<x-layout title="giris_yap">



    <form method="post" action="{{ route('login.islem') }}" class="container my-5">
        @csrf

        <x-floating name="email" type="email" />
        <x-floating name="sifre" type="password" />

        <button type="submit" class="btn btn-outline-dark shadow-sm">Gönder</button>

        <a href="{{ route('uyelik.uye_ol') }}">Üye ol</a>
        <a href="{{ route('uyelik.github.baglan') }}">Github ile bağlan</a>
    </form>



</x-layout>
