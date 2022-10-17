@component('vendor.mail.html.layout')

@component('vendor.mail.html.panel')
Üyeliğinizi tamamlamak için lütfen aşağıdaki linke tıklayın.
@endcomponent

@component('vendor.mail.html.button', [ 'url' => route('uyelik.uye_ol.dogrula', [ 'kod' => $kod ]) ])
test
@endcomponent

@endcomponent
