<h1>{{ config('app.name') }}</h1>
<p>Thank you for registering on {{ config('app.name') }} application.</p>

<p>Please confirm your email by clicking on the link below:</p>

<a href="{{ config('app.client.web.urls.confirm_email').$confirmation_code }}">Confirm Email</a> <br/><br/>

<p>If you can't click on that link, just copy and paste following url in your browser's address bar:</p>

<p>{{ config('app.client.web.urls.confirm_email').$confirmation_code }}</p>

Many Thanks, <br/>
{{ config('app.name') }} team