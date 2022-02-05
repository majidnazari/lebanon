<div class="content">
	<?=$this->load->view("includes/_bread")?>
            <div class="workplace">
                <div class="page-header">
                    <h1>User info <small><?=$query['fullname']?></small></h1>
                </div>                  
                <div class="row-fluid">
                <div class="span12">   
                <?php if($msg!=''){ ?>
              	<div class="alert alert-success">               
                    <?php echo $msg;?>
                </div> 
                <?php } ?>                   
                        <div class="row-fluid">
                            <div class="span3">
                                <div class="ucard clearfix">                                    
                                    <div class="right">
                                        <h4><?=$query['fullname']?></h4>
                                        <div class="image">
                                           <img src="<?=base_url()?>img/user.png" width="150" class="img-polaroid">                                        </div>
                                        <ul class="control"> 
                                        <?php if($p_edit){ ?>               
                                            <li><span class="icon-pencil"></span> <?=anchor('users/edit/id/'.$query['id'],'Edit')?></li>
                                            <?php }
											if($p_delete){ ?>
                                            <li><span class="icon-user"></span><?=anchor('users/status/id/'.$query['id'],'Status')?></li>
                                            <?php } ?>
                                            <li><span class="icon-wrench"></span> <?=anchor('users/change_password/id/'.$query['id'],'Change Password')?></li>
                                        </ul>                                                                                     
                                    </div>
                                </div>                                 
                            </div>                                                                                
                            <div class="span9">
                                <div class="block-fluid ucard">

                                        <div class="info">                                                                
                                            <ul class="rows">
                                                <li class="heading">User info</li>
                                                <li>
                                                    <div class="title">Name:</div>
                                                    <div class="text"><?=$query['fullname']?>&nbsp;</div>
                                                </li>
                                                <li>
                                                    <div class="title">Username:</div>
                                                    <div class="text"><?=$query['username']?>&nbsp;</div>
                                                </li>
                                                <li>
                                                    <div class="title">Email:</div>
                                                    <div class="text"><?=$query['email']?>&nbsp;</div>
                                                </li>
                                                <li>
                                                    <div class="title">Phone:</div>
                                                    <div class="text"><?=$query['phone']?>&nbsp;</div>
                                                </li>
                                                <li>
                                                    <div class="title">Address:</div>
                                                    <div class="text"><?=$query['address']?>&nbsp;</div>
                                                </li> 
												<li>
                                                    <div class="title">Status:</div>
                                                    <div class="text"><?=$query['status']?>&nbsp;</div>
                                                </li>                                                                                     
                                            </ul>                                                      
                                        </div>                        
                                </div>

                            </div>
                     </div>
                                     

                </div>            

                            

                <div class="dr"><span></span></div>           
				<div>
                  <div class="span3"></div>  
                           <div class="span9">
                                <div class="block-fluid ucard">
								 <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation'));
                                          echo form_hidden('user_id',$query['id']); ?>                     
                                        <div class="info">                                                                
                                            <ul class="rows">
                                                <li class="heading">User Privilege</li>
                                                <?php foreach($groups as $group){ 
												$check_views=FALSE;	
														foreach($privileges as $privilege)
														{
															if($privilege->group_id==$group->group_id)
															{
														//		echo "here";
																if($privilege->actions!='')
																{
																$array_p=json_decode($privilege->actions,true);
																
																	}
																$check_views=TRUE;	
																}
														}
												?>
                                                <li>
                                                    <div class="title"><?=$group->label?></div>
                                                    <div class="text">
                                                    	<?php
														if($group->sub_nav!='')
														{
															echo '<ul style="list-style:none; margin-left:20px !important;">';
																$array_nav=json_decode($group->sub_nav,true);

																foreach($array_nav as $value)
																{
														//			echo "<pre>";
														//		var_dump($array_p);
														//		echo "<pre>";
															//	echo '<font color="#FF0000">'.$value['id'].'</font>';
																$check_add=FALSE;
																$check_view=FALSE;
																$check_edit=FALSE;
																$check_delete=FALSE;
																if(array_key_exists($value['id'],$array_p))
																{
																	$key_p=$value['id'];
															//		echo "Mawjoud";
																	if(is_array($array_p[$key_p])){
																	if(is_array($array_p[$key_p]))
																	{
																		if(in_array('add',$array_p[$key_p]))
																		{
																			$check_add=TRUE;
																		}
																	
																		if($array_p[$key_p]=='add')
																		{
																			$check_add=TRUE;
																			}
																		}
																	if(in_array('edit',$array_p[$key_p]))
																	{
																		$check_edit=TRUE;
																		}

																	if(in_array('View',$array_p[$key_p]) or in_array('view',$array_p[$key_p]))
																	{
																		$check_view=TRUE;
																		}

																	if(in_array('delete',$array_p[$key_p]))
																	{
																		$check_delete=TRUE;
																		}
																		
																	
																	}
																else{
																//	echo '<b>'.$array_p[$key_p].'</b>';
																		if($array_p[$key_p]=='add')
																			$check_add=TRUE;
																		elseif($array_p[$key_p]=='edit')
																			$check_edit=TRUE;
																		elseif($array_p[$key_p]=='view')
																		$check_view=TRUE;
																		elseif($array_p[$key_p]=='View')		
																		$check_view=TRUE;
																		elseif($array_p[$key_p]=='delete')
																		$check_delete=TRUE;
																	}																	
																}

																	
																	$name=$value['id'];
																	if (strpos($value['label'],'Add')!== false  or strpos($value['label'],'Submit')!== false  or strpos($value['label'],'New')!== false)
																	{
																		 echo '<li>&nbsp;&nbsp;'.$value['label'].'&nbsp;&nbsp;'.form_checkbox('actions['.$group->group_id.']['.$name.']', 'add',$check_add).'</li>';
																		 
																		 }
																	elseif(strpos($value['label'],'Reports')!== false)
																	{
																	 echo '<li>&nbsp;&nbsp;'.$value['label'].'&nbsp;&nbsp;'.form_checkbox('actions['.$group->group_id.']['.$name.']', 'view',$check_view).'View</li>';	
																		}	 
																	else{	 
																	echo '<li>&nbsp;&nbsp;'.$value['label'].'&nbsp; : &nbsp;'.
																			form_checkbox('actions['.$group->group_id.']['.$name.'][]', 'view',$check_view).'View&nbsp;&nbsp;'.
																			form_checkbox('actions['.$group->group_id.']['.$name.'][]', 'edit',$check_edit).'Edit&nbsp;&nbsp;'.
																			form_checkbox('actions['.$group->group_id.']['.$name.'][]', 'delete',$check_delete).'Delete'.
																	'</li>';
																	}
																	}		
															echo '</ul>';
															}
														else{
															echo form_checkbox('actions['.$group->group_id.']', '',$check_views);
															}	
														 ?>
                                                    </div>
                                                </li>
                                                <?php } ?>
                                                                                     
                                            </ul> 
                                            <div class="footer tar">
                    	<center><input type="submit" name="save" value="Save" class="btn"></center>
                    </div>                                                       
                                        </div>
                                   <?=form_close()?>                             
                                </div>
                                                            
                        </div>

</div>

            </div>

        </div>