<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Carbon\Carbon;
use App\Models\voucher;
use App\Models\vouchergeneration;
use App\Models\module;
use App\Models\User;
use App\Models\privilege;
class VoucherController extends Controller
{
    function getvoucher(){
      if(session('id')!=""){
    	 $vouchs=voucher::Join('vouchergenerations',function($join) {
      $join->on('vouchergenerations.voucherid', '=', 'vouchers.id');
    }) ->get();
	$lists= voucher::select('id','heading')
    	->where('category','no_form')
    	->orderBy('heading','ASC')
    	->get();

    	return view('admin/general/voucher',['vouchs'=>$vouchs,'lists'=>$lists]);
    }
    else{
 return redirect('/'); 
}
    }
  function createvouchernumber(Request $req){
    	$vouch =vouchergeneration::updateOrCreate(
  ['voucherid'=>$req->input('voucherid')],
['constants'=>$req->input('constants'),'slno'=>$req->input('slno'),'genvouch'=>$req->input('genvouch'),
'createdby'=>session('name'),'wdate'=>session('wdate'),'finyear'=>session('fyear'),'cmpid'=>session('cmpid')]);
  $req->session()->flash('status', 'Data updated successfully!');
return redirect('/admin/voucher-number');

    }
function vouchernumber(Request $req){
	$vid = $req->get('vid');
$vouch= vouchergeneration::where('voucherid',$vid)->first();
return view('admin/general/voucherview',['vouch'=>$vouch]);
 
}
function getprivilege(){
  if(session('id')!=""){
$mods = module::all();
$users = User::select('login_name','id')->get();
$privs = privilege::Join('vouchers',function($join) {
      $join->on('vouchers.id', '=', 'privileges.pageid');
    })->Join('users',function($joins) {
      $joins->on('users.id', '=', 'privileges.user');
    })->get();
	return view('admin/general/privilege',['mods'=>$mods,'users'=>$users,'privs'=>$privs]);
}else{
 return redirect('/'); 
}
}
function getpage(Request $req){
$pages = voucher::where('module_name','like','%'.$req->vid.'%')->get();
$output = '';
$output = '<option value="" hidden>Page Name</option>';
foreach($pages as $page){

$output .= '<option value="'.$page->id.'">'.$page->heading.'</option>';

 }
 echo $output; 
}
function getprivileges(Request $req){
   $vid = $req->get('vid');
   $vouch=voucher::find($vid);
 $priv= privilege::where('pageid',$vid)->first(); 
 if(!empty($priv)){
$output = '';
$output = '<tbody>
                        <tr>
                         <td>
                          <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input page" style="opacity:1!important;" checked value="'.$priv->pageid.'">'.$priv->pageid.'</label>
                            </div>
                          </td>
                          <td>
                            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input read" checked value="R" >Read</label>
                            </div>
                          </td>
                          <td>
                            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input write" checked value="W">Write</label>
                            </div>
                          </td>
                          <td>
                            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input modify" value="M" checked>Modify</label>
                            </div>
                          </td>
                          <td>
                            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input delete" value="D" checked>Delete</label>
                            </div>
                          </td>
                       
                        </tr>
                        
                      </tbody>';
                 echo $output;
                 } 
                 else{
                  $output = '';
$output = '<tbody>
                        <tr>
                         <td>
                          <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input page" checked 
                                value="'.$vouch->heading.'">'.$vouch->heading.'</label>
                            </div>
                          </td>
                          <td>
                            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input read" checked value="R">Read</label>
                            </div>
                          </td>
                          <td>
                            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input write" checked value="W">Write</label>
                            </div>
                          </td>
                          <td>
                            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input modify" value="M" checked>Modify</label>
                            </div>
                          </td>
                          <td>
                            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input delete" value="D" checked>Delete</label>
                            </div>
                          </td>
                       
                        </tr>
                        
                      </tbody>';
                 echo $output;

                 }
}
function combineprivileges(Request $req){

 $priv=$req->get('priv'); 
$user=$req->get('user'); 
 $users= User::find($user);
$pageget=$req->get('pageget'); 
$page=$req->get('page'); 
$modules=$req->get('modules'); 
$output = '';
$output = '<tr>
<td><input name="user" value="'.$user.'" hidden>'.$users->login_name.'</td>
<td><input name="modules" value="'.$modules.'" hidden>'.$modules.'</td>
<td><input name="pageid" class="pagesid" hidden value="'.$pageget.'">'.$page.'</td>
<td><input name="priv" value="'.$priv.'" hidden>'.$priv.'</td>
</tr>';
echo $output;
}
function createprivilege(Request $req){
$vouch =privilege::updateOrCreate(
  ['pageid'=>$req->input('pageid')],
['module'=>$req->input('modules'),'user'=>$req->input('user'),'privilege'=>$req->input('priv'),
'createdby'=>session('name'),'wdate'=>session('wdate'),'finyear'=>session('fyear'),'cmpid'=>session('cmpid')]);
  $req->session()->flash('status', 'Data updated successfully!');
return redirect('/admin/privilege');
}
}
