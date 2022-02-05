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
			
                <div class="page-header">
                    <h2><?=$query['name_en'].'/&nbsp;'.$query['name_ar']?></h2>
                </div>  

		        <div class="row-fluid">

                    <div class="span9">                    
                        <div class="head clearfix">
                            <div class="isw-grid"></div>
                            <h1> 
                            	<div style="float:right !important; margin-right:10px; font-size:16px !important">الوكلات الاجنبية التي تمثلها الشركة</div>
                            </h1> 
                            <?php echo _show_add('transportations/branch-create/'.$query['id'],'Add New',$p_add_branch)?>                
                        </div>
                        <div class="block-fluid">
                            <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="checkall"/></th>                                        
                                        <th>Name</th>
                                        <th>Country</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Website</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(count($branches)){
										foreach($branches as $branch){ 
										$country=$this->Address->GetCountryById($branch->country_id);
										?>
                                    <tr>
                                        <td><input type="checkbox" name="checkbox"/></td>   
                                        <td><?=$branch->name_ar.' : '.$branch->name_en?></td>  
                                        <td><?=@$country['label_ar']?></td>
                                        <td><?=$branch->phone?></td>  
                                        <td><?=$branch->email?></td>  
                                        <td><?=$branch->website?></td>  
                                        <td nowrap="nowrap">
										<?php echo _show_delete('transportations/delete/id/'.$branch->id.'/cid/'.$query['id'].'/p/branches',$p_delete_branch);
										echo _show_edit('transportations/branch-edit/'.$query['id'].'/'.$branch->id,$p_edit_branch);?></td>
                                    </tr>
                                  <?php }
								  
								}
								else{
								?> 
                                    <tr>
                                        <td colspan="7" align="center"><h3>No Branch Found</h3></td>
                                    </tr> 
                                   <?php } ?>                                                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                     <?=$this->load->view('transportation/_navigation')?>                                
                </div>
                            
           <div class="dr"><span></span></div>           
         </div>
        </div>

