<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link media="all" href="<?=base_url()?>css/company-print.css" rel="stylesheet" />
        <title><?=$title?> </title>
        <style type="text/css">
            .span57{
                float:left;
                width:100px;
                margin-top:18px;
            }
            .span5{
                float:left;
                width:100px;
                margin-top:10px;
            }
            .span6{
                float:right;
                width:100px;
                margin-top:10px;
            }
            .span67{
                float:right;
                width:80px;
                margin-top:18px;
            }
            .span58{
                float:left;
                width:170px;
                margin-top:18px;
            }
            .span68{
                float:right;
                width:120px;
                margin-top:18px;
            }

        </style>
    </head>

    <body>
        <div class="container">
            <div class="header"><img src="<?=base_url()?>img/header-transportation.jpg" width="100%" style="margin-top:0px !important" /></div>
            <div class="clear"></div><br>
            <h3 class="d-num">رقم الاستمارة : <?=$query['id']?></h3>
            <table class="table-view" style="width:920px !important; margin-top:10px !important">
                <tr>
                    <td colspan="5">
                        <div class="label english">Company Name :</div>
                        <div class="data-box english"><?=$query['name_en'];?>&nbsp;</div>
                        <div class="label arabic"> اسم الشركة:</div>
                        <div class="data-box arabic"><?=$query['name_ar'];?>&nbsp;</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <div class="label english">Owner / Owners of The Co. :</div>
                        <div class="data-box english"><?=$query['owner_en'];?>&nbsp;</div>
                        <div class="label arabic"> صاحب / اصحاب الشركة: </div>
                        <div class="data-box arabic"><?=$query['owner_ar'];?>&nbsp;</div>
                    </td>
                </tr>

                <tr>
                    <td colspan="5">
                        <div class="label english">C.R :</div>
                        <div class="data-box english"> <?=$query['trade_license'].' - '.@$license['label_en'];?>&nbsp;</div>
                        <div class="label arabic">س.ت. / رقم الترخيص :</div>
                        <div class="data-box arabic"> <?=$query['trade_license'];?> - <?=@$license['label_ar']?>&nbsp;</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <div class="label english">Date Founded :</div>
                        <div class="data-box english"><?=$query['est_date'];?>&nbsp;</div>
                        <div class="label arabic"> تاريخ التأسيس: </div>
                        <div class="data-box arabic"><?=$query['est_date'];?>&nbsp;</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" valign="top" style="border-right:none !important">
                        <h2 class="english" style="margin-right:15px !important;">Membership in Organization : </h2>

                        <?php
                        if($query['maritime'] == 1) {
                            $checkedMaritime_en = '<img src="'.base_url().'img/checked.png" class="icon english" />';
                            $checkedMaritime_ar = '<img src="'.base_url().'img/checked.png" class="icon arabic" />';
                        }
                        else {
                            $checkedMaritime_en = '<img src="'.base_url().'img/unchecked.png" class="icon english" />';
                            $checkedMaritime_ar = '<img src="'.base_url().'img/unchecked.png" class="icon arabic" />';
                        }
                        if($query['airline'] == 1) {
                            $checkedAirline_en = '<img src="'.base_url().'img/checked.png" class="icon english" />';
                            $checkedAirline_ar = '<img src="'.base_url().'img/checked.png" class="icon arabic" />';
                        }
                        else {
                            $checkedAirline_en = '<img src="'.base_url().'img/unchecked.png" class="icon english" />';
                            $checkedAirline_ar = '<img src="'.base_url().'img/unchecked.png" class="icon arabic" />';
                        }
                        if($query['member_overseas_ar'] != '' || $query['member_overseas_en'] != '') {
                            $checkedoverseas_en = '<img src="'.base_url().'img/checked.png" class="icon english" />';
                            $checkedoverseas_ar = '<img src="'.base_url().'img/checked.png" class="icon arabic" />';
                        }
                        else {
                            $checkedoverseas_en = '<img src="'.base_url().'img/unchecked.png" class="icon english" />';
                            $checkedoverseas_ar = '<img src="'.base_url().'img/unchecked.png" class="icon arabic" />';
                        }
                        if($query['member_local_ar'] != '' || $query['member_local_en'] != '') {
                            $checkedlocal_en = '<img src="'.base_url().'img/checked.png" class="icon english" />';
                            $checkedlocal_ar = '<img src="'.base_url().'img/checked.png" class="icon arabic" />';
                        }
                        else {
                            $checkedlocal_en = '<img src="'.base_url().'img/unchecked.png" class="icon english" />';
                            $checkedlocal_ar = '<img src="'.base_url().'img/unchecked.png" class="icon arabic" />';
                        }

                        echo '<div class="span5">'.$checkedMaritime_en.' Maritime<br>'.$checkedlocal_en.' Locally<br>'.$query['member_local_en'].'</div>
					<div class="span5">'.$checkedAirline_en.' Airline<br>'.$checkedoverseas_en.' Overseas<br>'.$query['member_overseas_en'].'</div>';
                        ?></td>
                    <td colspan="3" style="border-left:none !important; text-align:right">
                        <h2 class="arabic" style="margin-left:15px !important;">عضويتها في هيئات   : </h2>
                        <?php echo '<div class="span6 label-ar"> بحرية  '.$checkedMaritime_ar.'<br> في الخارج '.$checkedoverseas_ar.'<br>'.$query['member_overseas_ar'].'</div>
						<div class="span6 label-ar"> جوية '.$checkedAirline_ar.'<br>محليا'.$checkedlocal_ar.'<br>'.$query['member_local_ar'].'</div>';?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" valign="top" style="border-right:none !important">
                        <h2 class="english" style="margin-right:15px !important;">Services : </h2>

