<!DOCTYPE html>
<html>
<head>
   
</head>
<body>
    <div class="wrap">
  <h2>Applications List</h2>
  <table class="widefat" class="form-table" id="joblist" cellspacing="0"><thead><tr>

        <th id="columnname" class="manage-column column-columnname" scope="col"><strong>Application Title</strong>
        <th id="columnname" class="manage-column column-columnname" scope="col"><strong>Name</strong>
        <th id="columnname" class="manage-column column-columnname" scope="col" style="display:none;"><strong>Email</strong>
        <th id="columnname" class="manage-column column-columnname" scope="col" style="display:none;"><strong>Mobile Number</strong>
        <th id="columnname" class="manage-column column-columnname" scope="col" ><strong>Education</strong>
        <th id="columnname" class="manage-column column-columnname" scope="col" style="display:none;"><strong>Experience</strong>
        <th id="columnname" class="manage-column column-columnname" scope="col" style="display:none;"><strong>Source</strong>
        <th id="columnname" class="manage-column column-columnname" scope="col" style="display:none;"><strong>LinkedinUrl</strong>
        <th id="columnname" class="manage-column column-columnname" scope="col" style="display:none;"><strong>Cover Letter</strong>
        <th id="columnname" class="manage-column column-columnname" scope="col" style="display:none;"><strong>Status</strong>
        <th id="columnname" class="manage-column column-columnname" scope="col"><strong>Resume</strong>
        <th id="columnname" class="manage-column column-columnname" scope="col"><strong>Action</strong>
      </tr>
    </thead><tbody>
          <tr class='alternate' valign='top'>
            <div  class="form-group">
              <label  for="firstName" class="col-sm-3 control-label">First Name</label>
              <div class="col-sm-6">
                  <input type="text" id="firstName" name="FirstName" placeholder="First Name" class="form-control" value="<?php echo $record['FirstName'];  ?>" autofocus>
                  <!-- <span class="help-block">Last Name, First Name, eg.: Smith, Harry</span> -->
              </div>
            </div>
            <td class='column-columnname'>
              <?php echo wordwrap(stripslashes($application_title), 40, "<br>\n", true); ?>
            </td>
            <td class='column-columnname'>
              <?php echo $application_name; ?>
            </td>
            <td class='column-columnname' style="display:none;">
              <?php echo $val->application_email; ?>
            </td>
            <td><a href="admin.php?page=application_add&act=upd&application_id=<?php echo $application_id; ?>">Edit</a>&nbsp;&nbsp;<a href="admin.php?page=myplug/fhg-application-plugin.php&info=del&did=<?php echo $application_id; ?>" onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>       
          </tr>
    </tbody>
    <tfoot>
    <br/>
    </tfoot>
  </table>
</div>
</body>
</html>


 <div class="form-group">
    <label for="image" class="col-sm-3 control-label">Select Image</label>
    <div class="col-sm-6">
        <input type="hidden" id="image" placeholder="image" name="user_img" onchange="preview_image(event)" class="form-control" value="<?php if(isset($_GET['id'])) {echo $record['user_img'];} ?>">
        <input id="upload-button" type="button" class="button"  value="Upload Image" />
        <img id="output_image" width="200" />
    </div>
