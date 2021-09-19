<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class expensesettlement extends Model
{
protected $fillable = ['slno','settle_no','paymentmode','bank','dates','cheque_no','bank_name','settle_type','remarks','nettotal','is_deleted','bank_date','createdby','finyear','wdate','cmpid'];


        public function expensesettlementdetail()
{
 return $this->hasMany(expensesettlementdetail::class,'sttlid');
}
}
