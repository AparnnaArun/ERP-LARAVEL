 <div class="row">
          
          <div class="col-md-4">
            <input type="hidden" id="custt" value="{{$cusss->short_name}}">
          </div>
          <div class="col-md-4">
          </div>
               
                <div class="col-md-4">
                   
                       <div  class="actions " id="actions" ></div>
                        
                      </div>
                   
         </div>
                 
           <div class="table table-responsive ">
                   
                  <table class="table table-striped reporttable" id="reporttable">
                      <thead>
                        <tr>
                     
       <th>Date</th>
       <th>Description</th>
       <th>Debit</th>
       <th>Credit</th>
      
       
       
                          </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td></td>
                          <td>Opening Balance</td>
                          <td>@if(!empty($op->debit)){{$op->debit}}@else 0.000 @endif</td>
                          <td>@if(!empty($op->credit)){{$op->credit}}@else 0.000 @endif</td>
                        </tr>
                        @foreach($reg as $cust)
     
    <tr>

      
      <td>{{ \Carbon\Carbon::parse($cust->dates)->format('j -F- Y')  }}</td>
      <td>{{$cust->narration}}</td>
     <td>@if($cust->debitcredit=='debt') {{$cust->amount  }} @else {{0.000}} @endif</td>
      <td>@if($cust->debitcredit=='cred') {{$cust->amount  }} @else {{0.000}} @endif</td>
      
      
     
    </tr>
   @endforeach

                                     <tfoot>                              
     
    <tr>
      <td  ><b>Total </b></td>
     
       <td > </td>
     <td > </td>
     <td > </td>
      
     
    </tr>
  </tfoot>
                      </tbody>
                    </table>
                  </div>
               <!--  </div> -->
                  
             
             
             
<script type="text/javascript">
    $(document).ready(function ()
{

  $(function ()
  {
    var oTable = $('#reporttable').DataTable({
      "oLanguage": {
        "sSearch": "Filter Data" //Will appear on search form
      },
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
        total = api.column( 2,{ search:'applied' }).data().sum();
      $( api.column(2).footer() ).html(total.toFixed(3));
          var apii = this.api();
        totals = apii.column( 3,{ search:'applied' }).data().sum();
      $( apii.column(3).footer() ).html(totals.toFixed(3));
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
         className: 'btn btn-warning btn-xs text-dark',
       title:  function(){
                var d = $("#custt").val();
          return d + ' REPORT' 
             },}, 
        {extend:'csv',
      className: 'btn btn-success btn-xs text-dark'}, 
          {extend: 'print',
          className: 'btn btn-danger btn-xs text-dark',
            title:  function(){
                var d = $("#custt").val();
          return d + ' REPORT' 
             },
          customize: function ( doc ) {
     $(doc.document.body).find('h1').css('font-size', '15pt');
     $(doc.document.body).find('h1').css('text-align', 'center'); 
 }}
      ]
    });
// Appends the buttons to the selected element class called "action"
    oTable.buttons(0, null).containers().appendTo('.actions');


    $("#startdate").datepicker({
      changeYear: true,
      changeMonth: true,
      dateFormat: "dd-M-yy",
      "onSelect": function (date)
      {
        minDateFilter = new Date(date).getTime();
        oTable.draw();
      }
    }).keyup(function ()
    {
      minDateFilter = new Date(this.value).getTime();
      oTable.draw();
    });

    $("#enddate").datepicker({
      changeYear: true,
      changeMonth: true,
      dateFormat: "dd-M-yy",
      "onSelect": function (date)
      {
        maxDateFilter = new Date(date).getTime();
        oTable.draw();
      }
    }).keyup(function ()
    {
      maxDateFilter = new Date(this.value).getTime();
      oTable.draw();
    });

  });

// Date range filter
  minDateFilter = "";
  maxDateFilter = "";

  $.fn.dataTableExt.afnFiltering.push(
    function (oSettings, aData, iDataIndex)
    {
      if (typeof aData._date == 'undefined')
      {
        aData._date = new Date(aData[0]).getTime();
      }

      if (minDateFilter && !isNaN(minDateFilter))
      {
        if (aData._date < minDateFilter)
        {
          return false;
        }
      }

      if (maxDateFilter && !isNaN(maxDateFilter))
      {
        if (aData._date > maxDateFilter)
        {
          return false;
        }
      }
      return true;
    }
  );


});
</script>