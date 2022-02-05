<script>

function upload()
        {
            document.getElementById("validation").action = "<?=base_url().'importers/editimage'?>";
			document.getElementById("validation").submit();
        }

</script>
<div class="span3">
    <div class="head clearfix">
        <div class="isw-ok"></div>
        <h1>Importer Navigation</h1>
    </div>
    <div class="block-fluid">
        <ul class="sList">
        	<?php 
			echo '<li>'.anchor('importers/details/'.$id,'<span class="isb-grid"></span>Company Details').'</li>';
			if($p_edit){ 
            echo '<li>'.anchor('importers/edit/'.$id,'<span class="isb-edit"></span>Edit').'</li>';
			}
			
			if($p_view){ 
            echo '<li>'.anchor('importers/view/'.$id,'<span class="isb-print"></span> Print', array('target'=>'_blank')).'</li>';
			}
			if($p_foreign_companies){ 
            echo '<li>'.anchor('importers/foreign-companies/'.$id,'<span class="isb-plus"></span> Add Foreign Company').'</li>';
			}
            //if(@$p_app){
            echo '<li>'.anchor('importers/export/'.$id,'<span class="isb-grid"></span>Export Applications To Excel').'</li>';
            //}
			echo '<li>'.anchor('documents/index/'.$id.'/importer','<span class="isb-grid"></span>Documents').'</li>';
			if($p_delete){
            echo '<li>'.anchor('importers/delete/id/'.$id.'/p/importer','<span class="isb-delete"></span> Delete','onclick="return confirmation(\'Are You sure you want to delete this Istimara\');"').'</li>';
			}
			//echo '<li>'.anchor('importers/remove/'.$id,'<span class="isb-delete"></span> Remove Advertisment Image','onclick="return confirmation(\'Are You sure you want to delete this Image\');"').'</li>';
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
