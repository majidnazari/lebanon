<style type="text/css">
    .row-form{
        font-size:15px !important;
    }
    .label-ar{
        float:right !important;
        margin-left:10px !important;
        text-align:right !important;
    }
    .adv-img{
        height:200px;
    }
    .h1-ar{
        float:right !important;
        margin-right:10px !important;
        font-size:22px !important
    }
    .row-form{
        padding: 5px 16px !important;
        direction:rtl;
    }
    .en{
        direction:ltr !important;
        text-align:left !important;
    }
</style>
<div class="content">
    <?=$this->load->view("includes/_bread")?>
    <?php echo form_open_multipart($this->uri->uri_string(), array('id' => 'validation'));
    ?>
    <div class="workplace">


        <div class="page-header">
            <h1><?=$subtitle?></h1>
        </div>
        <?php if($msg != '') {?>
            <div class="row-fluid">
                <div class="span12">
                    <div class="alert alert-success">
                        <?php echo $msg;?>
                    </div>
                </div>
            </div>
        <?php }?>
        <div class="row-fluid">

            <div class="span12">

                <div class="span9">
                    <div class="head clearfix">
                        <div class="isw-documents"></div>
                        <h1>Item</h1>
                        <h1 class="h1-ar"></h1>
                    </div>
                    <div class="block-fluid">
                        <div class="row-form clearfix">
                            <div class="span9" style="text-align:right !important">
                                <?php echo $query['hs_code'];?> </div>
                            <div class="span3"><strong class="label-ar"> الرمز المنسق  : </strong></div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span9" style="text-align:right !important">
                                <?php echo $query['hs_code_print'];?> </div>
                            <div class="span3"><strong class="label-ar">  الرمز المنسق الاصلي : </strong></div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span9" style="text-align:right !important">
                                <?php echo $query['chapter_ar'];?> </div>
                            <div class="span3"><strong class="label-ar">الفصل :   </strong></div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span9" style="text-align:right !important">
                                <p class="en"><?php echo $query['chapter_en'];?></p> </div>
                            <div class="span3"></div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span9" style="text-align:right !important">
                                <?php echo $query['subhead_ar'];?> </div>
                            <div class="span3"><strong class="label-ar">جزء الرمز :   </strong></div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span9" style="text-align:right !important">
                                <p class="en"><?php echo $query['subhead_en'];?></p></div>
                            <div class="span3"></div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span9" style="text-align:right !important">
                                <?php echo $query['label_ar'];?> </div>
                            <div class="span3"><strong class="label-ar">الصنف : </strong></div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span9" style="text-align:right !important">
                                <?php echo $query['label_en'];?> </div>
                            <div class="span3"><strong class="label-ar">Item : </strong></div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span9" style="text-align:right !important">
                                <?php echo $query['description_ar'];?> </div>
                            <div class="span3"><strong class="label-ar">وصف خاص : </strong></div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span9" style="text-align:right !important">
                                <?php echo $query['description_en'];?> </div>
                            <div class="span3"><strong class="label-ar">Special Description : </strong></div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span9" style="text-align:right !important">
                                <?php echo $query['update_time'];?> </div>
                            <div class="span3"><strong class="label-ar">Last Update : </strong></div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span9" style="text-align:right !important">
                                <?php echo $query['create_time'];?> </div>
                            <div class="span3"><strong class="label-ar">Create On : </strong></div>
                        </div>
                        <?php
                        $user = $this->Administrator->GetUserById($query['user_id']);
                        if(count($user) > 0) {
                            $createdBy = $user['fullname'].' ('.$user['username'].' )';
                        }
                        else {
                            $createdBy = 'N/A';
                        }
                        ?>
                        <div class="row-form clearfix">
                            <div class="span9" style="text-align:right !important">
                                <?php echo $createdBy;?> </div>
                            <div class="span3"><strong class="label-ar">Create By : </strong></div>
                        </div>
                    </div>
                    <div class="head clearfix">
                        <div class="isw-documents"></div>
                        <h1>Rating</h1>
                        <h1 class="h1-ar">النسب</h1>
                    </div>
                    <div class="block-fluid">
                        <table cellpadding="0" cellspacing="0" width="100%" class="table" style="direction:rtl !important">
                            <thead>
                                <tr>
                                    <th style="text-align:center">البلد</th>
                                    <th style="text-align:center" width="25%">نسبة التعرفة الجمركية (%)</th>
                                    <th style="text-align:center" width="25%">الاستيراد  (طن)</th>
                                    <th style="text-align:center" width="25%">الاستيراد (ل ل بالمليون)</th>
                                    <th style="text-align:center" width="25%">الاستيراد(دولار اميركي*1000)</th>
                                    <th style="text-align:center" width="25%">التصدير (ل ل بالمليون )</th>
                                    <th style="text-align:center" width="25%">التصدير (دولار اميركي*1000)</th>
                                    <th style="text-align:center" width="25%">التصدير(طن)</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(count($rating) > 0) {
                                    foreach($rating as $row) {
                                        ?>
                                        <tr>
                                            <td style="text-align:center"><?=$row->country_en?></td>
                                            <td style="text-align:center"><?=$row->rate?></td>
                                            <td style="text-align:center"><?=$row->tones_import?></td>
                                            <td style="text-align:center"><?=$row->import_lbp?></td>
                                            <td style="text-align:center"><?=$row->import_usd?></td>
                                            <td style="text-align:center"><?=$row->export_lbp?></td>
                                            <td style="text-align:center"><?=$row->export_usd?></td>
                                            <td style="text-align:center"><?=$row->tones_export?></td>
                                            <td style="text-align:center"><?=$row->year?></td>
                                        </tr>

                                        <?php
                                    }
                                }
                                else {
                                    echo '<tr>
                            	<td colspan="8"><center><strong>No Data Found</strong></center></td>
                            </tr>';
                                }
                                ?>
                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>


                    </div>
                </div>

                <?php $this->load->view('items/_navigation')?>
            </div>
        </div>
        <div class="dr"><span></span></div>
    </div>
    <?=form_close()?>

</div>