<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header" style="margin:0">Human Resource Management</h3>
    </div>
</div>
<div class="col-lg-12">
        <ul class="nav nav-tabs" role="tablist" id="hrm_tab">
            <li class="active"><a href="#dp"><i class="fa fa-institution fa-fw"></i>Departments & Position</a></li>
            <li><a  href="#pds"><i class="fa fa-gear fa-fw"></i>HR Settings</a></li>
        </ul>
    <div class="tab-content col-lg-12 no-padding">
        <div style="padding-top: 15px;" class="tab-pane active" id="dp">
            <?php
                $hrdb = Modules::load('hr/hrdbprocess/');
                $hrdb->getListOfDepartmentsPositions();
            ?>
        </div>

        <div style="padding-top: 15px;" class="tab-pane" id="pds">
            <?php
                $hrdb->getPaymentSchedule();
            ?>
        </div>
        
    </div>
        
</div>

<script type="text/javascript">
    
    $(document).ready(function(){
        $('#hrm_tab a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
      })
    })
</script>