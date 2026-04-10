<?php if($records->num_rows() > 0): ?>
<table class="table table-hover table-sm mb-0 align-middle">
                                                <thead class="table-secondary small text-uppercase">
                                                    <tr>
                                                        <th style="width:5%; text-align: center;"><h6 id="att_total" style="margin:0px;"><?php echo $records->num_rows() ?></h6></th>
                                                        <th>Student Name</th>
                                                        <th class="text-start">
                                                            Remarks
                                                            <button
                                                                class="btn btn-outline-primary btn-sm rounded-pill float-end"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#attendanceRemarkModal"
                                                            >
                                                                <i class="fa fa-plus me-1"></i> Remark
                                                            </button>
                                                        </th>
                                                    </tr>
                                                </thead>

                                                <tbody id="attendanceResult">
                                                    <?php foreach ($records->result() as $row):
                                                        $remarks = Modules::run('attendance/getAttendanceRemark', $row->st_id, $row->date); ?>
                                                        <tr
                                                            id="<?php echo $row->user_id; ?>_tr"
                                                            class="attendance-row"
                                                            onmouseenter="$('#delete_<?php echo $row->user_id ?>').show()"
                                                            onmouseleave="$('#delete_<?php echo $row->user_id ?>').hide()"
                                                        >
                                                            <td class="text-center">
                                                                <input
                                                                    class="form-check-input"
                                                                    type="radio"
                                                                    name="remarksRadio"
                                                                    onclick="getMe('<?php echo $row->st_id; ?>')"
                                                                >
                                                            </td>

                                                            <td class="text-start">
                                                                <a class="fw-semibold text-decoration-none"
                                                                href="<?php echo base_url(); ?>registrar/viewDetails/<?php echo base64_encode($row->st_id) ?>">
                                                                    <?php echo strtoupper($row->lastname . ', ' . $row->firstname); ?>
                                                                </a>
                                                            </td>

                                                            <td class="text-start">
                                                                <span class="badge bg-info-subtle text-dark">
                                                                    <?php echo $remarks->row()->category_name; ?>
                                                                </span>

                                                                <?php if ($remarks->row()->remarks != 0): ?>
                                                                    <small class="d-block text-muted mt-1">
                                                                        Remark by:
                                                                        <a href="<?php echo base_url().'hr/viewTeacherInfo/'.base64_encode($remarks->row()->remarks_from) ?>">
                                                                            <?php echo $remarks->row()->remarks_from; ?>
                                                                        </a>
                                                                    </small>
                                                                <?php endif; ?>

                                                                <i
                                                                    class="fa fa-trash text-danger float-end pointer"
                                                                    style="display:none"
                                                                    id="delete_<?php echo $row->user_id; ?>"
                                                                    onclick="deleteAttendance('<?php echo $row->att_id ?>','<?php echo $row->st_id ?>')"
                                                                    title="Remove attendance"
                                                                ></i>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                            <?php endif; ?>
<script type="text/javascript">
    $('#testClick').clickover({html: true});
</script>