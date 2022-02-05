<?php
/********************General Info**********************/
$array_ref=array('id'=>'ref','name'=>'ref','value'=>@$ref);
$array_name_ar=array('id'=>'name_ar','name'=>'name_ar','class'=>'ar txtbox','value'=>$query['name_ar'],'required'=>'required');
$array_name_en=array('id'=>'name_en','name'=>'name_en','class'=>'txtbox','value'=>$query['name_en'],'required'=>'required');

$array_owner_name=array('id'=>'owner_name','name'=>'owner_name','class'=>'ar txtbox','value'=>$query['owner_name']);
$array_owner_name_en=array('id'=>'owner_name_en','class'=>'txtbox','name'=>'owner_name_en','value'=>$query['owner_name_en']);

$array_auth_person_ar=array('id'=>'auth_person_ar','class'=>'ar txtbox','name'=>'auth_person_ar','value'=>$query['auth_person_ar']);
$array_auth_person_en=array('id'=>'auth_person_en','class'=>'txtbox','name'=>'auth_person_en','value'=>$query['auth_person_en']);

$array_auth_no =array('id'=>'auth_no','name'=>'auth_no','class'=>'txtbox','value'=>$query['auth_no']);

$array_activity_ar=array('id'=>'activity_ar','name'=>'activity_ar','class'=>'ar txtbox','value'=>$query['activity_ar']);
$array_activity_en=array('id'=>'activity_en','name'=>'activity_en','class'=>'txtbox','value'=>$query['activity_en']);
$array_establish_date=array('id'=>'establish_date','name'=>'establish_date','class'=>'txtbox','value'=>$query['establish_date']);

$array_personal_notes=array('id'=>'personal_notes','name'=>'personal_notes','value'=>$query['personal_notes'],'style'=>'height:250px !important');

$array_productions=array('id'=>'productions','name'=>'productions','style'=>'height:250px !important; width:98% !important');

/*********************Address*************************/
$array_street_ar=array('id'=>'street_ar','name'=>'street_ar','class'=>'ar txtbox','value'=>$query['street_ar']);
$array_street_en=array('id'=>'street_en','name'=>'street_en','class'=>'txtbox','value'=>$query['street_en']);

$array_bldg_ar=array('id'=>'bldg_ar','name'=>'bldg_ar','class'=>'ar txtbox','value'=>$query['bldg_ar']);
$array_bldg_en=array('id'=>'bldg_en','name'=>'bldg_en','class'=>'txtbox','value'=>$query['bldg_en']);

$array_fax=array('id'=>'fax','name'=>'fax','value'=>$query['fax'],'class'=>'txtbox');
$array_phone=array('id'=>'phone','name'=>'phone','value'=>$query['phone'],'class'=>'txtbox');

$array_pobox_ar=array('id'=>'pobox_ar','name'=>'pobox_ar','class'=>'ar txtbox','value'=>$query['pobox_ar'],'style'=>'direction:rtl !important');
$array_pobox_en=array('id'=>'pobox_en','name'=>'pobox_en','value'=>$query['pobox_en'],'class'=>'txtbox');

$array_email=array('id'=>'email','name'=>'email','value'=>$query['email'],'class'=>'txtbox');
$array_website=array('id'=>'website','name'=>'website','value'=>$query['website'],'class'=>'txtbox');
$array_x_location=array('id'=>'x_decimal','name'=>'x_decimal','value'=>$query['x_decimal']);
$array_y_location=array('id'=>'y_decimal','name'=>'y_decimal','value'=>$query['y_decimal']);

/*********************Molhak*************************/
$array_rep_person_ar=array('id'=>'rep_person_ar','name'=>'rep_person_ar','class'=>'ar txtbox','value'=>$query['rep_person_ar']);
$array_rep_person_en=array('id'=>'rep_person_en','name'=>'rep_person_en','class'=>'txtbox','value'=>$query['rep_person_en']);

$array_app_fill_date=array('id'=>'app_fill_date','name'=>'app_fill_date','class'=>'txtbox','value'=>$query['app_fill_date']);
$array_adv_pic=array('id'=>'adv_pic','name'=>'adv_pic','value'=>$query['adv_pic']);

