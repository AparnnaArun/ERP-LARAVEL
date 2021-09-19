<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\account;
use App\Models\vouchergeneration;
use App\Models\regularvoucherentry;
use App\Models\regularvoucherentrydetail;
class AccountsAccountController extends Controller
{
function getregentry(Request $req){
 if(session('id')!=""){


$acc =account::where('active','1')->orderBy('printname','asc')
      ->get();
$datas =    regularvoucherentry::orderBy('id','desc')
          ->get();
return view('accounts/account/regularvoucherentry',['acc'=>$acc,'datas'=>$datas]); 
}
else{
 return redirect('/erp'); 

   } 
}

function getnumber(Request $req){
 $borc =$req->borc;
 $voucher =$req->voucher;
 if($voucher=='P' || $voucher=='R'){
 $voch =$voucher.$borc;

 }
 else{
    $voch =$voucher; 
 }
  $reg =regularvoucherentry::where('keycode',$voch)
       ->orderBy('id','desc')->take('1')->first();
       if(!empty($reg->slno)){
       $nslno =$reg->slno + 1;
   }
   else{
    $nslno = 1;
   }
   $nvoch=  $voch.$nslno; 
   if($voucher=='P'){
    $key =1;
   }elseif($voucher=='R'){
    $key =2;
   }
   elseif($voucher=='Con'){
    $key =3;
   }
   elseif($voucher=='Jr'){
    $key =4;
   }
   elseif($voucher=='Pv'){
    $key =5;
   }
   elseif($voucher=='Sv'){
    $key =6;
   }
   elseif($voucher=='DN'){
    $key =7;
   }
   elseif($voucher=='CN'){
    $key =8;
   }
   else{}
  return view('accounts/account/getnumber',['nvoch'=>$nvoch,'nslno'=>$nslno,'voch'=>$voch,'key'=>$key]);  

}
function getaccounthead(Request $req){
    $borc =$req->borc;
 $voucher =$req->voucher;
 return view('accounts/account/loadregacc',['voucher'=>$voucher,'borc'=>$borc]); 
}
function creditdebit(Request $req){
 $voch =$req->vouchers;
 $borc =$req->borc;
  $action =$req->action;
if($voch=='P' && $borc == 'B' && $action == 'cred'){

     $sql =account::where('accounttype','a1') 
         ->where('category','bank')
         ->select('id','printname')
         ->orderBy('printname','asc')
      ->get();
}
elseif($voch=='P' && $borc == 'C' && $action == 'cred') {
    $sql =account::where('accounttype','a1') 
         ->where('category','cash')
         ->select('id','printname')
         ->orderBy('printname','asc')
      ->get();
}
elseif($voch=='P' &&  $action == 'debt') {
     $sql =account::where('accounttype','a1')
         ->where(function ($query) {
    $query->where('fullcode', 'LIKE', '#2#'.'%')
          ->orWhere('fullcode', 'LIKE', '#4#'.'%')
          ->orWhere('category', 'creditor');
         })->select('id','printname')
         ->orderBy('printname','asc')
      ->get();

}
elseif(($voch=='R' && $borc == 'B' && $action == 'debt')){
 $sql =account::where('accounttype','a1') 
         ->where('category','bank')
         ->select('id','printname')
         ->orderBy('printname','asc')
      ->get();

}
elseif(($voch=='R' && $borc == 'C' && $action == 'debt')){
    $sql =account::where('accounttype','a1') 
         ->where('category','cash')
         ->select('id','printname')
         ->orderBy('printname','asc')
      ->get();

    }
elseif($voch=='R' &&  $action == 'cred') {

   $sql =account::where('accounttype','a1')
         ->where(function ($query) {
    $query->where('fullcode', 'LIKE', '#3#'.'%')
          ->orWhere('category', 'debtor');
         })->select('id','printname')
         ->orderBy('printname','asc')
      ->get();
}
elseif($voch=='Con') {
       $sql =account::where('accounttype','a1')
         ->where(function ($query) {
    $query->where('category','bank')
          ->orWhere('category', 'cash');
         })->select('id','printname')
         ->orderBy('printname','asc')
      ->get();

}
elseif($voch=='Jr') {
$sql =account::where('accounttype','a1')
      ->select('id','printname')
      ->orderBy('printname','asc')
      ->get();
    }
    elseif($voch=='Pv' && $action='debt') {
 $sql =account::where('accounttype','a1')
      ->where(function ($query) {
    $query->where('fullcode', 'LIKE', '#1#6#'.'%')
          ->orWhere('fullcode', 'LIKE', '#1#7#'.'%');
         })
      ->select('id','printname')
      ->orderBy('printname','asc')
      ->get();
    }
      elseif($voch=='Pv' && $action='cred') {
  $sql =account::where('accounttype','a1')
      ->where('category','creditor')
      ->select('id','printname')
      ->orderBy('printname','asc')
      ->get();
    }
       elseif($voch=='Sv' && $action='debt') {
   $sql =account::where('accounttype','a1')
      ->where('category','debtor')
      ->select('id','printname')
      ->orderBy('printname','asc')
      ->get();
    }
      elseif($voch=='Sv' && $action='cred') {
   $sql =account::where('accounttype','a1')
      ->where(function ($query) {
      $query->where('fullcode', 'LIKE', '#1#6#'.'%')
          ->orWhere('fullcode', 'LIKE', '#1#7#'.'%');
         })
      ->select('id','printname')
      ->orderBy('printname','asc')
      ->get();
    }
         elseif($voch=='DN' && $action='debt') {
    $sql =account::where('accounttype','a1')
      ->where('category','creditor')
      ->select('id','printname')
      ->orderBy('printname','asc')
      ->get();
    }
          elseif($voch=='DN' && $action='cred') {
    $sql =account::where('accounttype','a1')
     
      ->select('id','printname')
      ->orderBy('printname','asc')
      ->get();
    }
           elseif($voch=='CN' && $action='cred') {
    $sql =account::where('accounttype','a1')
      ->where('category','creditor')
      ->select('id','printname')
      ->orderBy('printname','asc')
      ->get();
    }
          elseif($voch=='CN' && $action='debt') {
    $sql =account::where('accounttype','a1')
     
      ->select('id','printname')
      ->orderBy('printname','asc')
      ->get();
    }
  return view('accounts/account/loadallaccount',['sql'=>$sql,'action'=>$action]);   
}
function createvoucherentry(Request $req){
 $date =$req->input('dates');
$ndate = Carbon::parse($date)->format('Y-m-d');
if($req->input('totdebit') == $req->input('totcredit')){
 $data= regularvoucherentry::Create(
['voucher_no'=>$req->input('voucher_no'),'slno'=>$req->input('slno'),'keycode'=>$req->input('keycode'),'voucher'=>$req->input('voucher'),'dates'=>$ndate,'totdebit'=>$req->input('totdebit'),'totcredit'=>$req->input('totcredit'),'created_by'=>session('name'),'remarks'=>$req->input('remarks'),'approved_by'=>$req->input('approved_by'),'froms'=>$req->input('froms'),'from_where'=>'Direct Entry','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
 $account_name=$req->account_name;
   $debitcredit =$req->debitcredit;
   $narration =$req->narration;
   $cheque_no =$req->cheque_no;
   $cheque_date =$req->cheque_date;
   $cheque_bank =$req->cheque_bank;
   $cheque_clearance =$req->cheque_clearance;
   $amount =$req->amount;
   $counts =count($account_name);
for ($j=0; $j < $counts; $j++){
  $ndate1 = Carbon::parse($cheque_date[$j])->format('Y-m-d');
   if($amount[$j] !="0"){
$data1= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>$debitcredit[$j],'account_name'=>$account_name[$j],'narration'=>$narration[$j],'amount'=>$amount[$j],'cheque_no'=>$cheque_no[$j],'cheque_date'=>$ndate1,'cheque_bank'=>$cheque_bank[$j],'cheque_clearance'=>$cheque_clearance[$j],'dates'=>$ndate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
}
$req->session()->flash('status', 'Data deleted successfully!');
return redirect('accounts/regular-entry'); 
}
}
else{
 $req->session()->flash('failed', 'Total debit & credit should be equal!');
return redirect()->back();    
}
}
function editentry(Request $req,$id){
 if(session('id')!=""){


$acc =account::where('active','1')->orderBy('printname','asc')
      ->get();
$datas =    regularvoucherentry::orderBy('id','desc')
          ->get();
$ent =regularvoucherentry::find($id);
 $eent =regularvoucherentrydetail::leftJoin('accounts', function($join) {
      $join->on('regularvoucherentrydetails.account_name', '=', 'accounts.id');
         })->select('regularvoucherentrydetails.*','accounts.printname')
         ->where('regularvoucherentrydetails.voucherid',$ent->id)->get();
return view('accounts/account/regularvoucherentryedit',['acc'=>$acc,'datas'=>$datas,'ent'=>$ent,'eent'=>$eent]); 
}
else{
 return redirect('/erp'); 

   }

}
function getopentry(Request $req){
 if(session('id')!=""){


$acc =account::where('active','1')->orderBy('printname','asc')
      ->get();
$datas =    regularvoucherentry::where('optionalvoucher','1')
          ->orderBy('id','desc')
          ->get();
return view('accounts/account/optionvoucherentry',['acc'=>$acc,'datas'=>$datas]); 
}
else{
 return redirect('/erp'); 

   } 
}
function createopentry(Request $req){
 $date =$req->input('dates');
$ndate = Carbon::parse($date)->format('Y-m-d');
if($req->input('totdebit') == $req->input('totcredit')){
 $data= regularvoucherentry::Create(
['voucher_no'=>$req->input('voucher_no'),'slno'=>$req->input('slno'),'keycode'=>$req->input('keycode'),'voucher'=>$req->input('voucher'),'dates'=>$ndate,'totdebit'=>$req->input('totdebit'),'totcredit'=>$req->input('totcredit'),'created_by'=>session('name'),'remarks'=>$req->input('remarks'),'approved_by'=>$req->input('approved_by'),'froms'=>$req->input('froms'),'from_where'=>'Direct Entry','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'optionalvoucher'=>'1']); 
 if($data){
 $account_name=$req->account_name;
   $debitcredit =$req->debitcredit;
   $narration =$req->narration;
   $cheque_no =$req->cheque_no;
   $cheque_date =$req->cheque_date;
   $cheque_bank =$req->cheque_bank;
   $cheque_clearance =$req->cheque_clearance;
   $amount =$req->amount;
   $counts =count($account_name);
for ($j=0; $j < $counts; $j++){
  $ndate1 = Carbon::parse($cheque_date[$j])->format('Y-m-d');
   if($amount[$j] !="0"){
$data1= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>$debitcredit[$j],'account_name'=>$account_name[$j],'narration'=>$narration[$j],'amount'=>$amount[$j],'cheque_no'=>$cheque_no[$j],'cheque_date'=>$ndate1,'cheque_bank'=>$cheque_bank[$j],'cheque_clearance'=>$cheque_clearance[$j],'dates'=>$ndate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
}
$req->session()->flash('status', 'Data deleted successfully!');
return redirect('accounts/optional-entry'); 
}
}
else{
 $req->session()->flash('failed', 'Total debit & credit should be equal!');
return redirect()->back();    
}
}
function getreguentry(Request $req){
 if(session('id')!=""){
$acc =account::where('active','1')->orderBy('printname','asc')
      ->get();
$datas =    regularvoucherentry::where('optionalvoucher','1')
          ->orderBy('id','desc')
          ->get();
return view('accounts/account/regularizeentry',['acc'=>$acc,'datas'=>$datas]); 
}
else{
 return redirect('/erp'); 

   } 
}
function getoptional(Request $req){
     $date =$req->startdate;
     $date1 =$req->enddate;
$ndate = Carbon::parse($date)->format('Y-m-d');
$ndate1 = Carbon::parse($date1)->format('Y-m-d');
return $datas =    regularvoucherentry::where('optionalvoucher','1')
            ->whereBetween('dates',[$ndate,$ndate1])
          ->orderBy('id','desc')
          ->get();


}
function getrecon(Request $req){

if(session('id')!=""){
$acc =account::where('active','1')
       ->where('category','bank')
       ->orderBy('printname','asc')
      ->get();
$datas =    regularvoucherentry::where('optionalvoucher','1')
          ->orderBy('id','desc')
          ->get();
return view('accounts/account/bankreconciliation',['acc'=>$acc,'datas'=>$datas]); 
}
else{
 return redirect('/erp'); 

   }

}
function getbandetails(Request $req){
     $date =$req->startdate;
     $date1 =$req->enddate;
$ndate = Carbon::parse($date)->format('Y-m-d');
$ndate1 = Carbon::parse($date1)->format('Y-m-d');
 $datas =regularvoucherentrydetail::where('account_name',$req->account)
            ->whereBetween('dates',[$ndate,$ndate1])
        
          ->get();
return view('accounts/account/getbandetails',['datas'=>$datas]); 

}
}
