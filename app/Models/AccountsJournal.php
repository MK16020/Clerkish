<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AccountsJournal extends Model
{
    use SoftDeletes;
    public function items()
    {
        return $this->hasMany(Item::class, 'itemID');
    }

    public function restores()
    {
        return $this->hasMany(Restore::class, 'restoreID');
    }
}