</div>
<!DOCTYPE html>
<html>
<head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"></link>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js">
</script>
</head>
<body>
    <div class="wrap">
        <h1 class="wp-heading-inline">Add User</h1>
        <hr class="wp-header-end">
        <form id="my_form_id" role="form" method="post">
            <table class="form-table">
                <tbody>

                    <tr class="user-first-name-wrap">
                        <th><label for="first_name">First Name</label></th>
                        <td><input type="text" id="firstName" name="FirstName" placeholder="First Name"  value="<?php echo $record['FirstName'];  ?>" autofocus></td>
                    </tr>

                    <tr class="user-last-name-wrap">
                        <th><label for="last_name">Last Name</label></th>
                        <td><input type="text" id="lastName" name="LastName" placeholder="Last Name"  value="<?php if(isset($_GET['id'])){echo $record['LastName'];} ?>" autofocus></td>
                    </tr>

                    <tr class="user-nickname-wrap">
                        <th><label for="nickname">User No</label></th>
                        <td><input type="number" id="user_no" name="user_no" placeholder="user no"  value="<?php if(isset($_GET['id'])){echo $record['user_no'];} ?>"></td>
                    </tr>
                    <tr >
                        <th><label for="user_login">City</label></th>
                        <td>
                            <select name="user_city" value="<?php if(isset($_GET['id'])){echo $record['user_city'];} echo $user_city;  ?>" id="city" >  
                                <option style="display:none" > <?php if(isset($_GET['id'])){echo $record['user_city'];}  ?></option>
                              <?php
                                foreach($city_array as $key => $value):
                                echo '<option value="'.$key.'">'.$value.'</option>'; //close your tags!!
                                endforeach;
                              ?>
                            </select>
                        </td>
                    </tr>
                    <tr >
                        <th><label for="user_login">Date of Brith</label></th>
                        <td><input type="date" id="dob" name="user_dob" placeholder="Brith Date" min ="1965-12-31" max="1998-12-31" value="<?php if(isset($_GET['id'])){echo $record['user_dob']; } ?>"></td>
                    </tr>
                    <tr >
                        <th><label for="user_login">Mobile No</label></th>
                        <td><input type="text" id="mobile" name="user_mobile_no" placeholder="Mobile No"  value="<?php if(isset($_GET['id'])){ echo $record['user_mobile_no'];} ?>"></td>
                    </tr>
                    <tr >
                        <th><label for="user_login">Email</label></th>
                        <td><input type="email" id="email" name="user_email" placeholder="Email"  value="<?php if(isset($_GET['id'])) {echo $record['user_email'];} ?>" ></td>
                    </tr>
                    <tr >
                        <th><label for="user_login">Gender</label></th>
                        <td>
                            <div>
                                <label >
                                    <input type="radio" id="femaleRadio" name="user_gender" value="Female" <?php if(isset($_GET['id'])){echo ($record['user_gender']=='Female')?'checked':'';} ?> >Female
                                </label>
                            </div>
                            <div >
                                <label >
                                    <input type="radio" id="maleRadio" name="user_gender" value="Male" checked <?php if(isset($_GET['id'])){echo ($record['user_gender']=='Male')?'checked':'';}?> >Male
                                </label>
                            </div>
                        </td>
                        <!-- <td>
                            <div >
                                <label >
                                    <input type="radio" id="maleRadio" name="user_gender" value="Male" checked <?php if(isset($_GET['id'])){echo ($record['user_gender']=='Male')?'checked':'';}?> >Male
                                </label>
                            </div>
                        </td> -->
                    </tr>
                    <tr >
                        <th><label for="user_login">Select Language</label></th>
                        <td>
                            <div class="checkbox">
                                <label>
                                    <input <?php if(isset($list_lang) && in_array("English",$list_lang) && isset($_GET['id'])){echo "checked";}?> type="checkbox" name="user_lang[]" id="English" value='English'>English
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input <?php if(isset($list_lang) && in_array("Hindi",$list_lang)&& isset($_GET['id'])){echo "checked";}?> type="checkbox" name="user_lang[]" id="Hindi" value='Hindi'>Hindi
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input <?php if(isset($list_lang) && in_array("Urdu",$list_lang)&& isset($_GET['id'])){echo "checked";}?> type="checkbox" name="user_lang[]" id="Urdu" value='Urdu'>Urdu
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input <?php if(isset($list_lang) && in_array("Marathi",$list_lang)&& isset($_GET['id'])){echo "checked";}?> type="checkbox" name="user_lang[]" id="Marathi" value='Marathi'>Marathi
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr >
                        <th><label for="image" >Select Image</label></th>
                        <td>
                            <div class="form-group">
                                <div >
                                <input type="hidden" id="image" placeholder="image" name="user_img" onchange="preview_image(event)" class="form-control" value="<?php if(isset($_GET['id'])) {echo $record['user_img'];} ?>">
                                <input id="upload-button" type="button" class="button"  value="Upload Image" />
                                <img id="output_image" width="200" />
                            </div>
                            <div class="form-group">
                        </td>
                    </tr>
                    <tr >
                        <th><label for="description">Biographical Info</label></th>
                        
                        <td>
                            <?php 
                                wp_nonce_field('nates_nonce_action', 'nates_nonce_field');
                                $content = get_option('special_content');
                                $setting=array('textarea_rows'    => get_option( 'default_post_edit_rows', 4),
                                    'drag_drop_upload' => true);
                                wp_editor( $content, 'special_content',$setting);             
                                
                            ?>
                        <p class="description">Share a little biographical information to fill out your profile. This may be shown publicly.</p></td>
                    </tr>
                     <tr >
                        <td>
                            <div>
                            <?php 
                            if(isset($_GET['id']))
                            {
                                echo "
                                    <input type='submit' name='update-form' id='submit-form' class='button button-primary' value='Save' onclick='updateForm()'> ";
                                
                            }
                            else
                            {
                                 echo "
                                    <input type='submit' name='submit-form' id='submit-form' class='button button-primary' value='Save' onclick='submitForm()'> ";
                            }
                            ?>
                        </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</body>
</html>

