
<script type='text/javascript' src='<?=base_url()?>js/plugins/multiselect/jquery.multi-select.js'></script>
<script type='text/javascript' src='<?=base_url()?>js/plugins/jquery/jquery-1.9.1.min.js'></script>
<?php foreach ($query as $area) {
    //echo '<option value="'.$area->id.'">'.$area->label_ar . ' -' . $area->label_en.' ('.$area->TotalCompanies.' )'.'</option>';
    $array_area[$area->id]=$area->label_ar . ' -' . $area->label_en.' ('.$area->TotalCompanies.' )';
}?>
<?=form_multiselect('area_id[]', @$array_area, @$area_id, ' id="fmultiselect" class="multiselect"');?>