<?php
if($query['service_landline'] == 1) {
    $s_landline_en = '<img src="'.base_url().'img/checked.png" class="icon english" />';
    $s_landline_ar = '<img src="'.base_url().'img/checked.png" class="icon arabic" />';
}
else {
    $s_landline_en = '<img src="'.base_url().'img/unchecked.png" class="icon english" />';
    $s_landline_ar = '<img src="'.base_url().'img/unchecked.png" class="icon arabic" />';
}
if($query['service_maritime'] == 1) {
    $s_maritime_en = '<img src="'.base_url().'img/checked.png" class="icon english" />';
    $s_maritime_ar = '<img src="'.base_url().'img/checked.png" class="icon arabic" />';
}
else {
    $s_maritime_en = '<img src="'.base_url().'img/unchecked.png" class="icon english" />';
    $s_maritime_ar = '<img src="'.base_url().'img/unchecked.png" class="icon arabic" />';
}
if($query['service_airline'] == 1) {
    $s_airline_en = '<img src="'.base_url().'img/checked.png" class="icon english" />';
    $s_airline_ar = '<img src="'.base_url().'img/checked.png" class="icon arabic" />';
}
else {
    $s_airline_en = '<img src="'.base_url().'img/unchecked.png" class="icon english" />';
    $s_airline_ar = '<img src="'.base_url().'img/unchecked.png" class="icon arabic" />';
}

echo '<div class="span57">'.$s_landline_en.' Landline</div><div class="span57">'.$s_maritime_en.' Maritime</div><div class="span57">'.$s_airline_en.'Airline</div>';
?></td>
                    <td colspan="3" style="border-left:none !important; text-align:right">
                        <h2 class="arabic" style="margin-left:15px !important;">  خدمات النقل :</h2>
                        <?php echo '<div class="span67 label-ar"> برية  '.$s_landline_ar.'</div><div class="span67 label-ar"> بحرية '.$s_maritime_ar.'</div><div class="span67 label-ar"> جوية'.$s_airline_ar.'</div>';?>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" valign="top" style="border-right:none !important">
                        <h2 class="english" style="margin-right:15px !important;"> Comuting Transportation : </h2>
                        <?php
                        $array_services = explode(',', $query['services']);
                        $div_ar = '';
                        $div_en = '';
                        foreach($services as $service) {
                            if(in_array($service->id, $array_services)) {
                                $img_en = '<img src="'.base_url().'img/checked.png" class="icon english" />';
                                $img_ar = '<img src="'.base_url().'img/checked.png" class="icon arabic" />';
                            }
                            else {
                                $img_en = '<img src="'.base_url().'img/unchecked.png" class="icon english" />';
                                $img_ar = '<img src="'.base_url().'img/unchecked.png" class="icon arabic" />';
                            }
                            $div_en.='<div class="span58">'.$img_en.' '.$service->label_en.'</div>';
                            $div_ar.='<div class="span68">'.$img_ar.' '.$service->label_ar.'</div>';
                        }
                        echo $div_en;
                        ?>
                    </td>
                    <td colspan="3" style="border-left:none !important; text-align:right">
                        <h2 class="arabic" style="margin-left:15px !important;"> الخدمات البرية :  </h2>
                        <?php echo $div_ar;?>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" valign="top" style="border-right:none !important">
                        <table style="width:100%; border:none !important">
                            <tr style="width:100%; border:none !important">
                                <td style=" border:none !important"><h2 class="english" style="margin-right:15px !important;"> Foreign Companies Represented in Lebanon : </h2></td>
                                <td style="text-align:right; width:50%; border:none !important"><h2 class="arabic" style="margin-left:15px !important; "> الوكلات الاجنبية التي تمثلها في لبنان   : </h2></td>
                            </tr>
                        <?php
                        foreach($represented as $item) {
                            echo '<tr><td style=" border:none !important">'.$item->name_en.'</td><td style="text-align:right;  border:none !important">'.$item->name_ar.'</td></tr>';
                        }
                        ?>
                        </table>
                </tr>
                <tr>
                    <td colspan="5" valign="top" style="border-right:none !important">
                        <table style="width:100%; border:none !important">
                            <tr style="width:100%; border:none !important">
                                <td style=" border:none !important">
                                    <h2 class="english" style="margin-right:15px !important;"> Ports Served By The Vessels :  </h2></td>
                                <td style="text-align:right; width:50%; border:none !important"><h2 class="arabic" style="margin-left:15px !important; "> المرافىء التي تقصدها البواخر :</h2></td>
                            </tr>
