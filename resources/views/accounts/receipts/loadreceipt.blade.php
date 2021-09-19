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
       <th>Credit Note Amt</th>
       <th>Balance</th>
      <th>Amount</th>
                          </tr>
                      </thead>
                      <tbody>
                        <!-- /////////////LOADED ALL SALES INVOICES////// -->

                         @foreach($sinv as $custs)
                   
    <tr>

      
      <td> <input type="hidden" class="form-control"  name="gdates[]" value="{{ \Carbon\Carbon::parse($custs->dates)->format('j -F- Y')  }}"  >{{ \Carbon\Carbon::parse($custs->dates)->format('j -F- Y')  }}</td>
      <td><input type="hidden" class="form-control"  name="invoiceno[]" value="{{ $custs->invoice_no  }}"  >
        <input type="hidden" class="form-control"  name="salesid[]" value="{{ $custs->id  }}"  >{{ $custs->invoice_no }}</td>
      <td><input type="hidden" class="form-control"  name="grandtotal[]" value="{{ ($custs->net_total) -($custs->isslnrtn_amt) }}"  >
        <input type="hidden" class="form-control"  name="ntotal[]" value="{{ $custs->net_total}}"  >{{ ($custs->net_total) -($custs->isslnrtn_amt) }}</td>
      
     <td><input type="hidden" class="form-control"  name="collected[]" value="{{ $custs->collected_amount  }}"  >{{ $custs->collected_amount }}</td>
     
     <td><input type="hidden" class="form-control"  name="creditnote[]" value="{{ $custs->creditnote_amount  }}"  > {{ $custs->creditnote_amount}} </td>
     <td> {{ $custs->balance}} </td>
     <td><input type="hidden" class="form-control auto-calc balce"  name="balance[]" value="{{ $custs->balance  }}"  >  <input type="text" class="form-control auto-calc amount" name="amount[]" ><div class="alrtss" style="color:red;display:none;">This amount should be less than balance amount</div></td>
    </tr>
  @endforeach
   <!-- /////////////LOADED ALL PROJECT INVOICES////// -->
                          @foreach($pinv as $pnv)
                   
    <tr>

      
      <td> <input type="hidden" class="form-control"  name="gdates[]" value="{{ \Carbon\Carbon::parse($pnv->dates)->format('j -F- Y')  }}"  >{{ \Carbon\Carbon::parse($pnv->dates)->format('j -F- Y')  }}</td>
      <td><input type="hidden" class="form-control"  name="invoiceno[]" value="{{ $pnv->projinv_no  }}"  >
        <input type="hidden" class="form-control"  name="salesid[]" value="{{ $pnv->id  }}"  >{{ $pnv->projinv_no }}</td>
      <td><input type="hidden" class="form-control"  name="grandtotal[]" value="{{ $pnv->totalamount   }}"  >
        <input type="hidden" class="form-control"  name="ntotal[]" value="{{ $pnv->totalamount}}"  >{{ $pnv->totalamount  }}</td>
      
     <td><input type="hidden" class="form-control"  name="collected[]" value="{{ $pnv->collected_amount  }}"  >{{ $pnv->collected_amount }}</td>
     
     <td><input type="hidden" class="form-control"  name="creditnote[]" value="{{ $pnv->creditnote_amount  }}"  > {{ $pnv->creditnote_amount}} </td>
     <td> {{ $pnv->bal_amount}} </td>
     <td><input type="hidden" class="form-control auto-calc balce"  name="balance[]" value="{{ $pnv->bal_amount  }}"  >  <input type="text" class="form-control auto-calc amount" name="amount[]" >
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
            title: 'Receipts',
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
