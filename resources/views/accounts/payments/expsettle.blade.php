@extends('accounts/layout')
@section ('content')

<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-table menu-icon"></i>
                </span>Project Expense Settlement
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
                    <form class="forms-sample" action ="{{('/createsettlement')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                        <input type="hidden" name="id" value="" id="id"/>
                   <div class="row">
                    <div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Settle#</span>
                        </div>
                        <input type="text" class="form-control"  name="settle_no"  value="{{'Exp/Stl - '.$nslno}}">
                        <input type="hidden" class="form-control"  name="slno"  value="{{$nslno}}"   >
                         
                           </div>
                        </div>
                      </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Date</span>
                        </div>
                        <input type="text" class="form-control datepicker"  name="dates" value="" readonly >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Payment Mode</span>
                        </div>
                        
                        <select  class="form-control paymentMode"  name="paymentmode" value="{{ old('short_name') }}" required id="catid">
                          <option value="" hidden>Payment Mode</option>
                         
  <option value="1" >Cash</option>
 <option value="2" >Cheque</option>
  <option value="3" >DD</option>
   <option value="4" >Online Transfer</option>
   
                        </select>
                          
                     
                      </div>
                    </div>
                </div>
                
              </div>
              
           
             <div class="row results">
                    <div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Bank</span>
                        </div>
                        <input type="text" class="form-control"  name="bank"  value=""   >

                         
                           </div>
                        </div>
                      </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Cheque No</span>
                        </div>
                        <input type="text" class="form-control"  name="" value="" readonly >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Cheque Date</span>
                        </div>
                        <input type="text" class="form-control datepicker"  name="" value="" readonly >
                        
                      </div>
                    </div>
                </div>
                
              </div>
              <div class="row">
                 
                <!-- <div class="col-md-4 advnce">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Pending Amount</span>
                        </div>
                        

                        <input type="text" class="form-control advances"  name="advance" value="" readonly >
                          
                     
                      </div>
                    </div>
                </div> -->
                <!-- <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Total Amount</span>
                        </div>
                        
                        <input type="text" class="form-control auto-calc totalamount"  name="totalamount" value="0"  >
                          
                     
                      </div>
                    </div>
                </div> -->
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Settlement Type</span>
                        </div>
                        <select class="form-control settle"  name="settle_type"  >
                        <option value="" hidden >Settlement</option>
                        <option value="1" >Project Salary</option>
                        <option value="2" >Project Commission</option>
                        <option value="3" >Staff Salary</option>
                        <option value="4" >Staff Advance</option>
                        <option value="5" >Bank Charge</option>
                      
                        </select>
                        
                      </div>
                    </div>
                </div>
            </div>
              
              
               <div class="row loadrece">
                <div class="col-lg-12 grid-margin stretch-card">
                <div class="table table-responsive">
                    <table class="table table-striped ItemGrid" id="ItemGrid">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Invoice No</th>
                          <th>Date</th>
                           <th>Net Amount</th>
                           <th>Collected Amount</th>
                          
                           <th>Balance</th>
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
                    <div class="col-md-8">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white">Remarks</span>
                        </div>
                        <textarea class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="remarks" >
                  
                        </textarea>
                         
                           </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Net Total</span>
                        </div>
                        
                        <input type="text" class="form-control nettotal"  name="nettotal" value="" readonly >
                        <input type="hidden" class="form-control totaladvance"  name="totaladvance" value="" readonly >
                          
                     
                      </div>
                    </div>
                </div>
                    </div>
            
                      
        <div class="row mt-1">
               <div class="col-md-8 col-md-offset-1 ">
            <button type="submit" class="btn btn-gradient-dark btn-rounded btn-fw savebtn" >Save</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Cancel</button>
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
        <h5 class="modal-title" id="companyModalLabel">Expense Settlement  Details</h5>
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
      <th scope="col">Settle#</th>
      <th scope="col">Date</th>
      <th scope="col">Settlement Type</th>
     
     <th scope="col">Amount</th>
     <th scope="col">Invoices</th>
    </tr>
  </thead>
  <tbody>
     @foreach($datas as $data)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/accounts/settlement/{{$data->id}}">{{$data->settle_no}}</a></td>
      <td><a href="/accounts/settlement/{{$data->id}}">{{ \Carbon\Carbon::parse($data->dates)->format('j -F- Y')  }}</a></td>
  
    <td><a href="/accounts/settlement/{{$data->id}}">@if($data->settle_type =='1') Project Salary @elseif($data->settle_type =='2')  Project Commission @elseif($data->settle_type =='3')  Staff Salary @elseif($data->settle_type =='4') Staff Advance @elseif($data->settle_type =='5') Bank Charge @endif</a></td>
    <td><a href="/accounts/settlement/{{$data->id}}">{{$data->nettotal}}</a></td>
    <td><a href="/accounts/settlement/{{$data->id}}">@foreach($data->expensesettlementdetail as $item){{$item->invoiceno}},@endforeach</a></td>  
     </a></td>
     
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

 ///////////////////// Load Payment Mode/////////
   $('.paymentMode').change(function(){
  pay = $('.paymentMode').val();
   csrf=$("#token").val();
  if(pay =='5'){
  $(".totalamount").val("0.000"); 
   //$(".totalamount").prop("disabled",true);  
  }else{
   $(".totalamount").prop("disabled",false);   
  }
  $.ajax({ 
         type: "POST",
         url: "{{url('getbankorcash')}}", 
         data: {pay: pay,_token:csrf},
         dataType: "html",  
         success: 
              function(data){
                //alert(data);
                $('.results').html(data);
                  }
          });

  });
///////////////////// Customer /////////
$(function(){
   $('.settle').change(function(){
  settle = $('.settle').val();
   csrf=$("#token").val();
   //alert(settle);
  $.ajax({ 
         type: "POST",
         url: "{{url('getalldatas')}}", 
         data: {settle: settle,_token:csrf},
         dataType: "html",  
         success: 
              function(data){
               //alert(data);
                $('.ItemGrid tbody').html(data);
                  }
          });
 

  });
     });
////////////////CALCULATION ROUNDOFF//////////////
$(".roundoff").click(function (){
  
  $(".rnddiv").show();
  

})
</script>
@stop