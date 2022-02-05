<div class="main pagesize"> <!-- *** mainpage layout *** -->
	<div class="main-wrap">
		<div class="page clear">
			
			<!-- ICONBAR -->
			<div class="content-box clear">
			<div class="box-body iconbar">
				<div class="box-wrap">
				<div class="main-icons" id="iconbar">
					<ul class="clear">
		                        <li><?=anchor('admin/ideas', '<img src="'.base_url().'themes/ideas.png" class="icon" border="0"><span class="text">Creative Ideas</span>');?></li>
		                        <li><?=anchor('admin/news', '<img src="'.base_url().'themes/news.png" class="icon" border="0"><span class="text">News</span>');?></li>
                                 <li><?=anchor('admin/vacancies', '<img src="'.base_url().'themes/vacancies.png" class="icon" border="0"><span class="text">News</span>');?></li>
              		</ul>
				</div>
				</div>
			</div>
			</div>
           <div class="columns clear bt-space15">
						<div class="col1-2 online-user">
						
							<!-- ONLINE USERS BOXES -->
							<h2>Latest Agent Registered</h2>
                            <?php 
							$i=0;
							foreach($users_agent as $agent_item){ 
							if($i<5){
							?>
							<div class="mark clear">
								<div class="avatar">
									<img src="<?=base_url()?>images/avatar.jpg" alt="" />
									<p class="status admin"><?=$agent_item->username?></p>
								</div>
								<div class="desc">
									<ul class="links">
										<li><?=mailto($agent_item->email, 'send email',array('class'=>'mesg'));?></li>
                                        <li><?=anchor('admin/users/details/id/'.$agent_item->id, 'View Users details',array('class'=>'hist', 'title'=>'view user history'));?></li>
									</ul>
									<h4><strong><?=$agent_item->agent_code.' - '.$agent_item->fullname?></strong></h4>
									<p><small>Phone : <?=$agent_item->phone?></small></p>
                                    <p><small>Address : <?=$agent_item->address?></small></p>
									<p class="info"><small>registered: <?=$agent_item->create_time?></small></p>
								</div>
							</div>
                            <?php }
							else{
								break;
							}
							$i++;
							} ?>
						</div>
						
						<div class="col1-2 lastcol">
						
							<!-- USEFUL LINKS WITH ICONS -->
							<h2>Latest Private Users Registered</h2>
							<div class="mark icon-links">
								<ul>
                                <?php 
								$j=0;
								foreach($users_private as $private_item){
									if($j<5){
									 ?>
								<li class="clear">
                                	
									<?=anchor('admin/users/details/id/'.$private_item->id,'<img src="'.base_url().'images/avatar.jpg" class="icon" alt="" /><span>'.$private_item->agent_code.' - '.$private_item->fullname.'</span>');?>
									<p><small>Phone : <?=$private_item->phone?></small></p>
                                    <p><small>Address : <?=$private_item->address?></small></p>
									<p class="info"><small>registered: <?=$private_item->create_time?></small></p>
								</li>
                                <?php  }
							else{
								break;
							}
							$j++;
							} ?>
								</ul>
							</div>
						</div>
					</div> 
                    <div class="rule2"></div>
		</div><!-- end of page -->
 <?php /*<div class="content-box">
			<div class="box-body">
				<div class="box-header clear">
					<ul class="tabs clear">
						<li><a href="#data-table">JS plugin</a></li>
						<li><a href="#table">Table only</a></li>
					</ul>
					
					<h2>Content Box</h2>
				</div>
				
				<div class="box-wrap clear">
					
					<!-- TABLE -->
					<div id="data-table">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in porta lectus. Maecenas dignissim enim quis ipsum mattis aliquet. Maecenas id velit et elit gravida bibendum. Duis nec rutrum lorem.</p> 
					
						<form method="post" action="">
						
						<table class="style1 datatable">
						<thead>
							<tr>
								<th class="bSortable"><input type="checkbox" class="checkbox select-all" /></th>
								<th>Column 1</th>
								<th>Column 2</th>
								<th>Column 3</th>
								<th>Column 4</th>
								<th>Column 5</th>
								<th>Column 6</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><input type="checkbox" class="checkbox" /></td>
								<td>Lorem ipsum dolor</td>
								<td><a href="#">John</a></td>
								<td>5/6/2010</td>
								<td><input type="text" name="input1" id="input1" value="235" class="text" size="10" /></td>
								<td>sed in porta lectus</td>
								<td>
									<a href="#"><img src="images/ico_edit_16.png" class="icon16 fl-space2" alt="" title="edit" /></a>
									<a href="#"><img src="images/ico_delete_16.png" class="icon16 fl-space2" alt="" title="delete" /></a>
									<a href="#"><img src="images/ico_settings_16.png" class="icon16 fl-space2" alt="" title="settings" /></a>
								</td>
							</tr>
                                                        
							<tr>
								<td><input type="checkbox" class="checkbox" /></td>
								<td>Dignissim enim</td>
								<td><a href="#">Admin</a></td>
								<td>5/6/2010</td>
								<td><input type="text" name="input2" id="input2" value="124" class="text" size="10" /></td>
								<td>duis nec rutrum</td>
								<td>
									<a href="#"><img src="images/ico_edit_16.png" class="icon16 fl-space2" alt="" title="edit" /></a>
									<a href="#"><img src="images/ico_delete_16.png" class="icon16 fl-space2" alt="" title="delete" /></a>
									<a href="#"><img src="images/ico_settings_16.png" class="icon16 fl-space2" alt="" title="settings" /></a>
								</td>
							</tr>
							<tr>
								<td><input type="checkbox" class="checkbox" /></td>
								<td>Maecenas velit</td>
								<td><a href="#">Admin</a></td>
								<td>5/6/2010</td>
								<td><input type="text" name="input3" id="input3" value="58" class="text" size="10" /></td>
								<td>porta lectus</td>
								<td>
									<a href="#"><img src="images/ico_edit_16.png" class="icon16 fl-space2" alt="" title="edit" /></a>
									<a href="#"><img src="images/ico_delete_16.png" class="icon16 fl-space2" alt="" title="delete" /></a>
									<a href="#"><img src="images/ico_settings_16.png" class="icon16 fl-space2" alt="" title="settings" /></a>
								</td>
							</tr>
							<tr>
								<td><input type="checkbox" class="checkbox" /></td>
								<td>Maecenas velit</td>
								<td><a href="#">Admin</a></td>
								<td>5/6/2010</td>
								<td><input type="text" name="input4" id="input4" value="58" class="text" size="10" /></td>
								<td>porta lectus</td>
								<td>
									<a href="#"><img src="images/ico_edit_16.png" class="icon16 fl-space2" alt="" title="edit" /></a>
									<a href="#"><img src="images/ico_delete_16.png" class="icon16 fl-space2" alt="" title="delete" /></a>
									<a href="#"><img src="images/ico_settings_16.png" class="icon16 fl-space2" alt="" title="settings" /></a>
								</td>
							</tr>
							<tr>
								<td><input type="checkbox" class="checkbox" /></td>
								<td>Maecenas velit</td>
								<td><a href="#">Admin</a></td>
								<td>5/6/2010</td>
								<td><input type="text" name="input5" id="input5" value="58" class="text" size="10" /></td>
								<td>porta lectus</td>
								<td>
									<a href="#"><img src="images/ico_edit_16.png" class="icon16 fl-space2" alt="" title="edit" /></a>
									<a href="#"><img src="images/ico_delete_16.png" class="icon16 fl-space2" alt="" title="delete" /></a>
									<a href="#"><img src="images/ico_settings_16.png" class="icon16 fl-space2" alt="" title="settings" /></a>
								</td>
							</tr>
							<tr>
								<td><input type="checkbox" class="checkbox" /></td>
								<td>Maecenas velit</td>
								<td><a href="#">Admin</a></td>
								<td>5/6/2010</td>
								<td><input type="text" name="input6" id="input6" value="58" class="text" size="10" /></td>
								<td>porta lectus</td>
								<td>
									<a href="#"><img src="images/ico_edit_16.png" class="icon16 fl-space2" alt="" title="edit" /></a>
									<a href="#"><img src="images/ico_delete_16.png" class="icon16 fl-space2" alt="" title="delete" /></a>
									<a href="#"><img src="images/ico_settings_16.png" class="icon16 fl-space2" alt="" title="settings" /></a>
								</td>
							</tr>
							<tr>
								<td><input type="checkbox" class="checkbox" /></td>
								<td>Maecenas velit</td>
								<td><a href="#">Admin</a></td>
								<td>5/6/2010</td>
								<td><input type="text" name="input7" id="input7" value="58" class="text" size="10" /></td>
								<td>porta lectus</td>
								<td>
									<a href="#"><img src="images/ico_edit_16.png" class="icon16 fl-space2" alt="" title="edit" /></a>
									<a href="#"><img src="images/ico_delete_16.png" class="icon16 fl-space2" alt="" title="delete" /></a>
									<a href="#"><img src="images/ico_settings_16.png" class="icon16 fl-space2" alt="" title="settings" /></a>
								</td>
							</tr>
							<tr>
								<td><input type="checkbox" class="checkbox" /></td>
								<td>Maecenas velit</td>
								<td><a href="#">Admin</a></td>
								<td>5/6/2010</td>
								<td><input type="text" name="input8" id="input8" value="58" class="text" size="10" /></td>
								<td>porta lectus</td>
								<td>
									<a href="#"><img src="images/ico_edit_16.png" class="icon16 fl-space2" alt="" title="edit" /></a>
									<a href="#"><img src="images/ico_delete_16.png" class="icon16 fl-space2" alt="" title="delete" /></a>
									<a href="#"><img src="images/ico_settings_16.png" class="icon16 fl-space2" alt="" title="settings" /></a>
								</td>
							</tr>
							<tr>
								<td><input type="checkbox" class="checkbox" /></td>
								<td>Maecenas velit</td>
								<td><a href="#">Admin</a></td>
								<td>5/6/2010</td>
								<td><input type="text" name="input9" id="input9" value="58" class="text" size="10" /></td>
								<td>porta lectus</td>
								<td>
									<a href="#"><img src="images/ico_edit_16.png" class="icon16 fl-space2" alt="" title="edit" /></a>
									<a href="#"><img src="images/ico_delete_16.png" class="icon16 fl-space2" alt="" title="delete" /></a>
									<a href="#"><img src="images/ico_settings_16.png" class="icon16 fl-space2" alt="" title="settings" /></a>
								</td>
							</tr>
							<tr>
								<td><input type="checkbox" class="checkbox" /></td>
								<td>Maecenas velit</td>
								<td><a href="#">Admin</a></td>
								<td>5/6/2010</td>
								<td><input type="text" name="input10" id="input10" value="58" class="text" size="10" /></td>
								<td>porta lectus</td>
								<td>
									<a href="#"><img src="images/ico_edit_16.png" class="icon16 fl-space2" alt="" title="edit" /></a>
									<a href="#"><img src="images/ico_delete_16.png" class="icon16 fl-space2" alt="" title="delete" /></a>
									<a href="#"><img src="images/ico_settings_16.png" class="icon16 fl-space2" alt="" title="settings" /></a>
								</td>
							</tr>
							<tr>
								<td><input type="checkbox" class="checkbox" /></td>
								<td>Duis nec rutrum</td>
								<td><a href="#">John</a></td>
								<td>5/6/2010</td>
								<td><input type="text" name="input11" id="input11" value="10" class="text" size="10" /></td>

								<td>enim quis ipsum</td>
								<td>
									<a href="#"><img src="images/ico_edit_16.png" class="icon16 fl-space2" alt="" title="edit" /></a>
									<a href="#"><img src="images/ico_delete_16.png" class="icon16 fl-space2" alt="" title="delete" /></a>
									<a href="#"><img src="images/ico_settings_16.png" class="icon16 fl-space2" alt="" title="settings" /></a>
								</td>
							</tr>
							<tr>
								<td><input type="checkbox" class="checkbox" /></td>
								<td>Elit gravida</td>
								<td><a href="#">Admin</a></td>
								<td>5/6/2010</td>
								<td><input type="text" name="input12" id="input12" value="356" class="text" size="10" /></td>
								<td>dolor sit amet</td>
								<td>
									<a href="#"><img src="images/ico_edit_16.png" class="icon16 fl-space2" alt="" title="edit" /></a>
									<a href="#"><img src="images/ico_delete_16.png" class="icon16 fl-space2" alt="" title="delete" /></a>
									<a href="#"><img src="images/ico_settings_16.png" class="icon16 fl-space2" alt="" title="settings" /></a>
								</td>
							</tr>
						</tbody>
						</table>
						
						<div class="tab-footer clear fl">
							<div class="fl">
								<select name="dropdown" class="fl-space">
									<option value="option1">choose action...</option>
									<option value="option2">Edit</option>
									<option value="option3">Delete</option>
								</select>
								<input type="submit" value="Apply" id="submit1" class="button fl-space" />
							</div>
						</div>
						</form>
					</div><!-- /#table -->
					
					<!-- TABLE -->
					<div id="table">
						<form method="post" action="">
						<table class="style1">
							<thead>
								<tr>
									<th><input type="checkbox" class="checkbox select-all" /></th>
									<th>Column 1</th>
									<th>Column 2</th>
									<th>Column 3</th>
									<th>Column 4</th>
									<th>Column 5</th>
									<th>Column 6</th>
								</tr>
							</thead>
							
							<tbody>
								<tr>
									<td><input type="checkbox" class="checkbox" /></td>
									<td>Lorem ipsum dolor</td>
									<td><a href="#">John</a></td>
									<td>5/6/2010</td>
									<td><input type="text" name="input21" id="input21" value="235" class="text" size="10" /></td>
									<td>sed in porta lectus</td>
									<td>
										<a href="#"><img src="images/ico_edit_16.png" class="icon16 fl-space2" alt="" title="edit" /></a>
										<a href="#"><img src="images/ico_delete_16.png" class="icon16 fl-space2" alt="" title="delete" /></a>
										<a href="#"><img src="images/ico_settings_16.png" class="icon16 fl-space2" alt="" title="settings" /></a>
									</td>
								</tr>
								<tr>
									<td><input type="checkbox" class="checkbox" /></td>
									<td>Dignissim enim</td>
									<td><a href="#">Admin</a></td>
									<td>5/6/2010</td>
									<td><input type="text" name="input22" id="input22" value="124" class="text" size="10" /></td>
									<td>duis nec rutrum</td>
									<td>
										<a href="#"><img src="images/ico_edit_16.png" class="icon16 fl-space2" alt="" title="edit" /></a>
										<a href="#"><img src="images/ico_delete_16.png" class="icon16 fl-space2" alt="" title="delete" /></a>
										<a href="#"><img src="images/ico_settings_16.png" class="icon16 fl-space2" alt="" title="settings" /></a>
									</td>
								</tr>
								<tr>
									<td><input type="checkbox" class="checkbox" /></td>
									<td>Maecenas velit</td>
									<td><a href="#">Admin</a></td>
									<td>5/6/2010</td>
									<td><input type="text" name="input23" id="input23" value="58" class="text" size="10" /></td>
									<td>porta lectus</td>
									<td>
										<a href="#"><img src="images/ico_edit_16.png" class="icon16 fl-space2" alt="" title="edit" /></a>
										<a href="#"><img src="images/ico_delete_16.png" class="icon16 fl-space2" alt="" title="delete" /></a>
										<a href="#"><img src="images/ico_settings_16.png" class="icon16 fl-space2" alt="" title="settings" /></a>
									</td>
								</tr>
								<tr>
									<td><input type="checkbox" class="checkbox" /></td>
									<td>Duis nec rutrum</td>
									<td><a href="#">John</a></td>
									<td>5/6/2010</td>
									<td><input type="text" name="input24" id="input24" value="10" class="text" size="10" /></td>
									<td>enim quis ipsum</td>
									<td>
										<a href="#"><img src="images/ico_edit_16.png" class="icon16 fl-space2" alt="" title="edit" /></a>
										<a href="#"><img src="images/ico_delete_16.png" class="icon16 fl-space2" alt="" title="delete" /></a>
										<a href="#"><img src="images/ico_settings_16.png" class="icon16 fl-space2" alt="" title="settings" /></a>
									</td>
								</tr>
								<tr>
									<td><input type="checkbox" class="checkbox" /></td>
									<td>Elit gravida</td>
									<td><a href="#">Admin</a></td>
									<td>5/6/2010</td>
									<td><input type="text" name="input25" id="input25" value="356" class="text" size="10" /></td>
									<td>dolor sit amet</td>
									<td>
										<a href="#"><img src="images/ico_edit_16.png" class="icon16 fl-space2" alt="" title="edit" /></a>
										<a href="#"><img src="images/ico_delete_16.png" class="icon16 fl-space2" alt="" title="delete" /></a>
										<a href="#"><img src="images/ico_settings_16.png" class="icon16 fl-space2" alt="" title="settings" /></a>
									</td>
								</tr>
							</tbody>
						</table>
						
						<div class="tab-footer clear">
							<div class="fl">
								<select name="dropdown" class="fl-space">
									<option value="option1">choose action...</option>
									<option value="option2">Edit</option>
									<option value="option3">Delete</option>
								</select>
								<input type="submit" value="Apply" id="submit2" class="button fl-space" />
							</div>
							<div class="pager fr">
								<span class="nav">
									<a href="#" class="first" title="first page"><span>First</span></a>
									<a href="#" class="previous" title="previous page"><span>Previous</span></a>
								</span>
								<span class="pages">
									<a href="#" title="page 1"><span>1</span></a>
									<a href="#" title="page 2" class="active"><span>2</span></a>
									<a href="#" title="page 3"><span>3</span></a>
									<a href="#" title="page 4"><span>4</span></a>
								</span>
								<span class="nav">
									<a href="#" class="next" title="next page"><span>Next</span></a>
									<a href="#" class="last" title="last page"><span>Last</span></a>
								</span>
							</div>
						</div>
						</form>
					</div><!-- /#table -->
					
				</div><!-- end of box-wrap -->
			</div> <!-- end of box-body -->
			</div>*/ ?>       
	</div>
</div>