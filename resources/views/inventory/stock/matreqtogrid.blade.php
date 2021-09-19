@foreach($matreq as $item)
$amt =$item->cost * $item->bal_qnty;
<tr>
     <th scope="row"><input type="hidden" class="form-control auto-calc doitemid"  name="mainid[]" value="{{$item->id}}" id="doitemid"  >
     	<input type="hidden" class="form-control auto-calc mattemid "  name="item_id[]" value="{{$item->item_id}}" id=""  >{{$loop->iteration}}</th>
    
        <td><input type="hidden" class="form-control "  name="item_code[]" value="{{$item->code}}" id=""  >{{$item->code}}</td>
      <td><input type="hidden" class="form-control "  name="item[]" value="{{$item->item_name}}" id=""  >
      {{$item->item_name}}</td>
      
      <td><input type="hidden" class="form-control"  name="unit[]" value="{{$item->unit}}" id="unit[]"  ><input type="hidden" class="form-control auto-calc batchs inputpadd"  name="batch[]" value="" id=""  placeholder="Rates" data-id="{{$item->item_id}}" required="required">{{$item->unit}}</td>
      
    <td><input type="hidden" class="form-control reqqnties"  name="reqq_qnty[]" value="{{$item->bal_qnty}}" id="unit[]"  >{{$item->bal_qnty}}</td>
    <td><input type="text" class="form-control issqnty"  name="issue_qnty[]" value="" data-id="{{$item->item_id}}" readonly="" placeholder="Click Here" ></td>
    <td><input type="hidden" class="form-control auto-calc  inputpadd"  name="rate[]" value="{{$item->cost}}" id=""  placeholder="Rates" required="required">{{$item->cost}}</td>
      <td><input type="text" class="form-control auto-calc amount inputpadd"  name="total[]" value="" id=""  placeholder="Amount" data-id="{{$item->item_id}}" required></td>
     <td ><button id="remove" class="btn btn-danger btn-xs buttons "><i class="mdi mdi-delete-forever"></i></button></td>
    </tr>
@endforeach
    <script type="text/javascript">
 
  $(".issqnty").click(function(){
    row11 = $(this).closest("tr");
reqqnty = row11.find("td input.reqqnties").val();
  itemid = $(this).data('id');
  token = $("#token").val();
              $.ajax({
         type: "POST",
         url: "{{url('getcurrentstockmatreq')}}", 
         data: {_token: token,itemid:itemid,reqqnty:reqqnty},
         dataType: "html",  
         success: 
              function(result){
             
                $(".poppup").html(result);
               $('.currenytstock').modal('show');
               
              }
          });

                })
sumss =0;
$(".ItemGrid .amount").each(function() {
sumss += +$(this).val();
   });
$(".totalcost").val(sumss.toFixed(3));
</script>