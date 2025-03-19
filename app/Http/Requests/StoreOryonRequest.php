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
                Rule::unique('oryons', 'codigo')->ignore($this->route('id'))
            ],
            'descricao' => 'required',
            'preco' => 'required|numeric',
            'categoria' => 'required',
            'fornecedor' => 'required',
            'peso' => 'nullable|numeric',
            'preco_compra' => 'required|numeric',
            'estoque' => 'required|numeric',
        ];
    }
}