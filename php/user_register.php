<?php
$city_array= array('Mumbai'=>'Mumbai','Chennai'=>'Chennai','Delhi'=>'Delhi','Bangalore'=>'Bangalore','Hyderabad'=>'Hyderabad','Ahmedabad'=>'Ahmedabad','Kolkata'=>'Kolkata','Pune'=>'Pune','California'=>'California','Chicago'=>'Chicago','London'=>'London','Manchester'=>'Manchester');
if(isset($_GET['id']))
{
    require_once('function_list.php');
    $list=new My_List();
    $outer_array=$list->display_Old_Data($_GET['id']);   
    $record = $outer_array[0];
    $list_lang=explode(",",$record['user_lang']);
    // echo $record['user_img'];
    echo "<div>     
     <img src='".$record['user_img']."' height='100' width='100' STYLE='position:absolute; TOP:35px; LEFT:1000px;'>
     </div>";
    // print_r($record);
}
?>


<!DOCTYPE html>
<html>
<head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"></link>
<!-- <script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script> -->
<!-- <script src="https://code.jquery.com/jquery-1.12.4.js">
</script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js">
</script> -->
<style type="text/css">
    #message {
            color: #4F8A10;
            background-color: #DFF2BF;
        }
</style>
</head>
<body>
    <div class="wrap">   
        <div class="container" >
            
                <form class="form-horizontal" id="my_form_id" action="<?php get_permalink();?>" role="form" method="post">
                    <?php 
                            if(isset($_GET['id']))
                            {
                                echo "
                                    <center><h2 >Update Page</h2></center>
                                ";
                            }
                            else
                            {
                                echo "
                                    <h2 align=center>ADD Page</h2>
                                ";
                            }
                    ?>                  
                    <div  class="form-group">
                        <label  for="firstName" class="col-sm-3 control-label">First Name</label>
                        <div class="col-sm-6">
                            <input type="text" id="firstName" name="FirstName" placeholder="First Name" class="form-control" value="<?php echo $record['FirstName'];  ?>" autofocus>
                            <!-- <span class="help-block">Last Name, First Name, eg.: Smith, Harry</span> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lastName" class="col-sm-3 control-label">Last Name</label>
                        <div class="col-sm-6">
                            <input type="text" id="lastName" name="LastName" placeholder="Last Name" class="form-control" value="<?php if(isset($_GET['id'])){echo $record['LastName'];} ?>" autofocus>
                            <!-- <span class="help-block">Last Name, First Name, eg.: Smith, Harry</span> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user_no" class="col-sm-3 control-label">User No</label>
                        <div class="col-sm-6">
                            <input type="number" id="user_no" name="user_no" placeholder="user no" class="form-control" value="<?php if(isset($_GET['id'])){echo $record['user_no'];} ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="city" class="col-sm-3 control-label">City</label>
                        <div class="col-sm-6">
                            <select name="user_city" value="<?php if(isset($_GET['id'])){echo $record['user_city'];} echo $user_city;  ?>" id="city" class="form-control">  
                                <option style="display:none" > <?php if(isset($_GET['id'])){echo $record['user_city'];}  ?></option>
                              <?php
                                foreach($city_array as $key => $value):
                                echo '<option value="'.$key.'">'.$value.'</option>'; //close your tags!!
                                endforeach;
                              ?>
                            </select>
                        </div>
                    </div> <!-- /.form-group -->
                    <div class="form-group">
                        <label for="dob" class="col-sm-3 control-label">Date of Brith</label>
                        <div class="col-sm-6">
                            <input type="text" id="dob" name="user_dob" placeholder="Brith Date" class="form-control" value="<?php if(isset($_GET['id'])){echo $record['user_dob']; } ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mobile" class="col-sm-3 control-label">Mobile No</label>
                        <div class="col-sm-6">
                            <input type="text" id="mobile" name="user_mobile_no" placeholder="Mobile No" class="form-control" value="<?php if(isset($_GET['id'])){ echo $record['user_mobile_no'];} ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-6">
                            <input type="email" id="email" name="user_email" placeholder="Email" class="form-control" value="<?php if(isset($_GET['id'])) {echo $record['user_email'];} ?>" >
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <label class="control-label col-sm-3">Gender</label>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="radio-inline">
                                        <input type="radio" id="femaleRadio" name="user_gender" value="Female" <?php if(isset($_GET['id'])){echo ($record['user_gender']=='Female')?'checked':'';} ?> >Female
                                    </label>
                                </div>
                                <div class="col-sm-4">
                                    <label class="radio-inline">
                                        <input type="radio" id="maleRadio" name="user_gender" value="Male" checked <?php if(isset($_GET['id'])){echo ($record['user_gender']=='Male')?'checked':'';}?> >Male
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div> <!-- /.form-group -->
                    <div class="form-group">
                        <label class="control-label col-sm-3">Select Language</label>
                        <div class="col-sm-6">
                            <div class="checkbox">
                                <label>
                                    <input <?php if(isset($list_lang) && in_array("English",$list_lang) && isset($_GET['id'])){echo "checked";} ?> type="checkbox" name="user_lang[]" id="English" value='English'>English
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
                        </div>
                    </div> <!-- /.form-group -->
                    <div class="form-group">
                        <label for="image" class="col-sm-3 control-label">Select Image</label>
                        <div class="col-sm-6">
                            <input type="hidden" id="image" placeholder="image" name="user_img" onchange="preview_image(event)" class="form-control" value="<?php if(isset($_GET['id'])) {echo $record['user_img'];} ?>">
                            <input id="upload-button" type="button" class="button"  value="Upload Image" />
                            <img id="output_image" width="200" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6">        
                        </div>
                      </div >
                    <div class="form-group">
                        <div class="col-sm-6 col-sm-offset-3">
                            <?php 
                            if(isset($_GET['id']))
                            {
                                echo "
                                    <button  type='submit'  name='update-form' id='user_add'  onclick='submitForm()'  class='btn btn-primary btn-block'>Update</button>
                                ";
                            }
                            else
                            {
                                echo"<button  type='submit'  name='submit-form' id='submit_form'  onclick='submitForm()' class='btn btn-primary btn-block'>Register</button>";
                            }
                            ?>
                        </div>
                    </div>
                    
                </form> <!-- /form -->
                <div id="message" ></div>
        </div> <!-- ./container -->
    </div>
