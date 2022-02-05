<style>
    .uploader{
        display:block !important;
    }
</style>
<div id="Modal<?=$query->position?>" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel"><?=@$query->category?> Sponsor Position <?=$query->position?></h3>
    </div>  
    <?php echo form_open_multipart('sponsors/save',array('id'=>'validation'));
            echo form_hidden('id',@$query->id);
            echo form_hidden('position',@$query->position);
            echo form_hidden('category',@$query->category);
            echo form_hidden('language',@$query->language);
            echo form_hidden('logo',@$query->logo);
    ?>  
    
    <div class="row-fluid">
        <div class="block-fluid">
            <div class="row-form clearfix">
                        <div class="span3">Name in english:</div>
                        <div class="span4"><?php echo form_input(array('name'=>'title_en','value'=>@$query->title_en)); ?>
                        <font color="#FF0000"><?php echo form_error('title_en'); ?></font>
                        </div>
                    </div> 
                    
                    <div class="row-form clearfix">
                        <div class="span3">Website:</div>
                        <div class="span4"><?php echo form_input(array('name'=>'website','value'=>@$query->website)); ?>
                        <font color="#FF0000"><?php echo form_error('website'); ?></font>
                        </div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span3">Logo:</div>
                        <div class="span4"><input type="file" name="userfile" /></div>
                    </div>    
                    
                    <div class="row-form clearfix">
                        <div class="span3">Section:</div>
                        <div class="span4"><?php 
                        $array_sections=array('bank'=>'Bank','company'=>'Company','importer'=>'Importer','inurance'=>'Inurance','transportation'=>'Transportation','external'=>'External');
                        echo form_dropdown('section',$array_sections,@$query->section);
							?></div>
							<div class="span1">ID#:</div>
                        <div class="span4"><?php 
                        echo form_input(array('name'=>'section_id','value'=>@$query->section_id));
							?></div>
                    </div> 
                    
                    
                   
                   
                    <div class="row-form clearfix">
                        <div class="span3">Status:</div>
                        <div class="span4"><?php $array_status=array('online'=>'Online','offline'=>'Offline');
												echo form_dropdown('status',$array_status,@$query->status);
							?></div>
                    </div> 
        </div>                
        <div class="dr"><span></span></div>
    </div>                    
    <div class="modal-footer">
        <?php 
        if(@$query->id>0){
        echo anchor('sponsors/delete/'.@$query->id,'Delete',array('class'=>'btn'));
        }?>
        <input type="submit" name="save" value="Save" class="btn">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>            
    </div>
    <?=form_close()?>
</div>