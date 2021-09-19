                  <div class="row">
                    <div class="col-md-4">
                   
                       <div  class="actions " id="actions" ></div>
                        <input type="hidden" class="head" value="{{$action}}">
                      </div>
                  </div>
                    <table class="table table-striped reporttable" id="reporttable">
                      <thead>
                        <tr>
                     
                          <th>#</th>
       <th>Invoice#</th>
       <th>Income</th>
       <th>Expense</th>
       <th>Tot.Profit</th>
       <th>Exe.Profit</th>
      
                          </tr>
                      </thead>
                      <tbody>
                         @foreach($comm as $custs)
                    
    <tr>

      
      <td>{{ $loop->iteration  }}</td>
      <td>{{$custs->invoice_no}}</td>

      
     <td> {{ $custs->total_amount}} </td>
     <td> {{ $custs->totcost}} </td>
     <td> {{ $custs->profit}} </td>
     <td> {{ $custs->profitpay}} </td>
    </tr>
@endforeach

                                     <tfoot>                              
     
    <tr>
      <td >Total</td>
      <td >  </td>
      <td > </td>
      <td > </td>
     <td > </td>
      <td ><span style="float:right;"id ='totalSalary'> </span> </td>
      
     
      
     
    </tr>
  </tfoot>
                      </tbody>
                    </table>
                  </div>

             
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
      //   total = api.column( 3,{ search:'applied' }).data().sum();
      // $( api.column(3).footer() ).html(total.toFixed(3));
        var apii = this.api();
        totals = apii.column( 4,{ search:'applied' }).data().sum();
      $( apii.column(4).footer() ).html(totals.toFixed(3)); 
      var ap = this.api();
        tota = ap.column( 5,{ search:'applied' }).data().sum();
      $( ap.column(5).footer() ).html(tota.toFixed(3));
      
       }  // Reorders columns
      
      
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
          footer:true,
            title: function(){
                var d = $(".head").val();
          return d +' Commission Report'; 
             },
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
