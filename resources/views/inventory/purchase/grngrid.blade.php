 <thead>
                        <tr>
                          <th>#</th>
                          <th>Code</th>
                          <th>Item</th>
                          <th>Unit</th>
                          <th>Batch</th>
                          <th>GRN Qnty</th>
                          <th> Qnty</th>
                          <th>Free Qnty</th>
                          <th>Rate</th>
                          <th>Amount</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
@foreach($grns as $item)
<tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><input type="hidden" class="form-control "  name="item_code[]" value="{{$item->item_code}}"  >
        {{$item->item_code}}</td>
      <td><input type="hidden" class="form-control gridid"  name="item_id[]" value="{{$item->item_id}}" id="item_id"  >
      	<input type="hidden" class="form-control "  name="item_name[]" value="{{$item->item_name}}" id=""  >{{$item->item_name}}</td>
     
      <td><input type="hidden" class="form-control"  name="unit[]" value="{{$item->unit}}"  >{{$item->unit}}</td>
      <td class="batchs1"  data-id="{{$item->item_id}}"><input type="hidden" class="form-control batchs"  name="batchs[]" value=""  data-id="{{$item->item_id}}" ></td>
      <td><!--  -->
        <input type="hidden" class="form-control totqnty"  name="" value="{{$item->sumqnty}}"  >{{$item->sumqnty}}</td>
      <td><input type="text" class="form-control auto-calc invqnty inputpadd"  name="quantity[]" value="" data-id="{{$item->item_id}}"   placeholder="Quantity" readonly></td>
      <td><input type="text" class="form-control auto-calc freeqnty inputpadd"  name="freeqnty[]" value="0" id="qnty"  placeholder=" Free Quantity" ></td>
       <td><input type="text" class="form-control auto-calc rate inputpadd"  name="rate[]" value="0" id="rate"  placeholder="Rate" required="required" ></td>
        <td><input type="text" class="form-control auto-calc amount inputpadd"  name="total[]" value="0" id="amount"  placeholder="Amount" required="required"></td>
      <td ><button id="remove" class="btn btn-danger btn-xs buttons "><i class="mdi mdi-delete-forever"></i></button> <input type="hidden" class="form-control "  name="" value="{{implode(',',$grng)}}" id="grnid"   ></td>
     
     
    </tr>
    @endforeach
  </tbody>

    <script type="text/javascript">
  $(document).on("keyup change paste", ".auto-calc", function() {
  row = $(this).closest("tr");
    first = parseFloat(row.find("td input.invqnty").val());
    second = parseFloat(row.find("td input.rate").val());
   row.find("td input.amount").val((first*second).toFixed(3));
 var sums = 0;
  var sums1 = 0;
    $("input.qnty").each(function() {
  sums += +$(this).val();
  
  });
      $("input.amount").each(function() {
  sums1 += +$(this).val();
  
  });
      $(".tqnty").val(sums.toFixed(3));
      $(".tamount,.gridtotal,.nettotal").val(sums1.toFixed(3));
});
  
$(".invqnty").click(function(){
    row11 = $(this).closest("tr");
reqqnty = row11.find("td input.totqnty").val();
itemid = $(this).data('id');
  grnid=$("#grnid").val();
   token = $("#token").val();
   //alert(grnid);
              $.ajax({
         type: "POST",
         url: "{{url('loadgrnqnties')}}", 
         data: {_token: token,itemid:itemid,reqqnty:reqqnty,grnid:grnid},
         dataType: "html",  
         success: 
              function(result){
             
                $(".result").html(result);
               $('.grnstock').modal('show')
              }
          });

                });

</script>