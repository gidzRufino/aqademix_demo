<section class="card card-blue card-outline">
    <table class="table table-light table-striped">
        <tr>
            <td style="width: 20px; text-align: center;">#</td>
            <td class="col-lg-2">Student ID</td>
            <td class="col-lg-3">Name</td>
            <td class="col-lg-6">Address</td>
            <td>Emergency Contact</td>
        </tr>
        <?php $i=1; foreach ($students as $student): 
            $address = ucwords(strtolower(($student->street!=""?$student->street.', ':"")." ".$student->barangay.', '.$student->mun_city.' '.$student->province));
            ?>
        <tr>
            <td class="text-center"><?php echo $i++; ?></td>
            <td>
               <img class="img-circle" width="30" src="<?php echo base_url() . 'uploads/' . $student->avatar; ?>" alt="User Image">
                <?php echo $student->st_id; ?>
            </td>
            <td><?php echo $student->lastname.', '.$student->firstname; ?></td>
            <td><?php echo $address; ?></td>
            <td><?php echo $student->ice_contact; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</section>