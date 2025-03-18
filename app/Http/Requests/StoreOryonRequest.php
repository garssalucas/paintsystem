<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOryonRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Autoriza todos os usuários, ajuste conforme necessário
    }

    public function rules()
    {
        return [
            'codigo' => 'required|unique:oryons',
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