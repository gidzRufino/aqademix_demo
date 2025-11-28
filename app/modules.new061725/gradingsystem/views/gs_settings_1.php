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
   
   switch($gs_settings->gs_used):
       case 1:
       $kpup = '';
       $do_8 = 'hide';
       $kpup_radio = 'checked';  
       $do_8_radio = '';
           break;
       case 2:
       $kpup = 'hide';
       $do_8 = '';
       $kpup_radio = '';  
       $do_8_radio = 'checked';
           
           break;
       default :
       $kpup = 'hide';
       $do_8 = 'hide';
           break;
   endswitch;
   //print_r($category);]
?>

<div class="row" id="gs_settings_body">
    <div class="col-lg-12">
        <p><b>Please Select the Grading System to be used:</b></p>
        <input <?php echo $kpup_radio ?> id="kpup" name="gs_type" type="radio" onclick="selectGS(this.value)"  value="1" /> KPUP &nbsp;
        <input <?php echo $do_8_radio ?> id="order" name="gs_type" type="radio"  onclick="selectGS(this.value)" value="2" /> DepEd Order #8 s.2015<br /><br />
    </div>
    <div id="DO_8" class="<?php echo $do_8 ?> col-lg-7">
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
                                    
                                    $do_8settings = Modules::run('gradingsystem/getDO_settings');
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
    <div id="kpup_body" class="<?php echo $kpup ?>">
        <div class="col-lg-6">
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
                    <h5>KPUP Settings
                        <i onclick="saveKPUPS()"class="pull-right pointer fa fa-2x fa-save"></i>
                    </h5>
                </div>
                <div class="panel-body">
                    <input id="default" name="kpups" type="radio" <?php echo $default ?>   value="1" /> Default <br /><br />
                    <p style="padding-left:20px;">Knowledge : 15% <br />Process : 25% <br />Understanding : 30% <br />Product : 30%</p>
                    <input id="custom" name="kpups"  <?php echo $custom ?> type="radio" value="1" /> Customized Percentage <br /><br />
                        <p style="padding-left:20px;">Please type in the different percentage you may want to assign to each KPUP<br></p>
                        <div id="kpupsContainer1">
                            <label>Per Subject Percentage Breakdown: </label>
                            <select id="getSubject" onclick="$('#subject_name').val(this.text)" style="width:200px;">
                                <option value="0">Default</option>
                                <?php foreach ($subjects as $sub): ?>
                                <option name="<?php echo $sub->subject ?>" value="<?php echo $sub->subject_id ?>"><?php echo $sub->subject ?></option>   
                                <?php endforeach; ?>
                            </select>
                            <input type="hidden" id="subject_name" />
                            <input count="<?php echo $a ?>" class="col-lg-2 btn btn-sm btn-danger clickover <?php echo $disabled ?> pull-right" data-toggle="clickover" type="button" placeholder="Product" 
                                            data-content=" 
                                                         <div class='col-lg-12 form-group' style='width:230px;'>
                                                             <label class='control-label'>Add Criteria</label>
                                                             <div class='controls' id='AddedSection'>
                                                               <input type='text' id='addedCriteria' class='form-control' />
                                                             </div>
                                                         </div>
                                                         <div class'col-lg-12'>
                                                              <button data-dismiss='clickover' class='btn btn-xs btn-danger'>Cancel</button>&nbsp;&nbsp;
                                                              <a href='#' onclick='addCriteria()' data-dismiss='clickover' style='margin-right:10px; color:white' class='btn btn-xs btn-success pull-left'>Add</a>
                                                         </div> 
                                                      "
                                            value="Add Criteria" id="addCriteriaBtn" onclick="$('#custom').attr('checked', 'checked'),addCriteria()" />  
                        </div>
                        <br />
                        <div class="col-lg-12">
                            <label>Default :</label><br />
                            <p class="pull-left col-lg-12" id="<?php echo 'p_kpupsContainer_0' ?>">
                            <?php
                            $x = 0;
                            $i = 0;
                            foreach ($category as $cat):

                                if($cat->subject_id==0):
                                    $x++;
                                    if($x>4):
                                        $i++;
                                    ?>

                                            <input name="<?php echo $cat->category_name?>" subject="0"  onclick="$('#custom').attr('checked', 'checked'), $('#addCriteriaBtn').removeClass('disabled')" style="margin-right:10px; width:50px" class="col-lg-2" type="text" id="<?php echo $cat->subject_id.'_kpupsContainer_'.$i; ?>" value="<?php if($default==""): echo $cat->weight*100; else: echo ''; endif; ?>" /> <i class="pointer fa fa-trash" title="kpupsContainer" onclick="removed(this,<?php echo $i ?>)"></i>

                                    <?php
                                    else:
                                        $i++;
                                        ?>
                                        <input name="<?php echo $cat->category_name;?>" onclick="$('#custom').attr('checked', 'checked'), $('#addCriteriaBtn').removeClass('disabled')" style="margin-right:10px; width:50px" class="col-lg-2" type="text" id="<?php echo $cat->subject_id.'_kpupsContainer_'.$i; ?>" value="<?php echo $cat->weight*100 ?>" />


                                        <?php 
                                    endif;
                                endif;
                            endforeach; 
                            ?>
                            </p>            

                        </div>
                        <div class="col-lg-12" id="kpupsContainer">
                            <?php

                            foreach ($subjects as $s):
                                $l=1;
                                $i = 0;
                                    foreach ($category as $cat):

                                        if($s->subject_id == $cat->subject_id):
                                            if($l==1):
                                               $l++;
                                               echo "<label class='pull-left'>$s->subject :</label><br /><br />";
                                               ?>
                                                <p class="pull-left col-lg-12" id="<?php echo 'p_kpupsContainer_'.$cat->subject_id; ?>">
                                                    <?php     
                                            endif;

                                            $x++;

                                            if($x>4):
                                                ?>
                                                    <span class="pull-left"><input name="<?php echo $cat->category_name?>" subject="<?php echo $cat->subject_id ?>"  onclick="$('#custom').attr('checked', 'checked'), $('#addCriteriaBtn').removeClass('disabled')" style="margin-right:10px; width:50px" class="col-lg-2" type="text" id="<?php echo $cat->subject_id.'_kpupsContainer_'.$i; ?>" value="<?php if($default==""): echo $cat->weight*100; else: echo ''; endif; ?>" /> <i style="color:red;float:left;margin:5px 5px 5px 0; width:50px;" class="pointer fa fa-trash" title="kpupsContainer" onclick="removed(this,<?php echo $i ?>,<?php echo $cat->code ?>)"></i></span>
                                                <?php    
                                            else:
                                                        $i++;
                                                        ?>
                                                    <span><input name="<?php echo $cat->category_name?>" subject="<?php echo $cat->subject_id ?>"  onclick="$('#custom').attr('checked', 'checked'), $('#addCriteriaBtn').removeClass('disabled')" style="margin-right:10px; width:50px" class="col-lg-2" type="text" id="<?php echo $cat->subject_id.'_kpupsContainer_'.$i; ?>" value="<?php if($default==""): echo $cat->weight*100; else: echo ''; endif; ?>" /> <i style="color:red;float:left;margin:5px 5px 5px 0;" class="pointer fa fa-trash" title="kpupsContainer" onclick="removed(this,<?php echo $i ?>,<?php echo $cat->code ?>)"></i></span>

                                                        <?php 
                                                    endif;

                                        endif;

                                    endforeach; 
                                    if($l==1):
                                    ?>   
                                            </p>

                                                <?php 
                                                endif;
                                    unset($l);
                                    unset($x);


                            endforeach;
                             ?>
                                     <br />          
                                    <?php                
                            ?>

                        </div>

                </div>
            </div>
        </div>
    </div>
    
    
</div>
<?php $this->load->view('addDO8_subjects'); ?>
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
   
</script>