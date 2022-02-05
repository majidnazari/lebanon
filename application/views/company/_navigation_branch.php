<div class="span3">
    <div class="head clearfix">
        <div class="isw-ok"></div>
        <h1>Branch Navigation</h1>
    </div>
    <div class="block-fluid">
        <ul class="sList">
        	<?php if($this->p_branch_edit){
            echo '<li>'.anchor('companies/branch-edit/'.$row['id'],'<span class="isb-edit"></span>Edit').'</li>';
			}
			if($this->p_branch_delete){
            echo '<li>'.anchor('companies/delete/id/'.$row['id'].'/company/'.$id.'/p/branches','<span class="isb-delete"></span> Delete').'</li>';
			}
			if($this->p_branches){
            echo '<li>'.anchor('companies/branches/'.$id,'<span class="isb-bookmark"></span>Branches - الفروع').'</li>';
			}
			?>
        </ul>                                                
    </div>
</div>
