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
                        <input type="text" class="form-control"  name="settle_no"  value="{{$set->settle_no}}">
                        <input type="hidden" class="form-control"  name="slno"  value="{{$set->slno}}"   >
                         
                           </div>
                        </div>
                      </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Date</span>
                        </div>
                        <input type="text" class="form-control datepicker"  name="dates" value="{{ \Carbon\Carbon::parse($set->dates)->format('j -F- Y')  }}" readonly >
                        
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
                         
 <option value="1" {{($set->paymentmode == '1' ? 'selected' : 'disabled') }}>Cash</option>
 <option value="2" {{($set->paymentmode == '2' ? 'selected' : 'disabled') }} >Cheque</option>
  <option value="3" {{($set->paymentmode == '3' ? 'selected' : 'disabled') }}>DD</option>
   <option value="4" {{($set->paymentmode == '4' ? 'selected' : 'disabled') }}>Online Transfer</option>
   <option value="5" {{($set->paymentmode == '5' ? 'selected' : 'disabled') }}>Adv Settlement</option>
   
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
                          <span class="input-group-text bg-gradient-info text-white">Bank/cash</span>
                        </div>
                        <select  class="form-control"  name="bank" value="{{ old('short_name') }}" required >
                          <option value="" hidden>Cash</option>
                          @foreach($account as $cat)
                          <option value="{{$cat->id}}" {{($set->bank == $cat->id ? 'selected' : 'disabled') }}>{{$cat->printname}}</option>
                          @endforeach
                        </select>

                         
                           </div>
                        </div>
                      </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Cheque No</span>
                        </div>
                        <input type="text" class="form-control"  name="chequeno" value="{{$set->chequeno}}" readonly >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Cheque Date</span>
                        </div>
                        <input type="text" class="form-control editpicker"  name="chequedate" value="{{ \Carbon\Carbon::parse($set->bank_date)->format('j -F- Y')  }}" readonly >
                        
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
                        <option value="1" {{($set->settle_type == '1' ? 'selected' : 'disabled') }} >Project Salary</option>
                        <option value="2" {{($set->settle_type == '2' ? 'selected' : 'disabled') }}>Project Commission</option>
                        <option value="3" {{($set->settle_type == '3' ? 'selected' : 'disabled') }}>Staff Salary</option>
                        <option value="4" {{($set->settle_type == '4' ? 'selected' : 'disabled') }}>Staff Advance</option>
                        <option value="5" {{($set->settle_type == '5' ? 'selected' : 'disabled') }}>Bank Charge</option>
                      
                        </select>
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          @if($set->is_deleted==1)
                          <span class="input-group-text bg-gradient-dark text-white ">Deleted</span>
                          @endif
                        </div>
                        
                        
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
                    
   
@foreach($set->expensesettlementdetail as $pnv)
<tr>
  <td>{{$loop->iteration}}</td>
  <td><input type="hidden" class="form-control"  name="invoiceno[]" value="{{ $pnv->voucher  }}"  >
        <input type="hidden" class="form-control"  name="purchaseid[]" value="{{ $pnv->id  }}"  >{{ $pnv->invoiceno }}</td>
<td> <input type="hidden" class="form-control"  name="gdates[]" value="{{ \Carbon\Carbon::parse($pnv->dates)->format('j -F- Y')  }}"  >{{ \Carbon\Carbon::parse($pnv->dates)->format('j -F- Y')  }}</td>
      
      <td>
        <input type="hidden" class="form-control"  name="grandtotal[]" value="{{ $pnv->grandtotal   }}"  ><input type="hidden" class="form-control"  name="ntotal[]" value="{{ $pnv->grandtotal     }}"  >
       {{ $pnv->grandtotal     }}</td>
      
     <td><input type="hidden" class="form-control"  name="collected[]" value="{{ $pnv->collected  }}"  >{{ $pnv->collected }}</td>
     
     <td><input type="hidden" class="form-control"  name="debitnote[]" value="{{ $pnv->balance  }}"  > {{ $pnv->balance  }}</td>
    
     <td><input type="hidden" class="form-control auto-calc balce"  name="balance[]" value="{{ $pnv->advncebalnce  }}"  >  {{ $pnv->amount  }}
    </td>
    </tr>
    @endforeach 
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
                  {{$set->remarks}}
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
                        
                        <input type="text" class="form-control nettotal"  name="nettotal" value="{{$set->nettotal}}" readonly >
                        <input type="hidden" class="form-control totaladvance"  name="totaladvance" value="" readonly >
                          
                     
                      </div>
                    </div>
                </div>
                    </div>
            
                      
        <div class="row mt-1">
               <div class="col-md-8 col-md-offset-1 ">
            <button type="submit" class="btn btn-gradient-dark btn-rounded btn-fw" disabled>Save</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Cancel</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" data-toggle="modal" data-target=".bd-find-modal-lg" >Find</button>
             @if($set->is_deleted!=1)
           <a href="{{url('deletesettlement')}}/{{$set->id}}" type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Delete</a>
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
        <h5 class="modal-title" id="companyModalLabel">Expense Settlement Details</h5>
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