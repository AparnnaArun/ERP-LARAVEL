<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salesorder extends Model
{
     protected $fillable = ['slno','order_no','reference','customer','fob_point','ship_to','dates','purodr_date','currency','order_from','total','discount_total','net_total','erate','tax','freight','insurance','others','pf','deli_info','payment_terms','dispatch_details','remarks','approved_by','is_deleted','createdby','cmpid','finyear','wdate','call_for_do'];


        public function salesorderdetail()
{
 return $this->hasMany(salesorderdetail::class,'order_id');
}

}
