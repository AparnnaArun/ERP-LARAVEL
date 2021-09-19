<div class="row">
          <div class="col-md-4">
                   
                       <div  class="actions " id="actions" ></div>
                        
                      </div>
                    </div>
                    <div class="row">
                    <div class="table table-responsive">
                    <table class="table table-striped reporttable" id="reporttable">
                      <thead>
                        <tr>
                     
                          <th>Date</th>
       <th>DO#</th>
       <th>Customer</th>
       <th>SO.NO</th>
       <th>Code</th>
       <th>Items</th>
       <th>Unit</th>
       <th>DO Qnty</th>
       <th>DO Rtn Qnty</th>
       <th>Inv Qnty</th>
       <th>Bal Qnty</th>
       <th>Status</th>
       </tr>
                      </thead>
                      <tbody>
                        @foreach($custs as $cust)
    <tr>

      
      <td>{{ \Carbon\Carbon::parse($cust->dates)->format('j -F- Y')  }}</td>
      <td><a href="/inventory/delivery-note/{{$cust->id}}">{{$cust->deli_note_no}}</a></td>
      <td><a href="/inventory/customer-view/{{$cust->customer}}">{{$cust->name}}</a></td>
      <td><a href="/inventory/sorder/{{$cust->so_no}}">{{$cust->order_no}}</a></td>
      <td>@foreach($cust->deliverynotedetail as $cuu1) <span style="color: red;">*</span> {{ $cuu1->code}} <br/>@endforeach</td>
      <td>@foreach($cust->deliverynotedetail as $cuu2)<span style="color: red;">*</span> {{ $cuu2->item}} <br/>@endforeach</td>
      <td>@foreach($cust->deliverynotedetail as $cuu)<span style="color: red;">*</span> {{ $cuu->unit}} <br/>@endforeach</td>
      <td>@foreach($cust->deliverynotedetail as $cuu)<span style="color: red;">*</span> {{ $cuu->quantity}} <br/>@endforeach</td>
      <td>@foreach($cust->deliverynotedetail as $cuu)<span style="color: red;">*</span> {{ $cuu->dortn_qnty}} <br/>@endforeach</td>
      <td>@foreach($cust->deliverynotedetail as $cuu)<span style="color: red;">*</span> {{ $cuu->inv_qnty}} <br/>@endforeach</td>
   <td>@foreach($cust->deliverynotedetail as $cuu)<span style="color: red;">*</span> {{ $cuu->bal_qnty}} <br/>@endforeach</td>
    <td>@if(($cust->is_invoiced)==1) Fully Invoiced @elseif($cust->is_invoiced==2) Partially Invoiced @elseif($cust->is_dortn=='1') Fully Returned @elseif($cust->is_invoiced=='2') Partially Returned @else Not Invoiced Or returned @endif</td>
     
    </tr>
   @endforeach
                      </tbody>
                    </table>
                  </div>
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
            title: 'Delivery Note Report',
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