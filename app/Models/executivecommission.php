<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class executivecommission extends Model
{
     protected $fillable = ['inv_id','invoice_no','customer','executive','percent','total_amount','net_total','profit','profitpay','totcost','paid_amount','from_where','is_deleted','wdate','createdby','finyear','cmpid','dates'];
}
