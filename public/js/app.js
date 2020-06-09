(function(){

    $.ajaxSetup({
       headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
    });

    /**
     * 
     * Menu Top
     */
    var navigation = responsiveNav(".nav-collapse", {
        animate: true,                    // Boolean: Use CSS3 transitions, true or false
        transition: 284,                  // Integer: Speed of the transition, in milliseconds
        label: "Menu",                    // String: Label for the navigation toggle
        insert: "after",                  // String: Insert the toggle before or after the navigation
        customToggle: "",                 // Selector: Specify the ID of a custom toggle
        closeOnNavClick: false,           // Boolean: Close the navigation when one of the links are clicked
        openPos: "relative",              // String: Position of the opened nav, relative or static
        navClass: "nav-collapse",         // String: Default CSS class. If changed, you need to edit the CSS too!
        navActiveClass: "js-nav-active",  // String: Class that is added to <html> element when nav is active
        jsClass: "js",                    // String: 'JS enabled' class which is added to <html> element
        init: function(){},               // Function: Init callback
        open: function(){},               // Function: Open callback
        close: function(){}               // Function: Close callback
      });





      /**
       * 
       * Table-dep Check
       */
      $('#table-dep .check-depall').change(function(){    
            var checkthis = $(this);

            if (checkthis.is(':checked')) {
                //alert('remove');
                $('#dep-del').removeClass('disabled');  
            }else {
                //alert('add');
                $('#dep-del').addClass('disabled');      
            }     
      });
      $('#table-dep .check-dep').click(function(){  
            var val = [];
            $("#table-dep input[name='keydep[]']:checked").each(function(i){
                val[i] = $(this).val();
                //alert(val[i]);
            });

            if(val.length == 0){
                //alert('close');
                 $('#dep-del').addClass('disabled');    
            }else{
                //alert('open'); 
                $('#dep-del').removeClass('disabled');          
            }
      });
     $('#dep-del').click(function(){
            var checkstr =  confirm('คุณต้องการลบข้อมูล?');
            if(checkstr == true){
                var val = [];
                $("#table-dep input[name='keydep[]']:checked").each(function(i){
                    val[i] = $(this).val();
                });

                if(val.length > 0){
                    var dataSet={ keydel: val }; 
                    $.post('department/del',dataSet,function(data){  
                        location.replace('department');
                    }); 
                }else{
                    $('#dep-del').addClass('disabled');  
                }
            }else{
                return false;
            }        
     });
      





      /**
       * 
       * Table-user Check
       */
      $('#table-user .check-userall').change(function(){    
            var checkthis = $(this);

            if (checkthis.is(':checked')) {
                $('#user-del').removeClass('disabled');  
            }else {
                $('#user-del').addClass('disabled');      
            }     
      });
      $('#table-user .check-user').click(function(){  
            var val = [];
            $("#table-user input[name='keyuser[]']:checked").each(function(i){
                val[i] = $(this).val();
            });

            if(val.length == 0){
                 $('#user-del').addClass('disabled');    
            }else{
                $('#user-del').removeClass('disabled');          
            }
      });
     $('#user-del').click(function(){
            var checkstr =  confirm('คุณต้องการลบข้อมูล?');
            if(checkstr == true){
                var val = [];
                $("#table-user input[name='keyuser[]']:checked").each(function(i){
                    val[i] = $(this).val();
                });

                if(val.length > 0){
                    var dataSet={ keydel: val }; 
                    $.post('user/del',dataSet,function(data){  
                        location.replace('user');
                    }); 
                }else{
                    $('#user-del').addClass('disabled');  
                }
            }else{
                return false;
            }        
     });




     /**
       * 
       * Table-kpigroup Check
       */
      $('#table-kpigroup .check-kpigroupall').change(function(){    
            var checkthis = $(this);

            if (checkthis.is(':checked')) {
                $('#kpigroup-del').removeClass('disabled');  
            }else {
                $('#kpigroup-del').addClass('disabled');      
            }     
      });
      $('#table-kpigroup .check-kpigroup').click(function(){  
            var val = [];
            $("#table-kpigroup input[name='keykpigroup[]']:checked").each(function(i){
                val[i] = $(this).val();
            });

            if(val.length == 0){
                 $('#kpigroup-del').addClass('disabled');    
            }else{
                $('#kpigroup-del').removeClass('disabled');          
            }
      });
     $('#kpigroup-del').click(function(){
            var checkstr =  confirm('คุณต้องการลบข้อมูล?');
            if(checkstr == true){
                var val = [];
                $("#table-kpigroup input[name='keykpigroup[]']:checked").each(function(i){
                    val[i] = $(this).val();
                });

                if(val.length > 0){
                    var dataSet={ keydel: val }; 
                    $.post('kpigroup/del',dataSet,function(data){  
                        location.replace('kpigroup');
                    }); 
                }else{
                    $('#kpigroup-del').addClass('disabled');  
                }
            }else{
                return false;
            }        
     });



     /**
      * 
      * KPI
      */
     $('input[name="multiply"]').keyup(function(e)
     {
        if (/\D/g.test(this.value))
        {
            // Filter non-digits from input value.
            this.value = this.value.replace(/\D/g, '');
        }
     });

      /**
       * 
       * Table-kpi Check
       */
     $('#table-kpi .check-kpiall').change(function(){    
            var checkthis = $(this);

            if (checkthis.is(':checked')) {
                $('#kpi-del').removeClass('disabled');  
            }else {
                $('#kpi-del').addClass('disabled');      
            }     
      });
      $('#table-kpi .check-kpi').click(function(){  
            var val = [];
            $("#table-kpi input[name='keykpi[]']:checked").each(function(i){
                val[i] = $(this).val();
            });

            if(val.length == 0){
                 $('#kpi-del').addClass('disabled');    
            }else{
                $('#kpi-del').removeClass('disabled');          
            }
      });
     $('#kpi-del').click(function(){
            var checkstr =  confirm('คุณต้องการลบข้อมูล?');
            if(checkstr == true){
                var val = [];
                $("#table-kpi input[name='keykpi[]']:checked").each(function(i){
                    val[i] = $(this).val();
                });

                if(val.length > 0){
                    var dataSet={ keydel: val }; 
                    $.post('kpi/del',dataSet,function(data){  
                        location.replace('kpi');
                    }); 
                }else{
                    $('#kpi-del').addClass('disabled');  
                }
            }else{
                return false;
            }        
     });







     /**
       * 
       * Table-disease_group Check
       */
      $('#table-diseasegroup .check-diseasegroupall').change(function(){    
        var checkthis = $(this);

        if (checkthis.is(':checked')) {
            $('#diseasegroup-del').removeClass('disabled');  
        }else {
            $('#diseasegroup-del').addClass('disabled');      
        }     
  });
  $('#table-diseasegroup .check-diseasegroup').click(function(){  
        var val = [];
        $("#table-diseasegroup input[name='keydiseasegroup[]']:checked").each(function(i){
            val[i] = $(this).val();
        });

        if(val.length == 0){
             $('#diseasegroup-del').addClass('disabled');    
        }else{
            $('#diseasegroup-del').removeClass('disabled');          
        }
  });
 $('#diseasegroup-del').click(function(){
        var checkstr =  confirm('คุณต้องการลบข้อมูล?');
        if(checkstr == true){
            var val = [];
            $("#table-diseasegroup input[name='keydiseasegroup[]']:checked").each(function(i){
                val[i] = $(this).val();
            });

            if(val.length > 0){
                var dataSet={ keydel: val }; 
                $.post('diseasegroup/del',dataSet,function(data){  
                    location.replace('diseasegroup');
                }); 
            }else{
                $('#diseasegroup-del').addClass('disabled');  
            }
        }else{
            return false;
        }        
 });






     /**
      * 
      * Kpi To Dep
      *
      */
      //$('#btntranferkpi').addClass('disabled');
      //$('#selectdepkpi').attr("disabled","selectdepkpi");

      $('#selectgroupkpi').on('change', function () {

            var kpigroup = $('#selectgroupkpi').val();
            if( kpigroup == 'none' ){
                $('#show-kpi').html( '' );
            }else{                           
                $.get( 'getkpilist/'+kpigroup, function( data ) {
                    $( "#show-kpi" ).html( data );
                });
            }

      });

      $('#selectdepkpi').on('change', function () {

           var dep = $('#selectdepkpi').val();
            if( dep == 'none' ){
                $('#show-kpitodep').html( '' );
            }else{               
               $.get( 'getkpitodeplist/'+dep, function( data ) {
                    $( "#show-kpitodep" ).html( data );
                });
            }

      });

      $('#btntranferkpi').click(function(){
          if($('#selectgroupkpi').val() == 'none' || $('#selectdepkpi').val() == 'none'){
              alert('กรุณาเลือกข้อมูลให้ครบก่อนทำการจัดสรร KPI');
          }

          if($('#selectgroupkpi').val() != 'none' && $('#selectdepkpi').val() != 'none'){
                var val = [];
                $("#table-listkpi input[name='keylistkpi[]']:checked").each(function(i){
                    val[i] = $(this).val();
                });

                if(val.length > 0){
                    var dataSet={ keyadd: val, depid: $('#selectdepkpi').val() }; 
                    $.post('addkpitodep',dataSet,function(data){  
                        $.get( 'getkpitodeplist/'+$('#selectdepkpi').val(), function( data ) {
                            $( "#show-kpitodep" ).html( data );
                        });
                    });
                }else{
                    alert('กรุณาเลือก KPI');
                } 
          }
      });






      /**
       * 
       *  บันทึก KPI
       */
      $('#save_kpi').click(function(){
          var result_id  = document.querySelectorAll("#keykpi input[name='result_id[]']");
          var around  = document.querySelectorAll("#keykpi input[name='around[]']");
          var fraction  = document.querySelectorAll("#keykpi input[name='fraction[]']");
          var section  = document.querySelectorAll("#keykpi input[name='section[]']");
          var comment  = document.querySelectorAll("#keykpi input[name='comment[]']");
          var around_id = $("#keykpi input[name='around_id']").val();
          var kpi_id = $("#keykpi input[name='kpi_id']").val();
          var multiply = $("#keykpi input[name='multiply']").val();
          var idold = $("#keykpi input[name='idold']").val();

          const resultidArray = Array.from(result_id, s => s.value);
          const aroundArray = Array.from(around, s => s.value);
          const fractionArray = Array.from(fraction, s => s.value);
          const sectionArray = Array.from(section, s => s.value);
          const commentArray = Array.from(comment, s => s.value);

          var dataSet={ idold: idold, around_id: around_id, kpi_id: kpi_id, multiply: multiply, result_id: resultidArray, around: aroundArray, fraction: fractionArray, section: sectionArray, comment: commentArray }; 
          $.post('keykpiData',dataSet,function(data){
             top.location.href = idold;
          });

          /*if(section.length > 0){
            for(i=0;i<around.length;i++)
            {     
                if(fraction[i].value > 0){
                    var dataSet={ around_id: around_id, kpi_id: kpi_id, multiply: multiply , result_id: result_id[i].value ,around: around[i].value, fraction: fraction[i].value, section: section[i].value, comment: comment[i].value  }; 
                    $.post('keykpiData',dataSet,function(data){  });
                }            
            } 
          }else{
            for(i=0;i<around.length;i++)
            {    
                if(fraction[i].value > 0){
                    var sectionData = null;    
                    var dataSet={ around_id: around_id, kpi_id: kpi_id, multiply: multiply , result_id: result_id[i].value ,around: around[i].value, fraction: fraction[i].value, section: sectionData, comment: comment[i].value  }; 
                    $.post('keykpiData',dataSet,function(data){  });
                }       
            } 
          }*/

          //go back  
          //top.location.href = "../emp";
      });





      /**
       * 
       * getDataKpiDep()
       */
       $('#show-kpiall-dep').html( '' );
       $('#getDataKpiDep').on('change', function () {

           var year = $('#getDataKpiDep').val();
            if( year == 'none' ){
                $('#show-kpiall-dep').html( '' );
            }else{  
               var oldid = $('#oldid').val();     
               var dep = $('#showdep').val();     
               $.get( oldid+'/getdatakpi/'+year+'/'+dep, function( data ) {
                    $( "#show-kpiall-dep" ).html( data );
                });
            }

      });





      /**
       * === Report All ===
       */

        




})();

/**
 * 
 * ลบ ข้อมูล kpitodep
 */
function delkpitodep(id){
    var dataSet={ id: id }; 
    $.post('delkpitodep',dataSet,function(data){  
        $.get( 'getkpitodeplist/'+$('#selectdepkpi').val(), function( data ) {
            $( "#show-kpitodep" ).html( data );
        });
    });
}



/**
 * 
 * Approve kpi  around_id, around, datestart, dateend
 */
function approve(around_id, around, datestart, dateend){
    var dataSet={ around_id: around_id, around: around, datestart: datestart, dateend:dateend }; 
    $.post('approve',dataSet,function(data){  
        if(data == 'error'){
            alert('ยังไม่มีข้อมูลในรอบเดือนนี้ กรุณาตรวจสอบข้อมูล');
        }
        location.replace('admin');
    });
}