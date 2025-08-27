<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'status',
    ];

    // Relacionamento: uma publicação pertence a um usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}