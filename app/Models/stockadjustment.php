<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stockadjustment extends Model
{
        protected $fillable = ['slno','voucher_no','dates','location','voucher_type','is_deleted','createdby','cmpid','finyear','wdate','is_returned','total_amount','remarks'];


        public function stockadjustmentdetail()
{
 return $this->hasMany(stockadjustmentdetail::class,'stockid');
}
}
