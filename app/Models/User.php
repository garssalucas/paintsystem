<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;
    use HasRoles;
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

    // Atribuição de papéis quando o usuário for criado
    protected static function booted()
    {
        static::created(function ($user) {
            $user->assignRoleBasedOnArea();
        });

        static::updated(function ($user) {
            $user->assignRoleBasedOnArea();
        });
    }

    // Método para atribuir papéis baseado na área
    public function assignRoleBasedOnArea()
    {
        $this->syncRoles([]);
        // Exemplo de como você pode definir a área, isso pode ser alterado de acordo com sua lógica de negócios
        if ($this->area === 'administracao') {
            $this->assignRole('administradores');
        } elseif ($this->area === 'gerencia') {
            $this->assignRole('gerentes');
        } elseif ($this->area === 'laboratorio') {
            $this->assignRole('laboratorios');
        } elseif ($this->area === 'vendas') {
            $this->assignRole('vendedores');
        }
    }
}
