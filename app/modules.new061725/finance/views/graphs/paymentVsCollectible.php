<h3>Payments Received vs. Collectibles</h3>
<div id="chart"></div>

<script type="text/javascript">
    $(function () {
      var data1 = <?php echo $details ?>;
      var data2 = <?php echo $data2 ?>;
      var tr = <?php echo $tr ?>;
      var mx = '<?php echo $max ?>';

      var 
      container = document.getElementById('chart'),
      x, y, n, m;

      // Draw the line graph
      Flotr.draw(container, [
        { data: data1, label: 'Payment Received' },
        { data: data2, label: 'Collectibles' }
      ], {
        xaxis: {
        //   ticks: [[0, '0'], [1, '1'], [2, '2'], [3, '3'], [4, '4']]
            ticks: tr
        },
        yaxis: {
          min: 0,
          max: mx
        },
        mouse: {
            track: true,
            relative: true
        },
        grid: {
          horizontalLines: true,
          verticalLines: true
        },
        legend: {
          position: 'sw',
          backgroundColor: '#D2E8FF'
        }
      });
    })();
</script>

<style>
    #chart {
        width: 700px;
        height: 400px;
        /* margin: 24px auto; */
    }
</style>