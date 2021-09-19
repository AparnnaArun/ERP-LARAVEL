<tr>
     <th scope="row"><input type="hidden" class="form-control auto-calc doitemid"  name="item_id[]" value="{{$item->id}}" id="doitemid"  >{{$item->id}}<input type="hidden" class="form-control auto-calc"   value="{{$customer->specialprice}}" id="specialprice"  ></th>
    
        <td><input type="hidden" class="form-control "  name="item_code[]" value="{{$item->code}}" id=""  >{{$item->code}}</td>
      <td><input type="hidden" class="form-control "  name="item_name[]" value="{{$item->item}}" id=""  >
      {{$item->item}}</td>
      
      <td><input type="hidden" class="form-control"  name="unit[]" value="{{$item->basic_unit}}" id="unit[]"  >{{$item->basic_unit}}</td>
      <td>
        <input type="hidden" class="form-control auto-calc  inputpadd"  name="batch[]" value="{{$stock->batch}}" id=""  placeholder="Rates" required="required">{{$stock->batch}}</td>
      <td>
        <input type="hidden" class="form-control auto-calc totqnty inputpadd"  name="quantity[]" value="{{$totqnty}}" id=""   >{{$totqnty}}</td>
     <td>
      <input type="text" class="form-control auto-calc enterrate inputpadd"  name="rate[]" value="{{$item->retail_salesrate}}" id=""   >
      <input type="hidden" class="form-control auto-calc rsrate inputpadd"  name="" value="{{$item->retail_salesrate}}" id=""   >
     <input type="hidden" class="form-control auto-calc wsrate inputpadd"  name="" value="{{$item->wholesale_salesrate}}" id=""   >
     <div class="alrtss" style="color:red;display:none;">This price is lower than wholesale price<b>({{$item->wholesale_salesrate}})</b></div>
     <div class="alrtsscost" style="color:red;display:none;">This price is lower than Cost<b>({{$item->cost}})</b></div>
   </td>
     <td><input type="text" class="form-control auto-calc disc inputpadd"  name="discount[]" value="0" id=""   ></td>
     <td><input type="text" class="form-control auto-calc freeqnty inputpadd"  name="freeqnty[]" value="0" id=""   ></td>
     <td><input type="text" class="form-control auto-calc salammmt inputpadd"  name="amount[]" value="{{$ammt}}" id=""  readonly >
      <input type="hidden" class="form-control auto-calc costammmt inputpadd"  name="totalcost[]" value="{{$costt}}" id=""   >
     <input type="hidden" class="form-control auto-calc cost inputpadd"  name="" value="{{$item->cost}}" id=""   ></td>
   
      <td ><button id="remove" class="btn btn-danger btn-xs buttons "><i class="mdi mdi-delete-forever"></i></button></td>
    </tr>
    <script type="text/javascript">
  $(document).ready(function(){
    var sums = 0;
    var sums1 = 0;
    $("input.salammmt").each(function() {
  sums += +$(this).val();
  
  });
     $("input.costammmt").each(function() {
  sums1 += +$(this).val();
  
  });
    $(".gridtotal,.nettotal").val(sums.toFixed(3));
   $(".totalcost").val(sums1.toFixed(3));

  });
  $(document).on("keyup change paste", ".auto-calc", function() {
    rowc = $(this).closest("tr");
    rsrate = parseFloat(rowc.find("td input.rsrate").val());
    wsrate = parseFloat(rowc.find("td input.wsrate").val());
    disc = parseFloat(rowc.find("td input.disc").val());
    totqnty = parseFloat(rowc.find("td input.totqnty").val());
    freeqnty1 = parseFloat(rowc.find("td input.freeqnty").val());
    salammmt = parseFloat(rowc.find("td input.salammmt").val());
    costammmt = parseFloat(rowc.find("td input.costammmt").val());
    cost = parseFloat(rowc.find("td input.cost").val());
     enterrate = parseFloat(rowc.find("td input.enterrate").val());
     specialprice = parseFloat(rowc.find("th input#specialprice").val());
  if(enterrate < wsrate && specialprice=='0'){
rowc.find($(".alrtss")).show();
         }
         else if(enterrate < cost && specialprice=='1'){
rowc.find($(".alrtsscost")).show();
//rowc.find("td input.enterrate").val("");
  }
     else{
  rowc.find($(".alrtss,.alrtsscost")).hide();
   salammmt = (((totqnty - freeqnty1) * enterrate) - disc) ;
   rowc.find("td input.salammmt").val(salammmt.toFixed(3));
          }
  var sum = 0;
   $("input.salammmt").each(function() {
  sum += +$(this).val();
 
          });
$(".gridtotal,.nettotal").val(sum.toFixed(3));
          });


</script>