<script language="javascript">

  $(function() {
	  $( "#from" ).datepicker({
		  dateFormat: "yy-mm-dd"
		});
	$( "#to" ).datepicker({
		  dateFormat: "yy-mm-dd"
		});	
	})	
  
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
                        <div class="span3">From : <br /><?php echo form_input(array('name'=>'from','value'=>@$from,'id'=>'from')); ?>
                        </div>

                        <div class="span3">To :
						<br /><?php echo form_input(array('name'=>'to','value'=>@$to,'id'=>'to')); ?>
                        </div>

                         <div class="span3">Action<br />
						 		<?php 
									$array_users=array(''=>'All');
									if(count($users)>0)
									{
										foreach($users as $useri)
										{
											$array_users[$useri->id]=$useri->fullname.' ('.$useri->username.' )';		
										}
										
									}
									echo form_dropdown('user',$array_users,@$user);
							?></div>
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
                <?php echo form_open('',array('id'=>'form_id','name'=>'form1'));?>   
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
                        <ul class="buttons">
                           <li><?=_show_delete_checked('#',$p_delete_company)?></li>
                        </ul>                                      
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="checkall"/></th>
                                <th style="text-align:center">Action</th>
                                <th style="text-align:center">اسم الشركة</th>
                                <th style="text-align:center" width="21%">Date</th>
                                <th style="text-align:center" width="21%">Created By</th>
                                <th>Actions</th>                                    
                            </tr>
                        </thead>
                        <tbody> 
                        <?php 
						if(count($query)>0){
						foreach($query as $row){
							$array_data=json_decode($row->details);
							if(count($array_data)>0){
							if($row->action=='delete'){
							
							?>
                            <tr>
                                <td><input type="checkbox" id="check" name="checkbox1[]" value="<?=$row->id?>"/><?=$array_data->id?></td>
                                <td><?=ucfirst($row->action)?></td>
                                <td><?=anchor('logs/company-details/'.$row->id,@$array_data->name_ar.'<br>'.@$array_data->name_en,array('target'=>'_blank'))?></td>
                                
                                <td><?=$row->create_time?></td>
                                <td><?=$row->fullname.' ('.$row->username.' )'?></td>
                                <td>
								<?php 
										echo _show_delete('logs/delete/id/'.$row->id.'/p/company/',$p_delete_company);
										if($p_restore_company)
										echo anchor('logs/restore/id/'.$row->id.'/p/company','<i class="isb-left_circle"></i>',array('title'=>'Restore'));
									?>                                        
                                </td>                                    
                            </tr>
                            
                        <?php 
						
						}
						elseif($row->action=='edit'){
							
							?>
                            <tr>
                                <td><input type="checkbox" id="check" name="checkbox1[]" value="<?=$row->id?>"/><?=$row->company_id?></td>
                                <td><?=ucfirst($row->action)?></td>
                                <td><?php 
									echo '<table style="width:100%">';
									echo '<tr><th>Field</th><th>Old Value</th><th>New Value</th></tr>';
									foreach($array_data as $key=>$value){
										if($key!='update_time')
										echo '<tr><td>'.$key.'</td><td>'.$value->old.'</td><td>'.$value->new.'</td></tr>'; 
									}
									echo '</table>';
										?></td>
                                
                                <td><?=$row->create_time?></td>
                                <td><?=$row->fullname.' ('.$row->username.' )'?></td>
                                <td>
								<?php 
									echo _show_delete('logs/delete/id/'.$row->id.'/p/company/',$p_delete_company);
										
									?>                                        
                                </td>                                    
                            </tr>
                            
                        <?php  
									}
								}
							}
						}
						
						else{
								echo '<tr>
                            	<td colspan="5"><center><strong>No Data Found</strong></center></td>
                            </tr>';
							}
						
						?>    
                        </tbody>
                        <tfoot>
                        	<tr>
                                <td colspan="6">Total : <?=@$total_row?><div class="dataTables_paginate paging_full_numbers"><?=@$links?></div></td></tr>
                        </tfoot>
                    </table>
                    
                </div>
                <?php echo form_close();?>
            </div>                                
        </div>            
        <div class="dr"><span></span></div>            
    </div>
</div>
