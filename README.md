### Laravel local yayın yapma

$ php artisan serve --port=80

### Hosts dosyasında sanal bir domain oluşturma

- path: C:\Windows\System32\drivers\etc\hosts
- 127.0.0.1 orneksitem.com www.orneksitem.com

### Laravel için ön belleği temizleme

$ php artisan optimize

### Storage dosyasını public tarafında gösterme

$ php artisan storage:link

### Laravel sistemini bakıma alma (maintenance)

$ php artisan down/up

### Laravel log viewer

$ composer require rap2hpoutre/laravel-log-viewer

### Yeni controller oluşturma

$ php artisan make:controller AnaSayfaController

### Yeni middleware oluşturma

$ php artisan make:middleware AlanAdiMiddleware

#### Controller içerisinde middleware tanımlamma

- $this->middleware('alan_adi_middleware')->only([ 'altAnaSayfa', 'asdasaf' ]); // sadece bu methodlarda göster
- $this->middleware('alan_adi_middleware')->except([ 'altAnaSayfa', 'asdasaf' ]); // bu methodlar hariç göster

### Request oluşturma

$ php artisan make:request Uyelik/UyeOlRequest

