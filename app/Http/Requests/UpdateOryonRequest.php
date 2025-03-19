<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOryonRequest extends StoreOryonRequest
{
    public function rules()
    {
        //herança de regras do StoreOryonRequest que podem ser personalizadas para Update
        $rules = parent::rules();
        return $rules;
    }
}