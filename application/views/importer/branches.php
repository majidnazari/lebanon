<style type="text/css">
.title{
	width:200px !important;
}
.text1{
	margin-left:200px !important;
}
</style>

<script language="javascript">
	function displayitem(id)
	{
		$("#item").html("loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>companies/DisplayBank",
			type: "post",
			data: "id="+id,
			success: function(result){
				$("#item").html(result);
			}
		});
	}	
</script>		
<?php 
$heading_option='id="heading_id" onchange="displayitem(this.value)" style="width:300px"';
$jsdis='id="district_id" onchange="getarea(this.value)"';
?>
<link href="<?=base_url()?>css/select22.css" rel="stylesheet"/>
    <script src="<?=base_url()?>js/select2.js"></script>
    <script>
        $(document).ready(function() {
            $("#heading_id").select2();   
        });
    </script>
<div class="content">
	<?=$this->load->view("includes/_bread")?>
    
            <div class="workplace">
			<div class="row-fluid">
                <?=$this->load->view('insurance/_navigation')?>
                </div>   
                         
                <div class="page-header">
                    <h2><?=$query['name_en'].'/&nbsp;'.$query['name_ar']?></h2>
                </div>  

		        <div class="row-fluid">

                    <div class="span12">                    
                        <div class="head clearfix">
                            <div class="isw-grid"></div>
                            <h1>Branches & Sister Companies Abroad &nbsp;&nbsp; 
                            	<div style="float:right !important; margin-right:10px;">(المصارف)</div>
                            </h1> 
                            <?php //_show_add('companies/production-create/'.$query['id'],'Add New',TRUE)?>                
                        </div>
                        <div class="block-fluid">
                            <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="checkall"/></th>                                        
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Phone/Fax</th>
                                        <th>P.O.Box</th>
                                        <th>Phone/Fax</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(count($branches)){
										foreach($branches as $branch){ ?>
                                    <tr>
                                        <td><input type="checkbox" name="checkbox"/></td>   
                                        <td><?=$branch->name_ar?></td>  
                                        <td><?=$branch->name_en?></td>
                                        <td style="text-align:right"><?=$branch->id?></td>  
                                        <td nowrap="nowrap"><?php echo _show_delete('companies/delete/id/'.$branch->id.'/cid/'.$query['id'].'/p/banks',$p_delete);
										echo _show_edit('companies/banks/'.$query['id'].'/'.$branch->id,$p_delete);?></td>
                                    </tr>
                                  <?php }
								  
								}
								else{
								?> 
                                    <tr>
                                        <td colspan="4" align="center"><h3>No Bank Found</h3></td>
                                    </tr> 
                                   <?php } ?>                                                                
                                </tbody>
                            </table>
                        </div>
                    </div>                                
                </div>
                            
           <div class="dr"><span></span></div>           
         </div>
        </div>

