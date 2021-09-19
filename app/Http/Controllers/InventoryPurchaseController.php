<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\vendor;
use App\Models\deliverynote;
use App\Models\salesinvoice;
use App\Models\projectmaterialrequest;
use App\Models\projectinvoice;
use App\Models\executivecommission;
use App\Models\User;
use App\Models\executive;
use App\Models\itemmaster;
use App\Models\unit;
use App\Models\businesstype;
use App\Models\privilege;
use App\Models\vouchergeneration;
use App\Models\purchaserequisition;
use App\Models\purchaserequisitiondetail;
use App\Models\projectdetail;
use App\Models\requestforquotation;
use App\Models\requestforquotationdetail;
use App\Models\purchaseorderdetail;
use App\Models\purchaseorder;
use App\Models\purchaseorderapprovaldetail;
use App\Models\purchaseorderapproval;
use App\Models\store;
use App\Models\currency;
use App\Models\header;
use App\Models\goodsreceivednotedetail;
use App\Models\goodsreceivednote;
use App\Models\stockmovement;
use App\Models\currentstock;
use App\Models\purchaseinvoicedetail;
use App\Models\purchaseinvoice;
use App\Models\regularvoucherentry;
use App\Models\regularvoucherentrydetail;
use App\Models\purchasecost;
use App\Models\purchasecostdetail;
use App\Models\costcalculationdetail;
use App\Models\costcalculation;
use App\Models\purchasereturndetail;
use App\Models\purchasereturn;
use Illuminate\Support\Facades\Hash;
use PDF;
use Validator;
use Carbon\Carbon;

