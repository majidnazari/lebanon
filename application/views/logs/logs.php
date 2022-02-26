<script language="javascript">

    $(function () {
        $("#from").datepicker({
            dateFormat: "yy-mm-dd"
        });
        $("#to").datepicker({
            dateFormat: "yy-mm-dd"
        });
    })

</script>
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
                <?php echo form_open_multipart($this->uri->uri_string(), array('id' => 'validation', 'method' => 'get'));
                ?>
                <div class="block-fluid">
<div class="row-form clearfix">
                        <div class="span3">ID : <br /><?php echo form_input(array('name' => 'id', 'value' => @$id, 'id' => 'id'));?>
                        </div>

                        <div class="span3">KeyWord :
                            <br /><?php echo form_input(array('name' => 'keyword', 'value' => @$keyword, 'id' => 'keyword'));?>
                        </div>
                          <div class="span2">Type<br />
                            <?php
                            $array_types = array('' => 'All', 'company' => 'Company', 'bank' => 'Bank', 'insurance' => 'Insurance', 'importer' => 'Importer', 'transportation' => 'Transportation');
                            echo form_dropdown('type', $array_types, @$type);
                            ?></div>
                    </div>

                    <div class="row-form clearfix">
                        <div class="span2">From : <br /><?php echo form_input(array('name' => 'from', 'value' => @$from, 'id' => 'from'));?>
                        </div>

                        <div class="span2">To :
                            <br /><?php echo form_input(array('name' => 'to', 'value' => @$to, 'id' => 'to'));?>
                        </div>
                        <div class="span2">Users<br />
                            <?php
                            $array_users = array('' => 'All');
                            if(count($users) > 0) {
                                foreach($users as $useri) {
                                    $array_users[$useri->id] = $useri->fullname.' ('.$useri->username.' )';
                                }
                            }
                            echo form_dropdown('user', $array_users, @$user);
                            ?></div>

                        <div class="span2">Action<br />
                            <?php
                            $array_actions = array('' => 'All', 'add' => 'Add', 'delete' => 'Delete', 'edit' => 'Edit');
                            echo form_dropdown('action', $array_actions, @$action);
                            ?></div>
                        <div class="span2"><br /><input type="submit" name="search" value="Search" class="btn">
                            <input type="submit" name="clear" value="Clear" class="btn">
                        </div>
                    </div>



                </div>
                <?=form_close()?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <?php if($msg != '') {?>
                    <div class="alert alert-success">
                        <?php echo $msg;?>
                    </div>
                <?php }?>
                <?php echo form_open('', array('id' => 'form_id', 'name' => 'form1'));?>
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
                    <ul class="buttons">
                        <li><?=_show_delete_checked('#', $p_delete)?></li>
                    </ul>
                </div>
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="checkall"/></th>
                                <th style="text-align:center">Action</th>
                                <th style="text-align:center">Title</th>
                                <th style="text-align:center">Data</th>
                                <th style="text-align:center">Date</th>
                                <th style="text-align:center">Created By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $array_par = array('');
                            if(count($query) > 0) {
                                foreach($query as $row) {
                                    $restore = '';
                                    $ctitle = $row->item_title;
                                    $array_data = json_decode($row->details);                                  
                                                                    
                                    if(count((array)$array_data) > 0) {
                                        if($row->type == 'company' or $row->type == 'bank' or $row->type == 'insurance' or $row->type == 'importer' or $row->type == 'transportation') {
                                            if($row->action == 'delete' or $row->action == 'add') {
                                                $data = anchor('logs/'.$row->type.'-details/'.$row->id, 'View Data', array('target' => '_blank'));
                                                $restore = anchor('logs/restore/id/'.$row->id.'/p/'.$row->type, '<i class="isb-left_circle"></i>', array('title' => 'Restore'));
                                                $ctitle = anchor('logs/'.$row->type.'-details/'.$row->id, @$array_data->name_ar.'<br>'.@$array_data->name_en, array('target' => '_blank'));
                                                
                                                
                                            }
                                            else {

                                                $data = '<table style="width:100%">';
                                                $data.= '<tr><th>Field</th><th>Old Value</th><th>New Value</th></tr>';
                                                foreach($array_data as $key => $value) {
                                                    if($key != 'update_time') {
                                                        $array_old = $this->Administrator->GetValue($key, $value->old);
                                                        $array_new = $this->Administrator->GetValue($key, $value->new);
                                                        $data.= '<tr><td>'.$this->Log->ShowData($array_old['label']).'</td><td>'.$array_old['value'].'</td><td>'.$array_new['value'].'</td></tr>';
                                                    }
                                                }
                                                $data.= '</table>';
                                            }
                                        }
                                        else {
                                            if($row->action == 'delete' or $row->action == 'add') {

                                                $data = '<table style="width:100%">';
                                                $data.= '<tr><th>Field</th><th>Data Value</th></tr>';
                                                foreach($array_data as $key => $value) {
                                                    if($key != 'update_time' and $value != '') {
                                                        $array = $this->Administrator->GetValue($key, $value);
                                                        $data.= '<tr><td>'.$this->Log->ShowData($array['label']).'</td><td>'.$array['value'].'</td></tr>';
                                                    }
                                                }
                                                $data.= '</table>';
                                            }
                                            else {

                                                $data = '<table style="width:100%">';
                                                $data.= '<tr><th>Field</th><th>Old Value</th><th>New Value</th></tr>';
                                                foreach($array_data as $key => $value) {
                                                    if($key != 'update_time') {
                                                        $array_old = $this->Administrator->GetValue($key, $value->old);
                                                        $array_new = $this->Administrator->GetValue($key, $value->new);
                                                        $data.= '<tr><td>'.$this->Log->ShowData($array_old['label']).'</td><td>'.$array_old['value'].'</td><td>'.$array_new['value'].'</td></tr>';
                                                    }
                                                }
                                                $data.= '</table>';
                                            }
                                        }
                                        ?>
                                        <tr>
                                            <td><input type="checkbox" id="check" name="checkbox1[]" value="<?=$row->id?>"/><?=$row->item_id?></td>
                                            <td><?=ucfirst($row->action).' - '.$row->type?></td>
                                            <td><?=$ctitle?></td>
                                            <td><?=$data?></td>
                                            <td><?=$row->create_time?></td>
                                            <td><?=$row->fullname.' ('.$row->username.' )'?></td>
                                            <td>
                                                <?php
                                                echo _show_delete('logs/delete/id/'.$row->id.'/p/'.$row->type, $p_delete);
                                                if($p_restore)
                                                    echo $restore;
                                                ?>
                                            </td>
                                        </tr>

                                        <?php
                                    }
                                }
                            }
                            else {
                                echo '<tr>
                            	<td colspan="5"><center><strong>No Data Found</strong></center></td>
                            </tr>';
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">Total : <?=@$total_row?><div class="dataTables_paginate paging_full_numbers"><?=@$links?></div></td></tr>
                        </tfoot>
                    </table>

                </div>
                <?php echo form_close();?>
            </div>
        </div>
        <div class="dr"><span></span></div>
    </div>
</div>
