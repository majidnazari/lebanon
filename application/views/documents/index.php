<div class="content">
	<?=$this->load->view("includes/_bread")?>
    <div class="workplace">                        
        <div class="page-header">
            <h1><?=$subtitle?></h1>
        </div> 
                         
          <div class="row-fluid">

            <div class="span9">
            <div class="row-fluid">
            <div class="span12">
                 <div class="head clearfix">
                    <div class="isw-zoom"></div>
                    <h1>Add New</h1>
                </div>
                <?php echo form_open_multipart('documents/create',array('id'=>'validation'));
					  echo form_hidden('item_type',$type);
					  echo form_hidden('item_id',$id);
				?> 
                <div class="block-fluid">                        
                    <div class="row-form clearfix">
                        <div class="span1">Title</div><div class="span3"><?=form_input(array('name'=>'title','id'=>'title'))?></div>
                        <div class="span1">File </div><div class="span5"><input type="file" name="userfile" /></div>
                        <div class="span2"><input type="submit" name="save" value="Save" class="btn"></div>
                    </div>                            
                </div>
				<?=form_close()?>
            </div>
        </div>
                <div class="head clearfix">
                    <div class="isw-picture"></div>
                    <h1>Documents</h1>
                </div>
                <div class="block thumbs clearfix">                                    
					<?php foreach($query as $row){ 
							$info = new SplFileInfo(base_url().$row->url);
							$extension = pathinfo($info->getFilename(), PATHINFO_EXTENSION);
							if($extension=='pdf')
							{
								$img='<a href="'.base_url().$row->url.'" target="_blank"><img src="'.base_url().'img/pdf.png" class="img-polaroid"/></a>';	
								
							}
							elseif($extension=='doc' || $extension=='docx' )
							{
								$img='<a href="'.base_url().$row->url.'" target="_blank"><img src="'.base_url().'img/word.png" class="img-polaroid"/></a>';	
							}
							else{
								$img='<a class="fancybox" rel="group" href="'.base_url().$row->url.'">
                        	<img src="'.base_url().$row->url.'" class="img-polaroid"/></a>';
								}
					?>
                    <div class="thumbnail">
                       <?=$img?>
                        <div class="caption">
                            <h3><?=$row->title?></h3>
                            <p><?=anchor('documents/delete/'.$row->id.'/'.$id.'/'.$type,'Delete',array('class'=>'btn','onclick'=>'return confirmation();'))?></p>
                        </div>
                    </div>                        
					<?php } ?>
                </div>
            </div>
            <?=$this->load->view($nav)?>
        </div>
        <div class="dr"><span></span></div>            
    </div>
 </div>
