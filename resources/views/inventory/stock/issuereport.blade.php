@extends('inventory/layout')
@section ('content')
 <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-history  menu-icon"></i>
                </span>Material Issue Report
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
       <th>Issue#</th>
       
       <th>Code</th>
       <th>Items</th>
       <th>Unit</th>
       <th>Issue Qnty</th>
       <th>Rtn Qnty</th>
       <th>Bal Qnty</th>
       <th>Issue For</th>
       </tr>
                      </thead>
                      <tbody>
                        @foreach($stock as $cust)
    <tr>

      
      <td>{{ \Carbon\Carbon::parse($cust->issue_date)->format('j -F- Y')  }}</td>
      <td><a href="/inventory/stock/{{$cust->id}}">{{$cust->issue_no}}</a></td>
     
      <td>@foreach($cust->stockissuedetail as $cuu1) <span style="color: red;">*</span> {{ $cuu1->item_code}} <br/>@endforeach</td>
      <td>@foreach($cust->stockissuedetail as $cuu2)<span style="color: red;">*</span> {{ $cuu2->item_name}} <br/>@endforeach</td>
      <td>@foreach($cust->stockissuedetail as $cuu)<span style="color: red;">*</span> {{ $cuu->unit}} <br/>@endforeach</td>
      <td>@foreach($cust->stockissuedetail as $cuu)<span style="color: red;">*</span> {{ $cuu->issue_qnty}} <br/>@endforeach</td>
      <td>@foreach($cust->stockissuedetail as $cuu)<span style="color: red;">*</span> {{ $cuu->rtn_qnty}} <br/>@endforeach</td>
      <td>@foreach($cust->stockissuedetail as $cuu)<span style="color: red;">*</span> {{ $cuu->pen_qnty}} <br/>@endforeach</td>
   <td>{{$cust->issue_for}}</td>
     
    </tr>
   @endforeach
   <!-- //////////////////////// project mat issue//////////////// -->
                      @foreach($mat as $row)
    <tr>

      
      <td>{{ \Carbon\Carbon::parse($row->dates)->format('j -F- Y')  }}</td>
      <td><a href="/inventory/matissue/{{$row->id}}">{{$row->issue_no}}</a></td>
     
      <td>@foreach($row->projectmaterialissuedetail as $cuu1) <span style="color: red;">*</span> {{ $cuu1->item_code}} <br/>@endforeach</td>
      <td>@foreach($row->projectmaterialissuedetail as $cuu2)<span style="color: red;">*</span> {{ $cuu2->item}} <br/>@endforeach</td>
      <td>@foreach($row->projectmaterialissuedetail as $cuu)<span style="color: red;">*</span> {{ $cuu->unit}} <br/>@endforeach</td>
      <td>@foreach($row->projectmaterialissuedetail as $cuu)<span style="color: red;">*</span> {{ $cuu->issue_qnty}} <br/>@endforeach</td>
      <td>@foreach($row->projectmaterialissuedetail as $cuu)<span style="color: red;">*</span> {{ $cuu->rtn_qnty}} <br/>@endforeach</td>
      <td>@foreach($row->projectmaterialissuedetail as $cuu)<span style="color: red;">*</span> {{ $cuu->pen_qnty}} <br/>@endforeach</td>
   <td>{{$row->executive}}</td>
     
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
            title: 'Material Issue Report',
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