<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<style type="text/css">
    tr, td, table, tr {
        border: 1px solid #D0D0D0;
    }

    .yellow {
        background: #FF0 !important;
        font-weight: bold;
    }
</style>
<table>
    <tr>
        <td class="yellow" style="width: 50%">رقم الاستمارة</td>
        <td style="width: 50%"><?= $query['id']; ?>&nbsp;</td>
    </tr>
    <tr>
        <td class="yellow">Bank Name</td>
        <td><?= $query['name_en']; ?>&nbsp;</td>
    </tr>
    <tr>
        <td class="yellow"> اسم المصرف</td>
        <td><?= $query['name_ar']; ?>&nbsp;</td>
    </tr>
    <tr>
        <td class="yellow">C.R</td>
        <td><?php echo @$license['label_en'] . ' / ' . $query['trade_license']; ?>&nbsp;</td>
    </tr>
    <tr>
        <td class="yellow"> س.ت:</td>
        <td><?php echo @$license['label_ar'] . ' / ' . $query['trade_license']; ?>&nbsp;</td>
    </tr>
    <tr>
        <td class="yellow">رأس المال :</td>
        <td><?= $query['bnk_capital']; ?>&nbsp;&nbsp;</td>
    </tr>
    <tr>

        <td class="yellow"> تاريخ التأسيس :</td>
        <td class="data-box english"><?= $query['establish_date']; ?>&nbsp;</td>
    </tr>
    <tr>
        <td class="yellow"> لائحة المصارف :</td>
        <td class="data-box arabic"><?= $query['list_number']; ?>&nbsp;</td>
    </tr>
    <tr class="trhead">
        <td colspan="2"  class="yellow">مجلس الادارة :</td>
    </tr>
    <tr>
        <td class="yellow">Board Of Directors</td>
        <td class="yellow">مجلس الادارة</td>
    </tr>
    <?php if (count($directors)) {
        foreach ($directors as $director) {

            ?>
            <tr>

                <td><?= $director->name_en ?></td>
                <td> <?= $director->name_ar ?></td>

            </tr>
            <?php
        }
    } else {
        for ($i = 0; $i < 3; $i++) {
            echo '<tr>
                                    <td>&nbsp;</td>
                                    <td style="text-align:right; width:50%">&nbsp;</td>
                                </tr>';
        }
    }

    ?>
    <tr class="trhead">
        <td class="thead">Head Office Address :</td>
        <td class="thead">

            عنوان المركز الرئيسي :
        </td>
    </tr>
    <?php
    if (count($governorates) > 0) {
        $gov_en = $governorates['label_en'];
        $gov_ar = $governorates['label_ar'];
    } else {
        $gov_en = '';
        $gov_ar = '';
    }
    ?>
    <tr>
        <td class="yellow">Mohafaza :</td>
        <td class="data-box english"><?= $gov_en; ?></td>
    </tr>
    <tr>
        <td class="yellow"> المحافظة :</td>
        <td class="data-box arabic"><?= $gov_ar; ?></td>
    </tr>
    <?php
    if ($query['address2_ar'] != '') {
        $array_address = explode('-', $query['address2_ar']);
    }
    if (count($districts) > 0) {
        $district_en = $districts['label_en'];
        $district_ar = $districts['label_ar'];
    } else {
        $district_en = '';
        $district_ar = '';
    }
    ?>
    <tr>
        <td class="yellow">Kazaa :</td>
        <td class="data-box english"><?= $district_en; ?></td>
    </tr>
    <tr>
        <td class="yellow"> القضاء :</td>
        <td class="data-box arabic"><?= $district_ar; ?></td>
    </tr>
    <?php
    if (count($area) > 0) {
        $area_en = $area['label_en'];
        $area_ar = $area['label_ar'];
    } else {
        $area_en = '';
        $area_ar = '';
    }
    ?>
    <tr>
        <td class="yellow">City :</td>
        <td class="data-box english"><?= $area_en; ?></td>
    </tr>
    <tr>
        <td class="yellow"> البلدة او المحلة :</td>
        <td class="data-box arabic"><?= $area_ar; ?></td>
    </tr>

    <tr>
        <td class="yellow">Street :</td>
        <td class="data-box english"><?= $query['street_en']; ?></td>
    </tr>
    <tr>
        <td class="yellow"> الشارع :</td>
        <td class="data-box arabic"><?= $query['street_ar']; ?></td>
    </tr>
    <tr>
        <td class="yellow">Bldg :</td>
        <td class="data-box english"><?= $query['bldg_en']; ?></td>
    </tr>
    <tr>
        <td class="yellow"> البناية :</td>
        <td class="data-box arabic"><?= $query['bldg_ar']; ?></td>
    </tr>
    <tr>
        <td class="yellow"> هاتف:</td>
        <td class="data-box arabic"><?= $query['phone']; ?></td>
    </tr>
    <tr>
        <td class="yellow"> فاكس:</td>
        <td class="data-box arabic"><?= $query['fax']; ?></td>
    </tr>
    <tr>
        <td class="yellow">P.O.Box :</td>
        <td class="data-box english"><?= $query['pobox_en']; ?></td>
    </tr>
    <tr>
        <td class="yellow"> ص. بريد :</td>
        <td class="data-box arabic"><?= $query['pobox_ar']; ?></td>
    </tr>
    <tr>
        <td class="yellow"> البريد الالكتروني :</td>
        <td class="data-box english"><?= $query['email']; ?></td>

    </tr>
    <tr>
        <td class="yellow"> الموقع الالكتروني:</td>
        <td class="data-box english"><?= $query['website']; ?></td>
    </tr>
    <tr>
        <td class="yellow">N Location Decimal:</td>
        <td class="data-box english"><?= $query['x_location']; ?></td>
    </tr>
    <tr>
        <td class="yellow">E Location Decimal: </td>
        <td class="data-box english"><?= $query['y_location']; ?></td>
    </tr>
    <tr class="trhead">
        <td colspan="2"  class="yellow">الفروع</td>
    </tr>
    <tr>
        <td colspan="2">
            <table class="table-view" style="width:920px !important; margin-top:10px !important">
                <tr style="background:#66CCFF !important; font-weight:bold !important">
                    <td>الفرع</td>
                    <td>Branch</td>
                    <td>مدير الفرع</td>
                    <td>Branch Manager</td>
                    <td>المحافظة</td>
                    <td>القضاء</td>
                    <td>البلدة</td>
                    <td>Phone</td>
                    <td>E-mail</td>
                </tr>
                <?php
                foreach ($branches as $branch) {
                    $b_area = $this->Address->GetAreaById($branch->area_id);
                    $b_district = $this->Address->GetDistrictById($b_area['district_id']);
                    $b_gov = $this->Address->GetGovernorateById($b_district['governorate_id']);
                    ?>
                    <tr>
                        <td><?= $branch->name_ar ?></td>
                        <td><?= $branch->name_en ?></td>
                        <td><?= $branch->beside_ar ?></td>
                        <td><?= $branch->beside_en ?></td>
                        <td><?= $b_gov['label_ar'] ?></td>
                        <td><?= $b_district['label_ar']?></td>
                        <td><?=$b_area['label_ar'] ?></td>
                        <td><?= $branch->phone ?></td>
                        <td><?= $branch->email ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>


