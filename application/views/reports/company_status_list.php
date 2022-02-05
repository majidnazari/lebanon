<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link media="all" href="<?=base_url()?>css/company-print.css" rel="stylesheet" />
<title><?=$title?> </title>
</head>

<body>
	<div class="container">
    	<div class="header">
        	<div class="col-left">
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
            </div>
        </div>
    	<div class="clear"></div>
        <table style="width:920px !important; direction:rtl !important" class="tablelist">
        <tr>
        	<th>رقم</th>
            <th>Code</th>
            <th>الشركة</th>
            <th>المسؤول</th>
            <th>النشاط</th>
            <th>المحافظة</th>
            <th>القضاء</th>
            <th>المنطقة</th>
            <th>الشارع</th>
           <!-- <th>هاتف</th>
           <th>فاكس</th>
            <th>التصدير</th>-->
            <th>معلن</th>
        	<th>Online</th>
        	<th>مغلق</th>
        	<th>عنوان خطأ</th>
            <th style="width: 200px !important">ملاحظات</th>
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

			?>
        	<tr class="row">
            	<td><?=$i?></td>
                <td><?=$row->id?></td>
                <td><?=$row->name_ar;?></td>
                <td><?=$row->owner_name;?></td>
                <td><?=$row->activity_ar;?></td>
                <td><?=$row->governorate_ar;?></td>
                <td><?=$row->district_ar;?></td>
                <td><?=$row->area_ar;?></td>
                <td><?=$row->street_ar;?></td>
            <!--    <td><?=$row->phone;?></td>
                <td><?=$row->fax;?></td>
                <td><?=$exporter?></td>-->
                <td><?=$is_adv?></td>
                <td><?=(($row->show_online == 1) ? "Online" : "Offline")?></td>
				<td><?=(($row->is_closed == 1) ? "Yes" : "No")?></td>
				<td><?=(($row->error_address == 1) ? "Yes" : "No")?></td>
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