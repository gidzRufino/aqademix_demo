<div class="col-lg-6">
     <div class="panel panel-warning">
        <div class="panel-heading">
            <h5 class="no-margin">Grading Options
            <button class="btn btn-warning pull-right btn-xs"><i onclick="saveOptions()" class="pointer fa fa-save"></i></button>
            </h5>
        </div>
        <div class="panel-body">
            <div class="control-group" id="defaultOption">
                <div class="col-lg-4">
                    <input onclick="" style="margin-right: 10px;" type="radio" name="gs_options" value="1">Two Exam / 
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Semester
                </div>
                <div class="col-lg-4">
                    <input onclick="" style="margin-right: 10px;" type="radio" name="gs_options" value="2">Four Exam / 
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Semester
                </div>
                <div class="col-lg-4 no-padding">
                    <input onclick="" style="margin-right: 10px;" type="radio" name="gs_options" value="3">Four Grading
                </div>
            </div>
            <?php  //print_r(Modules:: run('gradingsystem/fourExams')); ?>
        </div>
     </div>
    <div class="panel panel-primary">
        <div class="panel-heading clearfix">
            <h5>Raw Score Transmutation
                <i onclick="saveTransmutation()" class="pull-right pointer fa fa-2x fa-save"></i>
            </h5>
        </div>
        <div class="panel-body">
            <input id="bybase" name="rst" type="radio" <?php echo $bybase ?> value="1" /> By Base <br /><br />
                <p>Please write the exact transmutation you are basing from <br /><small>[ e.g. if zero base just type in "0" ]</small>
                    <br /><small class="text-danger">Note: If leave blank, the default is base 65</small>
                </p>
                <input class="form-control" onclick="$('#bybase').attr('checked', 'checked')" type="text" value="<?php echo $base ?>" id="base" placeholder="Base 65" name="base" /><br />
            <input id="byform" name="rst" type="radio" <?php echo $byform   ?> value="1" /> By Formula<br /><br />
                <p>Please type in the formula in the input box using RS for the raw score and TS for the total score<br>
                    <small>[ e.g. ( (RS divide TS) times 35 plus 65 ) ]</small></p>

                <input class="form-control" onclick="$('#byform').attr('checked', 'checked')" type="text" value="<?php echo $formula ?>" id="formula" placeholder="type the formula here" name="base" />
        </div>
    </div>

</div>

<div class="col-lg-6 pull-right">
    <div class="panel panel-red">
        <div class="panel-heading clearfix">
            <h5>Weight of Components for each Subject
                <i onclick="$('#addDOSubjects').modal('show')"class="pull-right pointer fa fa-2x fa-plus"></i>
            </h5>
        </div>
        <div class="panel-body">
                <div id="DO_Container1">

                    <table class="table table-bordered">
                        <tr>
                            <th>Subjects</th>
                            <?php foreach($components as $c): ?>
                            <th><?php echo $c->component ?></th>
                            <?php endforeach; ?>
                            <th style="width:75px;"></th>
                        </tr>
                        <?php foreach ($subjects as $sub): ?>
                        <tr>
                            <td><?php echo $sub->subject; ?></td>
                            <?php foreach($components as $cp): ?>
                            <td>
                            <?php
                                $cmp = Modules::run('gradingsystem/new_gs/componentPerSubject', $sub->subject_id, $cp->id);
                                echo ($cmp->weight==0?"":($cmp->weight*100).' %');
                            ?>
                            </td>
                            <?php endforeach; ?>
                            <td><button onclick="showEditAssessWeight('<?php echo $sub->subject_id; ?>', '<?php echo $this->session->userdata('school_year'); ?>', '<?php echo $sub->subject ?>')" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></button></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <br />

        </div>
    </div>
</div>
<?php $this->load->view('addAssessment'); ?>

