                <?php
                foreach($students AS $stud):
                ?>
                <tr>
                    <td style="width:60px; text-align: center;">
                        <?php if(file_exists('uploads/'.$stud->avatar)): ?>
                            <img class="img-circle" style="width:50px;" src="<?php echo base_url().'uploads/'.$stud->avatar  ?>" />
                        <?php else: ?>
                            <img class="img-circle" style="width:50px;" src="<?php echo base_url().'images/forms/'. strtolower($studettings->set_logo)  ?>" />
                        <?php endif; ?>
                    </td>
                    <td><a href="<?php echo base_url('registrar/viewDetails/'.base64_encode($stud->st_id)) ?>/"><?php echo ($stud->st_id==""?$stud->user_id:$stud->st_id); ?></a></td>
                    <td onclick="document.location='<?php echo base_url('registrar/viewDetails/'.base64_encode($stud->st_id)) ?>/'"><?php echo strtoupper($stud->lastname); ?></td>
                    <td><?php echo strtoupper($stud->firstname); ?></td>
                    <td><?php echo strtoupper($stud->middlename); ?></td>
                    <td><?php echo $stud->level; ?></td>
                    <td><?php echo $stud->section; ?></td>
                    <td><?php echo $stud->sex; ?></td>
                    <td><?php echo $stud->school_year.' - '.($stud->school_year+1) ?></td>
                </tr>
                <?php
                endforeach;
                ?>