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
			if($p_edit){ 
            echo '<li>'.anchor('companies/edit/'.$id,'<span class="isb-edit"></span>Edit').'</li>';
			}
			if($p_edit){
				echo '<li>'.anchor('companies/marketing/'.$id,'<span class="isb-grid"></span>marketing').'</li>';
				}
            echo '<li>'.anchor('companies/view/'.$id,'<span class="isb-print"></span> Print', array('target'=>'_blank')).'</li>';
			if($p_production){
            echo '<li>'.anchor('companies/productions/'.$id,'<span class="isb-grid"></span>Production Info').'</li>';
			}
			if($p_export){
            echo '<li>'.anchor('companies/exports/'.$id,'<span class="isb-grid"></span>Export & Trade Market').'</li>';
			}
			if($p_insurance){
            echo '<li>'.anchor('companies/insurances/'.$id,'<span class="isb-grid"></span>Insurance').'</li>';
			}
			if($p_banks){
            echo '<li>'.anchor('companies/banks/'.$id,'<span class="isb-grid"></span>Banks').'</li>';
			}
			if($p_power){
            echo '<li>'.anchor('companies/power/'.$id,'<span class="isb-grid"></span>Electric Power').'</li>';
			}
			echo '<li>'.anchor('documents/index/'.$id.'/company','<span class="isb-grid"></span>Documents').'</li>';
			echo '<li>'.anchor('companies/statement/'.$id,'<span class="isb-grid"></span> المسح الصناعي').'</li>';
			if(@$p_app){
		//	echo '<li>'.anchor('companies/app/'.$id,'<span class="isb-grid"></span> Applications').'</li>';
                echo '<li>'.anchor('companies/export/'.$id,'<span class="isb-grid"></span>Export Applications To Excel').'</li>';
			}
			if(@$this->p_branches){
			echo '<li>'.anchor('companies/branches/'.$id,'<span class="isb-grid"></span> Branches').'</li>';
			}
			if($p_delete){
            echo '<li>'.anchor('companies/delete/id/'.$id.'/p/company','<span class="isb-delete"></span> Delete','onclick="return confirmation(\'Are You sure you want to delete this Istimara\');"').'</li>';
			}
			
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
