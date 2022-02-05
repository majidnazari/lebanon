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
        <h3 style="text-align: center !important;"><?=$query[0]->sales_man_ar.'<br> ACC. '.ucfirst($status)?></h3>
        <table style="width:920px !important; direction:rtl !important" class="tablelist">
        <tr>
        	<th>رقم</th>
            <th>Code</th>
            <th>الشركة</th>
            <th>المسؤول</th>
            <th>النشاط</th>
            <th>المنطقة</th>
            <th>الشارع</th>
            <th>هاتف</th>
            <th>معلن</th>
            <th>حاجز نسخة</th>
            <th style="width: 200px !important">ملاحظات</th>
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
					$phone=explode('-',$row->phone);

			?>
        	<tr class="row">
            	<td><?=$i?></td>
                <td><?=$row->company_id?></td>
                <td><?=$row->name_ar;?></td>
                <td><?=$row->owner_name;?></td>
                <td><?=$row->activity_ar;?></td>
                <td><?=$row->area_ar;?></td>
                <td><?=$row->street_ar;?></td>
                <td><?=@$phone[0];?></td>
                <td><?=$is_adv?></td>
                <td><?=$copy_res?></td>
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