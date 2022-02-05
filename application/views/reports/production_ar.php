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
					 <?php 
				echo anchor('reports/productions/en','<h3 style="float:right !important; color:#FFF !important"> - English  </h3>');
			   echo anchor('reports/export_productions/ar','<h3 style="float:right !important; color:#FFF !important">Export To Excel</h3>');
        ?>                                  
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th>رقم البند</th>
                                <th>السلعة</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
						if(count($query)>0){
							$i=1;
						foreach($query as $row){
							?>
                            <tr>
                                <td><?=$row->hs_code_print?></td>
                                <td style="direction:rtl !important; text-align:right !important"><?=$row->description_ar?></td>
                                <td><?=$i?></td>
                            </tr>
                            
                        <?php 
						$i++;
						} }
						else{
								echo '<tr>
                            	<td colspan="3"><center><strong>No Data Found</strong></center></td>
                            </tr>';
							}
						
						?>    
                        </tbody>
                        <tfoot>
                        	<tr>
                                <td colspan="3">
                                <?php if(count($query)>0){ ?>
                                Total : <?=count($query)?>
                                <?php } ?>
                                </td></tr>
                        </tfoot>
                    </table>
                    
                </div>
                <?php echo form_close();?>
            </div>                                
        </div>            
        <div class="dr"><span></span></div>            
    </div>
</div>
