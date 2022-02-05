<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link media="all" href="<?=base_url()?>css/company-print.css" rel="stylesheet" />
<title><?=$title?> </title>
</head>

<body>
	<div class="container" style="width:1380px !important;">
    	<div class="header" style="width:1380px !important;"><img src="<?=base_url()?>img/company-header.jpg" style="width:1380px !important; height: 150px !important;" />
        </div>
    	<div class="clear"></div>
        <h3 style="text-align: center !important;">Sales - <?=$id.' - '.ucfirst($sales['salesman'])?></h3>
        <h4 style="text-align: center !important;"><?=$sales['Areas']?></h4>
        <h4 style="text-align: center !important;"><?=$sales['StartDate'].' | '.$sales['EndDate']?></h4>
        <table style="width:1380px !important; direction:rtl !important" class="tablelist">
        <tr>
            <th>رقم</th>
            <th>Code</th>
            <th style="width: 150px !important">الشركة</th>
            <th>المسؤول</th>
            <th>النشاط</th>
            <th style="width: 100px !important">المحافظة</th>
            <th style="width: 100px !important">القضاء</th>
            <th style="width: 100px !important">المنطقة</th>
            <th>الشارع</th>
            <th>هاتف</th>
            <th>المندوب</th>
            <th>معلن</th>
            <th>حاجز نسخة</th>
            <th>عدد دليل</th>
            <th>عدد انترنت</th>
            <th style="width: 100px !important">صفحات عربي</th>
            <th style="width: 100px !important">صفحات إنجليزي</th>
            <th style="width: 100px !important">حجز نسخة</th>
            <th style="width: 75px !important">حجز اعلان</th>
            <th style="width: 150px !important">ملاحظات</th>

        </tr>
        <?php 
		$i=1;
		foreach($query as $row){

			if($row->is_exporter==1){
					$exporter='نعم';
				}
				else{
					$exporter='كلا';
					}
				if($row->is_adv==1){
					$is_adv='نعم';
				}
				else{
					$is_adv='كلا';
					}	
					if($row->copy_res==1){
					$copy_res='نعم';
				}
				else{
					$copy_res='كلا';
					}
            if($row->CopyReservation==1){
                $CopyReservation='نعم';
            }
            else{
                $CopyReservation='';
            }
            if($row->Advertisment==1){
                $Advertisment='نعم';
            }
            else{
                $Advertisment='';
            }

			?>
        	<tr class="row">
        	     <td><?=$i?></td>
                    <td><?=$row->id?></td>
                    <td><?=$row->name_ar?></td>
                    <td><?=$row->owner_name?></td>
                    <td><?=$row->activity_ar?></td>
                    <td><?=$row->governorate_ar?></td>
                    <td><?=$row->district_ar?></td>
                    <td><?=$row->area_ar?></td>
                    <td><?=$row->street_ar?></td>
                    <td><?=$row->phone?></td>
                    <td><?=$row->salesman?></td>
                    <td align="center"><?=$is_adv?></td>
                    <td align="center"><?=$copy_res?></td>
                    <td align="center"><?=(($row->CNbr*2)+1)?></td>
                    <td align="center"><?=(($row->CNbr*2)+4)?></td>
                    <td><?=$row->guide_pages_ar?></td>
                    <td><?=$row->guide_pages_en?></td>
                    <td><?=$CopyReservation?></td>
                    <td><?=$Advertisment?></td>
                    <td><?=$row->SalesNotes.'<br>'.$row->sales_note.'<br>'.$row->personal_notes?></td>
        	</tr>
           <?php 
		   $i++;
		   } ?> 
            </table>
    </div>
    <div class="break"></div>
</body>
</html>