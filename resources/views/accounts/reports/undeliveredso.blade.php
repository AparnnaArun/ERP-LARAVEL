@extends('accounts/layout')
@section ('content')
 <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-chart-bar  menu-icon"></i>
                </span>SO Not Delivered Report
              </h3>
              
            </div>

<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    
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
                     <th>#</th>
                          <th>Dates</th>
       <th>SO#</th>
       <th>Customer</th>
      
  
  
       
                          </tr>
                      </thead>
                      <tbody>
                        @foreach($so as $cust)
    <tr>

      
      
      <td>{{$loop->iteration}}</td>
      <td>
{{ \Carbon\Carbon::parse($cust->dates)->format('j -F- Y')  }}</td>
      <td>{{$cust->order_no}}</td>
      <td>{{$cust->short_name}}</td>

     
     
     
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
            title: 'SO NOT DELIVERED',
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
</script>
                @stop