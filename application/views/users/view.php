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
        <img src="<?=base_url()?>img/company-header.jpg" width="100%" />
        </div>
    	<div class="clear"></div>
        <table class="table-view" style="width:920px !important" style="margin-top:10px !important">
        	
            <tr>
            	<td>
                	<div class="label arabic">تاريخ :</div>
                    <div class="data-box arabic"><?=date('d / m / Y');?>&nbsp;</div>
				<td colspan="4">
                    <div class="label arabic">رقم الاستمارة :</div>
                    <div class="data-box arabic"><?=$query['id'];?>&nbsp;</div>                    
                </td>
            </tr>
            
			<tr>
            	<td colspan="5">
                	<div class="label english">Bank's Name :</div>
                    <div class="data-box english"><?=$query['name_en'];?>&nbsp;</div>
                    <div class="label arabic">إسم المصرف:</div>
                    <div class="data-box arabic"><?=$query['name_ar'];?>&nbsp;</div>                    
                </td>
            </tr>
            <tr>
            	<td>
                	<div class="label english">No. & Place of C.R :</div>
                    <div class="data-box english"><?=$query['commercial_register_en'];?>&nbsp;</div>
				</td>
				<td colspan="2">
                	<div class="label english">Capital:</div>
                    <div class="data-box english"><?=$query['bnk_capital'];?>&nbsp;</div>
				</td>
				<td>
                    <div class="label arabic">رأس المال: </div>
                    <div class="data-box arabic"><?=$query['bnk_capital'];?>&nbsp;</div>                    
                </td>
				<td>
                    <div class="label arabic"> رقم ومحل اصدار السجل التجاري: </div>
                    <div class="data-box arabic"><?=$query['commercial_register_ar'];?>&nbsp;</div>                    
                </td>
				
            </tr>
            <tr>
            	<td colspan="5">
                	<div class="label english">Date Founded:</div>
                    <div class="data-box english"><?=$query['establish_date'];?>&nbsp;</div>
                    <div class="label arabic">تاريخ التأسيس: </div>
                    <div class="data-box arabic"><?=$query['establish_date'];?>&nbsp;</div>                    
                </td>
            </tr>
            <tr>
            	<td colspan="5">
                	<div class="label english">Bank's List:</div>
                    <div class="data-box english"><?=$query['list_number'];?>&nbsp;</div>
                    <div class="label arabic">لائحة المصارف: </div>
                    <div class="data-box arabic"><?=$query['list_number'];?>&nbsp;</div>                    
                </td>
            </tr>
            <tr>
            	<td colspan="5"> 
				<div class="break"></div> 
                </td>
            </tr>
           

           <tr class="trhead">
            	<td colspan="5" class="thead">
                    <div class="thead english">Head Office Address : </div>
                    <div class="thead arabic">عنوان المركز الرئيسي  : </div>
                </td>
            </tr>
            <tr>
					<td>
                	<div class="label english">Mohafaza : </div>
                    <div class="data-box english"><?=$governorates['label_en'];?></div>
					</td>
					<td colspan="2">
                	<div class="label english">Kazaa : </div>
                    <div class="data-box english"><?=$districts['label_en'];?></div>
					</td>
					<td>
					<div class="label arabic">  القضاء : </div>
                    <div class="data-box arabic"><?=$districts['label_ar'];?></div>                    
					</td>
					<td>
                	<div class="label arabic">  المحافظة : </div>
                    <div class="data-box arabic"><?=$governorates['label_ar'];?></div>  					
					</td>					
             </tr>
			<tr>
            	<td colspan="5">
                	<div class="label english">City : </div>
                    <div class="data-box english"><?=$area['label_en'];?></div>
                    <div class="label arabic">   البلدة او المحلة : </div>
                    <div class="data-box arabic"><?=$area['label_ar'];?></div>                    
                </td>   
             </tr>

			<tr>
            	<td>
                	<div class="label english">Street : </div>
                    <div class="data-box english"><?=$query['street_en'];?></div>
				</td>	
				<td colspan="2">
                	<div class="label english">Bldg : </div>
                    <div class="data-box english"><?=$query['bldg_en'];?></div>
                </td>
				<td>
				    <div class="label arabic">  البناية : </div>
                    <div class="data-box arabic"><?=$query['bldg_ar'];?></div>                    
                </td>
				<td>	
                    <div class="label arabic">  الشارع : </div>
                    <div class="data-box arabic"><?=$query['street_ar'];?></div>                    
                </td>   
             </tr>
			<tr>
            	<td colspan="5">
                	<div class="label english">Tel : </div> 
                    <div class="data-box english"><?=$query['phone'];?></div>                   
                    <div class="label arabic">  هاتف: </div>
                    <div class="data-box arabic"><?=$query['phone'];?></div>
                </td>   
             </tr>
             <tr>
            	<td colspan="5">
                	<div class="label english">Fax : </div>
                    <div class="data-box english"><?=$query['fax'];?></div> 
                    <div class="label arabic">  فاكس: </div>
                    <div class="data-box arabic"><?=$query['fax'];?></div>                    
                </td>   
             </tr>
           <tr>
            	<td colspan="5">
                	<div class="label english">P.O.Box : </div>
                    <div class="data-box english"><?=$query['pobox_en'];?></div>                    
                    <div class="label arabic">  ص. بريد : </div>
                    <div class="data-box arabic"><?=$query['pobox_ar'];?></div>                    
                </td>   
             </tr>  
             <tr>
            	<td colspan="2">
                	<div class="label english">Email : </div>
                    <div class="data-box english"><?=$query['email'];?></div>
                </td>
				<td colspan="3">
                	<div class="label english">Website : </div>
                    <div class="data-box english"><?=$query['web_page'];?></div>
                </td>
             </tr>  
           <tr>
            	<td colspan="2">
                	<div class="label english">N Location : </div>
                    <div class="data-box english"><?=$query['x_location'];?></div>  
                </td>
                <td colspan="3">                      
                    <div class="label english">E Location : </div>
                    <div class="data-box english"><?=$query['y_location'];?></div>
                </td>   
             </tr>  
            </table>
            <div class="break"></div>
            <table class="table-view" style="width:920px !important" style="margin-top:10px !important">
            <tr>
            	<td colspan="5">
                	<div class="label english">No. Of Branches In Lebanon : </div>
                    <div class="data-box english"><?=$total_branches;?></div>
                    <div class="label arabic">   عدد الفروع في لبنان : </div>
                    <div class="data-box arabic"><?=$total_branches;?></div>                    
                </td>   
             </tr>

			<!--<tr class="trhead">
            	<td colspan="5" class="thead" style="text-align:center">المؤسسات الراعية</td>
            </tr>
			<tr>
            	<td colspan="5" style="text-align:center">
                <div class="sponsor">
                	<?php foreach($sponsors as $sponsor)
					{
						echo '<img src="'.base_url().$sponsor->logo.'" class="th-logo" />';
						} ?>
                 </div>       
                </td>
            </tr>-->
            
        </table>
    </div>
    <div class="break"></div>
</body>
</html>