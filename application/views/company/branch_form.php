<?php
/********************General Info**********************/
/*
$array_name_ar=array('id'=>'name_ar','name'=>'name_ar','value'=>@$row['name_ar'],'class'=>'label-ar','tabindex'=>1,'required'=>'required');
$array_name_en=array('id'=>'name_en','name'=>'name_en','value'=>@$row['name_en'],'tabindex'=>2,'required'=>'required');

*/
/*********************Address*************************/
$array_street_ar=array('id'=>'street_ar','name'=>'street_ar','value'=>@$row['street_ar'],'class'=>'label-ar');
$array_street_en=array('id'=>'street_en','name'=>'street_en','value'=>@$row['street_en']);

$array_bldg_ar=array('id'=>'bldg_ar','name'=>'bldg_ar','value'=>@$row['bldg_ar'],'class'=>'label-ar');
$array_bldg_en=array('id'=>'bldg_en','name'=>'bldg_en','value'=>@$row['bldg_en']);

$array_fax=array('id'=>'fax','name'=>'fax','value'=>@$row['fax']);
$array_phone=array('id'=>'phone','name'=>'phone','value'=>@$row['phone']);
$array_whatsapp=array('id'=>'whatsapp','name'=>'whatsapp','value'=>@$row['whatsapp']);

$array_pobox_ar=array('id'=>'pobox_ar','name'=>'pobox_ar','value'=>@$row['pobox_ar'],'class'=>'label-ar','style'=>'direction:rtl');
$array_pobox_en=array('id'=>'pobox_en','name'=>'pobox_en','value'=>@$row['pobox_en']);

$array_beside_ar=array('id'=>'beside_ar','name'=>'beside_ar','value'=>@$row['beside_ar'],'class'=>'label-ar');
$array_beside_en=array('id'=>'beside_en','name'=>'beside_en','value'=>@$row['beside_en']);

$array_email=array('id'=>'email','name'=>'email','value'=>(@$row['email']) ? @$row['email'] : $query['email']);
$array_website=array('id'=>'website','name'=>'website','value'=>(@$row['website']) ? @$row['website'] : $query['website']);
$array_x_location=array('id'=>'x_location','name'=>'x_location','value'=>@$row['x_location']);
$array_y_location=array('id'=>'y_location','name'=>'y_location','value'=>@$row['y_location']);

?>
<script language="javascript">
	function getdistricts(gov_id)
	{
		$("#district").html("loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>companies/GetDistricts",
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
			url: "<?php echo base_url();?>companies/GetArea",
			type: "post",
			data: "id="+district_id,
			success: function(result){
				$("#area").html(result);
			}
		});
	}
	jQuery(function($){
  $("#x_location").mask("99°99'99.99\"");
   $("#y_location").mask("99°99'99.99\"");
});		
</script>		
<?php
$jsgov='id="gov_id" onchange="getdistricts(this.value)"';
$jsdis='id="district_id" onchange="getarea(this.value)"';
?>

<style type="text/css">
select{
	direction:rtl !important;
	}
.label-ar{
	text-align:right !important;
	font-size:15px !important;
	font-weight:bold;
}	
</style>

