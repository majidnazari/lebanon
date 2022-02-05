<link href="<?=base_url()?>table/style.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="<?=base_url()?>table/scripts/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>table/scripts/move.js"></script>

<?php 
$array_name_ar=array('id'=>'name_ar','name'=>'name_ar','value'=>$name_ar);
$array_name_en=array('id'=>'name_en','name'=>'name_en','value'=>$name_en);
?>
<script language="javascript">
function editports(id,name_ar,name_en)
	{
		$("#"+id+"ar").html('<input id="name_ar'+id+'" type="text" value="'+name_ar+'" name="name_ar">');
		$("#"+id+"en").html('<input id="name_en'+id+'" type="text" value="'+name_en+'" name="name_en">');
		$("#"+id+"btn").html('<a href="javascript:void(0)" class="btn" onclick="save('+id+')">Save</a>');
	}
function save(id)
	{
		var namear=$("#name_ar"+id).val();
		var nameen=$("#name_en"+id).val();
		$.ajax({
			url: "<?php echo base_url();?>transportations/editports",
			type: "post",
			data: "id="+id+"&namear="+namear+"&nameen="+nameen,
			success: function(result){
				$("#"+id+"ar").html(namear);
				$("#"+id+"en").html(nameen);
				$("#"+id+"btn").html('<a href="javascript:void(0)" onclick="editports('+id+',\''+namear+'\',\''+nameen+'\')"><i class="isb-edit"></i></a>');

			}
		});
	}
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

<div class="content">
	<?=$this->load->view("includes/_bread")?>
    <div class="workplace">
        <div class="page-header">
            <h1><?=$subtitle;?></h1>
        </div> 
        <?php if($msg!=''){ ?>
                <div class="row-fluid">
              	<div class="alert alert-success">               
                    <?php echo $msg;?>
                </div> 
                </div>
                <?php } ?>  
       <div class="row-fluid"> 
       <div class="span9">         
       <div class="row-fluid">
            <div class="span12">
                 <div class="head clearfix">
                    <div class="isw-plus"></div>
                    <h1>Add New Ports</h1>
                </div>
                <?php echo form_open_multipart($this->uri->uri_string());?> 
                <div class="block-fluid">                        
                    <div class="row-form clearfix">
                        <div class="span5">Name In Arabic<br /><?php echo form_input($array_name_ar); ?><br />
                        <font color="#FF0000"><?php echo form_error('name_ar'); ?></font></div>
                        <div class="span5">Name In English<br /><?php echo form_input($array_name_en); ?><br />
                        <font color="#FF0000"><?php echo form_error('name_en'); ?></font></div>
                        <div class="span2"><br /><input type="submit" name="add" value="Save" class="btn"></div>
                    </div>                            
                </div>
				<?=form_close()?>
            </div>
        </div> 
        <div class="row-fluid">
            <div class="span12">
            
                <?php echo form_open('',array('id'=>'form_id','name'=>'form1'));
					  echo form_hidden('transport_id',$id);
					?>   
                                          
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1>المرافئ التي تقصدها البواخر</h1>
					  <a href="javascript:void(0)" onclick="delete_checked()">
                      <h2 style="float:right; color:#FFF !important">Delete Checked</h2></a>
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table horizontal">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="checkall"/></th>
                                <th>Arabic Name</th>
                                <th width="21%">English Name</th>
                                <th width="16%">Created by</th>   
                                <th>Actions</th>                                    
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
						if(count($ports)>0){
						foreach($ports as $row){
							$user=$this->Administrator->GetUserById($row->user_id);
							?>
                            <tr>
                                <td><input type="hidden" name="ids[]" value="<?=$row->id?>" />
                                <input type="checkbox" id="check" name="checkbox1[]" value="<?=$row->id?>"/></td>
                                <td id="<?=$row->id?>ar"><?=$row->name_ar?></td>
                                <td id="<?=$row->id?>en"><?=$row->name_en?></td>
                                <td><?=@$user['username'].' ( '.@$user['fullname'].' )'?></td>
                                <td nowrap="nowrap">
                                 
                                <div id="<?=$row->id?>btn">
                                	<a href="javascript:void(0)" onclick="editports(<?=$row->id?>,'<?=$row->name_ar?>','<?=$row->name_en?>')"><i class="isb-edit"></i></a>
                                 </div>   
								<?=_show_delete('transportations/delete/id/'.$row->id.'/transportation/'.$row->transport_id.'/p/ports',$p_view_port);?>                                        
                                </td>                                    
                            </tr>
                                                        
                        <?php } }
						else{
								echo '<tr>p
                            	<td colspan="6"><center><strong>No Data Found</strong></center></td>
                            </tr>';
							}
						
						?>    
                        </tbody>
                        <tfoot>
                        	<tr>
                                <td colspan="7">Total : <?=count($ports)?></td></tr>
                        </tfoot>
                    </table>
                    
                </div>
                <?php echo form_close();?>
            </div>                                
        </div> 
        </div> 
        <?=$this->load->view('transportation/_navigation')?>       
        </div>         
        <div class="dr"><span></span></div>            
    </div>
</div>
