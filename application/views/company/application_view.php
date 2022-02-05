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
        <td class="yellow"> وزارة ID</td>
        <td><?= $query['ministry_id']; ?>&nbsp;</td>
    </tr>
    <tr>
        <td class="yellow">رقم الاستمارة</td>
        <td><?= $query['id']; ?>&nbsp;</td>
    </tr>
    <tr>
        <td class="yellow">Company Name</td>
        <td><?= $query['name_en']; ?>&nbsp;</td>
    </tr>
    <tr>
        <td class="yellow"> اسم المؤسسة</td>
        <td><?= $query['name_ar']; ?>&nbsp;</td>
    </tr>
    <tr>
        <td class="yellow">Owner / Owners of The Co.</td>
        <td><?= $query['owner_name_en']; ?>&nbsp;</td>
    </tr>
    <tr>
        <td class="yellow"> صاحب / اصحاب الشركة </td>
        <td><?= $query['owner_name']; ?>&nbsp;</td>
    </tr>
    <tr>

        <td  class="yellow">Name of The Authorized to Sign :</td>
        <td class="data-box english"><?= $query['auth_person_en']; ?>&nbsp;</td>
    </tr>
    <tr>
        <td  class="yellow"> اسم المفوض بالتوقيع :</td>
        <td class="data-box arabic"><?= $query['auth_person_ar']; ?>&nbsp;</td>
    </tr>
    <?php
    if (count(@$license) > 0) {
        $license_en = $license['label_en'];
        $license_ar = $license['label_ar'];
    } else {
        $license_en = '';
        $license_ar = '';
    }
    ?>
    <tr>
        <td  class="yellow">No. & Place of C.R :</td>
        <td class="data-box english"><?= $query['auth_no'] . ' ' . $license_en; ?>&nbsp;</td>
    </tr>
    <tr>
        <td  class="yellow"> رقم ومحل اصدار السجل التجاري:</td>
        <td class="data-box arabic"><?= $query['auth_no'] . ' ' . $license_ar; ?>&nbsp;</td>
    </tr>
    <tr>
        <td  class="yellow">Activity :</td>
        <td class="data-box english"><?= $query['activity_en']; ?>&nbsp;</td>
    </tr>
    <tr>
        <td  class="yellow"> نوع النشاط:</td>
        <td class="data-box arabic"><?= $query['activity_ar']; ?>&nbsp;</td>
    </tr>
    <tr>
        <td class="yellow"> مصدر الرخصة</td>
        <td><?php echo (@$query['wezara_source'] == 1) ? 'وزارة الصناعة' : ''; ?></td>
    </tr>
    <tr>
        <td class="yellow">غير ذلك / حدد</td>
        <td><?= $query['other_source']; ?></td>
    </tr>
    <tr>
        <td  class="yellow">رقم الرخصة :</td>
        <td class="data-box arabic"><?= $query['nbr_source']; ?></td>
    </tr>
    <tr>
        <td  class="yellow"> التاريخ :</td>
        <td class="data-box arabic"><?= $query['date_source']; ?></td>
    </tr>

    <tr>
        <td  class="yellow"> الفئة :</td>
        <td class="data-box arabic"><?= $query['type_source']; ?></td>
    </tr>
    <tr>
            <td  class="yellow">Company Type : </td>
        <td><?=$query['type_en']?></td>
    </tr>
    <tr>
            <td  class="yellow">نوع الشركة : </td>
        <td><?=$query['type_ar']?></td>
    </tr>
    <tr>
        <td  class="yellow">  جمعية الصناعيين اللبنانيين  : </td>
            <td class="data-box arabic"><?php
                if($query['ind_association'] == 1)
                    echo 'نعم';
                else
                    echo 'كلا';
                ?></td>
    </tr>

    <tr>
        <?php
        if(count($industrial_room) > 0) {
            $industrial_room_en = $industrial_room['label_en'];
            $industrial_room_ar = $industrial_room['label_ar'];
        }
        else {
            $industrial_room_en = '';
            $industrial_room_ar = '';
        }
        ?>
            <td  class="yellow">غرفة التجارة والصناعة في</td>
            <td class="data-box arabic"><?=$industrial_room_ar;?></td>
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
            <td  class="yellow">Assemblies of Economical, Technical - Specify : </td>
            <td class="data-box english"><?=$economical_assembly_en;?></td>
    </tr>
    <tr>
            <td  class="yellow">  اتحادات مهنية اقليمية  - حدد:  </td>
            <td class="data-box arabic"><?=$economical_assembly_ar;?></td>

    </tr>

    <tr>
            <td  class="yellow">  تجمع صناعي  :  </td>
            <td class="data-box arabic"><?=$industrial_group_ar;?></td>
    </tr>
    <tr class="trhead">
        <td class="thead">Head Office Address : </td>
        <td class="thead">

            عنوان المركز الرئيسي  :
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
            <td  class="yellow">Mohafaza : </td>
            <td class="data-box english"><?=$gov_en;?></td>
    </tr>
    <tr>
            <td  class="yellow">  المحافظة : </td>
            <td class="data-box arabic"><?=$gov_ar;?></td>
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
            <td  class="yellow">Kazaa : </td>
            <td class="data-box english"><?=$district_en;?></td>
    </tr>
    <tr>
            <td  class="yellow">  القضاء : </td>
            <td class="data-box arabic"><?=$district_ar;?></td>
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
            <td  class="yellow">City : </td>
            <td class="data-box english"><?=$area_en;?></td>
    </tr>
    <tr>
            <td  class="yellow">   البلدة او المحلة : </td>
            <td class="data-box arabic"><?=$area_ar;?></td>
    </tr>

    <tr>
            <td  class="yellow">Street : </td>
            <td class="data-box english"><?=$query['street_en'];?></td>
    </tr>
    <tr>
            <td  class="yellow">  الشارع : </td>
            <td class="data-box arabic"><?=$query['street_ar'];?></td>
    </tr>
    <tr>
            <td  class="yellow">Bldg : </td>
            <td class="data-box english"><?=$query['bldg_en'];?></td>
    </tr>
    <tr>
            <td  class="yellow">  البناية : </td>
            <td class="data-box arabic"><?=$query['bldg_ar'];?></td>
    </tr>
    <tr>
            <td  class="yellow">  هاتف: </td>
            <td class="data-box arabic"><?=$query['phone'];?></td>
    </tr>
    <tr>
            <td  class="yellow">  فاكس: </td>
            <td class="data-box arabic"><?=$query['fax'];?></td>
    </tr>
    <tr>
            <td  class="yellow">P.O.Box : </td>
            <td class="data-box english"><?=$query['pobox_en'];?></td>
    </tr>
    <tr>
            <td  class="yellow">  ص. بريد : </td>
            <td class="data-box arabic"><?=$query['pobox_ar'];?></td>
    </tr>
    <tr>
        <td  class="yellow"> البريد الالكتروني : </td>
            <td class="data-box english"><?=$query['email'];?></td>

    </tr>
    <tr>
        <td  class="yellow" >  الموقع الالكتروني: </td>
        <td class="data-box english"><?=$query['website'];?></td>
    </tr>
    <tr>
            <td  class="yellow">N Location Decimal: </td>
            <td class="data-box english"><?=$query['x_decimal'];?></td>
    </tr>
    <tr>
            <td  class="yellow"">E Location Decimal: </td>
            <td class="data-box english"><?=$query['y_decimal'];?></td>
    </tr>
    <tr class="trhead">
            <td colspan="2" class="thead arabic">معلومات عن الانتاج  : </td>
    </tr>
    <tr>
        <td>HS Code</td>
        <td>الوصف الخاص</td>
    </tr>
    <?php if(count($items)) {
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
                <td><?=$item->hscodeprint?></td>
                <td>
                    <table>
                        <td><?=$heading_comp_ar?></td>
                        <td> <?=$heading_comp_en?></td>
                    </table>
                </td>
            </tr>
<?php
        }
    }
    ?>
    <tr >
            <td class="yellow">   اسواق البيع والتصدير: </td>
        <td>
            <?php
            if(count($markets)) {
            foreach($markets as $item) {
            if($item->item_type == 'country') {
                $row = $this->Parameter->GetCountryById($item->market_id);
                $label_en = $row['label_en'];
                $label_ar = $row['label_ar'];
            }
            elseif($item->item_type == 'region') {
                $row = $this->Parameter->GetCompanyMarketById($item->market_id);
                $label_en = $row['label_en'];
                $label_ar = $row['label_ar'];
            }
            echo $label_ar.' , ';

}
}
?>
        </td>
    </tr>
    <tr >
            <td class="yellow">  طريقة التصدير : </td>
        <td>
            <?php
            if(@$query['is_exporter'] == 0) {
               echo 'غير مصدر';

            }
            elseif(@$query['is_exporter'] == 1) {
                echo 'مباشر';

            }
            elseif(@$query['is_exporter'] == 2) {
               echo 'بالواسطة';
            }
            ?>
        </td>
    </tr>
    <tr >
            <td class="yellow">  عدد العمال : </td>
        <td></td>
    </tr>
    <tr>
            <td class="yellow">التأمين : </td>
        <td><?php
            if(count($insurances) > 0) {
                foreach($insurances as $insurance) {
                    echo $insurance->insurance_ar.' , ';
                }
            }
            ?></td>
    </tr>
    <tr>
            <td class="yellow">المصارف المعتمدة : </td>
        <td><?php
            if(count($banks)) {
                foreach($banks as $bank) {
                    echo $bank->bank_ar.' , ';
                }
            }
            ?></td>
    </tr>
    <tr >
            <td class="yellow">استعمال الطاقة : </td>
        <td></td>
    </tr>
</table>


