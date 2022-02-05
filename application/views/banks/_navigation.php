<script>

function upload()
        {
            document.getElementById("validation").action = "<?=base_url().'banks/editimage'?>";
			document.getElementById("validation").submit();
        }

</script>
<div class="span3">
    <div class="head clearfix">
        <div class="isw-ok"></div>
        <h1>Bank Navigation</h1>
    </div>
    <div class="block-fluid">
        <ul class="sList">
        
        	<?php 
			
			echo '<li>'.anchor('banks/details/'.$id,'<span class="isb-grid"></span>Bank Details').'</li>';
			if($p_edit){ 
            echo '<li>'.anchor('banks/edit/'.$id,'<span class="isb-edit"></span>Edit').'</li>';
			}
			
            echo '<li>'.anchor('banks/view/'.$id,'<span class="isb-print"></span> Print', array('target'=>'_blank')).'</li>';
			
			if($p_directors){
            echo '<li>'.anchor('banks/directors/'.$id,'<span class="isb-users"></span>Board of Directors - مجلس الادارة').'</li>';
			}
			if($p_branches){
            echo '<li>'.anchor('banks/branches/'.$id,'<span class="isb-bookmark"></span>Branches - الفروع').'</li>';
			}
			echo '<li>'.anchor('documents/index/'.$id.'/bank','<span class="isb-grid"></span>Documents').'</li>';
            //if(@$p_app){
                echo '<li>'.anchor('banks/export/'.$id,'<span class="isb-grid"></span>Export Applications To Excel').'</li>';
            //}
		if($p_delete){
            echo '<li>'.anchor('banks/delete/id/'.$id.'/st/banks','<span class="isb-delete"></span> Delete','onclick="return confirmation(\'Are You sure you banks to delete this Istimara\');"').'</li>';
			}
			//echo '<li>'.anchor('banks/remove/'.$id,'<span class="isb-delete"></span> Remove Advertisment Image','onclick="return confirmation(\'Are You sure you want to delete this Image\');"').'</li>';
			/*
			?>
            <li>Edit Advertisment Image
            	<?php echo form_hidden('editimageid',$id);?>
                        <input type="file" name="adimage" />
                       <center> <input type="button" onclick="upload()" value="Upload" class="btn" /></center>
            </li>
			*/
			?>
        </ul>                                                
    </div>
</div>
