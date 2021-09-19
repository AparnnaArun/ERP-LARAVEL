@extends('accounts/layout')
@section ('content')

<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-table menu-icon"></i>
                </span>Vendor Payment
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
                    <form class="forms-sample" action ="{{('/createpayment')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                        <input type="hidden" name="id" value="" id="id"/>
                   <div class="row">
                    <div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Payment#</span>
                        </div>
                        <input type="text" class="form-control"  name="pymt_no" id="code" value="{{$vpay->pymt_no}}">
                        <input type="hidden" class="form-control"  name="slno" id="code" value="{{$vpay->slno}}"   >
                         
                           </div>
                        </div>
                      </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Date</span>
                        </div>
                        <input type="text" class="form-control editpicker"  name="dates" value="
{{ \Carbon\Carbon::parse($vpay->dates)->format('j -F- Y')  }}"  >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Vendor</span>
                        </div>
                        
                        <select class="form-control vendor "  name="vendor" required >
                          <option value="" hidden>Vendor</option>
                          @foreach($vend as $row)
                        <option value="{{$row->id}}" {{($vpay->vendor == $row->id ? 'selected' : 'disabled') }} >{{$row->short_name}}</option>
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
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Payment Mode</span>
                        </div>
                        
                        <select  class="form-control paymentMode"  name="paymentmode" value="{{ old('short_name') }}" required id="catid">
                          <option value="" hidden>Payment Mode</option>
                         
 <option value="1" {{($vpay->paymentmode == '1' ? 'selected' : 'disabled') }}>Cash</option>
 <option value="2" {{($vpay->paymentmode == '2' ? 'selected' : 'disabled') }} >Cheque</option>
  <option value="3" {{($vpay->paymentmode == '3' ? 'selected' : 'disabled') }}>DD</option>
   <option value="4" {{($vpay->paymentmode == '4' ? 'selected' : 'disabled') }}>Online Transfer</option>
   <option value="5" {{($vpay->paymentmode == '5' ? 'selected' : 'disabled') }}>Adv Settlement</option>
                        </select>
                          
                     
                      </div>
                    </div>
                </div>
                <div class="col-md-4 advnce">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Advance</span>
                        </div>
                        

                        <input type="text" class="form-control advances"  name="advance" value="{{$vpay->advance}}" readonly >
                        <input type="hidden" class="form-control"  name="vendname" value="{{$vends->short_name}}" readonly >
                         <input type="hidden" class="form-control"  name="vendaccount" value="{{$vends->account}}" readonly >
                          
                     
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Total Amount</span>
                        </div>
                        
                        <input type="text" class="form-control auto-calc totalamount"  name="totalamount" value="{{$vpay->totalamount}}"  >
                          
                     
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
                          <option value="{{$cat->id}}" {{($vpay->bank == $cat->id ? ' selected' : 'disabled') }}>{{$cat->printname}}</option>
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
                        <input type="text" class="form-control"  name="chequeno" value="{{$vpay->chequeno}}" readonly >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Cheque Date</span>
                        </div>
                        <input type="text" class="form-control editpicker"  name="chequedate" value="{{ \Carbon\Carbon::parse($vpay->bank_date)->format('j -F- Y')  }}" readonly >
                        
                      </div>
                    </div>
                </div>
                
              </div>
              <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Exchange Rate</span>
                        </div>
                        <input type="text" class="form-control "  name="erate" value="{{$vpay->erate}}"  >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Currency</span>
                        </div>
                        <select class="form-control currency "  name="currency" required >
                        
                          @foreach($curr as $rows)
                        <option value="{{$rows->shortname}}" {{($vpay->currency == $rows->shortname? 'selected' : '') }}>{{$rows->shortname}}</option>
                        @endforeach
                    
                        </select>
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          @if($vpay->is_deleted==1)
                          <span class="input-group-text bg-gradient-dark text-white ">Deleted</span>
                          @endif
                        </div>
                        
                        
                      </div>
                    </div>
                </div>
              </div>
              
               <div class="row loadrece">
                <div class="col-md-4">
                   
                       <div  class="actions " id="actions" ></div>
                     
                      </div>
                    <div class="col-lg-12 grid-margin stretch-card">

                <div class="table table-responsive">
                    <table class="table table-striped reporttable" id="reporttable">
                      <thead>
                        <tr>
                     <th>#</th>
                          <th>Date</th>
       <th>Invoice#</th>
       <th>Net Amt</th>
       <th>CollectedAmt</th>
       <th>Debit Note Amt</th>
       <th>Balance</th>
      <th>Amount</th>
                          </tr>
                      </thead>
                      <tbody>
                        <!-- /////////////LOADED ALL SALES INVOICES////// -->

                         @foreach($vpay->vendorpaymentdetail as $custs)
                   
    <tr>
