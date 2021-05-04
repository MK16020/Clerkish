<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountsJournal extends Model
{
    public function accounts()
    {
        return $this->hasMany(Account::class, 'accountID');
    }

    public function journals()
    {
        return $this->hasMany(DailyJournal::class, 'journalID');
    }
}
