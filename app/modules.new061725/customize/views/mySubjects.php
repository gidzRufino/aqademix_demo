<?php
$position_id = $this->session->userdata('position_id');
switch ($position_id) {
    case '33':
        $admin = "display:none;";
        break;
}
?>
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header" style="margin:0">My Subjects</h2>
    </div>
    <div class="col-lg-12" style="margin-top:20px;">
        <?php
        if ($this->session->userdata('is_adviser')) {
            $advisory = Modules::run('academic/getAdvisory', $this->session->userdata('username'), $this->session->userdata('school_year'));
            ?>
            <h4 style="line-height: 10px;" class="selectTableRow" >Advisory Class:&nbsp;<br/><br/><ol style="margin-right: 50px">
                    <?php for ($ad = 0; $ad < $advisory->num_rows(); $ad++) { ?>
                    <li><a href="<?php echo base_url(); ?>academic/getStudentBySubject/<?php echo $advisory->row($ad)->grade_id; ?>/<?php echo $advisory->row($ad)->section_id; ?>">
                                <span style="color:#BB0000;">
                                    <?php echo $advisory->row($ad)->level; ?>&nbsp;[&nbsp;<?php echo $advisory->row($ad)->section; ?>&nbsp;]
                                </span>
                            </a></li>
                    <?php } ?>
    <!-- <a href="<?php echo base_url(); ?>academic/getStudentBySubject/<?php echo $advisory->row()->grade_id; ?>/<?php echo $advisory->row()->section_id; ?>" >
        <span style="color:#BB0000;">
                    <?php echo $advisory->row()->level; ?>&nbsp;[&nbsp;<?php echo $advisory->row()->section; ?>&nbsp;]
        </span>
    </a>  -->
                </ol></h4>
        <?php } else { ?>
            <h4 style="line-height: 10px;" class="selectTableRow" >Advisory Class:&nbsp;<span style="color:#BB0000;">NONE</span></h4>
        <?php } ?>    
    </div>
    <div class="col-lg-12" style="margin-top:20px;">
        <h4 style="color:black;">Subjects Taught:</h4>
        <ol>
            <?php
            foreach ($getAssignment as $ga) {
                ?>
                <li><h4><a href="<?php echo base_url(); ?>academic/getStudentBySubject/<?php echo $ga->grade_id; ?>/<?php echo $ga->section_id; ?>/<?php echo $ga->subject_id; ?>/<?php echo $ga->specs_id; ?>">
                            <span style="color:#BB0000;">
                                <?php
                                if ($ga->specs_id == 0):
                                    echo $ga->subject;
                                    ?>&nbsp;-&nbsp;<?php echo $ga->level; ?>&nbsp;[&nbsp;<?php echo $ga->section; ?>&nbsp;]
                                    <?php
                                else:
                                    echo $ga->specialization;
                                    ?>&nbsp;-&nbsp;<?php echo $ga->level; ?>
                                <?php endif; ?>
                            </span>  
                        </a>
                    </h4></li>        

            <?php } ?>
        </ol>   
    </div>



</div>

<input type="hidden" id="setSection"/>
<script type="text/javascript">

    function selectSection() {
        document.getElementById('setSection').value = 'selectSection'
        var level = document.getElementById("inputGrade").value

        sectionAction(level)
    }

    function setAssignment()
    {
        var data = new Array();
        data[0] = document.getElementById("inputTeacher").value;
        data[1] = document.getElementById("inputSubject").value;
        data[2] = document.getElementById("inputGrade").value;
        data[3] = document.getElementById("inputSection").value;

        saveRequest(data)
    }


    $(document).ready(function () {
        $("#inputTeacher").select2();
        $("#inputSubject").select2();
        $("#inputGrade").select2();
        $("#inputSection").select2();
    });
</script>
