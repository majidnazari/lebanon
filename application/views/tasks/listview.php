<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link media="all" href="<?=base_url()?>css/company-print.css" rel="stylesheet" />
<title><?=$title?> </title>
</head>

<body>  <?php /* var_dump($query); die();*/ ?>
	<div class="container" style="width:1380px !important;">
    	<div class="header" style="width:1380px !important;"><img src="<?=base_url()?>img/company-header.jpg" style="width:920px !important;" />
        </div>
    	<div class="clear"></div>
        <h3 style="text-align: center !important;"><?=$list_id.' - '.ucfirst($status)?></h3>
        <table  style="width:1380px !important; direction:rtl !important" class="tablelist">
        <tr>
        	<th>رقم</th>
            <th>Code</th>
            <th style="width: 150px !important">الشركة</th>
            <th>المسؤول</th>
            <th>النشاط</th>
            <th style="width: 100px !important">المنطقة</th>
            <th>الشارع</th>
            <th>هاتف</th>
            <th>واتساپ</th>
            <th>المندوب</th>
            <th>الموزع</th>
            <th>عدد انترنت</th>
            <th>معلن</th>
            <th style="width: 100px !important">ads start date </th>
            <th style="width: 100px !important">ads end date </th> 
            
            <th >show item</th> 
            
            <th style="width: 100px !important">  item start_date </th>
            <th style="width: 100px !important"> item end_date </th> 
           <!-- <th>حاجز نسخة</th> -->
           <!--  <th>عدد دليل</th> -->          
          
           <!-- <th style="width: 100px !important">صفحات عربي</th> -->
           <!-- <th style="width: 100px !important">صفحات إنجليزي</th> -->
            <!--  <th style="width: 100px !important">إسم المستلم</th> -->
             <th style="width: 75px !important">التاريخ</th>
             <th style="width: 150px !important">ملاحظات</th>
        </tr>
        <?php  
		$i=1;
		foreach($query as $row){
            $status=$row->show_status=="active" ? "YES" : "NO";
			if($row->is_exporter==1){
					$exporter='نعم';
				}
				else{
					$exporter='كلا';
					}
				if($row->is_adv==1){
					//$is_adv='نعم';
					$is_adv='YES';
				}
				else{
					//$is_adv='كلا';
					$is_adv='NO';
					}	
					if($row->copy_res==1){
					//$copy_res='نعم';
					$copy_res='YES';
				}
				else{
					//$copy_res='كلا';
					$copy_res='NO';
					}	
	$phone=explode('-',$row->phone);

			?>
        	<tr class="row" align="center">
        	     <td><?=$i?></td>
                    <td><?=$row->id?></td>
                    <td><?=$row->name_ar?></td>
                    <td><?=$row->owner_name?></td>
                    <td><?=$row->activity_ar?></td>
                    <td><?=$row->area_ar?></td>
                    <td><?=$row->street_ar?></td>
                    <td style="width: 150px !important"><?=@$phone[0]?></td>
                    <td style="width: 150px !important"><?=$row->whatsapp?></td>
                    <td><?=$row->sales_man_ar?></td>
                    <td><?=$row->csales_man_ar?></td>
                    <td align="center"><?=(($row->CNbr*2)+4)?></td>
                    <td align="center"><?=$is_adv?></td>
                    <td style="width: 150px !important"><?=$row->start_date_adv ?></td>
                    <td style="width: 150px !important"><?=$row->end_date_adv ?></td>

                    <td ><?=$status ?></td>

                    <td style="width: 150px !important"><?=$row->show_start_date ?></td>
                    <td style="width: 150px !important"><?=$row->show_end_date ?></td>
                   <!-- <td align="center"><?=$copy_res?></td> -->
                    <!-- <td align="center"><?=(($row->CNbr*2)+1)?></td>   -->
                 
                  <!--  <td><?=$row->guide_pages_ar?></td> -->
                  <!--  <td><?=$row->guide_pages_en?></td> -->

                 

                  <!--  <td><?=$row->receiver_name?></td> -->
                    <td><?=$row->delivery_date?></td>
                    <td><?=$row->personal_notes?></td>
        	</tr>
           <?php 
		   $i++;
		   } ?> 
            </table>
    </div>
    <div class="break"></div>
</body>
</html>