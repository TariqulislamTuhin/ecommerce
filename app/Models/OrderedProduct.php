<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderedProduct extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function ammount()
    {
        return $this->belongsTo(BillingAmount::class, 'billing_amount_id');
    }
}
