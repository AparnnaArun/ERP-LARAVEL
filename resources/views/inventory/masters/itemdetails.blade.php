@extends('inventory/layout')
@section ('content')
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-table"></i>
                </span>Item Details
              
            </div> 

<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
           
                    <p class="card-description"> Red color column indicate the qnty less than ROL
                    </p>
                    <input type="hidden" name="_token" class="token" value="{{ csrf_token() }}" id="token"/>
        
         <div class="row">
          
          <div class="col-md-4">
            
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
                     
                          <th>#</th>
       <th>Code#</th>
       <th>Item</th>
      <th>Part No</th>
       <th>Unit</th>
       <th>Cur.Qnty</th>
      <th>Cost</th>
      <th>Sales Rate</th>
       <th>Bottom Rate</th>
  
       
                          </tr>
                      </thead>
                      <tbody>
                        @foreach($item as $cust)
    <tr>

      
      <td>{{$loop->iteration  }}</td>
      <td>{{$cust->code}}</td>
    <td>{{$cust->item}}</td>
    <td>{{$cust->part_no}}</td>
    <td>{{$cust->basic_unit}}</td>
    <td>@if($cust->reorder_level < $cust->sumqnty){{$cust->sumqnty}} @else <span style="color:red;">{{$cust->sumqnty}}</span> @endif</td>
    <td>{{$cust->cost}}</td>
    <td>{{$cust->retail_salesrate}}</td>
   <td>{{$cust->wholesale_salesrate}}</td>
     
     
    </tr>
   @endforeach
                      </tbody>
                    </table>
                  </div>
               <!--  </div> -->
                  
             
             
             


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
          return d + ' EXPENSE REPORT' 
             },}, 
        {extend:'csv',
      className: 'btn btn-success btn-xs text-dark'}, 
          {extend: 'print',
          className: 'btn btn-danger btn-xs text-dark',
            title:  'Item Details',
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