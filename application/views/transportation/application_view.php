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
        <td class="yellow"> صاحب / اصحاب الشركة</td>
        <td><?= $query['owner_ar']; ?></td>
    </tr>
    <tr>
        <td class="yellow">C.R</td>
        <td> <?= $query['trade_license'] . ' - ' . @$license['label_en']; ?>&nbsp;</td>
    </tr>
    <tr>
        <td class="yellow"> س.ت. / رقم الترخيص</td>
        <td><?= $query['trade_license']; ?> - <?= @$license['label_ar'] ?></td>
    </tr>
    <tr>
        <td class="yellow">Date Founded</td>
        <td> <?= $query['est_date']; ?>&nbsp;</td>
    </tr>
    <tr>
        <td class="yellow"> تاريخ التأسيس</td>
        <td><?= $query['est_date']; ?></td>
    </tr>
    <tr>
        <td class="yellow"> عضويتها في هيئات</td>
        <td><?php
            if ($query['maritime'] == 1) {
                echo ' , بحرية';
            }

            if ($query['airline'] == 1) {
                echo ', جوية ';
            }

            if ($query['member_overseas_ar'] != '' || $query['member_overseas_en'] != '') {
                echo $query['member_overseas_ar'] . ' ,';
            }

            if ($query['member_local_ar'] != '' || $query['member_local_en'] != '') {
                echo $query['member_local_ar'];
            }

            ?></td>
    </tr>
    <tr>
        <td class="yellow"> خدمات</td>
        <td><?php
            if ($query['service_landline'] == 1) {
                echo 'برية ,';
            }

            if ($query['service_maritime'] == 1) {
                echo 'بحرية ,';
            }

            if ($query['service_airline'] == 1) {
                echo 'جوية';
            }


            ?></td>
    </tr>
    <tr class="trhead">
        <td colspan="2" class="yellow">الخدمات البرية</td>
    </tr>
    <tr>
        <td class="yellow">Comuting Transportation</td>
        <td class="yellow">الخدمات البرية</td>
    </tr>
    <?php
    $array_services = array();
    $array_services = explode(',', $query['services']);
    foreach ($services as $service) {
        if (in_array($service->id, $array_services)) {
            ?>
            <tr>

                <td><?= $service->label_en ?></td>
                <td> <?= $service->label_ar ?></td>

            </tr>
        <?php }
    }
    ?>

    <tr class="trhead">
        <td class="yellow">Foreign Companies Represented in Lebanon</td>
        <td class="yellow">الوكلات الاجنبية التي تمثلها في لبنان</td>
    </tr>

    <?php
    foreach ($represented as $item) {
        echo '<tr><td>' . $item->name_en . '</td><td style="text-align:right; ">' . $item->name_ar . '</td></tr>';

    } ?>

    <tr class="trhead">
        <td class="yellow">Ports Served By The Vessels</td>
        <td class="yellow">المرافىء التي تقصدها البواخر</td>
    </tr>

    <?php
    foreach($ports as $port) {
        echo '<tr><td>'.$port->name_en.'</td><td style="text-align:right; ">'.$port->name_ar.'</td></tr>';

    } ?>


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
        <td class="yellow">E Location Decimal:</td>
        <td class="data-box english"><?= $query['y_location']; ?></td>
    </tr>
</table>


