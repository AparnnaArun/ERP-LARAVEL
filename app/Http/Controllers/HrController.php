<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\account;
use App\Models\employee;
use App\Models\openingaccount;
use App\Models\currentstock;
use App\Models\itemmaster;
use App\Models\executive;
use App\Models\executivecommission;
use App\Models\executiveoverhead;
use App\Models\vouchergeneration;
use App\Models\regularvoucherentry;
use App\Models\regularvoucherentrydetail;
use App\Models\salesinvoice;

class HrController extends Controller
{
           function landing(){
 if(session('id')!=""){
return view('/hr/dashboard');
}
else{
 return redirect('/'); 
}

  }
  function utility(Request $req){
if(session('id')!=""){
    
      return view('hr/changepassword');
    }
   else{
 return redirect('/'); 

   }

  }
  function updatepasswordhr(Request $req){

$req->validate([
    'password' => 'required|confirmed'
]);

$pword = $req->input('oldpassword');
 $user=User::find(session('id'));
if (!Hash::check($pword, $user->password)) {

$req->session()->flash('failed', 'Old password is incorrect!');
return redirect('/hr/utility'); 
 
}else{
   DB::table('users')
            ->where('id',session('id'))
            ->update(['password' => Hash::make($req->password)                   
                  ]);
$req->session()->flash('status', 'Task was successful!');
return redirect('/');

}

  }
        function getemployee(){
    if(session('id')!=""){
     $emps =employee::select('id','empid','name','curposition')->get();
     $emp =employee::select('slno')->orderBy('id' ,'Desc')->take(1)->first();
     $no =1;
     if(empty($emp->slno))
     {
     $nepm=1;
      
    $empid = 'APS'.$nepm;
          }
      else
      {
  $nepm =$emp->slno + 1;
  $empid = 'APS'.$nepm;
    }
 $accounts = account::select('printname','id')
                   ->where('accounttype','s1')
                   ->where('active','1')
                   ->whereIn('id',array(10, 64, 310))
                   ->orderBy('printname','Asc')->get();
                    $acccat ='others';
  $accountslist = account::select('printname','id')
                   ->where('accounttype','a1')
                   ->where('active','1')
                   ->whereIn('parentid',array(10, 64, 310))
                   ->orderBy('printname','Asc')->get();
         $accid = account::select('id')
                 ->orderBy('id','Desc')->take(1)->first();
        $allaccounts = account::select('printname','id')
                   ->where('accounttype','a1')
                   ->where('active','1')
                   ->orderBy('printname','Asc')->get();
              $status ='accemp';
        return view('hr/employee',['emps'=>$emps,'empid'=>$empid,'nepm'=>$nepm,'accounts'=>$accounts,'accid'=>$accid,'allaccounts'=>$allaccounts,'accountslist'=>$accountslist,'acccat'=>$acccat,'status'=>$status]);
 
    }
   else{
 return redirect('/'); 
}
}
function createemployees(Request $req){
    $date =$req->input('passportexp');
$date1 =$req->input('civilidexp');
$date2 =$req->input('lisenceexp');
$ndate = Carbon::parse($date)->format('Y-m-d');
$ndate1 = Carbon::parse($date1)->format('Y-m-d');
$ndate2 = Carbon::parse($date2)->format('Y-m-d');
    $validator =  $req ->validate([
'empid'=>'required',
'name'=>'required',
'dob'=>'required|date',
'bsalary'=>'required',
'accname'=>'required|unique:employees'
],['accname.unique'=>'Sorry this A/C name already taken']);
    $emp =employee::updateOrCreate(
  ['empid'=>$req->input('empid'),'name'=>$req->input('name'),],
['slno'=>$req->input('slno'),'dob'=>$req->input('dob'),'dateofjoining'=>$req->input('dateofjoining'),'joiningposition'=>$req->input('joiningposition'),'department'=>$req->input('department'),'curposition'=>$req->input('curposition'),'salaried'=>$req->input('salaried'),'approve'=>$req->input('approve'),'bsalary'=>$req->input('bsalary'),'allowance'=>$req->input('allowance'),'vehicleno'=>$req->input('vehicleno'),'accname'=>$req->input('accname'),'address'=>$req->input('address'),'actualdob'=>$req->input('actualdob'),'homeaddr'=>$req->input('homeaddr'),'kwttel1'=>$req->input('kwttel1'),'kwttel2'=>$req->input('kwttel2'),'hometel'=>$req->input('hometel'),'email'=>$req->input('email'),'emergency1'=>$req->input('emergency1'),'emergency1no'=>$req->input('emergency1no'),'emergency2'=>$req->input('emergency2'),'emergency2no'=>$req->input('emergency2no'),'spouse'=>$req->input('spouse'),'spouseno'=>$req->input('spouseno'),'nochildren'=>$req->input('nochildren'),'education'=>$req->input('education'),'passportno'=>$req->input('passportno'),'weddate'=>$req->input('weddate'),'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'passportexp'=>$ndate,'civilidno'=>$req->input('civilidno'),'civilidexp'=>$ndate1,'lisenceno'=>$req->input('lisenceno'),'lisenceexp'=>$ndate2]);
  $req->session()->flash('status', 'Data updated successfully!');
return redirect('/hr/employee-details');

} 
function editemployees($id){
 if(session('id')!=""){
    $emmp =employee::leftJoin('accounts', function($join) {
      $join->on('employees.accname', '=', 'accounts.id');
        })->select('employees.*','accounts.printname')
    ->where('employees.id',$id)->first();
     $emps =employee::select('id','empid','name','curposition')->get();
    return view('/hr/employeeedit',['emps'=>$emps,'emmp'=>$emmp]);
 
    }
   else{
 return redirect('/'); 
}


}

function editsemployis(Request $req){
$date =$req->input('passportexp');
$date1 =$req->input('civilidexp');
$date2 =$req->input('lisenceexp');
$ndate = Carbon::parse($date)->format('Y-m-d');
$ndate1 = Carbon::parse($date1)->format('Y-m-d');
$ndate2 = Carbon::parse($date2)->format('Y-m-d');
$emp =employee::where('id', $req->input('id'))->update(
['dob'=>$req->input('dob'),'dateofjoining'=>$req->input('dateofjoining'),'joiningposition'=>$req->input('joiningposition'),'department'=>$req->input('department'),'curposition'=>$req->input('curposition'),'approve'=>$req->input('approve'),'bsalary'=>$req->input('bsalary'),'allowance'=>$req->input('allowance'),'vehicleno'=>$req->input('vehicleno'),'address'=>$req->input('address'),'actualdob'=>$req->input('actualdob'),'homeaddr'=>$req->input('homeaddr'),'kwttel1'=>$req->input('kwttel1'),'kwttel2'=>$req->input('kwttel2'),'hometel'=>$req->input('hometel'),'email'=>$req->input('email'),'emergency1'=>$req->input('emergency1'),'emergency1no'=>$req->input('emergency1no'),'emergency2'=>$req->input('emergency2'),'emergency2no'=>$req->input('emergency2no'),'spouse'=>$req->input('spouse'),'spouseno'=>$req->input('spouseno'),'nochildren'=>$req->input('nochildren'),'education'=>$req->input('education'),'passportno'=>$req->input('passportno'),'weddate'=>$req->input('weddate'),'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'passportexp'=>$ndate,'civilidno'=>$req->input('civilidno'),'civilidexp'=>$ndate1,'lisenceno'=>$req->input('lisenceno'),'lisenceexp'=>$ndate2]);
  $req->session()->flash('status', 'Data updated successfully!');
return redirect()->back();
}
function loademployee(Request $req){

 $emps =employee::orderBy('name','asc')
       ->get();
      return view('/hr/loademployees',['emps'=>$emps]);
}
}
