<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guavira extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', 
        'latitude',
        'longitude',
        'imagem',
        'descricao',
        'cnpj'
    ];
    
    //GRAB THE OWNER (USER_ID) THAT CREATED THE GUAVIRA OBJECT AND DISPLAY IT ON THE MAPGUAV CARD;
    /**
     * Get the user that owns the guavira.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }
}
