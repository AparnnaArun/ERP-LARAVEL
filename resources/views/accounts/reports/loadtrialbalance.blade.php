<div class="row">
  <div class="col-md-4">
                   
                       <div  class="actions " id="actions" >
                          <input type="hidden" class="head" value="Trial Balance">
                       </div>
                       

                      </div>
                      <div class="col-md-12">
                    <table class="table table-bordered reporttable" id="reporttable">
                     <thead>
     
      <tr>
       <th>Acc#</th>
       <th>Account Title</th>
       <th colspan="2">Opening</th>
       <th colspan="2">Movements during <br/>{{$dates}} To <br/>{{$dates1}}</th>
 
       </tr>
       <tr>
       <th></th>
       <th></th>
       <th>Debit</th>
       <th>Credit</th>
       <th>Debit</th>
       <th>Credit</th>
       <!-- <th>Debit</th>
       <th>Credit</th> -->
      </tr>
     </thead>
                      <tbody>

@foreach($categories as $category)

<tr>
              <td>@if($category->accounttype=='s1')<span style="color: blue;"><b>{{ $category->seqnumber }}</b></span>@else <span style="color: green;">{{ $category->seqnumber }}</span>@endif</td>
              <td class="text-uppercase">@if($category->accounttype=='s1')<span style="color: blue;"><b>{{ $category->name }}</b></span>@else <span style="color: green;">{{ $category->name }}</span>@endif</td>
              <td></td>
               <td></td>
               <td>@if($category->debitcredit=='debt') {{$category->sum}}@else 0.000 @endif</td>
               <td>@if($category->debitcredit=='cred') {{$category->sum}} @else 0.000 @endif</td>
              
            </tr>
            
               
                                
                               
                                @endforeach
                   
                         
                                     <tfoot>                              
     
    <tr>
      <td >Total</td>
      <td >  </td>
      <td > </td>
  <td > </td>
      <td ></td>
      <td ></td> 
   
      
     
    </tr>
  </tfoot>
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
      "bPaginate": false,
      "bSort" : false ,
      fixedHeader: {
        header: true, //Table have header and footer
        footer: true
      },
      autoFill: true, // Autofills fields by dragging the blue dot at the bottom right of cells
      responsive: true, //  Resize table
      rowReorder: true, // Row can be reordered by dragging
      select: true, // selecting rows, cells or columns
      colReorder: true, // Reorders columns
        drawCallback: function () {
       var apii = this.api();
        totals = apii.column( 4,{ search:'applied' }).data().sum();
      $( apii.column(4).footer() ).html(totals.toFixed(3)); 
      var ap = this.api();
        tota = ap.column( 5,{ search:'applied' }).data().sum();
      $( ap.column(5).footer()).html(tota.toFixed(3));
      
       }  // Reorders columns
      
      
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
          footer:true,
            title: function(){
                var d = $(".head").val();
          return d ; 
             },
          customize: function ( doc ) {
     $(doc.document.body).find('h1').css('font-size', '15pt');
     $(doc.document.body).find('h1').css('text-align', 'center'); 
 }}
      ]
    });
// Appends the buttons to the selected element class called "action"
    oTable.buttons(0, null).containers().appendTo('.actions');
});
var sum=0;
var sum1=0;
$(".debt").each(function(){
      sum+= +$(this).text()
    })
$(".cred").each(function(){
      sum1+= +$(this).text()
    })
//alert(sum);
if(sum > sum1){
$(".credbal").text((sum -sum1).toFixed(3));
}
else{
  $(".debtbal").text((sum1 -sum).toFixed(3)); 
}
});
</script>