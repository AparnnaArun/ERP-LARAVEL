<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stockissue extends Model
{
        protected $fillable = ['slno','issue_no','issue_date','issue_to','issue_for','is_deleted','createdby','cmpid','finyear','wdate','is_returned','total_amount'];


        public function stockissuedetail()
{
 return $this->hasMany(stockissuedetail::class,'stockissue_id');
}
}
