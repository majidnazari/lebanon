
<script language="JavaScript" type="text/JavaScript">

    function printall()
        {
			checkboxes = document.getElementsByName('checkall');
			checkboxes.checked =true;
			document.getElementById("form_id").target = "_blank";
            document.getElementById("form_id").action = "<?=base_url().'companies/printall'?>";
            document.getElementById("form_id").submit();

        }
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
        <?php if(@$search){ ?>
       <div class="row-fluid">
            <div class="span12">
                 <div class="head clearfix">
                    <div class="isw-zoom"></div>
                    <h1>Search</h1>
                </div>
                <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation','method'=>'get'));
					  
					   ?> 
                  <div class="block-fluid">                        

                    <div class="row-form clearfix">
                        <div class="span2">ID : <br /><?php echo form_input($array_id); ?>
                        </div>

                        <div class="span3">Company Name (اسم الشركة)
						<br /><?php echo form_input($array_name); ?>
                        </div>

                        <div class="span4">Activity<br /><?php echo form_input($array_activity); ?></div>
                        <div class="span2">Phone<br /><?php echo form_input($array_phone); ?></div>
                        
                    </div>                            
                               

                    <div class="row-form clearfix">
                        <div class="span3">Mohafaza<br /><?php 
								$array_governorates[0]='All ';
								foreach($governorates as $governorate)
								{
									if($governorate->id!=0)
									$array_governorates[$governorate->id]=$governorate->label_ar;	
								}
											
								echo form_dropdown('gov',$array_governorates,$govID,$class_sect);
							?>
                        </div>

                        <div class="span3">Kazaa (القضاء)<br />
						<div id="datadistrict">
						<?php 
								$array_district[0]='All ';
								foreach($districts as $district)
								{
									if($district->id!=0)
									$array_district[$district->id]=$district->label_ar;	
								}
											
								echo form_dropdown('district_id',$array_district,$districtID,'  onchange="getarea(this.value)"');
							?>
                            </div>
                        </div>
                        <div class="span3">City (المنطقة)<br />
						<div id="area">
						<?php 
								$array_area[0]='All ';
								foreach($areas as $area)
								{
									if($area->id!=0)
									$array_area[$area->id]=$area->label_ar;	
								}
											
								echo form_dropdown('area_id',$array_area,$areaID);
							?>
                            </div>
                        </div>

                        <div class="span1">Status<br /><?php $array_status=array('all'=>'All','online'=>'Online','offline'=>'Offline');
												echo form_dropdown('status',$array_status,$status);
							?></div>
                        <div class="span3"><br /><input type="submit" name="search" value="Search" class="btn">
                        <input type="submit" name="clear" value="Clear" class="btn">
                        </div>
                    </div>                            
                </div>
				<?=form_close()?>
            </div>
        </div> 
        <?php } ?>
        <div class="row-fluid">
            <div class="span12">
            <?php if($msg!=''){ ?>
              	<div class="alert alert-success">               
                    <?php echo $msg;?>
                </div> 
                <?php } ?>    
                <?php //echo form_open('',array('id'=>'form_id','name'=>'form1'));

				?>   
                                          
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
                        <ul class="buttons">
                                <li><?=_show_delete_checked('#',$p_delete)?></li>
                                <li><a href="javascript:void(0)" onclick="printall()"><h3>Print Selected</h3></a></li>
                                <?php if(@$search){ ?>
                                 <li><?=anchor('companies/listview?gov='.$govID.'&district_id='.$districtID.'&status='.$status,'<h3>Print List</h3>')?></li>
                                 <?php } ?>
                                <li>
                                    <a href="#" class="isw-settings"></a>
                                    <ul class="dd-list">
                                        <li><?=anchor('companies/reset-advertisment','Reset Advertisment','class="sub-link"')?></li>
                                        <li><?=anchor('companies/reset-reservations','Reset Copy Reservations','class="sub-link"')?></li>
                                        <li><?=anchor('companies/put-online','Put Online','class="sub-link"')?></li>
                                        <li><?=anchor('companies/put-offline','Put Offline','class="sub-link"')?></li>
                                    </ul>
                                </li>
                            </ul>                                      
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th style="text-align:center">اسم الشركة</th>
                                <th style="text-align:center">Phone1</th>
                                <th style="text-align:center">Phone2</th>
                                <th style="text-align:center">Phone3</th>
                                <th style="text-align:center">Mobile1</th>
                                <th style="text-align:center">Mobile2</th>
                                <th style="text-align:center" width="16%">قضاء - بلدة - شارع - مبنى</th>
                                <th style="text-align:center" width="16%">الشركات</th>
                                <th>Actions</th>                                    
                            </tr>
                        </thead>
                        <tbody> 
                        <?php

						if(count($query)>0){
						foreach($query as $row){
                            $report=$this->Company->GetMinistryReport($row->id);
                            if(count($report)<=0) {
                                $companies = $this->Company->GetCompaniesByMinistry($row->phone1, @$row->phone2, $row->phone3, $row->mobile1, $row->mobile2);
                                echo form_open('companies/save_report', array('id' => 'form_id' . $row->id, 'name' => 'form' . $row->id));
                                echo form_hidden('ministry_title', $row->name);
                                echo form_hidden('ministry_id', $row->id);
                                echo form_hidden('phone1', $row->phone1);
                                echo form_hidden('phone2', $row->phone2);
                                echo form_hidden('phone3', $row->phone3);
                                echo form_hidden('mobile1', $row->mobile1);
                                echo form_hidden('mobile2', $row->mobile2);
                                ?>
                                <tr>
                                    <td><?= $row->id ?></td>
                                    <td><?= $row->name ?></td>
                                    <td><?= $row->phone1 ?></td>
                                    <td><?= $row->phone2 ?></td>
                                    <td><?= $row->phone3 ?></td>
                                    <td><?= $row->mobile1 ?></td>
                                    <td><?= $row->mobile2 ?></td>
                                    <td><?= @$row->district . ' - ' . @$row->area . ' - ' . @$row->street . ' - ' . @$row->address ?></td>
                                    <td>
                                        <table>
                                            <thead>
                                            <tr>
                                                <th>Company ID</th>
                                                <th>Wezara ID</th>
                                                <th>Name</th>
                                            </tr>
                                            </thead>
                                            <?php

                                            foreach ($companies as $company) {

                                                echo '<tr><td>' . $company->id . '</td><td>' . $company->ministry_id . '</td><td>' . $company->name_ar . '</td></tr>';
                                            }

                                            ?>
                                        </table>
                                    </td>

                                    <td>

                                        <?php
                                        if (count($companies) == 0) {
                                            echo anchor('companies/insert/' . $row->id, '<span class="isb-plus"></span>');
                                        } elseif (count($companies) == 1 and $companies[0]->ministry_id == $row->id) {
                                            echo _show_delete('companies/delete/id/' . $row->id . '/p/ministry/cid/' . $companies[0]->id, $p_delete);
                                        } else {
                                            echo form_submit('save', 'Add To Report', 'class="btn"');
                                            echo anchor('companies/ministry_delete/' . $row->id , 'Delete',array('class'=>'btn'));

                                        }


                                        ?>
                                    </td>
                                </tr>

                                <?php
                            }
                            echo form_close();
						}
						}
						else{
								echo '<tr>
                            	<td colspan="10"><center><strong>No Data Found</strong></center></td>
                            </tr>';
							}
						
						?>    
                        </tbody>
                        <tfoot>
                        	<tr>
                                <td colspan="10">Total : <?=$total_row?><div class="dataTables_paginate paging_full_numbers"><?=$links?></div></td></tr>
                        </tfoot>
                    </table>
                    
                </div>
                <?php // echo form_close();?>
            </div>                                
        </div>            
        <div class="dr"><span></span></div>            
    </div>
</div>
