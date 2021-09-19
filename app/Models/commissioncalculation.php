<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class commissioncalculation extends Model
{
      protected $fillable = ['slno','enrty_no','dates','executive','total_income','total_expense','profit','commission_payable','commission_paid','balance','paycommission','createdby','cmpid','finyear','wdate','paymentmode','bankcash','chequeno','chequedate','is_deleted'];
 
}
