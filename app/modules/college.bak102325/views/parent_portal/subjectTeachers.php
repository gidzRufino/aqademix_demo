<?php
    $children = explode(',', $child_links);
    switch (count($children)):
        case 1:
            $width = '25%';
            $col = 'col-lg-12';
        break;
        case 2:
            $width = '100%';
            $col = 'col-lg-6';
        break;
        case 3:
            $width = '100%';
            $col = 'col-lg-6';
        break;
        default :
            $width = '100%';
            $col = 'col-lg-3';
        break;
    endswitch;
?>
<div class="row">
    <div class="col-lg-12">
        <h3 style="margin-top: 20px;" class="page-header">
            <a href="<?php echo base_url() ?>"><i class="fa fa-home"></i></a> | Subject Teachers
            <small onclick="logout()" class="pull-right pointer" style="margin-top:10px;"><?php echo $this->eskwela->getSet()->set_school_name;?></small>
            <input type="hidden" id="parent_id" value="<?php echo $this->session->userdata('parent_id') ?>" />
        </h3>
    </div>
</div>
<div class="col-lg-12">
    <div style="width: <?php echo $width ?>; margin:0 auto">
        <?php 
        
        foreach($children as $child):
            $isEnrolled = Modules::run('registrar/isEnrolled', $child, $this->session->userdata('school_year'));
            if(!$isEnrolled):
                $school_year = $this->session->userdata('school_year')-1;
            endif;
            $student = Modules::run('registrar/getSingleStudent', $child, $school_year);
            $assignment = Modules::run('academic/getAssignmentByLevel', $student->section_id, $student->grade_id, $school_year); 
            
    ?>
            <div class="<?php echo $col ?> pointer">
                <div class="panel panel-primary">
                    <div class="panel-header">
                        <h6 class="text-center"><?php echo $student->level ?> - <?php echo $student->section ?></h6>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped" style="font-size:12px;">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Subject</th>
                                <th>Grade Level</th>
                                <th>Section</th>
                            </tr>
                            <tbody id="subjectsAssignedTable">
                                <?php
                                $i = 1;
                                //print_r($assignment);
                                foreach ($assignment->result() as $as): ?>
                                <tr id="as_<?php echo $as->ass_id ?>">
                                    <td><?php echo $i++ ?></td>
                                    <td><?php echo $as->firstname.' '.$as->lastname ?></td>
                                    <td><?php echo $as->subject ?></td>
                                    <td><?php echo $as->level ?></td>
                                    <td><?php echo $as->section ?></td>

                                </tr>
                                <?php endforeach; ?> 
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
    <?php
        endforeach;
    ?>
    </div>
</div>


<script type="text/javascript">

</script>