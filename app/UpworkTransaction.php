<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UpworkTransaction extends Model
{
    protected $fillable = [
        'date',
        'reference_id',
        'type',
        'description',
        'agency',
        'freelancer',
        'team',
        'account_name',
        'po',
        'amount',
        'amount_in_local_currency',
        'currency',
        'balance',
    ];

    public function organization() {
        return $this->belongsTo(Organization::class);
    }

    public function entry() {
        return $this->belongsTo(Entry::class);
    }
}
