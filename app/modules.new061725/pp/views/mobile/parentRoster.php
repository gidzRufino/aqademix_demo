<div data-role="page" id="parentRoster" >
    <div data-role="content" >
    <?php echo Modules::run('mobile/headerPanel'); 
        $children = explode(',', $child_links);
        
    ?>
        <div class="mobile-blue-trans full-height" id="studentInfo">
            <?php 
                foreach($children as $child):
                    $isEnrolled = Modules::run('registrar/isEnrolled', $child, $this->session->userdata('school_year'));
                    if(!$isEnrolled):
                        $school_year = $this->session->userdata('school_year')-1;
                    endif;
                    $student = Modules::run('registrar/getSingleStudent', $child, $school_year);
                    $adviser = Modules::run('academic/getAdvisory',NULL, $school_year, $student->section_id);
                ?>
            <a href="#" onclick="getIndividualRecords('<?php echo base64_encode($child) ?>')">
                    <div class='col-xs-12 panel mobile-panel-name pointer'>
                        <div class='panel-heading no-padding'>
                            <div class="col-xs-3">
                                 <img class="img-circle img-thumbnail text-right" style="width:80px;" src="<?php echo base_url('uploads/noImage.png') ?> " />
                            </div>
                            <div class="col-xs-8">
                                <h4 style="margin:5px 0 5px"><?php echo strtoupper($student->firstname.' '. $student->lastname) ?></h4>
                                <h5 class="no-margin"><?php echo $student->level ?> - <?php echo $student->section ?></h5>
                            </div>
                        </div>
                    </div>
                </a>
            <?php
                endforeach;
                ?>
            
        </div>
    </div>
    <div id="parentRosterBackBtn" data-position="fixed"  data-theme="b" data-role="footer" style="display: none;" >
        <div data-role="navbar">
            <ul>
                <li><a onclick="location.reload()" data-transition="slideup"  href="<?php echo base_url('main/dashboard')?>#parentRoster"  data-icon="back">Back</a></li>
                                
            </ul>
        </div>

    </div> 
</div>

<script type="text/javascript">
    function getIndividualRecords(id)
    {
        var url = '<?php echo base_url('registrar/viewDetails') ?>/'+id;
        $.ajax({
                   type: "GET",
                   url: url,
                   data: "id="+id, // serializes the form's elements.
                   success: function(data)
                   {
                      $('#parentRosterBackBtn').show();
                      $('#studentInfo').html(data);
                   }
                 });
    }

</script>







<script type="text/javascript">

$('body').bind("swiperight", function(e){
              window.history.back()
     })
     $('body').bind("swipeleft", function(e){
              window.history.go('#parentFinance')
     })
    
</script>