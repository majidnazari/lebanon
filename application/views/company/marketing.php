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
                <div class="page-header">
                    <h2><?=$query['name_en'].'/&nbsp;'.$query['name_ar']?></h2> 
                </div> 
        <div class="row-fluid">  
            <div class="span9">       
                        <div class="row-fluid">
                            <div class="span6">                    
                                <div class="head clearfix">
                                        <?php $this->load->view('clients',['client_id'=>$c_id,'client_type'=>'company','status_type'=>'show_items','title'=>'Show Items']); ?>

                                </div>
                            </div>
                            <div class="span6">                    
                                <div class="head clearfix">
                                        <?php $this->load->view('company_salesman',['client_id'=>$c_id,'client_type'=>'company','status_type'=>'show_items','title'=>'Show Items']); ?>

                                </div>
                            </div>
                        </div>
            </div>            
                <?=$this->load->view('company/_navigation')?> 
        </div>
            <div class="dr"><span></span></div>
    </div>                   
 
</div>

