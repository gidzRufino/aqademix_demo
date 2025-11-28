<?php
    //$i =4;
    foreach ($getQuarterSettings as $gq){
       
        switch ($gq->quarter_id){
            case 1:
                $fromFirst = $gq->from_date;
                $toFirst = $gq->to_date;
               
            default;
            case 2:
                $fromSecond = $gq->from_date;
                $toSecond = $gq->to_date;
            default;
            case 3:
                $fromThird = $gq->from_date;
                $toThird = $gq->to_date;
            default;
            case 4:
                $fromFourth = $gq->from_date;
                $toFourth = $gq->to_date;
            default;
             
        }
    }
?>

<div class="col-lg-6">
  <h5>First Quarter</h5>
  <div class="control-group">
    <div class="controls">
          <label class="control-label" for="inputSSS">Start of First Quarter:</label>
          <input onblur="saveDate(event, this.value, 'from_date',1);" value="<?php echo $fromFirst ?>" name="fromFirstQuarter" type="text" data-date-format="mm-dd-yyyy" id="from1Quarter" placeholder="Start of First Quarter" required>
      </div>
    <div class="controls">
        <label class="control-label" for="inputSSS">End of First Quarter:</label>
          <input  value="<?php echo $toFirst ?>" name="toFirstQuarter" type="text" data-date-format="mm-dd-yyyy" id="to1Quarter" placeholder="End of First Quarter" required>
      </div>
  </div>  
  <h5>Second Quarter</h5>
  <div class="control-group">
    <div class="controls">
          <label class="control-label" for="inputSSS">Start of Second Quarter:</label>
          <input  value="<?php echo $fromSecond ?>" name="fromSecondQuarter" type="text" data-date-format="mm-dd-yyyy" id="from2Quarter" placeholder="Start of Second Quarter" required>
      </div>
    <div class="controls">
        <label class="control-label" for="inputSSS">End of Second Quarter:</label>
        <input value="<?php echo $toSecond ?>" name="toSecondQuarter" type="text" data-date-format="mm-dd-yyyy" id="to2Quarter" placeholder="End of Second Quarter" required>
      </div>
  </div>  
</div>
<div class="col-lg-6">
  <h5>Third Quarter</h5>
  <div class="control-group">
    <div class="controls">
          <label class="control-label" for="inputSSS">Start of Third Quarter:</label>
          <input value="<?php echo $fromThird ?>" name="fromThirdQuarter" type="text" data-date-format="mm-dd-yyyy" id="from3Quarter" placeholder="Start of Third Quarter" required>
      </div>
    <div class="controls">
        <label class="control-label" for="inputSSS">End of Third Quarter:</label>
          <input  value="<?php echo $toThird ?>" name="toThirdQuarter" type="text" data-date-format="mm-dd-yyyy" id="to3Quarter" placeholder="End of Third Quarter" required>
      </div>
  </div>  
  <h5>Fourth Quarter</h5>
  <div class="control-group">
    <div class="controls">
          <label class="control-label" for="inputSSS">Start of Fourth Quarter:</label>
          <input value="<?php echo $fromFourth ?>"  name="fromFourthQuarter" type="text" data-date-format="mm-dd-yyyy" id="from4Quarter" placeholder="Start of Fourth Quarter" required>
      </div>
    <div class="controls">
        <label class="control-label" for="inputSSS">End of Fourth Quarter:</label>
        <input name="toFourthQuarter" type="text"  value="<?php echo $toFourth ?>"  data-date-format="mm-dd-yyyy" id="to4Quarter" placeholder="End of Fourth Quarter" required>
      </div>
  </div>  
</div>

<script type="text/javascript">
    $(document).ready(function() {
       $('#from1Quarter').datepicker(); 
       $('#to1Quarter').datepicker(); 
       $('#from2Quarter').datepicker(); 
       $('#to2Quarter').datepicker(); 
       $('#from3Quarter').datepicker(); 
       $('#to3Quarter').datepicker(); 
       $('#from4Quarter').datepicker(); 
       $('#to4Quarter').datepicker(); 
    });
    
   function saveGrading()
   {
       var i = 1;
       
       for(i=1; i<=4; i++)
           {
               saveDate(i, 'from_date', $('#from'+i+'Quarter').val());
               saveDate(i, 'to_date', $('#to'+i+'Quarter').val());
           }
   }
   
   function saveDate(pk_value, column, value )
   {
           var table = 'esk_settings_quarter';
           var pk = 'quarter_id'; 
           var url = "<?php echo base_url().'main/singleColumnEdit/'?>"+table+"/"+column+"/"+value+"/"+pk+"/"+pk_value// the script where you handle the form input.

            $.ajax({
                   type: "POST",
                   url: url,
                   data: 'pk='+pk+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                        $('#qnotify').removeClass('hide')
                        $('#qnotify h4').html('Grading Period Saved Successfully!');
                        $('#qnotify').fadeOut(2000);
                   }
                 });

            return false;
           
      
   }
</script> 