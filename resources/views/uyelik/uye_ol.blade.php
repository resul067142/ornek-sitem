<x-layout title="uye_ol">



@if (config('options.user_register'))
    <form method="post" action="{{ route('uyelik.uye_ol.kayit') }}" class="container my-5">
        @csrf

        <x-floating name="isim" />
        <x-floating name="email" type="email" />
        <x-floating name="sifre" type="password" />
        <x-floating name="tc" type="number" />

        <button type="submit" class="btn btn-outline-dark shadow-sm">Gönder</button>
    </form>
@else
    <div class="alert alert-danger">Üyeliklerimiz şu an kapalıdır.</div>
@endif



</x-layout>
