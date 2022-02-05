<?php if($msg!=''){ ?>
<div class="notification note-success">
    <a href="#" class="close" title="Close notification">close</a>
    <p><strong><?php echo $msg;?></strong></p>
</div>
<?php } ?>
<div class="content-box">
    <div class="box-body">
        <div class="box-header clear"><h2>Agents Users</h2></div>
				
				<div class="box-wrap clear">
					
					<!-- DATA-TABLE JS PLUGIN -->
					<div id="data-table">
						<form method="post" action="" name="formName" id="SearchForm">
						<?php echo form_hidden('table','users');?>
						<table class="style1 datatable">
						<thead>
							<tr>
								<th class="bSortable">Agent Code#</th>
								<th>Agent Name</th>                                
								<th>Username / Email</th>
								<th>Contact Person</th>
								<th>Contact Info</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
                        <?php foreach($query as $row){?>
							<tr>
								<td><?=$row->agent_code?></td>
								<td><?=$row->fullname?></td>
								<td><?=$row->username.' / '.mailto($row->email, $row->email);?></td>
                                <td><?=$row->contact_person?></td>
								<td><?=$row->phone.'<br />'.$row->address?></td>
								<td><?=$row->status?></td>
								<td>
                                	<?php 
									echo _show_edit('admin/customers/edit/id/'.$row->id);
									echo _show_delete('admin/customers/delete/id/'.$row->id.'/group_id/'.$row->id).'<br>';
									echo anchor('admin/customers/password/id/'.$row->id,'Change Password');
									//echo _show_settings('admin/customers/details/id/'.$row->id)
									?>
								</td>
							</tr>
                            <?php } ?>                            
						</tbody>
						</table>
						<div class="tab-footer clear fl">
							<div class="fl">
 							</div>
						</div>
						</form>
        </div><!-- /#table -->
    </div><!-- end of box-wrap -->
</div> <!-- end of box-body -->
</div>