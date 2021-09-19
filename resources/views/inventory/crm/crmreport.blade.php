@extends('inventory/layout')
@section ('content')
 <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-history   menu-icon"></i>
                </span> CRM Report
              </h3>
              
            </div>

<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <input type="hidden" value="CRM Report" id="headd">
                    <p class="card-description">
       
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
                     
          <th>Customer</th>
       <th>Contact Person</th>
       <th>Contact No</th>
       <th>Email</th>
       <th>Feedback</th>
       <th>Followup Date</th>
    
    
       </tr>
                      </thead>
                      <tbody>
                        @foreach($datas as $cust)
    <tr>

      
      <td><a href="/inventory/crm/{{$cust->id}}" target="_blank">{{ $cust->customer }}</a></td>
      <td><a href="/inventory/crm/{{$cust->id}}" target="_blank">
        @foreach($cust->crmdetail as $ccrm){{$ccrm->contactperson}}<br>@endforeach

      </a></td>
      <td><a href="/inventory/crm/{{$cust->id}}" target="_blank">
        @foreach($cust->crmdetail as $ccrm){{$ccrm->contactno}}<br>@endforeach</a></td>
      <td><a href="/inventory/crm/{{$cust->id}}" target="_blank">
        @foreach($cust->crmdetail as $ccrm){{$ccrm->email}}<br>@endforeach
      </a></td>
      <td><a href="/inventory/crm/{{$cust->id}}" target="_blank">{{$cust->feedback}}</a></td>
      <td><a href="/inventory/crm/{{$cust->id}}" target="_blank">{{ \Carbon\Carbon::parse($cust->followupdate)->format('j -F- Y')  }}</a></td>
    

     
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
         className: 'btn btn-warning btn-xs text-dark',
       title:  function(){
                var d = $("#headd").val();
          return d ; 
             },
           format: {
                body: function ( data, column, row ) {
                    return column === 2 ?
    
      data.replace( /<br\s*\/?>/ig, '\r\n'):
       data;
                }
            },customize: function( xlsx ) {
                var sheet = xlsx.xl.worksheets['sheet1.xml'];
                // set cell style: Wrapped text
                $('row c', sheet).attr( 's', '55' );
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