<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class currentstock extends Model
{
   protected $fillable = ['location_id','item_id','batch','qnty_in','qnty_out','bal_qnty'];
}
