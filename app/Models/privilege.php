<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class privilege extends Model
{
protected $fillable = ['pageid','module','user','privilege','fromwhere','createdby','wdate','finyear','cmpid'];
}
