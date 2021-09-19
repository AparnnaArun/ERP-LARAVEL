<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class receiptdetail extends Model
{
    protected $fillable = ['rptid','salesid','invoiceno','dates','grandtotal','collected','creditnote','balance','amount','createdby','cmpid','finyear','wdate'];
}
