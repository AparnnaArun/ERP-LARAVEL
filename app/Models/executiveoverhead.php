<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class executiveoverhead extends Model
{
    protected $fillable = ['slno','ovr_no','overhead_type','invoice_no','dates','executive','amount','paymentmode','bank','chequeno','is_deleted','wdate','createdby','finyear','cmpid'];
}
