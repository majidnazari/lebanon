<style type="text/css">
.search{
	width:100%;
	direction:rtl;
}
.label_ar{
	font-weight:bold !important;
	text-align:right !important;
	font-size:15px !important;
}
.label_en{
	font-weight:bold !important;
	text-align:right !important;
}
</style>
<?php
$array_hs_code = array(
	'name'	=> 'hs_code',
	'id'	=> 'hs_code',
	'class'	=> 'validate[required]',	
	'value' => $hs_code,
	'style' => 'direction:rtl',
);
$array_hs_code_print = array(
	'name'	=> 'hs_code_print',
	'id'	=> 'hs_code_print',
	'class'	=> 'validate[required]',	
	'value' => $hs_code_print,
	'style' => 'direction:rtl',
);
$array_label_ar = array(
	'name'	=> 'label_ar',
	'id'	=> 'label_ar',
	'class'	=> 'validate[required]',	
	'value' => $label_ar,
	'style' => 'direction:rtl',
);
$array_label_en = array(
	'name'	=> 'label_en',
	'id'	=> 'label_en',
	'class'	=> 'validate[required]',	
	'value' => $label_en,
);
$array_description_ar = array(
	'name'	=> 'description_ar',
	'id'	=> 'description_ar',
	'value' => $description_ar,
	'style' => 'direction:rtl',
);
$array_description_en = array(
	'name'	=> 'description_en',
	'id'	=> 'description_en',
	'value' => $description_en,
);
$js='class="search"';
$array_countries=array();
foreach($countries as $country)
{
	$array_countries[$country->id]=$country->label_en;
}

?>

<link href="<?=base_url()?>css/select22.css" rel="stylesheet"/>
<script src="<?=base_url()?>js/select2.js"></script>
<script type="text/javascript">
var rowCount = 1;
function addMoreRows(frm) {
rowCount ++;
var recRow = '<tr id="rowCount'+rowCount+'"><td><input type="hidden" name="actions[]" value="add" /><input type="hidden" name="RateID[]" value="0" /><?=form_dropdown('countries[]',$array_countries,'','id="countryID"')?></td><td><input name="rate[]" id="rate'+rowCount+'" type="text" /></td><td><input name="import_lbp[]" id="import_lbp'+rowCount+'" type="text" /></td><td><input name="import_usd[]" id="import_usd'+rowCount+'" type="text"/></td><td><input name="tones_import[]" id="tones_import'+rowCount+'" type="text" /></td><td><input name="export_lbp[]" id="export_lbp'+rowCount+'" type="text" /></td><td><input name="export_usd[]" id="export_usd'+rowCount+'" type="text" /></td><td><input name="tones_export[]" id="tones_export'+rowCount+'" type="text" /></td><td><input name="year[]" id="year'+rowCount+'" type="text" /></td><td><a style="cursor:pointer" onclick="saveRate('+rowCount+',countryID'+rowCount+'.value,ratev'+rowCount+'.value,import_lbp'+rowCount+'.value,import_usd'+rowCount+'.value,tones_import'+rowCount+'.value,export_lbp'+rowCount+'.value,export_usd'+rowCount+'.value,tones_export'+rowCount+'.value,year'+rowCount+'.value)"><img src="<?=base_url()?>img/save.png" style="height:16px;" /></a><a href="javascript:void(0);" onclick="removeRow('+rowCount+');"><i class="isb-delete"></i></a></td></tr>';
jQuery('#addedRows').prepend(recRow);
}
function addRows(frm) {
rowCount ++;
var recRow = '<tr id="rowCount'+rowCount+'"><td><?=form_dropdown('countries[]',$array_countries,'','id="countryID"')?></td><td><input name="rate[]" id="rate'+rowCount+'" type="text" /></td><td><input name="import_lbp[]" id="import_lbp'+rowCount+'" type="text" /></td><td><input name="import_usd[]" id="import_usd'+rowCount+'" type="text"/></td><td><input name="tones_import[]" id="tones_import'+rowCount+'" type="text" /></td><td><input name="export_lbp[]" id="export_lbp'+rowCount+'" type="text" /></td><td><input name="export_usd[]" id="export_usd'+rowCount+'" type="text" /></td><td><input name="tones_export[]" id="tones_export'+rowCount+'" type="text" /></td><td><input name="year[]" id="year'+rowCount+'" type="text" /></td><td><a href="javascript:void(0);" onclick="removeRow('+rowCount+');"><i class="isb-delete"></i></a></td></tr>';
jQuery('#addedRows').append(recRow);
}
function editRate(id) {
	$("#rate"+id).html("Loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>items/editraterow",
			type: "post",
			data: "id="+id,
			success: function(result){
				$("#rate"+id).html(result);
			}
		});
}
function saveRate(id,countryID,rate,import_lbp,import_usd,tones_import,export_lbp,export_usd,tones_export,year) {
	$("#rate"+id).html("Loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>items/saveraterow",
			type: "post",
			data: "countryID="+countryID+"&rate="+rate+"&import_lbp="+import_lbp+"&import_usd="+import_usd+"&tones_import="+tones_import+"&export_lbp="+export_lbp+"&export_usd="+export_usd+"&tones_export="+tones_export+"&year="+year,
			success: function(result){
				$("#rate"+id).html(result);
			}
		});
}
function updateRate(id,countryID,rate,import_lbp,import_usd,tones_import,export_lbp,export_usd,tones_export,year) {
	$("#rate"+id).html("Loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>items/updateraterow",
			type: "post",
			data: "id="+id+"&countryID="+countryID+"&rate="+rate+"&import_lbp="+import_lbp+"&import_usd="+import_usd+"&tones_import="+tones_import+"&export_lbp="+export_lbp+"&export_usd="+export_usd+"&tones_export="+tones_export+"&year="+year,
			success: function(result){
				$("#rate"+id).html(result);
			}
		});
}

