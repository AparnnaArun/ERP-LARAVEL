@extends('inventory/layout')
@section ('content')

<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-chart-bar   menu-icon"></i>
                </span>Purchase Return
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
                    <form class="forms-sample" action ="{{('/createprtn')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                   <div class="row">
                   	<div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">PRtn#</span>
                        </div>
                       
                        @if(!empty($voucher->slno) && !empty($voucher->constants))
                        <input type="text" class="form-control"  name="prtn" id="code" value="{{ $voucher->constants }}{{ $nslno }}"  readonly >
                       
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
                          <span class="input-group-text bg-gradient-info text-white ">Date</span>
                        </div>
                        <input type="text" class="form-control datepicker"  name="dates" value="{{ old('dates') }}" required="required" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required add-on">Vendor</span>
                     
                        <select class="form-control vendor mySelect2" placeholder="" name="vendor" required="" >
                          <option value="" hidden>Vendor</option>
                     @foreach($vendor as $cust)
                        <option value="{{$cust->id,old('vendor')}}" >{{$cust->short_name}}</option>
                        @endforeach
                        </select>
                           </div>
                      </div>
                    </div>
                </div>
            </div>
           <div class="row">
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Project Code</span>
                        </div>
                        <select class="form-control " placeholder="" name="project_code"  >
                          <option value="" hidden>Project Code</option>
                     @foreach($pros as $pro)
                        <option value="{{$pro->id,old('project_code')}}" >{{$pro->project_code}}</option>
                        @endforeach
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
                        <select class="form-control" placeholder="" name="currency" required="" >
                          <option value="" hidden>Currency</option>
                     @foreach($curr as $cur)
                        <option value="{{$cur->shortname,old('currency')}}" >{{$cur->shortname}}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">PI #</span>
                        </div>
                        <select class="form-control loadpi" placeholder="" name="pi_no" required="" >
                          <option value="" hidden>PI Number</option>
                   
                        </select>
                      </div>
                    </div>
                </div>
              </div>
           
            
            
                 
                  <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                <div class="table table-responsive">
                    <table class="table table-striped ItemGrid" id="ItemGrid">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Code</th>
                          <th>Item</th>
                          <th>Unit</th>
                          <th>Batch</th>
                           <th> Qnty</th>
                           <th>Rtn Qnty</th>
                           <th>Rate</th>
                           <th>Amount</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>
                  
                </div>
              </div>
              </div>
              <div class="row">
               <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Total Discount</span>
                        </div>
                         <input type="text" class="form-control auto-calc disctotal"  name="discount_total"  value="{{0}}" >
                           
                        
                      </div>
                    </div>
                </div>
                 
                <div class="col-md-4 col-md-offset-0">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Total Qnty</span>
                        </div>
                       <input  class="form-control tqnty" placeholder="" name="tot_qnty" value="{{old('tot_qnty')}}" readony>
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Total Amount</span>
                        </div>
                       <input  class="form-control auto-calc tamount" placeholder="" name="tamount" value="{{old('tamount')}}" readony >
                        
                      </div>
                    </div>
                </div>
                
              </div>
              
              <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Net Total</span>
                        </div>
                       <input  class="form-control auto-calc nettotal" placeholder="" name="nettotal" value="{{old('tamount')}}" readony >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Exchange Rate</span>
                        </div>
                         <input type="text" class="form-control auto-calc erate "  name="erate"  value="{{1}}" >
                           
                        
                      </div>
                    </div>
                </div>

              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Total Amount(KWD)</span>
                        </div>
                         <input type="text" class="form-control auto-calc gridtotal "  name="totalamount"  value="{{old('totals'),0}}" readonly>
                         
                        
                      </div>
                    </div>
                </div>  
                
              </div>
            <div class="row mt-1">
               <div class="col-md-8 col-md-offset-1 ">
            <button type="submit" class="btn btn-gradient-dark btn-rounded btn-fw">Save</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Cancel</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" data-toggle="modal" data-target=".bd-find-modal-lg" >Find</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Delete</button>
            
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
        <h5 class="modal-title" id="companyModalLabel">Purchase Invoice Details</h5>
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
      <th scope="col">Rtn#</th>
      <th scope="col">Date</th>
      <th scope="col">PI#</th>
      <th scope="col">Vendor</th>
  
      </tr>
  </thead>
  <tbody>
   @foreach($datas as $data)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/inventory/purchases-Return/{{$data->id}}">{{$data->prtn}}</a></td>
      <td><a href="/inventory/purchases-Return/{{$data->id}}">{{ \Carbon\Carbon::parse($data->dates)->format('j -F- Y')  }}</a></td>
      <td><a href="/inventory/purchases-Return/{{$data->id}}">{{$data->p_invoice}}</a></td>
      <td><a href="/inventory/purchases-Return/{{$data->id}}">{{$data->vendor}}</a></td>
      
    
       
     
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
 <script src="../../assets/js/jquery-3.6.0.min.js"></script>
 <script type="text/javascript">

//////////////////Load GRN//////////////////
 $(function(){
$(".vendor").change(function(){
               vendor = $(this).val();
               token = $("#token").val();
            //alert(token);
              $.ajax({
         type: "POST",
         url: "{{url('loadpidetails')}}", 
         data: {_token: token,vendor:vendor},
         dataType: "html",  
         success: 
              function(data){
              //alert(data);
                $(".loadpi").html(data);
               
              }
          });
            

                });
});

// //////////ADD TO GRID SECTION ///////////////////////
$('.loadpi').change(function () {
  $('#myalertdiv').hide();
 
        token = $("#token").val();
       
        piid = $('.loadpi').val();
      //alert(piid);
$.ajax({ 
         type: "POST",
         url: "{{url('loadallpi')}}", 
        data: {piid: piid,_token:token},
         dataType: "html",  
         success: 
              function(data){
               alert(data);
                $('#ItemGrid tbody').html(data);

              }
          });
             
}); 
/////////////////Calculation////////////////

 $(document).on('click', '#remove', function(){  
  row = $(this).closest("tr");
   row.remove();
   ntotals = parseFloat($(".tamount").val());
   ttqnty=parseFloat($(".tqnty").val());
   tabqnty =parseFloat(row.find("td input.qnty").val());
   tabamount = parseFloat(row.find("td input.amount").val());
  discss = parseFloat($(".disctotal").val());
   erats = parseFloat($(".erate").val());
  ball = ntotals - tabamount- discss;
   ballx =  erats * ball;
$(".nettotal").val((ball).toFixed(3));
$(".tamount").val((ntotals - tabamount).toFixed(3));
$(".tqnty").val((ttqnty - tabqnty).toFixed(3));
$(".gridtotal").val(ballx.toFixed(3));
});
              </script>
@stop