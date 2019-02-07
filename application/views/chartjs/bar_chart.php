<?php

/**
 * @Author: IanJayBronola
 * @Date:   2019-02-07 16:36:20
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-07 16:46:33
 */

?>
<canvas id="<?= $chartId ?>"></canvas>

<script>
var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: "<?= $chartType ?>",
    data: {
        labels: <?= json_encode($labels) ?>,
        // datasets: [{
        //     label: '# of Votes',
        //     data: [12, 19, 3, 5, 2, 3],
        //     fill: "false",
        //     borderColor: [
        //         'rgba(255,99,132,1)',
        //         'rgba(54, 162, 235, 1)',
        //         'rgba(255, 206, 86, 1)',
        //         'rgba(75, 192, 192, 1)',
        //         'rgba(153, 102, 255, 1)',
        //         'rgba(255, 159, 64, 1)'
        //     ],
        //     borderWidth: 2
        // }]

        datasets = <?= json_encode($data) ?>

    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>
