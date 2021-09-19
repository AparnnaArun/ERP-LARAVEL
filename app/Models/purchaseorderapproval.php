<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchaseorderapproval extends Model
{
      protected $fillable = ['slno','po_no','odr_by','deli_date','vendor','reference','fob_point','order_validity','urgency_level','project_code','request_from','tot_qnty','tamount','currency','order_date','is_deleted','is_approved','createdby','finyear','wdate','cmpid','remarks','is_grned','discount_total','total','freight','pf','insurance','others','net_total','deliveryinfo','paymentterms','shipping','erate','apprpo_no'];


        public function purchaseorderapprovaldetail()
{
 return $this->hasMany(purchaseorderapprovaldetail::class,'reqid');
}
}
