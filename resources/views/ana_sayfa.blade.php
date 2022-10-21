<x-layout title="ana_sayfa">
    @auth
        <h1>Merhaba {{ auth()->user()->email }}</h1>
        <a href="{{ route('uyelik.cikis') }}">Çıkış yap</a>
    @else
        <a href="{{ route('uyelik.uye_ol') }}">Üye ol</a>
    @endif
    {{-- Üye olmak için <a href="{{ route('uyelik.uye_ol') }}">tıklayın</a> --}}

{{--     <x-collapse id="deneme">
        <x-collapse.item id="deneme-accordion_item-1" show="true">test</x-collapse.item>
        <x-collapse.item id="deneme-accordion_item-2">test</x-collapse.item>
        <x-collapse.item id="deneme-accordion_item-3">test</x-collapse.item>
        <x-collapse.item id="deneme-accordion_item-4">test</x-collapse.item>
        <x-collapse.item id="deneme-accordion_item-5">test</x-collapse.item>
    </x-collapse> --}}
    <x-slot:js>
        <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
        <script>

          // Enable pusher logging - don't include this in production
          // Pusher.logToConsole = true;

          var pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
              cluster: '{{ config('broadcasting.connections.pusher.cluster') }}'
          });

          var channel = pusher.subscribe('mesaj-yayini');

          channel.bind('etkinlik.{{ auth()->user()->key }}', function(data) {
              document.querySelector('body').innerHTML = data.data.mesaj;
          })
        </script>
    </x-slot:js>
</x-layout>
