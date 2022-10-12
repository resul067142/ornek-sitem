@component('vendor.mail.html.layout')

@component('vendor.mail.html.panel')
Üyeliğinizi tamamlamak için lütfen aşağıdaki linke tıklayın.
@endcomponent

@component('vendor.mail.html.button', [ 'url' => "/dogrula/$kod" ])
test
@endcomponent

@endcomponent
