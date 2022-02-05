<div class="span12">
    <div class="widgetButtons">
        <?php if($p_edit){ ?>
        <div class="bb"><?=anchor('banks/edit/'.$query['id'],'<span class="ibw-edit"></span>',array("class"=>"tipb", "title"=>"Edit"))?></div>
      <?php } 
	   if($p_delete){ ?>
        <div class="bb"><?=anchor('banks/delete/'.$query['id'],'<span class="ibw-delete"></span>',array("class"=>"tipb", "title"=>"Delete"),$js_confirm)?></div>
        <?php }
		 if($p_branches){ ?>     
        <div class="bb"><?=anchor('banks/branches/'.$query['id'],'<span class="ibw-settings"></span>',array("class"=>"tipb", "title"=>"Branches"))?></div>
        <?php } 
		 if($p_directors){ ?>
        <div class="bb"><?=anchor('banks/directories/'.$query['id'],'<span class="ibw-print"></span>',array("class"=>"tipb", "title"=>"Board Of Directories"))?></div>
        <?php } ?>    
		
        <div class="bb"><?=anchor('banks/view/'.$query['id'],'<span class="ibw-print"></span>',array("class"=>"tipb", "title"=>"Print Form","target"=>"_blank"))?></div>

    </div>
   
</div>