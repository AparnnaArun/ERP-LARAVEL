
@foreach($datas as $data)
<tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td >{{ \Carbon\Carbon::parse($data->cheque_date)->format('j -F- Y')  }}
                       </td>
     <td>{{$data->cheque_bank}}</td>
     <td>{{$data->cheque_no}}</td>
   
     <td class="form-control  editpicker">{{ \Carbon\Carbon::parse($data->cheque_clearance)->format('j -F- Y')  }}
                       </td>
     <td>@if($data->debitcred=='debt'){{$data->amount}} @else {{0.000}}@endif
                       </td>
     <td>@if($data->debitcred=='cred'){{$data->amount}} @else {{0.000}}@endif
                       </td>
    </tr>
    @endforeach
    <script type="text/javascript">
                $(document).ready(function () {
    $(".editpicker").datepicker(
      { dateFormat: 'dd-M-yy',
      changeYear: true,
      yearRange: "-100:+0",
      changeMonth: true});
  
});
    </script>