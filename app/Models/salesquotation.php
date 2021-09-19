<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salesquotation extends Model
{
  protected $fillable = ['slno','qtn_no','enq_id','qtn_ref','enq_ref','customer','authority','remarks','dates','total','discount_total','net_total','deli_info','currency','designation','attention','validity','from_enquiry','is_deleted','createdby','cmpid','finyear','wdate','paymentinfo'];


        public function salesquotationdetail()
{
 return $this->hasMany(salesquotationdetail::class,'qtn_id');
}
}
