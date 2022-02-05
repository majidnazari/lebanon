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
							<h2>All Colors</h2>
							
							<table class="basic" cellspacing="0">
							<caption>Vehicles Colors</caption>
							<thead>
							<tr>
								<th>ID#</th>
								<th>Title</th>
								<th>Edit</th>
                                <th>Delete</th>
							</tr>
							</thead>
							<tbody>
                            <?php foreach($query as $row){ ?>
							<tr>
								<td class="vcenter title"><?=$row->id?></td>
                                <td class="vcenter title"><?=$row->name?></td>
								<td class="vcenter nowrap"><?=_show_edit('admin/settings/colors/id/'.$row->id);?></td>
								<td class="vcenter nowrap"><?=_show_delete('admin/settings/delete_colors/id/'.$row->id);?></td>
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
							<h2><?=$action_title?></h2>
							<?php echo form_open();
								$color_name = array(
										'name'	 => 'name',
										'id'	   => 'name',
										'class'	=> 'text fl',
										'style'	=> 'width:200px',
										'required' =>'required',
										'value' =>$color_title,
									); 
							?>
							<table class="style1">
								<caption><?=$action_title?></caption>
                                <tbody>
                                    <tr class="box-slide-head">
                                        <td class="vcenter title">Color Title</td>
                                        <td class="vcenter nowrap"><?=form_input($color_name);?></td>
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