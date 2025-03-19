<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOryonRequest extends StoreOryonRequest
{
    public function rules()
    {
        $rules = parent::rules();
        return $rules;
    }
}