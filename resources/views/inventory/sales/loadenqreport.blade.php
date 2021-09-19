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
       <th>Enq#</th>
       <th>Customer</th>
       <th>Code</th>
       <th>Items</th>
       <th>Unit</th>
       <th> Qnty</th>
       
       </tr>
                      </thead>
                      <tbody>
                        @foreach($custs as $cust)
    <tr>

      
      <td>{{ \Carbon\Carbon::parse($cust->dates)->format('j -F- Y')  }}</td>
      <td>{{$cust->enq_no}}</td>
      <td>{{$cust->name}}</td>
      
      <td>@foreach($cust->salesenquirydetails as $cuu1) <span style="color: red;">*</span> {{ $cuu1->code}} <br/>@endforeach</td>
      <td>@foreach($cust->salesenquirydetails as $cuu2)<span style="color: red;">*</span> {{ $cuu2->item_name}} <br/>@endforeach</td>
      <td>@foreach($cust->salesenquirydetails as $cuu)<span style="color: red;">*</span> {{ $cuu->unit}} <br/>@endforeach</td>
      <td>@foreach($cust->salesenquirydetails as $cuu)<span style="color: red;">*</span>
       {{ $cuu->quantity}} <br/>@endforeach</td>
      
     
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
         className: 'btn btn-warning btn-xs text-dark',
       exportOptions: {
    format: {
        footer: function ( data, row, column, node ) {
              // `column` contains the footer node, apply the concat function and char(10) if its newline class
               if ($(column).hasClass('newline')) {
                    //need to change double quotes to single
                    data = data.replace( /"/g, "'" );
                    //split at each new line
                    splitData = data.split('<br>');
                    data = '';
                    for (i=0; i < splitData.length; i++) {
                        //add escaped double quotes around each line
                        data += '\"' + splitData[i] + '\"';
                        //if its not the last line add CHAR(13)
                        if (i + 1 < splitData.length) {
                            data += ', CHAR(10), ';
                        }
                    }
                    //Add concat function
                    data = 'CONCATENATE(' + data + ')';
                    return data;
                }
                return data;
            }
        }
    
},}, 
        {extend:'csv',
      className: 'btn btn-success btn-xs text-dark'}, 
          {extend: 'print',
          className: 'btn btn-danger btn-xs text-dark',
            title: 'Enquiry Report',
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