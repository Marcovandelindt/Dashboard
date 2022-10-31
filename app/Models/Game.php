<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    /**
     * Get the name of a game
     * 
     * @return string
     */
    public function getName(): string 
    {
        return $this->name;
    }
}
