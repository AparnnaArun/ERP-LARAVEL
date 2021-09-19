                     <div class="card-body">
 <img src="{{ public_path('assets/images') . '/' . $cmpid->imagename }}" style="width: 650px; height: 100px">
<h2 class="card-title " ><center>Delivery Note Return</center></h2>
      <table style="width:100%;">
        <tr><td>To,</td></tr>
        <tr><td colspan="4">{{$data ->name}}</td>
          <td></td>
          <td></td>
          <td></td>
          <td>Ref No</td>
          <td>: {{$data ->rtn_no}}</td></tr>
        <tr><td colspan="4">{{$data ->address}}</td>
          <td></td>
          <td></td>
          <td></td>
          <td>Date</td>
          <td>: {{ \Carbon\Carbon::parse($data->dates)->format('j -F- Y')  }}</td></tr>
       
          <tr><td colspan="4"></td>
          <td></td>
          <td></td>
          <td></td>
          <td>DO #</td>
          <td>: {{$do ->deli_note_no}}</td></tr>
          
      </table>
      <table border="1" style="border-collapse: collapse;border-color: #808080;width:100%">
        <thead>
          <tr>
            <th>SlNo</th>
            <th colspan="8" style="width:50%!important;" >Description</th>
            
            <th>Unit</th>
            <th>DO Qnty</th>
            <th>Rtn Qnty</th>
           

          </tr>
        </thead>
        <tbody>
          @foreach($data->deliveryreturndetail as $sqoute)
            <tr>
            <td style="text-align: center;">{{$loop->iteration}}</td>
            <td colspan="8" style="width:50%!important;" >{{$sqoute->item_name}}</td>
            <td style="text-align: center;">{{$sqoute->unit}}</td>
            <td style="text-align: center;">{{$sqoute->dnqnty}}</td>
            <td style="text-align: center;">{{$sqoute->rtnqnty}}</td>
            
          </tr>
          @endforeach
         
        </tbody>

      </table>
      <br/>
      <table>
      
      
          <tr><td colspan="2">Remarks</td>
          <td colspan="11">: {{$data ->remarks}}</td>
          </tr>
        
          
      </table>
<table>
         <tr>
           <td>Best Regards,</td></tr>
           <tr><td><b>Agrim Projects Solutions</b></td>
         </tr></table>




                  </div>