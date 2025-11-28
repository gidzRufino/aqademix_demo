<?php echo Modules::run('mobile/html_header');?>
<div data-role="page" id="parentRoster" class="no-padding">
    <div data-role="content"  class="no-padding">
        <?php
        $children = explode(',', $child_links);
    ?>
        <div class="full-height" id="studentInfo"  style="padding-top:10px;">
            <?php 
                foreach($children as $child):
                    $isEnrolled = Modules::run('registrar/isEnrolled', $child, $this->session->userdata('school_year'));
                    if(!$isEnrolled):
                        $school_year = $this->session->userdata('school_year')-1;
                    endif;
                    $student = Modules::run('registrar/getSingleStudent', $child, $school_year);
                    $adviser = Modules::run('academic/getAdvisory',NULL, $school_year, $student->section_id);
                    $present = Modules::run('attendance/getIndividualMonthlyAttendance',$student->st_id, date('m'), date('Y'));
                ?>
            <a href="#" onclick="getIndividualRecords('<?php echo base64_encode($child) ?>')">
                    <div class='col-xs-12 panel mobile-panel-name pointer' style="padding:5px;">
                        <div class='panel-heading no-padding'>
                            <div class="col-xs-3 no-padding" style=" margin:0 auto;">
                                 <img class="img-circle" style="width:100%;" src="<?php echo base_url('uploads/'.$student->avatar) ?> " />
                            </div>
                            <div class="col-xs-8">
                                <h4 style="margin:5px 0 5px"><?php echo strtoupper($student->firstname.' '. $student->lastname) ?></h4>
                                <h5>Present / Total Days : </h5>
                                <h3 class="no-margin"><?php echo $present ?>/<?php echo $totalDays ?></h3>
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

