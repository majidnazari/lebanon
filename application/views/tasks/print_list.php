<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link media="all" href="<?=base_url()?>css/company-print.css" rel="stylesheet" />
<title><?=$title?> </title>
</head>

<body>
	<div class="container" style="width:1380px !important;">
    	<div class="header" style="width:1380px !important;">
    	    <img src="<?=base_url()?>img/company-header.jpg" style="width:1380px !important; height:200px !important" />
        	<!--<div class="col-left">
            	<h3 class="english-h3">THE DIRECTORY OF EXPORTS & INDUSTRIAL FIRMS IN LEBANON</h3>
                <h4 class="english-h4">Field Survey Project</h4>
                <h5 class="english-h5">Data Form of Industrial Establishment</h5>
            </div>
            <div class="logo">
            	<img src="<?=base_url()?>img/logo.png" />
                <h4>
				                بالتعاون <br />مع جمعية الصناعيين في لبنان
            	<br />(Association of Lebanese Industrialists)
                </h4>
            </div>
            <div class="col-right">
            	<h3 class="arabic-h3">دليل الصادرات والمؤسسات الصناعية اللبنانية</h3>
                <h4 class="arabic-h4">مشروع المسح الميداني</h4>
                <h5 class="arabic-h5">بيانات مؤسسة صناعية</h5>
            </div>-->
        </div>
    	<div class="clear"></div>
        <h3 style="text-align: center !important;"><?=$query['results'][0]->employer_ar.'<br>Lists - '.ucfirst($status).'/'.ucfirst($query['results'][0]->category)?></h3>
        <table style="width:1380px !important; direction:rtl !important" class="tablelist">
             <tr>
        	<th>رقم</th>
            <th>Code</th>
            <th style="width: 150px !important">الشركة</th>
            <th>المسؤول</th>
            <th>النشاط</th>
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
             <th style="width: 100px !important">إسم المستلم</th>
             <th style="width: 75px !important">التاريخ</th>
            <th style="width: 150px !important">ملاحظات</th>
        </tr>
       
        <?php 
		$i=1;
	
		foreach($query['results'] as $row){

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
	$phone=explode('-',$row->phone);
			?>
        	<tr>
                    <td><?=$i?></td>
                    <td><?=$row->company_id?></td>
                    <td><?=$row->company_ar?></td>
                    <td><?=$row->owner_name?></td>
                    <td><?=$row->activity_ar?></td>
                    <td><?=$row->area_ar?></td>
                    <td><?=$row->street_ar?></td>
                    <td><?=@$phone[0]?></td>
                    <td><?=$row->sales_man_ar?></td>
                    <td align="center"><?=$is_adv?></td>
                    <td align="center"><?=$copy_res?></td>
                    <td align="center"><?=(($row->CNbr*2)+1)?></td>
                    <td align="center"><?=(($row->CNbr*2)+4)?></td>
                    <td><?=$row->guide_pages_ar?></td>
                    <td><?=$row->guide_pages_en?></td>
                    <td><?=$row->receiver_name?></td>
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