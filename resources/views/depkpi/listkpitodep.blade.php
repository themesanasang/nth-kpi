@if(count($kpi) > 0)
<div class="table-responsive">
<table id="table-listkpi" class="table table-bordered table-hover table-sm">
    <thead>
        <tr>
            <th>
                <div class="form-check-table">
                <label class="form-check-label">
                    <input class="form-check-input check-listkpiall" type="checkbox" >    
                </label>
                </div>
            </th>
            <th>รหัส</th>
        </tr>
    </thead>
    <tbody>
        @foreach($kpi as $key => $value)
        <tr data-id="{{ $value->id }}">
            <td class="form-check-table">
                <label class="form-check-label">
                    <input class="form-check-input check-listkpi" name="keylistkpi[]" type="checkbox" id="{{ $value->id }}" value="{{ $value->id }}">    
                </label>
            </td>
            <td>{{ $value->code }}</td>
        </tr>
        @endforeach
    </tbody>
</table> 
</div>
@endif     

<script>
    $(document).ready(function() {
        /**
        * 
        * Table Checkbox
        */
        $('table').tableCheckbox({ /* options */ });
       

       /**
       * 
       * Table-kpitodep Check
       */
        $('#table-listkpi .check-listkpiall').change(function(){    
                var checkthis = $(this);

                /*if (checkthis.is(':checked')) {
                    $('#btntranferkpi').removeClass('disabled');
                    $('#selectdepkpi').removeAttr('disabled');
                }else {
                    $('#btntranferkpi').addClass('disabled');
                    $('#selectdepkpi').attr("disabled","selectdepkpi");     
                } */    
        });

        $('#table-listkpi .check-listkpi').click(function(){  
                var val = [];
                $("#table-listkpi input[name='keylistkpi[]']:checked").each(function(i){
                    val[i] = $(this).val();
                });

                /*if(val.length == 0){
                    $('#btntranferkpi').addClass('disabled');
                    $('#selectdepkpi').attr("disabled","selectdepkpi");
                }else{
                    $('#btntranferkpi').removeClass('disabled');
                    $('#selectdepkpi').removeAttr('disabled');       
                }*/
        });
        
    });
</script>