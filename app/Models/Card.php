<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $table= "cc_card_tbl";

    protected $fillable = ['id','customerID','cardType','cardNumber','nameOnCard','CardExpireDate','status'];

    const CREATED_AT = null;
    const UPDATED_AT = null;
}
