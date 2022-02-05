<div class="span12">
    <div class="widgetButtons">
        <?php if($p_edit){ ?>
        <div class="bb"><?=anchor('companies/edit/'.$query['id'],'<span class="ibw-edit"></span>',array("class"=>"tipb", "title"=>"Edit"))?></div>
      <?php } ?>
      <?php if($p_delete){ ?>
        <div class="bb"><?=anchor('companies/delete/'.$query['id'],'<span class="ibw-delete"></span>',array("class"=>"tipb", "title"=>"Delete"),$js_confirm)?></div>
        <?php } ?>
      <?php if($p_production){ ?>     
        <div class="bb"><?=anchor('companies/productions/'.$query['id'],'<span class="ibw-settings"></span>',array("class"=>"tipb", "title"=>"Production Information\nمعلومات عن الانتاج"))?></div>
        <?php } ?>
        
        <?php if($p_export){ ?>
        <div class="bb"><?=anchor('companies/exports/'.$query['id'],'<span class="ibw-sync"></span>',array("class"=>"tipb", "title"=>"Export & Trade Market"))?></div>
        <?php } ?>
         <?php if($p_insurance){ ?>
        <div class="bb"><?=anchor('companies/insurances/'.$query['id'],'<span class="ibw-insurance"></span>',array("class"=>"tipb", "title"=>"Insurance"))?></div>
        <?php } ?>
         <?php if($p_banks){ ?>
        <div class="bb"><?=anchor('companies/banks/'.$query['id'],'<span class="ibw-banks"></span>',array("class"=>"tipb", "title"=>"Banks"))?></div>
        <?php } ?>
         <?php if($p_power){ ?>
        <div class="bb"><?=anchor('companies/power/'.$query['id'],'<span class="ibw-electrical"></span>',array("class"=>"tipb", "title"=>"Electric Power"))?></div>
        <?php } ?>
         <?php 
		 /*
		 if($p_edit){ ?>
        <div class="bb"><?=anchor('companies/sponsors/id/'.$query['id'],'<span class="ibw-user"></span>',array("class"=>"tipb", "title"=>"Administrator"))?></div>
        <?php } ?>
         <?php if($p_edit){ ?>
        <div class="bb"><?=anchor('companies/sponsors/'.$query['id'],'<span class="ibw-bookmark"></span>',array("class"=>"tipb", "title"=>"Sponsors"))?></div>
        <?php } */ ?>
		
        <div class="bb"><?=anchor('companies/view/'.$query['id'],'<span class="ibw-print"></span>',array("class"=>"tipb", "title"=>"Print Form","target"=>"_blank"))?></div>
             

    </div>
   
</div>