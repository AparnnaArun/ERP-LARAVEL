<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vouchergeneration extends Model
{
    use HasFactory;
     protected $fillable = ['voucherid','constants','slno','genvouch','createdby','wdate','finyear','cmpid'];
}
