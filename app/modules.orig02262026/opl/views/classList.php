<section class="card card-outline card-primary shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Student Directory</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-striped align-middle mb-0 table-bordered">
            <thead class="thead-light">
                <tr>
                    <th class="text-center" style="width: 40px;">#</th>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Emergency Contact</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($students as $student):
                    $address = ucwords(strtolower(
                        ($student->street ? $student->street . ', ' : '') .
                            $student->barangay . ', ' .
                            $student->mun_city . ' ' .
                            $student->province
                    ));
                ?>
                    <tr>
                        <td class="text-center"><?php echo $i++; ?></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <!-- <img class="rounded-circle border" width="30" height="30"
                                    src="<?php echo base_url('uploads/' . ($student->avatar ?? 'default.png')); ?>"
                                    alt="Avatar"
                                    onerror="this.onerror=null;this.src='<?php // echo base_url('uploads/default.png'); 
                                                                            ?>';"> -->
                                <span><?php echo $student->st_id; ?></span>
                            </div>
                        </td>
                        <td><?php echo htmlspecialchars($student->lastname . ', ' . $student->firstname); ?></td>
                        <td>
                            <span title="<?php echo htmlspecialchars($address); ?>" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; max-width: 250px;">
                                <?php echo htmlspecialchars($address); ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($student->ice_contact); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>