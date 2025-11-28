<?php
    if($this->session->userdata('is_admin') || $this->session->userdata('is_superAdmin')):
        $t_id = $this->uri->segment(3);
    else:
        $t_id = base64_encode($this->session->userdata('username'));
    endif;
    if($this->uri->segment(4)===FALSE):
        $from = date("Y-m-d", strtotime('monday this week'));
    else:
        $from = $this->uri->segment(4);
    endif;
    if($this->uri->segment(5)===FALSE):
        
        $to = date("Y-m-d", strtotime('friday this week'));
    else:
        $to = $this->uri->segment(5);
    endif;
?>

<div class="row">
    <div class="col-lg-12">
        <div style="margin-top:10px;">
            <div class="control-group pull-right">
              <div class="controls">
                  <label style="padding:5px" class="control-label pull-left" for="inputAdmissionDate">Date to</label>
                  <input name="dateTo" type="text" value="<?php echo $to;?>" data-date-format="yyyy-mm-dd" id="dateTo" >
                  <button onclick="getDLLFrom('<?php echo $t_id ?>',document.getElementById('dateFrom').value, document.getElementById('dateTo').value)" style="margin-left: 10px;" class="btn btn-success btn-xs pull-right">search</button>  
                </div>

            </div>
            <div class="control-group  pull-right">
              <div class="controls">
                  <label style="padding:5px" class="control-label pull-left" for="inputAdmissionDate">Date From</label>
                  <input name="dateFrom"  type="text" value="<?php echo $from;?>" data-date-format="yyyy-mm-dd" id="dateFrom" >
                </div>
            </div>
        </div>
            
        <h3 class="page-header clearfix" style="margin:15px 0 0 0">Lesson Log Timeline <small> <a href="<?php echo base_url().'daily_lesson_log/create' ?>"><i class="fa fa-file-text-o"></i></a></small></h3>
    </div>
    <div class="col-lg-12">
        <ul class="timeline">
             <?php 
               $num = 0;
               foreach($lessons->result() as $l):
               if($l->dll_submitted=='0000-00-00'):
                   $badge = 'fa-info';
                   $timeline = 'danger';
                   $action = 'onclick="submitDLL()"';
               else:
                   if($l->checked):
                       $badge = 'fa-check';
                        $timeline = 'success';
                        $action = '';
                   else:
                       if($this->session->userdata('is_admin') || $this->session->userdata('is_superAdmin')):
                            $badge = 'fa-send';
                            $timeline = 'info';
                            $action = 'onclick="checkDLL()"';
                       else:
                            $badge = 'fa-send';
                            $timeline = 'info';
                            $action = '';
                       endif;
                   endif;
               endif;
               if(($num++)&1):
                   $li = 'timeline-inverted';
                   $double = 'double-left';
               else:
                    $li = '';
                   $double = 'double-right';
               endif;
             ?>
               <li class="<?php echo $li ?>" >
                   <div <?php echo $action ?> id="badge_<?php echo $l->dll_id ?>" onmouseover="$('#dll_id_value').val('<?php echo $l->dll_id ?>')" class="timeline-badge pointer <?php echo $timeline; ?>">
                        <i id="fa_<?php echo $l->dll_id ?>" class="fa <?php echo $badge ?>"></i>
                    </div>
                    <div id="tl_<?php echo $l->dll_id ?>" style="height: 130px; overflow-y:hidden;" class="timeline-panel tlMin" onmouseover="$('#dll_id').val('<?php echo $l->dll_id ?>')">
                        <div class="timeline-heading clearfix">
                            <i class="fa fa-plus-square pull-right pointer" id="minMax_<?php echo $l->dll_id ?>" onclick="expandTimeline('<?php echo $l->dll_id ?>')"></i>
                            <h4 class="timeline-title text-danger"><?php echo $l->lesson ?> ( <?php echo $l->subject.' - '. $l->section ?> )</h4>
                            
                        </div>
                        <div class="timeline-body" onmouseover="$('#dll_id_value').val('<?php echo $l->dll_id ?>')"  data-toggle="context" data-target="#dllMenu">
                            <div class="col-lg-6 pull-left no-padding">
                                 <h5>References: 
                                 </h5>
                                <blockquote style="font-size: 14px; padding:0 10px;">
                                    <?php 
                                        $refUsed = Modules::run('daily_lesson_log/getReferences', $l->dll_id);
                                        foreach($refUsed as $su):
                                            if($su->type_id!=5):
                                    ?>
                                            <span onmouseover="$('#deleteId').val('<?php echo $su->ref_id ?>')"><?php  echo $su->ref_mat.' pp. : '.$su->page_num?></span><br />
                                    <?php
                                            else:
                                    ?>
                                            <span onmouseover="$('#deleteId').val('<?php echo $su->ref_id ?>')"><?php  echo $su->ref_mat.' : '.$su->page_num?></span><br />
                                    <?php        
                                            endif;
                                        endforeach; 
                                        ?>
                                </blockquote> 
                            </div>
                            <div class="col-lg-6 pull-right no-padding">
                                 <h5>Learner's Material Used: 
                                 </h5>
                                <blockquote style="font-size: 14px; padding:0 10px;">
                                    <?php 
                                        $matUsed = Modules::run('daily_lesson_log/getMaterialUsed', $l->dll_id);
                                        foreach($matUsed as $mu):
                                            if($mu->type_id!=5):
                                                ?>
                                            <span onmouseover="$('#deleteId').val('<?php echo $mu->mat_id ?>')"><?php  echo $mu->ref_mat.' pp. : '.$mu->page_num?></span><br />
                                            <?php
                                            else:
                                            ?>
                                             <span onmouseover="$('#deleteId').val('<?php echo $mu->mat_id ?>')"><?php  echo $mu->ref_mat.' : '.$mu->page_num?></span><br />
                                            <?php 
                                            endif;
                                        endforeach; 
                                        ?>
                                </blockquote> 
                            </div>
                            <div class="col-lg-12 no-padding">
                                <div class="col-lg-6 pull-left no-padding">
                                    <h5>Other Activities: 
                                    </h5>
                                   <blockquote style="font-size: 14px; padding:0 10px;">
                                       <?php 
                                           $act = Modules::run('daily_lesson_log/getActivities', $l->dll_id);
                                           foreach($act as $a):
                                               ?>
                                               <span onmouseover="$('#deleteId').val('<?php echo $a->act_id ?>')"><?php echo $a->activity?></span><br />
                                               <?php
                                           endforeach; 
                                           ?>
                                   </blockquote> 
                               </div>
                               <div class="col-lg-6 pull-right no-padding pointer">
                                    <h5>Remarks: 
                                    </h5>
                                  
                                   <blockquote onclick="$('#assessmentDetails').modal('show'), getAssessmentDetails('<?php echo $l->dll_assess_id ?>', '<?php echo $l->dll_section_id ?>','<?php echo $l->dll_sub_id ?>','<?php echo $l->lesson ?> ( <?php echo $l->subject.' - '. $l->section ?> )')" style="font-size: 14px; padding:0 10px;">
                                       <?php 
                                            $assessmentResult = Modules::run('daily_lesson_log/checkAssessmentResult', $l->dll_assess_id);
                                            $AR = json_decode($assessmentResult);
                                            $percentage = round(($AR->ml/($AR->ml+$AR->nr))*100,2);
                                       ?>
                                       No. of learners within mastery level:<br/> <strong><?php echo $AR->ml; ?> or <?php echo $percentage.'%' ?></strong><br/><br/>
                                       No. of learners needing Remediation<br/>/Reinforcements:<br/><strong><?php echo $AR->nr; ?> </strong><br/><br/>
                                       
                                   </blockquote> 
                               </div>
                            </div>

                        </div>
                    </div>

                    <div class="<?php echo $double ?>">
                        <div class="timeline-heading">
                            <h4 class="timeline-title"><?php echo date('l', strtotime($l->dll_date)) ?></h4>
                            <p><small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo date('F d, Y', strtotime($l->dll_date)) ?></small>
                            </p>
                        </div>
                        <?php $comment = Modules::run('daily_lesson_log/getComments', $l->dll_id); 
                            if($comment->num_rows()>0):
                        ?>
                                <hr style='margin:2px auto;' />
                                <strong>Comment:</strong>
                                <p style="font-size: 14px; text-align: left; text-indent: 10px;">
                                    <?php echo $comment->row()->comments; ?>
                                </p>
                        <?php
                            endif;
                        ?>
                        
                        
                    </div>
                    
                </li>
            <?php
               endforeach;
            ?>
            
        </ul>
    </div>
    
