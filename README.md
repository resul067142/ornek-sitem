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

### Request için Rule oluşturma

$ php artisan make:rule TcKimlikDogrulamasi

### Postman için örnek test scripti

	pm.test("Status code is 200", function () {
	    pm.response.to.have.status(200);

	    var obj = pm.response.json();

	    pm.collectionVariables.set("AUTHORIZATION", obj.key);
	});

## Migrations (Tablo oluşturma)

#### Yeni bir tablo migration'ı oluşturma

$ php artisan make:migration create_uyeler_table

#### Oluşturulan migrationları migrate etme

$ php artisan migrate
$ php artisan migrate:rollback --step=1 // 1 adım geri alma
$ php artisan migrate:fresh // db'deki alakalı alakasız tüm tabloları silip, yeniden oluşturur
$ php artisan migrate:refresh // tüm migration tablosundaki down methodlarını çalıştırır ve tekrar up methodlarını çalıştırır

### Yeni bir model oluşturma // birlikte migration oluşturma

$ php artisan make:model Uyeler -m

### Model fillable işlemi

Controller tarafı: $tablo->fill($request->all());
Model tarafı:
    protected $fillable = [
        'isim',
        'email',
        'tc',
    ];


### Seeder konusu

Seeder oluşturma: $ php artisan make:seeder UyelerTableSeeder
Seederları execute etme: $ php artisan db:seed
Sadece 1 seeder execute etme: $ php artisan db:seed --class=SeederClassAdı

### Factory oluşturma

$ php artisan make:factory KitaplarFactory

Faker örnekleri: https://github.com/fzaninotto/Faker

### Observer oluşturma

$ php artisan make:observer UyelerObserver --model=Uyeler

### POSTMAN değişken atama

	pm.test("Status code is 200", function () {
	    pm.response.to.have.status(200);

	    var obj = pm.response.json();

	    pm.collectionVariables.set("AUTHORIZATION", obj.key);
	});

### Job oluşturma

$ php artisan make:job EpostaKuyruguJob

### Resim düzenleme paketi

https://image.intervention.io/v2

### IP ile konum verileri paketi

https://lyften.com/projects/laravel-geoip/

### Rol sistemi

https://spatie.be/docs/laravel-permission/v5/basic-usage/new-app

### Komut dosyası oluşturma

$ php artisan make:command TarihiYaz

### Video toplama komutları

$ php artisan youtube:video:search --keyword=ankara // ankara kelimesini youtube'da arar ve videoları listeler
$ php artisan youtube:video:search --video_id=12345678901 // id numarası girilen video'a ait yorumları listeler.
$ php artisan youtube:video:search // Türkiye'deki youtube trendlerini listeler

https://github.com/alaouy/Youtube

### GuzzleHttp kurulum komutları (Stream için)

$ composer require guzzlehttp/guzzle
$ composer require guzzlehttp/oauth-subscriber

### Kuyruk işlemini redis'ten database yöntemine çekince tabloları migrate etmek

$ php artisan queue:table
$ php artisan queue:failed-table

### Event oluşturma

$ php artisan make:event MerhabaDunyaEvent
