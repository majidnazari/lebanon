<script>
    $(document).ready(function () {

        if($("#chart-33").length > 0) {

            var data = [];
<?php
$i = 0;
foreach($monthly_country_visitors as $ivisitor) {
    if((($ivisitor->Views * 100) / $total_monthly_visitors) > 1) {
        ?>
                    data[<?=$i?>] = {label: "<?=$ivisitor->country?>", data: Math.floor(<?=$ivisitor->Views?> * 100) + 1};
        <?php
    }
    $i++;
}
?>

            $.plot($("#chart-33"), data,
                    {
                        series: {
                            pie: {
                                show: true,
                                radius: 150,
                                label: {
                                    show: true,
                                    radius: 0.5, // place in middle of pie slice
                                    formatter: function (label, series) {
                                        var percent = Math.round(series.percent);
                                        return ('&nbsp;<b>' + percent + '%'); // custom format
                                    }
                                }
                            }

                        },
                        legend: {show: true}
                    });
        }
    });
</script>
<div class="block">
    <div id="chart-33" style="height: 300px;">

    </div>
</div>