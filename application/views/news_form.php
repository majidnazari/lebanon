<script type="text/javascript">

    $(function() {

        $(".datep").datepicker({
            dateFormat: "yy-mm-dd"
        });

        $('#txt_area').hide();
        $('#externalarea').hide();

        <?php if(@$query['type']=='text'){?>
        $('#txt_area').show();
        <?php }
        else{ ?>
        $('#externalarea').show();
        <?php  }
        ?>
        $('#btype').change(function(){
            if($('#btype').val() == 'text') {
                $('#txt_area').show();
                $('#externalarea').hide();
            } else if($('#btype').val() == 'external_url') {
                $('#txt_area').hide();
                $('#externalarea').show();
            }
        });
    });

</script>
<div class="content">
    <?=$this->load->view("includes/_bread")?>
    <div class="workplace">
        <div class="page-header">
            <h1><?=$subtitle?></h1>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Banners Position Preview</h1>
                </div>
                <div class="block-fluid">
                    <div class="row-form clearfix">
                        <div class="span6">
                            <img src="<?=base_url()?>uploads/banner_preview.jpg" style="width: 100%" />
                        </div>
                        <div class="span6">
                            <img src="<?=base_url()?>uploads/preview1.jpg" style="width: 100%" />
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1><?=$subtitle?></h1>
                </div>
                <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation'));
                echo form_hidden('id',@$id);
                echo form_hidden('url',@$query['url']);
                echo form_hidden('img_url',@$query['img']);
                ?>
                <div class="block-fluid">
                    <div class="row-form clearfix">
                        <div class="span3">Position:</div>
                        <div class="span4"><?php $array_position=array(1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8);
                            echo form_dropdown('position',$array_position,(set_value('position') ? set_value('position') : @$query['position']));
                            ?></div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span3">Title in arabic:</div>
                        <div class="span6"><?=form_input(array('name'=>'title_ar','value'=>(set_value('title_ar') ? set_value('title_ar') : @$query['title_ar']))); ?>
                            <font color="#FF0000"><?php echo form_error('title_ar'); ?></font>
                        </div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span3">Title in english:</div>
                        <div class="span6"><?=form_input(array('name'=>'title_en','value'=>(set_value('title_en') ? set_value('title_en') : @$query['title_en']))); ?>
                            <font color="#FF0000"><?php echo form_error('title_en'); ?></font>
                        </div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span3">Type:</div>
                        <div class="span4"><?php $array_types=array(''=>'Select','text'=>'Text','external_url'=>'External Popup');
                            echo form_dropdown('type',$array_types,(set_value('type') ? set_value('type') : @$query['type']),'id="btype"');
                            ?></div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span3">Date:</div>
                        <div class="span3">From<?=form_input(array('name'=>'fdate','value'=>(set_value('fdate') ? set_value('fdate') : @$query['fdate']),'class'=>'datep')); ?>
                            <font color="#FF0000"><?php echo form_error('fdate'); ?></font>
                        </div>
                        <div class="span3">To<?=form_input(array('name'=>'tdate','value'=>(set_value('tdate') ? set_value('tdate') : @$query['tdate']),'class'=>'datep')); ?>
                            <font color="#FF0000"><?php echo form_error('fdate'); ?></font>
                        </div>
                    </div>
                    <div id="txt_area">
                        <div class="row-form clearfix">
                            <div class="span3">Details in Arabic:</div>
                            <div class="span9"><?=form_textarea(array('name'=>'details_ar','value'=>(set_value('details_ar') ? set_value('details_ar') : @$query['details_ar']),'cols'=>35,'rows'=>8)); ?>
                                <font color="#FF0000"><?php echo form_error('details_ar'); ?></font>
                            </div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3">Details in English:</div>
                            <div class="span9"><?=form_textarea(array('name'=>'details_en','value'=>(set_value('details_en') ? set_value('details_en') : @$query['details_en']),'cols'=>35,'rows'=>8)); ?>
                                <font color="#FF0000"><?php echo form_error('details_en'); ?></font>
                            </div>
                        </div>

                        
                        <div class="row-form clearfix">
                            <div class="span3">Image:</div>
                            <div class="span4"><input type="file" name="img" />
                                <?php if(@$query['img']!=''){ ?>
                                    <img src="<?=base_url().$query['img']?>" />
                                    <?=anchor('news/remove_img/'.@$query['id'],'Remove Image');?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="row-form clearfix" id="externalarea">
                        <div class="span3">External Link:</div>
                        <div class="span4"><?=form_input(array('name'=>'external_link','value'=>(set_value('external_link') ? set_value('external_link') : @$query['external_link']),'placeholder'=>'http://')); ?>
                            <font color="#FF0000"><?php echo form_error('external_link'); ?></font>
                        </div>
                    </div>

                    <?php /*

                    <div class="row-form clearfix">
                        <div class="span3">Category:</div>
                        <div class="span4"><?php $array_category=array('vacancy'=>'Job Vacancy','banner'=>'Banner');
                            echo form_dropdown('category',$array_category,(set_value('category') ? set_value('category') : @$query['category']));
                            ?></div>
                    </div>
 */?>
 <div class="row-form clearfix">
                            <div class="span3">Thumbnail:</div>
                            <div class="span4"><input type="file" name="userfile" />
                                <?php if(@$query['url']!=''){ ?>
                                    <img src="<?=base_url().$query['url']?>" />
                                    <?=anchor('news/remove_thumbnail/'.@$query['id'],'Remove thumbnail');?>
                                <?php } ?>
                            </div>
                        </div>

                    <div class="row-form clearfix">
                        <div class="span3">Status:</div>
                        <div class="span4"><?php $array_status=array('active'=>'Active','inactive'=>'Inactive');
                            echo form_dropdown('status',$array_status,(set_value('status') ? set_value('status') : @$query['status']));
                            ?></div>
                    </div>

                    <div class="footer tar">
                        <center><input type="submit" name="save" value="Save" class="btn"></center>
                    </div>
                </div>
                <?=form_close()?>
            </div>
        </div>
    </div>
</div>