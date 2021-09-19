<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\executive;
use App\Models\crmform;
use App\Models\crmdetail;
use App\Models\deliverynote;
use App\Models\salesinvoice;
use App\Models\projectmaterialrequest;
use App\Models\projectinvoice;
use App\Models\executivecommission;
use PDF;
use Validator;
use Carbon\Carbon;


class InventoryCrmController extends Controller
{
function getcrmform(Request $req){

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
           ///////////////Layout Section Calculation Part End/////////////////
   $exe =executive::orderBy('short_name','asc')->get();
   if(session('utype')=="Admin"){
          $datas =crmform::with('crmdetail')
              ->orderBy('dates','asc')->get();
         }else{
      $datas =crmform::with('crmdetail')
              ->where('executive',session('exec'))->orderBy('dates','asc')->get();
                 } 
      return view('inventory/crm/crmform',['exe'=>$exe,'datas'=>$datas,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }
}
function createcrm(Request $req){
$validator =  $req ->validate([
                'dates'=>'required',
                'executive'=>'required',
                'customer'=>'required',
                'contactno'=>'required',
                'email'=>'required',
                 'followupdate'=>'required']);
    $dates=$req->input('dates');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
  $dates1=$req->input('followupdate');
  $nddate1 = Carbon::parse($dates1)->format('Y-m-d');
   $rtn = crmform::UpdateorCreate(['executive'=>$req->input('executive'),
    'customer'=>$req->input('customer'),],
  ['dates'=>$nddate,'followupdate'=>$nddate1,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'feedback'=>$req->input('feedback'),'status'=>$req->input('status')]);
   if($rtn){
        $contactperson=$req->contactperson;
        $contactno=$req->contactno;
        $email=$req->email;
        $count =count($contactperson);
for ($i=0; $i < $count; $i++){
  $bnd =crmdetail::updateOrCreate(
  ['contactperson'=>$contactperson[$i],
   'crmid'=>$rtn->id,],
  ['contactno'=>$contactno[$i],
    'email'=>$email[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
   }
   }
   $req->session()->flash('status', 'Data updated successfully!');
return redirect('/inventory/crm-entry');
}
function editcrmform(Request $req,$id){
       if(session('id')!=""){
   $exe =executive::orderBy('short_name','asc')->get();
 if(session('utype')=="Admin"){
          $datas =crmform::with('crmdetail')
              ->orderBy('dates','asc')->get();
         }else{
      $datas =crmform::with('crmdetail')
              ->where('executive',session('exec'))->orderBy('dates','asc')->get();
                 } 
   $crm =crmform::with('crmdetail')->find($id);
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
           ///////////////Layout Section Calculation Part End/////////////////
      return view('inventory/crm/crmformedit',['exe'=>$exe,'datas'=>$datas,'crm'=>$crm,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }


}
// function editscrm(Request $req){
// $validator =  $req ->validate([
//                 'dates'=>'required',
//                 'executive'=>'required',
//                 'customer'=>'required',
//                 'contactno'=>'required',
//                 'email'=>'required',
//                  'followupdate'=>'required']);
//     $dates=$req->input('dates');
//   $nddate = Carbon::parse($dates)->format('Y-m-d');
//   $dates1=$req->input('followupdate');
//   $nddate1 = Carbon::parse($dates1)->format('Y-m-d');
//    $rtn = crmform::where('id',$req->input('id'))
//    ->update(
//   ['dates'=>$nddate,
// 'executive'=>$req->input('executive'),'followupdate'=>$nddate1,'customer'=>$req->input('customer'),'contactperson'=>$req->input('contactperson'),'designation'=>$req->input('designation'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'contactno'=>$req->input('contactno'),'feedback'=>$req->input('feedback'),'email'=>$req->input('email')]);
//    $req->session()->flash('status', 'Data updated successfully!');
// return redirect()->back();
// }

}
