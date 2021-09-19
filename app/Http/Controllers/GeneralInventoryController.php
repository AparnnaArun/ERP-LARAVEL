<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\deliverynote;
 use App\Models\projectmaterialrequest;
 use App\Models\salesinvoice;
 use App\Models\executivecommission;
 use App\Models\projectinvoice;
 use App\Models\projectexpenseentry;
class GeneralInventoryController extends Controller
{
     function landing(){
 if(session('id')!=""){
  ///////////////Layout Section Calculation Part/////////////////
  if(session('utype')=='Admin'){
$noti1 =deliverynote::where('is_invoiced','0')
 
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
    
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
         ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
  }else{
  $noti1 =deliverynote::where('is_invoiced','0')
  ->where('executive',session('exec'))
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
      ->where('executive',session('exec'))
      ->count();
      $notix = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
        ->where('executivecommissions.executive',session('exec'))
          ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->select(DB::raw('SUM(salesinvoices.balance) AS bal1'))
          ->first();
          $notiy = projectinvoice::where('executive',session('exec'))
          ->where('is_deleted','!=','1')
           ->select(DB::raw('SUM(bal_amount) AS bal2'))
          ->first();
           $noti3 =($notix->bal1 +$notiy->bal2);
         }
         $result = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
        ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->where('salesinvoices.finyear',session('fyear'))
          ->where('executivecommissions.executive',session('exec'))
         ->select(DB::raw('SUM((salesinvoices.grand_total) -(salesinvoices.sales_commission + salesinvoices.isslnrtn_amt)) AS sumamt'),DB::raw('MONTH(salesinvoices.dates) month'),DB::raw('SUM((salesinvoices.grand_total) -(salesinvoices.sales_commission + salesinvoices.isslnrtn_amt +salesinvoices.totcosts)) AS sumpsamt'),
          'executivecommissions.executive')
          ->groupBy('executivecommissions.executive','month')
          ->orderBy('executivecommissions.executive','asc')
          ->get();
     $result1 = DB::table('projectinvoices')
                ->select(DB::raw('sum(totalamount)as sumpamt'), DB::raw('MONTH(dates) month'))
                ->where('is_deleted','0')
                ->where('finyear',session('fyear'))
                ->where('executive',session('exec'))
                ->groupBy('month')
                ->get();
      $result2 = DB::table('projectexpenseentries')
                ->select(DB::raw('sum(totalamount)as sumepamt'), DB::raw('MONTH(dates) month'))
                ->where('is_deleted','0')
                ->where('finyear',session('fyear'))
                 ->where('executive',session('exec'))
                ->groupBy('month')
                ->get(); 
        $cmnth =date('m');
      $result3 = DB::table('projectinvoices')
                ->select(DB::raw('sum(totalamount)as sumcpamt'), DB::raw('MONTH(dates) month'))
                ->where('is_deleted','0')
                ->where('finyear',session('fyear'))
                 ->where('executive',session('exec'))
                ->whereMonth('dates',$cmnth)
                 ->groupBy('month')
                ->get();
                $result4 = DB::table('salesinvoices')
                ->select(DB::raw('sum(grand_total-(isslnrtn_amt+sales_commission))as sumcsamt'), DB::raw('MONTH(dates) month'))
                ->where('is_deleted','0')
                ->where('is_returned','!=','1')
                ->where('finyear',session('fyear'))
                ->whereMonth('dates',$cmnth)
                 ->groupBy('month')
                ->get();  
           ///////////////Layout Section Calculation Part End/////////////////
return view('inventory/masters/dashboard',['noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3,'result'=>$result,'result1'=>$result1,'result2'=>$result2,'result3'=>$result3,'result4'=>$result4]);
}
else{
 return redirect('/'); 
}

  }
  function layouy(){
   $noti1 =deliverynote::where('is_invoiced','0')
      ->where('is_dortn','!=','1')
      ->where('is_deleted','0')
       ->count();
      $noti2 = projectmaterialrequest::where('status','0')
      ->count(); 
      return view('inventory/layout',['noti1'=>$noti1,'noti2'=>$noti2]); 
  }
}
