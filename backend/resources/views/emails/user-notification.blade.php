<x-mail::message>
## Hey {{$name}},

This email is to inform you that your vaccination date is {{$date}} at {{$center}}.
Please, bring your NID card.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
