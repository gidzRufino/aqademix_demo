
<div class="row-fluid"  id="pagination-table" >
    <div class="col-lg-6">
        <?php
        echo $links;
        ?>
    </div>
    <div class="form-group col-lg-4 pull-right" id='searchBox' style="margin:20px 0;">
        <div class="controls">
            <input autocomplete="off"  class="form-control" onkeypress="if (event.keyCode==13) searchTeacher(this.value)"  name="searchTeacher" type="text" id="searchTeacher" placeholder="Search Teacher's Family Name" required>
            <input type="hidden" id="teacher_id" name="teacher_id" value="0" />
        </div>
        <div style="min-height: 30px; background: #FFF; width:230px; position:absolute; z-index: 2000; display: none;" class="resultOverflow" id="teacherSearch">

        </div>
    </div>
    <table style="font-size: 12px;" class="table table-striped table-bordered">
        <tr>
            <td></td>
            <td>USER ID</td>
            <td>LAST NAME</td>
            <td>FIRST NAME</td>
            <td>MIDDLE NAME</td>
            <td>POSITION</td>
            <td>STATUS</td>
            <?php if ($this->session->userdata('is_admin') && $this->session->position != "Cashier"): ?>
                <td>PW</td>
                <td>Action</td>
            <?php endif; ?>
        </tr>

        <tbody  id="tableDetails">
            <?php
            //print_r($employee);
            foreach ($employee as $s) {
                //echo $s->isActive;
                ?>


                <tr>
                    <!-- <td style="width:60px; text-align: center;"><img class="img-circle" style="width:50px;" src="<?php// echo base_url() . 'uploads/' . ($s->avatar == "" ? 'noImage.png' : $s->avatar) ?>" /></td> -->
                    <td style="width:60px; text-align: center;">
                        <?php if($s->avatar != ''): 
                            if (file_exists('uploads/'.$s->avatar)):
                            ?>
                                <img class="img-circle" style="width:50px;" src="<?php echo base_url().'uploads/'.$s->avatar  ?>" />
                            <?php else: ?>
                                <img class="img-circle" style="width:50px;" src="<?php echo base_url(). 'images/avatar/' . ($s->sex == 'Female' ? 'female.png' : 'male.png')  ?>" />
                            <?php endif; ?>
                        <?php else: ?>
                            <img class="img-circle" style="width:50px;" src="<?php echo base_url(). 'images/avatar/' . ($s->sex == 'Female' ? 'female.png' : 'male.png')  ?>" />
                        <?php endif; ?>
                    </td>
                    <td><a href='<?php echo base_url('hr/viewTeacherInfo/' . base64_encode($s->uid)) ?>'><?php echo $s->uid; ?></a></td>
                    <td><?php echo strtoupper($s->lastname); ?></td>
                    <td><?php echo strtoupper($s->firstname); ?></td>
                    <td><?php echo strtoupper($s->middlename); ?></td>
                    <td><?php echo $s->position; ?></td>
                    <td style="text-align: center; padding-top: 10px">
                        <?php if ($s->isActive == 1): ?>
                            <span class="badge badge-pill badge-light nowrap clickover pointer" style="cursor: pointer; background-color: green;" rel="clickover"
                                  data-content="
                                  <?php
                                  $data['eStat'] = $s->isActive;
                                  $data['eid'] = $s->employee_id;
                                  $this->load->view('emStatus', $data)
                                  ?>">
                                <i class="fa fa-check-circle" title="Active"></i>  Active
                            </span>
                        <?php elseif ($s->isActive == 2): ?>
                            <span class="badge badge-pill badge-light nowrap clickover pointer" style="cursor: pointer; background-color: darkorange;" rel="clickover"
                                  data-content="
                                  <?php
                                  $data['eStat'] = $s->isActive;
                                  $data['eid'] = $s->employee_id;
                                  $this->load->view('emStatus', $data)
                                  ?>">
                                <i class="fa fa-exclamation-circle" title="Suspended"></i> Suspended
                            </span>
                        <?php elseif ($s->isActive == 3): ?>
                            <span class="badge badge-pill badge-light nowrap clickover pointer" style="cursor: pointer; background-color: red;" rel="clickover"
                                  data-content="
                                  <?php
                                  $data['eStat'] = $s->isActive;
                                  $data['eid'] = $s->employee_id;
                                  $this->load->view('emStatus', $data)
                                  ?>">
                                <i class="fa fa-times-circle" title="Resigned"></i> Resigned
                            </span>
                        <?php else: ?>
                            <span class="badge badge-pill badge-light nowrap clickover pointer" style="cursor: pointer; background-color: gray;" rel="clickover"
                                  data-content="
                                  <?php
                                  $data['eStat'] = $s->isActive;
                                  $data['eid'] = $s->employee_id;
                                  $this->load->view('emStatus', $data)
                                  ?>">
                                <i class="fa fa-minus-circle" title="Deactivated"></i> Deactivated
                            </span>
                        <?php endif; ?>


                    </td>

                    <?php if ($this->session->userdata('is_admin') && $this->session->position != "Cashier") { ?>
                        <td><?php echo $s->secret_key; ?></td>
                        <td>
                            <?php if ($s->rfid == "" || $s->rfid == "NULL"): ?>
                                <a href="#addId" data-toggle="modal"  onclick="showAddRFIDForm('<?php echo $s->user_id ?>', 'RFID', '<?php echo $s->uid ?>')" >Add RFID</a>
                            <?php else: ?>
                                <a href="#addId" data-toggle="modal"   onclick="showAddRFIDForm('<?php echo $s->user_id ?>', '<?php echo $s->rfid ?>', '<?php echo $s->uid ?>')" >Edit RFID</a>
                            <?php endif; ?>
                            <a href="<?php echo base_url('hr/viewTeacherInfo/' . base64_encode($s->uid)) ?>#dtr">View DTR</a>
                            <a href="#" onclick="deleteEmployee('<?php echo $s->user_id ?>', '<?php echo $s->employee_id ?>')">Delete Employee</a>
                        </td>
                    <?php } ?>
                </tr> 
                <?php
            }
            ?>
        </tbody>
    </table>
</div>