<script type="text/javascript">
    
    $(function(){
        $('#addCriteriaBtn').clickover({
            placement: 'top',
            html: true  
          });
    })  
    
    function showEditAssessWeight(subject, school_year, sub_title)
    {
        $('#editDOSubjects').modal('show')
        $('#subject_id').val(subject);
        $('#school_year').val(school_year)
        $('#sub_title').html(sub_title)
;    }
    
    function editSubjectWeight()
    {
        var subject_id =  $('#subject_id').val();
        var assessment = $('#editAssessment').val()
        var weight = $('#editWeight').val()
        var url = '<?php echo base_url().'gradingsystem/new_gs/editSubjectWeight' ?>';
        $.ajax({
           type: "POST",
           url: url,
           //dataType: 'json',
           data: 'subject_id='+subject_id+'&assessment='+assessment+'&weight='+weight+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
           success: function(data)
           {
              alert(data)    
              location.reload()
           }
       }) 
    }
    
    function addSubjectWeight()
    {
        var subject_id = $('#inputSubjectID').val()
        var assessment = $('#inputAssessment').val()
        var weight = $('#inputWeight').val()
        var url = '<?php echo base_url().'gradingsystem/new_gs/addSubjectWeight' ?>';
        $.ajax({
           type: "POST",
           url: url,
           //dataType: 'json',
           data: 'subject_id='+subject_id+'&assessment='+assessment+'&weight='+weight+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
           success: function(data)
           {
              alert(data)    
              location.reload()
           }
       }) 
    }
    function selectGS(value)
    {
        switch(value){
            case '1':
            $('#kpup_body').removeClass('hide');
            $('#DO_8').addClass('hide')
                break;
            case '2':
                
                $('#kpup_body').addClass('hide');
                $('#DO_8').removeClass('hide')
                break;
        }
        
        var url = "<?php echo base_url().'gradingsystem/saveGS/'?>" ;
          $.ajax({
           type: "POST",
           url: url,
           dataType: 'json',
           data: 'gs_used='+value+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
           success: function(data)
           {
                 
           }
         });
    }
    
    function saveTransmutation(){
           
          if($('#bybase').is(':checked'))
          {
              var byBase = 1
              var base = $('#base').val()
              var formula = ""
          }
          if($('#byform').is(':checked'))
              {
                  byBase = 0
                  base = ""
                  formula = $('#formula').val()
              }

          var url = "<?php echo base_url().'gradingsystem/saveTransmutation/'?>" ;
          $.ajax({
           type: "POST",
           url: url,
           dataType: 'json',
           data: 'byBase='+byBase+'&base='+base+'&formula='+formula+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
           success: function(data)
           {
                  alert(data.msg)
                  location.reload()
           }
         });
      }
      
    function saveCriteria()
    {
           var subject_id = $('#getSubject').val()
           
    }
    
    function saveKPUPS()
    {
         var subject_id = $('#getSubject').val()
         if($('#custom').is(':checked')){
             var custom = 0
         }else{
             custom = 1;
         }
        var k = $('#'+subject_id+'_kpupsContainer_1').val()
        var proc = $('#'+subject_id+'_kpupsContainer_2').val()
        var u = $('#'+subject_id+'_kpupsContainer_3').val()
        var prod = $('#'+subject_id+'_kpupsContainer_4').val()
            if(k==""){
                  k = 15;
              }
              if(proc==""){
                  proc = 25;
              }
              if(u==""){
                  u = 30;
              }
              if(prod==""){
                  prod = 30;    
              }
              
              var kpups = k + proc + u + prod;
              
        var aC = $('#addCriteriaBtn').attr('count')
        if(aC!='0'){
            if(aC > 1)
            {
                var i;
                var a = new Array();
                for(i=1; i<=aC; i++){
                    if(i==aC){
                       var c = ''
                    }else{
                        c=',';
                    }
                        a += '{"name": "'+$('#'+subject_id+'_kpupsContainer_'+i).attr('name')+'",'+'"value" :"'+$('#'+subject_id+'_kpupsContainer_'+i).val()+'"}'+c+'';
                    }
                    
            }
            else{
                a = '{"name": "'+$('#'+subject_id+'_kpupsContainer_'+1).attr('name')+'",'+'"value" :"'+$('#'+subject_id+'_kpupsContainer_'+1).val()+'"}';
            }
            var addedCriteria = '{"addedCriteria":['+a+']}'
            var hasAddedCriteria = 1;
        }
        else{
            hasAddedCriteria = 0;
        }
        
        //alert(k);
        var url = "<?php echo base_url().'gradingsystem/saveKPUPS/'?>" ;
          $.ajax({
           type: "POST",
           url: url,
           dataType: 'json',
           data: 'subject_id='+subject_id+'&k='+k+'&proc='+proc+'&u='+u+'&prod='+prod+'&addedCriteria='+addedCriteria+'&hasAddedCriteria='+hasAddedCriteria+'&custom='+custom+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
           success: function(data)
           {
                  if(data.status)
                      {
                          alert(data.msg)
                          location.reload()
                      }else
                          {
                              alert(data.alert)
                              console.log(data.msg)
                          }
           }
           });
    }
      
