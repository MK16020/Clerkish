<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyJournal extends Model
{
    use HasFactory;

    protected $casts = [
        'number' => 'integer',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public function accounts()
    {
        return $this->hasMany(Account::class, 'accountID');
    }
}
