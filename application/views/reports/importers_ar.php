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
				echo anchor('reports/importers/en','<h3 style="float:right !important; color:#FFF !important"> - English  </h3>');
			   echo anchor('reports/export_importers/ar','<h3 style="float:right !important; color:#FFF !important">Export To Excel</h3>');
        ?>                                  
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th>البريد اللكتروني</th>
                                <th>فاكس</th>
                                <th>هاتف</th>
                                <th>الشارع</th>
                                <th>المدينة</th>
                                <th>قضاء</th>
                                <th>الشركة</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
						foreach($activities as $activity)
						{
							echo '<tr><td colspan="7" align="center"><center><h3>'.$activity->label_ar.'</h3></center></td></tr>';
						if(count($query)>0){
							$i=1;
						foreach($query as $row){
							$array_activity=array();
							$array_activity=explode(',',$row->activities);
							if(in_array($activity->id,$array_activity)){
							?>
                            <tr>
                                <td style="text-align:right"><?=$row->email?></td>
                                <td style="text-align:right"><?=$row->fax?></td>
                                <td style="text-align:right"><?=$row->phone?></td>
                                <td style="direction:rtl !important; text-align:right !important"><?=$row->street_ar?></td>
                                <td style="text-align:right"><?=$row->area_ar?></td>
                                <td style="text-align:right"><?=$row->district_ar?></td>
                                <td style="direction:rtl !important; text-align:right !important"><?=$row->name_ar?></td>
                            </tr>
                            
                        <?php 
							}
								} 
							}	
						
						}
						
						?>    
                        </tbody>
                        <tfoot>
                        	<tr>
                                <td colspan="7">
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
