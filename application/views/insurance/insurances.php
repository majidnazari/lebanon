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
			url: "<?php echo base_url();?>companies/DisplayInsurance",
			type: "post",
			data: "id="+id,
			success: function(result){
				$("#item").html(result);
			}
		});
	}	
</script>		
<?php 
$heading_option='id="heading_id" onchange="displayitem(this.value)" style="width:100% !important"';
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
                <?=$this->load->view('_company_navigation')?>
                </div>   
                         
                <div class="page-header">
                    <h2><?=$query['name_en'].'/&nbsp;'.$query['name_ar']?></h2>
                </div>  

		 <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation'));
          echo form_hidden('c_id',$c_id);
		   echo form_hidden('action',$action);
		   ?>                     
        <div class="row-fluid">
            <div class="span12">
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1><?=$subtitle?></h1>
                </div>
                <div class="block-fluid">
					<div class="row-form clearfix">
                        <div class="span3">Insurance Company (شركة التأمين):</div>
                        <div class="span8">
                        <?php 
							$item_array=array(''=>'Select Insurance Company');
							foreach($items as $item){
								
								$item_array[$item->id]=$item->name_ar.' ( '.$item->name_en.' )';
								}
							echo form_dropdown('insurance_id',$item_array,$insurance_id,$heading_option);	
						?>
                        </div>
                    </div>                 
					<div class="row-form clearfix">
                        <div class="span3">Details:</div>
                        <div class="span9"><div id="item"><?=$display?></div></div>
                    </div> 
                    <div class="footer tar">
                    	<center><input type="submit" name="save" value="Save" class="btn">
                        		<?=anchor('companies/insurances/'.$query['id'],'Cancel',array('class'=>'btn'))?>
                        </center>
                    </div>                                                                        
                 </div>
             </div>
        </div>
        <?=form_close()?>
                
                <div class="row-fluid">

                    <div class="span12">                    
                        <div class="head clearfix">
                            <div class="isw-grid"></div>
                            <h1>Banks &nbsp;&nbsp; 
                            	<div style="float:right !important; margin-right:10px;">(معلومات عن الانتاج)</div>
                            </h1> 
                            <?php //_show_add('companies/production-create/'.$query['id'],'Add New',TRUE)?>                
                        </div>
                        <div class="block-fluid">
                            <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="checkall"/></th>                                        
                                        <th>Code</th>
                                        <th>Name Of insurance company</th>
                                        <th style="text-align:right">اسم الشركة</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(count($insurances)){
										foreach($insurances as $insurance){ ?>
                                    <tr>
                                        <td><input type="checkbox" name="checkbox"/></td>   
                                        <td><?=$insurance->insurance_id?></td>                                     
                                        <td><?=$insurance->insurance_en?></td>                                     
                                        <td style="text-align:right"><?=$insurance->insurance_ar?></td>
                                        <td nowrap="nowrap"><?php echo _show_delete('companies/delete/id/'.$insurance->id.'/cid/'.$query['id'].'/p/insurance',$p_delete);
										echo _show_edit('companies/insurances/'.$query['id'].'/'.$insurance->id,$p_delete);?></td>
                                    </tr>
                                  <?php }
								  
								}
								else{
								?> 
                                    <tr>
                                        <td colspan="4" align="center"><h3>No Insurance Company Found</h3></td>
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

