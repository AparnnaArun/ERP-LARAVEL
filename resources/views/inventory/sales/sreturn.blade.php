@extends('inventory/layout')
@section ('content')
@include('inventory.newcustomer')
@include('inventory.additem')
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-file-chart  menu-icon"></i>
                </span>Sales Return
              </h3>
              
            </div>
            <div class="col-md-12 grid-margin stretch-card">
  <div class="card">
                                                        @if (session('status'))
<div class="alert alert-success" role="alert">
  <button type="button" class="close" data-dismiss="alert">×</button>
  {{ session('status') }}
</div>
@elseif(session('failed'))
<div class="alert alert-danger" role="alert">
  <button type="button" class="close" data-dismiss="alert">×</button>
  {{ session('failed') }}
</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
      <button type="button" class="close" data-dismiss="alert">×</button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                  <div class="card-body">
                    <h4 class="card-title"></h4>
                    <form class="forms-sample" action ="{{('/createsreturn')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" class="token" value="{{ csrf_token() }}" id="token"/>
                   <div class="row">
                   	<div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Rtn#</span>
                        </div>
                       @if(!empty($voucher->constants))
                        <input type="text" class="form-control"  name="rtn_no" id="code" value="{{ $voucher->constants }}{{ $nslno }}"  readonly >
                       
                        <input type="hidden" class="form-control"  name="slno" id="code" value="{{ $nslno }} "  readonly >
                       @else
                       <input type="text" class="form-control"  name="" id="code" value=""  readonly >
                          @endif
                           </div>
                        </div>
                      </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Rtn Date</span>
                        </div>
                        <input type="text" class="form-control datepicker" aria-label="Amount (to the nearest dollar)" name="rtndate" value="{{ old('rtndate') }}" required="required" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4" id="podiv">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Location </span>
                        </div>
                        
                        <select class="form-control "  name="location" required="" id="">
                          
                     @foreach($store as $sto)
                        <option value="{{$sto->id,old('location')}}" >{{$sto->locationname}}</option>
                        @endforeach
                        </select>
                          
                     
                      </div>
                    </div>
                </div>
            </div>
           <div class="row">
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Customer</span>
                        </div>
                        <select class="form-control "  name="customer_id" required="" id="customer">
                          <option value="" hidden>Customer</option>
                     @foreach($customer as $cust)
                        <option value="{{$cust->id,old('customer_id')}}" >{{$cust->short_name}}</option>
                        @endforeach
                        </select>
                        
                      </div>
                    </div>
                </div>
                   	<div class="col-md-4 invdet">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Invoice #</span>
                        </div>
                       <select class="form-control invoiceno"  name="salesid" >
                        </select>
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Currency</span>
                        </div>
                        <select class="form-control "  name="currency" required="" >
                          
                     @foreach($currency as $cur)
                        <option value="{{$cur->shortname,old('currency')}}" >{{$cur->shortname}}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>
                </div>
              </div>
              <div class="row exeload">
                
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Executive</span>
                        </div>
                        <input type="text" class="form-control "  name="executive"  value="{{old('executive')}}" readonly>
                      </div>
                    </div>
                </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Sales Date</span>
                        </div>
                         <input type="text" class="form-control "  name="salesdate"  value="{{old('ship_to')}}" readonly>
                           
                        
                      </div>
                    </div>
                </div>
                
                <div class="col-md-2">
                   
                <label class="form-check-label">Payment Mode</label>
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input"   name="" value='cash'> Cash </label>
                            </div>
            
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input " name="" checked   value="credit"  > Credit </label>
                            </div>
           
           
                             
                </div>

              </div>
             <div class="col-md-1 poppup">
                              
                
                 </div>
                 
                 
                  <div class="row doGrid">
                <div class="col-lg-12 grid-margin stretch-card">
                <div class="table table-responsive">
                    <table class="table table-striped ItemGrid" id="ItemGrid">
                      <thead>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Item</th>
                            <th>Unit</th>
                            <th>Inv Bal Qnty</th>
                            <th>Inv Free Qnty</th>
                            <th>Rtn Qnty</th>
                            <th>Rtn Free Qnty</th>
                            <th>Damage</th>
                            <th>Rate</th>
                            <th>Discount</th>
                            <th>Total</th>
                            <th></th>
                          
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>
                  
                </div>
              </div>
              </div>
               <div class="row" >
                <div class="col-md-12">
                <table class="table table-striped stocktable" id="stocktable" style="display: none;" >
                      <thead>
                       
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>
              </div>
            </div>
              
              <div class="row">
              
                  
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Total Discount</span>
                        </div>
                         <input type="text" class="form-control auto-cal disctotal"  name="discount_total"  value="{{0}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Exchange Rate</span>
                        </div>
                         <input type="text" class="form-control auto-cal erate "  name="erate"  value="{{1}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Total Amount</span>
                        </div>
                         <input type="text" class="form-control auto-cal gridtotal "  name="total"  value="{{old('total'),0}}" readonly>
                          <input type="hidden" class="form-control auto-cal totalcost "  name="totcosts"  value="{{old('totcosts'),0}}" readonly> 
                        
                      </div>
                    </div>
                </div>
              </div>
              <div class="row">
              
                  
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Tax</span>
                        </div>
                         <input type="text" class="form-control auto-cal tax"  name="tax"  value="{{0}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Freight</span>
                        </div>
                         <input type="text" class="form-control auto-cal freight"  name="freight"  value="{{0}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> PF</span>
                        </div>
                         <input type="text" class="form-control auto-cal pf "  name="pf"  value="{{0}}" >
                           
                        
                      </div>
                    </div>
                </div>
              </div>
              <div class="row">
              
                  
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Insurance</span>
                        </div>
                         <input type="text" class="form-control auto-cal insurance"  name="insurance"  value="{{0}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Others </span>
                        </div>
                         <input type="text" class="form-control auto-cal others"  name="others"  value="{{0}}" >
                           
                        
                      </div>
                    </div>
                </div>
                 <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Net Total</span>
                        </div>
                         <input type="text" class="form-control auto-cal  nettotal"  name="net_total"  value="{{old('net_total'),0}}" readonly>
                           
                        
                      </div>
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white  ">Delivery Info</span>
                        </div>
                        <textarea class="form-control "  name="deli_info"  >
                          Ex Stocks
                        </textarea>
                      </div>
                    </div>
                </div> 
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white  ">Payment Info</span>
                        </div>
                        <textarea class="form-control "  name="payment_terms" >
                          Payment on delivery.
                        </textarea>
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white  ">Vehicle Details</span>
                        </div>
                        <textarea class="form-control "  name="vehicle_details" >
                           15 Days validity

                        </textarea>
                      </div>
                    </div>
                </div>
               
                
              </div>
              
          
            
                      
        <div class="row mt-1">
               <div class="col-md-8 col-md-offset-1 ">
            <button type="submit" class="btn btn-gradient-dark btn-rounded btn-fw">Save</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Cancel</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" data-toggle="modal" data-target=".bd-find-modal-lg" >Find</button>
            <a href="#" type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Delete</a>
            @if (session('status'))
             <a href="{{url('printreturn')}}" type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Print</a>
             @endif
          </div>
        </div>
                    
                  
                </form>
                </div>
                </div>
              </div>

              <!-- /////////////////////// POPUP FOR FIND BUTTON ////////////////////////  --> 
  <div class="modal fade bd-find-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="companyModalLabel">Sales Return Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                   
                   <table class="table table-bordered findtable" id="findtable">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Rtn Date</th>
      <th scope="col">Rtn #</th>
      <th scope="col">Customer</th>
      <th scope="col">Invoice #</th>
      <th scope="col">Net Amount</th>
      
    
    </tr>
  </thead>
  <tbody>
    @foreach($datas as $data)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      
      <td><a href="/inventory/sreturn-edit/{{$data->id}}">{{ \Carbon\Carbon::parse($data->rtndate)->format('j -F- Y') }}</a></td>
      <td><a href="/inventory/sreturn-edit/{{$data->id}}">{{$data->rtn_no}}</a></td>
      <td><a href="/inventory/sreturn-edit/{{$data->id}}">{{$data->name}}</a></td>
    <td><a href="/inventory/sreturn-edit/{{$data->id}}">{{$data->invoice_no}}</a></td>
    <td><a href="/inventory/sreturn-edit/{{$data->id}}">{{$data->net_total}}</a></td>
    
     
    </tr>
   @endforeach
  </tbody>
