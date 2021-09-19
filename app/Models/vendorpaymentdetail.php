<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vendorpaymentdetail extends Model
{
    protected $fillable = ['payid','purchaseid','vendor','invoiceno','dates','grandtotal','collected','debitednote','balance','amount','createdby','cmpid','finyear','wdate'];
}
