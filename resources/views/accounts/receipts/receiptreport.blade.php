@extends('accounts/layout')
@section ('content')
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-history  menu-icon"></i>
                </span>Receipts Detailed Report
              
            </div> 

<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
           
                    <p class="card-description"> 
                    </p>
                    <input type="hidden" name="_token" class="token" value="{{ csrf_token() }}" id="token"/>
                    <div class="row">
          
          
          <div class="col-md-4">
          </div>
               
                <div class="col-md-4">
                   
                       <div  class="actions " id="actions" ></div>
                        
                      </div>
                   
         </div>
         
         <div class="row">
          <div class="col-md-12 result">
             
                 
           <div class="table table-responsive ">
                   
                  <table class="table table-striped reporttable" id="reporttable">
                      <thead>
                        <tr>
                     
       <th>Date</th>
       <th>Receipt#</th>
       <th>Customer</th>
       <th>Mode</th>
       <th>Amount</th>
       <th>Remarks</th>
       
                          </tr>
                      </thead>
                      <tbody>
                       
                        @foreach($rec as $cust)
     
    <tr>

      
      <td>{{ \Carbon\Carbon::parse($cust->dates)->format('j -F- Y')  }}</td>
      <td>{{$cust->rept_no}}</td>
      <td>{{$cust->short_name}}</td>
     <td>@if($cust->paymentmode =='1') Cash @elseif($cust->paymentmode =='2') Cheque @elseif($cust->paymentmode =='3') DD @elseif($cust->paymentmode =='4') Online Transfer @elseif($cust->paymentmode =='5') Adv Settlement @endif</td>
     <td>{{$cust->nettotal}}</td>
     <td>@foreach($cust->receiptdetail as $data)*.{{$data->invoiceno}}
      <span style="color: red;">({{$data->amount}})</span><br/>@endforeach</td> 
      
     
    </tr>
   @endforeach

                      </tbody>
                    </table>
                  </div>
            </div>
        </div>

              </div>
                  </div>
                </div>

 <!-- ///////Js Start here//////////////////// -->
<script src="../../assets/js/jquery-3.6.0.min.js"></script> 
           
<script type="text/javascript">
    $(document).ready(function ()
{

  $(function ()
  {
    var oTable = $('#reporttable').DataTable({
      "oLanguage": {
        "sSearch": "Filter " //Will appear on search form
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
    new $.fn.custTable.Buttons(oTable, {
      name: 'commands',
      buttons: [
        {extend:'copy', 
        className: 'btn btn-primary btn-xs text-dark',
       },
         {extend:'excel',
         className: 'btn btn-warning btn-xs text-dark',
       title: 'Receivable Summary'}, 
        {extend:'csv',
      className: 'btn btn-success btn-xs text-dark'}, 
          {extend: 'print',
          className: 'btn btn-danger btn-xs text-dark',
            title:  'Receivable Summary',
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