<div class="content">
	<?=$this->load->view("includes/_bread")?>
            <div class="workplace">
                <div class="page-header">
                    <h1><small><?=$query['country']?></small></h1>
                </div>                  
                
                <div class="row-fluid">

                <div class="span6">   
                <?php if($msg!=''){ ?>
              	<div class="alert alert-success">               
                    <?php echo $msg;?>
                </div> 
                <?php } ?>                   
                        <div class="row-fluid">
                            <div class="span3">
                                <div class="ucard clearfix">                                    
                                    <div class="right">
                                        <h4><?=$query['country']?><br /><?=$query['country_ar']?></h4>
                                        <div class="image">
                                           <img src="<?=base_url().$query['flag']?>" width="120" class="img-polaroid">                                        </div>
                                           
                                        <ul class="control">             
                                         <?php if($p_edit){ ?>
                                            <li><span class="icon-pencil"></span> <?=anchor('countries/edit/id/'.$query['id'],'Edit')?></li>
                                            <?php }
											if($p_delete){ ?>
                                            <li><span class="icon-trash"></span> <?=anchor('countries/delete/id/'.$query['id'],'Delete')?></li>
                                            <?php } ?>
                                        </ul>                                                                                     
                                    </div>
                                </div>                                 
                            </div>
<div class="span9">
                                <div class="block-fluid ucard">

                                        <div class="info">                                                                
                                            <ul class="rows">
                                                <li class="heading">Country info</li>
                                                <li>
                                                    <div class="title">Name in english:</div>
                                                    <div class="text"><?=$query['country']?></div>
                                                </li>
                                                <li>
                                                    <div class="title">Name in arabic:</div>
                                                    <div class="text"><?=$query['country_ar'].'.'?></div>
                                                </li>
                                                <li>
                                                    <div class="title">Country Code:</div>
                                                    <div class="text"><?=$query['code'].'.'?></div>
                                                </li>
                                                <li>
                                                    <div class="title">Create Date:</div>
                                                    <div class="text"><?=$query['create_time']?></div>
                                                </li>
                                                <li>
                                                    <div class="title">Last Update Date:</div>
                                                    <div class="text"><?=$query['update_time']?></div>
                                                </li>
                                                <li>
                                                    <div class="title">Status:</div>
                                                    <div class="text"><?php 
															if($query['status']=='online')
																echo '<span class="label label-success">Online</span>';
																else
																echo '<span class="label">Offline</span>';?>
                                                   </div>
                                                </li>                                     
                                            </ul>                                                      
                                        </div>                        
                                </div>
                            </div>
                            </div>
                            </div>
                            <div class="span6">        
                           <?php echo form_open('countries/delete_checked_cities',array('id'=>'form_id','name'=>'form1'));
						   		echo form_hidden('country_id',$query['id']);
						   ?>                                
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1>Countries Details List</h1>
                    
                     <?=_show_delete_checked('#',$p_delete)?>                               
                     <?='<h2 style=" float:right; margin-right:10px">'.anchor('countries/create_cities','Add Cities',array('style'=>'color:#FFF')).'</h2>'?>
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table" id="tSortable">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="checkall"/></th>
                                <th>City</th>
                                <th>Status</th>
                                <th>Create Date / Last Update Date</th>                                
                                <th>Actions</th>                                    
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($cities as $city){?>
                            <tr>
                                <td><input type="checkbox" name="checkbox1[]" value="<?=$city->id?>"/></td>
                                <td><?=$city->city." / ".$city->city_ar?></td>
                                <td><?php 
								if($city->status=='online')
								echo '<span class="label label-success">Online</span>';
								else
								echo '<span class="label">Offline</span>';
								?></td>
                                <td><?=$city->create_time." / ".$city->update_time?></td>
                                <td><?php 
										echo _show_delete('countries/city_delete/id/'.$city->id.'/country_id/'.$query['id'],$p_delete);
										echo _show_edit('countries/edit_city/id/'.$city->id.'/country_id/'.$query['id'],$p_edit);
									?>                                        
                                </td>                                    
                            </tr>
                        <?php } ?>    
                        </tbody>
                    </table>
                </div>
                <?php echo form_close();?>

                            </div>                                
                        </div>
                    </div>
                                     

                </div>            

                            

                <div class="dr"><span></span></div>           


            </div>

        </div>