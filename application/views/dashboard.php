
<div class="wrapper">
    <div class="content">
        <?=$this->load->view("includes/_bread")?>
        <div class="workplace">
            <div class="row-fluid">
                <div class="span4">
                    <div class="wBlock red clearfix">
                        <div class="dSpace">
                            <h3>Visitors</h3>
                            <span class="mChartBar" sparkType="bar" sparkBarColor="white"><!--130,190,260,230,290,400,340,360,390--></span>
                            <span class="number"><?=$total_visitors?></span>
                        </div>
                        <div class="rSpace">
                            <span>Total Visitors : <?=$total_visitors?></span>
                            <?php
                            foreach($states_users as $states_user) {

                                if($states_user->Month == date('F')) {
                                    echo '<span>'.$states_user->Month.' Visitors : '.$states_user->Views.'</span>';
                                }
                            }
                            ?>
                            <span>Today Visitors : <?=@$today_visitors['Views']?></span>
                        </div>
                    </div>
                </div>
                <div class="span4">
                    <div class="wBlock red clearfix">
                        <div class="dSpace">
                            <h3>Industrial Companies</h3>
                            <span class="mChartBar" sparkType="bar" sparkBarColor="white"><!--130,190,260,230,290,400,340,360,390--></span>
                            <span class="number"><?=$companies_nbr?></span>
                        </div>
                        <div class="rSpace">
                            <span><?=anchor('tasks?list=&company_id=&sales_man=&from_start=&to_start=&from_due=&to_due=&gov=0&district_id=0&area_id=0&status=done&category=&search=Search', '<b>'.$tasks.' Reviewed '.date('Y').'</b>')?></span>
                            <span><?=anchor('companies/reservations', '<b>'.$copy_res.' Reservations Copies</b>')?></span>
                            <span><?=anchor('companies/advertising', '<b>'.$is_adv.' Advertising</b>')?></span>
                        </div>
                    </div>
                </div>

                <div class="span4">

                    <div class="wBlock green clearfix">
                        <div class="dSpace">
                            <h3>Banks</h3>
                            <span class="mChartBar" sparkType="bar" sparkBarColor="white"><!--5,10,15,20,23,21,25,20,15,10,25,20,10--></span>
                            <span class="number"><?=$banks_nbr?></span>
                        </div>
                        <div class="rSpace">
                            <span><?=anchor('banks/reservations', '<b>'.$banks_copy_res.' Reservations Copies</b>')?></span>
                            <span><?=anchor('banks/advertising', '<b>'.$banks_is_adv.' Advertising</b>')?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dr"><span></span></div>
            <div class="row-fluid">
                <div class="span4">
                    <div class="wBlock blue clearfix">
                        <div class="dSpace">
                            <h3>Importers Companies</h3>
                            <span class="mChartBar" sparkType="bar" sparkBarColor="white"><!--130,190,260,230,290,400,340,360,390--></span>
                            <span class="number"><?=$importers_nbr?></span>
                        </div>
                        <div class="rSpace">
                            <span><?=anchor('importers/reservations', '<b>'.$importers_copy_res.' Reservations Copies</b>')?></span>
                            <span><?=anchor('importers/advertising', '<b>'.$importers_is_adv.' Advertising</b>')?></span>
                        </div>
                    </div>
                </div>

                <div class="span4">

                    <div class="wBlock clearfix">
                        <div class="dSpace">
                            <h3>Transports Companies</h3>
                            <span class="mChartBar" sparkType="bar" sparkBarColor="white"><!--5,10,15,20,23,21,25,20,15,10,25,20,10--></span>
                            <span class="number"><?=$transports_nbr?></span>
                        </div>
                        <div class="rSpace">
                            <span><?=anchor('transportations/reservations', '<b>'.$transports_copy_res.' Reservations Copies</b>')?></span>
                            <span><?=anchor('transportations/advertising', '<b>'.$transports_is_adv.' Advertising</b>')?></span>
                        </div>
                    </div>
                </div>
                <div class="span4">

                    <div class="wBlock blue clearfix">
                        <div class="dSpace">
                            <h3>Insurance Companies</h3>
                            <span class="mChartBar" sparkType="bar" sparkBarColor="white"><!--240,234,150,290,310,240,210,400,320,198,250,222,111,240,221,340,250,190--></span>
                            <span class="number"><?=$insurances_nbr?></span>
                        </div>
                        <div class="rSpace">
                            <span><?=anchor('insurances/reservations', '<b>'.$insurances_copy_res.' Reservations Copies</b>')?></span>
                            <span><?=anchor('insurances/advertising', '<b>'.$insurances_is_adv.' Advertising</b>')?></span>
                        </div>
                    </div>

                </div>
            </div>
            <div class = "dr"><span></span></div>


            <div class = "row-fluid">
                <div class = "span12">
                    <?php if($company_statement_msg != '') {
                        ?>
                        <div class="row-fluid">
                            <div class="alert alert-success">
                                <?php echo $company_statement_msg;?>
                            </div>
                        </div>
                    <?php }?>
                    <div class="head clearfix">
                        <div class="isw-grid"></div>
                        <h1 style="font-size:22px !important">المسح الصناعي</h1>
                        <!--
                        <ul class="buttons">
                            <li><a href="#" class="isw-download"></a></li>
                            <li><a href="#" class="isw-attachment"></a></li>
                            <li>
                                <a href="#" class="isw-settings"></a>
                                <ul class="dd-list">
                                    <li><a href="#"><span class="isw-plus"></span> New document</a></li>
                                    <li><a href="#"><span class="isw-edit"></span> Edit</a></li>
                                    <li><a href="#"><span class="isw-delete"></span> Delete</a></li>
                                </ul>
                            </li>
                        </ul>    -->
                    </div>

                    <div class="block-fluid">
                        <table cellpadding="0" cellspacing="0" width="100%" class="table">
                            <thead>
                                <tr>
                                    <!--<th><input type="checkbox" name="checkall"/></th>-->
                                    <th width="10%">Year</th>
                                    <th width="25%">Company Name</th>
                                    <th width="55%">Notes</th>
                                    <th width="10%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach($statements as $statement) {
                                    if($statement->notes != '') {
                                        ?>
                                        <tr>
                                            <!--<td><input type="checkbox" name="checkbox"/></td>  -->
                                            <td><?=$statement->year?></td>
                                            <td><?=anchor('companies/details/'.$statement->company_id, $statement->name_ar)?></td>
                                            <td><?=$statement->notes?></td>
                                            <td><?=anchor('dashboard/companystatement/'.$statement->id, '<span class="label label-success">Close</span>')?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="dr"><span></span></div>

            <div class="row-fluid">

                <div class="span12">
                    <div class="head clearfix">
                        <div class="isw-graph"></div>
                        <h1>Monthly Visitors</h1>
                        <div style="float:right !important"><div class="isw-print"></div><h2 style="float:right; color:#000 !important"><?=anchor('dashboard/visitors_monthly','Print',array('target'=>'_blank','style'=>'color:#FFF; margin-right:10px;'))?></h2></div>
                    </div>
                    <div class="block">
                        <?=$this->load->view('_statistics');?>
                    </div>
                </div>

            </div>
            <div class="dr"><span></span></div>
            <div class="row-fluid">
				<script language="javascript">
                $(function() {
					  $( ".datepic" ).datepicker({
						  dateFormat: "yy-mm-dd"
						});
					
				  });
				</script>
                    <div class="head clearfix">
                        <div class="isw-graph"></div>
                        <h1>Search</h1>
                        <div style="float:right !important"><div class="isw-print"></div><h2 style="float:right; color:#000 !important"><?=anchor('dashboard/visitors_search?from='.@$from.'&to='.@$to,'Print',array('target'=>'_blank','style'=>'color:#FFF; margin-right:10px;'))?></h2></div>
                    </div>
                    <?php echo form_open_multipart($this->uri->uri_string(),array('method'=>'get'));?>
                    <div class="block">
                    <div class="row-form clearfix">
                        <div class="span1">From</div>
                        <div class="span2"><?php echo form_input(array('name'=>'from','value'=>@$from,'class'=>'datepic')); ?></div>
                        <div class="span1">To</div>
                        <div class="span2"><?php echo form_input(array('name'=>'to','value'=>@$to,'class'=>'datepic')); ?></div>
                        <div class="span2"><input type="submit" name="search" value="Search" class="btn" /></div>
                     </div>
                       <div class="row-form clearfix"><div class="span12"> <?=$this->load->view('_statistics_search');?></div></div>
                    </div>
                    <?php echo form_close()?>

            </div>
            <div class="dr"><span></span></div>
            <div class="row-fluid">

                <div class="span6">
                    <div class="head clearfix">
                        <div class="isw-graph"></div>
                        <h1>Total Visitors By Countries</h1>
                    </div>
                    <div class="block">
                        <?=$this->load->view('_statistics_country');?>
                    </div>
                </div>
                <div class="span6">
                    <div class="head clearfix">
                        <div class="isw-graph"></div>
                        <h1>Total Visitors By Countries in <?=date('F')?></h1>
                    </div>
                    <div class="block">
                        <?=$this->load->view('_statistics_country_pie');?>
                    </div>
                </div>

            </div>




            <div class="dr"><span></span></div>

        </div>

    </div>
</div>

