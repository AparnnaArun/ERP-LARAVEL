<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class requestforquotation extends Model
{
        protected $fillable = ['slno','req_no','dates','req_by','deliverydate','vendor','reqdept','remarks','projectcode','currency','req_from','is_deleted','is_returned','createdby','finyear','wdate','cmpid','deliveryinfo','paymentterms','notes'];


        public function requestforquotationdetail()
{
 return $this->hasMany(requestforquotationdetail::class,'reqid');
}
}
