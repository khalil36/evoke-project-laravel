<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
        <img src="{{env('APP_URL')}}/img/logo.png" class="logo" alt="{{env('APP_NAME')}}">
@endif
</a>
</td>
</tr>

