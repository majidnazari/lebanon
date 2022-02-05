<div class="span12">
    <div class="widgetButtons">
        <?php if($p_edit){ ?>
        <div class="bb"><?=anchor('banks/editbranch/'.$query['id'],'<span class="ibw-edit"></span>',array("class"=>"tipb", "title"=>"Edit"))?></div>
      <?php } ?>
      <?php if($p_delete){ ?>
        <div class="bb"><?=anchor('banks/deleteb/'.$query['id'],'<span class="ibw-delete"></span>',array("class"=>"tipb", "title"=>"Delete"),$js_confirm)?></div>
        <?php } ?>
		
    </div>
   
</div>