<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link media="all" href="<?=base_url()?>css/company-print.css" rel="stylesheet" />
<title><?=$title?> </title>
</head>

<body>
<?php
$total_done=0;
$total_pending=0;
$total_tasks=0;
$total_acc_done=0;
foreach($query as $row){

    $total_done=$total_done+$row->done_count;
    $total_pending=$total_pending+$row->pending_count;
    $total_tasks=$total_tasks+$row->all_count;
    $total_acc_done=$total_acc_done+$row->done_acc;
}
?>
	<div class="container">
    	<div class="header"><img src="<?=base_url()?>img/company-header.jpg" width="100%" /></div>
    	<div class="clear"></div>
        <h3 style="text-align: center !important;">Sales Report </h3>
        <h4 style="direction: rtl">عدد اجمالي المؤسسات الصناعية : <?=$total_companies?>
            <br>عدد الاستمارات الموزعة : <?=$total_tasks?>
            <br> المؤسسات الصناعية الممسوحة : <?=$total_done?>
            <br> المؤسسات الصناعية  غير الممسوحة : <?=$total_pending?>
            <br> المؤسسات الصناعية  المغلقة : <?=$closed_companies?>
            <br> المؤسسات الصناعية الغير معروفة : <?=$error_companies?>
            <br> مجموع الاستمارات المدفوعة : <?=$total_acc_done?>
            </h4>

        <table style="width:920px !important; direction:rtl !important" class="tablelist">
        <tr>
            <th></th>
            <th style="text-align:center"  width="15%">Sales Man</th>
            <th style="text-align:center"  width="15%">Lists</th>
            <th style="text-align:center"  width="15%">All </th>
            <th style="text-align:center" width="15%">Pending </th>
            <th style="text-align:center" width="10%">Done</th>
            <th style="text-align:center" width="10%">ACC. Done</th>
            <th style="width: 200px !important">ملاحظات</th>
        </tr>
        <?php 
		$i=1;
		foreach($query as $row){

            $all = $this->Task->GetListTasks('', '', '', '', '', '', $row->salesman_id, date('Y'), '', '', '', '', '','', 0, 0);

			?>
        	<tr class="row">
            	<td style="text-align: center">&nbsp;<?=$i?>&nbsp;</td>
                <td style="text-align:center"><?=$row->salesman?></td>
                <td style="text-align:center"><?=$all['num_results']?></td>
                <td style="text-align:center"><?=$row->all_count?></td>
                <td style="text-align:center"><?=$row->pending_count?></td>
                <td style="text-align:center"><?=$row->done_count?></td>
                <td style="text-align:center"><?=$row->done_acc?></td>
                <td style="width: 200px"></td>
            </tr>
        	</tr>
           <?php 
		   $i++;
		   } ?> 
            </table>
    </div>
    <div class="break"></div>
</body>
</html>