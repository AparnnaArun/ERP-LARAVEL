<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class itemgroup extends Model
{
       protected $fillable = ['group','unit','itemtype','active','createdby','cmpid','finyear','wdate'];

}
