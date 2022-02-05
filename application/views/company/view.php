<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link media="all" href="<?=base_url()?>css/company-print.css" rel="stylesheet" />
        <title><?=$title?> </title>
        <style type="text/css " media="print">
            .div-print{

                clear: both;
            }
        </style>
       <!--
        <script type="text/javascript">
            /*
            $(document).ready(function() {
                var pHeight=$("#<?=$query['id']?>").height();
                var Height=1350;
                per=pHeight/Height;
                v=Math.ceil(per);
                if ((v % 2) == 0) {
                } else {
                   // $("#clear-page-<?=$query['id']?>").html("<div style='height: 1300px;'></div><div class='break'></div>");
                }
            });
*/

        </script>-->
    </head>

    <body>
        <div class="container" id="<?=$query['id']?>">
            <div class="header">
                <img src="<?=base_url()?>img/company-header.jpg" width="100%" />
                <!--
                        <div class="col-left">
                        <h3 class="english-h3">THE DIRECTORY OF EXPORTS & INDUSTRIAL FIRMS IN LEBANON</h3>
                        <h4 class="english-h4">Field Survey Project</h4>
                        <h5 class="english-h5">Data Form of Industrial Establishment</h5>
                    </div>
                    <div class="logo">
                        <img src="<?=base_url()?>img/logo.png" />
                        <h4>
                                                        بالتعاون <br />مع جمعية الصناعيين في لبنان
                        <br />(Association of Lebanese Industrialists)
                        </h4>
                    </div>
                    <div class="col-right">
                        <h3 class="arabic-h3">دليل الصادرات والمؤسسات الصناعية اللبنانية</h3>
                        <h4 class="arabic-h4">مشروع المسح الميداني</h4>
                        <h5 class="arabic-h5">بيانات مؤسسة صناعية</h5>
                    </div>
                -->
            </div>
            <div class="clear"></div>
            <table class="table-view" style="width:920px !important" style="margin-top:10px !important">
                <tr class="row"><td colspan="5" style="text-align:center"><h3>رقم الاستمارة : <?=$query['id']?></h3></td></tr>
                <tr>
                    <td colspan="5">
                        <div class="label arabic">  وزارة ID :</div>
                        <div class="data-box arabic"><?=$query['ministry_id'];?>&nbsp;</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <div class="label english">Company Name :</div>
                        <div class="data-box english"><?=$query['name_en'];?>&nbsp;</div>
                        <div class="label arabic"> اسم المؤسسة:</div>
                        <div class="data-box arabic"><?=$query['name_ar'];?>&nbsp;</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <div class="label english">Owner / Owners of The Co. :</div>
                        <div class="data-box english"><?=$query['owner_name_en'];?>&nbsp;</div>
                        <div class="label arabic"> صاحب / اصحاب الشركة: :</div>
                        <div class="data-box arabic"><?=$query['owner_name'];?>&nbsp;</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <div class="label english">Name of The Authorized to Sign :</div>
                        <div class="data-box english"><?=$query['auth_person_en'];?>&nbsp;</div>
                        <div class="label arabic"> اسم المفوض بالتوقيع  :</div>
                        <div class="data-box arabic"><?=$query['auth_person_ar'];?>&nbsp;</div>
                    </td>
                </tr>
                <?php
                if(count(@$license) > 0) {
                    $license_en = $license['label_en'];
                    $license_ar = $license['label_ar'];
                }
                else {
                    $license_en = '';
                    $license_ar = '';
                }
                ?>
                <tr>
                    <td colspan="5">
                        <div class="label english">No. & Place of C.R :</div>
                        <div class="data-box english"><?=$query['auth_no'].' '.$license_en;?>&nbsp;</div>
                        <div class="label arabic"> رقم ومحل اصدار السجل التجاري: </div>
                        <div class="data-box arabic"><?=$query['auth_no'].' '.$license_ar;?>&nbsp;</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <div class="label english">Activity :</div>
                        <div class="data-box english"><?=$query['activity_en'];?>&nbsp;</div>
                        <div class="label arabic"> نوع النشاط:</div>
                        <div class="data-box arabic"><?=$query['activity_ar'];?>&nbsp;</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <table dir="rtl" style="width:100%; border:none !important; border-collapse:collapse">
                            <tr>
                                <td rowspan="2"><div class="label arabic"> مصدر الرخصة : </div></td>
                                <td><div class="data-box arabic">
                                        <?php $img=(@$query['wezara_source'] == 1) ? '<img src="'.base_url().'img/checked.png" class="icon arabic" />' : '<img src="'.base_url().'img/unchecked.png" class="icon arabic" />' ;
                                        echo $img. 'وزارة الصناعة &nbsp&nbsp' ;
                                        ?>
                                    </div></td>
                                <td>
                                    <div class="data-box arabic"> <?php $img=(@$query['investment'] == 1) ? '<img src="'.base_url().'img/checked.png" class="icon arabic" />' : '<img src="'.base_url().'img/unchecked.png" class="icon arabic" />' ;
                                        echo $img. 'رخصة استثمار  &nbsp&nbsp' ;
                                        ?>
                                    </div></td>
                                <td>
                                    <div class="data-box arabic"> <?php $img=(@$query['origin'] == 1) ? '<img src="'.base_url().'img/checked.png" class="icon arabic" />' : '<img src="'.base_url().'img/unchecked.png" class="icon arabic" />' ;
                                        echo $img. 'رخصة انشاء  &nbsp&nbsp' ;
                                        ?>
                                    </div></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="label arabic">رقم الرخصة : </div>
                                    <div class="data-box arabic"><?=$query['nbr_source'];?></div>
                                </td>
                                <td>
                                    <div class="label arabic"> التاريخ :    </div>
                                    <div class="data-box arabic"><?=$query['date_source'];?></div>
                                </td>
                                <td>
                                    <div class="label arabic"> الفئة :    </div>
                                    <div class="data-box arabic"><?=$query['type_source'];?></div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="trhead">
                    <td colspan="5" class="thead">
                        <div class="thead english">Company Type : </div>
                        <div class="thead arabic">نوع الشركة : </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" style="text-align:center !important">
                        <ul class="type-list" style="margin-top:10px !important">
                            <?php
                            $style = 'style="float:right"  disabled="disabled"';
                            foreach($company_types as $ctype) {
                                if($ctype->id == $query['company_type_id'])
                                    $checked = '<img src="'.base_url().'img/checked.png" class="icon arabic" />';
                                else
                                    $checked = '<img src="'.base_url().'img/unchecked.png" class="icon arabic" />';
                                echo '<li style="text-align:right !important">'.$ctype->label_ar.'&nbsp;&nbsp;'.$checked.'<br><span class="list-en">'.$ctype->label_en.'</span></li>';
                            }
                            ?>
                        </ul>
                    </td>
                </tr>
                <tr class="trhead">
                    <td colspan="5" class="thead">
                        <img
                            <div class="thead english">Affiliation to Economical & Technical Associations : </div>
                            <div class="thead arabic">الانتساب الى هيئات اقتصادية او مهنية : </div>
                    </td>
                </tr>

                <tr>
                    <td colspan="5">
                        <div class="label english">Associations of Lebanese Industrialists : </div>
                        <div class="data-box english"><?php
                            if($query['ind_association'] == 1)
                                echo 'Yes';
                            else
                                echo 'No';
                            ?></div>
                        <div class="label arabic">  جمعية الصناعيين اللبنانيين  : </div>
                        <div class="data-box arabic"><?php
                            if($query['ind_association'] == 1)
                                echo 'نعم';
                            else
                                echo 'كلا';
                            ?></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <div class="label english">Chambre of Commerce & Industry of : </div>
                        <div class="data-box english"><?php
                            if(count($industrial_room) > 0) {
                                $industrial_room_en = $industrial_room['label_en'];
                                $industrial_room_ar = $industrial_room['label_ar'];
                            }
                            else {
                                $industrial_room_en = '';
                                $industrial_room_ar = '';
                            }
                            $industrial_room_en;
                            ?></div>
                        <div class="label arabic">غرفة التجارة والصناعة في : </div>
                        <div class="data-box arabic"><?=$industrial_room_ar?></div>
                    </td>
                </tr>
                <tr>
                    <?php
                    if(count($economical_assembly) > 0) {
                        $economical_assembly_en = $economical_assembly['label_en'];
                        $economical_assembly_ar = $economical_assembly['label_ar'];
                    }
                    else {
                        $economical_assembly_en = '';
                        $economical_assembly_ar = '';
                    }
                    if(count($industrial_group) > 0) {
                        $industrial_group_en = $industrial_group['label_en'];
                        $industrial_group_ar = $industrial_group['label_ar'];
                    }
                    else {
                        $industrial_group_en = '';
                        $industrial_group_ar = '';
                    }
                    ?>
                    <td colspan="5">
                        <div class="label english">Assemblies of Economical, Technical - Specify : </div>
                        <div class="data-box english"><?=$economical_assembly_en;?></div>
                        <div class="label arabic">  اتحادات مهنية اقليمية  - حدد:  </div>
                        <div class="data-box arabic"><?=$economical_assembly_ar;?></div>
                    </td>

                </tr>

                <tr>
                    <td colspan="5">
                        <div class="label english">Industrial Assembly : </div>
                        <div class="data-box english"><?=$industrial_group_en;?></div>
                        <div class="label arabic">  تجمع صناعي  :  </div>
                        <div class="data-box arabic"><?=$industrial_group_ar;?></div>
                    </td>
                </tr>
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
				if($query['address2_ar']!='')
				{
					$array_address=explode('-',$query['address2_ar']);					
					}
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
                       <!-- <div class="data-box arabic"><?=@$array_address[0];?></div>-->
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
                       <!-- <div class="data-box arabic"><?=@$array_address[1];?></div>-->
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
                        <div class="label english">N Location Decimal: </div>
                        <div class="data-box english"><?=$query['x_decimal'];?></div>
                    </td>
                    <td colspan="3">
                        <div class="label english">E Location Decimal: </div>
                        <div class="data-box english"><?=$query['y_decimal'];?></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                    <table width="100%" style="  border-collapse: collapse !important;">
                    <td>
                        <div class="label english">FaceBook: </div>
                        <div class="data-box english"><?=$query['facebook'];?></div>
                    </td>
                    <td>
                        <div class="label english">Instagram: </div>
                        <div class="data-box english"><?=$query['instagram'];?></div>
                    </td>
                    <td>
                        <div class="label english">Twitter: </div>
                        <div class="data-box english"><?=$query['twitter'];?></div>
                    </td>
                    <td>
                        <div class="label english">Whatsapp: </div>
                        <div class="data-box english"><?=$query['whatsapp'];?></div>
                    </td>
                    </table>
                    </td>
                </tr>
            </table>
            <div class="break"></div>
            <table class="table-view" style="width:920px !important" style="margin-top:10px !important">
                <tr class="trhead">
                    <td colspan="5" class="thead">
                        <div class="thead english">Production Information : </div>
                        <div class="thead arabic">معلومات عن الانتاج  : </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <table dir="rtl" class="table1">
                            <tr class="trheadg">
                                <td class="theadg">البند الجمركي
                                    (H.S. Code)
                                </td>
                                <td  class="theadg" style="text-align:center !important">الصنف</td>
                                <td  class="theadg" style="text-align:center !important">ITEMS</td>
                            </tr>
                            <?php
                            if(count($items)) {
                                foreach($items as $item) {
                                    if($item->heading_description_ar != '') {
                                        $heading_comp_ar = $item->heading_description_ar;
                                    }
                                    else {
                                        $heading_comp_ar = $item->heading_ar;
                                    }
                                    if($item->heading_description_en != '') {
                                        $heading_comp_en = $item->heading_description_en;
                                    }
                                    else {
                                        $heading_comp_en = $item->heading_en;
                                    }
                                    ?>
                                    <tr>
                                        <td width="20%"><?=$item->hscodeprint?></td>
                                        <td width="40%"><?=$heading_comp_ar?></td>
                                        <td width="40%" style="text-align:left"><?=$heading_comp_en?></td>
                                    </tr>
                                    <?php
                                }
                            }
                            else {
                                ?>
                                <tr>
                                    <td width="20%">&nbsp;</td>
                                    <td width="40%">&nbsp;</td>
                                    <td width="40%" style="text-align:left">&nbsp;</td>

                                </tr>
                            <?php }?>
                        </table>
                    </td>
                </tr>
                <?php if(count($items) > 12) {?>
                </table>
                <div class="break"></div>
                <table class="table-view" style="width:920px !important" style="margin-top:10px !important">


                <?php }?>
                <tr class="trhead">
                    <td colspan="5" class="thead">
                        <div class="thead english">Export & Trade Market : </div>
                        <div class="thead arabic">   اسواق البيع والتصدير: </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <table cellpadding="0" cellspacing="0" width="100%" class="table">

                            <tbody>
                                <?php
                                $label_en='';
                                $label_ar='';
                                if(count($markets)) {
                                    foreach($markets as $item) {
                                        if($item->item_type == 'country') {
                                            $row = $this->Parameter->GetCountryById($item->market_id);
                                          //  var_dump($row);
                                            $label_en = @$row['label_en'];
                                            $label_ar = @$row['label_ar'];
                                        }
                                        elseif($item->item_type == 'region') {
                                            $row = $this->Parameter->GetCompanyMarketById($item->market_id);
                                            $label_en = @$row['label_en'];
                                            $label_ar = @$row['label_ar'];
                                        }
                                        ?>
                                        <tr>
                                            <td style="text-align:left"><?=$label_en?></td>
                                            <td style="text-align:right; width:50%"><?=$label_ar?></td>

                                        </tr>
                                        <?php
                                    }
                                }
                                else{
                                    for($i=0;$i<2;$i++){
                                        echo '<tr style="height: 30px !important;">
                                            <td style="text-align:left"></td>
                                <td style="text-align:right; width:50%"></td>

                                </tr> ';
                                    }

                                }
                                ?>
                            </tbody>
                        </table>
                        <?php /*
                          $array_id=array();
                          $checkedi_en='<img src="'.base_url().'img/unchecked.png" class="icon english" />';
                          $checkedi_ar='<img src="'.base_url().'img/unchecked.png" class="icon arabic" />';
                          foreach($markets as $market)
                          {
                          array_push($array_id,$market->country_id);
                          }
                          if(in_array(7,$array_id)){
                          $checked_ar='<img src="'.base_url().'img/checked.png" class="icon arabic" />';
                          $checked_en='<img src="'.base_url().'img/checked.png" class="icon english" />';
                          }else{
                          $checked_ar='<img src="'.base_url().'img/unchecked.png" class="icon arabic" />';
                          $checked_en='<img src="'.base_url().'img/unchecked.png" class="icon english" />';
                          }
                          if(count($array_id)>0 and !in_array(7,$array_id)){
                          $checkedi_en='<img src="'.base_url().'img/unchecked.png" class="icon english" />';
                          $checkedi_ar='<img src="'.base_url().'img/unchecked.png" class="icon arabic" />';
                          }

                          $style_en='style="float:left"  disabled="disabled"';
                          ?>
                          <div class="label english">Local Market <?php echo $checked_en ?></div>
                          <div class="label arabic"><?php

                          $style_ar='style="float:right"  disabled="disabled"';
                          ?>
                          اسواق محلية <?php echo $checked_ar?></div>

                          </td>
                          </tr>
                          <tr>
                          <td colspan="5">
                          <div class="label english"><?php echo $checkedi_en?> International Market / Country Name </div>
                          <div class="label arabic">

                          اسواق الدول الخارجية / اسم الدولة
                          <?php echo $checkedi_ar?></div>
                          </td>
                          </tr>
                          <?php
                          if(count($markets)>0){
                          foreach($markets as $market){ ?>
                          <tr>
                          <td class="point english" nowrap="nowrap"><?=$market->market_en.' / '.$market->country_en?></td>
                          <td class="empty">&nbsp;</td>
                          <td class="point arabic" nowrap="nowrap"><?=$market->market_ar.' / '.$market->country_ar?></td>
                          </tr>
                          <?php	}}
                         */?>

                        <tr class="trhead">
                            <td colspan="5" class="thead">
                                <div class="thead english">Means of Export : </div>
                                <div class="thead arabic">  طريقة التصدير : </div>
                            </td>
                        </tr>

                        <?php
                        $style_ins_exp = "class='english' disabled='disabled'";
                        $checked_l = '';
                        $checked_d = '';
                        $checked_m = '';
                        if(@$query['is_exporter'] == 0) {
                            $checked_d = '<img src="'.base_url().'img/unchecked.png" class="icon english" />';
                            $checked_l = '<img src="'.base_url().'img/checked.png" class="icon english" />';
                            $checked_m = '<img src="'.base_url().'img/unchecked.png" class="icon english" />';
                        }
                        elseif(@$query['is_exporter'] == 1) {
                            $checked_d = '<img src="'.base_url().'img/checked.png" class="icon english" />';
                            $checked_l = '<img src="'.base_url().'img/unchecked.png" class="icon english" />';
                            $checked_m = '<img src="'.base_url().'img/unchecked.png" class="icon english" />';
                        }
                        elseif(@$query['is_exporter'] == 2) {
                            $checked_d = '<img src="'.base_url().'img/unchecked.png" class="icon english" />';
                            $checked_l = '<img src="'.base_url().'img/unchecked.png" class="icon english" />';
                            $checked_m = '<img src="'.base_url().'img/checked.png" class="icon english" />';
                        }
                        ?>
                        <tr>
                            <td colspan="5" style="direction:rtl; text-align:center ">
                                <ul class="type-list" style="float:right; font-size:18px !important">
                                    <li style="margin-left:150px; margin-right:10px;">-<?=$checked_m.'&nbsp; بالواسطة/ Mediation'?></li>
                                    <li style="margin-left:150px; margin-right:10px;">-<?=$checked_d.'&nbsp;  مباشر/ Direct'?></li>
                                    <li>-<?=$checked_l.'&nbsp; غير مصدر/ Export Less'?></li>

                                </ul>
                            </td>
                        </tr>
                    <tr class="trhead">
                        <td colspan="5" class="thead">
                            <div class="thead english">Number of Labour : </div>
                            <div class="thead arabic">  عدد العمال : </div>
                        </td>
                    </tr>

                    <?php
                    $style_ins_exp = "class='english' disabled='disabled'";
                    $checked_l = '';
                    $checked_d = '';
                    $checked_m = '';
                    if(@$query['is_exporter'] == 0) {
                        $checked_d = '<img src="'.base_url().'img/unchecked.png" class="icon english" />';
                        $checked_l = '<img src="'.base_url().'img/checked.png" class="icon english" />';
                        $checked_m = '<img src="'.base_url().'img/unchecked.png" class="icon english" />';
                    }
                    elseif(@$query['is_exporter'] == 1) {
                        $checked_d = '<img src="'.base_url().'img/checked.png" class="icon english" />';
                        $checked_l = '<img src="'.base_url().'img/unchecked.png" class="icon english" />';
                        $checked_m = '<img src="'.base_url().'img/unchecked.png" class="icon english" />';
                    }
                    elseif(@$query['is_exporter'] == 2) {
                        $checked_d = '<img src="'.base_url().'img/unchecked.png" class="icon english" />';
                        $checked_l = '<img src="'.base_url().'img/unchecked.png" class="icon english" />';
                        $checked_m = '<img src="'.base_url().'img/checked.png" class="icon english" />';
                    }
                    ?>
                    <tr>
                        <td colspan="5" style="direction:rtl; text-align:center ">
                            <ul class="type-list" style="float:right; font-size:18px !important">
                                <?php
                                           $array_employees = array(
                                            '1 - 10' => '1 - 10',
                                            '10 - 20' => '10 - 20',
                                            '20 - 30' => '20 - 30',
                                            '30 - 40' => '30 - 40',
                                            '40 - 50' => '40 - 50',
                                            '50 - 100' => '50 - 100',
                                            '100 - 200' => '100 - 200',
                                
                                        );
                                foreach(@$array_employees as $key=>$value){
                                    if($value==$query['employees_number']){
                                        $checked_int = '<img src="'.base_url().'img/checked.png" class="icon english" />';
                                    }
                                    else{
                                        $checked_int = '<img src="'.base_url().'img/unchecked.png" class="icon english" />';
                                    }
                                    ?>
                                <li style="margin-left:10px; margin-right:10px;"><?=$checked_int.'&nbsp;['.$value.'['?></li>
                                <?php } ?>

                            </ul>
                        </td>
                    </tr>
                        <tr class="trhead">
                            <td colspan="5" class="thead">
                                <div class="thead english">Insurance : </div>
                                <div class="thead arabic">التأمين : </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <?php
                                $style_ins_en = "class='english' disabled='disabled'";
                                if(count($insurances) > 0) {
                                    $checked_yes_en = '<img src="'.base_url().'img/checked.png" class="icon english" />';
                                    $checked_yes_ar = '<img src="'.base_url().'img/checked.png" class="icon arabic" />';
                                    $checked_no_en = '<img src="'.base_url().'img/unchecked.png" class="icon english" />';
                                    $checked_no_ar = '<img src="'.base_url().'img/unchecked.png" class="icon arabic" />';
                                }
                                else {
                                    $checked_no_en = '<img src="'.base_url().'img/checked.png" class="icon english" />';
                                    $checked_no_ar = '<img src="'.base_url().'img/checked.png" class="icon arabic" />';
                                    $checked_yes_en = '<img src="'.base_url().'img/unchecked.png" class="icon english" />';
                                    $checked_yes_ar = '<img src="'.base_url().'img/unchecked.png" class="icon arabic" />';
                                }
                                ?>
                                <div class="label english">Do You Have Insurance </div>
                                <div class="data-box english"><?=$checked_yes_en.'&nbsp;Yes'?></div>
                                <div class="data-box english"><?=$checked_no_en.'&nbsp;No'?></div>
                                <div class="label arabic">هل المؤسسة مؤمنة : </div>
                                <div class="data-box arabic"><?=$checked_yes_ar.'&nbsp;نعم'?></div>
                                <div class="data-box arabic"><?=$checked_no_ar.'&nbsp;كلا'?></div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <div style="margin-left:20px !important">
                                    <div class="label english">Insurance Co. Name : </div>
                                    <div class="data-box english"><?php
                                        if(count($insurances) > 0) {
                                            foreach($insurances as $insurance) {
                                                echo $insurance->insurance_en.'<br>';
                                            }
                                        }
                                        ?></div>
                                </div>
                                <div style="margin-right:20px !important">
                                    <div class="label arabic">اسم شركة التأمين :  </div>
                                    <div class="data-box arabic"><?php
                                        if(count($insurances) > 0) {
                                            foreach($insurances as $insurance) {
                                                echo $insurance->insurance_ar.'<br>';
                                            }
                                        }
                                        ?></div>
                                </div>
                            </td>
                        </tr>
                        <tr class="trhead">
                            <td colspan="5" class="thead">
                                <div class="thead english">Banks : </div>
                                <div class="thead arabic">المصارف المعتمدة : </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <div class="label english">Bank Name : </div>
                                <div class="data-box english"><?php
                                    if(count($banks)) {
                                        foreach($banks as $bank) {
                                            echo $bank->bank_en.'<br>';
                                        }
                                    }
                                    ?></div>
                                <div class="label arabic">  اسم البنك: </div>
                                <div class="data-box arabic">
                                    <?php
                                    if(count($banks)) {
                                        foreach($banks as $bank) {
                                            echo $bank->bank_ar.'<br>';
                                        }
                                    }
                                    ?></div>
                            </td>
                        </tr>
                       
                        <tr class="trhead">
                            <td colspan="5" class="thead">
                                <div class="thead english">Electric Power/year : </div>
                                <div class="thead arabic">استعمال الطاقة/ بالسنة : </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="5">
                                <?php
                                $style_ins_p = "class='english' disabled='disabled'";
                                $checked_f_en = '<img src="'.base_url().'img/unchecked.png" class="icon english" />';
                                $checked_f_ar = '<img src="'.base_url().'img/unchecked.png" class="icon arabic" />';
                                $checked_d_en = '<img src="'.base_url().'img/unchecked.png" class="icon english" />';
                                $checked_d_ar = '<img src="'.base_url().'img/unchecked.png" class="icon arabic" />';
                                if(count($powers)) {
                                    foreach($powers as $power) {
                                        if($power->fuel != '') {
                                            $checked_f_en = '<img src="'.base_url().'img/checked.png" class="icon english" />';
                                            $checked_f_ar = '<img src="'.base_url().'img/checked.png" class="icon arabic" />';
                                        }
                                        else {
                                            $checked_f_en = '<img src="'.base_url().'img/unchecked.png" class="icon english" />';
                                            $checked_f_ar = '<img src="'.base_url().'img/unchecked.png" class="icon arabic" />';
                                        }
                                        if($power->diesel != '') {
                                            $checked_d_en = '<img src="'.base_url().'img/checked.png" class="icon english" />';
                                            $checked_d_ar = '<img src="'.base_url().'img/checked.png" class="icon arabic" />';
                                        }
                                        else {
                                            $checked_d_en = '<img src="'.base_url().'img/unchecked.png" class="icon english" />';
                                            $checked_d_ar = '<img src="'.base_url().'img/unchecked.png" class="icon arabic" />';
                                        }
                                    }
                                }
                                ?>
                                <div class="label english"><?=$checked_f_en.'&nbsp;Fuel / Ton Or Litre'?></div>
                                <div class="data-box english"><?php
                                    if(count($powers)) {
                                        foreach($powers as $power) {
                                            echo $power->fuel;
                                        }
                                    }
                                    ?></div>
                                <div class="label arabic"><?=$checked_f_ar.'&nbsp;فيول / طن او ليتر'?></div>
                                <div class="data-box arabic">
                                    <?php
                                    if(count($powers)) {
                                        foreach($powers as $power) {
                                            echo $power->fuel;
                                        }
                                    }
                                    ?></div>

                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">

                                <div class="label english"><?=$checked_d_en.'&nbsp;Diesel / Ton Or Litre'?></div>
                                <div class="data-box english"><?php
                                    if(count($powers)) {
                                        foreach($powers as $power) {
                                            echo $power->diesel;
                                        }
                                    }
                                    ?></div>
                                <div class="label arabic"><?=$checked_d_ar.'&nbsp;مازوت / طن او ليتر'?></div>
                                <div class="data-box arabic">
                                    <?php
                                    if(count($powers)) {
                                        foreach($powers as $power) {
                                            echo $power->diesel;
                                        }
                                    }
                                    ?></div>

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
                                        <tr><td colspan="2" style="border:none !important; font-size:18px !important">- اسم الشخص الذي تمت معه  المقابلة في  المؤسسة : <?=$query['rep_person_ar'].'&nbsp;&nbsp;&nbsp;<span style="float:left1">'.$query['rep_person_en'].'</span>';?></td></tr>
                                        <tr><td width="50%" style="border:none !important; font-size:18px !important">- صفته في المؤسسة : <?=$pos?></td><td width="50%" style="border:none !important; font-size:18px !important">- توقيعه : </td></tr>
                                        <tr><td width="50%" style="border:none !important; font-size:18px !important; font-size:18px !important">- اسم المندوب : <?=$sales_man?></td><td width="50%" style="border:none !important; font-size:18px !important">- توقيعه : </td></tr>
                                        <tr><td width="50%" style="border:none !important; font-size:18px !important">- ختم وتوقيع الشركة : </td><td width="50%" style="border:none !important; font-size:18px !important">- تاريخ ملئ الاستمارة : </td></tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
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
                        <?php /*
                    <tr class="trhead">
                        <td colspan="5" class="thead">
                            <div class="thead english">Notes : </div>
                            <div class="thead arabic"> ملاحظات : </div>
                        </td>
                    </tr>
                    <tr>
                        <td  colspan="5"><p><?=nl2br($query['personal_notes'])?></p>
                        </td>
                    </tr>
                    */?>
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
        <?php if(count($items) > 11) {?>
            <div style="height:600px !important">&nbsp;</div>
            <div class="break"></div>



        <?php }?>
        <div id="clear-page-<?=$query['id']?>"></div>
                        </body>
                        </html>