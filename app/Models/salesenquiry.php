<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salesenquiry extends Model
{
    protected $fillable = ['slno','enq_no','enq_ref','customer','authority','designation','remarks','dates','net_total','deli_info','createdby','cmpid','finyear','wdate','executive'];


        public function salesenquirydetails()
{
 return $this->hasMany(salesenquirydetail::class,'enq_id');
}


}
