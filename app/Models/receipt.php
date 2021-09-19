<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class receipt extends Model
{
          protected $fillable = ['slno','rept_no','customer','advance','paymentmode','bank','dates','cheque_no','bank_name','roundoff','totaladvace','total','remarks','nettotal','totalamount','bank_date','is_deleted','createdby','cmpid','finyear','wdate'];


        public function receiptdetail()
{
 return $this->hasMany(receiptdetail::class,'rptid');
}
}