?>

<?php
$jsgov='id="gov_id" onchange="getdistricts(this.value)" class="select2" required="required"';
$jsdis='id="district_id" onchange="getarea(this.value)" class="select2" required="required"';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link media="all" href="<?=base_url()?>css/company-print.css" rel="stylesheet" />
<title><?=$title?> </title>
<style type="text/css">
td{
	margin:0px;
	padding:0px;
	border:none !important;
}
.txtbox{
	border: 1px solid #d9d9d9;
    box-sizing: border-box;
    display: block;
    margin: 0 ;
    outline: medium none;
    padding: 10px 15px;
    transition: all 0.3s ease 0s;
    width: 100%;
	
}
select{
	
	border: 1px solid #d9d9d9;
    box-sizing: border-box;
    display: block;
    margin: 0 ;
    outline: medium none;
    padding: 10px 15px;
    transition: all 0.3s ease 0s;
    width: 100%;
	}
.ar{
	direction:rtl;
}
.td-input{
	width:25%;
}
.btn{
	background: #33b5e5 none repeat scroll 0 0;
    border: 0 none;
    color: #ffffff;
    cursor: pointer;
    padding: 10px 15px !important;
    transition: all 0.3s ease 0s;
    width: 100px;
	margin:30px !important;
}
</style>
<script type='text/javascript' src='<?=base_url()?>js/plugins/jquery/jquery-1.9.1.min.js'></script>
<script language="javascript">

  $(function() {
	  $(".select2").select2(); 
	  
	  $( "#app_fill_date" ).datepicker({
		  dateFormat: "yy-mm-dd"
		});
	$( "#end_date" ).datepicker({
		  dateFormat: "yy-mm-dd"
		});	
	})	
	function getdistricts(gov_id)
	{
		$("#district").html("loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>posting/GetDistricts",
			type: "post",
			data: "id="+gov_id,
			success: function(result){
				
				$("#district").html(result);
			}
		});
	}
	function getarea(district_id)
	{
		$("#area").html("loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>posting/GetArea",
			type: "post",
			data: "id="+district_id,
			success: function(result){
				$("#area").html(result);
			}
		});
	}
  
</script>		
</head>

