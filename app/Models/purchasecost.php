<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchasecost extends Model
{
    protected $fillable = ['pi_no','dates','is_deleted','createdby','finyear','wdate','cmpid','paidstatus','slno','addno'];
     public function purchasecostdetail()
{
 return $this->hasMany(purchasecostdetail::class,'pcid');
}
}
