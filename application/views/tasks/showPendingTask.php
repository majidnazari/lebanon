
<script language="javascript">
    $(document).ready(function() {
        $('#tSortable3').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "../server_side/scripts/server_processing.php"
        } );
    } );


    function ShowDeliveryDate(value,id)
    {
        if(value=='done')
        {
            $("#delivery"+id).show();
        }
        else{
            $("#delivery"+id).hide();
        }

    }

$(function () {
    $(".delivery-date").hide();
    $(".select2").select2();
    $(".datep").datepicker({
        dateFormat: "yy-mm-dd"
    });
})

$(document).ready(function () {
    $("#company").select2({
        <?php if(count(@$company_array)>0){ ?>
        initSelection: function(element, callback) {
            callback({id: <?=$company_array['id']?>, text: "<?=$company_array['name_ar']?>" });
        },
        <?php } ?>
        placeholder: 'اختر الشركة',
        allowClear: true,
        ajax: {
            url: "<?=base_url()?>tasks/GetCompanies",
            dataType: 'json',
            delay: 250,
            data: function (query) {
                if (!query) query = 'Москва';

                return {
                    geocode: query,
                    format: 'json'
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            results: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });
});

</script>

<script language="JavaScript" type="text/JavaScript">

    function printall()
        {
			checkboxes = document.getElementsByName('checkall');
			checkboxes.checked =true;
			document.getElementById("form_id").target = "_blank";
            document.getElementById("form_id").action = "<?=base_url().'companies/printall'?>";
            document.getElementById("form_id").submit();

        }

    function printarea()
    {
        checkboxes = document.getElementsByName('checkall');
        checkboxes.checked =true;
        //document.getElementById("form_id").target = "_blank";
        document.getElementById("form_id").action = "<?=base_url().'companies/task_create'?>";
        document.getElementById("form_id").submit();

    }
</script>
<style type="text/css">
.sub-link{
	padding-left:10px !important;
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
                <div class="isw-grid"></div>
                <h1><?=$subtitle;?></h1>
            </div>
            <div class="block-fluid table-sorting clearfix">
                <table cellpadding="0" cellspacing="0" width="100%" class="table" id="tSortable">
                    <thead>
                    <tr>
                        <th style="text-align:center" width="10%">ID</th>
                        <th style="text-align:center"  width="20%">اسم الشركة</th>

                        <th style="text-align:center" width="10%">العنوان</th>
                        <th style="text-align:center"  width="10%">اللائحة / المندوب</th>
                        <th  width="10%">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    if(count($query)>0){
                    foreach($query as $row){
                    ?>
                        <tr>
                            <td><?=$row->id?></td>
                            <td><?=anchor('companies/details/'.$row->company_id,$row->name_ar.'<br>'.$row->name_en)?></td>
                            <td><?php

                                echo $row->governorate_ar.' - '.$row->district_ar.' - '.$row->area_ar.' - '.$row->street_ar?></td>
                            <td><?=$row->sales_man_ar.' ( '.$row->list_id.' )';?></td>
                            <td nowrap="nowrap"><?=anchor('companies/view/'.$row->company_id,'<span class="isb-print"></span>',array('target'=>'_blank'));?></td>
                        </tr>

                    <?php } }


                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
        <div class="dr"><span></span></div>
    </div>
</div>
