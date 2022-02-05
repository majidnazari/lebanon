
<script language="javascript">
$(function () {
    $(".datep").datepicker({
        dateFormat: "yy-mm-dd"
    });
})


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
                    <div class="isw-zoom"></div>
                    <h1>Search</h1>
                </div>
                <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation','method'=>'get'));
                       echo form_hidden('id',$id);
                ?>
                  <div class="block-fluid">
                    <div class="row-form clearfix">
                        <div class="span3">From : <br /><?php echo form_input(array('name'=>'from','value'=>@$from,'class'=>'datep')); ?></div>
                        <div class="span3">To<br /><?php echo form_input(array('name'=>'to','value'=>@$to,'class'=>'datep')); ?></div>
                        <div class="span3">Category<br /><?php
                        $array_categories=array(''=>'Select','printed'=>'Printed','other'=>'Other');
                            echo form_dropdown('category',$array_categories,@$category); ?></div>
                        <div class="span3">
                            <br /><input type="submit" name="search" value="Search" class="btn">
                            <?=anchor('tasks/logs?id='.$id,'Clear',array('class'=>'btn'))?>
                        </div>

                    </div>                            
                </div>
				<?=form_close()?>
            </div>
        </div>
        <script>
            function SubmitForm(id)
            {
                document.getElementById("form_id").action = "<?=base_url().'tasks/update_status/'?>"+id;
                document.getElementById("form_id").submit();

            }
        </script>
        <div class="row-fluid">
            <div class="span12">
            <?php if($msg!=''){ ?>
              	<div class="alert alert-success">               
                    <?php echo $msg;?>
                </div> 
                <?php } ?>    
                <?php echo form_open('',array('id'=>'form_id','name'=>'form1'));

				?>

                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
                </div>
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th style="text-align:center"  width="20%">Date</th>
                                <th style="text-align:center"  width="20%">Category</th>
                                <th style="text-align:center"  width="40%">Notes</th>
                                <th style="text-align:center" width="20%">User </th>
                            </tr>
                        </thead>
                        <tbody> 
                        <?php 
						if(count($query)>0){
						foreach($query as $row){
							?>
                            <tr>
                                <td style="text-align:center"><?=$row->create_time?></td>
                                <td style="text-align:center"><?=$row->category?></td>
                                <td><?=$row->note?></td>
                                <td style="text-align:center"><?=$row->username?></td>
                            </tr>


                        <?php
						} }
						else{
                            echo '<tr><td colspan="4"><center><strong>No Data Found</strong></center></td></tr>';
							}
						
						?>    
                        </tbody>
                        <tfoot>
                        	<tr>
                                <td colspan="4">Total : <?=$total_row?><div class="dataTables_paginate paging_full_numbers"><?=$links?></div></td></tr>
                        </tfoot>
                    </table>
                    
                </div>
                <?php echo form_close();?>
            </div>                                
        </div>            
        <div class="dr"><span></span></div>            
    </div>
</div>
