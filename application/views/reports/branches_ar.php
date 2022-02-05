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
					  echo form_hidden('lang','ar');
					   ?> 
                <div class="block-fluid">                        
                    <div class="row-form clearfix">
                        <div class="span6">Mohafaza (المحافظة)<br /><?php 
								$array_gov[0]='All ';
								foreach($governorates as $governorate)
								{
									if($governorate->id!=0)
									$array_gov[$governorate->id]=$governorate->label_ar;	
								}
											
								echo form_dropdown('gov',$array_gov,$gov_id);
							?>
                        </div>
                        <div class="span3"><br /><input type="submit" name="search" value="Search" class="btn">
                        <input type="submit" name="clear" value="Clear" class="btn">
                        </div>
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
			//	echo anchor('reports/branches/en','<h3 style="float:right !important; color:#FFF !important"> - English  </h3>');
				if($gov_id!=''){
			   echo anchor('reports/ExportGeoBanksAr/'.$gov_id,'<h3 style="float:right !important; color:#FFF !important">Export Arabic To Excel</h3>');
			   echo anchor('reports/ExportGeoBanksEn/'.$gov_id,'<h3 style="float:right !important; color:#FFF !important">Export English To Excel</h3>');
				}
        ?>                                  
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th>البريد اللكتروني</th>
                                <th>ص.ب</th>
                                <th>فاكس</th>
                                <th>هاتف</th>
                                <th>الشارع</th>
                                <th>المدينة</th>
                                <th>اسم المصرف</th>
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
                                <td style="text-align:right"><?=$row->email?></td>
                                <td style="direction:rtl !important; text-align:right !important"><?=$row->pobox_ar?></td>
                                <td style="text-align:right"><?=$row->fax?></td>
                                <td style="text-align:right"><?=$row->phone?></td>
                                <td style="direction:rtl !important; text-align:right !important"><?=$row->street_ar?></td>
                                <td style="text-align:right"><?=$row->area_ar?></td>
                                <td style="direction:rtl !important; text-align:right !important"><?=$row->bank_ar?></td>
                                <td><?=$i?></td>
                            </tr>
                            
                        <?php 
						$i++;
						} }
						else{
								echo '<tr>
                            	<td colspan="9"><center><strong>No Data Found</strong></center></td>
                            </tr>';
							}
						
						?>    
                        </tbody>
                        <tfoot>
                        	<tr>
                                <td colspan="9">
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
