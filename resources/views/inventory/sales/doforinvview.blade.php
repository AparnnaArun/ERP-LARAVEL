  <input type="hidden" class="form-control auto-calc"  name="" value="{{$customer->specialprice}}" id="specialprice"  >
 <div class="col-lg-12 grid-margin stretch-card">
 
                  <div class="table table-responsive">
                    <table class="table table-striped ItemGrid" id="ItemGrid">
                      <thead>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Item</th>
                            <th>Unit</th>
                            <th>Batch</th>
                            <th>DO Qnty</th>
                            <th>Invoice Qnty</th>
                            <th>Selling Rate</th>
                            <th>Discount</th>
                            <th>Free Qnty</th>
                            <th>Total</th>
                            <th></th>
                          
                        </tr>
                      </thead>
                      <tbody>
            @foreach($eenqs as $item)
            
  
                        <tr>
     <th scope="row"><input type="hidden" class="form-control auto-calc doitemid"  name="item_id[]" value="{{$item->item_id}}" id="doitemid"  >
     
      {{$loop->iteration}}</th>
    
        <td><input type="hidden" class="form-control "  name="item_code[]" value="{{$item->code}}" id=""  >{{$item->code}}</td>
      <td><input type="hidden" class="form-control "  name="item_name[]" value="{{$item->item}}" id=""  >
      {{$item->item}}</td>
      
      <td><input type="hidden" class="form-control"  name="unit[]" value="{{$item->unit}}" id="unit[]"  >{{$item->unit}}</td>
      <td class="batchs1" data-id="{{$item->item_id}}"><input type="hidden" class="form-control batchs"  name="" value="" id="" data-id="{{$item->item_id}}" ></td>
      <td>
       
        <input type="hidden" class="form-control auto-calc totqnty inputpadd"  name="dobty[]" value="{{$item->sumqnty}}" id=""   >
         {{$item->sumqnty}}</td>
        <td>
        <input type="text" class="form-control auto-calc invqnty inputpadd"  name="quantity[]" value="" id=""  readonly  data-id="{{$item->item_id}}" placeholder="Click Here">
      <div class="alrtss1" style="color:red;display:none;">Invoice Qnty less than or equal DO qnty</div>
    </td>
     <td>
      <input type="text" class="form-control auto-calc enterrate inputpadd"  name="rate[]" value="{{$item->retail_salesrate}}" id=""   >
      <input type="hidden" class="form-control auto-calc rsrate inputpadd"  name="" value="{{$item->retail_salesrate}}" id=""   >
     <input type="hidden" class="form-control auto-calc wsrate inputpadd"  name="" value="{{$item->wholesale_salesrate}}" id=""   >
     <div class="alrtss" style="color:red;display:none;">You cannot sell this item lower than wholesale price({{$item->wholesale_salesrate}})</div>
     <div class="alrtsscost" style="color:red;display:none;">You cannot sell this item lower than cost({{$item->cost}})</div>
   </td>
     <td><input type="text" class="form-control auto-calc disc inputpadd"  name="discount[]" value="0" id=""   ></td>
     <td><input type="text" class="form-control auto-calc freeqnty inputpadd"  name="freeqnty[]" value="0" id=""   ></td>
     <td><input type="text" class="form-control auto-calc salammmt inputpadd"  name="amount[]" value="0" id=""  readonly  data-id="{{$item->item_id}}">
      <input type="hidden" class="form-control auto-calc costammmt inputpadd"  name="totalcost[]" value="0" id=""  data-id="{{$item->item_id}}" >
     <input type="hidden" class="form-control auto-calc cost inputpadd"  name="" value="{{$item->cost}}" id=""   ></td>
   
      <td ><i class="mdi mdi-delete-forever btn-danger" id="remove"></i></td>
    </tr>
    @endforeach
                        
                      </tbody>
                    </table>
                  
                </div>
              </div>
              <input type="hidden" class="form-control "  name="" value="{{implode(',',$enqno)}}" id="dlnid"   >
                  <script type="text/javascript">
 
 $(".invqnty").click(function(){
    row11 = $(this).closest("tr");
reqqnty = row11.find("td input.totqnty").val();
rsrate = row11.find("td input.rsrate").val();
cost =row11.find("td input.cost").val();
  itemid = $(this).data('id');
  dlnid=$("#dlnid").val();
   token = $("#token").val();
   action='Choose'
   //alert(dlnid);
              $.ajax({
         type: "POST",
         url: "{{url('loaddoqnties')}}", 
         data: {_token: token,itemid:itemid,reqqnty:reqqnty,dlnid:dlnid,
                rsrate:rsrate,cost:cost,action:action},
         dataType: "html",  
         success: 
              function(result){
             
                $(".poppup").html(result);
               $('.currenytstock').modal('show')
              }
          });

                });


  // $(document).ready(function(){
  //   var sums = 0;
  //   var sums1 = 0;
  //   $("input.salammmt").each(function() {
  // sums += +$(this).val();
  
  // });
  //    $("input.costammmt").each(function() {
  // sums1 += +$(this).val();
  
  // });
  //   $(".gridtotal,.nettotal").val(sums.toFixed(3));
  //  $(".totalcost").val(sums1.toFixed(3));

  // });
  $(document).on("keyup change paste", ".auto-calc", function() {
    rowc = $(this).closest("tr");
    rsrate = parseFloat(rowc.find("td input.rsrate").val());
    wsrate = parseFloat(rowc.find("td input.wsrate").val());
    disc = parseFloat(rowc.find("td input.disc").val());
    totqnty = parseFloat(rowc.find("td input.totqnty").val());
    invqnty =parseFloat(rowc.find("td input.invqnty").val());
    freeqnty1 = parseFloat(rowc.find("td input.freeqnty").val());
    salammmt = parseFloat(rowc.find("td input.salammmt").val());
    costammmt = parseFloat(rowc.find("td input.costammmt").val());
    cost = parseFloat(rowc.find("td input.cost").val());
     enterrate = parseFloat(rowc.find("td input.enterrate").val());
     specialprice = $('#specialprice').val();
     //alert(specialprice);
     tqnty = invqnty + freeqnty1;
  if(enterrate < wsrate && specialprice=='0'){
rowc.find($(".alrtss")).show();
}
else if(enterrate < cost && specialprice=='1'){
rowc.find($(".alrtsscost")).show();
  }
  else if(totqnty < tqnty){
rowc.find($(".alrtss1")).show();
         }
     else{
  rowc.find($(".alrtss,.alrtss1,.alrtsscost")).hide();
   salammmt = (((invqnty) * enterrate) - disc) ;
   costammmt1 = tqnty * cost;
   rowc.find("td input.salammmt").val(salammmt.toFixed(3));
   rowc.find("td input.costammmt").val(costammmt1.toFixed(3));
          }
  var sum = 0;
  var sum1 = 0;
   $("input.salammmt").each(function() {
  sum += +$(this).val();
 
          });
   $("input.costammmt").each(function() {
  sum1 += +$(this).val();
 
          });
$(".gridtotal,.nettotal").val(sum.toFixed(3));
$(".totalcost").val(sum1.toFixed(3));
          });

</script>