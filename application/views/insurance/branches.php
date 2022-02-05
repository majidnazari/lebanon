<style type="text/css">
.title{
	width:200px !important;
}
.text1{
	margin-left:200px !important;
}
.yellow tr, .yellow td{
    background:#9F0 !important;
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
function delete_checked()
        {
			checkboxes = document.getElementsByName('checkall');
			checkboxes.checked =true;
            document.getElementById("form_id").action = "<?=base_url().'insurances/delete_checked'?>";
			var answer = confirm("Are You Sure ?")
				if (answer){
					document.getElementById("form_id").submit();
				}
				else{
					return false
				}
            

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
                <?php if($msg!=''){ ?>
                 <div class="row-fluid">
                    <div class="span9">  
				
                        <div class="alert alert-success">               
                            <?php echo $msg;?>
                        </div> 
                        
                 </div>
                 </div>  
                 <?php } ?>    
                  <?php  echo form_open('',array('id'=>'form_id','name'=>'form1'));
						echo form_hidden('ins_id',$id);
						echo form_hidden('p','branch');
				?>        
		        <div class="row-fluid">

                    <div class="span9">  
                                      
                        <div class="head clearfix">
                            <div class="isw-grid"></div>
                            <h1>Branches & Sister Companies Abroad &nbsp;&nbsp;  (<?=count($branches)?>)
                            	<div style="float:right !important; margin-right:10px;">الفروع</div>
                                
                            </h1>
                            <a href="javascript:void(0)" onclick="delete_checked()"><h2 style="float:right; color:#FFF !important">Delete Checked</h2></a> 
                        </div>
                        <div class="block-fluid">
                            <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="checkall"/></th>                                        
                                        <th>الفرع</th>
                                        <th>Branch Name</th>
                                        <th>المحافظة</th>
                                        <th>القضاء</th>
                                        <th>البلدة</th>
                                        <th>العنوان</th>
                                        <th>Phone/Fax</th>
                                        <th>P.O.Box</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(count($branches)){
										foreach($branches as $branch){ 
										if($branch->bldg_ar!='')
										{
										$branch->bldg_ar=' - '.$branch->bldg_ar;	
										}
										if($branch->beside_ar!='')
										{
										$branch->beside_ar=' - '.$branch->beside_ar;	
										}
										if($branch->fax!='')
										{
										$branch->fax=' / '.$branch->fax;	
										}
                                            $sdate=date('Y-m-d');
                                            $css='';
                                            if( $branch->update_time >= $sdate.' 00:00:00' and $branch->update_time <= $sdate.' 23:59:59')
                                            {
                                                $css='yellow';
                                            }
										?>
                                    <tr class="<?=$css?>">
                                        <td> <input type="checkbox" id="check" name="checkbox1[]" value="<?=$branch->id?>"/></td>
                                        <td><?=anchor('insurances/branch-details/'.$branch->id,$branch->name_ar)?></td>  
                                        <td><?=anchor('insurances/branch-details/'.$branch->id,$branch->name_en)?></td>
                                        <td><?=$branch->governorate_ar?></td>
                                        <td><?=$branch->district_ar?></td>
                                        <td><?=$branch->area_ar?></td>
                                        <td style="direction:rtl">
										<?=$branch->street_ar.$branch->bldg_ar.$branch->beside_ar?></td>  
                                        <td><?=$branch->phone.$branch->fax?></td>
                                        <td><?=$branch->pobox_ar.'<br>'.$branch->pobox_ar?></td>
                                       
                                        <td nowrap="nowrap">
										<?php echo _show_delete('insurances/delete/id/'.$branch->id.'/iid/'.$query['id'].'/p/branch',$p_branches_delete);
										echo _show_edit('insurances/branch-edit/'.$branch->id,$p_branches_edit);
										
										?></td>
                                    </tr>
                                  <?php }
								  
								}
								else{
								?> 
                                    <tr>
                                        <td colspan="10" align="center"><h4>No Branch Found</h4></td>
                                    </tr> 
                                   <?php } ?>                                                                
                                </tbody>
                            </table>
                        </div>
                    </div> 
                    <?=$this->load->view('insurance/_navigation')?>                               
                </div>
                 <?=form_close()?>           
           <div class="dr"><span></span></div>           
         </div>
        </div>

