                $(".itemvalue").change(function(){
               itemid = $(this).val();
               token = $("#token").val();
              $.ajax({
         type: "POST",
         url: "{{url('getitemdetails')}}", 
         data: {_token: token,itemid:itemid},
         dataType: "html",  
         success: 
              function(result){
              //alert(result);
                $(".result").html(result);

              }
          });

                })
// //////////ADD TO GRID SECTION ///////////////////////
$('.addtogrid').click(function () {
  $('#myalertdiv').hide();
    var rowCount;
        token = $("#token").val();
        rowCount = $('.ItemGrid tr').length; 
        itemid = $('.itemvalue').val();
        gridid = $(".gridid").val();
if(itemid !== gridid && itemid!=""){
$.ajax({ 
         type: "POST",
         url: "{{url('itemstogridsqoute')}}", 
        data: {itemid: itemid,rowCount: rowCount,_token:token,gridid:gridid},
         dataType: "html",  
         success: 
              function(data){
               
                $('#ItemGrid tbody').append(data);

              }
          });
          }
          else{
            $('#myalertdiv').show();
            $("#myalertdiv").text("Item exist/No item ");
          }    
}); 
///////////////// Grid item to remove/////////////////////
$(document).on('click', '#remove', function(){  
  row = $(this).closest("tr");
   row.remove();
   ntotal = $(".gridtotal").val();
  discs = $(".disctotal").val();
 tabamount = row.find("td input.tabamount").val();
bal = ntotal - tabamount;
$(".gridtotal").val((ntotal - tabamount).toFixed(3));
$(".nettotal").val((bal - discs).toFixed(3));
      });

$(document).on("keyup change paste", ".auto-calc", function() {
   var total =$(".gridtotal").val();
   var disc = $(".disctotal").val();
   var nettotal = total-disc;
   $(".nettotal").val(nettotal.toFixed(3));
 });
////////////////Enquiry Radio MENU /////////////////
$(document).ready(function () {
 
$(".enqpopup").click(function(){
   $(".custdiv").hide();
  customer =$("#customer").val();
  token = $("#token").val();
  if(customer!=""){
$.ajax({ 
         type: "POST",
         url: "{{url('enqdetails')}}", 
        data: {customer: customer,_token:token},
         dataType: "html",  
         success: 
              function(data){
                //alert(data);
               $('.salesenq').html(data);
               $(".addtocart").show();
                           }
          });
}
else{
$(".custdiv").show();
$(".custdiv").text('Please choose customer');
}
    });
$("#customer").change(function(){
  $(".custdiv").hide();
  customer =$("#customer").val();
   if($('.enqpopup').is(':checked')){
token = $("#token").val();

$.ajax({ 
         type: "POST",
         url: "{{url('enqdetails')}}", 
        data: {customer: customer,_token:token},
         dataType: "html",  
         success: 
              function(data){
                //alert(data);
               $('.salesenq').html(data);
               $(".addtocart").show();
                           }
          });
}
else{
$(".custdiv").show();
$(".custdiv").text('Please choose customer');
}
    });

});
$(".addtocart").click(function(){
enqno = $(".select_product").val();
//alert(endno);
$.ajax({ 
         type: "POST",
         url: "{{url('enqdetailsfromcart')}}", 
        data: {enqno: enqno,_token:token},
         dataType: "html",  
         success: 
             function(data){
               
                $('#ItemGrid tbody').html(data);

              }
          });
  });