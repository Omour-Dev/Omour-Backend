@component('mail::message')

<h2>
    <center> {{ __('order::api.orders.celebrities.mail.header') }} </center>
</h2>
<h4>
    <center> # {{ $order['id'] }} </center>
</h4>

@component('mail::table')
| {{ __('order::api.orders.celebrities.mail.total') }} | {{ $order['total'] }} |
| :--: |:----: |
| {{ __('order::api.orders.celebrities.mail.from') }} | {{ ($order->is_gift) ? $order->from : '' }} |
| {{ __('order::api.orders.celebrities.mail.to') }} | {{ $order['to'] }} |
| {{ __('order::api.orders.celebrities.mail.is_gift') }} | {{ ($order->is_gift) ?  __('order::api.orders.celebrities.mail.is_gift') : __('order::api.orders.celebrities.mail.is_not_gift') }} |
| {{ __('order::api.orders.celebrities.mail.is_hidden') }} | {{ ($order->is_hidden) ?  __('order::api.orders.celebrities.mail.is_hidden') : __('order::api.orders.celebrities.mail.is_not_hidden') }} |
| {{ __('order::api.orders.celebrities.mail.instructions') }} | {{ $order['instructions'] }} |
| {{ __('order::api.orders.celebrities.mail.email') }} | {{ $order['email'] }} |
| {{ __('order::api.orders.celebrities.mail.mobile') }} | {{ $order['mobile'] }} |
| {{ __('order::api.orders.celebrities.mail.occasion') }} | {{ucfirst($order->occasion->translate(locale())->title)}}|
@endcomponent

@endcomponent
