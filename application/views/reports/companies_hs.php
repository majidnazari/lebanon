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
                <?php echo form_open_multipart('reports/companies_hs',array('id'=>'validation','method'=>'get'));
					   ?> 
                <div class="block-fluid">                        
                    <div class="row-form clearfix">
                        <div class="span3">H.S.Code (Number)</div>
                        <div class="span1"><?=form_dropdown('op',array('equal'=>'=','greater'=>'>','less'=>'<'),@$op);?></div>
                        <div class="span3"><?php 
								$array['']='Any ';
								for($i=0;$i<31;$i++)
								{
									$array[$i]=$i;	
								}
											
								echo form_dropdown('nbr',$array,$nbr);
							?>
                        </div>
                         <div class="span1"><input type="submit" name="search" value="Search" class="btn"></div>
                         <div class="span1"><?=anchor('reports/companies_hs','Clear',array('class'=>'btn'))?></div>
                        
                       
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
			   echo anchor('reports/ExportCompaniesHSCode?nbr='.$nbr.'&op='.$op,'<h3 style="float:right !important; color:#FFF !important">Export Result To Excel</h3>');
			  
        ?>                                  
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                            	<th>Company ID</th>
                            	<th>Company Name Ar</th>
                            	<th>Company Name En</th>
                            	<th>H.S.Code Count</th>
                             </tr>
                        </thead>
                        <tbody>
                        <?php
						foreach($query['results'] as $row)
						{
							echo '<tr><td>'.$row->id.'</td><td>'.$row->name_ar.'</td><td>'.$row->name_en.'</td><td>'.$row->hscode_count.'</td></tr>';
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
