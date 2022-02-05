<div class="block users scrollBox">

    <div class="scroll" style="height: 300px;">
        <?php foreach($country_visitors as $country_visitor) {?>
            <div class="item clearfix">
                <div class="image"><a href="#"><img src="<?=base_url()?>flags/<?=$country_visitor->country_code?>.png" width="32"/></a></div>
                <div class="info">
                    <a href="#" class="name"><?=$country_visitor->country?></a>
                    <a href="#" class="name" style="float:right !important"><?=$country_visitor->Views?></a>
                </div>
            </div>
        <?php }?>
    </div>

</div>