<script language="javascript">
function getsection(sector_id,section_id)
	{
		$("#datasection").html("loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>parameters/items/GetDataSection",
			type: "post",
			data: "id="+sector_id+"&section_id="+section_id,
			success: function(result){
				$("#datasection").html(result);
			}
		});
	}
function getsection1(sector_id,section_id)
	{
		$("#datasection1").html("loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>parameters/items/GetDataSection1",
			type: "post",
			data: "id="+sector_id+"&section_id="+section_id,
			success: function(result){
				$("#datasection1").html(result);
			}
		});
	}
function getsection2(sector_id,section_id)
	{
		$("#datasection2").html("loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>parameters/items/GetDataSection1",
			type: "post",
			data: "id="+sector_id+"&section_id="+section_id,
			success: function(result){
				$("#datasection2").html(result);
			}
		});
	}

</script>                    

<?php 

$adescription = array(
	'name'	=> 'chapter',
	'id'	=> 'chapter',	
	'value' => $chapter,
);
if($sectionID=='')
$sectionID=0;
$class_sect=' class="validate[required]" id="sector_id" onchange="getsection(this.value,'.$sectionID.')"';
$class_sect1=' class="validate[required]"  required="required" id="sector" onchange="getsection1(this.value,0)"';
$class_sect2=' class="validate[required]"  required="required" id="sector2" onchange="getsection2(this.value,0)"';

?>

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
                        <div class="span3">Chapter (الفصل)<br /><?php echo form_input($adescription); ?></div>
                        <div class="span3">Sector (القطاع)<br /><?php 
								$array_sector[0]='All ';
								foreach($sectors as $sector)
								{
									if($sector->id!=0)
									$array_sector[$sector->id]=$sector->label_ar;	
								}
											
								echo form_dropdown('sector',$array_sector,$sectorID,$class_sect);
							?>
                        </div>

                        <div class="span3">Section (القسم)<br />
						<div id="datasection">
						<?php 
								$array_section[0]='All ';
								foreach($sections as $section)
								{
									if($section->id!=0)
									$array_section[$section->id]=$section->label_ar;	
								}
											
								echo form_dropdown('section',$array_section,$sectionID);
							?>
                            </div>
                        </div>

                        <div class="span1">Status<br /><?php $array_status=array('online'=>'Online','offline'=>'Offline');
												echo form_dropdown('status',$array_status,$status);
							?></div>
                        <div class="span2"><br /><input type="submit" name="search" value="Search" class="btn">
                        <input type="submit" name="clear" value="Clear" class="btn">
                        </div>
                    </div>                            
                </div>
				<?=form_close()?>
            </div>
        </div> 
        <div class="row-fluid">
            <div class="span12">
            <?php if($msg!=''){ ?>
              	<div class="alert alert-success">               
                    <?php echo $msg;?>
                </div> 
                <?php } ?>    
                <?php echo form_open('parameters/items/delete_checked',array('id'=>'form_id','name'=>'form1'));
						echo form_hidden('st',$st);
						echo form_hidden('p','chapter');
				?>                                
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
                     <?=_show_delete_checked('#',$p_delete)?>
                     <?=_show_add_pop('#CreateModal','Add New',TRUE)?> 
                                                       
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="checkall"/></th>
                                <th>Code</th>
                                <th width="21%">English Description</th>
                                <th width="21%">Arabic Description</th>
                                <th width="16%">Date</th>                                
                                <th>Actions</th>                                    
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
						if(count($query)>0){
						foreach($query as $row){?>
                            <tr>
                                <td><input type="checkbox" id="check" name="checkbox1[]" value="<?=$row->id?>"/></td>
                                <td><?=$row->hs_code?></td>
                                <td><?=$row->label_en?></td>
                                <td align="right" style="text-align:right !important">
								<?=$row->label_ar?></td>
                                <td><?php echo 'Create Date : '.date('d-m-Y',strtotime($row->create_time))."<br />Last Update : ".date('d-m-Y',strtotime($row->update_time))?></td>
                                <td><?php 
										echo _show_delete('parameters/items/delete/id/'.$row->id.'/p/chapter/st/'.$st,$p_delete);
										echo _show_edit_pop('#'.$row->id.'Modal',$p_edit);
										
									
								if($row->status=='online')
								echo '<span class="label label-success">Online</span>';
								else
								echo '<span class="label">Offline</span>';
							
									?>                                        
                                </td>                                    
                            </tr>
                            
                        <?php } }
						else{
								echo '<tr>
                            	<td colspan="7"><center><strong>No Data Found</strong></center></td>
                            </tr>';
							}
						
						?>    
                        </tbody>
                        <tfoot>
                        	<tr>
                            	<td colspan="7"><?=$links?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <?php echo form_close();?>
            </div>                                
        </div>            
        <div class="dr"><span></span></div>            
    </div>
</div>
<div id="CreateModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h3 id="myModalLabel">Add New Chapter</h3>
                                    </div>  
                                    <?php echo form_open_multipart('parameters/items/chapter_create',array('id'=>'validation'));
										  echo form_hidden('st',$st);
									?>      
                                    <div class="row-fluid">
                                        <div class="block-fluid">
                                        <div class="row-form clearfix">
                                                <div class="span3">Chapter Number *</div>
                                                <div class="span2"><input type="text" name="cha_nbr" required="required" /></div>
                                            </div>       
                                            <div class="row-form clearfix">
                                                <div class="span3">Title in english *:</div>
                                                <div class="span9"><input type="text" name="label_en" required="required" /></div>
                                            </div>            
                                            <div class="row-form clearfix">
                                                <div class="span3">Title in arabic *:</div>
                                                <div class="span9"><input type="text" name="label_ar" required="required" /></div>
                                            </div>            
											<div class="row-form clearfix">
                                                <div class="span3">Sector (القطاع) *:</div>
                                                <div class="span9"><?php 
												unset($array_sector[0]);
												$array_sector['']='--SELECT SECTOR--';
												echo form_dropdown('sector',$array_sector,'',$class_sect1);
							?></div>
                                            </div> 
                                            <div class="row-form clearfix">
                                                <div class="span3">Section (القسم) *:</div>
                                                <div class="span9"><div id="datasection1"><select required="required"><option value="">Select Sector first</option></select></div></div>
                                            </div>       
                                             <div class="row-form clearfix">
                                            <div class="span3">Status:</div>
                                            <div class="span4"><?php $array_status=array('online'=>'Online','offline'=>'Offline');
                                                                    echo form_dropdown('status',$array_status,'');
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