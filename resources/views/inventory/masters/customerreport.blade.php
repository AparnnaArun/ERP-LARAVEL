@extends('inventory/layout')
@section ('content')
 

<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Customer Report</h4>
                    <p class="card-description"> 
                    </p>
                    <div class="table table-responsive">
                    <table class="table table-striped reporttable" id="reporttable">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Phone</th>
                          <th>Email</th>
                          <th>Executive</th>
                           <th>Approved</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach($custs as $cust)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/inventory/customer-view/{{$cust->id}}">{{$cust->name}}</a></td>
      <td><a href="/inventory/customer-view/{{$cust->id}}">{{$cust->phone}}</a></td>
      <td><a href="/inventory/customer-view/{{$cust->id}}">{{$cust->email}}</a></td>
      <td><a href="/inventory/customer-view/{{$cust->id}}">{{$cust->phone}}</a></td>
      <td><a href="/inventory/customer-view/{{$cust->id}}">@if($cust->approve==1) Yes @else No @endif</a></td>
     
    </tr>
   @endforeach
                      </tbody>
                    </table>
                  </div>
                  </div>
                </div>
              </div>
              <script src="/assets/js/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('.reporttable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
        { "extend": 'pdf', "className": "btn-xs" },
        {extend:'csv',className: 'btn-xs'},
        {extend: 'excel',
        className: 'btn-xs',
        title: 'Customer Report'
   
},
         {extend: 'print',
          className: 'btn-xs',
            title: 'Customer Report',
          customize: function ( doc ) {
     $(doc.document.body).find('h1').css('font-size', '15px');
     $(doc.document.body).find('h1').css('text-align', 'center'); 
 }
   
}
         
        ]
    } );
} );
</script>
                @stop