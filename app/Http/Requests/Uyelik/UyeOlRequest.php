<?php

namespace App\Http\Requests\Uyelik;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\TcKimlikDogrulamasiRule;

class UyeOlRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return config('options.user_register');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'isim' => 'required|string|max:100',
            'email' => 'required|email|max:200|unique:uyeler,email',
            'sifre' => 'required|string|min:6|max:100',
            'tc' => [ 'required', 'numeric', new TcKimlikDogrulamasiRule() ],
        ];
    }
}
