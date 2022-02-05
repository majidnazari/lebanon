<div class="content">
	<?=$this->load->view("includes/_bread")?>
    <div class="workplace">
        <div class="page-header">
            <h1><?=$subtitle;?></h1>
        </div> 
        <div class="row-fluid">
            <div class="span12">
                <?php echo form_open('',array('id'=>'form_id','name'=>'form1'));?>
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
                </div>
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th style="text-align:center"  width="15%">Sales Man</th>
                                <th style="text-align:center"  width="15%">July</th>
                                <th style="text-align:center"  width="15%">August</th>
                            </tr>
                        </thead>
                        <tbody> 
                        <?php

						if(count($salesmen)>0){
						foreach($salesmen as $salesman){
						    $july=$this->Task->GetMonthlyTasks($salesman->id,7);
                            $august=$this->Task->GetMonthlyTasks($salesman->id,8);



                            ?>
                            <tr>
                                <td style="text-align:center"><?=$salesman->fullname?></td>
                                <td style="text-align:center"><?php echo (@$july[0]->total_tasks != '') ? @$july[0]->total_tasks : 0;?></td>
                                <td style="text-align:center"><?php echo (@$august[0]->total_tasks != '') ? @$august[0]->total_tasks : 0;?></td>

                            </tr>
                            
                        <?php } }
						else{
								echo '<tr>
                            	<td colspan="7"><center><strong>No Data Found</strong></center></td>
                            </tr>';
							}

						?>    
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                    
                </div>
                <?php echo form_close();?>
            </div>                                
        </div>            
        <div class="dr"><span></span></div>            
    </div>
</div>
