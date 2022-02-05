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
    	<div class="clear"></div><br />
        <h3 class="d-num">رقم الاستمارة : <?=$query['id']?></h3>
        <table class="table-view" style="width:920px !important; margin-top:10px !important">
        	
            <tr>
            	<td colspan="5">
                	<div class="label english">Company Name :</div>
                    <div class="data-box english"><?=$query['name_en'];?>&nbsp;</div>
                    <div class="label arabic"> اسم الشركة:</div>
                    <div class="data-box arabic"><?=$query['name_ar'];?>&nbsp;</div>                    
                </td>
            </tr>
            <tr>
            	<td colspan="5">
                	<div class="label english">C.R :</div>
                    <div class="data-box english"><?=$query['cr_en'];?>&nbsp;</div>
                    <div class="label arabic"> س.ت:</div>
                    <div class="data-box arabic"><?=$query['cr_ar'];?>&nbsp;</div>                    
                </td>
            </tr>
            <tr>
            	<td colspan="5">
                	<div class="label english">Capital :</div>
                    <div class="data-box english"><?=$query['capital'];?>&nbsp;</div>
                    <div class="label arabic">رأس المال : </div>
                    <div class="data-box arabic"><?=$query['capital'];?>&nbsp;</div>                    
                </td>
            </tr>
            <tr>
            	<td colspan="5">
                	<div class="label english">Registration No. at Ministry of Economy :</div>
                    <div class="data-box english"><?=$query['ins_number'];?>&nbsp;</div>
                    <div class="label arabic"> رقم التسجيل في وزارة الاقتصاد والتجارة : </div>
                    <div class="data-box arabic"><?=$query['ins_number'];?>&nbsp;</div>                    
                </td>
            </tr>
            <tr>
            	<td colspan="5">
                	<div class="label english">Registration No. at Lebanon :</div>
                    <div class="data-box english"><?=$query['ins_ecoo_no'];?>&nbsp;</div>
                    <div class="label arabic"> رقم الانتساب لجمعية شركات الضمان في لبنان : </div>
                    <div class="data-box arabic"><?=$query['ins_ecoo_no'];?>&nbsp;</div>                    
                </td>
            </tr>
            <tr>
            	<td colspan="5">
                	<div class="label english">Board of Directors :</div>
                    <div class="data-box english"><?=$query['manager_en'];?>&nbsp;</div>
                    <div class="label arabic"> مجلس الادارة : </div>
                    <div class="data-box arabic"><?=$query['manager_ar'];?>&nbsp;</div>                    
                </td>
            </tr>
            <tr>
            	<td colspan="5">
                	<div class="label english">General Manager :</div>
                    <div class="data-box english"><?=$query['chairman_en'];?>&nbsp;</div>
                    <div class="label arabic">المدير العام :</div>
                    <div class="data-box arabic"><?=$query['chairman_ar'];?>&nbsp;</div>                    
                </td>
            </tr>
          	</td>
             </tr> 
             <tr class="trhead">
            	<td colspan="5" class="thead">
                    <div class="thead english">Board Of Directors : </div>
                    <div class="thead arabic">مجلس الادارة :   </div>
                </td>
            </tr>
             <tr>
                 <td colspan="5">
                    <table style="width:100%">
            		<?php	foreach($directors as $director){ ?>
                   		<tr>
                        	<td><?=$director->name_en?></td>
                            <td style="text-align:right; width:50%"><?=$director->name_ar?></td>
                        </tr>
               		<?php }
					echo '</table>';
					?> 
               		
              	</td>
             </tr> 
             <tr class="trhead">
            	<td colspan="5" class="thead">
                    <div class="thead english">Executive Management : </div>
                    <div class="thead arabic">الادارة التنفيذية : </div>
                </td>
            </tr>
            <tr>
                 <td colspan="5">
                    <table style="width:100%">
            		<?php	foreach($executives as $executive){ ?>
                   		<tr>
                        	<td><?=$executive->name_en?></td>
                            <td style="text-align:right; width:50%"><?=$executive->name_ar?></td>
                        </tr>
               		<?php }
					echo '</table>';
					?> 
               		
              	</td>
             </tr>             
            <tr class="trhead">
            	<td colspan="5" class="thead">
                    <div class="thead english">Head Office Address : </div>
                    <div class="thead arabic">عنوان المركز الرئيسي  : </div>
                </td>
            </tr>
            <?php 
					if(count($governorates)>0){
						$gov_en=$governorates['label_en'];
						$gov_ar=$governorates['label_ar'];
						}
					else{
						$gov_en='';
						$gov_ar='';
						}	
			?>
            <tr>
            	<td colspan="5">
                	<div class="label english">Mohafaza : </div>
                    <div class="data-box english"><?=$gov_en;?></div>
                    <div class="label arabic">  المحافظة : </div>
                    <div class="data-box arabic"><?=$gov_ar;?></div>                    
                </td>   
             </tr>
             <?php 
					if(count($districts)>0){
						$district_en=$districts['label_en'];
						$district_ar=$districts['label_ar'];
						}
					else{
						$district_en='';
						$district_ar='';
						}	
			?>
			<tr>
            	<td colspan="5">
                	<div class="label english">Kazaa : </div>
                    <div class="data-box english"><?=$district_en;?></div>
                    <div class="label arabic">  القضاء : </div>
                    <div class="data-box arabic"><?=$district_ar;?></div>                    
                </td>   
             </tr>
            <?php 
					if(count($area)>0){
						$area_en=$area['label_en'];
						$area_ar=$area['label_ar'];
						}
					else{
						$area_en='';
						$area_ar='';
						}	
			?> 
			<tr>
            	<td colspan="5">
                	<div class="label english">City : </div>
                    <div class="data-box english"><?=$area_en;?></div>
                    <div class="label arabic">   البلدة او المحلة : </div>
                    <div class="data-box arabic"><?=$area_ar;?></div>                    
                </td>   
             </tr>

			<tr>
            	<td colspan="5">
                	<div class="label english">Street : </div>
                    <div class="data-box english"><?=$query['street_en'];?></div>
                    <div class="label arabic">  الشارع : </div>
                    <div class="data-box arabic"><?=$query['street_ar'];?></div>                    
                </td>   
             </tr>
			<tr>
            	<td colspan="5">
                	<div class="label english">Bldg : </div>
                    <div class="data-box english"><?=$query['bldg_en'];?></div>
                    <div class="label arabic">  البناية : </div>
                    <div class="data-box arabic"><?=$query['bldg_ar'];?></div>                    
                </td>   
             </tr>
			<tr>
            	<td colspan="5">
                	<div class="label english">Tel : </div>                    
                    <div class="label arabic">  هاتف: </div>
                    <div class="data-box arabic"><?=$query['phone'];?></div>
                </td>   
             </tr>
             <tr>
            	<td colspan="5">
                	<div class="label english">Fax : </div>
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
            	<td colspan="5">
                	<div class="label english">Email : </div>
                    <div class="data-box english"><?=$query['email'];?></div>                    
                    <div class="label arabic"> البريد الالكتروني : </div>
                </td>   
             </tr>  
           <tr>
            	<td colspan="5">
                	<div class="label english">Website : </div>
                    <div class="data-box english"><?=$query['website'];?></div>                    
                    <div class="label arabic" >  الموقع الالكتروني: </div>
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
             <tr><td colspan="5" style="border-bottom:1px solid #00F"></td></tr>

			<tr class="trhead">
            	<td colspan="5" class="thead">
                    <div class="thead english">Classes of Business Transacted :</div>
                    <div class="thead arabic"> أوجه النشاط التي تمارسها الشركة :</div>
                </td>
            </tr>
            <tr>
            	<td colspan="5">
                	<table style="width:100%; border-collapse:collapse !important">
                    	<?php foreach($activities as $activity){?>
                        <tr>
                        	<td style="width:50%; text-align:left; padding-left:10px;"><?=$activity->label_en?></td>
                            <td style="width:50%; text-align:right; padding-right:10px;"><?=$activity->label_ar?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                        	<td>Other - Specify : <?=$query['activity_other_en']?></td>
                            <td style="direction:rtl"> نشاطات أخرى - حدد  :<?=$query['activity_other_ar']?></td>
                        </tr>
                    </table>
                	
                </td>
                
                
            </tr>
           <?php 
			if(count($salesman)>0){
				$sales_man=$salesman['fullname'];
				}
			else{
				$sales_man='';
				}	
			
			?>        
			<tr class="trhead">
            	<td colspan="5">
                	<div class="box">
                    	<table dir="rtl" width="100%"  style="border:none !important" cellpadding="10px">
                        	<tr>
                            	<td width="70%" colspan="2" style="border:none !important; font-size:18px !important"><strong>- اسم الشخص الذي تمت معه  المقابلة في  المؤسسة : </strong><?=$query['rep_person_en'].'&nbsp;&nbsp;&nbsp;<span style="float:left1">'.$query['rep_person_en'].'</span>';?></td>
                            	<td width="20%" style="border:none !important; font-size:18px !important"><strong>- توقيعه : </strong></td>
                            </tr>
                            <tr>
                            	<td width="40%" style="border:none !important; font-size:18px !important; font-size:18px !important">
                                <strong>- اسم المندوب : </strong><?=$sales_man?></td>
                                <td width="40%" style="border:none !important; font-size:18px !important"><strong>- تاريخ ملئ الاستمارة : </strong><?=$query['entry_date']?></td>
                                <td width="20%" style="border:none !important; font-size:18px !important"><strong>- توقيعه : </strong></td>
                           </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
            	<td colspan="5">
                
            <?php 
					if($query['display_directory']!=0)
						{
						$display_directory=base_url().'img/checked.png';
						if($query['directory_interested']!=0)
						{
						$directory_interested_yes=base_url().'img/checked.png';
						$directory_interested_no=base_url().'img/unchecked.png';
						}
					else{
						$directory_interested_yes=base_url().'img/unchecked.png';
						$directory_interested_no=base_url().'img/checked.png';
						}
						}
					else{
						$display_directory=base_url().'img/unchecked.png';
						$directory_interested_yes=base_url().'img/unchecked.png';
						$directory_interested_no=base_url().'img/unchecked.png';

						}
						
						if($query['display_exhibition']!=0)
						{
						$display_exhibition=base_url().'img/checked.png';
						if($query['exhibition_interested']!=0)
						{
						$exhibition_interested_yes=base_url().'img/checked.png';
						$exhibition_interested_no=base_url().'img/unchecked.png';
						}
					else{
						$exhibition_interested_yes=base_url().'img/unchecked.png';
						$exhibition_interested_no=base_url().'img/checked.png';
						}
						}
					else{
						$display_exhibition=base_url().'img/unchecked.png';
						$exhibition_interested_yes=base_url().'img/unchecked.png';
						$exhibition_interested_no=base_url().'img/unchecked.png';
						}
					
					?>
                  <ul class="list1">
                  	<li class="arabic"><img src="<?=$display_directory?>" class="icon arabic" />تم عرض الدليل</li>
                    <li class="arabic"><img src="<?=$directory_interested_yes?>" class="icon arabic" />مهتم</li>
                     <li class="arabic"><img src="<?=$directory_interested_no?>" class="icon arabic" />غير مهتم</li>
                    </ul> 
                   <ul class="list1" style="margin-right:30px;">
                    <li class="arabic"><img src="<?=$display_exhibition?>" class="icon arabic" />تم عرض المعرض</li>
                    <li class="arabic"><img src="<?=$exhibition_interested_yes?>" class="icon arabic" />مهتم</li>
                    <li class="arabic"><img src="<?=$exhibition_interested_no?>" class="icon arabic" />غير مهتم</li>
                  </ul>  
            	
                </td>
            </tr>
            <tr class="trhead">
            	<td colspan="5" class="thead">
                    <div class="thead english">Administration : </div>
                    <div class="thead arabic">خاص  بإدارة الدليل: </div>
                </td>
            </tr>           
            <tr>
            	<td  colspan="5">
                	<?php $style_ins_en="class='english'"; ?>
                    <table dir="rtl" width="100%" style="border:none !important; font-size:18px !important" cellpadding="10px">
                        <tr>
                            <td style="border:none !important; font-size:18px !important">- استلام  الاستمارة من المندوب <br /><br />
                            التاريخ : <br /><br />
                            التوقيع
                            </td>
                           <td style="border:none !important; font-size:18px !important">- التدقيق مع المؤسسات <br /><br />
                            التاريخ : <br /><br />
                            التوقيع
                            </td>
                            <td style="border:none !important; font-size:18px !important">- ادخال معلومات الاستمارة <br /><br />
                            التاريخ : <br /><br />
                            التوقيع
                            </td>
                            <td style="border:none !important; font-size:18px !important">- حفظ  الاستمارة <br /><br />
                            التاريخ : <br /><br />
                            التوقيع
                            </td>
                         </tr>
                         
                    </table>    
                 </td>
            </tr>     
            <!--       
			<tr class="trhead">
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
    <div class="break"></div>
        <div class="header"><img src="<?=base_url()?>img/header-insurance.jpg" width="100%" /></div>
    	<div class="clear"></div><br />
        <h3 class="d-num"><?='رقم الاستمارة : '.$query['id'].'<br>'.$query['name_ar']?></h3>
        <table class="table-view" style="width:920px !important; margin-top:10px !important">
            <tr style="background:#66CCFF !important; font-weight:bold !important">
                <td>Branch</td>
                <td>Mouhafazat</td>
                <td>Area & District</td>
                <td>Phone</td>
                <td>E-mail</td>
            </tr>
			<?php foreach($branches as $branch){ 
                    $b_area=$this->Address->GetAreaById($branch->area_id);
                    $b_district=$this->Address->GetDistrictById($b_area['district_id']);
                    $b_gov=$this->Address->GetGovernorateById($b_district['governorate_id']);
            ?>
            <tr>
                <td><?=$branch->name_en?></td>
                <td><?=$b_gov['label_en']?></td>
                <td><?=$b_district['label_en'].' '.$b_area['label_en']?></td>
                <td><?=$branch->phone?></td>
                <td><?=$branch->email?></td>
            </tr>
            <?php } ?>
		</table>
    </div>
    <div class="break"></div>
 	<div style="height:20px;"></div>
    <div class="break"></div>
</body>
</html>