<td>{{ $loop->iteration }}</td>
      
      <td> <input type="hidden" class="form-control"  name="gdates[]" value="{{ \Carbon\Carbon::parse($custs->dates)->format('j -F- Y')  }}"  >{{ \Carbon\Carbon::parse($custs->dates)->format('j -F- Y')  }}</td>
      <td><input type="hidden" class="form-control"  name="invoiceno[]" value="{{ $custs->invoiceno  }}"  >
        <input type="hidden" class="form-control"  name="purchaseid[]" value="{{ $custs->id  }}"  >{{ $custs->invoiceno }}</td>
      <td><input type="hidden" class="form-control"  name="grandtotal[]" value="{{ ($custs->grandtotal) }}"  >
        {{ $custs->grandtotal }}</td>
      
     <td><input type="hidden" class="form-control"  name="collected[]" value="{{ $custs->collected  }}"  >{{ $custs->collected }}</td>
     
     <td><input type="hidden" class="form-control"  name="debitnote[]" value="{{ $custs->debitednote  }}"  > {{ $custs->debitednote}} </td>
     <td> {{ $custs->balance}} </td>
     <td><input type="hidden" class="form-control auto-calc balce"  name="balance[]" value="{{ $custs->balance  }}"  >  <input type="hidden" class="form-control auto-calc amount" name="amount[]"  value="{{$custs->amount}}">{{$custs->amount}}</td>
    </tr>
  @endforeach
  


                                     <tfoot>                              
     
    <tr>
      <td colspan="6" ><b>Total Balance</b></td>
     
       <td > </td>
     
      
     
    </tr>
  </tfoot>
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
                          <span class="input-group-text bg-gradient-info text-white ">Roundoff</span>
                        </div>
                        <input type="text" class="form-control auto-calc roundoff"  name="roundoff" value="{{$vpay->roundoff}}"  >
                        <div class="rnddiv" style="color:red;display:none;">Prefix mathematical sign ±</div>
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                                            <span class="input-group-text bg-gradient-danger text-white spanshow " style="display: none;">Unmatched Amount</span>

                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Unsettled </span>
                        </div>
                        

                        <input type="text" class="form-control totaladvance"  name="totaladvace" value="{{$vpay->totaladvace}}" readonly >
                        <input type="hidden"  name="" class="advacetest form-control form-control-xs" id="advacetest" readonly value="0.000" >
                          
                     
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Total</span>
                        </div>
                        
                        <input type="text" class="form-control gridtotal"  name="total" value="{{$vpay->total}}" readonly >
                          
                     
                      </div>
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
                  {{$vpay->remarks}}
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
                        
                        <input type="text" class="form-control nettotal"  name="nettotal" value="{{$vpay->nettotal}}" readonly >
                          
                     
                      </div>
                    </div>
                </div>
                    </div>
            
                      
        <div class="row mt-1">
               <div class="col-md-8 col-md-offset-1 ">
            <button type="submit" class="btn btn-gradient-dark btn-rounded btn-fw" disabled>Save</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Cancel</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" data-toggle="modal" data-target=".bd-find-modal-lg" >Find</button>
             @if($vpay->is_deleted!=1)
           <a href="{{url('deletepayment')}}/{{$vpay->id}}" type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Delete</a>
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
        <h5 class="modal-title" id="companyModalLabel">Vendor Payment Details</h5>
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
      <th scope="col">Payment#</th>
      <th scope="col">Date</th>
      <th scope="col">Vendor</th>
      <th scope="col">Mode</th>
     <th scope="col">Amount</th>
     <th scope="col">Invoices</th>
    </tr>
  </thead>
  <tbody>
     @foreach($datas as $data)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/accounts/payment/{{$data->id}}">{{$data->pymt_no}}</a></td>
      <td><a href="/accounts/payment/{{$data->id}}">{{ \Carbon\Carbon::parse($data->dates)->format('j -F- Y')  }}</a></td>
      <td><a href="/accounts/payment/{{$data->id}}">{{$data->short_name}}</a></td>
    <td><a href="/accounts/payment/{{$data->id}}">@if($data->paymentmode =='1') Cash @elseif($data->paymentmode =='2') Cheque @elseif($data->paymentmode =='3') DD @elseif($data->paymentmode =='4') Online Transfer @elseif($data->paymentmode =='5') Adv Settlement @endif</a></td>
    <td><a href="/accounts/payment/{{$data->id}}">{{$data->nettotal}}</a></td>
    <td><a href="/accounts/payment/{{$data->id}}">@foreach($data->vendorpaymentdetail as $item){{$item->invoiceno}},@endforeach</a></td>  
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
  $(".totalamount").val("0"); 
   $(".totalamount").prop("disabled",true);  
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
   $('.vendor').change(function(){
  vendor = $('.vendor').val();
   csrf=$("#token").val();
   //alert(pay);
  $.ajax({ 
         type: "POST",
         url: "{{url('getpinvoice')}}", 
         data: {vendor: vendor,_token:csrf},
         dataType: "html",  
         success: 
              function(data){
               // alert(data);
                $('.loadrece').html(data);
                  }
          });
  $.ajax({ 
         type: "POST",
         url: "{{url('getsumpadvance')}}", 
         data: {vendor: vendor,_token:csrf},
         dataType: "html",  
         success: 
              function(data){
                //alert(data);
                $('.advnce').html(data);
                  }
          });

  });
