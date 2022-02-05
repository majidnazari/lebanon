<script>

function upload()
        {
            document.getElementById("validation").action = "<?=base_url().'transportations/editimage'?>";
			document.getElementById("validation").submit();
        }

</script>
<div class="span3">
    <div class="head clearfix">
        <div class="isw-ok"></div>
        <h1>Transportations Navigation</h1>
    </div>
    <div class="block-fluid">
        <ul class="sList">
        	<?php 
			echo '<li>'.anchor('transportations/details/'.$id,'<span class="isb-grid"></span>Company Details').'</li>';
			if($p_edit){ 
            echo '<li>'.anchor('transportations/edit/'.$id,'<span class="isb-edit"></span>Edit').'</li>';
			}
			
            echo '<li>'.anchor('transportations/view/'.$id,'<span class="isb-print"></span> Print', array('target'=>'_blank')).'</li>';
			
			if($p_view_port){
            echo '<li>'.anchor('transportations/ports/'.$id,'<span class="isb-users"></span>المرافئ التي تقصدها البواخر').'</li>';
			}
		if($p_view_branch){
            echo '<li>'.anchor('transportations/branches/'.$id,'<span class="isb-users"></span>الوكلات الاجنبية التي تمثلها الشركة').'</li>';
			}
		if($p_add_branch){
            echo '<li>'.anchor('transportations/branch-create/'.$id,'<span class="isb-plus"></span>Add Branches - اضافة  فرع').'</li>';
			}
            //if(@$p_app){
            echo '<li>'.anchor('transportations/export/'.$id,'<span class="isb-grid"></span>Export Applications To Excel').'</li>';
            //}
			echo '<li>'.anchor('documents/index/'.$id.'/transportation','<span class="isb-grid"></span>Documents').'</li>';
			if($p_delete){
            echo '<li>'.anchor('transportations/delete/id/'.$id.'/p/transportation','<span class="isb-delete"></span> Delete','onclick="return confirmation(\'Are You sure you want to delete this Istimara\');"').'</li>';
			}
			//echo '<li>'.anchor('transportations/remove/'.$id,'<span class="isb-delete"></span> Remove Advertisment Image','onclick="return confirmation(\'Are You sure you want to delete this Image\');"').'</li>';
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
