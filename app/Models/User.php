<?php

namespace App\Models;

use App\Models\Util\Senha;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'cpf',
        'setor',
        'cargo',
        'administrativo',
        'solicitar_adiantamento',
        'autorizar_adiantamento',
        'enviar_adiantamento',
        'operacao',
        'monitoramento',
        'cadastro',
        'master'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Define um mutator para o campo cpf, removendo caracteres não numéricos antes de salvar.
     *
     * @param  string  $value
     * @return void
     */
    public function setCpfAttribute($value)
    {
        $this->attributes['cpf'] = preg_replace("/[^0-9]/", "", $value);
    }

    /**
     * Define um accessor para o campo cpf, formatando-o como um número de CPF padrão brasileiro.
     *
     * @param  string  $value
     * @return string
     */
    public function getCpfAttribute($value)
    {
        // Adapte a lógica conforme necessário para o seu formato desejado
        return substr($value, 0, 3) . '.' . substr($value, 3, 3) . '.' . substr($value, 6, 3) . '-' . substr($value, 9, 2);
    }

    public function senha()
    {
        return $this->hasMany(Senha::class, 'id_user', 'id');
    }
}