<body>
	<div class="container">
    	<div class="header"><img src="<?=base_url()?>img/company-header.jpg" width="100%" /></div>
    	<div class="clear"></div>
            <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation'));
				 echo form_hidden('id',$query['id']);?>		

        <table class="table-view" style="width:920px !important" style="margin-top:10px !important">
        	<tr class="row"><td colspan="5" style="text-align:center"><h3>رقم الاستمارة : <?=$query['id']?></h3></td></tr>
            <tr>
            	<td><div class="label english">Company Name :</div></td>
                <td class="td-input"><?php echo form_input($array_name_en); ?></td>
                <td style="width:20px">&nbsp;</td>
                <td class="td-input"><?php echo form_input($array_name_ar); ?></td>
                <td><div class="label arabic"> اسم المؤسسة:</div></td>
            </tr>
            <tr>
            	<td><div class="label english">Owner / Owners of The Co. :</div></td>
                <td><?php echo form_input($array_owner_name_en); ?></td>
                <td style="width:20px">&nbsp;</td>
                <td><?php echo form_input($array_owner_name); ?></td>
                <td><div class="label arabic"> صاحب / اصحاب الشركة: </div></td>
            </tr>
            <tr>
            	<td><div class="label english">Name of The Authorized to Sign :</div></td>
                <td><?php echo form_input($array_auth_person_en); ?></td>
                <td style="width:20px">&nbsp;</td>
                <td><?php echo form_input($array_auth_person_ar); ?></td>
                <td><div class="label arabic"> اسم المفوض بالتوقيع  :</div></td>
            </tr>
            <tr>
            	<td><div class="label english">No. & Place of C.R :</div></td>
                <td><?php echo form_input($array_auth_no); ?></td>
                <td style="width:20px">&nbsp;</td>
                <td><?php 
								$array_licenses=array(0=>'اختر');
								foreach($license_sources as $license_item)
								{
									$array_licenses[$license_item->id]=$license_item->label_ar;
									}
							echo form_dropdown('license_source_id',$array_licenses,$query['license_source_id'],'class="ar"');		
								
						 ?></td>
                <td><div class="label arabic"> مصدر السجل: </div></td>
            </tr>
            <tr>
            	<td><div class="label english">Activity :</div></td>
                <td><?php echo form_input($array_activity_en); ?></td>
                <td style="width:20px">&nbsp;</td>
                <td><?php echo form_input($array_activity_ar); ?></td>
                <td><div class="label arabic"> نوع النشاط:</div></td>
            </tr>       
			<tr>
            	<td colspan="3"></td>
                <td><?php
					$style='style="float:right"  disabled="disabled"';
						$array_company_t=array(''=>'Select a type');
                    	foreach($company_types as $ctype)
						{
							$array_company_t[$ctype->id]=$ctype->label_ar.' ('.$ctype->label_en.')';
							
							}
						echo form_dropdown('company_type_id',$array_company_t,$query['company_type_id'],'class="ar"');	
					?> </td>
            	<td><div class="label arabic">نوع الشركة : </div></td>
            </tr>
           <tr class="trhead">
            	<td colspan="5" class="thead">
                    <div class="thead english">Affiliation to Economical & Technical Associations : </div>
                    <div class="thead arabic">الانتساب الى هيئات اقتصادية او مهنية : </div>
                </td>
            </tr>
            <tr>
            	<td colspan="3"></td>
                <td><?php 
						if($query['ind_association']==1){
							$checked=TRUE;
							}
						else{
							$checked=FALSE;
							}	
						echo form_checkbox('ind_association', 1, $checked);?>
                    </td>  
                    <td><div class="label arabic">  جمعية الصناعيين اللبنانيين  : </div></td>  
            </tr>
            <tr>
            	<td colspan="3"></td>
                <td><?php 
								$array_iro=array(0=>'اختر ');
								if(count($iro_data)>0){
									foreach($iro_data as $iro_item){
										$array_iro[$iro_item->id]=$iro_item->label_ar;
										
										}
										
									}
								echo form_dropdown('iro_code',$array_iro,$query['iro_code'],'style="direction:rtl"');	
							?>
                    </td>  
                    <td><div class="label arabic">غرفة التجارة والصناعة في</div></td>  
            </tr>
            <tr>
            	<td colspan="3"></td>
                <td><?php 
								$array_eas=array(0=>'اختر ');
								if(count($eas_data)>0){
									foreach($eas_data as $eas_item){
										$array_eas[$eas_item->id]=$eas_item->label_ar;
										
										}
										
									}
								echo form_dropdown('eas_code',$array_eas,$query['eas_code'],'style="direction:rtl"');	
							?>
                    </td>  
                    <td><div class="label arabic">  اتحادات مهنية اقليمية او دولية - حدد: </div></td>  
            </tr>
            <tr>
            	<td colspan="3"></td>
                <td><?php 
								$array_igr=array(0=>'اختر ');
								if(count($igr_data)>0){
									foreach($igr_data as $igr_item){
										$array_igr[$igr_item->id]=$igr_item->label_ar;
										
										}
										
									}
								echo form_dropdown('igr_code',$array_igr,$query['igr_code'],'style="direction:rtl"');	
							?>
                    </td>  
                    <td><div class="label arabic">  تجمع صناعي  :  </div></td>  
            </tr>
           <tr class="trhead">
            	<td colspan="5" class="thead">
                    <div class="thead english">Head Office Address : </div>
                    <div class="thead arabic">عنوان المركز الرئيسي  : </div>
                </td>
            </tr>
            <tr>
            	<td colspan="3"></td>
                <td> <?php 
							$gover=array(''=>'اختر المحافظة');
							foreach($governorates as $governorate){
								
								$gover[$governorate->id]=$governorate->label_ar.' ( '.$governorate->label_en.' )';
								}
						?>
                       <?php echo form_dropdown('governorate_id',$gover,$query['governorate_id'],$jsgov); ?>
                     </td>   
                    <td><div class="label arabic">  المحافظة : </div></td>
                </td>   
             </tr>
           
			<tr>
            	<td colspan="3"></td>
                <td> <div id="district">
                        <?php 
							$district_array=array(''=>'اختر القضاء');
							if(count($districts)>0){
							foreach($districts as $district){
								
								$district_array[$district->id]=$district->label_ar.' ( '.$district->label_en.' )';
								}
							}
						 echo form_dropdown('district_id',$district_array,$query['district_id'],$jsdis); ?></div>
                     </td>   
                    <td><div class="label arabic">  القضاء : </div></td>
                </td>   
             </tr>
             <tr>
            	<td colspan="3"></td>
                <td> <div id="area">
                        <?php 
							$area_array=array(''=>'اختر البلدة');
							if(count($areas)>0){
							foreach($areas as $area){
								
								$area_array[$area->id]=$area->label_ar.' ( '.$area->label_en.' )';
								}
							}
						 echo form_dropdown('area_id',$area_array,$query['area_id'],' class="select2"  required="required"'); ?>
                       </div>
                     </td>   
                    <td><div class="label arabic">   البلدة او المحلة : </div></td>
                </td>   
             </tr>
			<tr>
            	<td><div class="label english">Street : </div></td>
                <td><?php echo form_input($array_street_en); ?></td>
                <td></td>
                <td><?php echo form_input($array_street_ar); ?></td>
                <td> <div class="label arabic">  الشارع : </div></td>
             </tr>
             <tr>
            	<td><div class="label english">Bldg : </div></td>
                <td><?php echo form_input($array_bldg_en); ?></td>
                <td></td>
                <td><?php echo form_input($array_bldg_ar); ?></td>
                <td><div class="label arabic">  البناية : </div></td>
             </tr>
             <tr>
                <td colspan="4"><?php echo form_input($array_phone); ?></td>
                <td><div class="label arabic">  هاتف: </div></td>
             </tr>
             <tr>
                <td colspan="4"><?php echo form_input($array_fax); ?></td>
                <td><div class="label arabic">  فاكس: </div></td>
             </tr>
			<tr>
            	<td><div class="label english">P.O.Box : </div></td>
                <td><?php echo form_input($array_pobox_en); ?></td>
                <td></td>
                <td><?php echo form_input($array_pobox_ar); ?></td>
                <td> <div class="label arabic">  ص. بريد : </div></td>
            </tr>    
            <tr>
            	<td colspan="3"></td>
                <td><?php echo form_input($array_email); ?></td>
                <td><div class="label arabic"> البريد الالكتروني : </div></td>
             </tr>
             <tr>
            	<td colspan="3"></td>
                <td><?php echo form_input($array_website); ?></td>
                <td><div class="label arabic" >  الموقع الالكتروني: </div></td>
             </tr>
             <?php 
			 /*
						$x1=explode('°',$query['x_location']);
						$x2=explode("'",@$x1[1]);
						$x3=explode('"',@$x2[1]);
						
						$y1=explode('°',$query['y_location']);
						$y2=explode("'",@$y1[1]);
						$y3=explode('"',@$y2[1]);
						*/

					?>
           <tr>
            	<td><div class="label english">N Location Decimal: </div></td>
                <td><div class="data-box english"><?php echo form_input($array_x_location); ?></div>  
                </td>
                <td></td>
                <td><div class="label english">E Location Decimal: </div></td>
                <td><div class="data-box english"><?php echo form_input($array_y_location); ?></div>
                </td>   
             </tr>  
            <tr class="trhead">
            	<td colspan="5" class="thead">
                    <div class="thead english">Production Information : </div>
                    <div class="thead arabic">معلومات عن الانتاج  : </div>
                </td>
            </tr>
            <tr>
            	<td colspan="5" align="center"><?=form_textarea($array_productions);?></td>
            </tr>
            <tr>
            	<td colspan="5" align="center"><?=form_submit('save','Submit','class="btn"');?></td>
            </tr>
         </table>
         <?=form_close()?>
    </div>
    </body>
</html>