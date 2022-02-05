<?php if($msg!=''){ ?>
<div class="notification note-success">
    <a href="#" class="close" title="Close notification">close</a>
    <p><strong><?php echo $msg;?></strong></p>
</div>
<?php } ?>
<div class="content-box">
    <div class="box-body">
        <div class="box-header clear"><h2>All Vehicles</h2></div>
				
				<div class="box-wrap clear">
					
					<!-- DATA-TABLE JS PLUGIN -->
					<div id="data-table">
						<form method="post" action="" name="formName" id="SearchForm">
						<?php echo form_hidden('table','vehicles');?>
						<table class="style1 datatable">
						<thead>
							<tr>
								<th class="bSortable">Chassis No</th>
                                <th>Make</th>
								<th>Model</th>
                                <th>Color</th>
								<th>Agent Code</th>
								<th>Create Date</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
                        <?php foreach($query as $row){?>
							<tr>
								<td><?=$row->chassis_no?></td>
								<td><?=$row->make?></td>
								<td><?=$row->model?></td>
                                <td><?=$row->color?></td>
                                <td><?=$row->agent_code?></td>
								<td><?=$row->create_time?></td>
								<td>
                                	<?php 
									echo _show_edit('admin/vehicle/edit/id/'.$row->id);
									echo _show_delete('admin/vehicle/delete/id/'.$row->id);
									echo _show_settings('admin/vehicle/details/id/'.$row->id)
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