<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class projectmaterialrequest extends Model
{
       protected $fillable = ['slno','matreq_no','project_id','req_by','req_date','purpose','delivery_date','status','net_total','createdby','cmpid','finyear','wdate','executive','customerpo','customer','customer_id'];


        public function projectmaterialrequestdetail()
{
 return $this->hasMany(projectmaterialrequestdetail::class,'matreq_id');
}
}
