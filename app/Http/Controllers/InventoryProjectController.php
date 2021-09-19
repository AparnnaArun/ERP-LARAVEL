<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\header;
use App\Models\privilege;
use App\Models\itemtype;
use App\Models\itemcategory;
use App\Models\itemmaster;
use App\Models\vouchergeneration;
use App\Models\customer;
use App\Models\projectdetail;
use App\Models\unit;
use App\Models\businesstype;
use App\Models\executive;
use App\Models\customerexecutivedetail;
use App\Models\projectmaterialrequest;
use App\Models\projectmaterialrequestdetail;
use App\Models\vendor;
use App\Models\User;
use App\Models\projectexpenseentry;
use App\Models\projectexpenseentrydetail;
use App\Models\regularvoucherentry;
use App\Models\regularvoucherentrydetail;
use App\Models\executivecommission;
use App\Models\projectinvoice;
use App\Models\projectinvoicedetail;
use App\Models\deliverynote;
use App\Models\salesinvoice;
use Illuminate\Support\Facades\Hash;
use PDF;
use Validator;
use Carbon\Carbon;

class InventoryProjectController extends Controller
{
    function getproject(){
    
       $priv=privilege::select('pageid','user')
           ->where('pageid','33')
           ->where('user',session('id'))
           ->count();
    	   	if(session('id')!="" && ($priv >0)){
        
    	   		//////// For Popups/////////////
    	   	
              $btypes = businesstype::select('id','btype')
                        ->where('active','1')
                        ->get();
               $execus = executive::select('id','short_name')
                         ->get();
               ///////////////////////////////////////////////////
  $voucher  = vouchergeneration::where('voucherid','33')
              ->select('slno','constants')->first();  
  $slno=projectdetail::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')
                       ->first();
if(!empty($slno->slno)){
  $nslno = $slno->slno +1;
}
else{
  $nslno=$voucher->slno;
}
 $item = itemmaster::select('id', 'code','part_no','item')
         ->orderBy('item','asc')
         ->get();  
 $customer = customer::where('approve','1')
             ->where('active','1')
             ->select('short_name','id')
             ->orderBy('short_name','asc')->get();
$datas =    projectdetail::leftJoin('customers', function($join) {
      $join->on('projectdetails.customer_id', '=', 'customers.id');
         })->select('projectdetails.id','projectdetails.project_code','projectdetails.project_name','customers.name','projectdetails.executive','projectdetails.is_completed','projectdetails.is_deleted',)
->orderBy('projectdetails.id','desc')
          ->get();
  



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
return view('inventory/project/projectdetails',['btypes'=>$btypes,'execus'=>$execus,'item'=>$item,'customer'=>$customer,'voucher'=>$voucher,'nslno'=>$nslno,'datas'=>$datas,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }
}
function getexecutives(Request $req){
	 $cuss = customerexecutivedetail::where('customerid',$req->id)->get();
	return view('inventory/project/cusexedetails',['cuss'=>$cuss]);

}
function createproject(Request $req){
	 $validator =  $req ->validate([
                'project_code'=>'required',
               
                'customer_id'=>'required',
                'short_name'=>'unique:projectdetails',
                'executive'=>'required'],
   [ 'project_code.required'    => 'Sorry,Please generate an project code, Thank You.',
       
       'customer_id.required'  => 'Sorry,Please select a customer, Thank You.',
       'executive.required'   => 'Sorry,executive is required, Thank You.'
        ]);
  $dates=$req->input('exp_startingdate');
  $dates1=$req->input('exp_endingdate');
  $nddate1 = Carbon::parse($dates1)->format('Y-m-d');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
  $enquiry = projectdetail::updateOrCreate(
  ['project_code'=>$req->input('project_code')],
['slno'=>$req->input('slno'),'exp_startingdate'=>$nddate,'exp_endingdate'=>$nddate1,'project_name'=>$req->input('project_name'),'short_name'=>$req->input('short_name'),'customer_id'=>$req->input('customer_id'),'customer_po'=>$req->input('customer_po'),'executive'=>$req->input('executive'),'remarks'=>$req->input('remarks'),'active'=>$req->input('active'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
 
$req->session()->flash('status', 'Data updated successfully!');
return redirect('/inventory/project-details');

  

}
function completeproject($id,Request $req){
	$projectdetail = projectdetail::where('id',$id)
	                 ->update(['is_completed'=>'1']);
	  $req->session()->flash('status', 'Data updated successfully!');
return redirect()->back();               

}
function deleteproject($id){
	$projectdetail = projectdetail::where('id',$id)
	                 ->update(['is_deleted'=>'1']);
	  $req->session()->flash('status', 'Data updated successfully!');
return redirect()->back();               

}
function editproject(Request $req, $id){

       $priv=privilege::select('pageid','user')
           ->where('pageid','33')
           ->where('user',session('id'))
           ->count();
    	   	if(session('id')!="" && ($priv >0)){
 
 $pro = projectdetail::find($id);  
 $customer = customer::where('approve','1')
             ->where('active','1')
             ->select('short_name','id')
             ->orderBy('short_name','asc')->get();
$datas =    projectdetail::leftJoin('customers', function($join) {
      $join->on('projectdetails.customer_id', '=', 'customers.id');
         })->select('projectdetails.id','projectdetails.project_code','projectdetails.project_name','customers.name','projectdetails.executive','projectdetails.is_completed','projectdetails.is_deleted',)
->orderBy('projectdetails.id','desc')
          ->get();
    



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
return view('inventory/project/projectdetailsedit',['customer'=>$customer,'datas'=>$datas,'pro'=>$pro,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }

}
function editsprojects(Request $req){
		 $validator =  $req ->validate([
                'project_code'=>'required',
               
                'customer_id'=>'required',
                
                'executive'=>'required'],
   [ 'project_code.required'    => 'Sorry,Please generate an project code, Thank You.',
       
       'customer_id.required'  => 'Sorry,Please select a customer, Thank You.',
       'executive.required'   => 'Sorry,executive is required, Thank You.'
        ]);
  $dates=$req->input('exp_startingdate');
  $dates1=$req->input('exp_endingdate');
  $nddate1 = Carbon::parse($dates1)->format('Y-m-d');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
  $enquiry = projectdetail::where('id',$req->input('id'))
  ->update(['project_code'=>$req->input('project_code'),
'slno'=>$req->input('slno'),'exp_startingdate'=>$nddate,'exp_endingdate'=>$nddate1,'project_name'=>$req->input('project_name'),'short_name'=>$req->input('short_name'),'customer_id'=>$req->input('customer_id'),'customer_po'=>$req->input('customer_po'),'executive'=>$req->input('executive'),'remarks'=>$req->input('remarks'),'active'=>$req->input('active'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
 
$req->session()->flash('status', 'Data updated successfully!');
return redirect()->back();

}
function getmatreq(Request $req){
           $priv=privilege::select('pageid','user')
           ->where('pageid','47')
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
               $execus = executive::select('id','short_name')
                         ->get();
               ///////////////////////////////////////////////////
  $voucher  = vouchergeneration::where('voucherid','47')
              ->select('slno','constants')->first(); 
              $sslmm =projectmaterialrequest::select('slno')
                       ->where('slno',$voucher->slno)->count(); 
  $slno=projectmaterialrequest::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')
                       ->first();
if(!empty($slno->slno)){
  $nslno = $slno->slno +1;
}
elseif(!empty($voucher->slno)){
  $nslno=$voucher->slno;
}else{
  $nslno="";  
}
 $item = itemmaster::leftJoin('currentstocks', function($join) {
      $join->on('currentstocks.item_id', '=', 'itemmasters.id');
         })->select('itemmasters.id', 'itemmasters.code','itemmasters.part_no','itemmasters.item',
         DB::raw('SUM(currentstocks.bal_qnty) AS sumqnty'))
         ->orderBy('itemmasters.item','asc')
         ->groupBy('itemmasters.id', 'itemmasters.code','itemmasters.part_no','itemmasters.item')
         ->get();  
 $customer = customer::where('approve','1')
             ->where('active','1')
             ->select('short_name','id')
             ->orderBy('short_name','asc')->get();
$datas =    projectmaterialrequest::leftJoin('projectdetails', function($join) {
      $join->on('projectdetails.id', '=', 'projectmaterialrequests.project_id');
         })->select('projectdetails.project_code','projectmaterialrequests.createdby','projectmaterialrequests.req_date','projectmaterialrequests.matreq_no','projectmaterialrequests.status','projectmaterialrequests.id')
          ->orderBy('projectmaterialrequests.id','desc')
          ->get();
          $user =User::where('login_name',session('name'))
->select('executive')->first();

 
  $pros =projectdetail::where('is_completed','!=','1')
        ->where('is_deleted','!=','1') 
        ->where('executive',$user->executive)->get();           
      



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
return view('inventory/project/projectmaterialrequest',['units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'btypes'=>$btypes,'execus'=>$execus,'item'=>$item,'customer'=>$customer,'voucher'=>$voucher,'nslno'=>$nslno,'pros'=>$pros,'datas'=>$datas,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }



}
function creatematerialreq(Request $req){
  $validator =  $req ->validate([
                'matreq_no'=>'required',
                'item_id'=>'required',
                'project_id'=>'required',
                'quantity'=>'required'],
   [ 'matreq_no.required'    => 'Sorry,Please generate an Request number, Thank You.',
       'item_id.required'  => 'Sorry, Minimum one item is needed to save this task, 
                                     Thank You.',             
       'project_id.required'  => 'Sorry,Please select a project code, Thank You.',
       'quantity.required'   => 'Sorry,Quantity is required, Thank You.'
        ]);
  $dates=$req->input('req_date');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
  $dates1=$req->input('delivery_date');
  $nddate1 = Carbon::parse($dates1)->format('Y-m-d');
  $enquiry = projectmaterialrequest::updateOrCreate(
  ['matreq_no'=>$req->input('matreq_no')],
['slno'=>$req->input('slno'),'req_date'=>$nddate,'req_by'=>$req->input('req_by'),'project_id'=>$req->input('project_id'),'purpose'=>$req->input('purpose'),'delivery_date'=>$nddate1,'net_total'=>$req->input('net_total'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'customer_id'=>$req->input('customer_id'),'customer'=>$req->input('customer'),'customerpo'=>$req->input('customerpo'),'executive'=>$req->input('executive')]);
  if(isset($enquiry)){
      $item_id=$req->item_id;
      $code = $req->code;
        $item_name=$req->item_name;
        $unit=$req->unit;
        $description=$req->description;
        $quantity=$req->quantity;
        $count =count($item_id);
for ($i=0; $i < $count; $i++){
  $bnd =projectmaterialrequestdetail::Create(
  ['item_id'=>$item_id[$i],'matreq_id'=>$enquiry->id,
  'code'=>$code[$i],
  'item_name'=>$item_name[$i],
  'unit'=>$unit[$i],
  'req_qnty'=>$quantity[$i],
  'bal_qnty'=>$quantity[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
   }
$req->session()->flash('status', 'Data updated successfully!');
return redirect('/inventory/project-material-request');

  }
}
function editmatreq($id,Request $req){
           $priv=privilege::select('pageid','user')
           ->where('pageid','47')
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
               $execus = executive::select('id','short_name')
                         ->get();
               ///////////////////////////////////////////////////
 $item = itemmaster::select('id', 'code','part_no','item')
         ->orderBy('item','asc')
         ->get();  

$datas =    projectmaterialrequest::leftJoin('projectdetails', function($join) {
      $join->on('projectdetails.id', '=', 'projectmaterialrequests.project_id');
         })->select('projectdetails.project_code','projectmaterialrequests.createdby','projectmaterialrequests.req_date','projectmaterialrequests.matreq_no','projectmaterialrequests.status','projectmaterialrequests.id')
          ->orderBy('projectmaterialrequests.id','desc')
          ->get();
          $datas1 =    projectmaterialrequest::with('projectmaterialrequestdetail')
          ->find($id);
 $user =User::where('login_name',session('name'))
->select('executive')->first();

 
  $pros =projectdetail::where('is_completed','!=','1')
        ->where('is_deleted','!=','1') 
        ->where('executive',$user->executive)->get();          
    



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
return view('inventory/project/projectmaterialrequestedit',['units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'btypes'=>$btypes,'execus'=>$execus,'item'=>$item,'pros'=>$pros,'datas'=>$datas,'datas1'=>$datas1,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }
}
function editmaterialreq(Request $req){

  $dates=$req->input('req_date');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
  $dates1=$req->input('delivery_date');
  $nddate1 = Carbon::parse($dates1)->format('Y-m-d');
  $enquiry = projectmaterialrequest::where('id',$req->input('idd'))
  ->update(['matreq_no'=>$req->input('matreq_no')
,'req_date'=>$nddate,'req_by'=>$req->input('req_by'),'project_id'=>$req->input('project_id'),'purpose'=>$req->input('purpose'),'delivery_date'=>$nddate1,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'customer'=>$req->input('customer'),'customerpo'=>$req->input('customerpo'),'executive'=>$req->input('executive')]);
 
$req->session()->flash('status', 'Data updated successfully!');
return redirect()->back();

}
function addnewvendor(Request $req){
  $name=$req->name;
 $shortname=$req->shortname;
 $bustype=$req->bustype;
 
if(!empty($name && $shortname )){
  $cus = vendor::updateOrCreate(['short_name'=>$shortname,],
             ['vendor'=>$name,'business_type'=>$bustype,'active'=>'1',
             'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),
             'wdate'=>session('wdate'),'createdby'=>session('name')]);
  
 return '<div class="alert alert-success">Data updated successfully</div>';
 
     }
else{
    return '<div class="alert alert-danger">Sorry, Something went wrong</div>';
    }


}
function getproexp(Request $req){
           $priv=privilege::select('pageid','user')
           ->where('pageid','54')
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
  $voucher  = vouchergeneration::where('voucherid','54')
              ->select('slno','constants')->first(); 
               
  $slno=projectexpenseentry::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')
                       ->first();
if(!empty($slno->slno)){
  $nslno = $slno->slno +1;
}
elseif(!empty($voucher->slno)){
  $nslno=$voucher->slno;
}else{
  $nslno="";  
}
$user =User::where('login_name',session('name'))
->select('executive')->first();

  $execs = executive::select('id', 'short_name')
         ->where('short_name',$user->executive)
         ->orderBy('short_name','asc')
         ->first();  
    
 $customer = customer::where('approve','1')
             ->where('active','1')
             ->select('short_name','id')
             ->orderBy('short_name','asc')->get();
 $datas =    projectexpenseentry::leftJoin('projectdetails', function($join) {
      $join->on('projectdetails.id', '=', 'projectexpenseentries.projectid');
         })->leftJoin('vendors', function($join) {
      $join->on('vendors.id', '=', 'projectexpenseentries.vendor_id');
         })->select('projectdetails.project_code','vendors.vendor','projectexpenseentries.*')
       ->where('projectexpenseentries.expensefrom','=','0')
            ->orderBy('projectexpenseentries.id','desc')
          ->get();
   $vendor = vendor::where('approve','1')
            ->orderBy('short_name','asc')->get();       
  



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
            
return view('inventory/project/projectexpense',['units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'btypes'=>$btypes,'execs'=>$execs,'customer'=>$customer,'voucher'=>$voucher,'nslno'=>$nslno,'datas'=>$datas,'vendor'=>$vendor,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }

}
function getprodetails(Request $req){
    $pid =$req->pid;
    $texce =$req->texce;
    $rowCount=$req->rowCount;
     $pro =projectdetail::leftJoin('customers', function($join) {
      $join->on('projectdetails.customer_id', '=', 'customers.id');
         })->select('projectdetails.*','customers.name')->find($pid);
return view('inventory/project/tablepro',['pro'=>$pro,'rowCount'=>$rowCount,'texce'=>$texce]);
}
function getexceprodetails(Request $req){
     $pros =projectdetail::where('is_completed','!=','1')
        ->where('is_deleted','!=','1') 
        ->where('executive',$req->eid)->get(); 
        $exx =executive::where('short_name',$req->eid)->first();
        return view('inventory/project/execdettt',['pros'=>$pros,'exx'=>$exx]);

}
function getproinvoice(Request $req){
     $priv=privilege::select('pageid','user')
           ->where('pageid','55')
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
  $voucher  = vouchergeneration::where('voucherid','55')
              ->select('slno','constants')->first(); 
              $sslmm =projectmaterialrequest::select('slno')
                       ->where('slno',$voucher->slno)->count(); 
  $slno=projectinvoice::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')
                       ->first();

if(!empty($slno->slno)){
  $nslno = $slno->slno +1;
}
elseif(!empty($voucher->slno)){
  $nslno=$voucher->slno;
}else{
  $nslno="";  
}
$user =User::where('login_name',session('name'))
->select('executive')->first();

  $execs = executive::select('id', 'short_name')
         ->where('short_name',$user->executive)
         ->orderBy('short_name','asc')
         ->first();
 $customer = customer::where('approve','1')
             ->where('active','1')
             ->select('short_name','id')
             ->orderBy('short_name','asc')->get();
             if(session('utype')=='Admin'){
                $datas =    projectinvoice::leftJoin('projectdetails', function($join) {
      $join->on('projectdetails.id', '=', 'projectinvoices.projectid');
         })->select('projectinvoices.*','projectdetails.project_code')
           ->orderBy('projectinvoices.id','desc')
          ->get();
   $pros =projectdetail::where('is_completed','!=','1')
        ->where('is_deleted','!=','1') 
      ->get();

             }else{
$datas =    projectinvoice::leftJoin('projectdetails', function($join) {
      $join->on('projectdetails.id', '=', 'projectinvoices.projectid');
         })->select('projectinvoices.*','projectdetails.project_code')
           ->where('projectinvoices.executive',$execs->short_name)
          ->orderBy('projectinvoices.id','desc')
          ->get();
   $pros =projectdetail::where('is_completed','!=','1')
        ->where('is_deleted','!=','1') 
        ->where('executive',$execs->short_name)
        ->get();  
        }     
           
    



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
return view('inventory/project/projectinvoice',['units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'btypes'=>$btypes,'execs'=>$execs,'customer'=>$customer,'voucher'=>$voucher,'nslno'=>$nslno,'datas'=>$datas,'pros'=>$pros,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
 else{
                  return redirect('/'); 
                 }


}
function getallprodetails(Request $req){
 $pros =projectdetail::leftJoin('customers', function($join) {
      $join->on('projectdetails.customer_id', '=', 'customers.id');
         })->leftJoin('executives', function($joins) {
      $joins->on('executives.short_name', '=', 'projectdetails.executive');
         })->where('projectdetails.id',$req->pid)
   ->select('projectdetails.*','customers.name','customers.account','executives.commission_percentage','executives.comm_pay_account','executives.exe_com_exp_ac')->first();
return view('inventory/project/projectinpt',['pros'=>$pros]); 
}
function getitemstogrid(Request $req){
   $item= $req->item;
   $rowCount=$req->rowCount;

return view('inventory/project/projectitem',['item'=>$item,'rowCount'=>$rowCount]);
}
function getutilitys(){
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
      return view('inventory/utility/changepassword',['noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
    }
   else{
 return redirect('/'); 

   } 
}
function updatepasswordinv(Request $req){
$req->validate([
    'password' => 'required|confirmed'
]);

$pword = $req->input('oldpassword');
 $user=User::find(session('id'));
if (!Hash::check($pword, $user->password)) {

$req->session()->flash('failed', 'Old password is incorrect!');
return redirect('/admin/utility'); 
 
}else{
   DB::table('users')
            ->where('id',session('id'))
            ->update(['password' => Hash::make($req->password)                   
                  ]);
$req->session()->flash('status', 'Task was successful!');
return redirect('/');

}
}
function createproexp(Request $req){
    $validator =  $req ->validate([
                'entry_no'=>'required',
                'comm_pay_account'=>'required',
                'commission_percentage'=>'required',
                'exe_com_exp_ac'=>'required',
                'vendaccount'=>'required'
            ],
   ['entry_no.required'    => 'Sorry,Please generate an entry number, Thank You.',
'comm_pay_account.required'    => 'Sorry,Executive account is Missing, Thank You.',
'exe_com_exp_ac.required'    => 'Sorry,Executive account is Missing, Thank You.',
'commission_percentage.required'    => 'Sorry,Commission percentage, Thank You.',
'vendaccount.required' =>'Sorry,Vendor account is missing, Thank You.']);
   $dates=$req->input('dates');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
$enquiry = projectexpenseentry::UpdateorCreate(
  ['entry_no'=>$req->input('entry_no'),
'slno'=>$req->input('slno'),'dates'=>$nddate,'vendor_id'=>$req->input('vendor_id'),'executive'=>$req->input('executives'),'paymentmode'=>$req->input('paymentmode'),'expense_type'=>$req->input('expense_type'),'totalamount'=>$req->input('totalamount'),'balanceamount'=>$req->input('totalamount'),'remarks'=>$req->input('remarks'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'commission_percentage'=>$req->input('commission_percentage'),'comm_pay_account'=>$req->input('comm_pay_account'),'exe_com_exp_ac'=>$req->input('exe_com_exp_ac'),'keycode'=>$req->input('constants'),'projectid'=>$req->input('projectids'),'balance_amount'=>$req->input('totalamount')]);
  if(isset($enquiry)){
    $amount = 0 - $req->input('totalamount') ;
  $percents =$req->input('commission_percentage');
  $payprofit = ($amount*$percents)  /100;
  $payprofit1 =(-1)*$payprofit ;

      $projectcode=$req->projectcode;
      $projectid = $req->projectid;
      $projectname=$req->projectname;
      $customerid=$req->customerid;
      $customer=$req->customer;
      $executive=$req->executive;
      $amount=$req->amount;
      $count =count($projectid);
        for ($i=0; $i < $count; $i++){
  $bnd =projectexpenseentrydetail::Create(
    ['expense_id'=>$enquiry->id,
  'projectcode'=>$projectcode[$i],
  'projectid'=>$projectid[$i],
  'projectname'=>$projectname[$i],
  'customerid'=>$customerid[$i],
  'customer'=>$customer[$i],
  'executive'=>$executive[$i],
  'amount'=>$amount[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
  $profit = 0 - $amount[$i] ;
  $percent =$req->input('commission_percentage');
  $profitpay = ($profit*$percent)/100;
  $profitpay1 =(-1)*$profitpay ;
      //////Executive Commission////////////////
   $exee = executivecommission::Create(
    ['invoice_no'=>$req->input('entry_no'),
  'customer'=>$customerid[$i],'executive'=>$executive[$i],'percent'=>$req->input('commission_percentage'),'profit'=>$profit,'profitpay'=>$profitpay,'from_where'=>'Project Expense Entry','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'dates'=>$nddate,'totcost'=>$amount[$i]]); 
   }
   //////ACCOUNTS SETTELING ////////////////
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
 $data= regularvoucherentry::Create(['remarks'=>$req->input('entry_no'),
'voucher_no'=>$no,'slno'=>$nslno,'keycode'=>'Jr','voucher'=>'4','dates'=>$nddate,'totdebit'=>$req->input('totalamount'),'totcredit'=>$req->input('totalamount'),'created_by'=>session('name'),'approved_by'=>session('name'),'from_where'=>'Project Expense Entry','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
    if($req->input('expense_type')=='2'){
        $data1= regularvoucherentrydetail::Create(['voucherid'=>$data->id,'debitcredit'=>'cred','narration'=>$req->input('entry_no'),'account_name'=>'321','amount'=>$req->input('totalamount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

}else{
$data1= regularvoucherentrydetail::Create(['voucherid'=>$data->id,
    'debitcredit'=>'cred','narration'=>$req->input('entry_no'),
  'account_name'=>$req->input('vendaccount'),'amount'=>$req->input('totalamount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
}
$data2= regularvoucherentrydetail::Create(['voucherid'=>$data->id,
    'debitcredit'=>'debt','narration'=>$req->input('entry_no'),
  'account_name'=>'27','amount'=>$req->input('totalamount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
  //////Executive Commission///////////////////////////////
  $sql2 = regularvoucherentry::where('keycode','Jr')
       ->orderBy('id','desc')
       ->take(1)->first();
 $slno2 =$sql2->slno;
 $nslno2 = $slno2 + 1;
 $no2 = 'Jr'.$nslno2;
 $data6= regularvoucherentry::Create(['remarks'=>'executivecommission'.$req->input('entry_no'),'from_where'=>'Project Expense Entry',
'voucher_no'=>$no2,'slno'=>$nslno2,'keycode'=>'Jr','voucher'=>'4','dates'=>$nddate,'totdebit'=>$payprofit1,'totcredit'=>$payprofit1,'created_by'=>session('name'),'approved_by'=>session('name'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data6){
$data7= regularvoucherentrydetail::Create(['voucherid'=>$data6->id,'debitcredit'=>'cred','narration'=>'executivecommission'.$req->input('entry_no'),
  'account_name'=>$req->input('exe_com_exp_ac'),'amount'=>$payprofit1,'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data8= regularvoucherentrydetail::Create(['voucherid'=>$data6->id,'debitcredit'=>'debt','narration'=>'executivecommission'.$req->input('entry_no'),
  'account_name'=>$req->input('comm_pay_account'),'amount'=>$payprofit1,'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 } 
    
$req->session()->flash('status', 'Data updated successfully!');
return redirect('/inventory/project-expense');

  }

}
function createprojinv(Request $req){
 $validator =  $req ->validate([
                'projinv_no'=>'required',
               
                'projectid'=>'required',
                'executive'=>'required',
             'cus_accnt'=>'required',
                'commission_percentage'=>'required',
                'comm_pay_account'=>'required',
                'exe_com_exp_ac'=>'required'],
   [ 'projinv_no.required'    => 'Sorry,Please generate an Inv number, Thank You.',
    'projectid.required'  => 'Sorry,Please select a project code, Thank You.',
       'executive.required'   => 'Sorry,executive is required, Thank You.',
       'cus_accnt.required'=> 'Sorry, Customer account is missing.',
       'commission_percentage.required'=> 'Sorry, Executive percentage is missing.',
       'comm_pay_account.required'=> 'Sorry, Executive account is missing.',
       'exe_com_exp_ac.required'   => 'Sorry, Executive account is missing.'
        ]);
  $dates=$req->input('dates');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
  $enquiry = projectinvoice::updateOrCreate(
  ['projinv_no'=>$req->input('projinv_no')],
['slno'=>$req->input('slno'),'dates'=>$nddate,'projectid'=>$req->input('projectid'),'projectname'=>$req->input('projectname'),'customerid'=>$req->input('customerid'),'customer'=>$req->input('customer'),'executive'=>$req->input('executive'),'remarks'=>$req->input('remarks'),'totalamount'=>$req->input('totalamount'),'bal_amount'=>$req->input('totalamount'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'commission_percentage'=>$req->input('commission_percentage'),'comm_pay_account'=>$req->input('comm_pay_account'),'exe_com_exp_ac'=>$req->input('exe_com_exp_ac'),'cus_accnt'=>$req->input('cus_accnt')]);
  $profit = $req->input('totalamount') - 0 ;
  $percent =$req->input('commission_percentage');
$profitpay = ($profit*$percent)/100;
if(isset($enquiry)){
      $item=$req->item;
      $qnty = $req->qnty;
      $rate=$req->rate;
      $total=$req->total;
      $count =count($item);
        for ($i=0; $i < $count; $i++){
  $bnd =projectinvoicedetail::Create(
  ['item'=>$item[$i],'proinv_id'=>$enquiry->id,
  'qnty'=>$qnty[$i],
  'rate'=>$rate[$i],
  'total'=>$total[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
   }
    //////Executive Commission////////////////
   $exee = executivecommission::updateOrCreate(
  ['invoice_no'=>$req->input('projinv_no')],
['customer'=>$req->input('customerid'),'executive'=>$req->input('executive'),'percent'=>$req->input('commission_percentage'),'total_amount'=>$req->input('totalamount'),'net_total'=>$req->input('totalamount'),'profit'=>$profit,'profitpay'=>$profitpay,'from_where'=>'ProjInv','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'dates'=>$nddate]); 
//////ACCOUNTS SETTELING ////////////////
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

['voucher_no'=>$no,'slno'=>$nslno,'keycode'=>'Jr','voucher'=>'4','dates'=>$nddate,'totdebit'=>$req->input('totalamount'),'totcredit'=>$req->input('totalamount'),'created_by'=>session('name'),'remarks'=>$req->input('projinv_no'),'approved_by'=>session('name'),'from_where'=>'Project Invoice','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
$data1= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'debt','account_name'=>$req->input('cus_accnt'),'narration'=>$req->input('projinv_no'),'amount'=>$req->input('totalamount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data2= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'cred','account_name'=>'65','narration'=>$req->input('projinv_no'),'amount'=>$req->input('totalamount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
  //////Executive Commission///////////////////////////////
  $sql2 = regularvoucherentry::where('keycode','Jr')
       ->orderBy('id','desc')
       ->take(1)->first();
 $slno2 =$sql2->slno;
 $nslno2 = $slno2 + 1;
 $no2 = 'Jr'.$nslno2;
 $data6= regularvoucherentry::Create(

['voucher_no'=>$no2,'slno'=>$nslno2,'keycode'=>'Jr','voucher'=>'4','dates'=>$nddate,'totdebit'=>$profitpay,'totcredit'=>$profitpay,'created_by'=>session('name'),'remarks'=>$req->input('projinv_no'),'approved_by'=>session('name'),'from_where'=>'Project Invoice','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data6){
$data7= regularvoucherentrydetail::Create(
  ['voucherid'=>$data6->id,'debitcredit'=>'debt','account_name'=>$req->input('exe_com_exp_ac'),'narration'=>$req->input('projinv_no'),'amount'=>$profitpay,'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data8= regularvoucherentrydetail::Create(
  ['voucherid'=>$data6->id,'debitcredit'=>'cred','account_name'=>$req->input('comm_pay_account'),'narration'=>$req->input('projinv_no'),'amount'=>$profitpay,'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 } 
$req->session()->flash('status', 'Data updated successfully!');
return redirect('/inventory/project-invoice');

  }

}
function editproinv(Request $req,$id){
     $priv=privilege::select('pageid','user')
           ->where('pageid','55')
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
 
$user =User::where('login_name',session('name'))
->select('executive')->first();

  $execs = executive::select('id', 'short_name')
         ->where('short_name',$user->executive)
         ->orderBy('short_name','asc')
         ->first();
 $customer = customer::where('approve','1')
             ->where('active','1')
             ->select('short_name','id')
             ->orderBy('short_name','asc')->get();
             if(session('utype')=='Admin'){
                $datas =    projectinvoice::leftJoin('projectdetails', function($join) {
      $join->on('projectdetails.id', '=', 'projectinvoices.projectid');
         })->select('projectinvoices.*','projectdetails.project_code')
           ->orderBy('projectinvoices.id','desc')
          ->get();
   $pros =projectdetail::where('is_completed','!=','1')
        ->where('is_deleted','!=','1') 
      ->get();

             }else{
$datas =    projectinvoice::leftJoin('projectdetails', function($join) {
      $join->on('projectdetails.id', '=', 'projectinvoices.projectid');
         })->select('projectinvoices.*','projectdetails.project_code')
           ->where('projectinvoices.executive',$execs->short_name)
          ->orderBy('projectinvoices.id','desc')
          ->get();
   $pros =projectdetail::where('is_completed','!=','1')
        ->where('is_deleted','!=','1') 
        ->where('executive',$execs->short_name)
        ->get();  
        }     
       



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
    $pinv =projectinvoice::with('projectinvoicedetail')->find($id); 
return view('inventory/project/editproinv',['units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'btypes'=>$btypes,'execs'=>$execs,'customer'=>$customer,'datas'=>$datas,'pros'=>$pros,'pinv'=>$pinv,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
 else{
                  return redirect('/'); 
                 }

}
function delteproinv(Request $req,$id){
  
 $pinv =projectinvoice::find($id);
 projectinvoice::where('id',$id)
            ->update(['is_deleted'=>'1']);
executivecommission::where('invoice_no',$pinv->projinv_no)
  ->update(['is_deleted'=>'1']);  
   $profit = $pinv->totalamount;
  $percent =$pinv->commission_percentage;
$profitpay = ($profit*$percent)/100;              
//////ACCOUNTS SETTELING ////////////////
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

['voucher_no'=>$no,'slno'=>$nslno,'keycode'=>'Jr','voucher'=>'4','dates'=>date('Y-m-d'),'totdebit'=>$pinv->totalamount,'totcredit'=>$pinv->totalamount,'created_by'=>session('name'),'remarks'=>'Deleted'.$pinv->projinv_no,'approved_by'=>session('name'),'from_where'=>'Deleted Project Invoice','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
$data1= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'cred','account_name'=>$pinv->cus_accnt,'narration'=>'Deleted'.$pinv->projinv_no,'amount'=>$pinv->totalamount,'dates'=>date('Y-m-d'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data2= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'debt','account_name'=>'65','narration'=>'Deleted'.$pinv->projinv_no,'amount'=>$pinv->totalamount,'dates'=>date('Y-m-d'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
   //////Executive Commission///////////////////////////////
  $sql2 = regularvoucherentry::where('keycode','Jr')
       ->orderBy('id','desc')
       ->take(1)->first();
 $slno2 =$sql2->slno;
 $nslno2 = $slno2 + 1;
 $no2 = 'Jr'.$nslno2;
 $data6= regularvoucherentry::Create(

['voucher_no'=>$no2,'slno'=>$nslno2,'keycode'=>'Jr','voucher'=>'4','dates'=>date('Y-m-d'),'totdebit'=>$profitpay,'totcredit'=>$profitpay,'created_by'=>session('name'),'remarks'=>'Deleted'.$pinv->projinv_no,'approved_by'=>session('name'),'from_where'=>'Deletd Project Invoice','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data6){
$data7= regularvoucherentrydetail::Create(
  ['voucherid'=>$data6->id,'debitcredit'=>'cred','account_name'=>$pinv->exe_com_exp_ac,'narration'=>'Deleted'.$pinv->projinv_no,'amount'=>$profitpay,'dates'=>date('Y-m-d'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data8= regularvoucherentrydetail::Create(
  ['voucherid'=>$data6->id,'debitcredit'=>'debt','account_name'=>$pinv->comm_pay_account,'narration'=>'Deleted'.$pinv->projinv_no,'amount'=>$profitpay,'dates'=>date('Y-m-d'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 } 
$req->session()->flash('status', 'Data deleted successfully!');
return redirect()->back();


}
function printpinv(Request $req){
    $cmpid =header::select('imagename')
         ->where('compid',session('cmpid'))->first();
  $data = projectinvoice::with('projectinvoicedetail')
       ->orderBy('id','desc')
      ->take('1')
          ->first();
  //return view('inventory/project/proinvview',['cmpid'=>$cmpid,'data'=>$data]);
$pdf = PDF::loadView('inventory/project/proinvview',['cmpid'=>$cmpid,'data'=>$data]);
return $pdf->download('ProjectInvoice.pdf');

}
function eprintpinv(Request $req,$id){
    $cmpid =header::select('imagename')
         ->where('compid',session('cmpid'))->first();
  $data = projectinvoice::with('projectinvoicedetail')
       ->find($id);
  //return view('inventory/project/proinvview',['cmpid'=>$cmpid,'data'=>$data]);
$pdf = PDF::loadView('inventory/project/proinvview',['cmpid'=>$cmpid,'data'=>$data]);
return $pdf->download('ProjectInvoice.pdf');

}
function getvendoracc(Request $req){
     $vend = vendor::select('account')->find($req->vid);
    $output="";
    $output .=' <input type="hidden" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="vendaccount"  value="'.$vend->account.'" readonly>';
    echo $output;

}
function editexpense($id,Request $req){
           $priv=privilege::select('pageid','user')
           ->where('pageid','54')
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
  $voucher  = vouchergeneration::where('voucherid','54')
              ->select('slno','constants')->first(); 
               
  $slno=projectexpenseentry::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')
                       ->first();
if(!empty($slno->slno)){
  $nslno = $slno->slno +1;
}
elseif(!empty($voucher->slno)){
  $nslno=$voucher->slno;
}else{
  $nslno="";  
}
$user =User::where('login_name',session('name'))
->select('executive')->first();

  $execs = executive::select('id', 'short_name')
        
         ->orderBy('short_name','asc')
         ->get();  
    
 $customer = customer::where('approve','1')
             ->where('active','1')
             ->select('short_name','id')
             ->orderBy('short_name','asc')->get();
 $datas =    projectexpenseentry::leftJoin('projectdetails', function($join) {
      $join->on('projectdetails.id', '=', 'projectexpenseentries.projectid');
         })->leftJoin('vendors', function($join) {
      $join->on('vendors.id', '=', 'projectexpenseentries.vendor_id');
         })->select('projectdetails.project_code','vendors.vendor','projectexpenseentries.*')
       ->where('projectexpenseentries.expensefrom','=','0')
        ->orderBy('projectexpenseentries.id','desc')
          ->get();
   $vendor = vendor::where('approve','1')
            ->orderBy('short_name','asc')->get();       
    $exp =projectexpenseentry::with('projectexpenseentrydetail')->find($id); 
    $vendacc =vendor::where('id',$exp->vendor_id)
               ->select('account')->first();    
    



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
return view('inventory/project/projectexpenseedit',['units'=>$units,'nllslno'=>$nllslno,'nlslno'=>$nlslno,'btypes'=>$btypes,'execs'=>$execs,'customer'=>$customer,'voucher'=>$voucher,'nslno'=>$nslno,'datas'=>$datas,'vendor'=>$vendor,'exp'=>$exp,'vendacc'=>$vendacc,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
}
           else{
                  return redirect('/'); 
                 }

}
function editsproexp(Request $req){
$dates=$req->input('dates');
  $nddate = Carbon::parse($dates)->format('Y-m-d');
$enquiry = projectexpenseentry::where('id',$req->input('id'))
->update(
  ['entry_no'=>$req->input('entry_no'),
'dates'=>$nddate,'vendor_id'=>$req->input('vendor_id'),'executive'=>$req->input('executives'),'paymentmode'=>$req->input('paymentmode'),'expense_type'=>$req->input('expense_type'),'totalamount'=>$req->input('totalamount'),'balanceamount'=>$req->input('totalamount'),'remarks'=>$req->input('remarks'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'commission_percentage'=>$req->input('commission_percentage'),'comm_pay_account'=>$req->input('comm_pay_account'),'exe_com_exp_ac'=>$req->input('exe_com_exp_ac'),'keycode'=>$req->input('constants'),'projectid'=>$req->input('projectids'),'balance_amount'=>$req->input('totalamount')]);
  if(isset($enquiry)){
    $amount = 0 - $req->input('totalamount') ;
  $percents =$req->input('commission_percentage');
  $payprofit = ($amount*$percents)  /100;
  $payprofit1 =(-1)*$payprofit ;
   $id1=$req->id1;
      $projectcode=$req->projectcode;
      $projectid = $req->projectid;
      $projectname=$req->projectname;
      $customerid=$req->customerid;
      $customer=$req->customer;
      $executive=$req->executive;
      $amount=$req->amount;
      $count =count($projectid);
        for ($i=0; $i < $count; $i++){
  $bnd =projectexpenseentrydetail::where('id',$id1[$i])
  ->update(
    ['projectcode'=>$projectcode[$i],
  'projectid'=>$projectid[$i],
  'projectname'=>$projectname[$i],
  'customerid'=>$customerid[$i],
  'customer'=>$customer[$i],
  'executive'=>$executive[$i],
  'amount'=>$amount[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
  $profit = 0 - $amount[$i] ;
  $percent =$req->input('commission_percentage');
  $profitpay = ($profit*$percent)/100;
  $profitpay1 =(-1)*$profitpay ;
      //////Executive Commission////////////////
 
   $exee = executivecommission::where('invoice_no',$req->input('entry_no'))
   ->where('customer',$customerid[$i])
   ->where('executive',$executive[$i])->update(
    ['percent'=>$req->input('commission_percentage'),'profit'=>$profit,'profitpay'=>$profitpay,'from_where'=>'Project Expense Entry','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'dates'=>$nddate,'totcost'=>$amount[$i]]); 
   }
   //////ACCOUNTS SETTELING ////////////////
 $reg=regularvoucherentry::where('remarks',$req->input('entry_no'))
      ->select('id')->first();
 $data= regularvoucherentry::where('id',$reg->id)->update(['dates'=>$nddate,'totdebit'=>$req->input('totalamount'),'totcredit'=>$req->input('totalamount'),'created_by'=>session('name'),'approved_by'=>session('name'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
    $regd=regularvoucherentrydetail::where('voucherid',$reg->id)
              ->where('debitcredit','cred')
              ->where('narration',$req->input('entry_no'))
              ->select('id')->first();
$regdd=regularvoucherentrydetail::where('voucherid',$reg->id)
              ->where('debitcredit','debt')
              ->where('narration',$req->input('entry_no'))
              ->select('id')->first(); 
$data1= regularvoucherentrydetail::where('id',$regd->id)
        ->update(['amount'=>$req->input('totalamount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

$data2= regularvoucherentrydetail::where('id',$regdd->id)
    ->update(['account_name'=>'27','amount'=>$req->input('totalamount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
  //////Executive Commission///////////////////////////////
   $rege=regularvoucherentry::where('remarks','executivecommission'.$req->input('entry_no'))
      ->select('id')->first();
 $data6= regularvoucherentry::where('id',$rege->id)
 ->update(['dates'=>$nddate,'totdebit'=>$payprofit1,'totcredit'=>$payprofit1,'created_by'=>session('name'),'approved_by'=>session('name'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data6){
     $rege1=regularvoucherentrydetail::where('narration','executivecommission'.$req->input('entry_no'))
     ->where('voucherid',$rege->id)
     ->where('debitcredit','debt')
      ->select('id')->first();
$data7= regularvoucherentrydetail::where('id',$rege1->id)
  ->update(['account_name'=>$req->input('exe_com_exp_ac'),'amount'=>$payprofit1,'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
  $rege2=regularvoucherentrydetail::where('narration','executivecommission'.$req->input('entry_no'))
     ->where('voucherid',$rege->id)
     ->where('debitcredit','cred')
      ->select('id')->first();
$data8= regularvoucherentrydetail::where('id',$rege2->id)
->update(['account_name'=>$req->input('comm_pay_account'),'amount'=>$payprofit1,'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 } 
    
$req->session()->flash('status', 'Data updated successfully!');
return redirect()->back();

  }


}
}
