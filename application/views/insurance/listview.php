<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link media="all" href="<?=base_url()?>css/company-print.css" rel="stylesheet" />
<title><?=$title?> </title>
</head>

<body>
	<div class="container">
	    <div class="header"><img src="<?=base_url()?>img/header-insurance.jpg" width="100%" /></div>
    	<div class="clear"></div>
        <table style="width:920px !important; direction:rtl !important" class="tablelist">
        <tr>
        	<th>رقم</th>
            <th>Code</th>
            <th>الشركة</th>
            <th>المحافظة</th>
            <th>القضاء</th>
            <th>المنطقة</th>
            <th>الشارع</th>
            <th>هاتف</th>
            <th>معلن</th>
            <th width="300px">ملاحظات</th>
        </tr>
        <?php 
		$i=1;
		foreach($query as $row){
				$governorates=$this->Address->GetGovernorateById($row->governorate_id);
				$districts=$this->Address->GetDistrictById($row->district_id);
				$area=$this->Address->GetAreaById($row->area_id);
			
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
                <td><?=$governorates['label_ar'];?></td>
                <td><?=$districts['label_ar'];?></td>
                <td><?=$area['label_ar'];?></td>
                <td><?=$row->street_ar;?></td>
                <td><?=$row->phone;?></td>
                <td><?=$is_adv?></td>
                <td style="font-size:10px !important"><?=@$row->personal_notes?></td>
        	</tr>
           <?php 
		   $i++;
		   } ?> 
            </table>
    </div>
    <div class="break"></div>
</body>
</html>