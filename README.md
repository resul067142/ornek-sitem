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

### Binance Laravel paketi

https://github.com/jaggedsoft/php-binance-api

### Dinamik option paketi

https://github.com/appstract/laravel-options

### Telegram paketi

https://github.com/laravel-notification-channels/telegram

### Telegram ile oturum aç butonu
 <script
                            async
                            src="https://telegram.org/js/telegram-widget.js?14"
                            data-telegram-login="medyaizibot"
                            data-size="large"
                            data-radius="3"
                            data-auth-url="https://callback-adresimiz"
                            data-request-access="write"></script>

### Ubuntu server için PHP yapılandırması ve Laravel ortam hazırlanması

// Sunucumuzun güncelleyelim.
$ sudo apt-get update
$ sudo apt-get upgrade

$ sudo apt install software-properties-common // yazılım kurmak için gerekebilir (bazen)

// Ondrej php paketini tanımlayalım.
$ sudo add-apt-repository ppa:ondrej/php
$ sudo apt-get -y update

// apache2, git, php 8, curl, postgresql, redis-server ve supervisor kurulumu
$ sudo apt-get -y install apache2 git php8 curl postgresql redis-server supervisor

// Sistem için gerekecek PHP alt kütüphanelerini kuralım ve apache için izin verelim.
$ sudo apt-get -y install php8-mbstring php8-curl php8-cli php8-gd php8-intl php8-tidy php8-xsl php8-zip php8-pgsql php8-bcmath php-redis

$ sudo a2enmod rewrite php8
$ sudo service apache2 restart

// PHP versiyon paketleyicisi olan Composer'ı kuralım.
$ curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer

### Yazılım Yapılandırmaları

## Redis

$ sudo nano /etc/redis/redis.conf

maxmemory 2048mb
maxmemory-policy allkeys-lru

$ sudo systemctl restart redis-server.service
$ sudo systemctl enable redis-server.service

// PostgreSQL
$ sudo -u postgres psql

postgres=# \password
postgres=# (New Password)
postgres=# (New Password Repeat)
postgres=# \q

$ sudo nano /etc/postgresql/10/main/postgresql.conf

max_connections = 5000

$ sudo nano /etc/postgresql/10/main/pg_hba.conf

host    all             all              0.0.0.0/0                       md5
host    all             all              ::/0                            md5

### Sistemin Kurulumu Öncesi Yapılandırma

$ git clone git@github.com:wutlu/ornek-sitem.git orneksitem.com
$ nano /etc/apache2/sites-available/medyaizi.com.conf
<VirtualHost *:80>
        ServerName app.medyaizi.com

        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/medyaizi.com/public

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>

$ sudo a2ensite medyaizi.com.conf

$ nano /etc/apache2/apache2.conf
<Directory /var/www/>
        Options Indexes FollowSymLinks
        AllowOverride all 
        Require all granted
</Directory>

$ sudo service apache2 reload
$ sudo swapoff -a
