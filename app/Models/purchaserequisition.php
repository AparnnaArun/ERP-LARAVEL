<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchaserequisition extends Model
{
    protected $fillable = ['slno','req_no','dates','req_by','deliverydate','vendor','reqdept','remarks','projectcode','deliveryaddr','req_from','is_deleted','is_returned','createdby','finyear','wdate','cmpid','approvedby','approvalstatus','approveddate'];


        public function purchaserequisitiondetail()
{
 return $this->hasMany(purchaserequisitiondetail::class,'reqid');
}
}
