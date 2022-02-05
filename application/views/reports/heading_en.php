<style type="text/css">
    .yellow{
        background:#FF0 !important;
    }
</style>
<div class="content">
    <?=$this->load->view("includes/_bread")?>
    <div class="workplace">
        <div class="page-header">
            <h1><?=$subtitle;?></h1>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="head clearfix">
                    <div class="isw-zoom"></div>
                    <h1>Search</h1>
                </div>
                <?php
                echo form_open_multipart($this->uri->uri_string(), array('id' => 'validation', 'method' => 'get'));
                echo form_hidden('lang', 'en');
                ?>
                <div class="block-fluid">
                    <div class="row-form clearfix">
                        <div class="span1">Description : </div>
                        <div class="span6"><?=form_input(array('name' => 'hscode', 'id' => 'hscode', 'value' => $hscode))?></div>
                        <div class="span3"><input type="submit" name="search" value="Search" class="btn">
                            <input type="submit" name="clear" value="Clear" class="btn">
                        </div>
                    </div>
                </div>
                <?=form_close()?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <?php echo form_open('', array('id' => 'form_id', 'name' => 'form1'));?>
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?> : Total Results : <?=count($query)?></h1>
                    <?php
                    echo anchor('reports/heading?hscode='.$hscode.'&lang=ar&search=Search', '<h3 style="float:right !important; color:#FFF !important"> - Arabic  </h3>');
                    // echo anchor('reports/ExportHeading/'.$hscode.'/en', '<h3 style="float:right !important; color:#FFF !important">Export All To Excel</h3>');
                    ?>
                </div>
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th>H.S Code</th>
                                <th>Label</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($query as $row) {?>
                                <tr>
                                    <td><?=anchor('reports/ExportHeading/'.$row->hs_code_print.'/en', $row->hs_code_print)?></td>
                                    <td><?=$row->label_en?></td>
                                    <td><?=$row->description_en?></td>
                                </tr>
                            <?php }?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7"></td></tr>
                        </tfoot>
                    </table>

                </div>
                <?php echo form_close();?>
            </div>
        </div>
        <div class="dr"><span></span></div>
    </div>
</div>
