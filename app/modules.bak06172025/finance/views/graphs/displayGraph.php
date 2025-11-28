<div id="chart"></div>

<script type="text/javascript">
    $(function () {
        var container = document.getElementById('chart');
        var data1 = [];
        var tr = [];
        data1 = '<?php print_r($data) ?>';


        Flotr.draw(container, [
        { data: data1, label: 'Payment Received' },
        { data: data2, label: 'Collectibles' }
      ], {
        xaxis: {
        //   ticks: [[0, '0'], [1, '1'], [2, '2'], [3, '3'], [4, '4']]
            ticks: tr
        },
        yaxis: {
          min: 0
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
          position: 'se',
          backgroundColor: '#D2E8FF'
        }
      });
    })();