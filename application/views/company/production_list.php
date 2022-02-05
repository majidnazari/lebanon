<script type='text/javascript' src='<?=base_url()?>js/plugins/jquery/jquery-1.9.1.min.js'></script>
<script language="javascript">
    function addproduct(id)
    {
        $.ajax({
            url: "<?php echo base_url();?>companies/addproduct",
            type: "post",
            data: "id=" + id + "&companyid=<?=$companyid?>",
            success: function (result) {
                $("#success").append(result);
            }
        });
    }
</script>

<?php
echo form_open('companies/AddProductions', array('id' => 'form_id', 'name' => 'form1'));
echo form_hidden('companyid', $companyid);
?>
<div id="success"></div>
<div class="block-fluid table-sorting clearfix">
    <table cellpadding="0" cellspacing="0" width="100%" class="table" id="tSortable">
        <thead>
            <tr>
                <th><input type="checkbox" name="checkall"/></th>
                <th>H.S Code</th>
                <th style="direction:rtl !important; text-align:right !important">المنتج</th>
                <th>Production</th>
                <!--<th>Actions</th>   -->
            </tr>
        </thead>
        <tbody>
            <?php
            //echo '<pre>';
            //var_dump($productions);
            //echo '</pre>';
            foreach($items as $item) {

                if($item->description_ar != '') {
                    $title_ar = $item->description_ar;


                    if($item->description_en != '') {
                        $title_en = $item->description_en;
                    }
                    else {
                        $title_en = $item->label_en;
                    }
                    if(in_array($item->id, $HeadingIds)) {
                        $disbled = TRUE;
                    }
                    else {
                        $disbled = FALSE;
                    }
                    ?>
                    <tr>
                        <td><input type="checkbox" name="checkbox1[]" value="<?=$item->id?>"
                    <?php if($disbled) {
                        echo 'disabled="disabled"';
                    }?>  /></td>
                        <td><?=$item->hs_code?></td>
                        <td style="direction:rtl !important; text-align:right !important">
                            <?php //'<strong>'.$item->label_ar.'</strong><br>'
                            echo $item->description_ar
                            ?></td>
                        <td><?php //'<strong>'.$item->label_en.'</strong><br>'.
                    echo $item->description_en
                            ?></td>
                        <!--<td>
                        <?php if(!$disbled) {?>
                    <a href="javascript:void(0)"  onClick="addproduct(<?=$item->id?>)" class="btn">Add</a>
                        <?php }
                        ?>
            </td>  -->
                    </tr>
                <?php }
            }?>
        </tbody>
    </table>
    <div class="footer tar">
        <center><input type="submit" name="save" value="Save" class="btn">
<?=anchor('companies/productions/'.$companyid, 'Cancel', array('class' => 'btn'))?>
        </center>
    </div>
</div>
<?php echo form_close();?>
