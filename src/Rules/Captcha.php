<?php

namespace SOSEventsBV\Cms\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Translation\PotentiallyTranslatedString;

class Captcha implements ValidationRule
{
    /**
     * @param string $expectedAction The action expected by the captcha
     * @param float|null $threshold The minimum score required for the captcha to be considered valid (optional)
     */
    public function __construct(
        private string $expectedAction,
        private ?float $threshold = null,
    ) {
        $this->threshold ??= (float) config('cms.services.recaptcha.threshold', 0.5);
    }

    /**
     * Run the validation rule.
     *
     * @param Closure(string, ?string=): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $config = config('cms.services.recaptcha');

        try {
            $assessment = Http::withQueryParameters(['key' => $config['api_key']])
                ->post("https://recaptchaenterprise.googleapis.com/v1/projects/{$config['project_id']}/assessments", [
                    'event' => [
                        'token' => $value,
                        'expectedAction' => $this->expectedAction,
                        'siteKey' => $config['site_key'],
                    ],
                ])
                ->throw()
                ->collect();
        } catch (ConnectionException | RequestException $e) {
            report($e);
            $fail(__('cms::validation.captcha.error'));
            return;
        }

        $valid = data_get($assessment, 'tokenProperties.valid', false);
        $action = data_get($assessment, 'tokenProperties.action');
        $score = data_get($assessment, 'riskAnalysis.score', 0.0);

        if (!$valid || $action !== $this->expectedAction || $score < $this->threshold) {
            $fail(__('cms::validation.captcha.failed'));
        }
    }
}
