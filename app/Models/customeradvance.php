<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customeradvance extends Model
{
   protected $fillable = ['slno','advanceno','advance','adv_out','bal_advnce','customer','dates','paymentmode','bankcash','chequeno','chequedate','from_where','remarks','is_deleted','createdby','finyear','wdate','cmpid'];
}
