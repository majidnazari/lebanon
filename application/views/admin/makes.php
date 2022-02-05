<?php if($msg!=''){ ?>
<div class="notification note-success">
    <a href="#" class="close" title="Close notification">close</a>
    <p><strong><?php echo $msg;?></strong></p>
</div>
<?php } ?>
<?php $button = "class='button'";?>
<div class="columns clear">
				<div class="col1-2">
					<div class="content-box">
					<div class="box-body">
						<div class="box-wrap clear">
						
							<!-- BASIC STYLE TABLE OPENABLE -->
							<h2>All Makes</h2>
							
							<table class="basic" cellspacing="0">
							<caption>Vehicles Makes</caption>
							<thead>
							<tr>
								<th>ID#</th>
								<th>Title</th>
								<th>Edit</th>
                                <th>Delete</th>
                                <th>Models</th>
							</tr>
							</thead>
							<tbody>
                            <?php foreach($query as $row){ ?>
							<tr>
								<td class="vcenter title"><?=$row->id?></td>
                                <td class="vcenter title"><?=$row->name?></td>
								<td class="vcenter nowrap"><?=_show_edit('admin/settings/makes/id/'.$row->id);?></td>
								<td class="vcenter nowrap"><?=_show_delete('admin/settings/delete_makes/id/'.$row->id);?></td>
                                <td class="vcenter nowrap"><?=anchor('admin/settings/models/makeid/'.$row->id,'View Models');?></td>
							</tr>                           
                            <?php } ?>
							</tbody>
							</table>
							
						</div> <!-- end of box-wrap -->
					</div> <!-- end of box-body -->
					</div> <!-- end of content-box -->
				</div>
				<div class="col1-2 lastcol">
					<div class="content-box">
					<div class="box-body">
						<div class="box-wrap clear">
						
							<!-- STYLE1 TABLE OPENABLE -->
							<h2>Add New Make</h2>
							<?php echo form_open();
								$make_name = array(
										'name'	 => 'name',
										'id'	   => 'name',
										'class'	=> 'text fl',
										'style'	=> 'width:200px',
										'required' =>'required',
										'value' =>$make_title,
									); 
							?>
							<table class="style1">
								<caption>Add New Make</caption>
                                <tbody>
                                    <tr class="box-slide-head">
                                        <td class="vcenter title">Make Title</td>
                                        <td class="vcenter nowrap"><?=form_input($make_name);?></td>
                                        <td class="vcenter"></td>
                                    </tr>
                                </tbody>
							</table>
                            <?=form_submit($btn_name, 'Save',$button);?>
							<?=form_close()?>
						</div> <!-- end of box-wrap -->
					</div> <!-- end of box-body -->
					</div> <!-- end of content-box -->
				</div>
			</div>