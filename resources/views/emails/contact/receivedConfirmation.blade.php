@component('mail::message')
# Hello {{ isset($contact) ? $contact['name'] : 'Guest'}}

Thank you to reaching out to us at B.A.R.F. Bento!
One of our customer support team will get back to you within the next business day.

If you you would like, you can reach out to us directly by phone.

Phone: 647-880-1136

@component('mail::button', ['url' => 'http://www.barfbento.com/packages'])
See Our Packages
@endcomponent

Thank you,<br>
{{ config('app.name') }}
@endcomponent
