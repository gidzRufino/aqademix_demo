<div class="col-lg-6" id="finance_1">
    <?php echo Modules::run('finance/financeCharges', $course_id, 1, $school_year, $sem); ?>
</div>
<div class="col-lg-6" id="finance_2">
    <?php echo Modules::run('finance/financeCharges', $course_id, 2, $school_year, $sem); ?>
</div>
<div class="col-lg-6" id="finance_3">
   <?php echo Modules::run('finance/financeCharges', $course_id, 3, $school_year, $sem); ?>
</div>
<div class="col-lg-6" id="finance_4">
    <?php echo Modules::run('finance/financeCharges', $course_id, 4, $school_year, $sem); ?>
</div>