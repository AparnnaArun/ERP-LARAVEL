<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class indemnity extends Model
{
  protected $fillable = ['cases','status','rate','active','createdby','cmpid','finyear','wdate'];
}
