<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    public function upworkTransactions()
    {
        return $this->hasMany(UpworkTransaction::class);
    }
}
