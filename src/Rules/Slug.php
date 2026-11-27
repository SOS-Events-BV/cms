<?php

namespace SOSEventsBV\Cms\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use SOSEventsBV\Cms\Models\Redirect;

class Slug implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Validate that the slug does not start with a slash
        if (str_starts_with($value, '/')) {
            $fail(__('cms::validation.slug.starts_with_slash'));
        }

        // Check if this slug has a redirect
        if (Redirect::where('from', $value)->exists()) {
            $fail(__('cms::validation.slug.has_redirect'));
        }
    }
}