////////////////CALCULATION ROUNDOFF//////////////
$(".roundoff").click(function (){
  
  $(".rnddiv").show();
  

})
///////////////DATA TABLE/////////////
   $(document).ready(function ()
{

  $(function ()
  {
    var oTable = $('#reporttable').DataTable({
      "oLanguage": {
        "sSearch": "Filter Data" //Will appear on search form
      },
      paging:false,
      fixedHeader: {
        header: true, //Table have header and footer
        footer: true
      },
      autoFill: true, // Autofills fields by dragging the blue dot at the bottom right of cells
      responsive: true, //  Resize table
      rowReorder: true, // Row can be reordered by dragging
      select: true, // selecting rows, cells or columns
      colReorder: true, // Reorders columns
        drawCallback: function () {
         var api = this.api();
        total = api.column( 6,{ search:'applied' }).data().sum();
      $( api.column(6).footer() ).html(total.toFixed(3));
      //   var apii = this.api();
      //   totals = apii.column( 4,{ search:'applied' }).data().sum();
      // $( apii.column(4).footer() ).html(totals.toFixed(3)); 
      // var ap = this.api();
      //   tota = ap.column( 5,{ search:'applied' }).data().sum();
      // $( ap.column(5).footer() ).html(tota.toFixed(3));
      
       }  // Reorders columns
      
      
    });
// Adding action buttons to table
    new $.fn.dataTable.Buttons(oTable, {
      name: 'commands',
      buttons: [
        {extend:'copy', 
        className: 'btn btn-primary btn-xs text-dark',
       },
         {extend:'excel',
         className: 'btn btn-warning btn-xs text-dark'}, 
        {extend:'csv',
      className: 'btn btn-success btn-xs text-dark'}, 
          {extend: 'print',
          className: 'btn btn-danger btn-xs text-dark',
          footer:true,
            title: 'Payments',
          customize: function ( doc ) {
     $(doc.document.body).find('h1').css('font-size', '15pt');
     $(doc.document.body).find('h1').css('text-align', 'center'); 
 }}
      ]
    });
// Appends the buttons to the selected element class called "action"
    oTable.buttons(0, null).containers().appendTo('.actions');
});
});
    

    /////////// Calculation //////////
  $(document).on("keyup change paste", "input.auto-calc", function() {
  row = $(this).closest("tr");
var total = parseFloat($(".totalamount").val());
var advances = parseFloat($(".advances").val());
var tots = total + advances;
var bal = parseFloat(row.find(".balce").val());
var amt = parseFloat(row.find(".amount").val());
//alert(advances);
$('.totaladvance').val(tots.toFixed(3));
$('.advacetest').val(tots.toFixed(3));
if(amt > bal ){
 row.find('.alrtss').show();
}
else{
 row.find('.alrtss').hide();
 var sum = 0;
 $("input.amount").each(function() {
  sum += +$(this).val();
  });
 $('.gridtotal').val(Math.round(sum*1000)/1000);
 //$('.nettotal').val(Math.round(sum*1000)/1000);
}

 var tot = parseFloat($('.gridtotal').val());
 var adv = parseFloat($('.advacetest').val());
 var round =parseFloat($('.roundoff').val()); 
 var full= (tots-tot);
//alert(full); 
  $('.totaladvance').val((full).toFixed(3));

if(full < 0){
$('.spanshow').show();  
}else{
$('.spanshow').hide();   
}
 var bal = tot + (round) ;
 //alert(bal);
 $('.nettotal').val(bal.toFixed(3));

   });
</script>
@stop