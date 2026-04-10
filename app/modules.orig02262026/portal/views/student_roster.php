<?php
    foreach($students AS $s):
        $person = Modules::run('portal/fetchStudentLevel', $s);
        $data = $person['check'];
        ?>
        <div>
            <a href="<?php echo site_url('portal/student/').base64_encode($s); ?>" class="text-dark">
                <div class="card mb-3">
                    <img class="card-img-top" src="<?php echo site_url('uploads/').$data->avatar; ?>" auto" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo Modules::run('main/compileName', $data); ?></h5>
                        <span class="card-text"><?php echo $person['level']; ?> | GA: 87%</span>
                        <p class="card-text text-right"><small class="text-muted">Last updated 3 mins ago</small></p>
                    </div>
                </div>
            </a>
        </div>
<?php
    endforeach;
?>
