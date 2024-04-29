<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conta extends Model
{
    use HasFactory;

    protected $table = 'contas';

    protected $fillable = [
        'user_id',
        'descricao',
        'dominio',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:d/m/Y H:i:s',
            'updated_at' => 'datetime:d/m/Y H:i:s',
            'deleted_at' => 'datetime:d/m/Y H:i:s'
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function movimentos(): HasMany
    {
        return $this->hasMany(Movimento::class);
    }

}
