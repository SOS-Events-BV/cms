<form action="{{ $postRoute }}" method="POST" class="not-prose my-8 flex flex-col gap-5 items-start" id="form">
    @csrf
    @honeypot {{-- Prevent spam --}}

    @foreach ($formInputs as $input)
        @switch($input->type)
            @case('text_input')
                <x-cms::form.input name="{{ Str::slug($input->data->label, '_') }}" :label="$input->data->label"
                    placeholder="{{ $input->data->placeholder ?? '' }}" :required="$input->data->required" />
            @break

            @case('email_input')
                <x-cms::form.input type="email" name="{{ Str::slug($input->data->label, '_') }}" :label="$input->data->label"
                    placeholder="{{ $input->data->placeholder ?? '' }}" :required="$input->data->required" />
            @break

            @case('phone_input')
                <x-cms::form.input type="tel" name="{{ Str::slug($input->data->label, '_') }}" :label="$input->data->label"
                    placeholder="{{ $input->data->placeholder ?? '' }}" :required="$input->data->required" />
            @break

            @case('number_input')
                <x-cms::form.input type="number" name="{{ Str::slug($input->data->label, '_') }}" :label="$input->data->label"
                    placeholder="{{ $input->data->placeholder ?? '' }}" :required="$input->data->required" :min="$input->data->min ?? null" :max="$input->data->max ?? null" />
            @break

            @case('textarea')
                <x-cms::form.textarea name="{{ Str::slug($input->data->label, '_') }}" :label="$input->data->label"
                    placeholder="{{ $input->data->placeholder ?? '' }}" :required="$input->data->required" />
            @break

            @case('select')
                <x-cms::form.select name="{{ Str::slug($input->data->label, '_') }}" :label="$input->data->label" :options="$input->data->options"
                    :required="$input->data->required" />
            @break

            @case('radio')
                <x-cms::form.radio name="{{ Str::slug($input->data->label, '_') }}" :label="$input->data->label" :options="$input->data->options"
                    :required="$input->data->required" />
            @break

            @case('checkbox')
                <x-cms::form.checkbox name="{{ Str::slug($input->data->label, '_') }}" :label="$input->data->label" :required="$input->data->required" />
            @break

            @case('date_input')
                <x-cms::form.input type="date" name="{{ Str::slug($input->data->label, '_') }}" :label="$input->data->label"
                    :required="$input->data->required" />
            @break
        @endswitch
    @endforeach

    <x-cms::form.recaptcha action="PAGEFORM" />

    <button type="submit" class="btn btn-blue">
        Verzenden
    </button>
</form>
