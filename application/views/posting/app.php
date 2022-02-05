<!DOCTYPE html>
<head>
  <link href='http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
  <link href='//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css' rel='stylesheet' type='text/css'>
  <link href='//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/1.8/css/bootstrap-switch.css' rel='stylesheet' type='text/css'>
  <link href='http://davidstutz.github.io/bootstrap-multiselect/css/bootstrap-multiselect.css' rel='stylesheet' type='text/css'>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=$title?></title>
</head>
<body>

<?php
/********************General Info**********************/
$array_ref=array('id'=>'ref','name'=>'ref','value'=>@$ref);
$array_name_ar=array('id'=>'name_ar','name'=>'name_ar','value'=>$query['name_ar'],'required'=>'required');
$array_name_en=array('id'=>'name_en','name'=>'name_en','value'=>$query['name_en'],'required'=>'required');

$array_owner_name=array('id'=>'owner_name','name'=>'owner_name','value'=>$query['owner_name']);
$array_owner_name_en=array('id'=>'owner_name_en','name'=>'owner_name_en','value'=>$query['owner_name_en']);

$array_auth_person_ar=array('id'=>'auth_person_ar','name'=>'auth_person_ar','value'=>$query['auth_person_ar']);
$array_auth_person_en=array('id'=>'auth_person_en','name'=>'auth_person_en','value'=>$query['auth_person_en']);

$array_auth_no =array('id'=>'auth_no','name'=>'auth_no','value'=>$query['auth_no']);

$array_activity_ar=array('id'=>'activity_ar','name'=>'activity_ar','value'=>$query['activity_ar']);
$array_activity_en=array('id'=>'activity_en','name'=>'activity_en','value'=>$query['activity_en']);
$array_establish_date=array('id'=>'establish_date','name'=>'establish_date','value'=>$query['establish_date']);

$array_personal_notes=array('id'=>'personal_notes','name'=>'personal_notes','value'=>$query['personal_notes'],'style'=>'height:250px !important');

/*********************Address*************************/
$array_street_ar=array('id'=>'street_ar','name'=>'street_ar','value'=>$query['street_ar']);
$array_street_en=array('id'=>'street_en','name'=>'street_en','value'=>$query['street_en']);

$array_bldg_ar=array('id'=>'bldg_ar','name'=>'bldg_ar','value'=>$query['bldg_ar']);
$array_bldg_en=array('id'=>'bldg_en','name'=>'bldg_en','value'=>$query['bldg_en']);

$array_fax=array('id'=>'fax','name'=>'fax','value'=>$query['fax']);
$array_phone=array('id'=>'phone','name'=>'phone','value'=>$query['phone']);

$array_pobox_ar=array('id'=>'pobox_ar','name'=>'pobox_ar','value'=>$query['pobox_ar'],'style'=>'direction:rtl !important');
$array_pobox_en=array('id'=>'pobox_en','name'=>'pobox_en','value'=>$query['pobox_en']);

$array_email=array('id'=>'email','name'=>'email','value'=>$query['email']);
$array_website=array('id'=>'website','name'=>'website','value'=>$query['website']);
$array_x_location=array('id'=>'x_location','name'=>'x_location','value'=>$query['x_location']);
$array_y_location=array('id'=>'y_location','name'=>'y_location','value'=>$query['y_location']);

/*********************Molhak*************************/
$array_rep_person_ar=array('id'=>'rep_person_ar','name'=>'rep_person_ar','value'=>$query['rep_person_ar']);
$array_rep_person_en=array('id'=>'rep_person_en','name'=>'rep_person_en','value'=>$query['rep_person_en']);

$array_app_fill_date=array('id'=>'app_fill_date','name'=>'app_fill_date','value'=>$query['app_fill_date']);
$array_adv_pic=array('id'=>'adv_pic','name'=>'adv_pic','value'=>$query['adv_pic']);

?>