<?php
foreach($ports as $port) {
    echo '<tr><td style=" border:none !important">'.$port->name_en.'</td><td style="text-align:right;  border:none !important">'.$port->name_ar.'</td></tr>';
}
?>
                        </table>
                </tr>
<?php /* <tr>
  <td colspan="2" valign="top" style="border-right:none !important">
  <h2 class="english" style="margin-right:15px !important;"> Foreign Companies Represented in Lebanon : </h2>
  <?php foreach($represented as $item){
  echo $item->name_en.'<br>';
  }
  ?>
  </td>
  <td colspan="3" style="border-left:none !important; text-align:right">
  <h2 class="arabic" style="margin-left:15px !important;"> الشركات الاجنبية التي تمثلها في لبنان   : </h2>
  <?php foreach($represented as $item){
  echo $item->name_ar.'<br>';
  }
  ?>

  </td>
  </tr>
 */?>
                <tr class="trhead">
                    <td colspan="5" class="thead">
                        <div class="thead english">Head Office Address : </div>
                        <div class="thead arabic">عنوان المركز الرئيسي  : </div>
                    </td>
                </tr>
                <?php
                if(count($governorates) > 0) {
                    $gov_en = $governorates['label_en'];
                    $gov_ar = $governorates['label_ar'];
                }
                else {
                    $gov_en = '';
                    $gov_ar = '';
                }
                ?>
                <tr>
                    <td colspan="5">
                        <div class="label english">Mohafaza : </div>
                        <div class="data-box english"><?=$gov_en;?></div>
                        <div class="label arabic">  المحافظة : </div>
                        <div class="data-box arabic"><?=$gov_ar;?></div>
                    </td>
                </tr>
                <?php
                if(count($districts) > 0) {
                    $district_en = $districts['label_en'];
                    $district_ar = $districts['label_ar'];
                }
                else {
                    $district_en = '';
                    $district_ar = '';
                }
                ?>
                <tr>
                    <td colspan="5">
                        <div class="label english">Kazaa : </div>
                        <div class="data-box english"><?=$district_en;?></div>
                        <div class="label arabic">  القضاء : </div>
                        <div class="data-box arabic"><?=$district_ar;?></div>
                    </td>
                </tr>
                <?php
                if(count($area) > 0) {
                    $area_en = $area['label_en'];
                    $area_ar = $area['label_ar'];
                }
                else {
                    $area_en = '';
                    $area_ar = '';
                }
                ?>
                <tr>
                    <td colspan="5">
                        <div class="label english">City : </div>
                        <div class="data-box english"><?=$area_en;?></div>
                        <div class="label arabic">   البلدة او المحلة : </div>
                        <div class="data-box arabic"><?=$area_ar;?></div>
                    </td>
                </tr>

                <tr>
                    <td colspan="5">
                        <div class="label english">Street : </div>
                        <div class="data-box english"><?=$query['street_en'];?></div>
                        <div class="label arabic">  الشارع : </div>
                        <div class="data-box arabic"><?=$query['street_ar'];?></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <div class="label english">Bldg : </div>
                        <div class="data-box english"><?=$query['bldg_en'];?></div>
                        <div class="label arabic">  البناية : </div>
                        <div class="data-box arabic"><?=$query['bldg_ar'];?></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <div class="label english">Tel : </div>
                        <div class="label arabic">  هاتف: </div>
                        <div class="data-box arabic"><?=$query['phone'];?></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <div class="label english">Fax : </div>
                        <div class="label arabic">  فاكس: </div>
                        <div class="data-box arabic"><?=$query['fax'];?></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <div class="label english">P.O.Box : </div>
                        <div class="data-box english"><?=$query['pobox_en'];?></div>
                        <div class="label arabic">  ص. بريد : </div>
                        <div class="data-box arabic"><?=$query['pobox_ar'];?></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <div class="label english">Email : </div>
                        <div class="data-box english"><?=$query['email'];?></div>
                        <div class="label arabic"> البريد الالكتروني : </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <div class="label english">Website : </div>
                        <div class="data-box english"><?=$query['website'];?></div>
                        <div class="label arabic" >  الموقع الالكتروني: </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="label english">N Location : </div>
                        <div class="data-box english"><?=$query['x_location'];?></div>
                    </td>
                    <td colspan="3">
                        <div class="label english">E Location : </div>
                        <div class="data-box english"><?=$query['y_location'];?></div>
                    </td>
                </tr>
