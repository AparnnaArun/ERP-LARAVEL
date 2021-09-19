<div class="col-lg-12 grid-margin stretch-card">
                <div class="table table-responsive">
                    <table class="table table-striped ItemGrid" id="ItemGrid">
                      <thead>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Item</th>
                            <th>Unit</th>
                            <th>Inv Bal Qnty</th>
                            <th>Inv Free Qnty</th>
                            <th>Rtn Qnty</th>
                            <!-- <th>Rtn Free Qnty</th>
                            <th>Damage</th> -->
                            <th>Rate</th>
                            <th>Discount</th>
                            <th>Total</th>
                            <th></th>
                          
                        </tr>
                      </thead>
                      <tbody>
@foreach($invs as $item)
<tr>
  
     <th scope="row"><input type="hidden" class="form-control auto-calc doitemid"  name="item_id[]" value="{{$item->item_id}}" id="doitemid"  >
      
      <input type="hidden" class="form-control auto-calc"  name="mainid[]" value="{{$item->id}}" id=""  >
      <input type="hidden" class="form-control auto-calc"  name="invid[]" value="{{$item->inv_id}}" id=""  >{{$loop->iteration}}</th>
    
        <td><input type="hidden" class="form-control "  name="item_code[]" value="{{$item->item_code}}" id=""  >{{$item->item_code}}</td>
      <td><input type="hidden" class="form-control "  name="item_name[]" value="{{$item->item_name}}" id=""  >
      {{$item->item_name}}</td>
      
      <td><input type="hidden" class="form-control"  name="unit[]" value="{{$item->unit}}" id="unit[]"  ><input type="hidden" class="form-control auto-calc  inputpadd"  name="batch[]" value="{{$item->batch}}" id=""  placeholder="Rates" required="required">{{$item->unit}}</td>
      
      <td>
        <input type="hidden" class="form-control auto-calc invqnty inputpadd"  name="salesquantity[]" value="{{$item->quantity}}" id=""   >{{$item->penrtn_qnty}}</td>
        <td>
        <input type="hidden" class="form-control auto-calc  inputpadd"  name="isslnrtn_qnty[]" value="{{$item->isslnrtn_qnty}}" id=""   >
        <input type="hidden" class="form-control auto-calc  inputpadd"  name="penrtn_qnty[]" value="{{$item->penrtn_qnty}}" id=""   >
        <input type="hidden" class="form-control auto-calc invfqnty inputpadd"  name="freeqnty[]" value="{{$item->freeqnty}}" id=""   >{{$item->freeqnty}}</td>
     <td>
      @if($item->invoicefrom=='0')
      <input type="text" class="form-control auto-calc rtnqnty inputpadd"  name="rtnqnty[]" value="{{0}}" id="" required>
      @else

      <input type="text" class="form-control auto-calc rtnqnty rttqty inputpadd"  name="rtnqnty[]" value="" id=""  readonly="" data-id="{{$item->item_id}}" placeholder="Click Here">
     @endif
     <div class="alrtss" style="color:red;display:none;">Rtn Qnty should be less than Inv qnty</div>
   </td>
   <!-- <td>
      <input type="text" class="form-control auto-calc rtnfqnty inputpadd"  name="rtnfreeqnty[]" value="0" id=""   >
     
     
   </td>
    <td>
      <input type="text" class="form-control auto-calc damage inputpadd"  name="damage[]" value="0" id=""   >
     
     
   </td> -->
    <td>
      <input type="hidden" class="form-control auto-calc rate inputpadd"  name="rate[]" value="{{$item->rate}}" id=""   >
      <input type="hidden" class="form-control auto-calc cost inputpadd"  name="cost[]" value="{{$item->cost}}" id=""   >
     {{$item->rate}}
     
   </td>
   
     <td><input type="text" class="form-control auto-calc disc inputpadd"  name="discount[]" value="0" id=""   ></td>
    
     <td><input type="text" class="form-control auto-calc salammmt inputpadd"  name="amount[]" value=""   readonly data-id="{{$item->item_id}}">
      <input type="hidden" class="form-control auto-calc costammmt inputpadd"  name="totalcost[]" value="" id=""  readonly data-id="{{$item->item_id}}" ></td>
     
   
      <td ><i class="mdi mdi-delete-forever btn-danger" id="remove"></i></td>
    </tr>
    @endforeach
      </tbody>
                    </table>
                 <input type="hidden" class="form-control "  name="" value="{{$enqno->deli_note_no}}" id="dlnid"   > 
                 invoicefrom
                 <input type="hidden" class="form-control "  name="invoicefrom" value="{{$enqno->invoicefrom}}"    >
                </div>
              </div>
    <script type="text/javascript">
   $(".rttqty").click(function(){
    row11 = $(this).closest("tr");
reqqnty = row11.find("td input.invqnty").val();
rsrate = row11.find("td input.rate").val();
cost =row11.find("td input.cost").val();
  itemid = $(this).data('id');
  dlnid=$("#dlnid").val();
   token = $("#token").val();
   action='Rtn Qnty'
   //alert(dlnid);
              $.ajax({
         type: "POST",
         url: "{{url('loaddortnqnties')}}", 
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
  $(document).on("keyup change paste", ".auto-calc", function() {
    rowc = $(this).closest("tr");
    invqnty = parseFloat(rowc.find("td input.invqnty").val());
    invfqnty = parseFloat(rowc.find("td input.invfqnty").val());
    rtnqnty = parseFloat(rowc.find("td input.rtnqnty").val());
    // rtnfqnty = parseFloat(rowc.find("td input.rtnfqnty").val());
    // damage = parseFloat(rowc.find("td input.damage").val());
    rate= parseFloat(rowc.find("td input.rate").val());
    cost = parseFloat(rowc.find("td input.cost").val());
    disc = parseFloat(rowc.find("td input.disc").val());
    
    trtnqnty = rtnqnty ;
    tinvqnty = invqnty + invfqnty;
    //alert( trtnqnty);
  if(trtnqnty > tinvqnty ){
rowc.find($(".alrtss")).show();
         }
     else{
  rowc.find($(".alrtss")).hide();
   salammmt = ((rtnqnty  * rate) - disc) ;
  costammmt   = (trtnqnty * cost);
   rowc.find("td input.salammmt").val(salammmt.toFixed(3));
    rowc.find("td input.costammmt").val(costammmt.toFixed(3));
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