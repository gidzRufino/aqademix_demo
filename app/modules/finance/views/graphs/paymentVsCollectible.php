<div class"row">
  <div  class="col-sm-12 text-center">
    <div class="row">
      <div class="col-md-12">
        <label class="label" style="font-size: 12pt; color: black; padding: 5px;"><b style="color: blue">Collectibles</b> | <b style="color: gray">Monthly Payment Received</b> | <b style="color: green">Total Payment Received</b></label>
        <div id="bar-chart" ></div>
      </div>
      <div class="col-md-6">
        <label class="label" style="font-size: 12pt; color: black; padding: 5px;">Weekly Payment Received</label>
        <div id='chart_area_weekly'></div>
      </div>
      <div class="col-md-6">
        <label class="label" style="font-size: 12pt; color: black; padding: 5px;">Daily Payment Received</label>
        <div id='chart_area_daily'></div>
      </div>
    </div>
  </div><br /><br />
</div>
  <script type="text/javascript">
    $('#profile_tab a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    });
    var data = <?php echo $data1 ?>,
    config = {
      data: data,
      xkey: 'y',
      ykeys: ['a', 'b', 'c'],
      labels: ['Collectibles', 'Monthly Payments Received', 'Total Payments Received'],
      fillOpacity: 1,
      hideHover: 'auto',
      behaveLikeLine: true,
      parseTime: false,
      xLabels: 'month',
      resize: true,
      pointFillColors:['#ffffff'],
      pointStrokeColors: ['black'],
      lineColors:['gray','red', 'blue']
    };
    config.element = 'bar-chart';
    Morris.Line(config);
    
    var weekly = <?php echo $weekly ?>;
    Morris.Area({
        element: 'chart_area_weekly',
        data: weekly,
        xkey: 'a',
        ykeys: ['b'],
        xLabels: 'week',
        labels: ['Weekly Collection']
      });

    var daily = <?php echo $daily ?>;
    Morris.Line({
        element: 'chart_area_daily',
        data: daily,
        xkey: 'd',
        ykeys: ['e'],
        xLabels: 'day',
        labels: ['Daily Collection'],
        xLabelAngle: 45,
        resize: true,
      });
</script>