<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOryonRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Autoriza todos os usuários, ajuste conforme necessário
    }

    public function rules()
    {
        return [
            'codigo' => [
                'required',
                'string',
                'max:20',
                Rule::unique('oryons', 'codigo')->ignore($this->route('id'))
            ],
            'descricao' => 'required|string|max:128',
            'preco' => 'required|numeric|min:0|max:99999999.99',
            'categoria' => 'required|string|max:64',
            'fornecedor' => 'required|string|max:64',
            'peso' => 'nullable|numeric|min:0|max:999999.99',
            'codigo_fornecedor' => 'nullable|string|max:64',
            'preco_compra' => 'nullable|numeric|min:0|max:99999999.99',
            'estoque' => 'nullable|numeric|min:0|max:99999999.99',
        ];
    }
}