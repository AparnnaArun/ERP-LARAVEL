                     <div class="card-body">
 <img src="{{ public_path('assets/images') . '/' . $cmpid->imagename }}" style="width: 650px; height: 100px">
<h2 class="card-title " ><center>Gooods Received Note</center></h2>
      <table style="border-collapse: collapse;border-color: wheat;width:100%">
        
        <tr><td colspan="3">{{$data ->vendor}}</td>
          <td></td>
          <td></td>
          <td></td>
          <td>PO No</td>
          <td>: {{$data ->po_no}}</td></tr>
        <tr><td colspan="3" >GRN NO : {{$data ->grn_no}}</td>
          <td></td>
          <td ></td>
           <td ></td>
           
          <td>Date</td>
          <td>: {{ \Carbon\Carbon::parse($data->dates)->format('j -F- Y')  }}</td></tr>
        <tr><td colspan="3"></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td></tr>
         
        
      </table>
      <table border="1" style="border-collapse: collapse;border-color: #808080;width:100%">
        <thead>
          <tr>
            <th>SlNo</th>
            <th colspan="8" style="width:50%!important;" >Description</th>
            
          
            <th>Unit</th>
            <th>Qnty</th>
            

          </tr>
        </thead>
        <tbody>
          @foreach($data->goodsreceivednotedetail as $sqoute)
            <tr>
            <td style="text-align: center;">{{$loop->iteration}}</td>
            <td colspan="8" style="width:50%!important;" >{{$sqoute->item_name}}</td>
            <td style="text-align: center;">{{$sqoute->unit}}</td>
            <td style="text-align: center;">{{$sqoute->quantity}}</td>
           
          </tr>
          @endforeach
          <tr>
            <th colspan="10">Total Qnty</th>
            <th>{{$data ->tot_qnty}}</th>
           
          </tr>
         
        </tbody>

      </table>
      <br/>
      
<table>
         <tr>
           <td>Best Regards,</td></tr>
           <tr><td><b>Agrim Projects Solutions</b></td>
         </tr></table>




                  </div>