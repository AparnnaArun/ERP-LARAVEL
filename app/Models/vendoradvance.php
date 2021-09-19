<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vendoradvance extends Model
{
       protected $fillable = ['advance','adv_taken','bal_advnce','vendor','dates','paymentmode','bankcash','chequeno','chequedate','from_where','remarks','is_deleted','createdby','finyear','wdate','cmpid','erate','currency','slno','advanceno'];
}
