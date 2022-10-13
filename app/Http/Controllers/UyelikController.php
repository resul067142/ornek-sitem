<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\Uyelik\UyeOlRequest;

use App\Models\Uyeler;

use Auth;

class UyelikController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('uyeCikis');
    }

    public function uyeOl()
    {
        return view('uyelik.uye_ol');
    }

    public function uyeOlKayit(UyeOlRequest $request)
    {
        $tablo = new Uyeler;
        $tablo->fill($request->all());
        $tablo->password = bcrypt($request->sifre);
        $tablo->save();

        Auth::login($tablo);

        return redirect()->route('ana_sayfa');
    }

    public function uyeOlKayitApi(UyeOlRequest $request)
    {
        $tablo = new Uyeler;
        $tablo->fill($request->all());
        $tablo->password = bcrypt($request->sifre);
        $tablo->save();

        return response()
            ->json([
                'message' => 'İşlem tamam',
            ]);
    }

    public function uyelerApi()
    {
        // with yöntemi ile
        // $test = Uyeler::with('getKitap')->paginate(10);
        $test = Uyeler::with([ 'getKitaplar' ])->orderBy('id', 'asc')->get();

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
}
