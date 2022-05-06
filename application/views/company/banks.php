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
                    <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation'));
                echo form_hidden('c_id',$c_id);
                echo form_hidden('action',$action);
                ?>   
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1><?=$subtitle?></h1>
                </div>
                <div class="block-fluid">
					<div class="row-form clearfix">
                        <div class="span4">Banks (المصارف):</div>
                        <div class="span8">
                            <?php 
                            $array_bnk=array();
                            if(count($banks)){
                                foreach($banks as $bank){
                                    array_push($array_bnk,$bank->bank_id);
                                    }
                            }
                                $item_array=array(''=>'Select Bank');
                                foreach($items as $item){
                                    if(!in_array($item->id,$array_bnk))
                                    $item_array[$item->id]=$item->name_ar.' ( '.$item->name_en.' )';
                                    }
                                echo form_dropdown('bank_id',$item_array,$bank_id,$heading_option);	
                            ?>
                        </div>
                    </div>                 
					<div class="row-form clearfix">
                        <div class="span3">Details:</div>
                        <div class="span9"><div id="item"><?=$display?></div></div>
                    </div> 
                    <div class="footer tar">
                    	<center><input type="submit" name="save" value="Save" class="btn">
                        		<?=anchor('companies/banks/'.$id,'Cancel',array('class'=>'btn'))?>
                        </center>
                    </div>                                                                        
                </div> <!-- end div for  <div class="block-fluid"> -->
                            <?=form_close()?>
                            <?php echo form_open('companies/delete_checked',array('id'=>'form_id','name'=>'form1'));
                                    echo form_hidden('company',$id);
                                    echo form_hidden('p','banks');
                            ?>
                <div class="row-fluid">
                    <div class="span12">                    
                        <div class="head clearfix">
                            <div class="isw-grid"></div>
                            <h1>Banks &nbsp;&nbsp; 
                            	<div style="float:right !important; margin-right:10px; font-size:20px !important">المصارف</div>
                            </h1> 
                            <?=_show_delete_checked('#',$p_delete)?>
                            <?php //_show_add('companies/production-create/'.$query['id'],'Add New',TRUE)?>                
                        </div>
                        <div class="block-fluid">
                            <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="checkall"/></th>                                        
                                        <th>Code</th>
                                        <th>Bank Name</th>
                                        <th style="text-align:right">اسم  المصرف</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(count($banks)){
										foreach($banks as $bank){ ?>
                                    <tr>
                                        <td><input type="checkbox" name="checkbox1[]" value="<?=$bank->id?>"/></td>   
                                        <td><?=$bank->bank_id?></td>                                     
                                        <td><?=$bank->bank_en?></td>                                     
                                        <td style="text-align:right"><?=$bank->bank_ar?></td>
                                        <td nowrap="nowrap"><?php echo _show_delete('companies/delete/id/'.$bank->id.'/cid/'.$query['id'].'/p/bank',$p_delete);
										echo _show_edit('companies/banks/'.$id.'/'.$bank->id,$p_delete);?></td>
                                    </tr>
                                  <?php }
								  
								}
								else{
								?> 
                                    <tr>
                                        <td colspan="5" align="center"><h3>No Bank Found</h3></td>
                                    </tr> 
                                   <?php } ?>                                                                
                                </tbody>
                            </table>
                        </div>
                    </div>                                
                </div>
                <?=form_close()?>
            </div>
             <?=$this->load->view('company/_navigation')?> 
        </div>
   <div class="dr"><span></span></div>           
 </div>
</div>

