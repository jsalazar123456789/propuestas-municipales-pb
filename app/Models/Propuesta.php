<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Propuesta extends Model
{
    protected $fillable = ['numero', 'titulo', 'categoria_id', 'descripcion', 'observaciones', 'foto1', 'foto2', 'user_id', 'estado'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($propuesta) {
            $ultimo = static::latest('id')->first();
            $numero = $ultimo ? $ultimo->id + 1 : 1;
            $propuesta->numero = 'PROP-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
        });
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getEstadoBadgeAttribute()
    {
        $badges = [
            'pendiente' => '<span class="badge badge-warning"><i class="fas fa-clock"></i> Pendiente</span>',
            'aprobada' => '<span class="badge badge-success"><i class="fas fa-check"></i> Aprobada</span>',
            'rechazada' => '<span class="badge badge-danger"><i class="fas fa-times"></i> Rechazada</span>'
        ];
        return $badges[$this->estado] ?? $badges['pendiente'];
    }
}
