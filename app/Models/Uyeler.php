<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Uyeler extends Authenticatable
{
    use HasFactory, SoftDeletes, HasRoles;

    protected $table = 'uyeler';

    protected $appends = [
        'tc_field',
        'tam_ad',
    ];

    protected $hidden = [
        'password',
    ];

    protected $fillable = [
        'isim',
        'email',
        'tc',
    ];

    protected $casts = [
        'isim' => 'string',
        'email' => 'string',
        'password' => 'string',
        'tc' => 'integer',
    ];

    /**
     * Get the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function tcField(): Attribute
    {
        return Attribute::make(
            get: fn () => Str::mask($this->tc, '*', 3),
        );
    }

    public function getKitap()
    {
        return $this->hasOne(Kitaplar::class, 'uyeler_id', 'id'); //->where('active', true);
    }

    public function getKitaplar()
    {
        return $this->hasMany(Kitaplar::class, 'uyeler_id', 'id')->skip(1)->take(1);
    }

    public function getTamAdAttribute()
    {
        return $this->isim.' '.$this->soyisim;
    }

    /**
     * $this->isim değerini alabilmemiz için, farklı bir mutatorsten çağırmalıydık.
     * kendi değerini almak için fn fonksiyonuna $value parametresi eklenmelidir.
     */
    protected function isim(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
        );
    }
}
