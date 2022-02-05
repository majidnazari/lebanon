<script>

function upload()
        {
            document.getElementById("validation").action = "<?=base_url().'companies/editimage'?>";
			document.getElementById("validation").submit();
        }

</script>
<div class="span3">
    <div class="head clearfix">
        <div class="isw-ok"></div>
        <h1>Company Navigation</h1>
    </div>
    <div class="block-fluid">
        <ul class="sList">
        	
			<?php 
			echo '<li>'.anchor('companies/details/'.$id,'<span class="isb-grid"></span>Company Details').'</li>';
			
			
            echo '<li>'.anchor('companies/view/'.$id,'<span class="isb-print"></span> Print', array('target'=>'_blank')).'</li>';
			
            echo '<li>'.anchor('companies/productions/'.$id,'<span class="isb-grid"></span>Production Info').'</li>';
			echo '<li>'.anchor('companies/exports/'.$id,'<span class="isb-grid"></span>Export & Trade Market').'</li>';
			echo '<li>'.anchor('companies/insurances/'.$id,'<span class="isb-grid"></span>Insurance').'</li>';
			echo '<li>'.anchor('companies/banks/'.$id,'<span class="isb-grid"></span>Banks').'</li>';
			echo '<li>'.anchor('companies/power/'.$id,'<span class="isb-grid"></span>Electric Power').'</li>';
			echo '<li>'.anchor('documents/index/'.$id.'/company','<span class="isb-grid"></span>Documents').'</li>';
			echo '<li>'.anchor('companies/statement/'.$id,'<span class="isb-grid"></span> المسح الصناعي').'</li>';
						//echo '<li>'.anchor('companies/remove/'.$id,'<span class="isb-delete"></span> Remove Advertisment Image','onclick="return confirmation(\'Are You sure you want to delete this Image\');"').'</li>';
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