function addCriteria() {

        var subject_id = $('#getSubject').val()
        var subject_name = $('#getSubject :selected').text()
        var k = $('#'+subject_id+'_kpupsContainer_1').val()
        
        if($('#'+subject_id+'_kpupsContainer_1').length > 0){
            var proc = $('#'+subject_id+'_kpupsContainer_2').val()
            var u = $('#'+subject_id+'_kpupsContainer_3').val()
            var prod = $('#'+subject_id+'_kpupsContainer_4').val()
                        
        
        
              if(k==""){
                  k = 15
              }
              if(proc==""){
                  proc = 25
              }
              if(u==""){
                  u = 30
              }
              if(prod==""){
                  prod = 30
              }
              
              var kpups = parseInt(k)+parseInt(proc)+parseInt(u)+parseInt(prod);
                //alert(kpups)
            if(kpups>=100){
                  alert('Sorry, You Can\'t add a Criteria')
                          location.reload()
            }else{
                $('#addCriteriaBtn').clickover({
                    auto_close: 1000  
                  });
                var name = $('#addedCriteria').val();
                var i = $('#p_kpupsContainer_'+subject_id).find('input').length + 1;
                var kpupsContainer = $('#p_kpupsContainer_'+subject_id);
                $('<input type="text" id="'+subject_id+'_kpupsContainer_'+i+'" size="8" name="'+name+'" value="" placeholder="'+name.charAt(0)+' %" /><i class="pointer fa fa-trash" title="kpupsContainer" onclick="removed(this,'+i+')"></i>').appendTo(kpupsContainer);
                $('#addCriteriaBtn').attr('count', i);
                i++;  
            }
        }else{
            $('<label>'+subject_name+' :</label><br /><p id="p_kpupsContainer_'+subject_id+'">\n\
                \n\
                </p>').appendTo($('#kpupsContainer'))
                
                var kpupsContainer = $('#p_kpupsContainer_'+subject_id);
                $('<input style="margin-right:10px;" class="text-center" type="text" id="'+subject_id+'_kpupsContainer_1" size="8" name="Knowledge" value="15" placeholder="K %" />').appendTo(kpupsContainer);
                $('<input style="margin-right:10px;" class="text-center" type="text" id="'+subject_id+'_kpupsContainer_2" size="8" name="Process" value="25" placeholder="P %" />').appendTo(kpupsContainer);
                $('<input style="margin-right:10px;" class="text-center" type="text" id="'+subject_id+'_kpupsContainer_3" size="8" name="Understanding" value="30" placeholder="U %" />').appendTo(kpupsContainer);
                $('<input style="margin-right:10px;" class="text-center" type="text" id="'+subject_id+'_kpupsContainer_4" size="8" name="Product" value="30" placeholder="P %" />').appendTo(kpupsContainer);
                $('#addCriteriaBtn').attr('count', 4);            
        }

          

}

