
<?php 
$row_s=$this->Client->getShowItemsClientStatus($client_id,$client_type);
$query = $this->Company->GetCompanyById($id);
if(!isset($adv_pic))
{
    $adv_pic="";
}
if(!isset($start_date_adv))
{
    $start_date_adv="";
}
if(!isset($end_date_adv))
{
    $end_date_adv="";
}
$start_date_adv = array('id' => 'start_date_adv', 'name' => 'start_date_adv', 'value' => $start_date_adv);
$end_date_adv = array('id' => 'end_date_adv', 'name' => 'end_date_adv', 'value' => $end_date_adv);
$array_adv_pic = array('id' => 'adv_pic', 'name' => 'adv_pic', 'value' => $adv_pic);
?>
<script language="javascript">

    $(function () {
        $(".datep").datepicker({
            dateFormat: "yy-mm-dd"
        });
        $("#end_date_adv").datepicker({
            dateFormat: "yy-mm-dd"
        });
        $("#start_date_adv").datepicker({
            dateFormat: "yy-mm-dd"
        });
        $("#delivery_date").datepicker({
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
        <h1>Advertisement</h1>
    </div>
    <?php echo form_open_multipart($this->uri->uri_string(), array('id' => 'validation')); ?>
    <input type="hidden" id="market_id" value="1" />
    <input type="hidden" id="clientId" value="<?=$client_id?>" />
    <input type="hidden" id="clientType" value="<?=$client_type?>" />
    <input type="hidden" id="statusType" value="<?=$status_type?>" />

    <div class="block-fluid">  
        <div class="row-form clearfix">
                <div class="row-form clearfix">
                    <div class="span4">Sales Man:</div>
                    <div class="span8">
                            <?php 
                            $salesc_array = array(0 => 'اختر');
                            if(!isset($sales))
                            {
                            $sales= $this->data['sales'] = $this->Company->GetSalesMen();
                            }
                            if (count($sales) > 0) {
                                foreach ($sales as $item) {

                                    $salesc_array[$item->id] = $item->fullname;
                                }
                            }
                            echo form_dropdown('adv_salesman_id', $salesc_array,$query['adv_salesman_id'] /*@$row_s->sales_man_id*/, 'style="direction:rtl" id="adv_salesman_id"'); ?>
                    </div>
                </div>
                <div class="row-form clearfix">

                        <div class="span4">File Name :</div>
                        <div class="span8"> 
                            <?= form_input($array_adv_pic) ?>                               
                        </div>
                        
                </div>                    


            <div class="row-form clearfix">
                <div class="span3">Start Date:</div>
                <div class="span7"><?php echo form_input($start_date_adv); ?>
                                                <font color="#FF0000"><?php echo form_error('start_date_adv'); ?></font>
                    <!-- <?php echo form_input(['name'=>'start_date_adv','class'=>'datep','id'=>'startDate','value'=>@$row_s->start_date]); ?>
                    <font color="#FF0000"><?php echo form_error('start_date_adv'); ?></font> -->
                </div>
            </div>
            <div class="row-form clearfix">
                <div class="span3">End Date:</div>
                <div class="span7">
                    <?php echo form_input($end_date_adv); ?>
                    <font color="#FF0000"><?php echo form_error('end_date_adv'); ?></font>
                    <!--<?php echo form_input(['name'=>'end_date_adv','class'=>'datep','id'=>'endDate','value'=>@$row_s->end_date]); ?>
                    <font color="#FF0000"><?php echo form_error('end_date_adv'); ?></font> -->
                </div>
            </div>
                
            <div class="row-form clearfix">
                    <div class="span3">Status:</div>
                    <div class="span7">
                        <?php  $array_status=array('1'=>'Active','0'=>'Inactive');
                        echo form_dropdown('status_adv',$array_status,@$status_adv,' id="status_adv"');
                        ?>                                     
                        <!-- <?php $array_status=array('inactive'=>'Inactive','active'=>'Active');
                            echo form_dropdown('status_adv',$array_status,@$row_s->status,' id="status_adv"');
                            ?> -->
                    </div>
            </div>
        </div>
    </div>
            
    <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Copy Reservation </h1>
                    <!-- <h1 style="float:right; margin-right:10px;">ملاحظات شخصية</h1> -->
    </div>


    <div class="block-fluid">                          
        <div class="row-form clearfix">

            <div class="row-form clearfix">
                <div class="span5" style="text-align:left"> Copy Res Salesman </div>
                <div class="span7">
                        <?php
                        $sales_array = array(0 => 'اختر');
                        if (count($sales) > 0) {
                            foreach ($sales as $item) {

                                $sales_array[$item->id] = $item->fullname;
                            }
                        }
                        echo ''.form_dropdown('copy_res_salesman_id', $sales_array, @$query['copy_res_salesman_id'], 'style="direction:rtl"'); ?>
                                        
                        
                </div>
            </div>

            <div class="row-form clearfix">
                        <div class="span3">Copy Res:</div>
                        <div class="span2"><?php 
                                if ($copy_res == 1) {
                                    $checkedcopy_res = TRUE;
                                } else {
                                    $checkedcopy_res = FALSE;
                                }
                                echo  form_checkbox('copy_res', 1, $checkedcopy_res); ?>
                        </div>
                        <div class="span5">Copy Res. Bold:</div>
                        <div class="span1"><?php 
                                if (@$query['copy_res_bold'] == 1) {
                                    $checkedcopy_res_bold = TRUE;
                                } else {
                                    $checkedcopy_res_bold = FALSE;
                                }
                                echo  form_checkbox('copy_res_bold', 1, $checkedcopy_res_bold); ?>
                         </div>
             </div>
            
           
            <div class="row-form clearfix">                    
                <!-- <div class="span1">Online </div> -->
                <div class="span2"><?php 
                    if ($show_online == 1) {
                        $checkedonline = TRUE;
                    } else {
                        $checkedonline = FALSE;
                    }
                    echo "Online ".  form_checkbox('show_online', 1, $checkedonline); ?>
                </div>
                <!-- <div class="span3">Update Info</div> -->
                <div class="span4"><?php
                    if ($query['acc'] == "yes") {
                        $checkedacc = TRUE;
                    } else {
                        $checkedacc = FALSE;
                    }
                    echo "Update Info ".date('Y'). form_checkbox('acc', 1, $checkedacc); ?>
                </div>
                <!-- <div class="span4">ACC.Done </div> -->
                <div class="span4"><?php 
                    if (0 == 1) {
                        $checkedtask_status = TRUE;
                    } else {
                        $checkedtask_status = FALSE;
                    }
                    echo "ACC.Done " . date('Y').' '. form_checkbox('task_status', 1, $checkedtask_status); ?>
                </div>
            </div> 

        </div>
    </div> 

    <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Delivery</h1>
                    <!-- <h1 style="float:right; margin-right:10px;">ملاحظات شخصية</h1> -->
    </div>


    <div class="block-fluid">            
            
        <div class="row-form clearfix">
            <div class="row-form clearfix">
                <div class="span4">Delivery Date</div>
                <div class="span8">
                    <?= form_input(array('name'=>'delivery_date', 'id' => 'delivery_date', 'value' => @$query['delivery_date'], 'style' => 'direction:rtl')); ?>
                </div>
                
            </div>
            <div class="row-form clearfix">
                <div class="span4">Delivery By</div>
                <div class="span8">
                    <?php
                        echo form_dropdown('delivery_by', $sales_array, @$query['delivery_by'], 'style="direction:rtl"'); ?>
                </div>
                
            </div>
            <div class="row-form clearfix">

                <div class="span4">Copy Quantity</div>
                <div class="span8">
                        <?= form_input(array('name'=>'copy_qty', 'id' => 'copy_qty', 'value' => @$query['copy_qty'])); ?>
                </div>       
        
            </div>
            <div class="row-form clearfix">                                 
                
                <div class="span4">Receiver Name</div>
                <div class="span8">
                        <?= form_input(array('name'=>'receiver_name', 'id' => 'receiver_name', 'value' => @$query['receiver_name'], 'style' => 'direction:rtl')); ?>
                </div>

            </div>
            <div class="row-form clearfix">                                 
                
                <div class="span4">Sales Note</div>
                <div class="span8">
                <?php echo form_textarea(array('name'=>'sales_note','value'=>@$query['sales_note'])); ?>
                </div>

            </div>
            <div class="footer tar">
                <center><button class="btn" id="saveBtn">Save</button> <div id="itemMsg" style="color:#FF0000"></div></center>
                
            </div>
        </div>
    </div>
              