</table>
                  </div>
                </div>
              </div>      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
              </div>
    </div>
  </div>
</div>
<!-- ///////Js Start here//////////////////// -->
 <script type="text/javascript">


// //////////ADD TO GRID SECTION ///////////////////////
 $(document).on("keyup change paste", ".auto-cal", function() {
   var total =$(".gridtotal").val();
   var disc = $(".disctotal").val();
   var erate = $(".erate").val();
   var tax =parseFloat($(".tax").val());
   var pf = parseFloat($(".pf").val());
   var insurance =parseFloat($(".insurance").val());
   var freight = parseFloat($(".freight").val());
   var others = parseFloat($(".others").val());
   var nettotals = total-disc;
   var afrrate = erate*nettotals;
   var othramt = tax + insurance + freight + others + pf;
   var all = afrrate +  othramt;
   $(".nettotal").val(all.toFixed(3));
 });
////////////////Enquiry Radio MENU /////////////////
$("#customer").change(function(){
 customer =$("#customer").val();
  token = $("#token").val();
 $.ajax({ 
         type: "POST",
         url: "{{url('getinvoice')}}", 
        data: {customer: customer,_token:token},
         dataType: "html",  
         success: 
              function(data){
                //alert(data);
               $('.invdet').html(data);
              
                           }
          });


    });
///////////////// Grid item to remove/////////////////////
$(document).on('click', '#remove', function(){  
  row = $(this).closest("tr");
   row.remove();
   item_id = row.find("th input.doitemid").val();
   ntotals = parseFloat($(".gridtotal").val());
   costtotals = parseFloat($(".totalcost").val());
   tabamount = parseFloat(row.find("td input.salammmt").val());
   tabcost = parseFloat(row.find("td input.costammmt").val());
   discss = parseFloat($(".disctotal").val());
   erats = parseFloat($(".erate").val());
   taxs = parseFloat($(".tax").val());
   freights = parseFloat($(".freight").val());
   insurances =parseFloat( $(".insurance").val());
   pfs = parseFloat($(".pf").val());
   otherss = parseFloat($(".others").val());
   alls =pfs + insurances + freights + otherss + taxs;
   ball = ntotals - tabamount- discss;
   ballx =  erats * ball;
   allbalss =  ballx + alls;
$(".gridtotal").val((ntotals - tabamount).toFixed(3));
$(".totalcost").val((costtotals - tabcost).toFixed(3));
$(".nettotal").val(allbalss.toFixed(3));
$(".stocktable tr").each(function(){
       $(this).find('td input.idid').each(function(){
          var currentText = $(this).val();
 if(currentText == item_id){
              $(this).parents('tr').remove();
          }
      });
   });
   });
              </script>
@stop