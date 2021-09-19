
  <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required">GRN NO </span>
                        </div>
                         <select class="form-control mySelect2 select_product "  name="grnid[]"  multiple="multiple" >
                       
                       @foreach($grn as $row)
                        <option value="{{$row->id}}" >{{$row->grn_no}}</option>
                        @endforeach
                    
                        </select>
                           
                        
                      </div>
                    </div>
                 
                    <script type="text/javascript">
                    	 $('.mySelect2').select2({
  selectOnClose: true
});
                    </script>