<div class="content">
   <?=$this->load->view("includes/_bread")?>  
    <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation')); 
			echo form_hidden('company_id',$id);
	?>             
    <div class="workplace">
        <div class="page-header">
            <h1><?=$subtitle?>
                <input type="submit" name="save" value="Save" class="btn btn-large" style="float:right !important">
                &nbsp;
                <?=anchor('companies/branches/'.$id,'Cancel',array('class'=>'btn btn-large','style'=>'float:right !important; margin-right:10px'))?>
            </h1>
        </div> 
		               
        <div class="row-fluid">
        <div class="span9">
                 <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Branch Info</h1>
                    <h1 style="float:right; margin-right:10px"> عنوان الفرع</h1>
                </div>   
                <?php /*
				<div class="block-fluid">
                    <div class="row-form clearfix">    
                    	<div class="span1">Name : </div>
                        <div class="span5"><?php echo form_input($array_name_en); ?>
                        <font color="#FF0000"><?php echo form_error('name_en'); ?></font></div>
                        <div class="span5" style="text-align:right"><?php echo form_input($array_name_ar); ?>
                        <font color="#FF0000"><?php echo form_error('name_ar'); ?></font></div>
                        <div class="span1 label-ar"> :   الاسم</div>

                    </div>
                    */?>
                    <div class="block-fluid">
                    <div class="row-form clearfix">
                    <div class="span3">
                        <div id="area">
                        <?php 
							$area_array=array();
							if(count($areas)>0){
							foreach($areas as $area){
								
								$area_array[$area->id]=$area->label_en.' ( '.$area->label_ar.' )';
								}
							}
						 echo form_dropdown('area_id',$area_array,@$row['area_id'],''); ?>
                        <font color="#FF0000"><?php echo form_error('district_id'); ?></font></div>
                        </div>
                        <div class="span1 label-ar">البلدة</div>
                    <div class="span3">
                        <div id="district">
                        <?php 
							$district_array=array();
							if(count($districts)>0){
							foreach($districts as $district){
								
								$district_array[$district->id]=$district->label_en.' ( '.$district->label_ar.' )';
								}
							}
						 echo form_dropdown('district_id',$district_array,@$row['district_id'],$jsdis); ?>
                        <font color="#FF0000"><?php echo form_error('district_id'); ?></font></div>
                        </div>
                        <div class="span1 label-ar">  القضاء</div>

                        <?php 
							$gover=array(0=>'اختر المحافظة');
							foreach($governorates as $governorate){
								
								$gover[$governorate->id]=$governorate->label_en.' ( '.$governorate->label_ar.' )';
								}
						?>
                        <div class="span3"><?php echo form_dropdown('governorate_id',$gover,@$row['governorate_id'],$jsgov); ?>
                        <font color="#FF0000"><?php echo form_error('governorate_id'); ?></font></div>
                        <div class="span1 label-ar"> المحافظة</div>
                     </div>  
                     <div class="row-form clearfix">    
                    	<div class="span1">Street : </div>
                        <div class="span5"><?php echo form_input($array_street_en); ?>
                        <font color="#FF0000"><?php echo form_error('street_en'); ?></font></div>
                        <div class="span5" style="text-align:right"><?php echo form_input($array_street_ar); ?>
                        <font color="#FF0000"><?php echo form_error('street_ar'); ?></font></div>
                        <div class="span1 label-ar"> :   شارع</div>
                    </div>
                   
                    <div class="row-form clearfix">    
                    	<div class="span1">Building: </div>
                        <div class="span5"><?php echo form_input($array_bldg_en); ?>
                        <font color="#FF0000"><?php echo form_error('bldg_en'); ?></font></div>
                        <div class="span5" style="text-align:right"><?php echo form_input($array_bldg_ar); ?>
                        <font color="#FF0000"><?php echo form_error('bldg_ar'); ?></font></div>
                        <div class="span1 label-ar"> : بناية </div>

                    </div>   
                    <?php /*
                     <div class="row-form clearfix">    
                    	<div class="span1">Manager : </div>
                        <div class="span5"><?php echo form_input($array_beside_en); ?>
                        <font color="#FF0000"><?php echo form_error('beside_en'); ?></font></div>
                        <div class="span5" style="text-align:right"><?php echo form_input($array_beside_ar); ?>
                        <font color="#FF0000"><?php echo form_error('beside_ar'); ?></font></div>
                        <div class="span1 label-ar"> :المدير </div>

                    </div>  
                    */?>
					<div class="row-form clearfix">  
                    	<div class="span6"></div>                       
                        <div class="span5"><?php echo form_input($array_phone); ?>
                        <font color="#FF0000"><?php echo form_error('phone'); ?></font></div>
                        <div class="span1 label-ar">: هاتف</div>
                    </div>                                
					<div class="row-form clearfix">   
                    	<div class="span6"></div>                           
                        <div class="span5"><?php echo form_input($array_fax); ?>
                        <font color="#FF0000"><?php echo form_error('fax'); ?></font></div>
                        <div class="span1 label-ar">: فاكس </div>
                    </div>
                    <div class="row-form clearfix">    
                    	<div class="span2" >P.O. Box : </div>
                        <div class="span4"><?php echo form_input($array_pobox_en); ?>
                        <font color="#FF0000"><?php echo form_error('pobox_en'); ?></font></div>
                        <div class="span4" style="text-align:right"><?php echo form_input($array_pobox_ar); ?>
                        <font color="#FF0000"><?php echo form_error('bldg_ar'); ?></font></div>
                        <div class="span2 label-ar"> : صندوق بريد </div>
                    </div> 
					<div class="row-form clearfix">    
                    	<div class="span6"></div>                    
                        <div class="span4"><?php echo form_input($array_email); ?>
                        <font color="#FF0000"><?php echo form_error('email'); ?></font></div>
                        <div class="span2 label-ar">: البريد الالكتروني </div>
                    </div>
 					<div class="row-form clearfix"> 
                    	<div class="span6"></div>                        
                        <div class="span4"><?php echo form_input($array_website); ?>
                        <font color="#FF0000"><?php echo form_error('website'); ?></font></div>    
                        <div class="span2 label-ar">: الموقع الالكتروني</div>
                    </div> 
                    <?php 
						$x1=explode('°',@$query['x_location']);
						$x2=explode("'",@$x1[1]);
						$x3=explode('"',@$x2[1]);
						
						$y1=explode('°',@$query['y_location']);
						$y2=explode("'",@$y1[1]);
						$y3=explode('"',@$y2[1]);

					?>
<?php /*
					 <div class="row-form clearfix">         
                     	<div class="span1">N-Location</div>                 
                        <div class="span4"><?php echo form_input(array('name'=>'x1','value'=>@$x1[0],'style'=>'width:25%')).'° '.form_input(array('name'=>'x2','value'=>@$x2[0],'style'=>'width:25%'))."' ".form_input(array('name'=>'x3','value'=>@$x3[0],'style'=>'width:25%')).'"'; ?>
                        <font color="#FF0000"><?php echo form_error('x_location'); ?></font></div>
                        <div class="span2"></div>
                        <div class="span1">E-Location</div>                 
                        <div class="span4"><?php echo form_input(array('name'=>'y1','value'=>@$y1[0],'style'=>'width:25%')).'° '.form_input(array('name'=>'y2','value'=>@$y2[0],'style'=>'width:25%'))."' ".form_input(array('name'=>'y3','value'=>@$y3[0],'style'=>'width:25%')).'"'; ?>
                        <font color="#FF0000"><?php echo form_error('y_location'); ?></font></div>    
                    </div>
 */?>
                    <div class="row-form clearfix">   
                    	<center><input type="submit" name="save" value="Save" class="btn btn-large"/>
                		&nbsp;<?=anchor('companies/branches/'.$id,'Cancel',array('class'=>'btn btn-large','style'=>''))?></center>
                    </div>                                       
                    </div>            
                  
            </div>
            <?=$this->load->view('company/_navigation')?>
    </div>
    <?=form_close()?>
</div>