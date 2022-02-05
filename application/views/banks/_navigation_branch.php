<div class="span3">
    <div class="head clearfix">
        <div class="isw-ok"></div>
        <h1>Branch Navigation</h1>
    </div>
    <div class="block-fluid">
        <ul class="sList">
        	<?php if($p_branch_edit){ 
            echo '<li>'.anchor('banks/branch-edit/'.$row['id'],'<span class="isb-edit"></span>Edit').'</li>';
			}
			if($p_branch_delete){
            echo '<li>'.anchor('banks/delete/id/'.$row['id'].'/bank/'.$id.'/st/branches','<span class="isb-delete"></span> Delete').'</li>';
			}
			if($p_branches){
            echo '<li>'.anchor('banks/branches/'.$id,'<span class="isb-bookmark"></span>Branches - الفروع').'</li>';
			}
			?>
        </ul>                                                
    </div>
</div>
