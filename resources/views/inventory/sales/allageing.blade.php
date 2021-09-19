 <div class="row">
          
          <div class="col-md-4">
            <input type="hidden" id="custt" value="{{$cusss->name}}">
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
       <th>Inv#</th>
       <th>Customer PO</th>
       <th>0 - 30</th>
       <th>31 -60</th>
       <th>61 - 90</th>
       <th>90 - ∞ </th>
       
       
                          </tr>
                      </thead>
                      <tbody>
                        @foreach($custs1 as $cust)
      @php
    $data= ((\Carbon\Carbon::parse($cust->dates))->diff(\Carbon\Carbon::now())->format('%a'));
@endphp
    <tr>

      
      <td>{{ \Carbon\Carbon::parse($cust->dates)->format('j -F- Y')  }}</td>
      <td><a href="/inventory/invoice-edit/{{$cust->id}}">{{$cust->invoice_no}}</a></td>
      <td>{{$cust->po_number}}</td>
      <td> 
      @if($data >= 0  && $data <= 30) {{$cust->balance  }} @else {{0.000}} @endif
       
</td>
      <td>@if($data >= 31  && $data <= 60) {{$cust->balance  }} @else {{0.000}} @endif</td>
      <td>@if($data >= 61  && $data <= 90) {{$cust->balance  }} @else {{0.000}} @endif</td>
      <td>@if( $data >= 90) {{$cust->balance  }} @else {{0.000}} @endif</td>
      
     
    </tr>
   @endforeach
                @foreach($proinv as $pro)
      @php
    $data= ((\Carbon\Carbon::parse($pro->dates))->diff(\Carbon\Carbon::now())->format('%a'));
@endphp
    <tr>

      
      <td>{{ \Carbon\Carbon::parse($pro->dates)->format('j -F- Y')  }}</td>
      <td><a href="/inventory/invoice-edit/{{$cust->id}}">{{$pro->projinv_no}}</a></td>
      <td>{{$pro->customer_po}}</td>
      <td> 
      @if($data >= 0  && $data <= 30) {{$pro->bal_amount  }} @else {{0.000}} @endif
       
</td>
      <td>@if($data >= 31  && $data <= 60) {{$pro->bal_amount  }} @else {{0.000}} @endif</td>
      <td>@if($data >= 61  && $data <= 90) {{$pro->bal_amount  }} @else {{0.000}} @endif</td>
      <td>@if( $data >= 90) {{$pro->bal_amount  }} @else {{0.000}} @endif</td>
      
     
    </tr>
   @endforeach
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
          return d + 'AGEING REPORT' 
             },}, 
        {extend:'csv',
      className: 'btn btn-success btn-xs text-dark'}, 
          {extend: 'print',
          className: 'btn btn-danger btn-xs text-dark',
            title:  function(){
                var d = $("#custt").val();
          return d + 'AGEING REPORT' 
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