class InventoryPurchaseController extends Controller
{
    function getrequisition(){
    	$priv=privilege::select('pageid','user')
           ->where('pageid','38')
           ->where('user',session('id'))
           ->count();
            if(session('id')!="" && ($priv >0)){
                 //////// For Popups/////////////
                $units = unit::where('active','1')
                        ->select('shortname')
                        ->orderBy('shortname','Asc')
                        ->get();
                $sllo = itemmaster::select('localslno')
                        ->wherenotNull('localslno')
                        ->where('localslno','!=','0')
                        ->orderBy('id','Desc')
                        ->take(1)->first();
              $nlslno =$sllo->localslno + 1;
              $nllslno ='LI'.$nlslno;
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();
             
               ///////////////////////////////////////////////////
        $voucher  = vouchergeneration::where('voucherid','38')
              ->select('slno','constants')->first();  
              if(!empty($voucher->slno)){
  $slno=purchaserequisition::select('slno')
                       ->where('slno',$voucher->slno)
                       ->count();
                       if($slno >0){
                   $slno1=purchaserequisition::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')->first();     
                       
  $nslno = $slno1->slno +1;
}
else{
  $nslno=$voucher->slno;
}
}else{
 $nslno=1;   
}
 $pros =projectdetail::where('is_completed','!=','1')
        ->where('is_deleted','!=','1') 
      ->get();
$datas =    purchaserequisition::leftJoin('vendors', function($join) {
      $join->on('purchaserequisitions.vendor', '=', 'vendors.id');
         })->select('purchaserequisitions.id','purchaserequisitions.req_no','purchaserequisitions.req_by','vendors.vendor')
->orderBy('purchaserequisitions.id','desc')
          ->get();
$item=itemmaster::orderBy('item','asc')->get();
$vendor =vendor::orderBy('short_name','asc')->get();




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
return view('inventory/purchase/purchaserequisition',['btypes'=>$btypes,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'units'=>$units,'vendor'=>$vendor,'item'=>$item,'nslno'=>$nslno,'voucher'=>$voucher,'pros'=>$pros,'datas'=>$datas,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
else{
 return redirect('/'); 
}
    }
    function itemsrequisition(Request $req){
 $rowCount = $req->rowCount;
   $itemid = $req->itemid;
   $item = itemmaster::find($itemid);
  
  
return view('inventory/purchase/itemsgridreqview',['item'=>$item,'rowCount'=>$rowCount]);

    }
    function createrequisition(Request $req){
 $validator =  $req ->validate([
                'req_no'=>'required',
                'vendor'=>'required',
                'item_id'=>'required',
                'reqqnty'=>'required'],
   [ 'req_no.required'    => 'Sorry,Please generate an enquiry number, Thank You.',
       'item_id.required'  => 'Sorry, Minimum one item is needed to save this task, 
                                     Thank You.',             
       'vendor.required'  => 'Sorry,Please select a vendor, Thank You.',
       'reqqnty.required'   => 'Sorry,Quantity is required, Thank You.'
        ]);
  $dates=$req->input('dates');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
$enquiry = purchaserequisition::updateOrCreate(
  ['req_no'=>$req->input('req_no')],
['slno'=>$req->input('slno'),'dates'=>$nddate,'req_by'=>$req->input('req_by'),'vendor'=>$req->input('vendor'),'reqdept'=>$req->input('reqdept'),'projectcode'=>$req->input('projectcode'),'deliveryaddr'=>$req->input('deliveryaddr'),'req_from'=>$req->input('req_from'),'remarks'=>$req->input('remarks'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
  if(isset($enquiry)){
      $item_id=$req->item_id;
      $code = $req->item_code;
        $item_name=$req->item_name;
        $unit=$req->unit;
        $quantity=$req->reqqnty;
        $rate=$req->rate;
        $total=$req->total;
        $count =count($item_id);
for ($i=0; $i < $count; $i++){
  $bnd =purchaserequisitiondetail::updateOrCreate(['item_id'=>$item_id[$i],
    'reqid'=>$enquiry->id,],
  ['item_code'=>$code[$i],
  'item_name'=>$item_name[$i],
  'unit'=>$unit[$i],
  'reqqnty'=>$quantity[$i],
  'apprqnty'=>$quantity[$i],
  'rate'=>$rate[$i],
  'total'=>$total[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
   }
$req->session()->flash('status', 'Data updated successfully!');
return redirect('/inventory/purchase-requisition');
    }
}
function editrequisition($id,Request $req){
$priv=privilege::select('pageid','user')
           ->where('pageid','38')
           ->where('user',session('id'))
           ->count();
            if(session('id')!="" && ($priv >0)){
                 //////// For Popups/////////////
                $units = unit::where('active','1')
                        ->select('shortname')
                        ->orderBy('shortname','Asc')
                        ->get();
                $sllo = itemmaster::select('localslno')
                        ->wherenotNull('localslno')
                        ->where('localslno','!=','0')
                        ->orderBy('id','Desc')
                        ->take(1)->first();
              $nlslno =$sllo->localslno + 1;
              $nllslno ='LI'.$nlslno;
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();
                              $voucher  = vouchergeneration::where('voucherid','38')
              ->select('slno','constants')->first();  
              if(!empty($voucher->slno)){
  $slno=purchaserequisition::select('slno')
                       ->where('slno',$voucher->slno)
                       ->count();
                       if($slno >0){
                   $slno1=purchaserequisition::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')->first();
                         $nslno = $slno1->slno +1;
}
else{
  $nslno=$voucher->slno;
}
}else{
 $nslno=1;   
}
 $pros =projectdetail::where('is_completed','!=','1')
        ->where('is_deleted','!=','1') 
      ->get();
$datas =    purchaserequisition::leftJoin('vendors', function($join) {
      $join->on('purchaserequisitions.vendor', '=', 'vendors.id');
         })->select('purchaserequisitions.id','purchaserequisitions.req_no','purchaserequisitions.req_by','vendors.vendor')
->orderBy('purchaserequisitions.id','desc')
          ->get();
$item=itemmaster::orderBy('item','asc')->get();
$vendor =vendor::orderBy('short_name','asc')->get();




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
$reequsi =purchaserequisition::with('purchaserequisitiondetail')->find($id);
return view('inventory/purchase/purchaserequisitionedit',['btypes'=>$btypes,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'units'=>$units,'vendor'=>$vendor,'item'=>$item,'nslno'=>$nslno,'voucher'=>$voucher,'pros'=>$pros,'datas'=>$datas,'reequsi'=>$reequsi,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
else{
 return redirect('/'); 
} 
}
function reqapproval(Request $req){
$priv=privilege::select('pageid','user')
           ->where('pageid','38')
           ->where('user',session('id'))
           ->count();
            if(session('id')!="" && ($priv >0)){
                 //////// For Popups/////////////
                $units = unit::where('active','1')
                        ->select('shortname')
                        ->orderBy('shortname','Asc')
                        ->get();
                $sllo = itemmaster::select('localslno')
                        ->wherenotNull('localslno')
                        ->where('localslno','!=','0')
                        ->orderBy('id','Desc')
                        ->take(1)->first();
              $nlslno =$sllo->localslno + 1;
              $nllslno ='LI'.$nlslno;
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();
                              $voucher  = vouchergeneration::where('voucherid','38')
              ->select('slno','constants')->first();  
              if(!empty($voucher->slno)){
  $slno=purchaserequisition::select('slno')
                       ->where('slno',$voucher->slno)
                       ->count();
                       if($slno >0){
                   $slno1=purchaserequisition::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')->first();
                         $nslno = $slno1->slno +1;
}
else{
  $nslno=$voucher->slno;
}
}else{
 $nslno=1;   
}
 $pros =projectdetail::where('is_completed','!=','1')
        ->where('is_deleted','!=','1') 
      ->get();
$datas =    purchaserequisition::leftJoin('vendors', function($join) {
      $join->on('purchaserequisitions.vendor', '=', 'vendors.id');
         })->select('purchaserequisitions.id','purchaserequisitions.req_no','purchaserequisitions.req_by','vendors.vendor')
->where('purchaserequisitions.approvalstatus','1')
->orderBy('purchaserequisitions.id','desc')
          ->get();
          $datass =purchaserequisition::leftJoin('vendors', function($join) {
      $join->on('purchaserequisitions.vendor', '=', 'vendors.id');
         })->select('purchaserequisitions.id','purchaserequisitions.req_no','purchaserequisitions.req_by','vendors.vendor')
          ->where('purchaserequisitions.approvalstatus','0')
->orderBy('purchaserequisitions.id','desc')
          ->get();
$item=itemmaster::orderBy('item','asc')->get();
$vendor =vendor::orderBy('short_name','asc')->get();




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
return view('inventory/purchase/purchaserequisitionapproval',['btypes'=>$btypes,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'units'=>$units,'vendor'=>$vendor,'item'=>$item,'nslno'=>$nslno,'voucher'=>$voucher,'pros'=>$pros,'datas'=>$datas,'datass'=>$datass,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
else{
 return redirect('/'); 
}    
}
function requisitionappr($id,Request $req){
    $priv=privilege::select('pageid','user')
           ->where('pageid','38')
           ->where('user',session('id'))
           ->count();
            if(session('id')!="" && ($priv >0)){
                 //////// For Popups/////////////
                $units = unit::where('active','1')
                        ->select('shortname')
                        ->orderBy('shortname','Asc')
                        ->get();
                $sllo = itemmaster::select('localslno')
                        ->wherenotNull('localslno')
                        ->where('localslno','!=','0')
                        ->orderBy('id','Desc')
                        ->take(1)->first();
              $nlslno =$sllo->localslno + 1;
              $nllslno ='LI'.$nlslno;
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();
                              $voucher  = vouchergeneration::where('voucherid','38')
              ->select('slno','constants')->first();  
              if(!empty($voucher->slno)){
  $slno=purchaserequisition::select('slno')
                       ->where('slno',$voucher->slno)
                       ->count();
                       if($slno >0){
                   $slno1=purchaserequisition::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')->first();
                         $nslno = $slno1->slno +1;
}
else{
  $nslno=$voucher->slno;
}
}else{
 $nslno=1;   
}
 $pros =projectdetail::where('is_completed','!=','1')
        ->where('is_deleted','!=','1') 
      ->get();
$datas =    purchaserequisition::leftJoin('vendors', function($join) {
      $join->on('purchaserequisitions.vendor', '=', 'vendors.id');
         })->select('purchaserequisitions.id','purchaserequisitions.req_no','purchaserequisitions.req_by','vendors.vendor')
->where('purchaserequisitions.approvalstatus','1')
->orderBy('purchaserequisitions.id','desc')
          ->get();
$item=itemmaster::orderBy('item','asc')->get();
$vendor =vendor::orderBy('short_name','asc')->get();




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
$reequsi =purchaserequisition::with('purchaserequisitiondetail')->find($id);
return view('inventory/purchase/purchaserequisitionaprroves',['btypes'=>$btypes,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'units'=>$units,'vendor'=>$vendor,'item'=>$item,'nslno'=>$nslno,'voucher'=>$voucher,'pros'=>$pros,'datas'=>$datas,'reequsi'=>$reequsi,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
else{
 return redirect('/'); 
} 
}
function createreqapprov(Request $req){
     $dates=$req->input('dates');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
$enquiry = purchaserequisition::where('id',$req->input('idd'))->update(
  ['req_no'=>$req->input('req_no'),
'dates'=>$nddate,'req_by'=>$req->input('req_by'),'vendor'=>$req->input('vendor'),'reqdept'=>$req->input('reqdept'),'projectcode'=>$req->input('projectcode'),'deliveryaddr'=>$req->input('deliveryaddr'),'req_from'=>$req->input('req_from'),'remarks'=>$req->input('remarks'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'approvalstatus'=>'1']);
  if(isset($enquiry)){
    $id1=$req->id1;
      
        $apprqnty=$req->apprqnty;
     
        $count =count($id1);
for ($i=0; $i < $count; $i++){
  $bnd =purchaserequisitiondetail::where('id',$id1[$i])->update(
  [
  'apprqnty'=>$apprqnty[$i],
 
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
   }
$req->session()->flash('status', 'Data updated successfully!');
return redirect()->back();
    }
}
function getrfq(Request $req){
$priv=privilege::select('pageid','user')
           ->where('pageid','48')
           ->where('user',session('id'))
           ->count();
            if(session('id')!="" && ($priv >0)){
                 //////// For Popups/////////////
                $units = unit::where('active','1')
                        ->select('shortname')
                        ->orderBy('shortname','Asc')
                        ->get();
                $sllo = itemmaster::select('localslno')
                        ->wherenotNull('localslno')
                        ->where('localslno','!=','0')
                        ->orderBy('id','Desc')
                        ->take(1)->first();
              $nlslno =$sllo->localslno + 1;
              $nllslno ='LI'.$nlslno;
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();
                              $voucher  = vouchergeneration::where('voucherid','48')
              ->select('slno','constants')->first();  
              if(!empty($voucher->slno)){
  $slno=requestforquotation::select('slno')
                       ->where('slno',$voucher->slno)
                       ->count();
                       if($slno >0){
                   $slno1=requestforquotation::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')->first();
                         $nslno = $slno1->slno +1;
}
else{
  $nslno=$voucher->slno;
}
}else{
 $nslno=1;   
}
 $pros =projectdetail::where('is_completed','!=','1')
        ->where('is_deleted','!=','1') 
      ->get();
       $curr =currency::orderBy('shortname','asc') 
      ->get();
$datas =    requestforquotation::leftJoin('vendors', function($join) {
      $join->on('requestforquotations.vendor', '=', 'vendors.id');
         })->select('requestforquotations.id','requestforquotations.req_no','requestforquotations.req_by','vendors.vendor')
->orderBy('requestforquotations.id','desc')
          ->get();
$item=itemmaster::orderBy('item','asc')->get();
$vendor =vendor::orderBy('short_name','asc')->get();




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
return view('inventory/purchase/rfq',['btypes'=>$btypes,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'units'=>$units,'vendor'=>$vendor,'item'=>$item,'nslno'=>$nslno,'voucher'=>$voucher,'pros'=>$pros,'datas'=>$datas,'curr'=>$curr,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
else{
 return redirect('/'); 
} 
}
function createrfq(Request $req){
$validator =  $req ->validate([
                'req_no'=>'required',
                'vendor'=>'required',
                'item_id'=>'required',
                'reqqnty'=>'required'],
   [ 'req_no.required'    => 'Sorry,Please generate an enquiry number, Thank You.',
       'item_id.required'  => 'Sorry, Minimum one item is needed to save this task, 
                                     Thank You.',             
       'vendor.required'  => 'Sorry,Please select a vendor, Thank You.',
       'reqqnty.required'   => 'Sorry,Quantity is required, Thank You.'
        ]);
  $dates=$req->input('dates');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
$enquiry = requestforquotation::updateOrCreate(
  ['req_no'=>$req->input('req_no')],
['slno'=>$req->input('slno'),'dates'=>$nddate,'req_by'=>$req->input('req_by'),'vendor'=>$req->input('vendor'),'projectcode'=>$req->input('projectcode'),'currency'=>$req->input('currency'),'req_from'=>$req->input('req_from'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'deliveryinfo'=>$req->input('deliveryinfo'),'paymentterms'=>$req->input('paymentterms'),'notes'=>$req->input('notes')]);
  if(isset($enquiry)){
      $item_id=$req->item_id;
      $code = $req->item_code;
        $item_name=$req->item_name;
        $unit=$req->unit;
        $quantity=$req->reqqnty;
        $rate=$req->rate;
        $total=$req->total;
        $count =count($item_id);
for ($i=0; $i < $count; $i++){
  $bnd =requestforquotationdetail::updateOrCreate(
    ['item_id'=>$item_id[$i],'reqid'=>$enquiry->id,],
  ['item_code'=>$code[$i],
  'item_name'=>$item_name[$i],
  'unit'=>$unit[$i],
  'reqqnty'=>$quantity[$i],
 
  'rate'=>$rate[$i],
  'total'=>$total[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
   }
$req->session()->flash('status', 'Data updated successfully!');
return redirect('/inventory/RFQ');

}
}
function editrfq($id,Request $req){
$priv=privilege::select('pageid','user')
           ->where('pageid','48')
           ->where('user',session('id'))
           ->count();
            if(session('id')!="" && ($priv >0)){
                 //////// For Popups/////////////
                $units = unit::where('active','1')
                        ->select('shortname')
                        ->orderBy('shortname','Asc')
                        ->get();
                $sllo = itemmaster::select('localslno')
                        ->wherenotNull('localslno')
                        ->where('localslno','!=','0')
                        ->orderBy('id','Desc')
                        ->take(1)->first();
              $nlslno =$sllo->localslno + 1;
              $nllslno ='LI'.$nlslno;
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();
                              $voucher  = vouchergeneration::where('voucherid','48')
              ->select('slno','constants')->first();  
              if(!empty($voucher->slno)){
  $slno=requestforquotation::select('slno')
                       ->where('slno',$voucher->slno)
                       ->count();
                       if($slno >0){
                   $slno1=requestforquotation::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')->first();
                         $nslno = $slno1->slno +1;
}
else{
  $nslno=$voucher->slno;
}
}else{
 $nslno=1;   
}
 $pros =projectdetail::where('is_completed','!=','1')
        ->where('is_deleted','!=','1') 
      ->get();
$datas =    requestforquotation::leftJoin('vendors', function($join) {
      $join->on('requestforquotations.vendor', '=', 'vendors.id');
         })->select('requestforquotations.id','requestforquotations.req_no','requestforquotations.req_by','vendors.vendor')
->orderBy('requestforquotations.id','desc')
          ->get();
$item=itemmaster::orderBy('item','asc')->get();
$vendor =vendor::orderBy('short_name','asc')->get();




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
$reequsi =requestforquotation::with('requestforquotationdetail')->find($id);
return view('inventory/purchase/rfqedits',['btypes'=>$btypes,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'units'=>$units,'vendor'=>$vendor,'item'=>$item,'nslno'=>$nslno,'voucher'=>$voucher,'pros'=>$pros,'datas'=>$datas,'reequsi'=>$reequsi,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
else{
 return redirect('/'); 
}

}
function getpo(Request $req){
$priv=privilege::select('pageid','user')
           ->where('pageid','36')
           ->where('user',session('id'))
           ->count();
            if(session('id')!="" && ($priv >0)){
                 //////// For Popups/////////////
                $units = unit::where('active','1')
                        ->select('shortname')
                        ->orderBy('shortname','Asc')
                        ->get();
                $sllo = itemmaster::select('localslno')
                        ->wherenotNull('localslno')
                        ->where('localslno','!=','0')
                        ->orderBy('id','Desc')
                        ->take(1)->first();
              $nlslno =$sllo->localslno + 1;
              $nllslno ='LI'.$nlslno;
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();
                              $voucher  = vouchergeneration::where('voucherid','36')
              ->select('slno','constants')->first();  
              if(!empty($voucher->slno)){
  $slno=purchaseorder::select('slno')
                       ->where('slno',$voucher->slno)
                       ->count();
                       if($slno >0){
                   $slno1=purchaseorder::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')->first();
                         $nslno = $slno1->slno +1;
}
else{
  $nslno=$voucher->slno;
}
}else{
 $nslno=1;   
}
 $pros =projectdetail::where('is_completed','!=','1')
        ->where('is_deleted','!=','1') 
      ->get();
      $curr =currency::orderBy('shortname','asc') 
      ->get();
$datas =    purchaseorder::leftJoin('vendors', function($join) {
      $join->on('purchaseorders.vendor', '=', 'vendors.id');
         })->select('purchaseorders.id','purchaseorders.po_no','purchaseorders.odr_by','vendors.vendor','purchaseorders.is_approved')
->orderBy('purchaseorders.id','desc')
          ->get();
$item=itemmaster::orderBy('item','asc')->get();
$vendor =vendor::orderBy('short_name','asc')->get();




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
return view('inventory/purchase/po',['btypes'=>$btypes,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'units'=>$units,'vendor'=>$vendor,'item'=>$item,'nslno'=>$nslno,'voucher'=>$voucher,'pros'=>$pros,'datas'=>$datas,'curr'=>$curr,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
else{
 return redirect('/'); 
}    
}
function createpo(Request $req){
$validator =  $req ->validate([
                'po_no'=>'required',
                'vendor'=>'required',
                'item_id'=>'required',
                'reqqnty'=>'required'],
   [ 'po_no.required'    => 'Sorry,Please generate an PO number, Thank You.',
       'item_id.required'  => 'Sorry, Minimum one item is needed to save this task, 
                                     Thank You.',             
       'vendor.required'  => 'Sorry,Please select a vendor, Thank You.',
       'reqqnty.required'   => 'Sorry,Quantity is required, Thank You.'
        ]);
  $dates=$req->input('dates');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
  $dates1=$req->input('deli_date');
  $nddate1 = Carbon::parse($dates1)->format('Y-m-d');
$enquiry = purchaseorder::updateOrCreate(
  ['po_no'=>$req->input('po_no')],
['slno'=>$req->input('slno'),'order_date'=>$nddate,'odr_by'=>$req->input('odr_by'),'vendor'=>$req->input('vendor'),'reference'=>$req->input('reference'),'project_code'=>$req->input('project_code'),'urgency_level'=>$req->input('urgency_level'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'request_from'=>$req->input('request_from'),'currency'=>$req->input('currency'),'fob_point'=>$req->input('fob_point'),'order_validity'=>$req->input('order_validity'),'deli_date'=>$nddate1,'remarks'=>$req->input('remarks'),'tot_qnty'=>$req->input('tot_qnty'),'tamount'=>$req->input('tamount'),'discount_total'=>$req->input('discount_total'),'erate'=>$req->input('erate'),'total'=>$req->input('totals'),'tax'=>$req->input('tax'),'freight'=>$req->input('freight'),'pf'=>$req->input('pf'),'insurance'=>$req->input('insurance'),'others'=>$req->input('others'),'net_total'=>$req->input('net_total'),'deliveryinfo'=>$req->input('deliveryinfo'),'paymentterms'=>$req->input('paymentterms'),'shipping'=>$req->input('shipping'),'dates'=>$nddate]);
  if(isset($enquiry)){
          $item_id=$req->item_id;
      $code = $req->item_code;
        $item_name=$req->item_name;
        $unit=$req->unit;
        $quantity=$req->reqqnty;
        $rate=$req->rate;
        $total=$req->total;
        $count =count($item_id);
for ($i=0; $i < $count; $i++){
  $bnd =purchaseorderdetail::Create(
  ['item_id'=>$item_id[$i],'reqid'=>$enquiry->id,
  'item_code'=>$code[$i],
  'item_name'=>$item_name[$i],
  'unit'=>$unit[$i],
  'reqqnty'=>$quantity[$i],
   'balqnty'=>$quantity[$i],
  'rate'=>$rate[$i],
  'total'=>$total[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
   }
$req->session()->flash('status', 'Data updated successfully!');
return redirect('/inventory/purchase-order');

}
}
function editspo(Request $req,$id){
$priv=privilege::select('pageid','user')
           ->where('pageid','36')
           ->where('user',session('id'))
           ->count();
            if(session('id')!="" && ($priv >0)){
                 //////// For Popups/////////////
                $units = unit::where('active','1')
                        ->select('shortname')
                        ->orderBy('shortname','Asc')
                        ->get();
                $sllo = itemmaster::select('localslno')
                        ->wherenotNull('localslno')
                        ->where('localslno','!=','0')
                        ->orderBy('id','Desc')
                        ->take(1)->first();
              $nlslno =$sllo->localslno + 1;
              $nllslno ='LI'.$nlslno;
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();
                              $voucher  = vouchergeneration::where('voucherid','36')
              ->select('slno','constants')->first();  
              if(!empty($voucher->slno)){
  $slno=purchaseorder::select('slno')
                       ->where('slno',$voucher->slno)
                       ->count();
                       if($slno >0){
                   $slno1=purchaseorder::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')->first();
                         $nslno = $slno1->slno +1;
}
else{
  $nslno=$voucher->slno;
}
}else{
 $nslno=1;   
}
$curr =currency::orderBy('shortname','asc') 
      ->get();
 $pros =projectdetail::where('is_completed','!=','1')
        ->where('is_deleted','!=','1') 
      ->get();
$datas =    purchaseorder::leftJoin('vendors', function($join) {
      $join->on('purchaseorders.vendor', '=', 'vendors.id');
         })->select('purchaseorders.id','purchaseorders.po_no','purchaseorders.odr_by','vendors.vendor','purchaseorders.is_approved')
->orderBy('purchaseorders.id','desc')
          ->get();
$item=itemmaster::orderBy('item','asc')->get();
$vendor =vendor::orderBy('short_name','asc')->get();
$reequsi =purchaseorder::with('purchaseorderdetail')->find($id);




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
return view('inventory/purchase/poedits',['btypes'=>$btypes,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'units'=>$units,'vendor'=>$vendor,'item'=>$item,'nslno'=>$nslno,'voucher'=>$voucher,'pros'=>$pros,'datas'=>$datas,'reequsi'=>$reequsi,'curr'=>$curr,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
else{
 return redirect('/'); 
} 

}
function getpoapproval(){
    $priv=privilege::select('pageid','user')
           ->where('pageid','36')
           ->where('user',session('id'))
           ->count();
            if(session('id')!="" && ($priv >0)){
                 //////// For Popups/////////////
                $units = unit::where('active','1')
                        ->select('shortname')
                        ->orderBy('shortname','Asc')
                        ->get();
                $sllo = itemmaster::select('localslno')
                        ->wherenotNull('localslno')
                        ->where('localslno','!=','0')
                        ->orderBy('id','Desc')
                        ->take(1)->first();
              $nlslno =$sllo->localslno + 1;
              $nllslno ='LI'.$nlslno;
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();
                              $voucher  = vouchergeneration::where('voucherid','36')
              ->select('slno','constants')->first();  
              if(!empty($voucher->slno)){
  $slno=purchaseorder::select('slno')
                       ->where('slno',$voucher->slno)
                       ->count();
                       if($slno >0){
                   $slno1=purchaseorder::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')->first();
                         $nslno = $slno1->slno +1;
}
else{
  $nslno=$voucher->slno;
}
}else{
 $nslno=1;   
}
 $pros =projectdetail::where('is_completed','!=','1')
        ->where('is_deleted','!=','1') 
      ->get();
      $curr =currency::orderBy('shortname','asc') 
      ->get();
$datas =    purchaseorder::leftJoin('vendors', function($join) {
      $join->on('purchaseorders.vendor', '=', 'vendors.id');
         })->select('purchaseorders.id','purchaseorders.po_no','purchaseorders.odr_by','vendors.vendor')
->where('is_approved','1')
->orderBy('purchaseorders.id','desc')
          ->get();
$item=itemmaster::orderBy('item','asc')->get();
$vendor =vendor::orderBy('short_name','asc')->get();




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
$po= purchaseorder::where('is_approved','!=','1')->get();
return view('inventory/purchase/poapproval',['btypes'=>$btypes,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'units'=>$units,'vendor'=>$vendor,'item'=>$item,'nslno'=>$nslno,'voucher'=>$voucher,'pros'=>$pros,'datas'=>$datas,'po'=>$po,'curr'=>$curr,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
else{
 return redirect('/'); 
}
}
function editapproval(Request $req,$id){
 $priv=privilege::select('pageid','user')
           ->where('pageid','37')
           ->where('user',session('id'))
           ->count();
            if(session('id')!="" && ($priv >0)){
                 //////// For Popups/////////////
                $units = unit::where('active','1')
                        ->select('shortname')
                        ->orderBy('shortname','Asc')
                        ->get();
                $sllo = itemmaster::select('localslno')
                        ->wherenotNull('localslno')
                        ->where('localslno','!=','0')
                        ->orderBy('id','Desc')
                        ->take(1)->first();
              $nlslno =$sllo->localslno + 1;
              $nllslno ='LI'.$nlslno;
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();
                              $voucher  = vouchergeneration::where('voucherid','37')
              ->select('slno','constants')->first();  
              if(!empty($voucher->slno)){
  $slno=purchaseorderapproval::select('slno')
                       ->where('slno',$voucher->slno)
                       ->count();
                       if($slno >0){
                   $slno1=purchaseorderapproval::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')->first();
                         $nslno = $slno1->slno +1;
}
else{
  $nslno=$voucher->slno;
}
}else{
 $nslno=1;   
}
$curr =currency::orderBy('shortname','asc') 
      ->get();
 $pros =projectdetail::where('is_completed','!=','1')
        ->where('is_deleted','!=','1') 
      ->get();
$datas =    purchaseorder::leftJoin('vendors', function($join) {
      $join->on('purchaseorders.vendor', '=', 'vendors.id');
         })->select('purchaseorders.id','purchaseorders.po_no','purchaseorders.odr_by','vendors.vendor')
->where('is_approved','1')
->orderBy('purchaseorders.id','desc')
          ->get();
$item=itemmaster::orderBy('item','asc')->get();
$vendor =vendor::orderBy('short_name','asc')->get();
$reequsi =purchaseorder::with('purchaseorderdetail')->find($id);




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
return view('inventory/purchase/poapprovaledits',['btypes'=>$btypes,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'units'=>$units,'vendor'=>$vendor,'item'=>$item,'nslno'=>$nslno,'voucher'=>$voucher,'pros'=>$pros,'datas'=>$datas,'reequsi'=>$reequsi,'curr'=>$curr,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
else{
 return redirect('/'); 
} 
   
}
function editsapproval(Request $req){
   $dates=$req->input('dates');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
  $dates1=$req->input('deli_date');
  $nddate1 = Carbon::parse($dates1)->format('Y-m-d');
$enquiry = purchaseorder::where('id',$req->input('idd'))->
update(['order_date'=>$nddate,'odr_by'=>$req->input('odr_by'),'vendor'=>$req->input('vendor'),'reference'=>$req->input('reference'),'project_code'=>$req->input('project_code'),'urgency_level'=>$req->input('urgency_level'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'request_from'=>$req->input('request_from'),'currency'=>$req->input('currency'),'fob_point'=>$req->input('fob_point'),'order_validity'=>$req->input('order_validity'),'deli_date'=>$nddate1,'remarks'=>$req->input('remarks'),'tot_qnty'=>$req->input('tot_qnty'),'tamount'=>$req->input('tamount'),'discount_total'=>$req->input('discount_total'),'erate'=>$req->input('erate'),'total'=>$req->input('totals'),'tax'=>$req->input('tax'),'freight'=>$req->input('freight'),'pf'=>$req->input('pf'),'insurance'=>$req->input('insurance'),'others'=>$req->input('others'),'net_total'=>$req->input('net_total'),'deliveryinfo'=>$req->input('deliveryinfo'),'paymentterms'=>$req->input('paymentterms'),'shipping'=>$req->input('shipping'),'dates'=>$nddate]);
  if(isset($enquiry)){
    $id1=$req->id1;
          $item_id=$req->item_id;
      $code = $req->item_code;
        $item_name=$req->item_name;
        $unit=$req->unit;
        $quantity=$req->reqqnty;
        $apprqnty =$req->apprqnty;
        $papprqnty =$req->papprqnty;
        $rate=$req->appr_rate;
        $total=$req->total;
        $count =count($item_id);
for ($i=0; $i < $count; $i++){
$bnd =purchaseorderdetail::where('id',$id1[$i])->update(
  ['apprqnty'=>$apprqnty[$i],
  'balqnty'=>$apprqnty[$i],
  'rate'=>$rate[$i],
  'total'=>$total[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
  
   }
$upenquiry = purchaseorder::where('id',$req->input('idd'))
             ->update(['is_approved'=>'1']);
 $req->session()->flash('status', 'Data updated successfully!');
return redirect()->back();

}
}
function getgrn(Request $req){
    $priv=privilege::select('pageid','user')
           ->where('pageid','32')
           ->where('user',session('id'))
           ->count();
            if(session('id')!="" && ($priv >0)){
                 //////// For Popups/////////////
                $units = unit::where('active','1')
                        ->select('shortname')
                        ->orderBy('shortname','Asc')
                        ->get();
                $sllo = itemmaster::select('localslno')
                        ->wherenotNull('localslno')
                        ->where('localslno','!=','0')
                        ->orderBy('id','Desc')
                        ->take(1)->first();
              $nlslno =$sllo->localslno + 1;
              $nllslno ='LI'.$nlslno;
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();
    $voucher  = vouchergeneration::where('voucherid','32')
              ->select('slno','constants')->first();

              if(!empty($voucher->slno) && !empty($voucher->constants)){
                $newno =   $voucher->constants.$voucher->slno;
  $slno=goodsreceivednote::select('slno')
                       ->where('grn_no',$newno)
                       ->count();
                       if($slno >0){
                   $slno1=goodsreceivednote::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')->first();
                         $nslno = $slno1->slno +1;
}
else{
  $nslno=$voucher->slno;
}
}else{
 $nslno=1;   
}
 $pros =projectdetail::where('is_completed','!=','1')
        ->where('is_deleted','!=','1') 
      ->get();
      $store =store::orderBy('id','Asc')->get();
$datas =    goodsreceivednote::leftJoin('vendors', function($join) {
      $join->on('goodsreceivednotes.vendor', '=', 'vendors.id');
         })->leftJoin('purchaseorders', function($joins) {
      $joins->on('goodsreceivednotes.po_no', '=', 'purchaseorders.id');
         })->select('goodsreceivednotes.id','purchaseorders.po_no','goodsreceivednotes.grn_no','vendors.vendor','goodsreceivednotes.dates')
->orderBy('goodsreceivednotes.id','desc')
          ->get();

$vendor =vendor::wherenotNull('account')->orderBy('short_name','asc')->get();
$po= purchaseorder::where('is_approved','!=','1')->get();




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
return view('inventory/purchase/grn',['btypes'=>$btypes,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'units'=>$units,'vendor'=>$vendor,'store'=>$store,'nslno'=>$nslno,'voucher'=>$voucher,'pros'=>$pros,'datas'=>$datas,'po'=>$po,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
else{
 return redirect('/'); 
}

}
function loadponumber(Request $req){
 $pos=purchaseorder::where('vendor',$req->vendor)
           ->where('is_grned','!=','1')
           ->where('is_approved','1')
           ->select('po_no','id')->get();
           return view('inventory/purchase/loadpo',['pos'=>$pos]);


}
function showapproval($id,Request $req){
     $priv=privilege::select('pageid','user')
           ->where('pageid','36')
           ->where('user',session('id'))
           ->count();
            if(session('id')!="" && ($priv >0)){
                 //////// For Popups/////////////
                $units = unit::where('active','1')
                        ->select('shortname')
                        ->orderBy('shortname','Asc')
                        ->get();
                $sllo = itemmaster::select('localslno')
                        ->wherenotNull('localslno')
                        ->where('localslno','!=','0')
                        ->orderBy('id','Desc')
                        ->take(1)->first();
              $nlslno =$sllo->localslno + 1;
              $nllslno ='LI'.$nlslno;
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();
                              $voucher  = vouchergeneration::where('voucherid','36')
              ->select('slno','constants')->first();  
              if(!empty($voucher->slno)){
  $slno=purchaseorder::select('slno')
                       ->where('slno',$voucher->slno)
                       ->count();
                       if($slno >0){
                   $slno1=purchaseorder::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')->first();
                         $nslno = $slno1->slno +1;
}
else{
  $nslno=$voucher->slno;
}
}else{
 $nslno=1;   
}
$curr =currency::orderBy('shortname','asc') 
      ->get();
 $pros =projectdetail::where('is_completed','!=','1')
        ->where('is_deleted','!=','1') 
      ->get();
$datas =    purchaseorder::leftJoin('vendors', function($join) {
      $join->on('purchaseorders.vendor', '=', 'vendors.id');
         })->select('purchaseorders.id','purchaseorders.po_no','purchaseorders.odr_by','vendors.vendor')

->orderBy('purchaseorders.id','desc')
          ->get();
$item=itemmaster::orderBy('item','asc')->get();
$vendor =vendor::orderBy('short_name','asc')->get();
$reequsi =purchaseorder::with('purchaseorderdetail')->find($id);




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
return view('inventory/purchase/poapprovalshow',['btypes'=>$btypes,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'units'=>$units,'vendor'=>$vendor,'item'=>$item,'nslno'=>$nslno,'voucher'=>$voucher,'pros'=>$pros,'datas'=>$datas,'reequsi'=>$reequsi,'curr'=>$curr,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
else{
 return redirect('/'); 
} 
 
}
function printpoapproval($id,Request $req){
    $cmpid =header::select('imagename')
         ->where('compid',session('cmpid'))->first();
   $data = purchaseorder::with('purchaseorderdetail')->leftJoin('vendors', function($join) {
      $join->on('purchaseorders.vendor', '=', 'vendors.id');
         })->select('purchaseorders.id','purchaseorders.po_no','purchaseorders.order_date','purchaseorders.reference','vendors.vendor','vendors.address','vendors.contact_person','purchaseorders.tamount','purchaseorders.discount_total','purchaseorders.net_total','purchaseorders.deliveryinfo','purchaseorders.remarks','purchaseorders.paymentterms')
->where('purchaseorders.id',$id)

          ->first();
 // return view('inventory/purchase/poapproval_view',['cmpid'=>$cmpid,'data'=>$data]);
$pdf = PDF::loadView('inventory/purchase/poapproval_view',['cmpid'=>$cmpid,'data'=>$data]);
return $pdf->download('PurchaseOrder.pdf');
}
function itemstogridforgrn(Request $req){
 $locs =$req->locs;
 $sto =store::find($locs);
$pos =purchaseorderdetail::where('reqid',$req->po)
      ->where('balqnty','!=','0')->get();
return view('inventory/purchase/gridgrnview',['pos'=>$pos,'locs'=>$locs,'sto'=>$sto]);

}
function creategrn(Request $req){
   $dates=$req->input('dates');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
  $dates1=$req->input('dc_date');
  $nddate1 = Carbon::parse($dates1)->format('Y-m-d');
$enquiry = goodsreceivednote::updateOrCreate(
  ['grn_no'=>$req->input('grn_no')],
['slno'=>$req->input('slno'),'dates'=>$nddate,'dc'=>$req->input('dc'),'dc_date'=>$nddate1,'vendor'=>$req->input('vendor'),'project_code'=>$req->input('project_code'),'locations'=>$req->input('locations'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'po_no'=>$req->input('po_no'),'remarks'=>$req->input('remarks'),'tot_qnty'=>$req->input('tot_qnty')]);
  if(isset($enquiry)){
      $item_id=$req->item_id;
      $pid = $req->pid;
      $code = $req->item_code;
      $item_name=$req->item_name;
        $unit=$req->unit;
        $location=$req->location;
        $batch=$req->batch;
        $quantity=$req->quantity;
        $apprqnty=$req->apprqnty;
        $pgrnqnty=$req->pgrnqnty;
        $mid=$req->mid;
        $rate=$req->rate;
        $total=$req->amount;
        $count =count($item_id);
for ($i=0; $i < $count; $i++){
    $ngrnqnty =$pgrnqnty[$i] +$quantity[$i];
    $nbalqnty =$apprqnty[$i]-$ngrnqnty;
  $bnd =goodsreceivednotedetail::updateOrCreate(
    ['item_id'=>$item_id[$i],
  'grnid'=>$enquiry->id,],
  ['item_code'=>$code[$i],
  'item_name'=>$item_name[$i],
  'unit'=>$unit[$i],
  'location'=>$location[$i],
  'batch'=>$batch[$i],
  'quantity'=>$quantity[$i],
   'balqnty'=>$quantity[$i],
  'rate'=>$rate[$i],
  'amount'=>$total[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
  purchaseorderdetail::where('id',$pid[$i])
  ->update(
  ['grnqnty'=>$ngrnqnty,
   'balqnty'=>$nbalqnty,
  
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
  $senq = purchaseorderdetail::where('reqid',$mid[$i])
                 ->where('balqnty','!=','0.000')->count();
    if($senq < 1){

    purchaseorder::where('id',$mid[$i])
  ->update(['is_grned'=>'1']);    
    }
    else{

 purchaseorder::where('id',$mid[$i])
  ->update(['is_grned'=>'2']); 
    }

////// Stock Movement//////////////////////////////
   stockmovement::Create(
  ['voucher_id'=>'32','voucher_type'=>'Goods Received Note','voucher_date'=>$nddate,'description'=>$req->input('grn_no'),'location_id'=>$location[$i],'item_id'=>$item_id[$i],'batch'=>$batch[$i],'rate'=>$rate[$i],'quantity'=>$quantity[$i],'stock_value'=>$total[$i],'status'=>'IN','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$ccur1 =currentstock::where('item_id',$item_id[$i])
               ->where('batch',$batch[$i])
               ->where('location_id',$location[$i])
               ->select('qnty_in','qnty_out','bal_qnty')->count();
               $ccur2 =currentstock::where('item_id',$item_id[$i])
               ->where('batch',$batch[$i])
               ->where('location_id',$location[$i])
               ->select('qnty_in','qnty_out','bal_qnty')->first();
               if($ccur1 >0){
               $nqntyin1 =   $quantity[$i] + $ccur2->qnty_in; 
               $nbalqnty =$nqntyin1 - $ccur2->qnty_out;
               currentstock::where('item_id',$item_id[$i])
               ->where('batch',$batch[$i])
               ->where('location_id',$location[$i])
               ->update(['qnty_in'=>$nqntyin1,
                       'bal_qnty'=>$nbalqnty]);
               }else{
               currentstock::create([
                'item_id'=>$item_id[$i],
               'batch'=>$batch[$i],
               'location_id'=>$location[$i],
               'qnty_in'=>$quantity[$i],
               'bal_qnty'=>$quantity[$i] ]);
               
               }
           }

$req->session()->flash('status', 'Data updated successfully!');
return redirect('/inventory/grn');

}
}
function editgrn($id,Request $req){
    $priv=privilege::select('pageid','user')
           ->where('pageid','32')
           ->where('user',session('id'))
           ->count();
            if(session('id')!="" && ($priv >0)){
                 //////// For Popups/////////////
                $units = unit::where('active','1')
                        ->select('shortname')
                        ->orderBy('shortname','Asc')
                        ->get();
                $sllo = itemmaster::select('localslno')
                        ->wherenotNull('localslno')
                        ->where('localslno','!=','0')
                        ->orderBy('id','Desc')
                        ->take(1)->first();
              $nlslno =$sllo->localslno + 1;
              $nllslno ='LI'.$nlslno;
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();

 $pros =projectdetail::where('is_completed','!=','1')
        ->where('is_deleted','!=','1') 
      ->get();
      $store =store::orderBy('id','Asc')->get();
$datas =    goodsreceivednote::leftJoin('vendors', function($join) {
      $join->on('goodsreceivednotes.vendor', '=', 'vendors.id');
         })->leftJoin('purchaseorders', function($joins) {
      $joins->on('goodsreceivednotes.po_no', '=', 'purchaseorders.id');
         })->select('goodsreceivednotes.id','purchaseorders.po_no','goodsreceivednotes.grn_no','vendors.vendor','goodsreceivednotes.dates')
->orderBy('goodsreceivednotes.id','desc')
          ->get();

$vendor =vendor::wherenotNull('account')->orderBy('short_name','asc')->get();
$po= purchaseorder::where('is_approved','!=','1')->get();
$grn =goodsreceivednote::with('goodsreceivednotedetail')->leftJoin('purchaseorders', function($joins) {
      $joins->on('goodsreceivednotes.po_no', '=', 'purchaseorders.id');
         })->select('goodsreceivednotes.*','purchaseorders.po_no')->where('goodsreceivednotes.id',$id)->first();




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
return view('inventory/purchase/grnedit',['btypes'=>$btypes,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'units'=>$units,'vendor'=>$vendor,'store'=>$store,'pros'=>$pros,'datas'=>$datas,'po'=>$po,'grn'=>$grn,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
else{
 return redirect('/'); 
}


}
function printgrn($id,Request $req){
   $cmpid =header::select('imagename')
         ->where('compid',session('cmpid'))->first();
   $data = goodsreceivednote::with('goodsreceivednotedetail')->leftJoin('vendors', function($join) {
      $join->on('goodsreceivednotes.vendor', '=', 'vendors.id');
         })->leftJoin('purchaseorders', function($joins) {
      $joins->on('goodsreceivednotes.po_no', '=', 'purchaseorders.id');
         })->select('goodsreceivednotes.id','vendors.vendor','vendors.address','purchaseorders.po_no','goodsreceivednotes.grn_no','goodsreceivednotes.dates','goodsreceivednotes.tot_qnty')
->where('goodsreceivednotes.id',$id)->first();
 //return view('inventory/purchase/grn_view',['cmpid'=>$cmpid,'data'=>$data]);
$pdf = PDF::loadView('inventory/purchase/grn_view',['cmpid'=>$cmpid,'data'=>$data]);
return $pdf->download('GoodsReceivedNotes.pdf');   
}
function ssprintgrn(Request $req){
  $cmpid =header::select('imagename')
         ->where('compid',session('cmpid'))->first();
   $data = goodsreceivednote::with('goodsreceivednotedetail')->leftJoin('vendors', function($join) {
      $join->on('goodsreceivednotes.vendor', '=', 'vendors.id');
         })->leftJoin('purchaseorders', function($joins) {
      $joins->on('goodsreceivednotes.po_no', '=', 'purchaseorders.id');
         })->select('goodsreceivednotes.id','vendors.vendor','vendors.address','purchaseorders.po_no','goodsreceivednotes.grn_no','goodsreceivednotes.dates','goodsreceivednotes.tot_qnty')
->orderBy('goodsreceivednotes.id','desc')->take(1)->first();
 //return view('inventory/purchase/grn_view',['cmpid'=>$cmpid,'data'=>$data]);
$pdf = PDF::loadView('inventory/purchase/grn_view',['cmpid'=>$cmpid,'data'=>$data]);
return $pdf->download('GoodsReceivedNotes.pdf');    
}
function getpinvoice(Request $req){
    $priv=privilege::select('pageid','user')
           ->where('pageid','35')
           ->where('user',session('id'))
           ->count();
            if(session('id')!="" && ($priv >0)){
                 //////// For Popups/////////////
                $units = unit::where('active','1')
                        ->select('shortname')
                        ->orderBy('shortname','Asc')
                        ->get();
                $sllo = itemmaster::select('localslno')
                        ->wherenotNull('localslno')
                        ->where('localslno','!=','0')
                        ->orderBy('id','Desc')
                        ->take(1)->first();
              $nlslno =$sllo->localslno + 1;
              $nllslno ='LI'.$nlslno;
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();
    $voucher  = vouchergeneration::where('voucherid','35')
              ->select('slno','constants')->first();

              if(!empty($voucher->slno) && !empty($voucher->constants)){
                $newno =   $voucher->constants.$voucher->slno;
  $slno=purchaseinvoice::select('slno')
                       ->where('p_invoice',$newno)
                       ->count();
                       if($slno >0){
                   $slno1=purchaseinvoice::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')->first();
                         $nslno = $slno1->slno +1;
}
else{
  $nslno=$voucher->slno;
}
}else{
 $nslno=1;   
}

 $pros =projectdetail::where('is_completed','!=','1')
        ->where('is_deleted','!=','1') 
      ->get();
      $store =store::orderBy('id','Asc')->get();
 $datas =    purchaseinvoice::leftJoin('vendors', function($join) {
      $join->on('purchaseinvoices.vendor', '=', 'vendors.id');
         })->leftJoin('goodsreceivednotes', function($joins) {
      $joins->on('purchaseinvoices.grnid', '=', 'goodsreceivednotes.id');
         })->select('purchaseinvoices.id','goodsreceivednotes.grn_no','vendors.vendor','purchaseinvoices.dates','purchaseinvoices.p_invoice')
->orderBy('purchaseinvoices.id','desc')
          ->get();
$curr =currency::orderBy('shortname','asc') 
      ->get();
// return $grnitem = goodsreceivednotedetail::whereHas('goodsreceivednote',function ($query) {
//     return $query->whereIn('id',array('8','9','16'));
// })->where('item_id', '=', '243')
//     ->where('balqnty','!=','0.000')
// ->select('grn_no','balqnty')
//           ->get();
      $item=itemmaster::orderBy('item','asc')->get();
$vendor =vendor::wherenotNull('account')->orderBy('short_name','asc')->get();
$po= purchaseorder::where('is_approved','!=','1')->get();




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
return view('inventory/purchase/purchaseinvoice',['btypes'=>$btypes,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'units'=>$units,'vendor'=>$vendor,'store'=>$store,'nslno'=>$nslno,'voucher'=>$voucher,'pros'=>$pros,'datas'=>$datas,'po'=>$po,'curr'=>$curr,'item'=>$item,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
else{
 return redirect('/'); 
}
}
function getlocalitems(Request $req){
    if($req->pfrom =='LocalPurchase'){
      $item =itemmaster::where('is_local','!=','')
      ->select('item','id','code','part_no')
      ->orderBy('item','asc')->get();  
    }
    elseif($req->pfrom =='Direct'){
         $item =itemmaster::select('item','id','code','part_no')
      ->orderBy('item','asc')->get();
    }
    else{
      $item ="";  
    }
    $output="";
    $output .='<option value="" hidden>Items</option>';
    foreach($item as $iit){
    $output .='<option value="'.$iit->id.'">'.$iit->code.'/'.$iit->item.'/'.$iit->part_no.'</option>';
    }
    echo $output;
}
function gridpinvoice(Request $req){
$rowCount = $req->rowCount;
$itemid = $req->itemid;
$item = itemmaster::find($itemid);
return view('inventory/purchase/itemstogridforpinvoice',['item'=>$item,'rowCount'=>$rowCount]);
}
function pcost(Request $req){
    $priv=privilege::select('pageid','user')
           ->where('pageid','32')
           ->where('user',session('id'))
           ->count();
            if(session('id')!="" && ($priv >0)){
                 //////// For Popups/////////////
                $units = unit::where('active','1')
                        ->select('shortname')
                        ->orderBy('shortname','Asc')
                        ->get();
                $sllo = itemmaster::select('localslno')
                        ->wherenotNull('localslno')
                        ->where('localslno','!=','0')
                        ->orderBy('id','Desc')
                        ->take(1)->first();
              $nlslno =$sllo->localslno + 1;
              $nllslno ='LI'.$nlslno;
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();

$datas =    goodsreceivednote::leftJoin('vendors', function($join) {
      $join->on('goodsreceivednotes.vendor', '=', 'vendors.id');
         })->leftJoin('purchaseorders', function($joins) {
      $joins->on('goodsreceivednotes.po_no', '=', 'purchaseorders.id');
         })->select('goodsreceivednotes.id','purchaseorders.po_no','goodsreceivednotes.grn_no','vendors.vendor','goodsreceivednotes.dates')
->orderBy('goodsreceivednotes.id','desc')
          ->get();

$vendor =vendor::where('business_type','FREIGHT')->wherenotNull('account')->orderBy('short_name','asc')->get();
$pi= purchaseinvoice::where('is_deleted','0')
    ->where('is_returned','0')->orderBy('id','desc')->get();
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

return view('inventory/purchase/pcost',['btypes'=>$btypes,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'units'=>$units,'vendor'=>$vendor,'datas'=>$datas,'pi'=>$pi,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
else{
 return redirect('/'); 
}

}
function loadgrndetails(Request $req){
 $grn=goodsreceivednote::where('vendor',$req->vendor)
            ->where('is_invoiced','!=','1')
            ->select('grn_no','id')->get();
    return view('inventory/purchase/loadgrn',['grn'=>$grn]);

}
function grndetailsfromcart(Request $req){
 $grng= $req->grnno;
  $grns =goodsreceivednotedetail::where('balqnty','!=','0')
              ->whereIn('grnid', $req->grnno)
              ->select(DB::raw('SUM(balqnty) AS sumqnty'),'item_id','item_code','item_name','unit')
            ->groupBy('item_id','item_code','item_name','unit')
         ->get();
return view('inventory/purchase/grngrid',['grns'=>$grns,'grng'=>$grng]);
}
function createpi(Request $req){
    $validator =  $req ->validate([
                'p_invoice'=>'required',
                'vendor'=>'required',
                'item_id'=>'required',
                'quantity'=>'required'],
   [ 'p_invoice.required'    => 'Sorry,Please generate an PI number, Thank You.',
       'item_id.required'  => 'Sorry, Minimum one item is needed to save this task, 
                                     Thank You.',             
       'vendor.required'  => 'Sorry,Please select a vendor, Thank You.',
       'quantity.required'   => 'Sorry,Quantity is required, Thank You.'
        ]);
    $dates=$req->input('dates');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
  $dates1=$req->input('inv_date');
  $nddate1 = Carbon::parse($dates1)->format('Y-m-d');
  if($req->input('purchase_method')=='GRN'){
$enquiry = purchaseinvoice::updateOrCreate(
  ['p_invoice'=>$req->input('p_invoice')],
['slno'=>$req->input('slno'),'dates'=>$nddate,'invoice'=>$req->input('invoice'),'inv_date'=>$nddate1,'vendor'=>$req->input('vendor'),'project_code'=>$req->input('project_code'),'payment_mode'=>$req->input('payment_mode'),'purchase_method'=>$req->input('purchase_method'),'currency'=>$req->input('currency'),'locations'=>$req->input('locations'),'additionalcharges'=>$req->input('additionalcharges'),'tot_qnty'=>$req->input('tot_qnty'),'tamount'=>$req->input('tamount'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'discount_total'=>$req->input('discount_total'),'tax'=>$req->input('tax'),'net_total'=>$req->input('net_total'),'erate'=>$req->input('erate'),'totalamount'=>$req->input('totalamount'),'balance'=>$req->input('totalamount'),'grnid'=>implode($req->grnid, ', ')]);
}else{
$enquiry = purchaseinvoice::updateOrCreate(
  ['p_invoice'=>$req->input('p_invoice')],
['slno'=>$req->input('slno'),'dates'=>$nddate,'invoice'=>$req->input('invoice'),'inv_date'=>$nddate1,'vendor'=>$req->input('vendor'),'project_code'=>$req->input('project_code'),'payment_mode'=>$req->input('payment_mode'),'purchase_method'=>$req->input('purchase_method'),'currency'=>$req->input('currency'),'locations'=>$req->input('locations'),'additionalcharges'=>$req->input('additionalcharges'),'tot_qnty'=>$req->input('tot_qnty'),'tamount'=>$req->input('tamount'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'discount_total'=>$req->input('discount_total'),'tax'=>$req->input('tax'),'net_total'=>$req->input('net_total'),'erate'=>$req->input('erate'),'totalamount'=>$req->input('totalamount'),'balance'=>$req->input('totalamount')]);    
}
  if(isset($enquiry)){
      $item_id=$req->item_id;
     
      $code = $req->item_code;
      $item_name=$req->item_name;
      $unit=$req->unit;
      $batch=$req->batch;
      $quantity=$req->quantity;
      $rate=$req->rate;
      $total=$req->total;
      $count =count($item_id);

for ($i=0; $i < $count; $i++){
$bnd =purchaseinvoicedetail::Create(
  ['item_id'=>$item_id[$i],
  'piid'=>$enquiry->id,
  'item_code'=>$code[$i],
  'item_name'=>$item_name[$i],
  'unit'=>$unit[$i],
  'batch'=>$batch[$i],
  'quantity'=>$quantity[$i],
   'balqnty'=>$quantity[$i],
  'rate'=>$rate[$i],
  'total'=>$total[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);

if($req->input('purchase_method')=='LocalPurchase'){
////// Stock Movement//////////////////////////////
   stockmovement::Create(
  ['voucher_id'=>'35','voucher_type'=>'Local Purchase Invoice','voucher_date'=>$nddate,'description'=>$req->input('p_invoice'),'location_id'=>$req->input('locations'),'item_id'=>$item_id[$i],'batch'=>$batch[$i],'rate'=>$rate[$i],'quantity'=>$quantity[$i],'stock_value'=>$total[$i],'status'=>'IN','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$ccur1 =currentstock::where('item_id',$item_id[$i])
               ->where('batch',$batch[$i])
               ->where('location_id',$req->input('locations'))
               ->select('qnty_in','qnty_out','bal_qnty')->count();
               $ccur2 =currentstock::where('item_id',$item_id[$i])
               ->where('batch',$batch[$i])
               ->where('location_id',$req->input('locations'))
               ->select('qnty_in','qnty_out','bal_qnty')->first();
               if($ccur1 >0){
               $nqntyin1 =   $quantity[$i] + $ccur2->qnty_in; 
               $nbalqnty =$nqntyin1 - $ccur2->qnty_out;
               currentstock::where('item_id',$item_id[$i])
               ->where('batch',$batch[$i])
               ->where('location_id',$req->input('locations'))
               ->update(['qnty_in'=>$nqntyin1,
                       'bal_qnty'=>$nbalqnty]);
               }else{
               currentstock::create([
                'item_id'=>$item_id[$i],
               'batch'=>$batch[$i],
               'location_id'=>$req->input('locations'),
               'qnty_in'=>$quantity[$i],
               'bal_qnty'=>$quantity[$i] ]);
               
               }

    }
}
  if($req->input('purchase_method')=='GRN'){
      $id1 = $req->mainid;
      $gqnty=$req->gqnty;
      $ginvqnty=$req->ginvqnty;
      $main=$req->grnid;
      $quantity1 =$req->quantity1;
      $counts =count($id1);
      for ($j=0; $j < $counts; $j++){
    $nginvqnty =$ginvqnty[$j] +$quantity1[$j];
    $nbalqnty =$gqnty[$j]-$nginvqnty;
goodsreceivednotedetail::where('id',$id1[$j])
  ->update(
  ['invqnty'=>$nginvqnty,
   'balqnty'=>$nbalqnty,
  
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
  $senq = goodsreceivednotedetail::where('grnid',$main[$j])
                 ->where('balqnty','!=','0.000')->count();
    if($senq < 1){

    goodsreceivednote::where('id',$main[$j])
  ->update(['is_invoiced'=>'1']);    
    }
    else{

 goodsreceivednote::where('id',$main[$j])
  ->update(['is_invoiced'=>'2']); 
    }
}
}
    ////////////// Accounts settling///////////////////////
    $vens =vendor::where('id',$req->input('vendor'))
    ->select('account')
    ->first();
 $sql = regularvoucherentry::where('keycode','Jr')
       ->orderBy('id','desc')
       ->take(1)->first();
 
 if(!empty($sql->slno)){
    $slno =$sql->slno;
 $nslno = $slno + 1;
}else{
  $nslno =1;  
}
 $no = 'Jr'.$nslno;
 $data= regularvoucherentry::Create(

['voucher_no'=>$no,'slno'=>$nslno,'keycode'=>'Jr','voucher'=>'4','dates'=>$nddate,'totdebit'=>$req->input('totalamount'),'totcredit'=>$req->input('totalamount'),'created_by'=>session('name'),'remarks'=>$req->input('p_invoice'),'approved_by'=>session('name'),'from_where'=>'Purchase Invoice','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
    if($req->input('purchase_method')=='Direct'){
$data1= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'debt','account_name'=>'24','narration'=>$req->input('p_invoice'),'amount'=>$req->input('totalamount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
}else{
$data1= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'debt','account_name'=>'272','narration'=>$req->input('p_invoice'),'amount'=>$req->input('totalamount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);    
}
$data2= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'cred','account_name'=>$vens->account,'narration'=>$req->input('p_invoice'),'amount'=>$req->input('totalamount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
           
$req->session()->flash('status', 'Data updated successfully!');
return redirect('/inventory/purchase-invoice');

}
}
function editpi (Request $req,$id){
     $priv=privilege::select('pageid','user')
           ->where('pageid','35')
           ->where('user',session('id'))
           ->count();
            if(session('id')!="" && ($priv >0)){
                 //////// For Popups/////////////
                $units = unit::where('active','1')
                        ->select('shortname')
                        ->orderBy('shortname','Asc')
                        ->get();
                $sllo = itemmaster::select('localslno')
                        ->wherenotNull('localslno')
                        ->where('localslno','!=','0')
                        ->orderBy('id','Desc')
                        ->take(1)->first();
              $nlslno =$sllo->localslno + 1;
              $nllslno ='LI'.$nlslno;
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();
    $voucher  = vouchergeneration::where('voucherid','35')
              ->select('slno','constants')->first();

              if(!empty($voucher->slno) && !empty($voucher->constants)){
                $newno =   $voucher->constants.$voucher->slno;
  $slno=purchaseinvoice::select('slno')
                       ->where('p_invoice',$newno)
                       ->count();
                       if($slno >0){
                   $slno1=purchaseinvoice::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')->first();
                         $nslno = $slno1->slno +1;
}
else{
  $nslno=$voucher->slno;
}
}else{
 $nslno=1;   
}
 $pros =projectdetail::where('is_completed','!=','1')
        ->where('is_deleted','!=','1') 
      ->get();
      $store =store::orderBy('id','Asc')->get();
 $datas =    purchaseinvoice::leftJoin('vendors', function($join) {
      $join->on('purchaseinvoices.vendor', '=', 'vendors.id');
         })->leftJoin('goodsreceivednotes', function($joins) {
      $joins->on('purchaseinvoices.grnid', '=', 'goodsreceivednotes.id');
         })->select('purchaseinvoices.id','goodsreceivednotes.grn_no','vendors.vendor','purchaseinvoices.dates','purchaseinvoices.p_invoice')
->orderBy('purchaseinvoices.id','desc')
          ->get();
$curr =currency::orderBy('shortname','asc') 
      ->get();

      $item=itemmaster::orderBy('item','asc')->get();
$vendor =vendor::wherenotNull('account')->orderBy('short_name','asc')->get();
$pi =purchaseinvoice::with('purchaseinvoicedetail')->find($id);
$idd= $pi->grnid;
           $myArray = explode(',', $idd);
             $doo= goodsreceivednote::whereIn('id',$myArray)
                     ->select('grn_no')->get();




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
return view('inventory/purchase/purchaseinvoiceedit',['btypes'=>$btypes,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'units'=>$units,'vendor'=>$vendor,'store'=>$store,'nslno'=>$nslno,'voucher'=>$voucher,'pros'=>$pros,'datas'=>$datas,'curr'=>$curr,'item'=>$item,'pi'=>$pi,'doo'=>$doo,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
else{
 return redirect('/'); 
}   
}
function loadpicharge(Request $req){
$pcharge=purchasecost::with('purchasecostdetail')
         ->where('pi_no',$req->pi)->first();
 $pi =purchaseinvoice::leftJoin('vendors', function($join) {
      $join->on('purchaseinvoices.vendor', '=', 'vendors.id');
         })->select('purchaseinvoices.*','vendors.vendor')
         ->where('p_invoice',$req->pi)->first();      
$vendor = vendor::where('business_type','FREIGHT')
         ->wherenotNull('account')
         ->orderBy('short_name','asc')->get();
  return view('inventory/purchase/loadpcost',['pcharge'=>$pcharge,'vendor'=>$vendor,'pi'=>$pi]);
}
function createpicost(Request $req){
    $dates=$req->input('dates1');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
    $enquiry = purchasecost::updateOrCreate(
  ['pi_no'=>$req->input('pi_no')],
['dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
  if(isset($enquiry)){
     $dates1=$req->dates;
      $costfor=$req->costfor;
      $vendor = $req->vendor;
      $amount=$req->amount;
      $count =count($costfor);
for ($i=0; $i < $count; $i++){
    $vend = vendor::where('account',$vendor[$i])
            ->select('vendor')->first();
    $nddate1 = Carbon::parse($dates1[$i])->format('Y-m-d');        
  $bnd =purchasecostdetail::updateOrCreate(['costfor'=>$costfor[$i],
  'pcid'=>$enquiry->id,'pinvid'=>$req->input('pi_no'),],
  ['dates'=>$nddate1,
  'vendor'=>$vend->vendor,
  'vendoracc'=>$vendor[$i],
  'amount'=>$amount[$i],
  'addnos'=>$costfor[$i].'-'.$req->input('pi_no'),
  'unsettledamt'=>$amount[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
      ////////////// Accounts settling///////////////////////
  
 $sql = regularvoucherentry::where('keycode','Jr')
       ->orderBy('id','desc')
       ->take(1)->first();
 
 if(!empty($sql->slno)){
    $slno =$sql->slno;
 $nslno = $slno + 1;
}else{
  $nslno =1;  
}
 $no = 'Jr'.$nslno;
 $sqsl = regularvoucherentry::where('remarks',$costfor[$i].'Of '.$req->input('pi_no'))
       ->orderBy('id','desc')
       ->take(1)->first();
       if(!empty($sqsl->remarks)){
 $data= regularvoucherentry::where('remarks',$costfor[$i].'Of '.$req->input('pi_no'))->Update(
['dates'=>$nddate1,'totdebit'=>$amount[$i],'totcredit'=>$amount[$i],'created_by'=>session('name'),'approved_by'=>session('name'),'from_where'=>'Additional Purchase Cost','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){

$data1= regularvoucherentrydetail::where('voucherid',$sqsl->id)
->where('debitcredit','debt')
->where('narration',$costfor[$i].'Of '.$req->input('pi_no'))->Update(
  ['account_name'=>'272','amount'=>$amount[$i],'dates'=>$nddate1,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);    

$data2= regularvoucherentrydetail::where('voucherid',$sqsl->id)
->where('debitcredit','cred')
->where('narration',$costfor[$i].'Of '.$req->input('pi_no'))->Update(
  ['account_name'=>$vendor[$i],'amount'=>$amount[$i],'dates'=>$nddate1,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
       }else{
 $data= regularvoucherentry::Create(['remarks'=>$costfor[$i].'Of '.$req->input('pi_no'),'voucher_no'=>$no,'slno'=>$nslno,'keycode'=>'Jr','voucher'=>'4','dates'=>$nddate1,'totdebit'=>$amount[$i],'totcredit'=>$amount[$i],'created_by'=>session('name'),'approved_by'=>session('name'),'from_where'=>'Additional Purchase Cost','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){

$data1= regularvoucherentrydetail::Create(['voucherid'=>$data->id,'debitcredit'=>'debt','narration'=>$costfor[$i].'Of '.$req->input('pi_no'),'account_name'=>'272','amount'=>$amount[$i],'dates'=>$nddate1,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);    

$data2= regularvoucherentrydetail::Create(['voucherid'=>$data->id,'debitcredit'=>'cred','narration'=>$costfor[$i].'Of '.$req->input('pi_no'),
  'account_name'=>$vendor[$i],'amount'=>$amount[$i],'dates'=>$nddate1,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
}
   }
$req->session()->flash('status', 'Data updated successfully!');
return redirect('/inventory/purchase-cost');

}
}
function calcost(Request $req){
     
            if(session('id')!="" ){
$datas =    goodsreceivednote::leftJoin('vendors', function($join) {
      $join->on('goodsreceivednotes.vendor', '=', 'vendors.id');
         })->leftJoin('purchaseorders', function($joins) {
      $joins->on('goodsreceivednotes.po_no', '=', 'purchaseorders.id');
         })->select('goodsreceivednotes.id','purchaseorders.po_no','goodsreceivednotes.grn_no','vendors.vendor','goodsreceivednotes.dates')
->orderBy('goodsreceivednotes.id','desc')
          ->get();
$pi= purchaseinvoice::where('is_deleted','0')
    ->where('is_returned','0')->orderBy('id','desc')->get();




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
return view('inventory/purchase/costcalculation',['datas'=>$datas,'pi'=>$pi,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
else{
 return redirect('/'); 
}  
}
function loadallcharges(Request $req){
       $pi= purchaseinvoice::with('purchaseinvoicedetail')
         ->where('p_invoice',$req->pi)
         ->first();

     $pcost= purchasecost::with('purchasecostdetail')->where('pi_no',$req->pi)
        ->first();

      $charge =costcalculation::with('costcalculationdetail')
             ->where('pi_no',$req->pi)->first(); 
      
return view('inventory/purchase/loadallcharges1',['pcost'=>$pcost,'pi'=>$pi,'charge'=>$charge]);
}
function createcostcal(Request $req){
  
    $enquiry = costcalculation::updateOrCreate(
  ['pi_no'=>$req->input('pi_no')],
['purchasecost'=>$req->input('purchasecost'),'extracost'=>$req->input('extracosts'),'totalextracost'=>$req->input('totalextracost'),'percentextracost'=>$req->input('percentextracost'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
    if(isset($enquiry)){
     $code=$req->code;
      $item=$req->item;
      $qnty = $req->qnty;
      $purcost=$req->purcost;
      $erate=$req->erate;
      $kdamt=$req->kdamt;
      $extracost = $req->extracost;
      $totalkd=$req->totalkd;
      $totalextra = $req->totalextra;
      $cost=$req->cost;
     $count =count($code);
for ($i=0; $i < $count; $i++){
$bnd =costcalculationdetail::updateOrCreate(
    ['code'=>$code[$i],'costid'=>$enquiry->id,],
  ['item'=>$item[$i],
   'qnty'=>$qnty[$i],
  'purcost'=>$purcost[$i],
  'erate'=>$erate[$i],
  'kdamt'=>$kdamt[$i],
  'extracost'=>$extracost[$i],
  'totalkd'=>$totalkd[$i],
   'cost'=>$cost[$i],
  'totalextra'=>$totalextra[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);


}
}
  
$req->session()->flash('status', 'Data updated successfully!');
return redirect('/inventory/cost-calculation');
}
function getprtn(Request $req){
    $priv=privilege::select('pageid','user')
           ->where('pageid','39')
           ->where('user',session('id'))
           ->count();
            if(session('id')!="" && ($priv >0)){
                 //////// For Popups/////////////
                $units = unit::where('active','1')
                        ->select('shortname')
                        ->orderBy('shortname','Asc')
                        ->get();
                $sllo = itemmaster::select('localslno')
                        ->wherenotNull('localslno')
                        ->where('localslno','!=','0')
                        ->orderBy('id','Desc')
                        ->take(1)->first();
              $nlslno =$sllo->localslno + 1;
              $nllslno ='LI'.$nlslno;
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();
    $voucher  = vouchergeneration::where('voucherid','39')
              ->select('slno','constants')->first();

              if(!empty($voucher->slno) && !empty($voucher->constants)){
                $newno =   $voucher->constants.$voucher->slno;
  $slno=purchasereturn::select('slno')
                       ->where('prtn',$newno)
                       ->count();
                       if($slno >0){
                   $slno1=purchasereturn::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')->first();
                         $nslno = $slno1->slno +1;
}
else{
  $nslno=$voucher->slno;
}
}else{
 $nslno=1;   
}
 $pros =projectdetail::where('is_completed','!=','1')
        ->where('is_deleted','!=','1') 
      ->get();
      $store =store::orderBy('id','Asc')->get();
 $datas =    purchasereturn::leftJoin('vendors', function($join) {
      $join->on('purchasereturns.vendor', '=', 'vendors.id');
         })->leftJoin('purchaseinvoices', function($join) {
      $join->on('purchasereturns.pi_no', '=', 'purchaseinvoices.id');
         })->select('purchasereturns.id','purchasereturns.dates','vendors.vendor','purchasereturns.prtn','purchaseinvoices.p_invoice')
->orderBy('purchasereturns.id','desc')
          ->get();

$curr =currency::orderBy('shortname','asc') 
      ->get();

      $item=itemmaster::orderBy('item','asc')->get();
$vendor =vendor::wherenotNull('account')->orderBy('short_name','asc')->get();
$po= purchaseorder::where('is_approved','!=','1')->get();




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
return view('inventory/purchase/purchasereturn',['btypes'=>$btypes,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'units'=>$units,'vendor'=>$vendor,'store'=>$store,'nslno'=>$nslno,'voucher'=>$voucher,'pros'=>$pros,'datas'=>$datas,'po'=>$po,'curr'=>$curr,'item'=>$item,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
else{
 return redirect('/'); 
}
}
function loadpidetails(Request $req){

 $pin=purchaseinvoice::where('vendor',$req->vendor)
     ->where('is_deleted','!=','1')
     ->where('is_returned','!=','1')
     ->where('paidstatus','!=','1')
     ->get();
     $output="";
     $output .='<option value="" hidden>PI Number</option>';
     foreach($pin as $pi){

 $output .=' <option value="'.$pi->id.'" >'.$pi->p_invoice.'</option>';

     }
echo $output;

}
function loadallpi(Request $req){
 $piv =purchaseinvoicedetail::where('piid',$req->piid)
    ->where('balqnty','!=','0')
      ->get();
$mpi =purchaseinvoice::where('id',$req->piid)
      ->select('locations')
      ->first();
return view('inventory/purchase/loadpis',['piv'=>$piv,'mpi'=>$mpi]);
}
function createprtn(Request $req){
    $validator =  $req ->validate([
                'prtn'=>'required',
                'vendor'=>'required',
                'item_id'=>'required',
                'quantity'=>'required'],
   [ 'prtn.required'    => 'Sorry,Please generate an Purchase Return number, Thank You.',
       'item_id.required'  => 'Sorry, Minimum one item is needed to save this task, 
                                     Thank You.',             
       'vendor.required'  => 'Sorry,Please select a vendor, Thank You.',
       'quantity.required'   => 'Sorry,Quantity is required, Thank You.'
        ]);
    $dates=$req->input('dates');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
 $enquiry = purchasereturn::updateOrCreate(
  ['prtn'=>$req->input('prtn')],
['slno'=>$req->input('slno'),'dates'=>$nddate,'vendor'=>$req->input('vendor'),'project_code'=>$req->input('project_code'),'currency'=>$req->input('currency'),'pi_no'=>$req->input('pi_no'),'discount_total'=>$req->input('discount_total'),'tot_qnty'=>$req->input('tot_qnty'),'tamount'=>$req->input('tamount'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'nettotal'=>$req->input('nettotal'),'erate'=>$req->input('erate'),'totalamount'=>$req->input('totalamount')]);    

  if(isset($enquiry)){
      $item_id=$req->item_id;
      $id1 = $req->id1;
      $code = $req->item_code;
      $item_name=$req->item_name;
      $unit=$req->unit;
      $batch=$req->batch;
      $quantity=$req->quantity;
      $piqnty=$req->piqnty;
      $rtnqnty=$req->rtnqnty;
      $main=$req->main;
        $rate=$req->rate;
        $total=$req->total;
        $loc=$req->loc;
        $count =count($item_id);

for ($i=0; $i < $count; $i++){
    $nrtnqnty =$rtnqnty[$i] +$quantity[$i];
    $nbalqnty =$piqnty[$i]-$nrtnqnty;
  $bnd =purchasereturndetail::UpdateorCreate(
    ['purrtn_id'=>$enquiry->id,'item_id'=>$item_id[$i],],
  ['item_code'=>$code[$i],
  'item_name'=>$item_name[$i],
  'unit'=>$unit[$i],
  'batch'=>$batch[$i],
  'quantity'=>$quantity[$i],
  'rate'=>$rate[$i],
  'total'=>$total[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
////////////////// Reduction From PI//////////////
purchaseinvoicedetail::where('id',$id1[$i])
  ->update(
  ['rtnqnty'=>$nrtnqnty,
   'balqnty'=>$nbalqnty,
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
  // $pinnv = purchaseinvoice::where('id',$main[$i])
  //                ->select('grnid')->first();
  $senq = purchaseinvoicedetail::where('piid',$main[$i])
                 ->where('balqnty','!=','0.000')->count();
    if($senq < 1){

    purchaseinvoice::where('id',$main[$i])
  ->update(['is_returned'=>'1']);    
    }
    else{

 purchaseinvoice::where('id',$main[$i])
  ->update(['is_returned'=>'2']); 
    }


////// Stock Movement//////////////////////////////
   stockmovement::Create(
  ['voucher_id'=>'39','voucher_type'=>'Purchase Return','voucher_date'=>$nddate,'description'=>$req->input('prtn'),'location_id'=>$loc[$i],'item_id'=>$item_id[$i],'batch'=>$batch[$i],'rate'=>$rate[$i],'qntyout'=>$quantity[$i],'stockout'=>$total[$i],'status'=>'OUT','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$ccur1 =currentstock::where('item_id',$item_id[$i])
               ->where('batch',$batch[$i])
               ->where('location_id',$loc[$i])
               ->select('qnty_in','qnty_out','bal_qnty')->count();
               $ccur2 =currentstock::where('item_id',$item_id[$i])
               ->where('batch',$batch[$i])
               ->where('location_id',$loc[$i])
               ->select('qnty_in','qnty_out','bal_qnty')->first();
               if($ccur1 >0){
               $nqntyout1 =   $quantity[$i] + $ccur2->qnty_out; 
               $nbalqnty =$ccur2->qnty_in -$nqntyout1;
               currentstock::where('item_id',$item_id[$i])
               ->where('batch',$batch[$i])
               ->where('location_id',$loc[$i])
               ->update(['qnty_out'=>$nqntyout1,
                       'bal_qnty'=>$nbalqnty]);
               }
}
    ////////////// Accounts settling///////////////////////
    $vens =vendor::where('id',$req->input('vendor'))
    ->select('account')
    ->first();
 $sql = regularvoucherentry::where('keycode','Jr')
       ->orderBy('id','desc')
       ->take(1)->first();
 
 if(!empty($sql->slno)){
    $slno =$sql->slno;
 $nslno = $slno + 1;
}else{
  $nslno =1;  
}
 $no = 'Jr'.$nslno;
 $data= regularvoucherentry::UpdateorCreate(['remarks'=>$req->input('prtn'),],

['voucher_no'=>$no,'slno'=>$nslno,'keycode'=>'Jr','voucher'=>'4','dates'=>$nddate,'totdebit'=>$req->input('totalamount'),'totcredit'=>$req->input('totalamount'),'created_by'=>session('name'),'approved_by'=>session('name'),'from_where'=>'Purchase Return','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){

$data1= regularvoucherentrydetail::UpdateorCreate(['narration'=>$req->input('prtn'),'voucherid'=>$data->id,'debitcredit'=>'cred',],
  ['account_name'=>'272','amount'=>$req->input('totalamount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);    

$data2= regularvoucherentrydetail::UpdateorCreate(['voucherid'=>$data->id,'debitcredit'=>'debt','account_name'=>$vens->account,],
  ['narration'=>$req->input('prtn'),'amount'=>$req->input('totalamount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
           
$req->session()->flash('status', 'Data updated successfully!');
return redirect('/inventory/purchaseReturn');

}

}
function loadgrnqnties(Request $req){
$reqqnty=$req->reqqnty;
  $grnid = explode(',', $req->grnid);
  $itemid =$req->itemid;
  $grnitem = DB::table('goodsreceivednotes')
        ->leftJoin('goodsreceivednotedetails', function ($join) use ($itemid) {
            $join->on('goodsreceivednotedetails.grnid', '=', 'goodsreceivednotes.id')
                ->where('goodsreceivednotedetails.item_id', '=', $itemid)
                 ->where('goodsreceivednotedetails.balqnty', '!=', '0');
              })->whereIn('goodsreceivednotes.id',$grnid)
      ->select('goodsreceivednotes.grn_no','goodsreceivednotedetails.*')
     ->get();
return view('inventory/purchase/loadgrnqnties',['grnitem'=>$grnitem,'reqqnty'=>$reqqnty,'itemid'=>$itemid]); 

}
function editprtn(Request $req,$id){
    $priv=privilege::select('pageid','user')
           ->where('pageid','39')
           ->where('user',session('id'))
           ->count();
            if(session('id')!="" && ($priv >0)){
                 //////// For Popups/////////////
                $units = unit::where('active','1')
                        ->select('shortname')
                        ->orderBy('shortname','Asc')
                        ->get();
                $sllo = itemmaster::select('localslno')
                        ->wherenotNull('localslno')
                        ->where('localslno','!=','0')
                        ->orderBy('id','Desc')
                        ->take(1)->first();
              $nlslno =$sllo->localslno + 1;
              $nllslno ='LI'.$nlslno;
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();
    $voucher  = vouchergeneration::where('voucherid','39')
              ->select('slno','constants')->first();

              if(!empty($voucher->slno) && !empty($voucher->constants)){
                $newno =   $voucher->constants.$voucher->slno;
  $slno=purchasereturn::select('slno')
                       ->where('prtn',$newno)
                       ->count();
                       if($slno >0){
                   $slno1=purchasereturn::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')->first();
                         $nslno = $slno1->slno +1;
}
else{
  $nslno=$voucher->slno;
}
}else{
 $nslno=1;   
}
 $pros =projectdetail::where('is_completed','!=','1')
        ->where('is_deleted','!=','1') 
      ->get();
      $store =store::orderBy('id','Asc')->get();
$datas =    purchasereturn::leftJoin('vendors', function($join) {
      $join->on('purchasereturns.vendor', '=', 'vendors.id');
         })->leftJoin('purchaseinvoices', function($join) {
      $join->on('purchasereturns.pi_no', '=', 'purchaseinvoices.id');
         })->select('purchasereturns.id','purchasereturns.dates','vendors.vendor','purchasereturns.prtn','purchaseinvoices.p_invoice')
->orderBy('purchasereturns.id','desc')
          ->get();

$curr =currency::orderBy('shortname','asc') 
      ->get();

      $item=itemmaster::orderBy('item','asc')->get();
$vendor =vendor::wherenotNull('account')->orderBy('short_name','asc')->get();
$po= purchaseorder::where('is_approved','!=','1')->get();




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
         $prtn =purchasereturn::with('purchasereturndetail')->find($id);
         $pinv =purchaseinvoice::find($prtn->pi_no);
return view('inventory/purchase/purchasereturnedit',['btypes'=>$btypes,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'units'=>$units,'vendor'=>$vendor,'store'=>$store,'nslno'=>$nslno,'voucher'=>$voucher,'pros'=>$pros,'datas'=>$datas,'po'=>$po,'curr'=>$curr,'item'=>$item,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3,'prtn'=>$prtn,'pinv'=>$pinv]);
}
else{
 return redirect('/'); 
}
}
}