function removeRow(removeNum) {
jQuery('#rowCount'+removeNum).remove();
}

function removeRate(id)
	{
		
		$("#rate"+id).html("Deleting ... ");
		$.ajax({
			url: "<?php echo base_url();?>items/removerate",
			type: "post",
			data: "id="+id,
			success: function(result){
				$("#rate"+id).html(result);
			}
		});
	}
	$(document).ready(function() {
		$(".search").select2();   
	});
	jQuery(function($){
   //$("#hs_code_print").mask("99.99.99.99");
   //$("#hs_code").mask("99.99.99.99.99");
});		
</script>
<div class="content">
   <?=$this->load->view("includes/_bread")?>         
    <div class="workplace">
        <div class="page-header">
            <h1><?=$subtitle?></h1>
        </div>                  
        <div class="row-fluid">
        <?php if($nav){ 
				$span='span9';
				//$navigation=$this->load->view('items/_navigation');
				}
			else{
				$span='span12';
				//$navigation='';
				}
		?>
        <div class="<?=$span?>">
                 <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Items</h1>
                    <h1 style="float:right; margin-right:10px"></h1>
                </div> 
                 <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation'));
          			  echo form_hidden('id',@$id); 
		 		 ?>               
				<div class="block-fluid"> 
                        
                    <div class="row-form clearfix">
                        
                        <?php 
							$array_subhead=array(0=>'اختر جزء الرمز');
							foreach($subhead as $row){
								
								$array_subhead[$row->id]=$row->title_ar;
								}
						?>
                        <div class="span10"><?php echo form_dropdown('subhead_id',$array_subhead,$subhead_id,$js); ?>
                        <font color="#FF0000"><?php echo form_error('subhead_id'); ?></font></div>
                        <div class="span2 label_ar">جزء الرمز</div>
                     </div>  
                     <div class="row-form clearfix"> 
                       <div class="span10">
                        <?php 
							$array_chapters=array();
							if(count($chapters)>0){
							foreach($chapters as $chapter){
								
								$array_chapters[$chapter->id]=$chapter->label_ar;
								}
							}
						 echo form_dropdown('chapter_id',$array_chapters,$chapter_id,'class="search"'); ?>
                        <font color="#FF0000"><?php echo form_error('chapter_id'); ?></font></div>
                        <div class="span2 label_ar" class="">:  الفصل</div>
                     </div>   
                    <div class="row-form clearfix">  
                        <div class="span8"></div>
                        <div class="span2">
							<?php echo form_input($array_hs_code); ?>
                        	<font color="#FF0000"><?php echo form_error('hs_code'); ?></font>				
                        </div>
                        <div class="span2 label_ar">:  الرمز المنسق</div>
                    </div> 
                    <div class="row-form clearfix">  
                         <div class="span8"></div>
                         <div class="span2">
							<?php echo form_input($array_hs_code_print); ?>
                        	<font color="#FF0000"><?php echo form_error('hs_code_print'); ?></font>				
                        </div>
                        <div class="span2 label_ar">:  الرمز المنسق الاصلي</div>
                    </div>  
                    <div class="row-form clearfix">    
                        <div class="span10"><?php echo form_input($array_label_ar); ?>
                        <font color="#FF0000"><?php echo form_error('label_ar'); ?></font></div>
                        <div class="span2 label_ar"> :الصنف</div>
                    </div>                                                      
                    <div class="row-form clearfix">
                       
                        <div class="span10"><?php echo form_input($array_label_en); ?>
                        <font color="#FF0000"><?php echo form_error('label_en'); ?></font></div>
                        <div class="span2 label_en"> : Item</div>
                    </div>      
                    <div class="row-form clearfix">  
                        <div class="span10" style="text-align:right"><?php echo form_input($array_description_ar); ?>
                        <font color="#FF0000"><?php echo form_error('description_ar'); ?></font></div>
                        <div class="span2 label_ar"> : الوصف الخاص </div>
                    </div>             
					<div class="row-form clearfix">                       
                        <div class="span10"><?php echo form_input($array_description_en); ?>
                        <font color="#FF0000"><?php echo form_error('description_en'); ?></font></div>
                        <div class="span2 label_en">: Special description</div>
                    </div>
                    <div class="row-form clearfix">
                    	<div class="span8"></div>                       
                        <div class="span2"><?php $array_status=array('online'=>'Online','offline'=>'Offline');
								  echo form_dropdown('status',$array_status,$status);
							?></div>
                        <div class="span2 label_en">: Status</div>
                    </div>
                    <div class="row-form clearfix">
                    	<div class="span12">                    
                        <div class="head clearfix">
                            <div class="isw-grid"></div>
                            <h1>Rating</h1>
                            <ul class="buttons">
                            	<?php if($nav){ ?>
                                <li><a class="isw-plus" style="cursor:pointer" onclick="addMoreRows(this.form);"></a></li>
                                 <!--<li><a  style="cursor:pointer" class="isw-edit"></a></li>
                                <li><a  style="cursor:pointer" class="isw-delete"></a></li>-->
                                <?php }
								else{
									?>
                                <li><a class="isw-plus" style="cursor:pointer" onclick="addRows(this.form);"></a></li>
							<?php	} ?>
                               
                            </ul>                        
                        </div>
                        <div class="block-fluid">
                            <table rules="all" cellpadding="0" cellspacing="0" width="100%" class="table">
                                <thead>
                                    <tr>                                    
                                        <th>Country</th>
                                        <th>Rate</th>
                                        <th>Import LBP</th>
                                        <th>Import USD</th>
                                        <th>Tones Import</th>
                                        <th>Export LBP</th>
                                        <th>Export USD</th>
                                        <th>Tones Export</th>
                                        <th>Year</th>
                                        <th>Actions</th>                                   
                                    </tr>
                                </thead>
                                <tbody id="addedRows">
                                	<?php 
									if(count($rates)>0){
									foreach($rates as $rate){ ?>
                                    <tr id="rate<?=$rate->id?>">                                    
                                        <td><?=$rate->country_en?></td>
                                        <td><?=$rate->rate?></td>
                                        <td><?=$rate->import_lbp?></td>
                                        <td><?=$rate->import_usd?></td>    
                                        <td><?=$rate->tones_import?></td>    
                                        <td><?=$rate->export_lbp?></td>    
                                        <td><?=$rate->export_usd?></td>
                                        <td><?=$rate->tones_export?></td>
                                        <td><?=$rate->year?></td>
                                        <td><?=_show_delete('items/delete/id/'.$rate->id.'/item/'.$id.'/p/rate',TRUE)?>
                                        	<a  style="cursor:pointer" onclick="editRate(<?=$rate->id?>)"><i class="isb-edit"></i></a>
                                        </td>                                    
                                    </tr>
                                    <?php } 
									}?>
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                    </div>
                    <div class="row-form clearfix">  
                    	<div class="span5"></div>                     
                        <div class="span2">
                        	<?php 
							$array_action=array('view'=>'Save & View','add'=>'Save & Insert another new');
							$selectI='';
							if(@$id!=''){
								$array_action['edit']='Save & Edit next Item';
								$selectI='edit';
								}
							
								  echo form_dropdown('action',$array_action,$selectI);
							?>
                       </div>
                        <div class="span2"><input type="submit" name="save" value="Save" class="btn"/>
                        					<?php
                                            if($nav){
											echo anchor('items/edit/'.$id,'Cancel',array('class'=>'btn'));
											}
											else{
												echo anchor($_SERVER['HTTP_REFERER'],'Cancel',array('class'=>'btn'));
												}
											?>
                        </div>
                        <div class="span5"></div>
                    </div>                   
				</div>
                <?=form_close()?>   
                         
            </div>
            
        	<?php if($nav){ 
				echo $this->load->view('items/_navigation');
				}
			
		?>
    </div>
    </div>
</div>