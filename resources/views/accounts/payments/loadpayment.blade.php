                 <!--  
                  <div class="row"> -->
<div class="col-md-4">
                   
                       <div  class="actions " id="actions" ></div>
                     
                      </div>
                    <div class="col-lg-12 grid-margin stretch-card">

                <div class="table table-responsive">
                    <table class="table table-striped reporttable" id="reporttable">
                      <thead>
                        <tr>
               
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

                         @foreach($pinv as $custs)
                   
    <tr>

      
      <td> <input type="hidden" class="form-control"  name="gdates[]" value="{{ \Carbon\Carbon::parse($custs->dates)->format('j -F- Y')  }}"  >{{ \Carbon\Carbon::parse($custs->dates)->format('j -F- Y')  }}</td>
      <td><input type="hidden" class="form-control"  name="invoiceno[]" value="{{ $custs->p_invoice  }}"  >
        <input type="hidden" class="form-control"  name="purchaseid[]" value="{{ $custs->id  }}"  >{{ $custs->p_invoice }}</td>
      <td><input type="hidden" class="form-control"  name="grandtotal[]" value="{{ ($custs->net_total) -($custs->isslnrtn_amt) }}"  >
        <input type="hidden" class="form-control"  name="ntotal[]" value="{{ $custs->totalamount}}"  >{{ $custs->totalamount }}</td>
      
     <td><input type="hidden" class="form-control"  name="collected[]" value="{{ $custs->collected_amount  }}"  >{{ $custs->collected_amount }}</td>
     
     <td><input type="hidden" class="form-control"  name="debitnote[]" value="{{ $custs->debit_note_amount  }}"  > {{ $custs->debit_note_amount}} </td>
     <td> {{ $custs->balance}} </td>
     <td><input type="hidden" class="form-control auto-calc balce"  name="balance[]" value="{{ $custs->balance  }}"  >  <input type="text" class="form-control auto-calc amount" name="amount[]" ><div class="alrtss" style="color:red;display:none;">This amount should be less than balance amount</div></td>
    </tr>
  @endforeach
   <!-- /////////////LOADED ALL PROJECT INVOICES////// -->
                          @foreach($pexc as $pnv)
                   
    <tr>

      
      <td> <input type="hidden" class="form-control"  name="gdates[]" value="{{ \Carbon\Carbon::parse($pnv->dates)->format('j -F- Y')  }}"  >{{ \Carbon\Carbon::parse($pnv->dates)->format('j -F- Y')  }}</td>
      <td><input type="hidden" class="form-control"  name="invoiceno[]" value="{{ $pnv->entry_no  }}"  >
        <input type="hidden" class="form-control"  name="purchaseid[]" value="{{ $pnv->id  }}"  >{{ $pnv->entry_no }}</td>
      <td><input type="hidden" class="form-control"  name="grandtotal[]" value="{{ $pnv->totalamount   }}"  >
        <input type="hidden" class="form-control"  name="ntotal[]" value="{{ $pnv->totalamount}}"  >{{ $pnv->totalamount  }}</td>
      
     <td><input type="hidden" class="form-control"  name="collected[]" value="{{ $pnv->collected_amount  }}"  >{{ $pnv->collected_amount }}</td>
     
     <td><input type="hidden" class="form-control"  name="debitnote[]" value="{{ $pnv->debitnote_amount  }}"  > {{ $pnv->debitnote_amount}} </td>
     <td> {{ $pnv->balance_amount}} </td>
     <td><input type="hidden" class="form-control auto-calc balce"  name="balance[]" value="{{ $pnv->balance_amount  }}"  >  <input type="text" class="form-control auto-calc amount" name="amount[]" >
      <div class="alrtss" style="color:red;display:none;">This amount should be less than balance amount</div></td>
    </tr>
@endforeach
<!-- /////////////LOADED ALL PURCHASE COSTS////// -->
                          @foreach($pcost as $pct)
                   
    <tr>

      
      <td> <input type="hidden" class="form-control"  name="gdates[]" value="{{ \Carbon\Carbon::parse($pct->dates)->format('j -F- Y')  }}"  >{{ \Carbon\Carbon::parse($pct->dates)->format('j -F- Y')  }}</td>
      <td><input type="hidden" class="form-control"  name="invoiceno[]" value="{{ $pct->addnos }}"  >
        <input type="hidden" class="form-control"  name="purchaseid[]" value="{{ $pct->id  }}"  >
        <input type="hidden" class="form-control"  name="pcostmid[]" value="{{ $pct->pcid  }}"  >{{ $pct->addnos }}</td>
      <td><input type="hidden" class="form-control"  name="grandtotal[]" value="{{ $pct->amount   }}"  >
        <input type="hidden" class="form-control"  name="ntotal[]" value="{{ $pct->amount}}"  >{{ $pct->amount  }}</td>
      
     <td><input type="hidden" class="form-control"  name="collected[]" value="{{ $pct->settledamt  }}"  >{{ $pct->settledamt }}</td>
     
     <td><input type="hidden" class="form-control"  name="debitnote[]" value="0.000"  > 0.000 </td>
     <td> {{ $pct->unsettledamt}} </td>
     <td><input type="hidden" class="form-control auto-calc balce"  name="balance[]" value="{{ $pct->unsettledamt  }}"  >  <input type="text" class="form-control auto-calc amount" name="amount[]" >
      <div class="alrtss" style="color:red;display:none;">This amount should be less than balance amount</div></td>
    </tr>
@endforeach

                                     <tfoot>                              
     
    <tr>
      <td colspan="5" ><b>Total Balance</b></td>
     
       <td > </td>
     
      
     
    </tr>
  </tfoot>
                      </tbody>
                    </table>
                  </div>
                </div>

             
<script type="text/javascript">
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
        total = api.column( 5,{ search:'applied' }).data().sum();
      $( api.column(5).footer() ).html(total.toFixed(3));
         }  
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
  $(".savebtn").attr("disabled", true);
}
else{
 row.find('.alrtss').hide();
  $(".savebtn").attr("disabled", false);
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
var full= (tots-(round))-tot;
//alert(full); 
  $('.totaladvance').val((full).toFixed(3));

if(full < 0){
$('.spanshow').show();
 $(".savebtn").attr("disabled", true);  
}else{
$('.spanshow').hide(); 
 $(".savebtn").attr("disabled", false);  
}
 var bal = tot + (round) ;
 //alert(bal);
 $('.nettotal').val(bal.toFixed(3));

   });
</script>
