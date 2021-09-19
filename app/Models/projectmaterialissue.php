<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class projectmaterialissue extends Model
{
protected $fillable = ['slno','issue_no','project_id','requisitionid','issue_from','dates','executive','customer','customerpo','createdby','cmpid','finyear','wdate','is_returned','total_amount','commission_percentage','comm_pay_account','exe_com_exp_ac','customer_id'];


        public function projectmaterialissuedetail()
{
 return $this->hasMany(projectmaterialissuedetail::class,'issue_id');
}
}
