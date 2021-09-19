<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\companyinformation;
use App\Models\User;
use App\Models\usercompany;
use App\Models\finyear;
use App\Models\executive;
use App\Models\executivecommission;
use App\Models\salesinvoice;
class CompanyController extends Controller
{

  function landing(){
 if(session('id')!=""){

  $result = DB::table('salesinvoices')
                ->select(DB::raw('sum(grand_total -(sales_commission + isslnrtn_amt)) as sumamt,sum(grand_total -(totcosts + sales_commission + isslnrtn_amt)) as sumprof'), DB::raw('MONTH(dates) month'))
                ->where('is_deleted','0')
                ->where('is_returned','!=','1')
                ->where('finyear',session('fyear'))
                ->groupBy('month')
                ->get();
     $result1 = DB::table('projectinvoices')
                ->select(DB::raw('sum(totalamount)as sumpamt'), DB::raw('MONTH(dates) month'))
                ->where('is_deleted','0')
                ->where('finyear',session('fyear'))
                ->groupBy('month')
                ->get();
      $result2 = DB::table('projectexpenseentries')
                ->select(DB::raw('sum(totalamount)as sumepamt'), DB::raw('MONTH(dates) month'))
                ->where('is_deleted','0')
                ->where('finyear',session('fyear'))
                ->groupBy('month')
                ->get(); 
        $cmnth =date('m');
      $result3 = DB::table('projectinvoices')
                ->select(DB::raw('sum(totalamount)as sumcpamt'), DB::raw('MONTH(dates) month'))
                ->where('is_deleted','0')
                ->where('finyear',session('fyear'))
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
return view('admin/general/dashboard',['result'=>$result,'result1'=>$result1,'result2'=>$result2,'result3'=>$result3,'result4'=>$result4]);
}
else{
 return redirect('/'); 
}

  }
    function getcompany(){
      if(session('id')!=""){
      $comps = companyinformation::select('name','short_name','phone','email','id')
      ->get();
    	return view('admin/general/companyinfo',['comps'=>$comps]);
    }
    else{
      return redirect('/');
    }
    }
    function editcompany($id){
 if(session('id')!=""){

   $comp=companyinformation::find($id);
      $comps = companyinformation::select('name','short_name','phone','email','id')
      ->get();
      return view('admin/general/companyinfoedit',['comps'=>$comps,'comp'=>$comp]);
    }
    else{
      return redirect('/');
    }
    }
function createcompany(Request $req){
$validator =  $req ->validate([
'name'=>'required',
'short_name'=>'required',
'address'=>'required',
'phone'=>'required',
'email'=>'required|email'
]);  
 $date = Carbon::now();
$comp =companyinformation::updateOrCreate(
  ['name'=>$req->input('name'),'short_name'=>$req->input('short_name')],
['address'=>$req->input('address'),'phone'=>$req->input('phone'),'email'=>$req->input('email'),'fax'=>$req->input('fax'),'active'=>$req->input('active'),
'admin'=>$req->input('admin'),'inventory'=>$req->input('inventory'),'accounts'=>$req->input('accounts'),'hr'=>$req->input('hr'),'trading'=>$req->input('trading'),'manufacturing'=>$req->input('manufacturing'),'createdby'=>session('name')]);
  $req->session()->flash('status', 'Data updated successfully!');
return redirect('/admin/company-information');

    }
function editscompany(Request $req){
              companyinformation::where('id', $req->input('id'))
              ->update(['name'=>$req->input('name'),'short_name'=>$req->input('short_name'),'address'=>$req->input('address'),'phone'=>$req->input('phone'),'email'=>$req->input('email'),'fax'=>$req->input('fax'),'active'=>$req->input('active'),'admin'=>$req->input('admin'),'inventory'=>$req->input('inventory'),'accounts'=>$req->input('accounts'),'hr'=>$req->input('hr'),'trading'=>$req->input('trading'),'manufacturing'=>$req->input('manufacturing'),'createdby'=>session('name')]);
$req->session()->flash('status', 'Data updated successfully!');
return redirect()->back();
    }
     function getuser(){
       if(session('id')!=""){
$exes=executive::select('id','short_name')
     ->orderBy('short_name','asc')->get();    
$comp=companyinformation::select('id','short_name')->get();
$users=User::select('id','name','login_name','email','mobile')->get();
return view('admin/general/users',['comp'=>$comp,'users'=>$users,'exes'=>$exes]);
}else{
 return redirect('/'); 
}
    }

function editusers($id){
       if(session('id')!=""){
$user=user::find($id); 
$exes=executive::select('id','short_name')
     ->orderBy('short_name','asc')->get(); 
    $ucom=usercompany::where('userid',$id)
             ->select('companyid')->get();
   
 $comp=companyinformation::select('id','short_name')->get();
$users=User::select('id','name','login_name','email','mobile')->get();
return view('admin/general/usersedit',['comp'=>$comp,'users'=>$users,'user'=>$user,'ucom'=>$ucom,'exes'=>$exes]);
}else{
 return redirect('/'); 
}  

}


function createuser(Request $request){
$validator =  $request ->validate([
'name'=>'required',
'login_name'=>'required',
'password'=>'required',
'mobile'=>'required',
'email'=>'required|email'
]);
 $uuser = User::where('login_name',$request->input('login_name'))->count();
 $uuser1 = User::where('email',$request->input('email'))->count();
if($uuser > 0){
$request->session()->flash('failed', 'This login name already exist!');
return redirect('/admin/users');  
}elseif($uuser1 > 0){
$request->session()->flash('failed', 'This email already exist!');
return redirect('/admin/users');
} 
else{
 $user = new User;
 $user->name=$request->name;
 $user->login_name=$request->login_name;
 $user->email=$request->email;
 $user->mobile=$request->mobile;
 $user->manager=$request->manager;
 $user->executive=$request->executive;
 $user->divisiton=$request->division;
 $user->usertype=$request->usertype;
 $user->costvisible=$request->costvisible;
  $user->admin=$request->admin;
  $user->inventory=$request->inventory;
  $user->accounts=$request->accounts;
  $user->hr=$request->hr;
  $user->password =Hash::make($request->password);
    if($user->save()){
$company= $request->input('company');
$count =count($company);
for ($i=0; $i < $count; $i++){
  $cuser = new usercompany;
$cuser->companyid=$company[$i];
$cuser->userid=$user->id;
$cuser->save();

    }
$request->session()->flash('status', 'Data updated successfully!');
return redirect('/admin/users');
	

}
}

}
function editsusers(Request $req){
$validator =  $req ->validate([
'name'=>'required',
'login_name'=>'required',

'mobile'=>'required',
'email'=>'required|email'
]);

  $use =User::where('id', $req->input('id'))
              ->update(['name'=>$req->input('name'),'login_name'=>$req->input('login_name'),'email'=>$req->input('email'),'mobile'=>$req->input('mobile'),'manager'=>$req->input('manager'),'executive'=>$req->input('executive'),'usertype'=>$req->input('usertype'),'costvisible'=>$req->input('costvisible'),'admin'=>$req->input('admin'),'inventory'=>$req->input('inventory'),'hr'=>$req->input('hr'),'accounts'=>$req->input('accounts'),'createdby'=>session('name')]);

 if(isset($use)){
$company= $req->input('company');
$uid = $req->input('uid');
$count =count($company);
for ($i=0; $i < $count; $i++){
$usecom =usercompany::updateOrCreate(['companyid'=>$company[$i],
                  'userid'=>$uid[$i]]);

    }
$req->session()->flash('status', 'Data updated successfully!');
return redirect()->back();

}



}



function finyear(){
    if(session('id')!=""){
 $fyear = finyear::where('defaults','yes')->count();
$years = finyear::all();
  return view('admin/general/finyear',['fyear'=>$fyear,'years'=>$years]);

}
else{
return redirect('/');  
}
}
function editfinyear($id,Request $req){
   if(session('id')!=""){
return $fyear = finyear::find($id);
$years = finyear::all();
  return view('admin/general/finyearedit',['years'=>$years,'fyear'=>$fyear]);

}
else{
return redirect('/');  
}
}

function createfinyear(Request $request){
$validator =  $request ->validate([
'start_date'=>'required',
'end_date'=>'required',
'finyear'=>'required'

]);
 $stardate = Carbon::parse($request->start_date);
 $enddate = Carbon::parse($request->end_date);
$finyear = new finyear;
 $finyear->start_date=$stardate->format('y-m-d');
 $finyear->end_date=$enddate->format('y-m-d');
 $finyear->finyear=$request->finyear;
 $finyear->active=$request->active;
 $finyear->defaults=$request->defaults;
$finyear->save();
$request->session()->flash('status', 'Data updated successfully!');
return redirect('admin/financial-year');

}
function getsumvalue(Request $req){
  $sinv = salesinvoice::leftJoin('executivecommissions', 'salesinvoices.id', '=', 'executivecommissions.inv_id')
        ->where('salesinvoices.is_deleted','!=','1')
          ->where('salesinvoices.is_returned','!=','1')
          ->where('salesinvoices.finyear',session('fyear'))
          ->whereMonth('salesinvoices.dates',$req->month)
         ->select(DB::raw('SUM((salesinvoices.grand_total) -(salesinvoices.sales_commission + salesinvoices.isslnrtn_amt)) AS sin1'),DB::raw('MONTH(salesinvoices.dates) month'),'executivecommissions.executive')
          ->groupBy('executivecommissions.executive','month')
          ->orderBy('executivecommissions.executive','asc')
          ->get();
     $pinv = DB::table('projectinvoices')
                ->select(DB::raw('sum(totalamount)as pinvs'), DB::raw('MONTH(dates) month'),'executive')
                ->where('is_deleted','0')
                ->where('finyear',session('fyear'))
                ->whereMonth('dates',$req->month)
                 ->groupBy('executive','month')
                 ->orderBy('executive','asc')
                ->get();
         $exe =executive::select('short_name')
                    ->orderBy('short_name','asc')->get();        
return view('admin/general/getsumvalue',['sinv'=>$sinv,'pinv'=>$pinv,'exe'=>$exe]);

}
function getallexceprofvalue(Request $req){
  $dates=$req->dates;
   $nddate = Carbon::parse($dates)->format('Y-m-d');
    $sinv =executivecommission::where('is_deleted','!=','1')
        ->where('finyear',session('fyear'))
          ->where('dates','<=',$nddate)
          ->where(function ($query) {
    $query->where('from_where',  'Sinv')
          ->orWhere('from_where', 'salescommission')
          ->orWhere('from_where', 'SRtn');
         })->select(DB::raw('SUM((net_total)-(totcost)) AS sin1'),DB::raw('MONTH(dates) month'),'executive')
          ->groupBy('executive','month')
          ->orderBy('executive','asc')
          ->get();
     // $pinv = DB::table('executivecommissions')
     //            ->select(DB::raw('sum(net_total)as pinvs'), DB::raw('MONTH(dates) month'),'executive')
     //            ->where('is_deleted','0')
     //            ->where('finyear',session('fyear'))
     //            ->where('dates','<=',$nddate)
     //            ->where('from_where',  'ProjInv')
     //             ->groupBy('executive','month')
     //             ->orderBy('executive','asc')
     //            ->get();
         $pinv = DB::table('executives')
        ->leftJoin('executivecommissions', function ($join) use ($nddate) {
            $join->on('executivecommissions.executive', '=', 'executives.short_name')
                ->where('executivecommissions.is_deleted', '=', '0')
                 ->where('executivecommissions.dates', '<=', $nddate)
                ->where('executivecommissions.from_where','ProjInv');
        })->select(DB::raw('sum(executivecommissions.net_total)as pinvs'),'executives.short_name')
        ->groupBy('executives.short_name')
     ->orderBy('executives.short_name','asc')
        ->get();
         $exe =executive::select('short_name')
                    ->orderBy('short_name','asc')->get();
                    $cnt =executive::select('short_name')
                    ->orderBy('short_name','asc')->count();         
return view('admin/general/getallexceprofvalue',['sinv'=>$sinv,'pinv'=>$pinv,'exe'=>$exe,'cnt'=>$cnt]);


}
}
