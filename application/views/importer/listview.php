<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link media="all" href="<?=base_url()?>css/company-print.css" rel="stylesheet" />
<title><?=$title?> </title>
</head>

<body>
	<div class="container">
        <div class="header"><img src="<?=base_url()?>img/header-importers.jpg" width="100%" /></div>
    	<div class="clear"></div>
        <table style="width:920px !important; direction:rtl !important" class="tablelist">
        <tr>
        	<th>رقم</th>
            <th>Code</th>
            <th>الشركة</th>
            <th>المسؤول</th>
            <th>المحافظة</th>
            <th>القضاء</th>
            <th>المنطقة</th>
            <th>الشارع</th>
            <th>هاتف</th>
            <th>فاكس</th>
            <th>التصدير</th>
            <th>معلن</th>
            <th>ملاحظات</th>
        </tr>
        <?php 
		$i=1;
		foreach($query as $row){


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
                <td><?=$row->owner_ar;?></td>
                <td><?=$row->governorate_ar;?></td>
                <td><?=$row->district_ar;?></td>
                <td><?=$row->area_ar;?></td>
                <td><?=$row->street_ar;?></td>
                <td><?=$row->phone;?></td>
                <td><?=$row->fax;?></td>
                <td><?=$is_adv?></td>
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