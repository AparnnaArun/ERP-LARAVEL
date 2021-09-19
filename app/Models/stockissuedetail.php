<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stockissuedetail extends Model
{
    protected $fillable = ['stockissue_id','item_id','item_code','item_name','unit','issue_qnty','rtn_qnty','pen_qnty','rate','stockissue_value','createdby','cmpid','finyear','wdate','batch'];
  public function stockissue()
{
 return $this->belongsTo(stockissue::class,'id');
}
}