function addSubjectComponent() {

        var subject_id = $('#getSubject').val()
        var subject_name = $('#getSubject :selected').text()
        var k = $('#'+subject_id+'_kpupsContainer_1').val()
        
        if($('#'+subject_id+'_kpupsContainer_1').length > 0){
            var proc = $('#'+subject_id+'_kpupsContainer_2').val()
            var u = $('#'+subject_id+'_kpupsContainer_3').val()
            var prod = $('#'+subject_id+'_kpupsContainer_4').val()
                        
        
        
              if(k==""){
                  k = 15
              }
              if(proc==""){
                  proc = 25
              }
              if(u==""){
                  u = 30
              }
              if(prod==""){
                  prod = 30
              }
              
              var kpups = parseInt(k)+parseInt(proc)+parseInt(u)+parseInt(prod);
                //alert(kpups)
            if(kpups>=100){
                  alert('Sorry, You Can\'t add a Criteria')
                          location.reload()
            }else{
                $('#addCriteriaBtn').clickover({
                    auto_close: 1000  
                  });
                var name = $('#addedCriteria').val();
                var i = $('#p_kpupsContainer_'+subject_id).find('input').length + 1;
                var kpupsContainer = $('#p_kpupsContainer_'+subject_id);
                $('<input type="text" id="'+subject_id+'_kpupsContainer_'+i+'" size="8" name="'+name+'" value="" placeholder="'+name.charAt(0)+' %" /><i class="pointer fa fa-trash" title="kpupsContainer" onclick="removed(this,'+i+')"></i>').appendTo(kpupsContainer);
                $('#addCriteriaBtn').attr('count', i);
                i++;  
            }
        }else{
            $('<label>'+subject_name+' :</label><br /><p id="p_kpupsContainer_'+subject_id+'">\n\
                \n\
                </p>').appendTo($('#kpupsContainer'))
                
                var kpupsContainer = $('#p_kpupsContainer_'+subject_id);
                $('<input style="margin-right:10px;" class="text-center" type="text" id="'+subject_id+'_kpupsContainer_1" size="8" name="Knowledge" value="15" placeholder="K %" />').appendTo(kpupsContainer);
                $('<input style="margin-right:10px;" class="text-center" type="text" id="'+subject_id+'_kpupsContainer_2" size="8" name="Process" value="25" placeholder="P %" />').appendTo(kpupsContainer);
                $('<input style="margin-right:10px;" class="text-center" type="text" id="'+subject_id+'_kpupsContainer_3" size="8" name="Understanding" value="30" placeholder="U %" />').appendTo(kpupsContainer);
                $('<input style="margin-right:10px;" class="text-center" type="text" id="'+subject_id+'_kpupsContainer_4" size="8" name="Product" value="30" placeholder="P %" />').appendTo(kpupsContainer);
                $('#addCriteriaBtn').attr('count', 4);            
        }

          

}

function removed(e, i, id)
{
    var name = $('#kpupsContainer_'+i).attr('name')  
    if( i > 0 ) {

            $(e).parents('p').remove();
            i--;
            $('#addCriteriaBtn').attr('count', i);
    }
       var url = "<?php echo base_url().'gradingsystem/deleteKPUPS/'?>" ;
      $.ajax({
       type: "POST",
       url: url,
       dataType: 'json',
       data: 'custom='+i+'&name='+name+'&id='+id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
       success: function(data)
       {
              if(data.status)
                  {
                      alert(data.msg)
                      location.reload()
                  }else
                      {
                          console.log(data.msg)
                      }
       }
       });
}


function addComponent()
{
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'gradingsystem/addComponent' ?>",
        data: "component="+$('#component').val()+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
        dataType:'json',
        success: function(data)
        {
            if(data.status){
                $('#inputAssessment').append('<option value="'+data.id+'"> '+$('#component').val()+'</option>');
                alert('Successfully Added')
            }else{
                alert('Sorry Component already exist');
            }
            
            $('#addComponent').modal('hide');
        }
    
        });
}
   
</script>