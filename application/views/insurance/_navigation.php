<script>

    function upload()
    {
        document.getElementById("validation").action = "<?=base_url().'insurances/editimage'?>";
        document.getElementById("validation").submit();
    }

</script>
<div class="span3">
    <div class="head clearfix">
        <div class="isw-ok"></div>
        <h1>Insurance Navigation</h1>
    </div>
    <div class="block-fluid">
        <ul class="sList">
            <?php
            if($p_edit) {
                echo '<li>'.anchor('insurances/edit/'.$id, '<span class="isb-edit"></span>Edit').'</li>';
            }

            echo '<li>'.anchor('insurances/view/'.$id, '<span class="isb-print"></span> Print', array('target' => '_blank')).'</li>';
            if($p_executive) {
                echo '<li>'.anchor('insurances/executive/'.$id, '<span class="isb-users"></span>General Management - الادارة العامة').'</li>';
            }
            if($p_directors) {
                echo '<li>'.anchor('insurances/directors/'.$id, '<span class="isb-users"></span>Board of Directors - مجلس الادارة').'</li>';
            }
            if($p_branches) {
                echo '<li>'.anchor('insurances/branches/'.$id, '<span class="isb-bookmark"></span>Branches - الفروع').'</li>';
            }
            //if(@$p_app){
            echo '<li>'.anchor('insurances/export/'.$id,'<span class="isb-grid"></span>Export Applications To Excel').'</li>';
            //}
            if($p_delete) {
                echo '<li>'.anchor('insurances/delete/id/'.$id.'/p/insurance', '<span class="isb-delete"></span> Delete', 'onclick="return confirmation(\'Are You sure you banks to delete this Istimara\');"').'</li>';
            }
            if($p_branches_add) {
                echo '<li>'.anchor('insurances/branch-create/'.$id, '<span class="isb-plus"></span>Add Branches - اضافة  فرع').'</li>';
            }
            /*
              //echo '<li>'.anchor('insurances/remove/'.$id,'<span class="isb-delete"></span> Remove Advertisment Image','onclick="return confirmation(\'Are You sure you want to delete this Image\');"').'</li>';
              /*
              ?>
              <li>Edit Advertisment Image
              <?php echo form_hidden('editimageid',$id);?>
              <input type="file" name="adimage" />
              <center> <input type="button" onclick="upload()" value="Upload" class="btn" /></center>
              </li>
             */
            ?>
        </ul>
    </div>
</div>
