<script language="javascript">
function getsection(sector_id,section_id)
	{
		$("#datasection").html("loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>reports/GetSections/"+sector_id+"/"+section_id,
			type: "post",
			data: "id="+sector_id+"&section_id="+section_id,
			success: function(result){
				$("#datasection").html(result);
			}
		});
	}
function getchapter(section_id)
	{
		$("#datachapter").html("loading ... ");
	//	var sector_id=$("#sector").val();
		$.ajax({
			url: "<?php echo base_url();?>reports/GetChapters/"+section_id,
			type: "post",
			data: "id="+section_id,
			success: function(result){
				$("#datachapter").html(result);
			}
		});
	}

</script>                    
<?php 
$class_sect=' class="validate[required]"  required="required" id="sector" onchange="getsection(this.value,'.$section_id.')"';
$class_chap=' class="validate[required]"  required="required" id="section" onchange="getchapter(this.value,'.$chapter_id.')"';

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
					  echo form_hidden('lang','ar');
					   ?> 
                <div class="block-fluid">                        
                    <div class="row-form clearfix">
                        <div class="span3">Sector (القطاع)<br /><?php 
								$array_sector[0]='All ';
								foreach($sectors as $sector)
								{
									if($sector->id!=0)
									$array_sector[$sector->id]=$sector->label_ar;	
								}
											
								echo form_dropdown('sector',$array_sector,$sector_id,$class_sect);
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
											
								echo form_dropdown('section',$array_section,$section_id,$class_chap);
							?>
                            </div>
                        </div>
                        <div class="span3">Chapter (الفصل)<br />
						<div id="datachapter">
						<?php 
								$array_chapter[0]='All ';
								foreach($chapters as $chapter)
								{
									if($chapter->id!=0)
									$array_chapter[$chapter->id]=$chapter->label_ar;	
								}
											
								echo form_dropdown('chapter',$array_chapter,$chapter_id);
							?>
                            </div>
                        </div>
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
                <?php echo form_open('',array('id'=>'form_id','name'=>'form1'));?>   
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
					 <?php 
				echo anchor('reports/companies/en','<h3 style="float:right !important; color:#FFF !important"> - English  </h3>');
			   echo anchor('reports/export_company/ar','<h3 style="float:right !important; color:#FFF !important">Export To Excel</h3>');
        ?>                                  
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th>البريد اللكتروني</th>
                                <th>ص.ب</th>
                                <th>فاكس</th>
                                <th>هاتف</th>
                                <th>الشارع</th>
                                <th>المدينة</th>
                                <th>قضاء</th>
                                <th>الشركة</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
						//echo '<pre>';
						//var_dump($query);
						//echo '</pre>';
							
						if(count($query)>0){
							$i=1;
						$sector_temp='';
						$section_temp='';
						$chapter_temp='';
						$heading_temp='';
						foreach($query as $row){
							if($row->sector_ar!=$sector_temp)
							{
								$sector_temp=$row->sector_ar;
							?>
                            <tr>
                            	<td colspan="9" align="center"><center><h3><?=$sector_temp?></h3></center></td>
                            </tr>
                            <?php }
							 if($row->section_ar!=$section_temp)
							{
								$section_temp=$row->section_ar;
							?>
                            <tr>
                            	<td colspan="9" align="center"><center><?=$section_temp?></center></td>
                            </tr>
                            <?php }
							 if($row->chapter_ar!=$chapter_temp)
							{
								$chapter_temp=$row->chapter_ar;
							?>
                            <tr>
                            	<td colspan="9" align="center"><center><?=$chapter_temp?></center></td>
                            </tr>
                            <?php }
							 if($row->heading_ar!=$heading_temp and $row->heading_ar!='')
							{
								$heading_temp=$row->heading_ar;
							?>
                            <tr>
                            	<td colspan="9" align="right" style="text-align:right !important; font-weight:bold !important" dir="rtl">البند الجمركي  : <?=$row->hs_code?> <?=$heading_temp?></td>
                            </tr>
                            <?php }
							 
							 ?>
                            <tr>
                                <td style="text-align:right"><?=$row->hs_code?><?=$row->email?></td>
                                <td style="direction:rtl !important; text-align:right !important"><?=$row->pobox_ar?></td>
                                <td style="text-align:right"><?=$row->fax?></td>
                                <td style="text-align:right"><?=$row->phone?></td>
                                <td style="direction:rtl !important; text-align:right !important"><?=$row->street_ar?></td>
                                <td style="text-align:right"><?=$row->area_ar?></td>
                                <td style="text-align:right"><?=$row->district_ar?></td>
                                <td style="direction:rtl !important; text-align:right !important"><?=$row->name_ar?></td>
                                <td><?=$i?></td>
                            </tr>
                            
                        <?php 
						$i++;
						} }
						else{
								echo '<tr>
                            	<td colspan="9"><center><strong>No Data Found</strong></center></td>
                            </tr>';
							}
						
						?>    
                        </tbody>
                        <tfoot>
                        	<tr>
                                <td colspan="9">
                                <?php if(count($query)>0){ ?>
                                Total : <?=count($query)?>
                                <?php } ?>
                                </td></tr>
                        </tfoot>
                    </table>
                    
                </div>
                <?php echo form_close();?>
            </div>                                
        </div>            
        <div class="dr"><span></span></div>            
    </div>
</div>
