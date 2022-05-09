<style type="text/css">
.ar{
	text-align:right !important;
	direction:rtl;
}
</style>
<?php 
$array_area=array('name'=>'area','id'=>'area','value'=>$area);
$g_js='onchange="getdistricts(this.value)"';
$add_js='onchange="getdistrictsadd(this.value)"';
?>
<script language="JavaScript" type="text/JavaScript">

    function printall()
        {
			checkboxes = document.getElementsByName('checkall');
			checkboxes.checked =true;
			document.getElementById("form_id").target = "_blank";
            document.getElementById("form_id").action = "<?=base_url().'companies/printall'?>";
            document.getElementById("form_id").submit();

        }

	function getdistricts(gov_id)
	{
		$("#district").html("loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>addresses/GetDistricts",
			type: "post",
			data: "id="+gov_id,
			success: function(result){
				$("#district").html(result);
			}
		});
	}
	function getdistrictsadd(gov_id)
	{
		$("#district_add").html("loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>addresses/GetDistricts",
			type: "post",
			data: "id="+gov_id,
			success: function(result){
				$("#district_add").html(result);
			}
		});
	}
	function geteditdistricts(gov_id,itemid)
	{
		$("#district"+itemid).html("loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>addresses/GetDistricts",
			type: "post",
			data: "id="+gov_id,
			success: function(result){
				$("#district"+itemid).html(result);
			}
		});
	}
	function getarea(district_id)
	{
		$("#area").html("loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>banks/GetArea",
			type: "post",
			data: "id="+district_id,
			success: function(result){
				$("#area").html(result);
			}
		});
	}
	jQuery(function($){
   $("#app_refill_date").mask("9999-99-99");
   $("#end_date").mask("9999-99-99");
   $("#x_location").mask("99°99'99\"");
   $("#y_location").mask("99°99'99\"");
});		
</script>	
<div class="content">
	<?=$this->load->view("includes/_bread")?>
    <div class="workplace">
        <div class="page-header">
            <h1><?=$subtitle;?></h1>
        </div> 
       <div class="row-fluid">
            <div class="span12">
                 <div class="head clearfix">
                    <div class="isw-zoom"></div>
                    <h1>Search</h1>
                </div>
                <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation','method'=>'get'));
					   ?> 
                <div class="block-fluid">                        

                    <div class="row-form clearfix">
                    	<div class="span3">City <br /><?php echo form_input($array_area);?></div>
                        <div class="span3">Mohafaza<br /><?php
													$array_governorate[0]='Select Governorate ';
													foreach($governorates as $governorate)
													{
														if($governorate->id!=0)
														$array_governorate[$governorate->id]=$governorate->label_ar.' ('.$governorate->label_en.')';	
													}
																
													echo form_dropdown('gov',$array_governorate,$gov,$g_js);
						
												?></div>
                        <div class="span3">Kazaa<br />
						<div id="district">
						<?php
													$array_district[0]='Select District ';
													foreach($districts as $ditem)
													{
														if($ditem->id!=0)
														$array_district[$ditem->id]=$ditem->label_ar.' ('.$ditem->label_en.')';	
													}
																
													echo form_dropdown('district',$array_district,$district,'class="select2"');
						
												?>
                                                </div>
                                                </div>
                        
                        <div class="span3"><br /><input type="submit" name="search" value="Search" class="btn">
                        <input type="submit" name="clear" value="Clear" class="btn">
                        </div>
                    </div>                            
                </div>
				<?php echo form_close() ?>
            </div>
        </div> 
        <div class="row-fluid">
            <div class="span12">
            <?php if($msg!=''){ ?>
              	<div class="alert alert-success">               
                    <?php echo $msg;?>
                </div> 
                <?php } ?>    
                <?php // echo form_open('',array('id'=>'form_id','name'=>'form1'));?>
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?>

                    </h1>
                    <?php if($p_move_area){
                        echo '<h2 style="float:right; color:#000 !important">'.anchor('addresses/changingarea','Changing Area','style="float:right !important; color:#FFF "').'</h2>';
                    }

						echo _show_add_pop('#CreateModal','Add New',$p_add_area);
                        //echo _show_delete_checked('#',$p_delete_item)?>
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th style="text-align:center">البلدة</th>
                                <th style="text-align:center" width="15%">Area</th>
                                <th style="text-align:center" width="15%">القضاء </th>
                                <th style="text-align:center;" width="15%">المحافظة</th>
                                <th style="text-align:center;">شركات</th>
                                <th style="text-align:center;">بنوك</th>
                                <th style="text-align:center;">استيراد</th>
                                <th style="text-align:center;">نقل</th>
                                <th style="text-align:center;">تأمين</th>
                                <th style="text-align:center" width="20%">Create Date </th>
                                <th style="text-align:center" width="15%">Created By </th>
                                <th></th>                                    
                            </tr>
                        </thead>
                        <tbody> 
                        <?php 
						if(count($query)>0){
						foreach($query as $row){
							$user=$this->Administrator->GetUserById($row->user_id);
                            $companies=$this->Company->SearchCompanies('', '', '', '', '', $row->governorate_id, $row->district_id, $row->id, 0, 0,FALSE,FALSE,'');
                            $banks=$this->Bank->GetAllBanks('', '', '', '', '', $row->governorate_id, $row->district_id, $row->id, 0, 0,0);
                            $importers=$this->Importer->GetAllImporters('','','','',$row->governorate_id, $row->district_id, $row->id,0,0,0);
                            $transportations=$this->Transport->GetAllTransportations('','','','',$row->governorate_id, $row->district_id, $row->id,0,0,0);
                            $insurances=$this->Insurance->GetAllInsurances('','','','',$row->governorate_id, $row->district_id, $row->id,0,0,0);


							 if(count($user)>0)
							 {
									$createdBy=$user['fullname'].' ('.$user['username'].' )'; 
								}
							else{
									$createdBy='N/A';
								}
								?>
                            <tr>
                                <td style="text-align:center"><?=$row->label_ar?></td>
                                <td style="text-align:center"><?=$row->label_en?></td>
                                <td style="text-align:center"><?=$row->district_ar?></td>
                                <td style="text-align:center"><?=$row->governorate_ar?></td>
                                <td style="text-align:center"><?=count($companies)?></td>
                                <td style="text-align:center"><?=count($banks)?></td>
                                <td style="text-align:center"><?=count($importers)?></td>
                                <td style="text-align:center"><?=count($transportations)?></td>
                                <td style="text-align:center"><?=count($insurances)?></td>
                                <td ><?=$row->create_time?></td>
                                <td style="text-align:center"><?=$createdBy?></td>
                                
                                <td>
								
								<?php


                                echo _show_delete('addresses/delete/id/'.$row->id.'/p/area/',$p_delete_area);
										 echo _show_edit('addresses/editarea/'.$row->id,$p_edit_area);
										
									
								if($row->status=='online')
								echo '<span class="label label-success">Online</span>';
								else
								echo '<span class="label">Offline</span>';
							
									?>                                        
                                </td>                                    
                            </tr>
                            <?php if($p_edit_area){ ?>
                            <div id="<?=$row->id?>Modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h3 id="myModalLabel">Edit Area</h3>
                                    </div>  
                                    <?php 
									
									echo form_open_multipart('addresses/edit_area');
					  				echo form_hidden('id',$row->id);
									?>      
                                    <div class="row-fluid">
                                        <div class="block-fluid">
                                            <div class="row-form clearfix">
                                                <div class="span3">Title In english *:</div>
                                                <div class="span9"><input type="text" name="label_en" value="<?=$row->label_en?>" required="required" /></div>
                                                </div>
                                                <div class="row-form clearfix">
                                                <div class="span3">Title In arabic *:</div>
                                                <div class="span9"><input type="text" name="label_ar" value="<?=$row->label_ar?>" required="required" /></div>
                                            </div> 
                                            <div class="row-form clearfix">
                                                <div class="span3">Governorate *:</div>
                                                <div class="span9">
                                                <?php 
												$dists=$this->Address->GetDistrictByGov('online',$row->governorate_id);
												$js='onchange="geteditdistricts(this.value,'.$row->id.')"';
													$array_governorate[0]='Select Governorate ';
													foreach($governorates as $governorate)
													{
														if($governorate->id!=0)
														$array_governorate[$governorate->id]=$governorate->label_ar.' ('.$governorate->label_en.')';	
													}
																
													echo form_dropdown('governorate_id',$array_governorate,$row->governorate_id,$js);
						
												?></div>
                                            </div>
                                            <div class="row-form clearfix">
                                                <div class="span3">District *:</div>
                                                <div class="span9">
                                                <div id="district<?=$row->id?>">
						<?php
													$array_dist[0]='Select District ';
													foreach($dists as $dist)
													{
														if($dist->id!=0)
														$array_dist[$dist->id]=$dist->label_ar.' ('.$dist->label_en.')';	
													}
																
												//	echo form_dropdown('district',$array_dist,$row->district_id,'class="select2"');
						
												?>
                                                </div>
                                               </div>
                                            </div>
                                            <div class="row-form clearfix">
                                                <div class="span3">Status</div>                       
                                                <div class="span9"><?php $array_status=array('online'=>'Online','offline'=>'Offline');
                                                          echo form_dropdown('status',$array_status,$row->status);
                                                    ?></div>
                                            </div>           
                                          </div>                
                                        <div class="dr"><span></span></div>
                                    </div>                    
                                    <div class="modal-footer">
                                       <!-- <input type="submit" name="save" value="Save" class="btn">-->
                                        <button class="btn" name="save" onclick="return f_submit(validation);">Save</button>
                                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>            
                                    </div>
                                    <?php echo form_close();
									
									?>
        						</div>
                                  <?php }
								 
                         } }
						else{
								echo '<tr>
                            	<td colspan="12"><center><strong>No Data Found</strong></center></td>
                            </tr>';
							}
						
						?>    
                        </tbody>
                        <tfoot>
                        	<tr>
                                <td colspan="12" style="direction:ltr !important">Total : <?=$total_row?><div class="dataTables_paginate paging_full_numbers"><?=$links?></div></td></tr>
                        </tfoot>
                    </table>
                    
                </div>
                <?php // echo form_close();?>
            </div>                                
        </div>            
        <div class="dr"><span></span></div>            
    </div>
