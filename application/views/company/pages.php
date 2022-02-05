<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link media="all" href="<?=base_url()?>css/company-print.css" rel="stylesheet" />
<title><?=$title?> </title>
</head>

<body>
	<div class="container">
    	<div class="header"><img src="<?=base_url()?>img/company-header.jpg" style="width:920px !important;" />
        </div>
    	<div class="clear"></div>
        <h3 style="text-align: center !important;"><?=$query['name_ar'].' - '.$query['company_id']?></h3>
        <table style="width:920px !important; direction:rtl !important" class="tablelist">
        <tr>
            <th style="width:50%; text-align:center"><?=$query['name_ar']?></th>
            <th style="width:50%; text-align:center"><?=$query['name_en']?></th>
        
        </tr>
        <?php 
		$ar_pages=explode(',',$query['guide_pages_ar']);
		$en_pages=explode(',',$query['guide_pages_en']);
		if(count($ar_pages)>count($en_pages))
		{
		    $lenght=count($ar_pages);
		}
		elseif(count($ar_pages)<=count($en_pages)){
		    $lenght=count($en_pages);
		}
		for($i=0;$i<$lenght;$i++)
		{
		    echo '<tr><td style="width:50%; text-align:center">'.@$ar_pages[$i].'</td><td style="width:50%; text-align:center">'.@$en_pages[$i].'</td></tr>';
		
		   } ?> 
            </table>
    </div>
    <div class="break"></div>
</body>
</html>