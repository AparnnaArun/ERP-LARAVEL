
<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
@if(empty($vouch))
<div class="col-md-3">

                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Cont.</span>
                        </div>
                        <input type="text" class="form-control constants" name="constants" id="constants" value="" required="required">
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Serial No</span>
                        </div>
                        
                        <input type="text" class="form-control slno" name="slno" id="slno" value="" required="required">
                      </div>
                    </div>
                </div>
           
          <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Vo.No</span>
                        </div>
                        
                        <input type="text" class="form-control genvouch" name="genvouch" id="genvouch" value="" readonly>
                      </div>
                    </div>

                </div>
                @else
                <div class="col-md-3">

                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Cont.</span>
                        </div>
                        <input type="text" class="form-control constants" name="constants" id="constants" value="{{ $vouch->constants }}" required="required">
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Serial No</span>
                        </div>
                        
                        <input type="text" class="form-control slno" name="slno" id="slno" value="{{ $vouch->slno }}" required="required">
                      </div>
                    </div>
                </div>
           
          <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Vo.No</span>
                        </div>
                        
                        <input type="text" class="form-control genvouch" name="genvouch" id="genvouch" value="{{$vouch->genvouch}}" readonly>
                      </div>
                    </div>

                </div>

                @endif
               
 <script type="text/javascript">
 $(".constants,.slno").change(function(){
  csrf = $('#token').val();
con=$(".constants").val();
slno=$(".slno").val();
//alert(csrf);
$(".genvouch").val(con + slno);

 })
</script>