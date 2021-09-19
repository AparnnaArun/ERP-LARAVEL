<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class projectmaterialissuedetail extends Model
{
   protected $fillable = ['issue_id','item_id','item_code','item','unit','issue_qnty','rtn_qnty','pen_qnty','rate','total','createdby','cmpid','finyear','wdate','matreqid','req_qnty','batch'];
     public function projectmaterialissue()
{
 return $this->belongsTo(projectmaterialissue::class,'id');
}
}
