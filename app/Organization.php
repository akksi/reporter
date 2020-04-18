<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    public function transactions()
    {
        return $this->hasMany(UpworkTransaction::class);
    }
}
