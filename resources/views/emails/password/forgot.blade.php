<h1>{{ config('app.name') }}</h1>

<p>A request has been made to reset your password.</p>

<p>Please click on this link below in order to reset your password:</p>

<a href="{{ config('app.client.web.urls.reset_password').$token }}">Reset Password</a> <br/><br/>

<p>If you can't click on that link, just copy and paste following url in your browser's address bar:</p>

<p>{{ config('app.client.web.urls.reset_password').$token }}</p>

<br/>
Many Thanks, <br/>
{{ config('app.name') }} team