<?php

/**
 * @Author: IanJayBronola
 * @Date:   2019-02-07 16:36:20
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-08 16:52:56
 */

	


	$prepped = prep_data($dataset, $xAxis, $labelField, $sumField, $chartType);




?>
<canvas id="<?= $chartId ?>"></canvas>

<script>
var ctx = document.getElementById("<?= $chartId ?>").getContext('2d');
var myChart = new Chart(ctx, {
    type: "<?= $chartType ?>",
    data: {
        labels: <?= json_encode($prepped['xAxis']) ?>,
        datasets : <?= json_encode($prepped['data']) ?>
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
