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