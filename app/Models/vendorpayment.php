<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vendorpayment extends Model
{
             protected $fillable = ['slno','pymt_no','vendor','advance','paymentmode','bank','dates','cheque_no','bank_name','roundoff','totaladvace','total','remarks','nettotal','totalamount','bank_date','erate','currency','is_deleted','createdby','cmpid','finyear','wdate'];


        public function vendorpaymentdetail()
{
 return $this->hasMany(vendorpaymentdetail::class,'payid');
}
}