<?php
$jsgov='id="gov_id" onchange="getdistricts(this.value)" class="select2" required="required"';
$jsdis='id="district_id" onchange="getarea(this.value)" class="select2" required="required"';
?>

  <div class='container'>
    <div class='panel panel-primary dialog-panel'>
      <div class='panel-heading'>
        <h5>Almaguin Campground - Reservation</h5>
      </div>
      <div class='panel-body'>
      <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation','class'=>'form-horizontal'));
          echo form_hidden('c_id',$query['id']);
		 // echo form_hidden('adv_pic',$adv_pic);
		   ?>             
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_title'>* : اسم المؤسسة</label>
            <div class='col-md-8'>
              <div class='col-md-3 indent-small'>
                <div class='form-group internal'>
                  <input class='form-control' id='id_first_name' placeholder='First Name' type='text'>
                </div>
              </div>
              <div class='col-md-3 indent-small'>
                <div class='form-group internal'>
                  <input class='form-control' id='id_last_name' placeholder='Last Name' type='text'>
                </div>
              </div>
            </div>
          </div>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_adults'>Guests</label>
            <div class='col-md-8'>
              <div class='col-md-2'>
                <div class='form-group internal'>
                  <input class='form-control col-md-8' id='id_adults' placeholder='18+ years' type='number'>
                </div>
              </div>
              <div class='col-md-3 indent-small'>
                <div class='form-group internal'>
                  <input class='form-control' id='id_children' placeholder='2-17 years' type='number'>
                </div>
              </div>
              <div class='col-md-3 indent-small'>
                <div class='form-group internal'>
                  <input class='form-control' id='id_children_free' placeholder='&lt; 2 years' type='number'>
                </div>
              </div>
            </div>
          </div>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_email'>Contact</label>
            <div class='col-md-6'>
              <div class='form-group'>
                <div class='col-md-11'>
                  <input class='form-control' id='id_email' placeholder='E-mail' type='text'>
                </div>
              </div>
              <div class='form-group internal'>
                <div class='col-md-11'>
                  <input class='form-control' id='id_phone' placeholder='Phone: (xxx) - xxx xxxx' type='text'>
                </div>
              </div>
            </div>
          </div>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_checkin'>Checkin</label>
            <div class='col-md-8'>
              <div class='col-md-3'>
                <div class='form-group internal input-group'>
                  <input class='form-control datepicker' id='id_checkin'>
                  <span class='input-group-addon'>
                    <i class='glyphicon glyphicon-calendar'></i>
                  </span>
                </div>
              </div>
              <label class='control-label col-md-2' for='id_checkout'>Checkout</label>
              <div class='col-md-3'>
                <div class='form-group internal input-group'>
                  <input class='form-control datepicker' id='id_checkout'>
                  <span class='input-group-addon'>
                    <i class='glyphicon glyphicon-calendar'></i>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_equipment'>Equipment type</label>
            <div class='col-md-8'>
              <div class='col-md-3'>
                <div class='form-group internal'>
                  <select class='form-control' id='id_equipment'>
                    <option>Travel trailer</option>
                    <option>Fifth wheel</option>
                    <option>RV/Motorhome</option>
                    <option>Tent trailer</option>
                    <option>Pickup camper</option>
                    <option>Camper van</option>
                  </select>
                </div>
              </div>
              <div class='col-md-9'>
                <div class='form-group internal'>
                  <label class='control-label col-md-3' for='id_slide'>Slide-outs</label>
                  <div class='make-switch' data-off-label='NO' data-on-label='YES' id='id_slide_switch'>
                    <input id='id_slide' type='checkbox' value='chk_hydro'>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_service'>Required Service</label>
            <div class='col-md-8'>
              <select class='multiselect' id='id_service' multiple='multiple'>
                <option value='hydro'>Hydro</option>
                <option value='water'>Water</option>
                <option value='sewer'>Sewer</option>
              </select>
            </div>
          </div>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_pets'>Pets</label>
            <div class='col-md-8'>
              <div class='make-switch' data-off-label='NO' data-on-label='YES' id='id_pets_switch'>
                <input id='id_pets' type='checkbox' value='chk_hydro'>
              </div>
            </div>
          </div>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_comments'>Comments</label>
            <div class='col-md-6'>
              <textarea class='form-control' id='id_comments' placeholder='Additional comments' rows='3'></textarea>
            </div>
          </div>
          <div class='form-group'>
            <div class='col-md-offset-4 col-md-3'>
              <button class='btn-lg btn-primary' type='submit'>Request Reservation</button>
            </div>
            <div class='col-md-3'>
              <button class='btn-lg btn-danger' style='float:right' type='submit'>Cancel</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>