<div class="text-center">
    <img class="img img-circle" style="width: auto" src="<?php echo site_url('uploads/').$details->avatar; ?>">
    <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#academics" role="tab" aria-controls="academics" aria-selected="false">Academics</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="finance-tab" data-toggle="tab" href="#finance" role="tab" aria-controls="finance" aria-selected="false">Finances</a>
        </li>
    </ul>
    <div class="tab-content clearfix" id="myTabContent">
        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="col-md-12 row">
                <div class="col-md-12">
                    <span>Name: <?php echo ucfirst(strtolower($details->firstname)). " ".$details->middlename[0].". ".ucfirst(strtolower($details->lastname)) ?></span>
                </div>
                <div class="col-md-12">
                    <span><?php echo (!empty($details->level)) ? "Grade/Section: ".$details->level." - ".$details->section : "Course/Year: ".$details->short_code." - ".$details->year_level ?></span>
                </div>
                <div class="col-md-12">
                    <span>Birthdate: <?php echo date('F d, Y', strtotime($details->temp_bdate)); ?></span>
                </div>
                <div class="col-md-12">
                    <span>Address: <?php
                    echo Modules::run('main/compileAddress', $details);
                    ?></span>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="academics" role="tabpanel" aria-labelledby="academics-tab">
            <table class="table" style="font-size: 12px">
                <?php
                    $subjects = Modules::run('portal/getGradeSchoolSubjects ', $student_id);
                    if(!empty($subjects)):
                        foreach($subjects AS $sub):
                            $ave = Modules::run('portal/getSubjectTotalAverage', $student_id, $sub->subject_id);
                            ?>
                                <tr>
                                    <td><?php echo $sub->subject; ?></td>
                                    <td><?php echo ($ave<75) ? "<span class='text-danger'>".$ave."%</span>" : "<span class='text-success'>".$ave."%</span>"; ?></td>
                                </tr>
                            <?php
                        endforeach;
                    else:
                        $subjects = Modules::run('portal/getCollegeSubjects', $student_id);
                        foreach($subjects AS $sub):
                            ?>
                                <tr>
                                    <td><?php echo $sub->sub_code; ?></td>
                                    <td></td>
                                </tr>
                    <?php
                        endforeach;
                    endif;
                ?>
            </table>
        </div>
        <div class="tab-pane fade" id="finance" role="tabpanel" aria-labelledby="finance-tab">
            <table class="table" style="font-size: 12px">
                <tr>
                    <td><b>TOTAL CHARGES</b></td>
                    <td colspan="2" class="text-right"><b>&#8369;</b> 22,756.48</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center"><b>PAYMENTS</b></td>
                </tr>
                <tr>
                    <td>September 05, 2018 - ID</td>
                    <td class="text-center"><b>&#8369;</b> 300.00</td>
                </tr>
                <tr>
                    <td>January 07, 2019</td>
                    <td class="text-center"><b>&#8369;</b> 12,000.00</td>
                </tr>
                <tr>
                    <td>March 23, 2019</td>
                    <td class="text-center"><b>&#8369;</b> 8,145.25</td>
                </tr>
                <tr>
                    <td><b>REMAINING BALANCE</b></td>
                    <td class="text-center"><b>&#8369;</b> 2,311.23</td>
                </tr>
            </table>
        </div>
    </div>
</div>
