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
        <td class="yellow">Company Name</td>
        <td><?= $query['name_en']; ?>&nbsp;</td>
    </tr>
    <tr>
        <td class="yellow"> اسم الشركة</td>
        <td><?= $query['name_ar']; ?>&nbsp;</td>
    </tr>
    <tr>
        <td class="yellow">Owner / Owners of The Co.</td>
        <td><?php echo $query['owner_en']; ?>&nbsp;</td>
    </tr>
    <tr>
        <td class="yellow"> صاحب / اصحاب الشركة:</td>
        <td><?=$query['owner_ar'];?></td>
    </tr>
    <tr class="trhead">
        <td colspan="2"  class="yellow">مجلس الادارة :</td>
    </tr>
    <tr>
        <td class="yellow">Sectors</td>
        <td class="yellow">القطاعات</td>
    </tr>
    <?php
    $array_activities = array();
    $array_activities = explode(',', $query['activities']);
    $checked_activity = base_url().'img/unchecked.png';
    foreach($activities as $activity) {
        if (in_array($activity->id, $array_activities)) {
            ?>
            <tr>

                <td><?= $activity->label_en ?></td>
                <td> <?= $activity->label_ar ?></td>

            </tr>
    <?php }
    }
    ?>
    <tr>
        <td class="yellow">Activities</td>
        <td><?php echo $query['activity_other_en']; ?>&nbsp;</td>
    </tr>
    <tr>
        <td class="yellow"> نوع النشاط الرئيسي</td>
        <td><?=$query['activity_other_ar'];?></td>
    </tr>

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
        <td colspan="2"  class="yellow">الشركات الاجنبية التي تمثلها في لبنان</td>
    </tr>
    <tr>
        <td colspan="2">
            <table class="table-view" style="width:920px !important; margin-top:10px !important">
                <tr style="background:#66CCFF !important; font-weight:bold !important">
                    <td>اسم الشركة</td>
                    <td>Co. Names</td>
                    <td>العنوان</td>
                    <td>Address</td>
                    <td>نوع السلعة المستوردة</td>
                    <td>Items Imported</td>
                    <td>العلامة التجارية </td>
                    <td>Trade Mark</td>
                </tr>
                <?php
                foreach ($fcompanies as $company) {

                    ?>
                    <tr>
                        <td><?= $company->name_ar ?></td>
                        <td><?= $company->name_en ?></td>
                        <td><?= $company->address_ar ?></td>
                        <td><?= $company->address_en?></td>
                        <td><?=$company->items_ar ?></td>
                        <td><?= $company->items_en ?></td>
                        <td><?= $company->trade_mark_ar ?></td>
                        <td><?= $company->trade_mark_en ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>


