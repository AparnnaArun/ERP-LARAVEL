@if($settle=='1' ||$settle=='2')

@foreach($proo as $pnv)
<tr>
	<td>{{$loop->iteration}}</td>
<td> <input type="hidden" class="form-control"  name="gdates[]" value="{{ \Carbon\Carbon::parse($pnv->dates)->format('j -F- Y')  }}"  >{{ \Carbon\Carbon::parse($pnv->dates)->format('j -F- Y')  }}</td>
      <td><input type="hidden" class="form-control"  name="invoiceno[]" value="{{ $pnv->entry_no  }}"  >
        <input type="hidden" class="form-control"  name="purchaseid[]" value="{{ $pnv->id  }}"  >{{ $pnv->entry_no }}</td>
      <td><input type="hidden" class="form-control"  name="grandtotal[]" value="{{ $pnv->totalamount   }}"  >
        <input type="hidden" class="form-control"  name="ntotal[]" value="{{ $pnv->totalamount}}"  >{{ $pnv->totalamount  }}</td>
      
     <td><input type="hidden" class="form-control"  name="collected[]" value="{{ $pnv->collected_amount  }}"  >{{ $pnv->collected_amount }}</td>
     
        <td> {{ $pnv->balance_amount}} </td>
     <td><input type="hidden" class="form-control auto-calc balce"  name="balance[]" value="{{ $pnv->balance_amount  }}"  >  <input type="text" class="form-control auto-calc amount" name="amount[]" >
      <div class="alrtss" style="color:red;display:none;">This amount should be less than balance amount</div></td>
    </tr>

@endforeach
@elseif($settle=='3')
@foreach($proo as $pnv)
<tr>
	<td>{{$loop->iteration}}</td>
	<td><input type="hidden" class="form-control"  name="invoiceno[]" value="{{ $pnv->voucher  }}"  >
        <input type="hidden" class="form-control"  name="purchaseid[]" value="{{ $pnv->id  }}"  >{{ $pnv->voucher }}</td>
<td> <input type="hidden" class="form-control"  name="gdates[]" value="{{ \Carbon\Carbon::parse($pnv->dates)->format('j -F- Y')  }}"  >{{ \Carbon\Carbon::parse($pnv->dates)->format('j -F- Y')  }}</td>
      
      <td>
        <input type="hidden" class="form-control"  name="grandtotal[]" value="{{ $pnv->totalnetsalary  }}"  ><input type="hidden" class="form-control"  name="ntotal[]" value="{{ $pnv->totalnetsalary   }}"  >
        {{ $pnv->totalnetsalary   }}</td>
      
     <td><input type="hidden" class="form-control"  name="collected[]" value="{{ $pnv->collected_amount  }}"  >{{ $pnv->collected_amount }}</td>
     
    <td><input type="hidden" class="form-control"  name="debitnote[]" value="{{ $pnv->balance  }}"  > {{ $pnv->balance  }}</td>
     
     <td><input type="hidden" class="form-control auto-calc balce"  name="balance[]" value="{{ $pnv->balance  }}"  >  <input type="text" class="form-control auto-calc amount" name="amount[]" >
      <div class="alrtss" style="color:red;display:none;">This amount should be less than balance</div></td>
    </tr>
    @endforeach
    @elseif($settle=='4')
@foreach($proo as $pnv)
<tr>
  <td>{{$loop->iteration}}</td>
  <td><input type="hidden" class="form-control"  name="invoiceno[]" value="{{ $pnv->voucher  }}"  >
        <input type="hidden" class="form-control"  name="purchaseid[]" value="{{ $pnv->id  }}"  >{{ $pnv->voucher }}</td>
<td> <input type="hidden" class="form-control"  name="gdates[]" value="{{ \Carbon\Carbon::parse($pnv->dates)->format('j -F- Y')  }}"  >{{ \Carbon\Carbon::parse($pnv->dates)->format('j -F- Y')  }}</td>
      
      <td>
        <input type="hidden" class="form-control"  name="grandtotal[]" value="{{ $pnv->totaladvance  }}"  ><input type="hidden" class="form-control"  name="ntotal[]" value="{{ $pnv->totaladvance   }}"  >
       {{ $pnv->totaladvance   }}</td>
      
     <td><input type="hidden" class="form-control"  name="collected[]" value="{{ $pnv->collectedadvnce  }}"  >{{ $pnv->collectedadvnce }}</td>
     
     <td><input type="hidden" class="form-control"  name="debitnote[]" value="{{ $pnv->advncebalnce  }}"  > {{ $pnv->advncebalnce  }}</td>
    
     <td><input type="hidden" class="form-control auto-calc balce"  name="balance[]" value="{{ $pnv->advncebalnce  }}"  >  <input type="text" class="form-control auto-calc amount" name="amount[]" >
      <div class="alrtss" style="color:red;display:none;">This amount should be less than balance</div></td>
    </tr>
    @endforeach
@endif
<script type="text/javascript">
	$(document).on("keyup change paste", "input.auto-calc", function() {
  row = $(this).closest("tr");

var bal = parseFloat(row.find(".balce").val());
var amt = parseFloat(row.find(".amount").val());

if(amt > bal ){
 row.find('.alrtss').show();
 $(".savebtn").attr("disabled", true);
}
else{
 row.find('.alrtss').hide();
  $(".savebtn").attr("disabled", false);
}
sum =0;
sum1=0;
$(".adnce").each(function (){
    sum += +$(this).val();
})
$(".amount").each(function (){
    sum1 += +$(this).val();
})
$(".totaladvance").val(sum.toFixed(3));
$(".nettotal").val(sum1.toFixed(3));
});
</script>