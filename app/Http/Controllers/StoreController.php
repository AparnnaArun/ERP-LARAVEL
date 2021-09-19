<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\deliverynote;
 use App\Models\projectmaterialrequest;
 use App\Models\salesinvoice;
 use App\Models\executivecommission;
 use App\Models\projectinvoice;
use Validator;
use Carbon\Carbon;
use App\Models\store;
use App\Models\customer;
use App\Models\customerexecutivedetail;
use App\Models\executive;
use App\Models\currentstock;
use App\Models\itemmaster;
use App\Models\salesrateupdation;

class StoreController extends Controller
{
    public function index()
    {
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
            $store = store::all();
           return view('inventory/masters/store',['store'=>$store,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
            }
     else{
             return redirect('/'); 
         }   

    }
    public function store(Request $req)
    {
$store=store::where('defaults','1')->count();
if($store >0){

 $req->session()->flash('failed', 'Default is taken!');

return redirect('/inventory/store');  	
}
else
{
    $sst =  store::updateOrCreate(['locationname'=>$req->input('locationname'),],
            ['locationtype'=>$req->input('locationtype'),'active'=>$req->input('active'),
            'defaults'=>$req->input('defaults'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
             $req->session()->flash('status', 'Data updated successfully!');
             return redirect('/inventory/store');    
    }

}

function show($id){
if(session('id')!=""){
            $store = store::all();
            $stor = store::find($id);
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
           return view('inventory/masters/storeedit',['store'=>$store,'stor'=>$stor,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
            }
     else{
             return redirect('/'); 
         }



}

function editsstores(Request $req){
 

store::where('id', $req->input('id'))
              ->update(['locationname'=>$req->input('locationname'),'locationtype'=>$req->input('locationtype'),'active'=>$req->input('active'),'defaults'=>$req->input('defaults'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
                $req->session()->flash('status', 'Data updated successfully!');
                return redirect()->back();
              

}
function getitemdetails(){
     if(session('id')!=""){
            $store = store::all();
            $item = itemmaster::leftJoin('currentstocks', function($join) {
      $join->on('currentstocks.item_id', '=', 'itemmasters.id');
         })->leftJoin('salesrateupdations', function($join) {
      $join->on('salesrateupdations.item_id', '=', 'itemmasters.id');
         })->select('itemmasters.id', 'itemmasters.code','itemmasters.part_no','itemmasters.item','itemmasters.basic_unit','itemmasters.cost','salesrateupdations.retail_salesrate','salesrateupdations.wholesale_salesrate','itemmasters.reorder_level',
         DB::raw('SUM(currentstocks.bal_qnty) AS sumqnty'))
         ->orderBy('itemmasters.item','asc')
         ->groupBy('itemmasters.id', 'itemmasters.code','itemmasters.part_no','itemmasters.item','itemmasters.basic_unit','itemmasters.cost','salesrateupdations.retail_salesrate','salesrateupdations.wholesale_salesrate','itemmasters.reorder_level')
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
           return view('inventory/masters/itemdetails',['item'=>$item,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
            }
     else{
             return redirect('/'); 
         }

}
function getexecutives(){

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
            $customer = customer::where('active','1')
                        ->where('approve','1')
                        ->orderBy('name','Asc')->get();
            $executive = executive::where('active','1')
                        ->orderBy('short_name','Asc')->get(); 
               $cuu =   customerexecutivedetail::leftJoin('customers', function($join) {
                        $join->on('customers.id', '=', 'customerexecutivedetails.customerid'); })->get();        
           return view('inventory/masters/executives',['customer'=>$customer,'executive'=>$executive,'cuu'=>$cuu,'noti1'=>$noti1,'noti2'=>$noti2,'noti3'=>$noti3]);
            }
     else{
             return redirect('/'); 
         }

}
function invcreateeecutive(Request $req){

     $executive=$req->executive;
       
        $count =count($executive);
for ($i=0; $i < $count; $i++){
  $ece =customerexecutivedetail::Create(['customerid'=>$req->input('customerid'),'executive'=>$executive[$i],'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
   }
$req->session()->flash('status', 'Data updated successfully!');
return redirect('/inventory/executive-details'); 

}
function deleteexecutives($id,Request $req){
    customerexecutivedetail::destroy($id);
    
  $req->session()->flash('status', 'Task was successful!');
    return redirect('inventory/executive-details');

}
}
