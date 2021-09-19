@for ($x = 1; $x <= 10; $x++) 
<tr>
      <th scope="row">{{$x}}
      <input type="hidden" class="form-control borc inputpadd "  name="borc" value="{{ $borc }}"   >
    <input type="hidden" class="form-control voucher inputpadd "  name="voucher" value="{{ $voucher }}"   ></th>
      <td><button type="button" class="btn btn-gradient-success btn-xs btn-fw dr">DR</button><button type="button" class="btn btn-gradient-primary btn-xs btn-fw cr">CR</button></td>
      <td class="results"><select  class="form-control inputpadd"  name="overhead_type" value="{{ old('short_name') }}"  >
      <option value="" hidden>Account</option>
      </select></td>
      <td ><input type="text" class="form-control inputpadd "  name="narration[]" value="{{ old('narration') }}"   >
                       </td>
     <td><input type="text" class="form-control  inputpadd"  name="cheque_no[]" value="{{ old('cheque_no') }}"  >
                       </td>
     <td><input type="text" class="form-control  datepicker inputpadd"  name="cheque_date[]" value="{{ old('cheque_date') }}"  >
                       </td>
     <td><input type="text" class="form-control  inputpadd"  name="cheque_bank[]" value="{{ old('cheque_bank') }}"  >
                       </td>
     <td><input type="text" class="form-control  datepicker inputpadd"  name="cheque_clearance[]" value="{{ old('cheque_clearance') }}"  >
                       </td>
     <td><input type="text" class="form-control auto-calc debt inputpadd"  name="amount[]" value="{{ old('name') }}" disabled >
                       </td>
     <td><input type="text" class="form-control  auto-calc cred inputpadd"  name="amount[]" value="{{ old('name') }}"  disabled>
                       </td>
          
     
    </tr>
    @endfor
    <script type="text/javascript">
          $(document).ready(function () {
    $(".datepicker").datepicker(
      { dateFormat: 'dd-M-yy',
      changeYear: true,
      yearRange: "-100:+0",
      changeMonth: true}).datepicker("setDate",'now');
  
});
$('.dr').click(function(){
    row = $(this).closest('tr');
    vouchers = $(".voucher").val();
    borc = $(".borc").val();
  action = 'debt';
 
  row.find('.debt').prop('disabled',false);
  row.find('.dr').addClass('btn-gradient-warning');
    row.find('.cred').prop('disabled',true);
    row.find('.cred').val('0.000');
    row.find('.cr').removeClass('btn-gradient-warning');
$.ajax({ 
         type: "POST",
         url: "{{url('creditdebit')}}", 
         data: {_token:csrf,vouchers:vouchers,borc:borc,action:action},
         dataType: "html",  
         success: 
              function(data){
              //alert(data);
        row.find('.results').html(data);
                  }
          });
});
$('.cr').click(function(){
    row = $(this).closest('tr');
    vouchers = $(".voucher").val();
    borc = $(".borc").val();
  action = 'cred';

  row.find('.cred').prop('disabled',false);
  row.find('.cr').addClass('btn-gradient-warning');
    row.find('.debt').prop('disabled',true);
    row.find('.debt').val('0.000');
    row.find('.dr').removeClass('btn-gradient-warning');
$.ajax({ 
         type: "POST",
         url: "{{url('creditdebit')}}", 
         data: {_token:csrf,vouchers:vouchers,borc:borc,action:action},
         dataType: "html",  
         success: 
              function(data){
                //alert(data);
              row.find('.results').html(data);
                  }
          });
});  
///// Calculation Part//////////////////
  $(document).on("keyup change paste", ".auto-calc", function() {
  row = $(this).closest("tr");
first = row.find("td input.debt").val();
  var sum =0;
 $("input.debt").each(function() {
  sum += +$(this).val();
  });
 $('.totdebit').val(sum.toFixed(3));
 var sum1 =0;
 $("input.cred").each(function() {
  sum1 += +$(this).val();
  });
 $('.totcredit').val(sum1.toFixed(3));

   }); 
   /////////////////Automatic Sum Capture///////

   $('.cred').click(function(){
row1 = $(this).closest('tr');
var debb = $('.totdebit').val();
var credd = $('.totcredit').val();
var bal = debb - credd;
row1.find("td input.cred").val(bal);
});
$('.debt').click(function(){
row2 = $(this).closest('tr');
var debb1 = $('.totdebit').val();
var credd1 = $('.totcredit').val();
var bal1 =  credd1-debb1 ;
row2.find("td input.debt").val(bal1);
});
$('.cr').click(function(){
var sum5 =0;
 $("input.cred").each(function() {
  sum5+= +$(this).val();
  });
 $('.totcredit').val(sum5.toFixed(3));
var sum6 =0;
 $("input.debt").each(function() {
  sum6+= +$(this).val();
  });
 $('.totdebit').val(sum6.toFixed(3));
});
$('.dr').click(function(){
var sum51 =0;
 $("input.cred").each(function() {
  sum51+= +$(this).val();
  });
 $('.totcredit').val(sum51.toFixed(3));
var sum61 =0;
 $("input.debt").each(function() {
  sum61+= +$(this).val();
  });
 $('.totdebit').val(sum61.toFixed(3)); 
});   
    </script>