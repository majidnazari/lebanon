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
$all_companies=$this->Company->SearchCompanies('', '', '', '', '', '', '', $area_id, 0, 0,FALSE,FALSE,FALSE);
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
        <h4 style="direction: rtl">عدد اجمالي المؤسسات الصناعية في منطقة <?=$area_name['label_ar']?> : <?=count($all_companies)?>
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
            <th style="text-align:center"  width="15%">ID#</th>
            <th style="text-align:center"  width="15%">اسم الشركة</th>
            <th style="text-align:center"  width="15%">المندوب </th>
            <th style="text-align:center"  width="15%">المحافظة </th>
            <th style="text-align:center"  width="15%">القضاء </th>
            <th style="text-align:center"  width="15%">المنطقة </th>
            <th style="text-align:center" width="15%">Status </th>
            <th style="text-align:center" width="10%">ACC. Done</th>
            <th style="width: 200px !important">ملاحظات</th>
        </tr>
        <?php 
		$i=1;
		foreach($query as $row){
			?>
        	<tr class="row">
            	<td style="text-align: center">&nbsp;<?=$i?>&nbsp;</td>
            	<td style="text-align: center">&nbsp;<?=$row->company_id?>&nbsp;</td>
                <td style="text-align:center"><?=$row->company_ar?></td>
                <td style="text-align:center"><?=$row->salesman?></td>
                <td style="text-align:center"><?=$row->governorate_ar?></td>
                <td style="text-align:center"><?=$row->district_ar?></td>
                <td style="text-align:center"><?=$row->area_ar?></td>
                <td style="text-align:center"><?=$row->status?></td>
                <td style="text-align:center"><?=$row->payment_status?></td>
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