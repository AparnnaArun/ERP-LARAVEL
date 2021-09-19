 <div class="row">
          
                  <div class="col-md-2">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Code</span>
                        </div>
                       <input  class="form-control inputpadd" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="" id="" value="{{$items->code}}" readonly="">
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Unit</span>
                        </div>
                       <input  class="form-control inputpadd" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="" id="" value="{{$items->basic_unit}}" readonly="">
                       <input  type="hidden" class="form-control inputpadd" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="" id="itemname" value="{{$items->item}}" readonly="">
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Current Qnty</span>
                        </div>
                       <input  class="form-control inputpadd" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="" id="" value="{{$curr->sum}}" readonly="">
                        
                      </div>
                    </div>
                </div>
               
                <div class="col-md-4">
                   
                       <div  class="actions " id="actions" ></div>
                        
                      </div>
                   
         </div>
                 
           <div class="table table-responsive ">
                   
                  <table class="table table-striped reporttable" id="reporttable">
                      <thead>
                        <tr>
          <th>Date</th>           
          <th>Description</th>
       <th>Qnty In</th>
       <th>Qnty Out</th>
      
       </tr>
                      </thead>
                      <tbody>
                        @foreach($stocks as $cust)
    <tr>

     <td> {{\Carbon\Carbon::parse($cust->voucher_date)->format('j -F- Y') }}</td>
      <td>{{ $cust->description }}</td>
      
      <td>@if($cust->status=='IN'){{$cust->quantity}} @else {{0.000}} @endif</td>
      <td>@if($cust->status=='OUT'){{$cust->quantity}} @else {{0.000}} @endif</td>
      
     
    </tr>
   @endforeach
   
   
                      </tbody>
                    </table>
                  </div>
               <!--  </div> -->
                  
             
             
             
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
                var d = $("#itemname").val();
          return d + ' Movement Report' 
             },
     }, 
        {extend:'csv',
      className: 'btn btn-success btn-xs text-dark'}, 
          {extend: 'print',
          className: 'btn btn-danger btn-xs text-dark',
            title:  function(){
                var d = $("#itemname").val();
          return d + ' Movement Report' 
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

    $("#").datepicker({
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