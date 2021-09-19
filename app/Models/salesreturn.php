<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salesreturn extends Model
{
protected $fillable = ['slno','rtndate','rtn_no','location','salesid','customer_id','currency','executive','salesdate','payment_mode','discount_total','erate','total','totcosts','tax','freight','pf','insurance','others','roundoff','net_total','vehicle_details','deli_info','payment_terms','createdby','cmpid','finyear','wdate'];

public function salesreturndetail()
{
 return $this->hasMany(salesreturndetail::class,'rtn_id');
}
}
