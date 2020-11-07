@component('mail::message')
# Introduction

Reset Password.

@component('mail::button', ['url' => $link])
{{ $link }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
