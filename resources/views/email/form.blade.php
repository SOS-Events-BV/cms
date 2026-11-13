<x-mail::message>
# Nieuw formulier ingevuld

Er is een formulier ingevuld op de pagina <a href="{{ route('page', $slug) }}">/{{ $slug }}</a>
van de website <a href="{{ config('app.url') }}">{{ config('app.name') }}</a>. Hieronder vind je de ingevulde gegevens:

<x-mail::table>
| Veld | Waarde |
| ---- | ------ |
@foreach($formData as $field => $value)
| {{ Str::ucfirst(str_replace('_', ' ', $field)) }} | {{ $value ?? '-' }} |
@endforeach
</x-mail::table>

*Deze e-mail is automatisch verstuurd; je kunt hier niet op reageren.*
</x-mail::message>