</div>

<input type="hidden" id="dll_id" />
<input type="hidden" id="dll_id_value" />
<input type="hidden" id="deleteId" />
<div id="dllMenu">
    <ul class="dropdown-menu" role="menu">
        <?php
        if($this->session->userdata('is_admin') || $this->session->userdata('is_superAdmin')):
        ?>
        <li onclick="$('#addComment').modal('show')" class="pointer"><a tabindex="-1"><i class="fa fa-edit fa-fw"></i>Add Remarks</a></li>
        
        <?php
        else:
            if($result->total==0):
        ?>
        <li  class="pointer"><a onclick="showModal('addReference')"><i class="fa fa-plus-square fa-fw"></i>Add Reference</a></li>
        <li  class="pointer"><a onclick="showModal('addMaterials')"><i class="fa fa-plus-square fa-fw"></i>Add Material Used</a></li>
        <li  class="pointer"><a onclick="showModal('addActivities')"><i class="fa fa-plus-square fa-fw"></i>Add Other Activities</a></li>
        <li  class="pointer"><a onclick="deleteItem('reference')"><i class="fa fa-trash fa-fw"></i>Delete Reference</a></li>
        <li  class="pointer"><a onclick="deleteItem('material')"><i class="fa fa-trash fa-fw"></i>Delete Material Used</a></li>
        <li  class="pointer"><a onclick="deleteItem('activities')"><i class="fa fa-trash fa-fw"></i>Delete Activity</a></li>
        <li class="divider"></li>
        <li  class="pointer"><a onclick="deleteDll()"><i class="fa fa-trash fa-fw"></i>Delete DLL</a></li>
        <?php
            endif;
        endif;
        ?>
    </ul>
