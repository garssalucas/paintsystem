<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oryon extends Model
{
    protected $table = 'oryons';
    //quais colunas podem ser preenchidas:
    protected $fillable = ['codigo', 'descricao', 'preco', 'categoria', 'fornecedor', 'peso', 'preco_compra', 'estoque']; 
}