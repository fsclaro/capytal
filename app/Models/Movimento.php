<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movimento extends Model
{
    use HasFactory;

    protected $table = 'movimentos';

    protected $fillable = [
        'user_id',
        'conta_id',
        'categoria_id',
        'tipo_documento_id',
        'descricao',
        'tipo_movimento',
        'dt_vencto',
        'vl_vencto',
        'dt_pagto',
        'vl_pagto',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'dt_vencto'  => 'datetime:d/m/Y',
            'dt_pagto'   => 'datetime:d/m/Y',
            'created_at' => 'datetime:d/m/Y H:i:s',
            'updated_at' => 'datetime:d/m/Y H:i:s',
            'deleted_at' => 'datetime:d/m/Y H:i:s'
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function conta(): BelongsTo
    {
        return $this->belongsTo(Conta::class);
    }

    public function tipo_documento(): BelongsTo
    {
        return $this->belongsTo(TipoDocumento::class);
    }
}