</div>
<?php if($p_add_area){ ?>
<div id="CreateModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Add New District</h3>
    </div>  
    <?php echo form_open_multipart('addresses/create_area',array('id'=>'validation'));?>      
    <div class="row-fluid">
        <div class="block-fluid">
            <div class="row-form clearfix">
                <div class="span3">Title in english *:</div>
                <div class="span9"><input type="text" name="label_en" required="required" /></div>
            </div>            
            <div class="row-form clearfix">
                <div class="span3">Title in arabic *:</div>
                <div class="span9"><input type="text" name="label_ar" required="required" /></div>
            </div>
            <div class="row-form clearfix">
                    <div class="span3">Governorate *:</div>
                    <div class="span9">
                    <?php 
                        $array_governorate[0]='Select Governorate ';
                        foreach($governorates as $governorate)
                        {
                            if($governorate->id!=0)
                            $array_governorate[$governorate->id]=$governorate->label_ar.' ('.$governorate->label_en.')';	
                        }
                                    
                        echo form_dropdown('governorate_id',$array_governorate,'',$add_js);

                    ?></div>
                </div>
                <div class="row-form clearfix">
                    <div class="span3">District *:</div>
                    <div class="span9">
                    <div id="district_add">
<?php
                        $array_[0]='Select District ';

                                    
                        echo form_dropdown('district',$array_,'','class="select2"');

                    ?>
                    </div>
                   </div>
                </div>
            <div class="row-form clearfix">
                <div class="span3">Status</div>                       
                <div class="span9"><?php $array_status=array('online'=>'Online','offline'=>'Offline');
                          echo form_dropdown('status',$array_status);
                    ?></div>
            </div>           
        </div>                
        <div class="dr"><span></span></div>
    </div>                    
    <div class="modal-footer">
        <input type="submit" name="save" value="Save" class="btn">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>            
    </div>
    <?=form_close()?>
</div>
<?php } ?>