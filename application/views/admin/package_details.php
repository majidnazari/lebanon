<?php 
$button = "class='button size-120'";
if($msg!=''){ ?>
<div class="notification note-success">
    <a href="#" class="close" title="Close notification">close</a>
    <p><strong><?php echo $msg;?></strong></p>
</div>
<?php } ?>
<div class="content-box">
    <div class="box-body">
        <div class="box-header clear">
            <h2>Package Detail</h2>
        </div>
				<div class="box-wrap clear">
					<table class="style1">
					<thead>
					<tr>
						<th>Item</th>
						<th width="780" >Value</th>
						<th nowrap="nowrap"><?php	echo _show_edit('admin/packages/edit/id/'.$row['id']);
									echo _show_delete('admin/packages/delete/id/'.$row['id']);?></th>
					</tr>
					</thead>
					<tbody>
					<tr><th>Title</th><td colspan="2"><?=$row['title']?></td></tr>
                    <tr><th>Category</th><td colspan="2"><?=$row['category']?></td></tr>
                    <tr><th>Cost</th><td colspan="2"><?=$row['cost']?>USD</td></tr>
                    <tr><th>Addionnal Cost</th><td colspan="2"><?=$row['addionnal_cost']?>%</td></tr>
                    <tr><th>Min. Premium</th><td colspan="2"><?=$row['min_premium']?>USD</td></tr>					
					<tr>
						<th>Description</th>
						<td colspan="2"><p><?=$row['details']?></p></td>
					</tr>
					<tr>
						<th>Status</th>
						<td colspan="2"><img src="<?=base_url().'themes/'.$row['status']?>.png" class="icon16 fl" title="<?=$row['status']?>" alt="" /></td>
					</tr>
					<tr>
						<th>Create Date</th>
						<td colspan="2"><?=$row['create_time'];?></td>
					</tr>
					<tr>
						<th>Update Date</th>
						<td colspan="2"><?=$row['update_time'];?></td>
					</tr>                    
					</tbody>
					</table>
				</div> <!-- end of box-wrap -->
			</div> <!-- end of box-body -->
			</div>