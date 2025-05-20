<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;
    use HasRoles, HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'area',
        'atende_rua',
        'status',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return in_array($this->area, config('custom.admins'));
    }

    public function assignRoleByArea()
    {
        $roles = match ($this->area) {
            'administracao' => ['administradores', 'gerentes', 'vendedores', 'laboratorios'],
            'gerencia' => ['gerentes', 'vendedores', 'laboratorios'],
            'vendas' => ['vendedores'],
            'laboratorio' => ['laboratorios'],
            default => [],
        };
        //dd($this);
        // Remove roles antigos e adiciona os novos corretamente
        $this->load('roles')->syncRoles($roles);
    }

}
