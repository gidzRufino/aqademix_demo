<?php $nsList = Modules::run('main/getTypeList'); ?>
<div class="col-md-12">
    <select>
        <option>Select Notification Type</option>
        <?php foreach ($nsList as $n): ?>
            <option onclick="getSubListByType('<?php echo $n->type_id ?>')" value="<?php echo $n->type_id ?>"><?php echo $n->type ?></option>
        <?php endforeach; ?>
    </select>
</div>
<hr/>

<div id="notifySubList" class="col-md-8">

</div>

<div id="addSubsNotifList" class="modal fade" role="dialog" style="width: 40%; margin: 5% 0 0 30%">
    <div class="panel panel-primary">
        <div class="panel-heading">
            ADD Subscriber to notification
            <i class="fa fa-times-circle pull-right fa-2x" style="cursor: pointer;" onclick="$('#addSubsNotifList').modal('hide')"></i>
        </div>
        <div class="panel panel-body">
            <div class="row">
                <div class="col-md-6">
                    <select id="notifSelected">
                        <option value="0">Select Notification Type</option>
                        <?php foreach ($nsList as $l): ?>
                            <option value="<?php echo $l->type_id ?>"><?php echo $l->type ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <div class="controls">
                        <input autocomplete="off"  class="form-control" onkeydown="searchTeacher(this.value)"  name="searchTeacher" type="text" id="searchTeacher" placeholder="Search Teacher's Family Name" required>
                        <input type="hidden" id="teacher_id" name="teacher_id" value="0" />
                    </div>
                </div>
                <div class="col-md-12">                    
                    <div id="empList">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>