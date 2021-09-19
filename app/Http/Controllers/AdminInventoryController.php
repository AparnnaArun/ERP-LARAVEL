<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Carbon\Carbon;
use App\Models\brand;
use App\Models\vouchergeneration;
use App\Models\module;
use App\Models\User;
use App\Models\privilege;
use App\Models\businesstype;
use App\Models\currency;
use App\Models\customer;
use App\Models\customerexecutivedetail;
use App\Models\itemcategory;
use App\Models\itemtype;
use App\Models\unit;
use App\Models\itemgroup;
use App\Models\itemmaster;
use App\Imports\ProjectsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\salesrateupdation;
use App\Models\vendor;
use App\Models\account;
use App\Models\employee;
use App\Models\executive;

class AdminInventoryController extends Controller
{
   function getbrand(){
    if(session('id')!=""){
      $brand=brand::all();
    	return view('admin/inventory/brand',['brand'=>$brand]);
    }
   else{
 return redirect('/'); 
}
}
function editbrand($id){
    if(session('id')!=""){
      $brand=brand::all();
      $brnd=brand::find($id);
      return view('admin/inventory/brandedit',['brand'=>$brand,'brnd'=>$brnd]);
    }
   else{
 return redirect('/'); 
}
}

function createbrand(Request $req){
      $validator =  $req ->validate([
'brand'=>'required'
]);
        $brands=$req->brand;
        $description=$req->description;
        $active=$req->active;
        $count =count($brands);
for ($i=0; $i < $count; $i++){
  $bnd =brand::updateOrCreate(
  ['brand'=>$brands[$i]],
  ['description'=>$description[$i],
    'active'=>$active[$i],'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
   }
$req->session()->flash('status', 'Data updated successfully!');
return redirect('/admin/brand');
     }
function editsbrands(Request $req){
  $brnd =brand::where('id', $req->input('id'))
              ->update(['brand'=>$req->input('brand'),'description'=>$req->input('description'),'active'=>$req->input('active'),'cmpid'=>session('cmpid'),
               'finyear'=>session('fyear'),'wdate'=>session('wdate'),
               'createdby'=>session('name')]);
$req->session()->flash('status', 'Data updated successfully!');
return redirect()->back();
}


     function getbtype(){
       if(session('id')!=""){
      $btypes=businesstype::all();
      return view('admin/inventory/businesstype',['btypes'=>$btypes]);
    }
   else{
 return redirect('/'); 
}
}
function editbtype($id){
     if(session('id')!=""){
      $btypes=businesstype::all();
      $btype=businesstype::find($id);
      return view('admin/inventory/businesstypeedit',['btypes'=>$btypes,'btype'=>$btype]);
    }
   else{
 return redirect('/'); 
}
}
function createbusinesstype(Request $req){
            $validator =  $req ->validate([
           'btype'=>'required'
            ]);
        $btype=$req->btype;
        $active=$req->active;
        $count =count($btype);
for ($i=0; $i < $count; $i++){
   $bnd =businesstype::updateOrCreate(
  ['btype'=>$btype[$i]],
  ['active'=>$active[$i],'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
   }
$req->session()->flash('status', 'Data updated successfully!');
return redirect('/admin/business-type');

     }
function editbusinesstype(Request $req){
  businesstype::where('id', $req->input('id'))
              ->update(['btype'=>$req->input('btype'),'active'=>$req->input('active'),
                'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$req->session()->flash('status', 'Data updated successfully!');
return redirect()->back();

}

     function getcurrency(){
           if(session('id')!=""){
      $currencys=currency::all();
      return view('admin/inventory/currency',['currencys'=>$currencys]);
    }
   else{
 return redirect('/'); 
}

     }
     function editcurrency($id){
       if(session('id')!=""){
      $currencys=currency::all();
      $currency=currency::find($id);
      return view('admin/inventory/currencyedit',['currencys'=>$currencys,'currency'=>$currency]);
    }
   else{
 return redirect('/'); 
}

     }
function createcurrency(Request $req){
$validator =  $req ->validate([
'currency'=>'required',
'shortname'=>'required'
        ]);
        $currency=$req->currency;
        $shortname=$req->shortname;
        $decimal=$req->decimal;
        $count =count($currency);
for ($i=0; $i < $count; $i++){
   $curr =currency::updateOrCreate(
  ['currency'=>$currency[$i]],
  ['shortname'=>$shortname[$i],'decimal'=>$decimal[$i],'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
   }
$req->session()->flash('status', 'Data updated successfully!');
return redirect('/admin/currency');  
}

function editscurrencys(Request $req){
  currency::where('id', $req->input('id'))
              ->update(['currency'=>$req->input('currency'),'shortname'=>$req->input('shortname'),'decimal'=>$req->input('decimal'),
                'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$req->session()->flash('status', 'Data updated successfully!');
return redirect()->back();

}
function getcustomer(){
          if(session('id')!=""){
       $btypes=businesstype::select('id','btype')
             ->where('active','1')
              ->get();
        $custs =customer::orderBy('name','Asc')->get();
        $allaccounts = account::select('printname','id')
                   ->where('accounttype','a1')
                   ->where('active','1')
                   ->orderBy('printname','Asc')->get();
        $accounts = account::select('printname','id')
                   ->where('accounttype','s1')
                   ->where('id',8)
                   ->orderBy('printname','Asc')->get();
                   $acccat ='debtor';
                   $status ='acccust';
         $accid = account::select('id')
                 ->orderBy('id','Desc')->take(1)->first();
                 $exe =executive::orderBy('short_name','asc')->get();
      return view('admin/inventory/customer',['btypes'=>$btypes,'accounts'=>$accounts,'accid'=>$accid,'allaccounts'=>$allaccounts,'acccat'=>$acccat,'status'=>$status,'custs'=>$custs,'exe'=>$exe]);
    }
   else{
 return redirect('/'); 
} 
}
function createcustomer(Request $req){
     $validator =  $req ->validate([
'printname'=>'required|unique:accounts'],
  [   
      'printname.unique'      => 'Sorry, This account is  taken. Please Try With Different One, Thank You.'
      
        ]);
  $customer =customer::updateOrCreate(
  ['name'=>$req->input('name'),'short_name'=>$req->input('short_name'),],
['account'=>$req->input('printname'),'phone'=>$req->input('phone'),'email'=>$req->input('email'),'fax'=>$req->input('fax'),'address'=>$req->input('address'),'active'=>$req->input('active'),'approve'=>$req->input('approve'),
'businesstype'=>$req->input('businesstype'),'ratetype'=>$req->input('ratetype'),'creditlimit'=>$req->input('creditlimit'),'creditdays'=>$req->input('creditdays'),'taxapplicable'=>$req->input('taxapplicable'),'website'=>$req->input('website'),'taxexempted'=>$req->input('taxexempted'),'customerstatus'=>$req->input('customerstatus'),'contactperson'=>$req->input('contactperson'),'designation'=>$req->input('designation'),'cpersonphone'=>$req->input('cpersonphone'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name'),'specialprice'=>$req->input('specialprice')]);
  if($customer){
      $executive=$req->executive;
        $count =count($executive);
for ($i=0; $i < $count; $i++){

customerexecutivedetail::updateOrCreate(['customerid'=>$customer->id,'executive'=>$executive[$i],],
['cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);

  }
}
  $req->session()->flash('status', 'Data updated successfully!');
return redirect('/admin/customer-details');
}
function getexecutive(){
         if(session('id')!=""){
       $btypes=businesstype::select('id','btype')
             ->where('active','1')
              ->get();
      $accounts = account::select('printname','id')
                   ->where('accounttype','s1')
                   ->whereIn('id',array(64,310))
                   ->orderBy('printname','Asc')->get();
         $accid = account::select('id')
                 ->orderBy('id','Desc')->take(1)->first();
        $allaccounts = account::select('printname','id')
                   ->where('accounttype','a1')
                   ->where('active','1')
                   ->whereIn('parentid',array(64, 310))
                   ->orderBy('printname','Asc')->get();
                    $acccat ='others';
                   $status ='accexce';
         $emplo = employee::where('approve','1')->get(); 
         $datas = executive::leftJoin('employees', function($join) {
      $join->on('employees.id', '=', 'executives.executive');
         })->select('executives.*','employees.name')
->orderBy('employees.name','asc')
          ->get();         
      return view('admin/inventory/executive',['btypes'=>$btypes,'accounts'=>$accounts,'accid'=>$accid,'allaccounts'=>$allaccounts,'acccat'=>$acccat,'status'=>$status,'emplo'=>$emplo,'datas'=>$datas]);
    }
   else{
 return redirect('/'); 
}  
}
function getitemcategory(){
   if(session('id')!=""){
$types = itemtype::all();
$category = itemcategory::orderBy('category','Asc')->get();
    return view('admin/inventory/itemcategory',['types'=>$types,'category'=>$category]);
    }
   else{
 return redirect('/'); 
}  
}
function edititemcategory($id){
   if(session('id')!=""){
$types = itemtype::all();
$category = itemcategory::orderBy('category','Asc')->get();
$cat = itemcategory::find($id);
    return view('admin/inventory/itemcategoryedit',['types'=>$types,'category'=>$category,'cat'=>$cat]);
    }
   else{
 return redirect('/'); 
}   
}


function createcategory(Request $req){
$validator =  $req ->validate([
'category'=>'required',
'itemtype'=>'required'
        ]);
        $category=$req->category;
        $itemtype=$req->itemtype;
        $active=$req->active;
        $count =count($category);
for ($i=0; $i < $count; $i++){
   $curr =itemcategory::updateOrCreate(
  ['category'=>$category[$i]],
  ['itemtype'=>$itemtype[$i],'active'=>$active[$i],'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
   }
$req->session()->flash('status', 'Data updated successfully!');
return redirect('/admin/item-category'); 

}
function editscategorys(Request $req){
 itemcategory::where('id', $req->input('id'))
              ->update(['category'=>$req->input('category'),'itemtype'=>$req->input('itemtype'),'active'=>$req->input('active'),
                'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$req->session()->flash('status', 'Data updated successfully!');
return redirect()->back();

}
function getunit(){
   if(session('id')!=""){

$unit= unit::orderBy('unit','Asc')->get();
    return view('admin/inventory/unit',['unit'=>$unit]);
    }
   else{
 return redirect('/'); 
}  
}
function editunit($id){
    if(session('id')!=""){
$un= unit::find($id);
$unit= unit::orderBy('unit','Asc')->get();
    return view('admin/inventory/editunit',['unit'=>$unit,'un'=>$un]);
    }
   else{
 return redirect('/'); 
} 
}
function createunit(Request $req){
$validator =  $req ->validate([
'unit'=>'required',
'shortname'=>'required'
        ]);
        $units=$req->unit;
        $shortname=$req->shortname;
        $active=$req->active;
        $count =count($units);
for ($i=0; $i < $count; $i++){
    $unit =unit::updateOrCreate(
  ['shortname'=>$shortname[$i]],
  ['unit'=>$units[$i],'active'=>$active[$i],'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
   }
$req->session()->flash('status', 'Data updated successfully!');
return redirect('/admin/unit');  
}
function editsunits(Request $req){
unit::where('id', $req->input('id'))
              ->update(['shortname'=>$req->input('shortname'),'unit'=>$req->input('unit'),'active'=>$req->input('active'),
                'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$req->session()->flash('status', 'Data updated successfully!');
return redirect()->back();



}
function getgroup(){
    if(session('id')!=""){
$types = itemtype::all();
$groups = itemgroup::all();
$units = unit::where('active','1')->get();
    return view('admin/inventory/itemgroup',['groups'=>$groups,'types'=>$types,'units'=>$units]);
    }
   else{
 return redirect('/'); 
} 
}
function editgroup($id){
    if(session('id')!=""){
$types = itemtype::all();
$groups = itemgroup::all();
$grp = itemgroup::find($id);
$units = unit::where('active','1')->get();
    return view('admin/inventory/itemgroupedit',['groups'=>$groups,'types'=>$types,'units'=>$units,'grp'=>$grp]);
    }
   else{
 return redirect('/'); 
}
}
function creategroup(Request $req){
$validator =  $req ->validate([
'group'=>'required'
        ]);
        $groups=$req->group;
        $units=$req->unit;
        $itemtype=$req->itemtype;
        $active=$req->active;
        $count =count($groups);
for ($i=0; $i < $count; $i++){
    $unit =itemgroup::updateOrCreate(
  ['group'=>$groups[$i]],
  ['unit'=>$units[$i],'itemtype'=>$itemtype[$i],'active'=>$active[$i],'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
   }
$req->session()->flash('status', 'Data updated successfully!');
return redirect('/admin/item-group');
}
function editsgroups(Request $req){
itemgroup::where('id', $req->input('id'))
              ->update(['group'=>$req->input('group'),'unit'=>$req->input('unit'),'itemtype'=>$req->input('itemtype'),'active'=>$req->input('active'),
                'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
$req->session()->flash('status', 'Data updated successfully!');
return redirect()->back();

}
function getitemmaster(){
     if(session('id')!=""){
$brands = brand::where('active','1')->orderBy('brand','Asc')->get();
$groups = itemgroup::where('active','1')->orderBy('group','Asc')->get();
$units = unit::where('active','1')->orderBy('shortname','Asc')->get();
$category = itemcategory::where('active','1')->get();
$items = itemmaster::leftJoin('itemcategories', function($join) {
      $join->on('itemmasters.category', '=', 'itemcategories.id');
         })
      ->orderBy('code','Asc')->get();
       $slo = itemmaster::select('slno')
      ->wherenotNull('slno')->orderBy('id','Desc')->take(1)->first();
     $nslno =$slo->slno + 1;
    return view('admin/inventory/itemmaster',['groups'=>$groups,'brands'=>$brands,'units'=>$units,'category'=>$category,'items'=>$items,'nslno'=>$nslno]);
    }
   else{
 return redirect('/'); 
} 
}
function getlocalcode(){
   $sllo = itemmaster::select('localslno')
      ->wherenotNull('localslno')
      ->where('localslno','!=','0')->orderBy('id','Desc')->take(1)->first();
      $nlslno =$sllo->localslno + 1;
      $nllslno ='LI'.$nlslno;
     
$output ="";
$output .='<div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Code</span>
                        </div>
                        <input type="text" class="form-control code" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="code" id="code" value="'.$nllslno.'"  readonly="readonly" >

                         <input type="hidden" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="localslno" value="'.$nlslno.'"  readonly="readonly" id="">
                        <div class="input-group-append">
                          <span class="input-group-text">
                           Is Local<input type="checkbox" class="form-check-input mb-1" name="islocal" id="islocal"   value="1"  checked> </span>
                           </div>
                        </div>
                      </div>';
                      echo $output;
}
function createitem(Request $req){
  $validator =  $req ->validate([
'part_no'=>'nullable|unique:itemmasters',
'item'=>'required|unique:itemmasters'],
  [   
      'part_no.unique'      => 'Sorry, This Part Number Is Already Used In Another Item. Please Try With Different One, Thank You.',
       'item.unique'      => 'Sorry, This Item  Is Already Use. Please Try With Different One, Thank You.'
        ]);
 $item =itemmaster::updateOrCreate(
  ['code'=>$req->input('code')],
['item'=>$req->input('item'),'slno'=>$req->input('slno'),'localslno'=>$req->input('localslno'),'is_local'=>$req->input('islocal'),'description'=>$req->input('description'),'item_type'=>$req->input('itemtype'),'active'=>$req->input('active'),'brand'=>$req->input('brand'),'category'=>$req->input('category'),'item_group'=>$req->input('group'),'basic_unit'=>$req->input('unit'),'basic_unit_ratio'=>$req->input('basic_unit_ratio'),'alt_unit'=>$req->input('altunit'),'alt_unit_ratio'=>$req->input('alt_unit_ratio'),'alt_unit1'=>$req->input('alt_unit1'),'alt_unit1_ratio'=>$req->input('alt_unit1_ratio'),'business_item'=>$req->input('business_item'),'criticality'=>$req->input('criticality'),'cost'=>$req->input('cost'),'part_no'=>$req->input('part_no'),'costing_method'=>$req->input('costing_method'),'batch_wise'=>$req->input('batch_wise'),'exp_applicable'=>$req->input('exp_applicable'),'minimum_stock'=>$req->input('minstock'),'reorder_level'=>$req->input('reorder_level'),'maximum_stock'=>$req->input('maximum_stock'),
'automatic_reorder_level'=>$req->input('automatic_reorder_level'),'intervals'=>$req->input('intervals'),'reordering_quantity_days'=>$req->input('reordering_quantity_days'),'demand'=>$req->input('demand'),'no_days'=>$req->input('no_days'),'buffer_stock'=>$req->input('buffer_stock'),'purchase_account'=>$req->input('purchase_account'),'sales_account'=>$req->input('sales_account'),'purchasereturn_account'=>$req->input('purchasereturn_account'),'salesreturn_account'=>$req->input('salesreturn_account'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name')]);
  $req->session()->flash('status', 'Data updated successfully!');
return redirect('/admin/item-master');

}
function getitembulk(){
     if(session('id')!=""){

    return view('admin/inventory/itembulk');
    }
   else{
 return redirect('/'); 
} 
}
function createitembulk () 
    {
        Excel::import(new ProjectsImport,request()->file('file'));
             
        return back()->with('success',"Your task was successfull");
    }
    function getsalesrate(){
         if(session('id')!=""){
$cats=itemcategory::orderBy('category','Asc')->get();
    return view('admin/inventory/salesrate',['cats'=>$cats]);
    }
   else{
 return redirect('/'); 
} 

    }
    function getssalesrate(Request $req){
      $vid = $req->get('vid');
          $items = itemmaster::leftJoin('salesrateupdations', function($join) {
      $join->on('itemmasters.id', '=', 'salesrateupdations.item_id');
         })
     ->where('itemmasters.category',$vid)
     ->select('itemmasters.id as itemid','itemmasters.code as code','itemmasters.item as item','itemmasters.cost as cost','salesrateupdations.retail_salesrate as rsrate','salesrateupdations.wholesale_salesrate as wsrate','salesrateupdations.dealer_salesrate as dsrate',)
      ->orderBy('itemmasters.code','Asc')->get();



      return view('admin/inventory/salesrateview',['items'=>$items]);

    }
    function createsalesrate(Request $req){
       $validator =  $req ->validate([
'items'=>'required']);
       $date =$req->input('dates');
       $ndate = Carbon::parse($date)->format('Y-m-d');
       $item_id=$req->itemid;
        $items=$req->items;
        $cost=$req->cost;
        $rsrate=$req->rsrate;
        $wsrate=$req->wsrate;
        $dsrate=$req->dsrate;
        $count =count($item_id);
for ($i=0; $i < $count; $i++){
  if(!empty($rsrate)){
$salesrate =salesrateupdation::updateOrCreate(
  ['item_id'=>$item_id[$i]],
['item'=>$items[$i],'retail_salesrate'=>$rsrate[$i],'wholesale_salesrate'=>$wsrate[$i],'dealer_salesrate'=>$dsrate[$i],'category'=>$req->input('category'),'date'=>$ndate,'cmpid'=>session('cmpid'),
  'finyear'=>session('fyear'),'wdate'=>session('wdate'),
  'createdby'=>session('name')]);
itemmaster::where('id', $item_id[$i])
          ->update(['cost' => $cost[$i]]);
        }
    }
    $req->session()->flash('status', 'Data updated successfully!');
return redirect('/admin/sales-rate-updation');
  }
  function getvendor(){
          if(session('id')!=""){
$btypes=businesstype::orderBy('btype','Asc')->get();
$vendors=vendor::orderBy('vendor','Asc')->get();
 $accounts = account::select('printname','id')
                   ->where('accounttype','s1')
                   ->where('id','15')
                   ->orderBy('printname','Asc')->get();
         $accid = account::select('id')
                 ->orderBy('id','Desc')->take(1)->first();
        $allaccounts = account::select('printname','id')
                   ->where('accounttype','a1')
                   ->where('active','1')
                   ->where('parentid','15')
                   ->orderBy('printname','Asc')->get();
                    $acccat ='creditor';
                   $status ='accvend';
    return view('admin/inventory/vendor',['btypes'=>$btypes,'vendors'=>$vendors,'accounts'=>$accounts,'accid'=>$accid,'allaccounts'=>$allaccounts,'acccat'=>$acccat,'status'=>$status]);
    }
   else{
 return redirect('/'); 
} 
  }

  function editvendor($id){
          if(session('id')!=""){
            $vend= vendor::leftJoin('accounts', function($join) {
      $join->on('vendors.account', '=', 'accounts.id');
         })->where('vendors.id',$id)
            ->select('vendors.*','accounts.printname')->first();

          
  $btypes = businesstype::orderBy('btype','Asc')->get();
  $vendors = vendor::orderBy('vendor','Asc')->get();
  $accounts = account::select('printname','id')
                   ->where('accounttype','s1')
                   ->where('id','15')
                   ->orderBy('printname','Asc')->get();
  $accid = account::select('id')
                   ->orderBy('id','Desc')->take(1)->first();
  $allaccounts = account::select('printname','id')
                   ->where('accounttype','a1')
                   ->where('active','1')
                   ->where('parentid','15')
                   ->orderBy('printname','Asc')->get();
                    $acccat ='creditor';
                   $status ='accvend';
  return view('admin/inventory/vendoredit',['btypes'=>$btypes,'vendors'=>$vendors,'allaccounts'=>$allaccounts,'vend'=>$vend,'accounts'=>$accounts,'accid'=>$accid,'acccat'=>$acccat,'status'=>$status]);
    }
   else{
 return redirect('/'); 
}

  }





  function createvendor(Request $req){
    $vendor =vendor::updateOrCreate(
  ['short_name'=>$req->input('short_name'),'account'=>$req->input('account'),],
['vendor'=>$req->input('vendor'),'active'=>$req->input('active'),'approve'=>$req->input('approve'),'address'=>$req->input('address'),'business_type'=>$req->input('business_type'),'contact_person'=>$req->input('contact_person'),
'designation'=>$req->input('designation'),'lead_time'=>$req->input('lead_time'),'email'=>$req->input('email'),'tax_applicable'=>$req->input('tax_applicable'),'credit_limit'=>$req->input('credit_limit'),'credit_days'=>$req->input('credit_days'),'phone'=>$req->input('phone'),'fax'=>$req->input('fax'),'website'=>$req->input('website'),'tax_exempted'=>$req->input('tax_exempted'),'exciseduty_applicable'=>$req->input('exciseduty_applicable'),'contract_date'=>$req->input('contract_date'),'security_deposit'=>$req->input('security_deposit'),'termsand_conditions'=>$req->input('termsand_conditions'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name') ]);
     $req->session()->flash('status', 'Data updated successfully!');
return redirect('/admin/vendor');
  }
function editsvendors(Request $req){
   $vendor =vendor::where('id', $req->input('id'))
              ->update(
  ['vendor'=>$req->input('vendor'),'active'=>$req->input('active'),'approve'=>$req->input('approve'),'address'=>$req->input('address'),'business_type'=>$req->input('business_type'),'contact_person'=>$req->input('contact_person'),
'designation'=>$req->input('designation'),'lead_time'=>$req->input('lead_time'),'email'=>$req->input('email'),'tax_applicable'=>$req->input('tax_applicable'),'credit_limit'=>$req->input('credit_limit'),'credit_days'=>$req->input('credit_days'),'phone'=>$req->input('phone'),'fax'=>$req->input('fax'),'website'=>$req->input('website'),'tax_exempted'=>$req->input('tax_exempted'),'exciseduty_applicable'=>$req->input('exciseduty_applicable'),'contract_date'=>$req->input('contract_date'),'security_deposit'=>$req->input('security_deposit'),'termsand_conditions'=>$req->input('termsand_conditions'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name') ]);
    $req->session()->flash('status', 'Data updated successfully!');
return redirect()->back();
}


  function getexedetails(Request $req){
$exce = $req->get('exce');
$emp =employee::leftJoin('accounts', function($join) {
      $join->on('employees.accname', '=', 'accounts.id');
         })->where('employees.id',$exce)->first();

return view('admin/inventory/getexedetails',['emp'=>$emp]);


  }
  function createexecutives(Request $req){
     $validator =  $req ->validate([
'short_name'=>'required'],
  [   
      'short_name.unique'      => 'Sorry, This name is  taken. Please Try With Different One, Thank You.'
      
        ]);

$exce =executive::updateOrCreate(
  ['executive'=>$req->input('executive'),],
['short_name'=>$req->input('short_name'),'account'=>$req->input('account'),'commission_percentage'=>$req->input('commpercent'),'active'=>$req->input('active'),'is_commissioned'=>$req->input('iscomm'),'comm_pay_account'=>$req->input('commpay'),'exe_com_exp_ac'=>$req->input('commexp'),'cmpid'=>session('cmpid'),'finyear'=>session('fyear'),'wdate'=>session('wdate'),'createdby'=>session('name') ]);
     $req->session()->flash('status', 'Data updated successfully!');
return redirect('/admin/executive');

  }
  function editexecutive(Request $req,$id){
         if(session('id')!=""){
       $btypes=businesstype::select('id','btype')
             ->where('active','1')
              ->get();
      $accounts = account::select('printname','id')
                   ->where('accounttype','s1')
                   ->whereIn('id',array(64,310))
                   ->orderBy('printname','Asc')->get();
         $accid = account::select('id')
                 ->orderBy('id','Desc')->take(1)->first();
        $allaccounts = account::select('printname','id')
                   ->where('accounttype','a1')
                   ->where('active','1')
                   ->whereIn('parentid',array(64, 310))
                   ->orderBy('printname','Asc')->get();
                    $acccat ='others';
                   $status ='accexce';
         $emplo = employee::where('approve','1')->get(); 
         $datas = executive::leftJoin('employees', function($join) {
      $join->on('employees.id', '=', 'executives.executive');
         })->select('executives.*','employees.name')
->orderBy('employees.name','asc')
          ->get(); 
      $exe =executive::find($id);            
      return view('admin/inventory/executiveedit',['btypes'=>$btypes,'accounts'=>$accounts,'accid'=>$accid,'allaccounts'=>$allaccounts,'acccat'=>$acccat,'status'=>$status,'emplo'=>$emplo,'datas'=>$datas,'exe'=>$exe]);
    }
   else{
 return redirect('/'); 
}  
}
function editcustomer(Request $req,$id){
          if(session('id')!=""){
       $btypes=businesstype::select('id','btype')
             ->where('active','1')
              ->get();
        $custs =customer::orderBy('name','Asc')->get();
        $allaccounts = account::select('printname','id')
                   ->where('accounttype','a1')
                   ->where('active','1')
                   ->orderBy('printname','Asc')->get();
        $accounts = account::select('printname','id')
                   ->where('accounttype','s1')
                   ->where('id',8)
                   ->orderBy('printname','Asc')->get();
                   $acccat ='debtor';
                   $status ='acccust';
         $accid = account::select('id')
                 ->orderBy('id','Desc')->take(1)->first();
        $exe =executive::orderBy('short_name','asc')->get();
        $cus =customer::find($id);
        $cusex =customerexecutivedetail::where('customerid',$id)->get();
      return view('admin/inventory/editcustomer',['btypes'=>$btypes,'accounts'=>$accounts,'accid'=>$accid,'allaccounts'=>$allaccounts,'acccat'=>$acccat,'status'=>$status,'custs'=>$custs,'exe'=>$exe,'cus'=>$cus,'cusex'=>$cusex]);
    }
   else{
 return redirect('/'); 
} 
}
function deletecustexe($id,Request $req){

 $ee= customerexecutivedetail::find($id);
 $ee->delete(); 
 $req->session()->flash('status', 'Data deleted successfully!');
return redirect()->back();  
}
function edititemmaster(Request $req,$id){
     if(session('id')!=""){
$brands = brand::where('active','1')->orderBy('brand','Asc')->get();
$groups = itemgroup::where('active','1')->orderBy('group','Asc')->get();
$units = unit::where('active','1')->orderBy('shortname','Asc')->get();
$category = itemcategory::where('active','1')->get();
$items = itemmaster::leftJoin('itemcategories', function($join) {
      $join->on('itemmasters.category', '=', 'itemcategories.id');
         })
      ->orderBy('code','Asc')->get();
       $item = itemmaster::find($id);

    return view('admin/inventory/itemmasteredit',['groups'=>$groups,'brands'=>$brands,'units'=>$units,'category'=>$category,'items'=>$items,'item'=>$item]);
    }
   else{
 return redirect('/'); 
} 
}
}
