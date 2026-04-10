<?php if($this->uri->segment(2)=='classBulletin'): ?>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-4">
                <div class="callout callout-danger b-t-1 b-r-1 b-b-1">
                    <small class="text-muted">Submitted Quizes</small><br>
                    <strong class="h4">10 / 20</strong>
                </div>
            </div><!--/.col-->
            <div class="col-sm-4">
                <div class="callout callout-warning b-t-1 b-r-1 b-b-1">
                    <small class="text-muted">Submitted Assignments</small><br>
                    <strong class="h4">11 / 20</strong>
                </div>
            </div><!--/.col-->
            <div class="col-sm-4">
                <div class="callout callout-success b-t-1 b-r-1 b-b-1">
                    <small class="text-muted">Number of Students Online</small><br>
                    <strong class="h4">12</strong>
                </div>
            </div><!--/.col-->

        </div><!--/.row-->
    </div>
</div>
<?php else: ?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-3">
                <div class="callout callout-info b-t-1 b-r-1 b-b-1">
                    <small class="text-muted">Number of Classes</small><br>
                    <strong class="h4">8</strong>
                </div>
            </div><!--/.col-->
            <div class="col-sm-3">
                <div class="callout callout-danger b-t-1 b-r-1 b-b-1">
                    <small class="text-muted">Submitted Quizes</small><br>
                    <strong class="h4">10 / 20</strong>
                </div>
            </div><!--/.col-->
            <div class="col-sm-3">
                <div class="callout callout-warning b-t-1 b-r-1 b-b-1">
                    <small class="text-muted">Submitted Assignments</small><br>
                    <strong class="h4">11 / 20</strong>
                </div>
            </div><!--/.col-->
            <div class="col-sm-3">
                <div class="callout callout-success b-t-1 b-r-1 b-b-1">
                    <small class="text-muted">Number of Students Online</small><br>
                    <strong class="h4">12</strong>
                </div>
            </div><!--/.col-->

        </div><!--/.row-->
    </div>
</div>

<?php endif; ?>
