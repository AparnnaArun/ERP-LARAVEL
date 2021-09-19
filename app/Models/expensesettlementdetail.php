<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class expensesettlementdetail extends Model
{
     protected $fillable = ['sttlid','purchaseid','vendor','invoiceno','dates','grandtotal','collected','balance','amount','createdby','cmpid','finyear','wdate'];
}