</div>
<?php $this->load->view('dllModal'); 
        $this->load->view('assessmentDetails');
?>
<script type="text/javascript">
    $(function(){
        $('#dateFrom').datepicker();
        $('#dateTo').datepicker();
        $('.addButton').clickover({
            placement: 'top',
            html: true
      });
    });
    
    function showModal(id)
    {
        $('#'+id).modal('show');
    }
    
    function expandTimeline(id)
    {
        if($('#tl_'+id).hasClass('tlMin')){
             $('#tl_'+id).css('height','auto');
             $('#tl_'+id).removeClass('tlMin');
             $('#minMax_'+id).addClass('fa-minus-square');
             $('#minMax_'+id).removeClass('fa-plus-square');
        }else{
             $('#tl_'+id).css('height','130px')
             $('#tl_'+id).addClass('tlMin');
             $('#minMax_'+id).addClass('fa-plus-square');
             $('#minMax_'+id).removeClass('fa-minus-square');
        }
       
    }
    
    function deleteDll()
    {
        var dll_id = $('#dll_id').val()
        var url = '<?php echo base_url().'daily_lesson_log/deleteItem/' ?>'+'dll/'+dll_id
        
        var answer = confirm("Do you really want to delete this dll ? You cannot undo this action, so be careful.");
        if(answer==true){
            $.ajax({
                   type: "GET",
                   url: url,
                   data: "data="+""+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       alert('Successfully deleted!')
                       location.reload()
                   }
                 });

            return false;
        }
    }
    
    function deleteItem(item)
    {
        var deleted_id = $('#deleteId').val()
        
        var url = '<?php echo base_url().'daily_lesson_log/deleteItem/' ?>'+item+'/'+deleted_id
        
        var answer = confirm("Do you really want to delete this "+item+"? You cannot undo this action, so be careful.");
        if(answer==true){
            $.ajax({
                   type: "GET",
                   url: url,
                   data: "data="+""+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       alert('Successfully deleted!')
                       location.reload()
                   }
                 });

            return false;
        }
    }
    
    function saveMatType()
    {
       var ref = $('#matType').val();
       var page_num = $('#mat_page_num').val()
       var dll_id = $('#dll_id_value').val();
       var url = "<?php echo base_url().'daily_lesson_log/addMaterial/'?>"+ref+'/'+page_num+'/'+dll_id; // the script where you handle the form input.

            $.ajax({
                   type: "GET",
                   url: url,
                   data: "data="+""+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       alert('Material Reference Saved!')
                       $('#materialUsed').append(data);
                   }
                 });

            return false;
    }
    function addReference()
    {
       var ref = $('#refType').val();
       var page_num = $('#page_num').val()
       var dll_id = $('#dll_id_value').val();
       var url = "<?php echo base_url().'daily_lesson_log/addReference/'?>"+ref+'/'+page_num+'/'+dll_id; // the script where you handle the form input.

            $.ajax({
                   type: "GET",
                   url: url,
                   data: "data="+""+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       alert('Reference Successfully Added!')
                       location.reload
                   }
                 });

            return false;
    }
    function saveActivities()
    {
       var page_num = $('#activity').val()
       var dll_id = $('#dll_id_value').val();
       var url = "<?php echo base_url().'daily_lesson_log/addActivities/'?>"+page_num+'/'+dll_id; // the script where you handle the form input.

            $.ajax({
                   type: "GET",
                   url: url,
                   data: "data="+""+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       alert('Activities Successfully Added!')
                       location.reload()
                   }
                 });

            return false;
    }
    
    function saveComment()
    {
       var page_num = $('#comment').val()
       var dll_id = $('#dll_id_value').val();
       var url = "<?php echo base_url().'daily_lesson_log/saveComment/'?>"+dll_id; // the script where you handle the form input.

            $.ajax({
                   type: "POST",
                   url: url,
                   data: "data="+page_num+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       alert('Comments are Saved!')
                       location.reload()
                   }
                 });

            return false;
    }
    
    function submitDLL()
    {
       var dll_id = $('#dll_id_value').val();
       var url = "<?php echo base_url().'daily_lesson_log/submitDLL/'?>"+dll_id; // the script where you handle the form input.

            $.ajax({
                   type: "GET",
                   url: url,
                   data: "data="+""+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       alert('Successfully Submitted!')
                       $('#fa_'+dll_id).removeClass('fa-info');
                       $('#fa_'+dll_id).addClass('fa-send');
                       $('#badge_'+dll_id).removeClass('danger');
                       $('#fa_'+dll_id).addClass('info');
                       
                   }
                 });

            return false;
    }
    
    function checkDLL()
    {
       var dll_id = $('#dll_id_value').val();
       var url = "<?php echo base_url().'daily_lesson_log/checkDLL/'?>"+dll_id; // the script where you handle the form input.

            $.ajax({
                   type: "GET",
                   url: url,
                   data: "data="+""+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       $('#fa_'+dll_id).removeClass('fa-send');
                       $('#fa_'+dll_id).addClass('fa-check');
                       $('#badge_'+dll_id).removeClass('info');
                       $('#fa_'+dll_id).addClass('success');
                       
                   }
                 });

            return false;
    }
    
    function getDLLFrom(user_id, from, to)
    {
        var url = "<?php echo base_url().'daily_lesson_log/getDLL/'?>"+user_id+'/'+from+'/'+to
        document.location = url;
    }
    
    function getAssessmentDetails(id, section_id, subject_id, title)
        {

            var url = "<?php echo base_url().'gradingsystem/getCPR_graph/'?>"+id+'/'+section_id+'/'+subject_id
              $.ajax({
                           type: "GET",
                           url: url,
                           //dataType:'json',
                           data: 'csrf_test_name='+$.cookie('csrf_cookie_name'),
                           success: function(data)
                           {
                               $('#assessBody').html(data)
                               $('#assessTitle').html(title+' Assessment Details <i class="fa fa-close pull-right pointer" data-dismiss="modal"></i>')
                              
                           }
              })    
        }
</script>
