
        <table id="table_present" style="width:100%; padding:0; margin:0;" align="center" class='table table-stripped table-bordered'>
            <tr>
                <td style="width:55%">Name of Student</td>
                <td id="getRemarks" onclick="getRemarks()">Remarks
                    <a href="#"><i  class="fa fa-plus-circle fa-2x clickover pointer pull-right"  ></i></a>
                </td>
            </tr>
            <?php
                $i = 1;
                //print_r($records->result());
                foreach ($records->result() as $row)
                {
                    $remarks = Modules::run('attendance/getAttendanceRemark', $row->rfid, $row->date);
            ?>
             <tr  valign="middle" id="<?php echo $row->rfid ?>_tr">
                <td  onclick="getMe('<?php echo $row->rfid ?>')" id="remarks_<?php echo $row->rfid ?>_td" style="padding:5px 0 5px 5px">
                    <h5><?php echo strtoupper($row->lastname.', '.$row->firstname) ?>
                    </h5>

                </td>

                <td>
                    <strong class="pull-left"><?php echo $remarks->row()->category_name ?></strong>
                    <i onclick="deleteAttendance('<?php echo $row->att_id ?>','<?php echo $row->rfid ?>')" class="fa fa-trash fa-2x pull-right"></i>

                </td>

            </tr>
             <?php
                }
             ?>
        </table>