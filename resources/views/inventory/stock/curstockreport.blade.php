@extends('inventory/layout')
@section ('content')
 <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-history   menu-icon"></i>
                </span> {{\Carbon\Carbon::parse(now())->format('j -F- Y') }} Stock Report
              </h3>
              
            </div>

<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <input type="hidden" value="{{\Carbon\Carbon::parse(now())->format('j -F- Y') }} Stock Report" id="headd">
                    <p class="card-description">
                    Todays stock report with location and batch details 
                    </p>
         <div class="row">
          
         
                <div class="col-md-4">
                   
                       <div  class="actions " id="actions" ></div>
                        
                      </div>
                   
         </div>
                    <div class="table table-responsive">
                    <table class="table table-striped reporttable" id="reporttable">
                      <thead>
                        <tr>
                     
          <th>Code</th>
       <th>Item</th>
       <th>Unit</th>
       <th>Batch</th>
       <th>Rate</th>
       <th>Cur Stock</th>
       <th>Stock Value</th>
       <th>Location</th>
       </tr>
                      </thead>
                      <tbody>
                        @foreach($stock as $cust)
    <tr>

      
      <td>{{ $cust->code }}</td>
      <td><a href="/inventory/stock/{{$cust->id}}">{{$cust->item}}</a></td>
      <td>{{$cust->basic_unit}}</td>
      <td>{{$cust->batch}}</td>
      <td>{{$cust->cost}}</td>
      <td>{{$cust->bal_qnty}}</td>
      <td>{{$cust->cost * $cust->bal_qnty}}</td>
   <td>{{$cust->locationname}}</td>
     
    </tr>
   @endforeach
   <tfoot>                              
     
    <tr>
      <td >Total</td>
      <td >  </td>
      <td > </td>
      <td > </td>
      <td > </td>
      <td > </td>
      <td style="color:red;"></td>
      <td > </td>
      
     
    </tr>
  </tfoot>
   
                      </tbody>
                    </table>
                  </div>
                  </div>
                </div>
              </div>
             
             <script src="/assets/js/jquery-3.6.0.min.js"></script>
            
            
             
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
         total = api.column( 6,{ search:'applied' }).data().sum();
         $( api.column(6).footer() ).html(total.toFixed(3));
           
      
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
                var d = $("#headd").val();
          return d ; 
             }}, 
        {extend:'csv',
      className: 'btn btn-success btn-xs text-dark'}, 
           {extend: 'print',
          className: 'btn btn-danger btn-xs text-dark',
            title:  function(){
                var d = $("#headd").val();
          return d ; 
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
                @stop