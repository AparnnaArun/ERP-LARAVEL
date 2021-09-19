<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;
use Carbon\Carbon;
use App\Models\account;
use App\Models\customer;
use App\Models\vouchergeneration;
use App\Models\regularvoucherentry;
use App\Models\regularvoucherentrydetail;
use App\Models\salesinvoice;
use App\Models\salesinvoicedetail;
use App\Models\projectinvoicedetail;
use App\Models\projectinvoice;
use App\Models\customeradvance;
use App\Models\receiptdetail;
use App\Models\receipt;
class AccountsReceiptsController extends Controller
{
    function getreceipt(Request $req){

        if(session('id')!=""){
            $cust =customer::orderBy('short_name','asc')->get();
           $slno=receipt::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')
                       ->first();
if(!empty($slno->slno)){
  $nslno = $slno->slno +1;
}
else{

$nslno="1";

}
$datas =receipt::with('receiptdetail')->leftJoin('customers', 'receipts.customer', '=', 'customers.id')->select('receipts.*','customers.short_name')
        ->orderBy('id','desc')->get();
      return view('accounts/receipts/customerreceipt',['cust'=>$cust,'nslno'=>$nslno,'datas'=>$datas]);
      }
else{
 return redirect('/erp'); 

   }
  
}
function getcinvoice(Request $req){
 $sinv =salesinvoice::where('is_returned','!=','1')
       ->where('is_deleted','!=','1')
       ->where('paidstatus','!=','1')
       ->where('customer_id',$req->customer)
       ->orderBy('id','desc')->get();
        $pinv =projectinvoice::where('is_deleted','!=','1')
       ->where('paidstatus','!=','1')
       ->where('customerid',$req->customer)
        ->orderBy('id','desc')->get();
return view('accounts/receipts/loadreceipt',['sinv'=>$sinv,'pinv'=>$pinv]);
}
function getcadvance(Request $req){
        if(session('id')!=""){
                            $slno=customeradvance::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')
                       ->first();
if(!empty($slno->slno)){
  $nslno = $slno->slno +1;
}
else{

$nslno="1";

}
   
            $cust =customer::orderBy('name','asc')->get();
      $datas =customeradvance::leftJoin('customers', 'customeradvances.customer', '=', 'customers.id')->select('customeradvances.*','customers.short_name')
          ->where('customeradvances.from_where','custadv')
          ->orderBy('id','desc')->get();
      return view('accounts/receipts/customeradvance',['cust'=>$cust,'datas'=>$datas,'nslno'=>$nslno]);
      }
else{
 return redirect('/erp'); 

   }

}
function createcadvance(Request $req){
 $dates=$req->input('dates');
$nddate = Carbon::parse($dates)->format('Y-m-d');
$dates1=$req->input('chequedate');
$nddate1 = Carbon::parse($dates1)->format('Y-m-d');
 $account =customeradvance::UpdateorCreate(['advanceno'=>$req->input('advanceno'),],
  ['customer'=>$req->input('customer'),'slno'=>$req->input('slno'),
'paymentmode'=>$req->input('paymentmode'),'dates'=>$nddate,'advance'=>$req->input('advance'),'remarks'=>$req->input('remarks'),'bankcash'=>$req->input('bank'),'chequeno'=>$req->input('chequeno'),'chequedate'=>$nddate1,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'bal_advnce'=>$req->input('advance'),'from_where'=>'custadv']);
 if(isset($account)){
     //////ACCOUNTS SETTELING ////////////////
    $cust=customer::where('id',$req->input('customer'))->select('account','short_name')->first();
    if($req->input('paymentmode')=='1'){
  $sql = regularvoucherentry::where('keycode','RC')
       ->orderBy('id','desc')
       ->take(1)->first();
             if(!empty($sql->keycode)){
 $key =$sql->keycode;
}else{
 $key='RC';   
}
   }else{
   $sql = regularvoucherentry::where('keycode','RB')
       ->orderBy('id','desc')
       ->take(1)->first(); 
        if(!empty($sql->keycode)){
 $key =$sql->keycode;
}else{
 $key='RB';   
}
   }

 if(!empty($sql->slno)){
    $slno =$sql->slno;
 $nslno = $slno + 1;
}else{
  $nslno =1;  
}
 $no = $key.$nslno;
 $data= regularvoucherentry::UpdateorCreate(['remarks'=>$req->input('advanceno'),],
['voucher_no'=>$no,'slno'=>$nslno,'keycode'=>$key,'voucher'=>'2','dates'=>$nddate,'totdebit'=>$req->input('advance'),'totcredit'=>$req->input('advance'),'created_by'=>session('name'),'approved_by'=>session('name'),'from_where'=>'CustomerAdv','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'is_customeradnce'=>'1']); 
 if($data){
$data1= regularvoucherentrydetail::UpdateorCreate(['voucherid'=>$data->id,'debitcredit'=>'cred','narration'=>$req->input('advanceno'),],
  ['account_name'=>$cust->account,'amount'=>$req->input('advance'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'cheque_no'=>$req->input('chequeno'),'cheque_date'=>$nddate1]);
$data2= regularvoucherentrydetail::UpdateorCreate(['voucherid'=>$data->id,'debitcredit'=>'debt','narration'=>$req->input('advanceno'),],
  ['account_name'=>$req->input('bank'),'amount'=>$req->input('advance'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
 $req->session()->flash('status', 'Data updated successfully!');
return redirect('accounts/customer-advance'); 
 }

}
function editcadvance($id,Request $req){
        if(session('id')!=""){
            $cust =customer::orderBy('name','asc')->get();
      $datas =customeradvance::leftJoin('customers', 'customeradvances.customer', '=', 'customers.id')->select('customeradvances.*','customers.short_name')
          ->where('customeradvances.from_where','custadv')
          ->orderBy('id','desc')->get();
           $account=account::where('category','cash')
                   ->orWhere('category','bank')
                   ->select('id','printname')->get();
          $adv =customeradvance::leftJoin('accounts', 'customeradvances.bankcash', '=', 'accounts.id')->select('customeradvances.*','accounts.printname','accounts.category')->where('customeradvances.id',$id)->first();
      return view('accounts/receipts/customeradvanceedit',['cust'=>$cust,'datas'=>$datas,'adv'=>$adv,'account'=>$account]);
      }
else{
 return redirect('/erp'); 

   }
}
function getsumadvance(Request $req){
 $result = DB::table('customeradvances')
                ->select(DB::raw('sum(bal_advnce) as sum_adv'))
                ->where('customer',$req->customer)
                ->groupBy('customer')
                ->first();
       $cust=customer::select('short_name','account')
            ->where('id',$req->customer)->first();        
return view('accounts/receipts/getsumadvance',['cust'=>$cust,'result'=>$result]);
}
function createreceipt(Request $req){
 $dates=$req->input('dates');
$nddate = Carbon::parse($dates)->format('Y-m-d');
$dates1=$req->input('chequedate');
$nddate1 = Carbon::parse($dates1)->format('Y-m-d');
 $account =receipt::UpdateorCreate(
    ['rept_no'=>$req->input('rept_no')],
  ['slno'=>$req->input('slno'),'customer'=>$req->input('customer'),
'paymentmode'=>$req->input('paymentmode'),'dates'=>$nddate,'advance'=>$req->input('advance'),'totalamount'=>$req->input('totalamount'),'bank'=>$req->input('bank'),'cheque_no'=>$req->input('chequeno'),'bank_date'=>$nddate1,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'roundoff'=>$req->input('roundoff'),'totaladvace'=>$req->input('totaladvace'),'total'=>$req->input('total'),'remarks'=>$req->input('remarks'),'nettotal'=>$req->input('nettotal')]);
  if(isset($account)){
   $dates11=$req->gdates;
      $invoiceno = $req->invoiceno;
        $salesid=$req->salesid;
        $grandtotal=$req->grandtotal;
        $nettotal=$req->ntotal;
        $collected=$req->collected;
        $creditnote=$req->creditnote;
        $balance=$req->balance;
        $amount=$req->amount;
        $count =count($amount);
for ($i=0; $i < $count; $i++){
    if(!empty($amount[$i])){
    $nddate11 = Carbon::parse($dates11[$i])->format('Y-m-d');
    $ncoll =$collected[$i] + $amount[$i];
      $nbal = $nettotal[$i] - $ncoll ;
  $bnd =receiptdetail::UpdateorCreate(
  ['invoiceno'=>$invoiceno[$i],'rptid'=>$account->id,],
  ['dates'=>$nddate11,
  'salesid'=>$salesid[$i],
  'grandtotal'=>$grandtotal[$i],
  'collected'=>$collected[$i],
  'creditnote'=>$creditnote[$i],
  'balance'=>$balance[$i],
  'amount'=>$amount[$i],
  'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),
  'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
   
   ////////////////SALES INVOICE / PROJECT INVOICE UPDATE/////////////
if($nbal <= 0){
           salesinvoice::where('invoice_no',$invoiceno[$i])
        ->update(['collected_amount'=>$ncoll,
                   'balance'=>$nbal,
                    'paidstatus'=>'1']);
           projectinvoice::where('projinv_no',$invoiceno[$i])
        ->update(['collected_amount'=>$ncoll,
                   'bal_amount'=>$nbal,
                    'paidstatus'=>'1']);
          }else{
             salesinvoice::where('invoice_no',$invoiceno[$i])
        ->update(['collected_amount'=>$ncoll,
                   'balance'=>$nbal,
                    'paidstatus'=>'2']);
                projectinvoice::where('projinv_no',$invoiceno[$i])
        ->update(['collected_amount'=>$ncoll,
                   'bal_amount'=>$nbal,
                    'paidstatus'=>'2']);
          }
                  }
     
}
     //////ACCOUNTS SETTELING ////////////////
    $bname=account::where('id',$req->input('bank'))->select('printname')->first();
    if(!empty($bname->printname)){
    $remarks =$bname->printname.','. $req->input('custname').','. $req->input('rept_no');
   }
   else{
    $remarks =$req->input('custname').','. $req->input('rept_no');
   }
    if($req->input('paymentmode')=='1'){
  $sql = regularvoucherentry::where('keycode','RC')
       ->orderBy('id','desc')
       ->take(1)->first();
             if(!empty($sql->keycode)){
 $key =$sql->keycode;
}else{
 $key='RC';   
}
   }else{
   $sql = regularvoucherentry::where('keycode','RB')
       ->orderBy('id','desc')
       ->take(1)->first(); 
        if(!empty($sql->keycode)){
 $key =$sql->keycode;
}else{
 $key='RB';   
}
   }

 if(!empty($sql->slno)){
    $slno =$sql->slno;
 $nslno = $slno + 1;
}else{
  $nslno =1;  
}
 $no = $key.$nslno;
 if($req->input('paymentmode')!='5'){
 $data= regularvoucherentry::Create(
['voucher_no'=>$no,'slno'=>$nslno,'keycode'=>$key,'voucher'=>'2','dates'=>$nddate,'totdebit'=>$req->input('totalamount'),'totcredit'=>$req->input('totalamount'),'created_by'=>session('name'),'remarks'=>$remarks,'approved_by'=>session('name'),'from_where'=>'Receipts','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
$data1= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'debt','account_name'=>$req->input('bank'),'narration'=>$remarks,'amount'=>$req->input('totalamount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'cheque_no'=>$req->input('chequeno'),'cheque_date'=>$nddate1]);
$data2= regularvoucherentrydetail::Create(
  ['voucherid'=>$data->id,'debitcredit'=>'cred','account_name'=>$req->input('custaccount'),'narration'=>$remarks,'amount'=>$req->input('totalamount'),'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
}
 ///////// Customer Advance ///////////////////
 $badvn = $req->input('totalamount') -$req->input('nettotal');

 $vslno =customeradvance::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')
                       ->first();
if(!empty($vslno->slno)){
  $nvslno = $vslno->slno +1;
}
else{

$nvslno="1";

}
$kkey = 'Cadv'.$nvslno;
  $account =customeradvance::Create(
  ['customer'=>$req->input('customer'),'slno'=>$nvslno,'advanceno'=>$kkey,
'paymentmode'=>$req->input('paymentmode'),'dates'=>$nddate,'advance'=>$req->input('totalamount'),'remarks'=>$req->input('rept_no').'Advance','bankcash'=>$req->input('bank'),'chequeno'=>$req->input('chequeno'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'bal_advnce'=>$badvn,'from_where'=>'Receipt']);
 $req->session()->flash('status', 'Data updated successfully!');
return redirect('accounts/receipts');
  }

}
function editreceipt(Request $req,$id){
    if(session('id')!=""){
        $cust =customer::orderBy('name','asc')->get();
$rec =receipt::with('receiptdetail')->leftJoin('accounts', 'receipts.bank', '=', 'accounts.id')->select('receipts.*','accounts.printname')->find($id);
$datas =receipt::with('receiptdetail')->leftJoin('customers', 'receipts.customer', '=', 'customers.id')->select('receipts.*','customers.short_name')
        ->orderBy('id','desc')->get();
      return view('accounts/receipts/customerreceiptedit',['rec'=>$rec,'datas'=>$datas,'cust'=>$cust]);
      }
else{
 return redirect('/erp'); 

   }

}
function deletereceipt(Request $req,$id){
receipt::where('id',$id)
  ->update(['is_deleted'=>'1']);
  $sql =receipt::where('id',$id)
        ->select('rept_no')->first();
  $sql1 =receiptdetail::where('rptid',$id)->get();
  foreach($sql1 as $sq1) {
    /// NOT EMPTY SALES INVOICE NO/////
$pur =salesinvoice::where('invoice_no',$sq1->invoiceno)->first();
if(!empty($pur->invoice_no)){
 $tamtpur =$pur->grand_total;
 $collamtpur =$pur->collected_amount;
 $debamtpur =$pur->creditnote_amount;
 $newcollamtpur =$collamtpur - ($sq1->amount);
  $newbalpur =$tamtpur -($debamtpur + $newcollamtpur);
if($newbalpur <= 0){
    salesinvoice::where('invoice_no',$sq1->invoiceno)
->update(['collected_amount'=>$newcollamtpur,
'balance'=>$newbalpur,'paidstatus'=>'1']);
        }
    else{
      salesinvoice::where('invoice_no',$sq1->invoiceno)
->update(['collected_amount'=>$newcollamtpur,
'balance'=>$newbalpur,'paidstatus'=>'2']);    
    }

}
/// NOT EMPTY PROJECT INVOICE NO/////
$exp =projectinvoice::where('projinv_no',$sq1->invoiceno)->first();
if(!empty($exp->projinv_no)){
 $tamtexp =$exp->totalamount;
 $collamtexp =$exp->collected_amount;
 $debamtexp =$exp->creditnote_amount;
 $newcollamtexp =$collamtexp - ($sq1->amount);
  $newbalexp =$tamtexp -($debamtexp + $newcollamtexp);
if($newbalexp <= 0){
    projectinvoice::where('projinv_no',$sq1->invoiceno)
->update(['collected_amount'=>$newcollamtexp,
'bal_amount'=>$newbalexp,'paidstatus'=>'1']);
        }
    else{
      projectinvoice::where('projinv_no',$sq1->invoiceno)
->update(['collected_amount'=>$newcollamtexp,
'bal_amount'=>$newbalexp,'paidstatus'=>'2']);    
    }

}

  }
$vpay =receipt::leftJoin('customers', 'receipts.customer', '=', 'customers.id')
            ->leftJoin('accounts', 'receipts.bank', '=', 'accounts.id')->select('receipts.rept_no','customers.short_name','accounts.printname','receipts.paymentmode','receipts.dates','receipts.totalamount','receipts.bank','customers.account','receipts.nettotal','receipts.customer')->where('receipts.id',$id)->first();

 if(!empty($vpay->printname)){
     $remarks ='Deleted '.$vpay->printname.','. $vpay->short_name.','. $vpay->rept_no;
   }
   else{
     $remarks ='Deleted '.$vpay->short_name.','. $vpay->rept_no;
   }
   $dt = now();
   $nddate =$dt->format('Y-m-d');
 if($vpay->paymentmode=='1'){
$sqlss = regularvoucherentry::where('keycode','RC')
       ->orderBy('id','desc')
       ->take(1)->first();
       if(!empty($sqlss->keycode)){
 $key =$sqlss->keycode;
}else{
 $key='RC';   
}
   }else{
   $sqlss = regularvoucherentry::where('keycode','RB')
       ->orderBy('id','desc')
       ->take(1)->first(); 
        if(!empty($sqlss->keycode)){
 $key =$sqlss->keycode;
}else{
 $key='RB';   
}
   }
    if(!empty($sqlss->slno)){
    $slno =$sqlss->slno;
 $nslno = $slno + 1;
}else{
  $nslno =1;  
}
 $no = $key.$nslno;
  if($vpay->paymentmode!='5'){
 $data= regularvoucherentry::Create(['remarks'=>$remarks,
'voucher_no'=>$no,'slno'=>$nslno,'keycode'=>$key,'voucher'=>'2','dates'=>$nddate,'totdebit'=>$vpay->totalamount,'totcredit'=>$vpay->totalamount,'created_by'=>session('name'),'approved_by'=>session('name'),'from_where'=>'Deleted Receipt','cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]); 
 if($data){
$data1= regularvoucherentrydetail::Create(['voucherid'=>$data->id,'debitcredit'=>'cred',
  'account_name'=>$vpay->bank,'narration'=>$remarks,'amount'=>$vpay->totalamount,'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$data2= regularvoucherentrydetail::Create(['voucherid'=>$data->id,'debitcredit'=>'debt',
  'account_name'=>$vpay->account,'narration'=>$remarks,'amount'=>$vpay->totalamount,'dates'=>$nddate,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

 }
}
 ///////// Customer Advance Return///////////////////
 $badvn = $vpay->nettotal - $vpay->totalamount;
 $vslno =customeradvance::select('slno')
                       ->orderBy('id','desc')
                       ->take('1')
                       ->first();
if(!empty($vslno->slno)){
  $nvslno = $vslno->slno +1;
}
else{

$nvslno="1";

}
$kkey = 'Cadv'.$nvslno;
  $account =customeradvance::Create(['remarks'=>'Deleted'.$vpay->rept_no.'Advance',
  'customer'=>$vpay->customer,'slno'=>$nvslno,'advanceno'=>$kkey,
'paymentmode'=>$vpay->paymentmode,'dates'=>$nddate,'advance'=>$vpay->totalamount,'bankcash'=>$vpay->bank,'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'bal_advnce'=>$badvn,'from_where'=>'Deleted Receipt']);    
$req->session()->flash('status', 'Data deleted successfully!');
return redirect()->back();


}

}