</body>
</html>



<?php
 if(isset($_POST['submit-form']))
{
    // $a=implode(',',$_POST['user_lang']);
    // $language=array("user_lang"=>"$a");
    // $insert_var=array_merge($_POST,$language);
    // unset($insert_var['submit-form']);
    // // print_r($insert_var);
    // global $wpdb;
    // $table = $wpdb->prefix.'manage_list';
    // $insert=$wpdb->insert($table,$insert_var);
    // if($insert)
    // {
    //     echo"<div class='alert alert-success'>The user data is Added to the List Successfully</div>";
    // }
    // else
    // {
    //     //echo"error";
    // }
}

// if(isset($_POST['update-form']))
// {
//     if($_POST['user_img']=='')
//     {
//         $_POST['user_img']= $record['user_img'];
//     }
//     $a=implode(',',$_POST['user_lang']);
//     $language=array("user_lang"=>"$a");
//     $insert_var=array_merge($_POST,$language);
//     unset($insert_var['update-form']);
//     // print_r($insert_var);
//     global $wpdb;
//     $table = $wpdb->prefix.'manage_list';
//     $where=array("user_no"=>$insert_var['user_no']);
//     $insert=$wpdb->update($table,$insert_var,$where);
//     if($insert)
//     {
        
//         echo"<div class='alert alert-success'>The User Data Successfully Updated!</div>";
//     }
//     else
//     {
//         echo"error";
//     }
// }
?>


