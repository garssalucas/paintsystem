<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Oryon extends Model
{
    //use SoftDeletes;
    protected $table = 'oryons';
    //quais colunas podem ser preenchidas:
    protected $fillable = ['codigo', 'descricao', 'preco', 'categoria', 'fornecedor', 'peso', 'preco_compra', 'estoque']; 
}