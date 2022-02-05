<?php if($msg!=''){ ?>
<div class="notification note-success">
    <a href="#" class="close" title="Close notification">close</a>
    <p><strong><?php echo $msg;?></strong></p>
</div>
<?php } ?>
<div class="content-box">
    <div class="box-body">
        <div class="box-header clear"><h2><?=$subtitle?></h2></div>
				
				<div class="box-wrap clear">
					
					<!-- DATA-TABLE JS PLUGIN -->
					<div id="data-table">
						<form method="post" action="" name="formName" id="SearchForm">
						<?php echo form_hidden('table','certificate_warranty');?>
						<table class="style1 datatable">
						<thead>
							<tr>
								<th class="bSortable">Certificate ID#</th>
								<th>Product Name</th>
								<th>Agent Code</th>
								<th>Certificate Holder</th>
								<th>Date</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
                        <?php foreach($query as $row){?>
							<tr>
								<td><?=$row->certificate_number?></td>
								<td><?=$row->product_name?></td>
								<td><?=$row->agent_code?></td>
                                <td><?=$row->certificate_holder?></td>
								<td><?=$row->create_time?></td>
								<td nowrap="nowrap"><?=form_open('admin/certificates/edit_status/');
						echo form_hidden('id',$row->id);
						?>
						<?php $array_status=array('canceled'=>'Canceled','done'=>'Completed','pending'=>'Pending');
						echo form_dropdown('status', $array_status,$row->status);?><input type="submit" name="submit1" value="OK" class="button clickable" />
                        <?=form_close()?>
						
					
                                </td>
								<td>
                                	<?php 
									echo _show_delete('admin/certificates/delete/id/'.$row->id);
									echo _show_settings('admin/certificates/details/id/'.$row->id)
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