                     <div class="card-body">
 <img src="{{ public_path('assets/images') . '/' . $cmpid->imagename }}" style="width: 650px; height: 100px">
<h2 class="card-title " ><center>Stock Adjustment</center></h2>
   
      <table border="1" style="border-collapse: collapse;border-color: #808080;width:100%">
        <thead>
          <tr>
            <th>SlNo</th>
            <th colspan="8" style="width:50%!important;" >Description</th>
            
            <th>Unit</th>
            <th>Batch</th>
            <th>Qnty</th>
            <th>Type</th>
            

          </tr>
        </thead>
        <tbody>
          @foreach($data->stockadjustmentdetail as $sqoute)
          
            <tr>
            <td style="text-align: center;">{{$loop->iteration}}</td>
            <td colspan="8" style="width:50%!important;" >{{$sqoute->item}}</td>
            <td style="text-align: center;">{{$sqoute->unit}}</td>
            <td style="text-align: center;">{{$sqoute->batch}}</td>
            <td style="text-align: center;">{{$sqoute->qnty}}</td>
            <td style="text-align: center;">{{$data->voucher_type}}</td>
          
          </tr>
          @endforeach
         
        </tbody>

      </table>
      <br/>
     
<table>
         <tr>
           <td>Best Regards,</td></tr>
           <tr><td><b>Agrim Projects Solutions</b></td>
         </tr></table>




                  </div>