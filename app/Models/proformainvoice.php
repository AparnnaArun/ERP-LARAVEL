<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class proformainvoice extends Model
{
     protected $fillable = ['slno','pro_no','customer_ref','customer','authority','remarks','dates','total','discount_total','net_total','deli_info','currency','designation','paymentmode','from_enquiry','is_deleted','createdby','cmpid','finyear','wdate','paymentinfo'];


        public function proformainvoicedetail()
{
 return $this->hasMany(proformainvoicedetail::class,'pro_id');
}
}
