<div class="span3">
    <div class="head clearfix">
        <div class="isw-ok"></div>
        <h1>Item Navigation</h1>
    </div>
    <div class="block-fluid">
        <ul class="sList">
        	<?php if($p_edit_item){ 
            echo '<li>'.anchor('items/edit/'.$id,'<span class="isb-edit"></span>Edit').'</li>';
			}
			if($p_delete_item){
            echo '<li>'.anchor('items/delete/id/'.$id.'/p/item','<span class="isb-delete"></span> Delete',array('onclick'=>'return confirmation();')).'</li>';
			}
			if($p_add_item){
            echo '<li>'.anchor('items/create/'.$id,'<span class="isb-plus"></span> Add New').'</li>';
			}
			if($p_view_item){
			foreach($squery as $sitem)	
            echo '<li>'.anchor('items/details/'.$sitem->id,'<span class="isb-grid"></span>'.$sitem->hs_code).'</li>';
			}
			?>
        </ul>                                                
    </div>
</div>
