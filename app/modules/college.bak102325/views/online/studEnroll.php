<a stud-name="<?php echo strtolower($s->firstname.' '.$s->lastname); ?>" href="<?php echo base_url('college/enrollment/monitor').'/'.$s->semester.'/'.$s->school_year.'/'.base64_encode($s->st_id).'/'.(isset($s->course)?'':1) ?>" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between">
        <h5 class="mb-1"><?php echo strtoupper($s->firstname.' '.$s->lastname) ?></h5>
    </div>
    <p class="mb-1"><?php echo ucwords(strtolower((isset($s->course)?$s->course:$s->level))) ?></p>
    <small class="text-danger">Enrollment Status: <b><?php echo $status ?></b></small>
</a>

