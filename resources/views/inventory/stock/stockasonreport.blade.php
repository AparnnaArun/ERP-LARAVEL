<div class="row">
                <div class="col-md-4">
                   
                       <div  class="actions " id="actions" ></div>
                        
                      </div>
                   
         </div>
         <div class="row">
                    <div class="table table-responsive">
                    <table class="table table-striped reporttable" id="mytable">
                      <thead>
                        <tr>
          <th>Date</th>           
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

     <td> {{\Carbon\Carbon::parse($cust->created_at)->format('j -F- Y') }}</td>
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
       <td > </td>
      <td style="color:red;"></td>
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
    var oTable = $('#mytable').DataTable({
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
         // $(api.table().footer()).html(api.column(8),{page:'current'}).nodes().sum();
         total = api.column( 7,{ search:'applied' }).data().sum();
           //total1 =api.column( 8 ).data().sum();
         $( api.column(7).footer() ).html(total.toFixed(3));
           
      
       }  
    });
// Adding action buttons to table
    new $.fn.dataTable.Buttons(oTable, {
      name: 'commands',
      buttons: [
        {extend:'copy', 
        className: 'btn btn-primary btn-xs text-dark'},
         {extend:'excel',
         className: 'btn btn-warning btn-xs text-dark'}, 
        {extend:'csv',
      className: 'btn btn-success btn-xs text-dark'}, 
          {extend: 'print',
          className: 'btn btn-danger btn-xs text-dark',

          footer:true,
           title: 'Stock As On Report',
          
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
             