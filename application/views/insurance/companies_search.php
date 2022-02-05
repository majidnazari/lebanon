<script language="javascript">
function printpage(url)
{
for (var i = 2; i < 9; i++) {
  child = window.open(url+'/'+i, "", "height=1px, width=1px");  //Open the child in a tiny window.
  window.focus();  //Hide the child as soon as it is opened.
  child.print();  //Print the child.
  child.close();  //Immediately close the child.
}
}
</script>                    

<?php 
$array_name=array('id'=>'name','name'=>'name','value'=>$name);
$array_id=array('id'=>'id','name'=>'id','value'=>$id);

$array_phone=array('id'=>'phone','name'=>'phone','value'=>$phone);

$array_activity=array('id'=>'activity','name'=>'activity','value'=>$activity);

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
                        <div class="span2">ID : <br /><?php echo form_input($array_id); ?>
                        </div>

                        <div class="span3">Company Name (اسم الشركة)
						<br /><?php echo form_input($array_name); ?>
                        </div>

                        <div class="span2">Activity<br /><?php echo form_input($array_activity); ?></div>
                        <div class="span2">Phone<br /><?php echo form_input($array_phone); ?></div>
                        <div class="span3"><br /><input type="submit" name="search" value="Search" class="btn">
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
                <?php echo form_open('',array('id'=>'form_id','name'=>'form1'));
						echo form_hidden('st',$st);
						echo form_hidden('p','chapter');
				?>   
                                          
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
                   
                     <?=_show_delete_checked('#',$p_delete)?>
                     <?=_show_add_pop('#CreateModal','Add New',TRUE)?> 
                     <a href="javascript:void(0)" onclick="printall()"><h3 style="float:right !important">Print Selected</h3></a>
                      
                                                       
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="checkall"/></th>
                                <th style="text-align:center">اسم الشركة</th>
                                <th style="text-align:center" width="21%">اسم المسؤول</th>
                                <th style="text-align:center" width="21%">هاتف</th>
                                <th style="text-align:center" width="16%">معلن</th>                                
                                <th>Actions</th>                                    
                            </tr>
                        </thead>
                        <tbody> 
                        <?php 
						if(count($query)>0){
						foreach($query as $row){
							$sector=$this->Item->GetSectorById($row->sector_id);
							$type=$this->Company->GetCompanyTypeById($row->company_type_id);
							?>
                            <tr>
                                <td><input type="checkbox" id="check" name="checkbox1[]" value="<?=$row->id?>"/></td>
                                <td><?=anchor('companies/details/'.$row->id,$row->name_ar.'<br>'.$row->name_en)?></td>
                                <td><?=$row->owner_name.'<br>'.$row->owner_name_en?></td>
                                <td>
                                	<?php 
									/*
									if(count($sector)>0){
										echo $sector['label_en'].'<br>'.$sector['label_ar'];
										}
									else{
										echo 'N/A';
										}
										*/
										echo $row->phone;
										?>	
                                </td>
                                <td><?php 
								/*
									if(count($type)>0){
										echo $type['label_en'].'<br>'.$type['label_ar'];
										}
									else{
										echo 'N/A';
										}
										*/
										if($row->is_adv==1){
										echo 'Yes';
										}
										else{
											echo 'No';
											}
										?></td>
                                <td>
								
								<?php 
										echo anchor('companies/view/'.$row->id,'<span class="isb-print"></span>',array('target'=>'_blank'));
										echo _show_delete('parameters/items/delete/id/'.$row->id.'/p/chapter/st/'.$st,$p_delete);
										echo _show_edit('companies/edit/'.$row->id,$p_edit);
										
									
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
                                <td colspan="7">Total : <?=$total_row?><div class="dataTables_paginate paging_full_numbers"><?=$links?></div></td></tr>
                        </tfoot>
                    </table>
                    
                </div>
                <?php echo form_close();?>
            </div>                                
        </div>            
        <div class="dr"><span></span></div>            
    </div>
</div>
