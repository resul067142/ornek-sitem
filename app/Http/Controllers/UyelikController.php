<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

use App\Jobs\EpostaKuyruguJob;
use App\Mail\UyelikDogrulamaKodu;

use Laravel\Socialite\Facades\Socialite;

use App\Http\Requests\Uyelik\UyeOlRequest;

use App\Models\Uyeler;
use App\Models\EpostaDogrulama;

use Auth;
use Image;

class UyelikController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('uyeCikis');
        $this->middleware('jwt.kontrol')->only([ 'uyelerApi', 'session', 'hesapSil' ]);
    }

    public static function tarihSaatYaz()
    {
        return date('H:i:s');
    }

    public function session()
    {
        $uye = request()->uye;
        $uye->updated_at = now();
        $uye->save();

        // Redis::set("uyeler:oturum:$uye->token", $uye->id, 'EX', 600);
    }

    public function uyeOl()
    {
        return view('uyelik.uye_ol');
    }

    public function uyeOlKayit(UyeOlRequest $request)
    {
        $uye = new Uyeler;
        $uye->fill($request->all());
        $uye->password = bcrypt($request->sifre);
        $uye->save();

        Auth::login($uye);

        return redirect()->route('ana_sayfa');
    }

    public function uyeOlKayitApi(UyeOlRequest $request)
    {
        $uye = new Uyeler;
        $uye->fill($request->all());
        $uye->password = bcrypt($request->sifre);
        $uye->token = Str::random(150);
        $uye->save();

        $kod = Str::random(100);

        $dogrula = new EpostaDogrulama;
        $dogrula->uyeler_id = $uye->id;
        $dogrula->token = $kod;
        $dogrula->save();

        dispatch(new EpostaKuyruguJob($uye, new UyelikDogrulamaKodu($kod)))
            ->onQueue('e-posta-trafigi');

        return response()
            ->json([
                'message' => 'İşlem tamam',
                'token' => $uye->token
            ]);
    }

    public function girisYapApi(Request $request)
    {
        $request['password'] = $request->sifre;
        $keys = $request->only('email', 'password');

        $islem = Auth::attempt($keys);

        if (!$islem)
        {
            echo 'ŞİFRENİZ HATALI';

            exit;
        }

        $tablo = Uyeler::where('email', $request->email)->first();
        $tablo->token = Str::random(150);
        $tablo->save();

        // print_r(geoip('46.1.12.52'));

        return response()
            ->json([
                'message' => 'İşlem tamam',
                'token' => $tablo->token
            ]);
    }

    public function uyelerApi()
    {
        // Artisan::call('islem:process x');

        // with yöntemi ile
        $test = Uyeler::with('getKitap')
            ->with('roles')
            ->with('permissions')
            ->withTrashed()
            ->limitliUye()
            ->orderBy('id', 'desc')
            ->paginate(10);
        // $test = Uyeler::with([ 'getKitaplar' ])->orderBy('id', 'asc')->get();

        // join yöntemi ile
        // $test = Uyeler::select('uyeler.isim as uye_adi', 'kitaplars.kitap_adi')
        //     ->leftJoin('kitaplars', function($join) {
        //         $join->on('uyeler.id', '=', 'kitaplars.uyeler_id')
        //             ->where('kitaplars.uyeler_id', '<', 10);
        //     })
        //     ->paginate(10);

        return response()->json($test);
    }

    public function uyeCikis(Request $request)
    {
        Auth::logout();

        // $request->session()->invalidate();
        // $request->session()->regenerateToken();

        return redirect()->route('ana_sayfa');
    }

    public function girisYap()
    {
        return view('uyelik.giris_yap');
    }

    public function girisYapIslem(Request $request)
    {
        $request['password'] = $request->sifre;
        $keys = $request->only('email', 'password');

        $islem = Auth::attempt($keys);

        if ($islem)
            return redirect()->route('ana_sayfa');
        else
            echo 'ŞİFRENİZ HATALI';
    }

    public function githubBaglan()
    {
        return Socialite::driver('github')->redirect();
    }

    public function githubGeriDonus()
    {
        $user = Socialite::driver('github')->user();

        print_r($user);
    }

    public function uyelikDogrula(string $kod)
    {
        $dogrulama = EpostaDogrulama::where('token', $kod)->firstOrFail();

        $uye = $dogrulama->getUye;
        $uye->e_posta_dogrulanma_zamani = now();
        $uye->save();

        $dogrulama->delete();

        // Auth::login($uye);

        return redirect()->route('ana_sayfa');
    }

    public function avatarYukle(Request $request)
    {
        $max_upload_size = config('options.max_upload_size');

        $request->validate(
            [
                'resim' => "required|image|mimes:jpg,jpeg,png,gif|max:$max_upload_size"
            ]
        );

        $img = Image::make($request->resim);
        $isim = 'test';

        Storage::disk('public')->put(
            'deneme.'.$request->resim->getClientOriginalExtension(),
            $img->response()
        );

        $user = request()->user;
        $user->avatar = storage_path('public/avatar.adi');
        $user->save();

        return 'ok';
    }

    public function hesapSil()
    {
        $uye = request()->uye;
        //
        //
        $uye->delete();
        // $uye->restore();
        // $uye->forceDelete();

        echo 'ok';
    }
}
