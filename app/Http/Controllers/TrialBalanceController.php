<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Carbon\Carbon;
use App\Models\account;
use App\Models\vouchergeneration;
use App\Models\regularvoucherentry;
use App\Models\regularvoucherentrydetail;

class TrialBalanceController extends Controller
{
   function gettrial(Request $req){

   if(session('id')!=""){
    $categories = account::leftJoin('regularvoucherentrydetails', function ($join)           {
                $join->on('regularvoucherentrydetails.account_name', '=' , 'accounts.id') ;
                $join->whereBetween('regularvoucherentrydetails.dates',['2021-08-01','2021-08-31']);
                $join->select(DB::raw('sum(regularvoucherentrydetails.amount) as sum'),'regularvoucherentrydetails.debitcredit');},
            function ($joins)          {
              
                $joins->where('regularvoucherentrydetails.dates','<','2021-08-01');
                $joins->select(DB::raw('sum(regularvoucherentrydetails.amount) as sums'),'regularvoucherentrydetails.debitcredit');
            })->select('accounts.id','accounts.name','accounts.seqnumber','accounts.accounttype')
      ->groupBy('accounts.id','accounts.name','accounts.seqnumber','regularvoucherentrydetails.debitcredit','accounts.accounttype')
      ->orderBy('accounts.fullcode','asc')
     ->get();
        
      
      return view('accounts/reports/trialbalance');
      }
else{
 return redirect('/erp'); 

   }
   }
   function loadtrialbal(Request $req){
    $dates=$req->startdate;
    $dates1=$req->enddate;
     $nddate = Carbon::parse($dates)->format('Y-m-d');
  $nddate1 = Carbon::parse($dates1)->format('Y-m-d');
 $categories = account::leftJoin('regularvoucherentrydetails', function ($join) 
                use($nddate,$nddate1)          {
                $join->on('regularvoucherentrydetails.account_name', '=' , 'accounts.id') ;
                $join->whereBetween('regularvoucherentrydetails.dates',[$nddate,$nddate1]);
               
                 },function ($joins) use($nddate)          {
                 $joins->on('regularvoucherentrydetails.account_name', '=' , 'accounts.id') ;
                 $joins->where('regularvoucherentrydetails.dates','<',$nddate);
              
            })->select('accounts.id','accounts.name','accounts.seqnumber','accounts.accounttype',DB::raw('sum(regularvoucherentrydetails.amount) as sum'),
                       'regularvoucherentrydetails.debitcredit',DB::raw('sum(regularvoucherentrydetails.amount) as sum'))
      ->groupBy('accounts.id','accounts.name','accounts.seqnumber','regularvoucherentrydetails.debitcredit','accounts.accounttype',)
      ->orderBy('accounts.fullcode','asc')
     ->get();
       
      return view('accounts/reports/loadtrialbalance',['categories'=>$categories,'dates'=>$dates,'dates1'=>$dates1]);
   }
}
