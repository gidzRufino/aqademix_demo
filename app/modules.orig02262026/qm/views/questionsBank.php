<div class="row">
    <div class="col-lg-12 no-padding">
        <div class="page-header no-margin clearfix">
            <div class="col-lg-5 pull-right" style="margin-top: 5px;">
                <button onclick="document.location='<?php echo base_url('qm') ?>'" class="btn btn-sm btn-default pull-right" >DASHBOARD</button>
            </div>
            <h2 class="no-margin col-lg-7">Questions Bank <i class="fa fa-database"></i></h2>
        </div>
    </div>
</div>

<div class="col-lg-12">
    <div class="col-lg-9 col-xs-12 clearfix">
        <h4>List of Questions [ <span class="text-danger" id="numberOfQuestions"><?php echo count($questions) ?></span> ]</h4>
        <ol id="quiz_items">
            <?php 
                foreach($questions as $q ):
                    $selection = Modules::run('qm/getQuizAnswer', $q->qq_id, 0);
                    $tags = Modules::run('qm/getTags', $q->qq_id);
                    $skills = Modules::run('qm/getSkills', $q->qq_id);
                ?>
            <li  style="margin-bottom:5px;"><?php echo $q->question; ?><span id="li_<?php echo $q->qq_id ?>"> </span> 
                <?php if($accessLevel <= 2): ?>
                <div class="btn-group">
                    <button id="li_<?php echo $q->qq_id ?>_edit" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i></button>
                        <ul class="dropdown-menu dropdown-menu-left">
                            <li><a href="#"><i class="fa fa-edit fa-fw"></i> | Edit Question</a></li>
                            <li onclick="$('#addTag').modal('show'), 
                                        $('#q_id').val('<?php echo $q->qq_id ?>'), 
                                        $('#tagHeader').html('<?php echo (!empty($tags)?'Edit Tags':'Add Tags') ?>')"><a href="#"><i class="fa fa-plus fa-fw"></i> | <?php echo (!empty($tags)?'Edit':'Add') ?> Tag</a></li>
                            <li onclick="$('#addSkill').modal('show'), 
                                        $('#sq_id').val('<?php echo $q->qq_id ?>'), 
                                        $('#skillHeader').html('<?php echo ($skills->qq_skills!=""?'Edit Skills':'Add Skills') ?>')"><a href="#"><i class="fa fa-plus fa-fw"></i> | <?php echo ($skills->qq_skills!=""?'Edit':'Add') ?>  Skills Learned</a></li>
                            <li onclick="$('#printIdModal').modal('show')"><a href="#"><i class="fa fa-plus fa-fw"></i> | Add Degree of Difficulty</a></li>
                            <li onclick="$('#printIdModal').modal('show')"><a href="#"><i class="fa fa-check fa-fw"></i> | Tag as Standard Test Question</a></li>
                        </ul>
                </div>
                <?php endif; ?>
                <br />
                    <?php
                    if($q->qq_qt_id!=2):?>
                    <input class="form-control" style="width:50%;" placeholder="answer" type="text" id="<?php echo $q->qq_id ?>" name="<?php echo $q->qq_id ?>"/>
                    <?php
                    else: 
                        foreach ($selection->result() as $choice):
                        ?>
                    <input type="radio" name="sel_<?php echo $q->qq_id ?>" onclick="$('#<?php echo $q->qq_id ?>').val(this.value)" value="<?php echo $choice->qs_selection ?>" /> <?php echo $choice->qs_selection.'. '.$choice->qs_choice ?><br />

                    <?php
                        endforeach;
                    ?>
                        <input  type="hidden" id="<?php echo $q->qq_id ?>" name="<?php echo $q->qq_id ?>" />
                    <?php
                    endif;
                    ?>
                <div class="row">
                    <h5 class="text-danger">Tags: <?php echo (!empty($tags)?$tags->qci_qc_tags:''); ?> </h5>
                    <h5 class="text-warning">Skills Learned: <?php echo ($skills->qq_skills!=""?$skills->qq_skills:''); ?> </h5>
                </div>
                </li>
                <?php
                endforeach;
            ?>
        </ol>
    </div>
    <div class="col-lg-3 col-xs-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-header no-margin">Multiple Intelligences</h4>
            </div>
            <div class="panel-body no-padding">
                <?php foreach ($skill as $s): ?>
                <div  class='btn btn-info alert alert-warning no-margin' style="border-radius: 0; padding-top:5px; padding-bottom: 5px; width: 100%;">
                
                    <div class="notify">
                        <?php echo $s->qm_skills; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('editModal'); ?>

<script type="text/javascript">
    $(document).ready(function() {
                        
       $("#addedTags").select2({tags:[<?php
         foreach ($quiz_cat as $qc) { 
             echo '"'.$qc->qm_category.'",';
         }
        ?>]});
                        
       $("#addedSkills").select2({tags:[<?php
         foreach ($skill as $s) { 
             echo '"'.$s->qm_skills.'",';
         }
        ?>]});
    });
    
      
    function addSkill()
    {
        var skills = $('#addedSkills').val()
        var q_id = $('#sq_id').val();
        var url = "<?php echo base_url().'qm/saveSkills/'?>" // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               data: "skills="+skills+"&q_id="+q_id+'&csrf_test_name='+$.cookie('csrf_cookie_name')                                                                                                                                                                                                                                                                                     , // serializes the form's elements.
               success: function(data)
               {
                  alert('successfully added');
                  location.reload();
               }
        });
    }
      
    function addTag()
    {
        var tags = $('#addedTags').val()
        var q_id = $('#q_id').val();
        var url = "<?php echo base_url().'qm/saveTags/'?>" // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               data: "tags="+tags+"&q_id="+q_id+'&csrf_test_name='+$.cookie('csrf_cookie_name')                                                                                                                                                                                                                                                                                     , // serializes the form's elements.
               success: function(data)
               {
                  alert('successfully added');
                  location.reload();
               }
        });
    }
    
    </script>
