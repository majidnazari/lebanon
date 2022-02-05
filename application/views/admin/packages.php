<?php if($msg!=''){ ?>
<div class="notification note-success">
    <a href="#" class="close" title="Close notification">close</a>
    <p><strong><?php echo $msg;?></strong></p>
</div>
<?php } ?>
<div class="content-box">
    <div class="box-body">
        <div class="box-header clear"><h2>All Packages</h2></div>
				
				<div class="box-wrap clear">
					
					<!-- DATA-TABLE JS PLUGIN -->
					<div id="data-table">
						<form method="post" action="" name="formName" id="SearchForm">
						<?php echo form_hidden('table','packages');?>
						<table class="style1 datatable">
						<thead>
							<tr>
								<th class="bSortable">ID#</th>
								<th>Category</th>
								<th>Title</th>
								<th>Min. Premium</th>
								<th>Date</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
                        <?php foreach($query as $row){?>
							<tr>
								<td><?=$row->id?></td>
								<td><?=$row->category?></td>
								<td><?=$row->title?></td>
                                <td><?=$row->min_premium?> USD</td>
								<td><?=$row->create_time?></td>
								<td><?=$row->status?></td>
								<td>
                                	<?php 
									echo _show_edit('admin/packages/edit/id/'.$row->id);
									echo _show_delete('admin/packages/delete/id/'.$row->id);
									echo _show_settings('admin/packages/details/id/'.$row->id)
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