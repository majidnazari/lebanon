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
        <table class="table-view" style="width:920px !important" style="margin-top:10px !important">
        	<tr class="row"><td colspan="5" style="text-align:center"><h3>رقم الاستمارة : <?=$query['id']?></h3></td></tr>
            <tr>
            	<td colspan="5">
                	<div class="label english">Company Name :</div>
                    <div class="data-box english"><?=$query['name_en'];?>&nbsp;</div>
                    <div class="label arabic"> اسم المؤسسة:</div>
                    <div class="data-box arabic"><?=$query['name_ar'];?>&nbsp;</div>                    
                </td>
            </tr>
            <tr>
            	<td colspan="5">
                	<div class="label english">Company Name :</div>
                    <div class="data-box english"><?=$query['name_en'];?>&nbsp;</div>
                    <div class="label arabic"> اسم المؤسسة:</div>
                    <div class="data-box arabic"><?=$query['name_ar'];?>&nbsp;</div>                    
                </td>
            </tr>
        	<tr>
            <td colspan="5">
            	<table width="100%" class="itable">
                <tr>
            	<td colspan="2">
                	<table width="100%">
                	<td class="label english" style="float:left;">Company Name :</td>
                    <td class="point english" style="float:left; width:300px !important"><?=$query['name_en'];?>&nbsp;</td>
                    </table>
                 </td>
                <td class="empty" rowspan="7">&nbsp;</td>
                <td colspan="2">
                <table width="100%" dir="rtl">
                	<td class="label arabic" nowrap="nowrap" > اسم المؤسسة:</td>
                    <td class="point arabic" style="width:300px !important"><?=$query['name_ar'];?>&nbsp;</td>
                    </table>
				</td>
             
            </tr>
        	<tr>
            	<td colspan="2">
                <table width="100%">
                	<td class="label english" nowrap="nowrap" >Owner / Owners of the Co. :</td>
                    <td class="point english" style="width:250px !important"><?=$query['owner_name_en'];?>&nbsp;</td>
                  </table>  
                 </td>
                 <td colspan="2">
                 <table width="100%"  dir="rtl">
                	<td class="label arabic" nowrap="nowrap"> صاحب / اصحاب الشركة: </td>
                    <td class="point arabic" style="width:230px !important"><?=$query['owner_name'];?>&nbsp;</td>
                    </table>
				</td>
            </tr>
            <tr>
            	<td colspan="2">
                <table width="100%">
                	<td class="label english"  nowrap="nowrap">Name of The Authorized to Sign :</td>
                    <td class="point english" style="width:240px !important"><?=$query['auth_person_en'];?>&nbsp;</td>
                  </table>  
                 </td>
                 <td colspan="2">
                 <table width="100%" dir="rtl">
                	<td class="label arabic" nowrap="nowrap"> اسم المفوض بالتوقيع  :</td>
                    <td class="point arabic" style="width:250px !important"><?=$query['auth_person_ar'];?>&nbsp;</td>
                   </table> 
				</td>
            </tr>
            <tr>
            	<td colspan="2">
                <table width="100%">
                	<td class="label english" nowrap="nowrap">No. & Place of C.R :</td>
                    <td class="point english" style="width:300px !important"><?=$query['commercial_register_en'];?>&nbsp;</td>
                  </table>  
                 </td>
                 <td colspan="2">
                 <table width="100%" dir="rtl">
                	<td class="label arabic"  nowrap="nowrap"> رقم ومحل اصدار السجل التجاري: </td>
                    <td class="point arabic" style="width:240px !important"><?=$query['commercial_register_ar'];?>&nbsp;</td>
                    </table>
				</td>
            </tr>
            <tr>
            	<td colspan="2">
                <table width="100%">
                	<td class="label english">Activity :</td>
                    <td class="point english" style="width:350px !important"><?=$query['activity_en'];?>&nbsp;</td>
                    </table>
                 </td>
                 <td colspan="2">
                 <table width="100%" dir="rtl">
                	<td class="label arabic" nowrap="nowrap"> نوع النشاط:</td>
                    <td class="point arabic" style="width:300px !important"><?=$query['activity_ar'];?>&nbsp;</td>
                  </table>  
				</td>
            </tr>
            <!--
       		<tr>
            	<td class="label english" nowrap="nowrap">Name of The Authorized to Sign : </td>
            	<td class="point english"><?=$query['auth_person_en'];?></td>   
                <td class="point arabic"><?=$query['auth_person_ar'];?></td>           
                <td class="label arabic" nowrap="nowrap"> : اسم المفوض بالتوقيع  </td>
            </tr>
       		<tr>
            	<td class="label english" nowrap="nowrap">No. & Place of C.R : </td>
            	<td class="point english"><?=$query['commercial_register_en'];?></td>   
                <td class="point arabic"><?=$query['commercial_register_ar'];?></td>           
                <td class="label arabic" nowrap="nowrap">: رقم ومحل اصدار السجل التجاري</td>
            </tr>
       		<tr>
            	<td class="label english" nowrap="nowrap">Activity : </td>
            	<td class="point english"><?=$query['activity_en'];?></td>   
                <td class="point arabic"><?=$query['activity_ar'];?></td>           
                <td class="label arabic" nowrap="nowrap">: نوع النشاط</td>
            </tr>-->
            </table>
            </td>
            </tr>
            <tr class="row">
            	<td colspan="2"></td>
                <td class="empty">&nbsp;</td>
                <td colspan="2"></td>
            </tr>
			<tr class="trhead">
            	<td colspan="2" class="thead">Company Type</td>
                <td class="empty">&nbsp;</td>
                <td colspan="2" class="thead arabic">نوع الشركة</td>
            </tr>
            <tr>
            	<td colspan="5" class="arabic">
                	<ul class="type-list">
                	<?php
					$style='style="float:right"  disabled="disabled"';
                    	foreach($company_types as $ctype)
						{
							if($ctype->id==$query['company_type_id'])
							$checked='<img src="'.base_url().'img/checked.png" class="icon arabic" />';
							else
							$checked='<img src="'.base_url().'img/unchecked.png" class="icon arabic" />';
							echo '<li>'.$ctype->label_ar.'&nbsp;&nbsp;'.$checked.'<br><span class="list-en">'.$ctype->label_en.'</span></li>';
							}
					?> 
                    </ul>
                </td>
            </tr>
           
			<tr class="trhead">
            	<td colspan="2" class="thead">Affiliation to Economical & Technical Associations : </td>
                <td class="empty" rowspan="7">&nbsp;</td>
                <td colspan="2" class="thead arabic">الانتساب الى هيئات اقتصادية او مهنية</td>
            </tr>
            <tr>
            	<td class="label english" nowrap="nowrap">Associations of Lebanese Industrialists : </td>
            	<td class="point english"><?php
                		if($query['leb_ind_group']==0)
						echo 'No';
						else
						echo 'Yes';
					?></td>   
                <td class="point arabic"><?php
                		if($query['leb_ind_group']==0)
						echo 'كلا';
						else
						echo 'نعم';
					?></td>           
                <td class="label arabic" nowrap="nowrap"> : جمعية الصناعيين اللبنانيين</td>
            </tr>

            <tr>
            	<td class="label english" nowrap="nowrap">Chambre of Commerce & Industry of : </td>
            	<td class="point english"><?php 
				if(count($industrial_room)>0){
					$industrial_room_en=$industrial_room['label_en'];
					$industrial_room_ar=$industrial_room['label_ar'];
					}
				else{
					$industrial_room_en='';
					$industrial_room_ar='';
					}	
				$industrial_room_en;;?></td>   
                <td class="point arabic"><?=$industrial_room_ar;?></td>           
                <td class="label arabic" nowrap="nowrap"> : غرفة الصناعة والتجارة في </td>
            </tr>

            <tr>
            <?php 
				if(count($economical_assembly)>0)
				{
					$economical_assembly_en=$economical_assembly['label_en'];
					$economical_assembly_ar=$economical_assembly['label_ar'];
					}
				else{
					$economical_assembly_en='';
					$economical_assembly_ar='';
					}	
				if(count($industrial_group)>0)
				{
					$industrial_group_en=$industrial_group['label_en'];
					$industrial_group_ar=$industrial_group['label_ar'];
					}
				else{
					$industrial_group_en='';
					$industrial_group_ar='';
					}	
			
			?>
            	<td class="label english">Assemblies of Economical, technical or Local Order - Specify : </td>
            	<td class="point english"><?=$economical_assembly_en;?></td>   
                <td class="point arabic"><?=$economical_assembly_ar;?></td>           
                <td class="label arabic" nowrap="nowrap"> : اتحادات مهنية اقليمية او دولية - حدد</td>
            </tr>

            <tr>
            	<td class="label english" nowrap="nowrap">Industrial Assembly : </td>
            	<td class="point english"><?=$industrial_group_en;?></td>   
                <td class="point arabic"><?=$industrial_group_ar;?></td>           
                <td class="label arabic" nowrap="nowrap"> : تجمع صناعي </td>
            </tr>
            <tr class="row">
            	<td colspan="2"></td>
                <td colspan="2"></td>
            </tr>
            <tr class="trhead">
            	<td colspan="2" class="thead">Head Office Address : </td>
                <td colspan="2" class="thead arabic">عنوان المركز الرئيسي </td>
            </tr>
            <tr>
           <td colspan="5">
            <table style="width:100% !important">
			
            <tr>
            	<td class="label english" nowrap="nowrap">Mohafaza : </td>
            	<td class="point english"><?=$governorates['label_en'];?></td>   
                <td class="empty" rowspan="12">&nbsp;</td>
                <td class="point arabic"><?=$governorates['label_ar'];?></td>           
                <td class="label arabic" nowrap="nowrap"> : المحافظة</td>
            </tr>

            <tr>
            	<td class="label english" nowrap="nowrap">Kazaa : </td>
            	<td class="point english"><?=$districts['label_en'];?></td>   
                <td class="point arabic"><?=$districts['label_ar'];?></td>           
                <td class="label arabic" nowrap="nowrap"> : القضاء </td>
            </tr>

            <tr>
            	<td class="label english">City : </td>
            	<td class="point english"><?=$area['label_en'];?></td>   
                <td class="point arabic"><?=$area['label_ar'];?></td>           
                <td class="label arabic" nowrap="nowrap"> : البلدة او المحلة</td>
            </tr>

            <tr>
            	<td class="label english" nowrap="nowrap">Street : </td>
            	<td class="point english"><?=$query['street_office_en'];?></td>   
                <td class="point arabic"><?=$query['street_office_ar'];?></td>           
                <td class="label arabic" nowrap="nowrap">الشارع</td>
            </tr>
            <tr>
            	<td class="label english" nowrap="nowrap">Bldg : </td>
            	<td class="point english"><?=$query['bldg_office_en'];?></td>   
                <td class="point arabic"><?=$query['bldg_office_ar'];?></td>           
                <td class="label arabic" nowrap="nowrap">البناية</td>
            </tr>

            <tr>
            	<td class="label english" nowrap="nowrap">Tel : </td>
            	<td class="point english"><?=$query['phone_office'];?></td>   
                <td class="point arabic"><?=$query['phone_office'];?></td>           
                <td class="label arabic" nowrap="nowrap"> : هاتف</td>
            </tr>

            <tr>
            	<td class="label english">Fax : </td>
            	<td class="point english"><?=$query['fax_office'];?></td>   
                <td class="point arabic"><?=$query['fax_office'];?></td>           
                <td class="label arabic" nowrap="nowrap"> : فاكس</td>
            </tr>

            <tr>
            	<td class="label english" nowrap="nowrap">P.O.Box : </td>
            	<td class="point english"><?=$query['pobox_office_en'];?></td>   
                <td class="point arabic"><?=$query['pobox_office_ar'];?></td>           
                <td class="label arabic" nowrap="nowrap"> : ص. بريد</td>
            </tr>
           <tr>
            	<td class="label english" nowrap="nowrap">Website : </td>
            	<td class="point english"><?=$query['web_page'];?></td>   
                <td class="point arabic"><?=$query['web_page'];?></td>           
                <td class="label arabic" nowrap="nowrap">الموقع الالكتروني</td>
            </tr>

            <tr>
            	<td class="label english">Email : </td>
            	<td class="point english"><?=$query['email'];?></td>   
                <td class="point arabic"><?=$query['email'];?></td>           
                <td class="label arabic" nowrap="nowrap"> : البريد الالكتروني</td>
            </tr>

            <tr>
            	<td colspan="5">
                    <table style="width:100% !important">
                        <td class="label english" nowrap="nowrap" style="width:100px !important">N Location : </td>
                        <td class="point english" style="width:230px !important"><?=$query['x_location'];?></td>
                        <td class="empty">&nbsp;</td>  
                     
                        <td nowrap="nowrap" style="width:100px !important">E Location :  </td>
                        <td class="point english" style="width:260px !important"><?=$query['y_location'];?></td>   
                    </table>        
                </td>
            </tr>
           
            </table>
            
             </td>
            </tr>
            </table>
            <div class="break"></div>
            <table width="100%" style="margin-top:20px !important">
            <tr class="row">
            	<td colspan="2"></td>
                <td colspan="2"></td>
            </tr>
			<tr class="trhead">
            	<td colspan="2" class="thead">Production Information : </td>
                <td class="empty">&nbsp;</td>  
                <td colspan="2" class="thead arabic">معلومات عن الانتاج</td>
            </tr>
            <tr>
            	<td colspan="5">
                	<table dir="rtl" class="table1">
                    	<tr class="trheadg">
                            <td class="theadg">البند الجمركي  
                            	(H.S. Code)
                            </td>
                            <td  class="theadg arabic">الصنف</td>
                            <td  class="theadg english">ITEMS</td>
                        </tr>
                        <?php 
						if(count($items)){	
						foreach($items as $item){ 
								if($item->heading_description_ar!=''){
									$heading_comp_ar=$item->heading_description_ar;
								}
								else{
									$heading_comp_ar=$item->heading_ar;
									}
								if($item->heading_description_en!=''){
									$heading_comp_en=$item->heading_description_en;
								}
								else{
									$heading_comp_en=$item->heading_en;
									}
						?>
                         <tr>
                         	<td width="20%"><?=$item->hscode?></td>
                            <td width="40%"><?=$heading_comp_ar?></td>
                            <td width="40%"  class="english"><?=$heading_comp_en?></td>
                         </tr>
                         <?php } }
						 else{
						  ?>
                          <tr>
                          	<td width="20%">&nbsp;</td>
                            <td width="40%">&nbsp;</td>
                            <td width="40%"  class="english">&nbsp;</td>
                            
                          </tr>
                          <?php } ?>
                    </table>
                </td>
            </tr>
            <tr class="row"><td colspan="5"></td></tr>
             <tr class="trhead">
            	<td colspan="5" class="thead" style="text-align:center">Export & Trade Market &nbsp;&nbsp;   اسواق البيع والتصدير</td>
                
            </tr>
            <tr>
           <td colspan="5">
            <table style="width:100%">
			
            <tr>
            	<td class="label english" nowrap="nowrap"><?php 
				$array_id=array();
				$checkedi_en='<img src="'.base_url().'img/unchecked.png" class="icon english" />';
				$checkedi_ar='<img src="'.base_url().'img/unchecked.png" class="icon arabic" />';
				foreach($markets as $market)
				{
					array_push($array_id,$market->country_id);
					}
				if(in_array(7,$array_id)){
					$checked_ar='<img src="'.base_url().'img/checked.png" class="icon arabic" />';
					$checked_en='<img src="'.base_url().'img/checked.png" class="icon english" />';
				}else{
					$checked_ar='<img src="'.base_url().'img/unchecked.png" class="icon arabic" />';
					$checked_en='<img src="'.base_url().'img/unchecked.png" class="icon english" />';
				}
				if(count($array_id)>0 and !in_array(7,$array_id)){
					$checkedi_en='<img src="'.base_url().'img/unchecked.png" class="icon english" />';
					$checkedi_ar='<img src="'.base_url().'img/unchecked.png" class="icon arabic" />';
					}
						
				$style_en='style="float:left"  disabled="disabled"';
				echo $checked_en?> Local Market  </td>
                <td class="empty">&nbsp;</td>    
                <td class="label arabic" nowrap="nowrap"><?php 
				
				$style_ar='style="float:right"  disabled="disabled"';
				?>
				     اسواق محلية <?php echo $checked_ar?></td>
            </tr>

            <tr>
            	<td class="label english" nowrap="nowrap"><?php echo $checkedi_en?> International Market / Country Name</td>   
                <td class="empty">&nbsp;</td>            
                <td class="label arabic" nowrap="nowrap">
					
                	اسواق الدول الخارجية / اسم الدولة
                <?php echo $checkedi_ar?>
                </td>
            </tr>
            	<?php foreach($markets as $market){ ?>
				<tr>
            	<td class="point english" nowrap="nowrap"><?=$market->market_en.' / '.$market->country_en?></td>   
                <td class="empty">&nbsp;</td>            
                <td class="point arabic" nowrap="nowrap"><?=$market->market_ar.' / '.$market->country_ar?></td>   
            </tr>	
				<?php	} ?>
            </table>
             </td>
            </tr>
            <tr class="row"><td colspan="5"></td></tr>
			<tr class="trhead">
            	<td colspan="2" class="thead">Means of Export : </td>
                <td class="empty">&nbsp;</td>  
                <td colspan="2" class="thead arabic"> : طريقة التصدير </td>
            </tr>
            <?php $style_ins_exp="class='english' disabled='disabled'"; 
					$checked_l='';
					$checked_d='';
					$checked_m='';
					
							if($query['is_exporter']==0){
								
							$checked_d='<img src="'.base_url().'img/checked.png" class="icon english" />';;
							$checked_l='<img src="'.base_url().'img/unchecked.png" class="icon english" />';;
							$checked_m='<img src="'.base_url().'img/unchecked.png" class="icon english" />';;
							}
							else{
							$checked_d='<img src="'.base_url().'img/unchecked.png" class="icon english" />';;
							$checked_l='<img src="'.base_url().'img/checked.png" class="icon english" />';;
							$checked_m='<img src="'.base_url().'img/unchecked.png" class="icon english" />';;
							}
						
					?>
            <tr>
            	<td colspan="5" class="arabic">
                	<ul class="type-list" style="float:right">
                    	<li><?=$checked_m.'&nbsp;Mediation / بالوسطة'?></li>
                        <li><?=$checked_d.'&nbsp; Direct / مباشر'?></li>
                        <li><?=$checked_l.'&nbsp;Export Less / غير مصدر '?></li>
                        
                    </ul>
                </td>
            </tr> 
            <tr class="row"><td colspan="5"></td></tr>           
			<tr class="trhead">
            	<td colspan="2" class="thead">Insurance : </td>
                <td class="empty">&nbsp;</td>  
                <td colspan="2" class="thead arabic">التأمين</td>
            </tr>
            <tr>
            	<td class="english" colspan="2">
                	<?php $style_ins_en="class='english' disabled='disabled'";
							if(count($insurances)>0){
								$checked_yes_en='<img src="'.base_url().'img/checked.png" class="icon english" />';
								$checked_yes_ar='<img src="'.base_url().'img/checked.png" class="icon arabic" />';
								$checked_no_en='<img src="'.base_url().'img/unchecked.png" class="icon english" />';
								$checked_no_ar='<img src="'.base_url().'img/unchecked.png" class="icon arabic" />';
							}
							else{
								$checked_no_en='<img src="'.base_url().'img/checked.png" class="icon english" />';
								$checked_no_ar='<img src="'.base_url().'img/checked.png" class="icon arabic" />';
								$checked_yes_en='<img src="'.base_url().'img/unchecked.png" class="icon english" />';
								$checked_yes_ar='<img src="'.base_url().'img/unchecked.png" class="icon arabic" />';
								}
					 ?>
                    <table>
                        <tr><td colspan="3">Do You have Insurance : </td></tr>
                        <tr>
                            <td><?=$checked_yes_en.'&nbsp;Yes'?>
                        		<?=$checked_no_en.'&nbsp;No'?></td>
                            <td> : Company Name :</td>
                            <td class="point">
                            	<?php
								foreach($insurances as $insurance){
									echo $insurance->insurance_en.'<br>';
									
									}
								 ?>
                            </td>
                         </tr>
                    </table>    
                 </td>
                 <td class="empty">&nbsp;</td>  
            	<td class="arabic" colspan="2">
                <?php $style_ins_ar="class='arabic' disabled='disabled'"; ?>
                	<table dir="rtl" style="float:right">
                        <tr><td colspan="3">هل المؤسسة مؤمنة : </td></tr>
                        <tr>
                            <td><?=$checked_yes_ar.'&nbsp;نعم'?>
                        		<?=$checked_no_ar.'&nbsp;كلا'?></td>
                            <td> : اسم الشركة  :</td>
                            <td class="point">
                            <?php
								foreach($insurances as $insurance){
									echo $insurance->insurance_ar.'<br>';
									
									}
								 ?>
                            </td>
                         </tr>
                    </table>    
                </td>
            </tr>
            <tr class="row"><td colspan="5"></td></tr>            
			<tr class="trhead">
            	<td colspan="2" class="thead">Banks : </td>
                <td class="empty">&nbsp;</td>  
                <td colspan="2" class="thead arabic">المصارف المعتمدة</td>
            </tr>
            <tr>
            	<td class="english" colspan="2">
                    <table>
                        <tr>
                            <td>Bank Name:</td>
                            <td class="point" nowrap="nowrap" style="width:360px !important">
                            <?php if(count($banks)){
										foreach($banks as $bank){
											echo $bank->bank_en.'<br>';
										}
									}
											
							?>
                            </td>
                         </tr>
                    </table>    
                 </td>
                 <td class="empty">&nbsp;</td>  
            	<td class="arabic" colspan="2">
                	<table width="100%">
                        <tr>
                           
                            <td class="point"  style="width:300px !important"><?php if(count($banks)){
										foreach($banks as $bank){
											echo $bank->bank_ar.'<br>';
										}
									}
											
							?></td>
                             <td> : اسم البنك  </td>
                         </tr>
                    </table>    
                </td>
            </tr> 
            <tr class="row"><td colspan="5"></td></tr>           
			<tr class="trhead">
            	<td colspan="2" class="thead">Electric Power : </td>
                <td class="empty">&nbsp;</td>  
                <td colspan="2" class="thead arabic">استعمال الطاقة</td>
            </tr>
            <tr>
            	<td class="english" colspan="2">
                	<?php $style_ins_p="class='english' disabled='disabled'"; 
					$checked_f_en='<img src="'.base_url().'img/unchecked.png" class="icon english" />';
					$checked_f_ar='<img src="'.base_url().'img/unchecked.png" class="icon arabic" />';
					$checked_d_en='<img src="'.base_url().'img/unchecked.png" class="icon english" />';
					$checked_d_ar='<img src="'.base_url().'img/unchecked.png" class="icon arabic" />';
					if(count($powers)){
							foreach($powers as $power){ 
							if($power->fuel!=''){
							$checked_f_en='<img src="'.base_url().'img/checked.png" class="icon english" />';
							$checked_f_ar='<img src="'.base_url().'img/checked.png" class="icon arabic" />';
							}
							else{
							$checked_f_en='<img src="'.base_url().'img/unchecked.png" class="icon english" />';
							$checked_f_ar='<img src="'.base_url().'img/unchecked.png" class="icon arabic" />';
							}
							if($power->diesel!=''){
							$checked_d_en='<img src="'.base_url().'img/checked.png" class="icon english" />';
							$checked_d_ar='<img src="'.base_url().'img/checked.png" class="icon arabic" />';
							}
							else{
							$checked_d_en='<img src="'.base_url().'img/unchecked.png" class="icon english" />';
							$checked_d_ar='<img src="'.base_url().'img/unchecked.png" class="icon arabic" />';
								}
							}
						}
					?>
                    <table>
                        <tr>
                            <td><?=$checked_f_en.'&nbsp;Fuel / Ton Or Litre'?></td>
                            <td class="point">
                            <?php if(count($powers)){
										foreach($powers as $power){ 
										echo $power->fuel;
										}
									}
										?>
                            </td>
                         </tr>
                         <tr>
                            <td><?=$checked_d_en.'&nbsp;Diesel / Ton Or Litre'?></td>
                            <td class="point">
                            <?php if(count($powers)){
										foreach($powers as $power){ 
										echo $power->diesel;
										}
									}
										?>
                            </td>
                         </tr>
                    </table>    
                 </td>
                 <td class="empty">&nbsp;</td>  
            	<td class="arabic" colspan="2">
                <?php $style_ins_ar="class='arabic'"; ?>
                	<table dir="rtl" width="100%">
                        <tr>
                            <td><?=$checked_f_ar.'&nbsp;فيول / طن او ليتر'?></td>
                            <td class="point">
							<?php if(count($powers)){
										foreach($powers as $power){ 
										echo $power->fuel;
										}
									}
										?></td>
                         </tr>
                         <tr>
                            <td><?=$checked_d_ar.'&nbsp;مازوت / طن او ليتر'?></td>
                            <td class="point">
                            <?php if(count($powers)){
										foreach($powers as $power){ 
										echo $power->diesel;
										}
									}
										?>
                            </td>
                         </tr>
                    </table>    
                </td>
            </tr>  
            <tr class="row"><td colspan="5"></td></tr>  
            <?php 
			if(count($salesman)>0){
				$sales_man=$salesman['fullname'];
				}
			else{
				$sales_man='';
				}	
			if(count($position)>0)
			{
				$pos=$position['label_ar'];
				}	
			else{
				$pos='';
				}	
			?>        
			<tr class="trhead">
            	<td colspan="5">
                	<div class="box">
                    	<table dir="rtl" width="100%">
                        	<tr><td colspan="2">اسم الشخص الذي تمت معه  المقابلة في  المؤسسة : <?=$query['rep_person_ar'].'&nbsp;<span style="float:left">'.$query['rep_person_en'].'</span>';?></td></tr>
                            <tr><td width="50%">صفته في المؤسسة : <?=$pos?></td><td width="50%">توقيعه : </td></tr>
                            <tr><td width="50%">اسم المندوب : <?=$sales_man?></td><td width="50%">توقيعه : </td></tr>
                            <tr><td width="50%">ختم وتوقيع الشركة : </td><td width="50%">تاريخ ملئ الاستمارة : </td></tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr class="row"><td colspan="5"></td></tr>          
			<tr class="trhead">
            	<td colspan="2" class="thead">Administration : </td>
                <td class="empty">&nbsp;</td>  
                <td colspan="2" class="thead arabic">خاص  بإدارة الدليل</td>
            </tr>

            <tr>
            	<td  colspan="5">
                	<?php $style_ins_en="class='english'"; ?>
                    <table dir="rtl" width="100%">
                        <tr>
                            <td>استلام  الاستمارة من المندوب <br />
                            التاريخ : <br />
                            التوقيع
                            </td>
                           <td>التدقيق مع المؤسسات <br />
                            التاريخ : <br />
                            التوقيع
                            </td>
                            <td>ادخال معلومات الاستمارة <br />
                            التاريخ : <br />
                            التوقيع
                            </td>
                            <td>حفظ  الاستمارة <br />
                            التاريخ : <br />
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
    </div>
    <div class="break"></div>
</body>
</html>