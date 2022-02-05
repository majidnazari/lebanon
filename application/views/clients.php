<?php 
$row_s=$this->Client->getShowItemsClientStatus($client_id,$client_type);
?>
<script language="javascript">

    $(function () {
        $(".datep").datepicker({
            dateFormat: "yy-mm-dd"
        });
        $("#saveBtn").click(function(){
            var client_id=$("#clientId").val();
            var client_type=$("#clientType").val();
            var status_type=$("#statusType").val();
            var start_date=$("#startDate").val();
            var end_date=$("#endDate").val();
            var status=$("#ClientStatus").val();
             var sales_man_id=$("#salesManId").val();
             $.post("<?=base_url()?>ajax/saveItems", {
                 client_id: client_id,
                 client_type:client_type,
                 status_type:status_type,
                 start_date:start_date,
                 end_date:end_date,
                 sales_man_id:sales_man_id,
                 status:status
             }, function(result){
                $("#itemMsg").html(result);
              });
              return false;
        });
    })
    
 </script>
<div class="head clearfix">
    <div class="isw-documents"></div>
    <h1><?=$title?></h1>
</div>
<input type="hidden" id="clientId" value="<?=$client_id?>" />
<input type="hidden" id="clientType" value="<?=$client_type?>" />
<input type="hidden" id="statusType" value="<?=$status_type?>" />
<div class="block-fluid">
    <div class="row-form clearfix">
        <div class="span3">Start Date:</div>
        <div class="span7"><?php echo form_input(['name'=>'start_date','class'=>'datep','id'=>'startDate','value'=>@$row_s->start_date]); ?>
            <font color="#FF0000"><?php echo form_error('start_date'); ?></font>
        </div>
    </div>
    <div class="row-form clearfix">
        <div class="span3">End Date:</div>
        <div class="span7"><?php echo form_input(['name'=>'end_date','class'=>'datep','id'=>'endDate','value'=>@$row_s->end_date]); ?>
            <font color="#FF0000"><?php echo form_error('end_date'); ?></font>
        </div>
    </div>
      <div class="row-form clearfix">
        <div class="span3">Sales Man:</div>
    <div class="span6">
        <?php
        $salesc_array = array(0 => 'اختر');
        if (count($sales) > 0) {
            foreach ($sales as $item) {

                $salesc_array[$item->id] = $item->fullname;
            }
        }
        echo form_dropdown('sales_man_id', $salesc_array, @$row_s->sales_man_id, 'style="direction:rtl" id="salesManId"'); ?>
        </div>
    </div>                    
    <div class="row-form clearfix">
        <div class="span3">Status:</div>
        <div class="span7"><?php $array_status=array('active'=>'Active','inactive'=>'Inactive');
            echo form_dropdown('client_status',$array_status,@$row_s->status,' id="ClientStatus"');
            ?></div>
    </div>
    
    <div class="footer tar">
        <center><button class="btn" id="saveBtn">Save</button> <div id="itemMsg" style="color:#FF0000"></div></center>
        
    </div>
</div>
