@props(['sitekey' => config('cms.services.recaptcha.site_key'), 'action' => null])

<div>
    <div class="g-recaptcha" data-sitekey="{{ $sitekey }}"
        @if ($action) data-action="{{ strtoupper($action) }}" @endif></div>

    @if ($errors->has('g-recaptcha-response'))
        <span class="text-red-500 text-sm">
            {{ $errors->first('g-recaptcha-response') }}
        </span>
    @endif
</div>

@pushonce('head')
    <script src="https://www.google.com/recaptcha/enterprise.js"></script>
@endpushonce
