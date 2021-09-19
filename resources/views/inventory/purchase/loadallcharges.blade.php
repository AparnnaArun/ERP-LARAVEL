@if(empty($pcost))
<div class="row" >
  <div class="col-md-3">
  </div>
          <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-dark text-white ">Add customs and freights</span>
                        </div>
                        
                          
                      </div>
                    </div>
                </div>
                <div class="col-md-3">
                </div>
              </div>
              @elseif(empty($charge))
<div class="row" >
  <div class="col-md-4">
  </div>
          <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Purchase Cost</span>
                        </div>
                        <input  class="form-control auto-calc pcost"  name="purchasecost" id="brand" readonly value="{{$pi->totalamount}}" >
                          
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                </div>
              </div>
              <div class="row" >
              @foreach($pcost->purchasecostdetail as $data)
                
                 
                 <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">{{$data->costfor}}</span>
                        </div>
                        <input  class="form-control auto-calc addcost"  name="" id="brand" value="{{$data->amount}}" readonly >
                          
                      </div>
                    </div>
                </div>
               
               
                @endforeach
                 </div>
                <div class="row" >
                  
                 <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Extra Cost</span>
                        </div>
                        <input  class="form-control auto-calc excost"  name="extracosts" id="brand" value="{{0}}" >
                          
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Total Extra Cost</span>
                        </div>
                        <input  class="form-control auto-calc texcost"  name="totalextracost" id="brand" value="{{0}}" readonly>
                          
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Extra Cost(%)</span>
                        </div>
                        <input  class="form-control auto-calc pexcost"  name="percentextracost" id="brand" value="0" readonly>
                          
                      </div>
                    </div>
                </div>
               
                </div>
                
                <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                <div class="table table-responsive">
                    <table class="table table-striped CostTable" id="CostTable">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Code</th>
                          <th>Item</th>
                          <th> Qnty</th>
                           <th>Pur.Cost</th>
                           <th>Exch Rate</th>
                           <th>KD Amt</th>
                           <th>Extra Cost</th>
                          <th>Tot KD</th>
                          <th>Tot Extra</th>
                          <th>Cost</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($pi->purchaseinvoicedetail as $items)
                    <tr>
      <th>{{$loop->iteration}}</th>
      <td><input type="hidden" class=""  name="code[]" 
      value="{{$items->item_code}}"  >{{$items->item_code}}</td>
      <td ><input type="hidden" class=""  name="item[]" 
      value="{{$items->item_name}}"  >{{$items->item_name}}</td>
     <td><input type="text" class="form-control auto-calc dqnty inputpadd"  name="qnty[]" 
      value="{{$items->balqnty}}" readonly ></td>
      <td><input type="text" class="form-control auto-calc drate inputpadd"  name="purcost[]" value="{{$items->rate}}"  readonly></td>
       <td ><input type="text" class="form-control auto-calc derate inputpadd"  name="erate[]" value="{{$pi->erate}}"  readonly></td>
       <td ><input type="text" class="form-control auto-calc dkdamt inputpadd"  name="kdamt[]" value="" readonly ></td>
       <td ><input type="text" class="form-control auto-calc decost inputpadd"  name="extracost[]" value="" readonly ></td>
       <td ><input type="text" class="form-control auto-calc dtkd inputpadd"  name="totalkd[]" readonly  ></td>
       <td ><input type="text" class="form-control auto-calc dtex inputpadd"  name="totalextra[]" value="" readonly ></td>
       <td ><input type="text" class="form-control auto-calc dcost inputpadd"  name="cost[]" value=""  readonly ></td>
      
     
     
    </tr>
                        @endforeach
                      </tbody>
                    </table>
                  
                </div>
              </div>
              </div>
              @else
              <div class="row" >
  <div class="col-md-4">
  </div>
          <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Purchase Cost</span>
                        </div>
                        <input  class="form-control auto-calc pcost"  name="purchasecost" id="brand" readonly value="{{$charge->purchasecost}}" >
                          
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                   
                       <div  class="actions " id="actions" ></div>
                        
                      </div>
              </div>
              <div class="row" >
              @foreach($pcost->purchasecostdetail as $data)
                
                 
                 <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">{{$data->costfor}}</span>
                        </div>
                        <input  class="form-control auto-calc addcost"  name="" id="brand" value="{{$data->amount}}" readonly >
                          
                      </div>
                    </div>
                </div>
               
               
                @endforeach
                 </div>
                <div class="row" >
                  
                 <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Extra Cost</span>
                        </div>
                        <input  class="form-control auto-calc excost"  name="extracosts" id="brand" value="{{$charge->extracost}}" >
                          
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Total Extra Cost</span>
                        </div>
                        <input  class="form-control auto-calc texcost"  name="totalextracost" id="brand" value="{{$charge->totalextracost}}" readonly>
                          
                      </div>
                    </div>
                </div>
                 <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Extra Cost(%)</span>
                        </div>
                        <input  class="form-control auto-calc pexcost"  name="percentextracost" id="brand" value="{{$charge->percentextracost}}" readonly>
                          
                      </div>
                    </div>
                </div>
               
                </div>
                
                <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                <div class="table table-responsive">
                    <table class="table table-striped CostTable" id="CostTable">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Code</th>
                          <th>Item</th>
                          <th> Qnty</th>
                           <th>Pur.Cost</th>
                           <th>Exch Rate</th>
                           <th>KD Amt</th>
                           <th>Extra Cost</th>
                          <th>Tot KD</th>
                          <th>Tot Extra</th>
                          <th>Cost</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($charhes as $items)
                    <tr>
      <th>{{$loop->iteration}}</th>
      <td><input type="hidden" class=""  name="code[]" 
      value="{{$items->code}}"  >{{$items->code}}</td>
      <td ><input type="hidden" class=""  name="item[]" 
      value="{{$items->item}}"  >{{$items->item}}</td>
     <td><input type="text" class="form-control auto-calc dqnty inputpadd"  name="qnty[]" 
      value="{{$items->qnty}}" readonly ></td>
      <td><input type="text" class="form-control auto-calc drate inputpadd"  name="purcost[]" value="{{$items->purcost}}"  readonly></td>
       <td ><input type="text" class="form-control auto-calc derate inputpadd"  name="erate[]" value="{{$items->erate}}"  readonly></td>
       <td ><input type="text" class="form-control auto-calc dkdamt inputpadd"  name="kdamt[]" value="{{$items->kdamt}}" readonly ></td>
       <td ><input type="text" class="form-control auto-calc decost inputpadd"  name="extracost[]" value="{{$items->extracost}}" readonly ></td>
       <td ><input type="text" class="form-control auto-calc dtkd inputpadd"  name="totalkd[]" readonly value="{{$items->totalkd}}" ></td>
       <td ><input type="text" class="form-control auto-calc dtex inputpadd"  name="totalextra[]" value="{{$items->totalextra}}" readonly ></td>
       <td ><input type="text" class="form-control auto-calc dcost inputpadd"  name="cost[]" value="{{$items->cost}}"  readonly ></td>
      
     
     
    </tr>
                        @endforeach
                      </tbody>
                    </table>
                  
                </div>
              </div>
              </div>
              @endif
              <script type="text/javascript">
    $(document).ready(function () {
                  var sum=0;
 $("input.addcost").each(function() {
  sum += +$(this).val();
  
  });
 excost =parseFloat($(".excost").val());
 x =parseFloat($(".pcost").val());
$(".texcost").val((sum + excost).toFixed(3));
y =sum + excost;
percent = (y*100)/x;
$(".pexcost").val(percent.toFixed(3));
$('.CostTable tbody tr').each(function () {
row = $(this);
dqnty = parseFloat(row.find("td input.dqnty").val());
drate = parseFloat(row.find("td input.drate").val());
derate = parseFloat(row.find("td input.derate").val());
row.find("td input.dkdamt").val((drate*derate).toFixed(3));
dkdamt =drate*derate;
decost=(dkdamt*percent)/100;
dtkd =dkdamt*dqnty;
dtex =decost*dqnty;
dcost =parseFloat(dkdamt) + parseFloat(decost);
row.find("td input.decost").val((decost).toFixed(3));
row.find("td input.dtkd").val((dtkd).toFixed(3));
row.find("td input.dtex").val((dtex).toFixed(3));
row.find("td input.dcost").val((dcost).toFixed(3));
//alert(drate);
  });

                });
    $(document).on("keyup change paste", ".auto-calc", function() {
                 var sum1=0;
 $("input.addcost").each(function() {
  sum1 += +$(this).val();
  
  });
 excost1 =parseFloat($(".excost").val());
 x1 =parseFloat($(".pcost").val());
$(".texcost").val((sum1 + excost1).toFixed(3));
y1 =sum1 + excost1;
percent1 = (y1*100)/x1;
$(".pexcost").val(percent1.toFixed(3));
$('.CostTable tbody tr').each(function () {
row1 = $(this);
dqnty1 = parseFloat(row1.find("td input.dqnty").val());
drate1 = parseFloat(row1.find("td input.drate").val());
derate1 = parseFloat(row1.find("td input.derate").val());
row1.find("td input.dkdamt").val((drate1*derate1).toFixed(3));
dkdamt1 =drate1*derate1;
decost1=(dkdamt1*percent1)/100;
dtkd1 =dkdamt1*dqnty1;
dtex1 =decost1*dqnty1;
dcost1 =parseFloat(dkdamt1) + parseFloat(decost1);
row1.find("td input.decost").val((decost1).toFixed(3));
row1.find("td input.dtkd").val((dtkd1).toFixed(3));
row1.find("td input.dtex").val((dtex1).toFixed(3));
row1.find("td input.dcost").val((dcost1).toFixed(3));

});
});
        $(document).ready(function ()
{

  $(function ()
  {
    var oTable = $('#CostTable').DataTable({
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
            title: 'GRN Report',
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