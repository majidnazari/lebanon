
<script language="javascript">
	function displayitem(id)
	{
		$("#item").html("loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>companies/DisplayItem",
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
            <h1><?=$subtitle?></h1>
        </div> 
		 <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation'));
          echo form_hidden('c_id',$c_id); ?>                     
        <div class="row-fluid">
            <div class="span12">
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1><?=$subtitle?></h1>
                </div>
                <div class="block-fluid">
					<div class="row-form clearfix">
                        <div class="span3">H.S Code (البند الجمركي) :</div>
                        <div class="span6">
                        <?php 
							$item_array=array(''=>'Select H.S Code');
							foreach($items as $item){
								
								$item_array[$item->id]=$item->hs_code;
								}
							echo form_dropdown('heading_id',$item_array,$heading_id,$heading_option);	
						?>
                        </div>
                    </div>                 
					<div class="row-form clearfix">
                        <div class="span3">Items:</div>
                        <div class="span9"><div id="item"></div></div>
                    </div> 
                    <div class="footer tar">
                    	<center><input type="submit" name="save" value="Save" class="btn"></center>
                    </div>                                                                        
                 </div>
             </div>
        </div>
        <?=form_close()?>
    </div>
</div>