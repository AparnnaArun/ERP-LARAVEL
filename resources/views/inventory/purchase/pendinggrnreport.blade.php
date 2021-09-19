@extends('inventory/layout')
@section ('content')
 <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-chart-bar  menu-icon"></i>
                </span>Pending GRN Report
              </h3>
              
            </div>

<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    
                    <p class="card-description"> 
                    </p>
         <div class="row">
          
          <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Start Date</span>
                        </div>
                       <input  class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="" id="startdate" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">End Date</span>
                        </div>
                       <input  class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="" id="enddate" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                   
                       <div  class="actions " id="actions" ></div>
                        
                      </div>
                   
         </div>
                    <div class="table table-responsive">
                    <table class="table table-striped reporttable" id="reporttable">
                      <thead>
                        <tr>
                     
                          <th>Date</th>
       <th>PO#</th>
       <th>Vendor</th>
       <th>ReqNo</th>
       <th>Project Code</th>
       <th>Items</th>
       <th>Unit</th>
       <th>Req Qnty</th>
       <th>Appr Qnty</th>
       <th>Appr Amt</th>
                           <th>status</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach($datas as $cust)
    <tr>

      
      <td>{{ \Carbon\Carbon::parse($cust->order_date)->format('j -F- Y')  }}</td>
      <td>{{$cust->po_no}}</td>
      <td>{{$cust->vendor}}</td>
      <td>{{$cust->reference}}</td>
      <td>{{$cust->project_code}}</td>
     
      <td>@foreach($cust->purchaseorderdetail as $cuu2)<span style="color: red;">*</span> {{ $cuu2->item_name}} <br/>@endforeach</td>
      <td>@foreach($cust->purchaseorderdetail as $cuu)<span style="color: red;">*</span> {{ $cuu->unit}} <br/>@endforeach</td>
      <td>@foreach($cust->purchaseorderdetail as $cuu)<span style="color: red;">*</span> {{ $cuu->reqqnty}} <br/>@endforeach</td>
      <td>@foreach($cust->purchaseorderdetail as $cuu)<span style="color: red;">*</span> {{ $cuu->apprqnty}} <br/>@endforeach</td>
      <td>@foreach($cust->purchaseorderdetail as $cuu)<span style="color: red;">*</span> {{ $cuu->rate}} <br/>@endforeach</td>
   <td>@if($cust->is_grned==1) Full goods received @elseif($cust->is_grned==2) Partially goods received @else Pending @endif</td>
     
    </tr>
   @endforeach
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
            title: 'Pending GRN Report',
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