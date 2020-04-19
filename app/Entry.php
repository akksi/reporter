<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    protected $fillable = [
        'value',
        'date',
        'type',
    ];

    public function upworkTransactions() {
        return $this->hasMany(UpworkTransaction::class);
    }

    public function organization() {
        return $this->belongsTo(Organization::class);
    }
}
