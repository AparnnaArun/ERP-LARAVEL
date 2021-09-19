<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class regularvoucherentrydetail extends Model
{
     protected $fillable = ['voucherid','debitcredit','account_name','narration','cheque_no','cheque_date','cheque_bank','cheque_clearance','amount','dates','createdby','cmpid','finyear','wdate','is_deleted'];
}
