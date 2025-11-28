<?php
   if($gs_settings->by_base!=0):
       $bybase = "checked";
       $base = $gs_settings->base;
       $byform = '';
       $formula = '';
   else:    
       $bybase = "";
       $base ='';
       $byform = 'checked';
       $formula = $gs_settings->formula;
   endif;
   
   if($gs_settings->kpup_default==1):
       $default='checked';
       $custom = '';
       $disabled ='disabled';
   else:
       $default = '';
       $custom = 'checked';
       $disabled ='';
       $y = 0;
       $a = 0;
        foreach ($category as $cat):
            $y++;
        if($y>4):
            $a++;
        endif;
        endforeach;
   endif;
   
   switch($gs_settings->customized_beh_settings):
       case 0:
       $bhs0 = 'checked'; 
       $bhs1 = '';
           break;
       case 1:
       $bhs0 = ''; 
       $bhs1 = 'checked';
           
           break;
       default :
       $bhs0 = 'checked'; 
       $bhs1 = '';
           break;
   endswitch;
   //print_r($category);]
?>

<div class="row" id="gs_settings_body">

    <div id="DO_8" class="<?php echo $do_8 ?> col-lg-6">
        <b>Grading System used:</b><br />
        <input id="order" name="gs_type" type="radio"   value="2" /> DepEd Order #8 s.2015<br /><br />

        <div class="col-lg-12">
            <div class="panel panel-green">
                <div class="panel-heading clearfix">
                    <h5>Raw Score Transmutation
                        <!--<i onclick="saveTransmutation()" class="pull-right pointer fa fa-2x fa-save"></i>-->
                    </h5>
                </div>
                <div class="panel-body">
                    <p>Raw score are being transmuted this way:<br />
                       <br />
                       <b>Percentage Score(PS)</b> = ((Learner's Total RS / Highest Possible Score) * 100%);
                    </p>
                </div>
            </div>

        </div>
        <div class="col-lg-12">
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
                                    <th style="width:75px;">Written Work</th>
                                    <th style="width:75px;">Performance Task</th>
                                    <th style="width:75px;">Quarterly Assessment</th>
                                    <th style="width:75px;"></th>
                                </tr>
                                <?php
                                    
                                    $do_8settings = Modules::run('gradingsystem/getDO_settings', NULL, $this->session->userdata('school_year'));
                                    foreach ($do_8settings as $ds):
                                        $do_settings = Modules::run('gradingsystem/getDO_settings', $ds->subject_id);
                                ?>
                                
                                <tr>
                                    <td style="width:100px;"><?php echo $ds->subject ?></td>
                                    <?php foreach ($do_settings as $subDS): ?>
                                        <td style="text-align: center; vertical-align: middle"><?php echo ($subDS->weight=="" ? "" : ($subDS->weight*100).'%') ?></td>
                                    <?php endforeach; ?>
                                    <td style="text-align: center; vertical-align: middle"><!--<button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></i></button> | --><button onclick="showEditAssessWeight('<?php echo $ds->subject_id; ?>', '<?php echo $this->session->userdata('school_year'); ?>', '<?php echo $ds->subject ?>')" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></button></td>
                                </tr>
                                <?php
                                    endforeach;
                                ?>
                            </table>
                        </div>
                        <br />

                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 pull-right">
        <b>Learner's Observed Values</b><br />
        <input <?php echo $bhs0?> id="bhS0" name="behS" type="radio" onclick="saveGS('customized_beh_settings',this.value)"  value="0" /> Default &nbsp;
        <input <?php echo $bhs1 ?> id="bhS1" name="behS" type="radio"  onclick="saveGS('customized_beh_settings',this.value)" value="1" /> Customized<br /><br />

        <?php echo Modules::run('gradingsystem/behSettings') ?>
    </div>
</div>
<?php $this->load->view('addDO8_subjects'); ?>
<?php $this->load->view('behavior_settings_modal'); ?>
<input type="hidden" id="prevSelected" value="" />
<script type="text/javascript">
    
    $(function(){
        $('#addCriteriaBtn').clickover({
            placement: 'top',
            html: true  
          });
    });  
    
    
    function showEditAssessWeight(subject, school_year, sub_title)
    {
        $('#editDOSubjects').modal('show')
        $('#subject_id').val(subject);
        $('#school_year').val(school_year)
        $('#sub_title').html(sub_title)
        var url = '<?php echo base_url().'gradingsystem/getAssessCatDropdown/' ?>'+subject+'/'+school_year;
        $.ajax({
           type: "GET",
           url: url,
           //dataType: 'json',
           data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
           success: function(data)
           {
             $('#editAssessment').html(data)  
           }
       }) 
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
    function saveGS(column,value)
    {
        
        var url = "<?php echo base_url().'gradingsystem/saveGS/'?>" ;
          $.ajax({
           type: "POST",
           url: url,
           data: 'gs_used='+value+'&column='+column+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
           success: function(data)
           {
                alert('Settings Successfully Updated')
                 location.reload();
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
   
</script>