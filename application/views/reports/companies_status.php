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
                <?php echo form_open_multipart('reports/companies_status',array('id'=>'validation','method'=>'get'));
					   ?> 
                <div class="block-fluid">                        
                    <div class="row-form clearfix">
                        <div class="span3">Status<br><?=form_dropdown('status',array(''=>'Any',1=>'Online',0=>'Offline'),@$status);?></div>
                        <div class="span3">Closed<br><?=form_dropdown('closed',array(''=>'Any',1=>'Yes',0=>'No'),@$closed);?></div>
                        <div class="span3">Wrong Address<br><?=form_dropdown('wrong_address',array(''=>'Any',1=>'Yes',0=>'No'),@$wrong_address);?></div>
                         <div class="span1"><br><input type="submit" name="search" value="Search" class="btn"></div>
                         <div class="span1"><br><?=anchor('reports/companies_hs','Clear',array('class'=>'btn'))?></div>
                        
                       
                    </div>                         
                </div>
				<?=form_close()?>
            </div>
        </div> 
        
				
       
        <div class="row-fluid">
            <div class="span12">
                <?php echo form_open('',array('id'=>'form_id','name'=>'form1'));?>   
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
					 <?php 
					 echo '<h3 style="float:right !important; color:#FFF !important">Total : '.$query['num_results'].'</h3>';
					 echo anchor('reports/ViewCompaniesStatus?status='.$status.'&closed='.$closed.'&wrong_address='.$wrong_address,'<h3 style="float:right !important; color:#FFF !important">View Result List</h3>',array('target'=>'_blank')).'&nbsp&nbsp';
			   echo anchor('reports/ExportCompaniesStatus?status='.$status.'&closed='.$closed.'&wrong_address='.$wrong_address,'<h3 style="float:right !important; color:#FFF !important">Export Result To Excel</h3>');
			  
        ?>                                  
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                            	<th>Company ID</th>
                            	<th>Company Name Ar</th>
                            	<th>Company Name En</th>
                            	<th>Mohafaza</th>
                            	<th>Kazaa</th>
                            	<th>Area</th>
                            	<th>Activity</th>
                            	<th>Status</th>
                            	<th>Closed</th>
                            	<th>Wrong Address</th>
                            	<th>Personal Notes</th>
                             </tr>
                        </thead>
                        <tbody>
                        <?php
						foreach($query['results'] as $row)
						{
							echo '<tr><td>'.$row->id.'</td><td>'.$row->name_ar.'</td><td>'.$row->name_en.'</td><td>'.$row->governorate_ar.'</td><td>'.$row->district_ar.'</td>
							<td>'.$row->area_ar.'</td><td>'.$row->activity_ar.'</td>
							<td>'.(($row->show_online == 1) ? 'Online' : 'Offline').'</td>
							<td>'.(($row->is_closed == 1) ? 'Yes' : 'No').'</td>
							<td>'.(($row->error_address == 1) ? 'Yes' : 'No').'</td>
							<td>'.$row->personal_notes.'</td>
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
