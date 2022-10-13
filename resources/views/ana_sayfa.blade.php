<x-layout title="ana_sayfa">
    @auth
        <h1>Merhaba {{ auth()->user()->isim . ' ' . auth()->user()->soyisim }}</h1>
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
</x-layout>