<?php
if(count($salesman) > 0) {
    $sales_man = $salesman['fullname'];
}
else {
    $sales_man = '';
}
if(count($position) > 0) {
    $pos = $position['label_ar'];
}
else {
    $pos = '';
}
?>
                <tr class="trhead">
                    <td colspan="5">
                        <div class="box">
                            <table dir="rtl" width="100%"  style="border:none !important" cellpadding="10px">
                                <tr>
                                    <td width="70%" colspan="3" style="border:none !important; font-size:18px !important"><strong>- اسم الشخص الذي تمت معه  المقابلة في  المؤسسة : </strong><?=$query['res_person_ar'].'&nbsp;&nbsp;&nbsp;<span style="float:left1">'.$query['res_person_en'].'</span>';?></td>

                                </tr>
                                <tr><td width="50%" style="border:none !important; font-size:18px !important" colspan="2"><strong>- صفته في المؤسسة : </strong><?=$pos?></td><td width="50%" style="border:none !important; font-size:18px !important"><strong>- توقيعه : </strong></td></tr>
                                <tr>
                                    <td width="40%" style="border:none !important; font-size:18px !important; font-size:18px !important">
                                        <strong>- اسم المندوب : </strong><?=$sales_man?></td>
                                    <td width="40%" style="border:none !important; font-size:18px !important"><strong>- تاريخ ملئ الاستمارة : </strong></td>
                                    <td width="20%" style="border:none !important; font-size:18px !important"><strong>- توقيعه : </strong></td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
            <div class="break"></div>
            <table class="table-view" style="width:920px !important" style="margin-top:10px !important">

                <tr class="trhead">
                    <td colspan="5" class="thead">
                        <div class="thead english">Administration : </div>
                        <div class="thead arabic">خاص  بإدارة الدليل: </div>
                    </td>
                </tr>
                <tr>
                    <td  colspan="5">
<?php $style_ins_en = "class='english'";?>
                        <table dir="rtl" width="100%" style="border:none !important; font-size:18px !important" cellpadding="10px">
                            <tr>
                                <td style="border:none !important; font-size:18px !important">- استلام  الاستمارة من المندوب <br /><br />
                                    التاريخ : <br /><br />
                                    التوقيع
                                </td>
                                <td style="border:none !important; font-size:18px !important">- التدقيق مع المؤسسات <br /><br />
                                    التاريخ : <br /><br />
                                    التوقيع
                                </td>
                                <td style="border:none !important; font-size:18px !important">- ادخال معلومات الاستمارة <br /><br />
                                    التاريخ : <br /><br />
                                    التوقيع
                                </td>
                                <td style="border:none !important; font-size:18px !important">- حفظ  الاستمارة <br /><br />
                                    التاريخ : <br /><br />
                                    التوقيع
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
                <!--
                            <tr class="trhead">
                    <td colspan="5" class="thead" style="text-align:center">المؤسسات الراعية</td>
                </tr>
                            <tr>
                    <td colspan="5" style="text-align:center">
                    <div class="sponsor">
<?php
foreach($sponsors as $sponsor) {
    echo '<img src="'.base_url().$sponsor->logo.'" class="th-logo" />';
}
?>
                     </div>
                    </td>
                </tr>-->

            </table>
        </div>
        <div class="break"></div>
    </body>
</html>