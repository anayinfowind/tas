<?php
echo "sasasasa"; die;


define('NO_OUTPUT_BUFFERING', true);

require(__DIR__ . '/../../../config.php');

require_once($CFG->libdir . '/adminlib.php');

require_login();

admin_externalpage_setup('toolleeloolxp_sync');

global $SESSION;

$postcourses = optional_param('course', null, PARAM_RAW);

$activity_set = optional_param('sync_activity_resouce', null, PARAM_RAW);

$msg = '';

//echo hash_internal_user_password($password);

// sync activity

$records = $DB->get_record('config_plugins', array("name" => 'teamnio_liacence'),'value');



    if($records) { 

      echo   $liacnse_key =  $records->value;  



    } else {
        return true;

    }



        //$not_login_message = "You are not login on tracker, please login.";



            



        $postData = '&license_key='.$liacnse_key;



        $ch = curl_init();  



        $url = 'https://leeloolxp.com/api_moodle.php/?action=page_info';



        curl_setopt($ch,CURLOPT_URL,$url);



        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);



        curl_setopt($ch,CURLOPT_HEADER, false); 



        curl_setopt($ch, CURLOPT_POST, count($postData));



        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);  

        $output=curl_exec($ch);



        curl_close($ch);



        $info_teamnio  = json_decode($output);



           



        if($info_teamnio->status!='false') {



            $teamnio_url = $info_teamnio->data->install_url;



        } else {



            echo "Teamnio url not found"; die;

            //$teamnio_url = 'https://leeloolxp.com/dev';



        }

if(isset($_REQUEST['resync_activity'])) {
    $activity_id=$_REQUEST['activity_id'];
    $activity_name=$_REQUEST['activity_name'];
            $post = [
                        'activity_id' => $activity_id,
                        'activity_name' => $activity_name
                    ];

            $ch = curl_init($teamnio_url.'/admin/sync_moodle_course/activity_sync');

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

            $response = curl_exec($ch);

            curl_close($ch);
            $msg = 'Resychronizationed successfully.';

}
if(isset($_REQUEST['resync'])) {
       echo  $course_id = $_REQUEST['courseid_resync'];
        die;
        $course_details = $DB->get_record('course', array('id' => $course_id)); // fetch all exist course from
        $course_name =  $course_details->fullname; 
        $table = 'course_sections'; // section table name.
        $sections = $DB->get_records($table, array('course' => $course_id)); // fetch sections of each course.
        $course = get_course($course_id);
        $modinfo = get_fast_modinfo($course);
        $arr_main = array(); 
        if (!empty($sections)) {
            foreach ($sections as $section_key => $sections_details) {
                if ($sections_details->name != '') {
                    $modules_course = $DB->get_records("course_modules", array('section' => $sections_details->id)); // fecth modules and instaced of modules 
                    if (!empty($modules_course)) {
                        foreach ($modules_course as $course_module_details) {
                            $module_id = $course_module_details->module;
                            $instance = $course_module_details->instance;
                            $modules = $DB->get_records("modules", array('id' => $module_id)); // fetch modules for real table name\
                            if (!empty($modules)) {
                                foreach ($modules as $key => $value) {
                                    $tbl = $value->name;
                                    $module_detail = $DB->get_records($tbl, array('id' => $instance)); // fetch activities and resources based on instance and module name table.
                                    if (!empty($module_detail)) {
                                        foreach ($module_detail as $key => $value_final) {
                                            $activity_ids = $DB->get_record('course_modules', array('instance' => $instance,'module'=>$module_id));  
                                            $already_enabled = $DB->get_record_sql( "SELECT id FROM {tool_leeloolxp_sync} where activityid = '$activity_ids->id' and enabled = '1'") ;
                                            $enabled = false;
                                            $enabled = true;
                                            $sections_details->name;
                                            $cm = $modinfo->cms[$activity_ids->id];
                                            $old_sections_name  =  $sections_details->name; 
                                            $arr_main[$activity_ids->id] = $value_final->name;  
                                        } // loop close for activity and resources
                                    }  // if close for module_detail
                                } //  loop close for  modules.
                            } // single module condition close
                        } // modules_course loop
                    } // modules_course  condition
                } // section name black if clsoe (codition)
            }
        }



            $post = [
                        'course_id' => $course_id,
                        'course_name' => $course_name,
                        'activity_array' => $arr_main
                    ];
           
            $ch = curl_init($teamnio_url.'/admin/sync_moodle_course/resync_course');

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

            $response = curl_exec($ch);

            curl_close($ch);
            $msg = 'Resychronizationed successfully.';

    }

if(isset($_REQUEST['unsync_id']) && !empty($_REQUEST['unsync_id']) ) {

    $activity_id_moodle_arr = $_REQUEST['unsync_id'];



    $activity_details_again = $DB->get_record('tool_leeloolxp_sync', array('activityid' => $activity_id_moodle_arr) ); // fetch all exist course from



    $task_id = $activity_details_again->teamnio_task_id; 

    

    $post = ['task_id' => $task_id];



    $ch = curl_init( $teamnio_url.'/admin/sync_moodle_course/unsyncactivity');



    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);



    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);



    $response = curl_exec($ch);

    curl_close($ch);

    $DB->execute("DELETE FROM {tool_leeloolxp_sync} where activityid = '$activity_id_moodle_arr'");

    $msg = 'Unsychronizationed successfully.';

    // need to do delete activity from teamnio 

}



if( isset($_REQUEST['id']) && !empty($_REQUEST['id']) ) { 

    $course_id = $_REQUEST['id'];

    $post = ['course_id' => $course_id];


    $ch = curl_init($teamnio_url.'/admin/sync_moodle_course/unsynccourse');

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

    $response = curl_exec($ch);

    curl_close($ch);

    $DB->execute("DELETE FROM {tool_leeloolxp_sync} where courseid = '$course_id'");



    $msg = 'Unsychronizationed successfully.';

}



if( isset($_REQUEST['course_id_date']) && !empty($_REQUEST['course_id_date']) ) {



    $course_id_again = $_REQUEST['course_id_date'];



    $course_details_again = $DB->get_record('course', array('id' => $course_id_again) ); // fetch all exist course from











            //foreach ($activity_set as $key => $value) {



            $post = [

                

                    'course_id' => $course_details_again->id,



                    'startdate' => $course_details_again->startdate,



                    'enddate' => $course_details_again->enddate,



                ];





                $ch = curl_init($teamnio_url.'/admin/sync_moodle_course/sync_date');

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

                $response = curl_exec($ch);

                curl_close($ch);

                $msg = 'Date Sychronizationed successfully.';

            }















if( isset($_REQUEST['sync_activities']) ) {

    $all_data  =  $_REQUEST['all_activities'];

    

    $i=0;

    $moodle_user_array = array();
    $moodle_user_student_array = array();
    $moodle_user_teacher_array = array();

    foreach ($all_data as $key => $value) {



        $activity_id_moodle_arr = array();



        $activity_set = str_replace("'", '', $value); 



        $activity_id_arr = explode('$$', $activity_set);



        $course_id_again =  $activity_id_arr[4];



        // enrolled users and sync with teamnio   //

        if($i=='0') { 

            $enrolled_user = $DB->get_records_sql("SELECT u.*, ue.id, e.courseid, ue.userid, e.enrol AS enrolmethod, FROM_UNIXTIME(ue.timecreated) FROM {user_enrolments} ue JOIN {enrol} e ON e.id = ue.enrolid AND e.status = 0 JOIN {user} u ON u.id = ue.userid AND u.deleted = 0 AND u.suspended = 0 Where e.courseid = '$course_id_again'");

            foreach ($enrolled_user as $key => $moodel_user_value) {

            $sql = "SELECT * FROM {role_assignments} AS ra LEFT JOIN {user_enrolments} AS ue ON ra.userid = ue.userid LEFT JOIN {role} AS r ON ra.roleid = r.id LEFT JOIN {context} AS c ON c.id = ra.contextid LEFT JOIN {enrol} AS e ON e.courseid = c.instanceid AND ue.enrolid = e.id WHERE  ue.userid = '$moodel_user_value->userid' AND e.courseid = '$course_id_again'";

                $role_result = $DB->get_records_sql($sql);

                $user_role = '';
                print($role_result); die;
                foreach ($role_result as $role_key => $role_values) {

                    $user_role = $role_values->shortname;
                    $roleid = $role_values->id;

                }

                if($user_role == '' || $user_role == 'student') {
                    $can_create_user = $DB->get_record('config_plugins', array("name" => 'web_new_user_student'),'value');
                    $user_designation = $DB->get_record('config_plugins', array("name" => 'student_position'),'value');
                    $user_approval = $DB->get_record('config_plugins', array("name" => 'required_aproval_student'),'value');
                    
                } else {
                    if($user_role == 'editingteacher') {
                        $can_create_user = $DB->get_record('config_plugins', array("name" => 'web_new_user_teacher'),'value');
                        $user_designation = $DB->get_record('config_plugins', array("name" => 'teacher_position'),'value');
                        $user_approval = $DB->get_record('config_plugins', array("name" => 'required_aproval_teacher'),'value');   
                    }
                }



                $enrolled_userid = $moodel_user_value->userid; 

                $groups_name = $DB->get_record_sql("SELECT * FROM `{groups}` as groups left join {groups_members} on {groups_members}.groupid = groups.id where groups.courseid = '$course_id_again' and {groups_members}.userid='$enrolled_userid'");

                if(!empty($groups_name)) {

                    $user_groups_name = $groups_name->name;

                } else {

                    $user_groups_name = '';

                }
                if($user_role == '' || $user_role == 'student') { 
                    $moodle_user_student_array[] = array('username' => $moodel_user_value->username,'fullname'=> ucfirst($moodel_user_value->firstname)." ".ucfirst($moodel_user_value->lastname),'email'=> $moodel_user_value->email,'passwors'=>$moodel_user_value->password,'user_groups_name' => $user_groups_name,'can_create_user' => $can_create_user->value,'designation' => $user_designation->value,'user_approval' => $user_approval->value);
                } else {
                    if($user_role == 'editingteacher') {
                        $moodle_user_teacher_array[] = array('username' => $moodel_user_value->username,'fullname'=> ucfirst($moodel_user_value->firstname)." ".ucfirst($moodel_user_value->lastname),'email'=> $moodel_user_value->email,'passwors'=>$moodel_user_value->password,'user_groups_name' => $user_groups_name,'can_create_user' => $can_create_user->value,'designation' => $user_designation->value,'user_approval' => $user_approval->value); 
                    }
                }
                

            }
           
        }





die;

        $activity_id = $activity_id_arr[3];



        $secction_description = $activity_id_arr[5];

        

        $activity_description = $activity_id_arr[6];

         



        $course_details_again = $DB->get_record('course', array('id' => $course_id_again) ); // fetch all exist course from



        

        $group_name = '';

        $post = [



                'moodle_users_students' => json_encode($moodle_user_student_array),

                'moodle_users_teachers' => json_encode($moodle_user_teacher_array),



                'course_section_activity' => $activity_set,



                'is_quiz_task' => 0,



                'group_name' => $group_name,



                'project_description' => $course_details_again->summary,

                'subproject_description' => $secction_description,

                'task_description' => $activity_description,

                'course_id' => $course_details_again->id,



                'idnumber' => $course_details_again->idnumber,



                'startdate' => $course_details_again->startdate,



                'enddate' => $course_details_again->enddate,



            ];







          

            $ch = curl_init($teamnio_url.'/admin/sync_moodle_course/index');

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

            //curl_setopt($ch, CURLOPT_HTTPHEADER, array(

            //'Content-Type:application/json'

            //));

            $response = curl_exec($ch);

            

            $response = json_decode($response,true);



            curl_close($ch);

  

            $courseid = $course_id_again;

            $sectionid = 0;

            //$teamnio_activity_id = $response;

            if(!empty($response)) {

                foreach ($response as $key => $teamnio_task_id) {

                    if($teamnio_task_id!='0') {

                       // echo "SELECT id FROM {tool_leeloolxp_sync} where teamnio_task_id = '$teamnio_task_id'";die;

                        $already_exist_query = $DB->get_record_sql( "SELECT id FROM {tool_leeloolxp_sync} where teamnio_task_id = '$teamnio_task_id'");

                        if(empty($already_exist_query)) { 

                            $DB->execute("INSERT INTO {tool_leeloolxp_sync} (`id`, `courseid`, `sectionid`, `activityid`, `enabled`, `teamnio_task_id`,`is_quiz`) VALUES (NULL, '$courseid', '$sectionid', '$activity_id', '1', '$teamnio_task_id','0')");

                        }

                        $msg = 'Sychronizationed successfully.';

                    } else {

                        $activity_id_moodle_arr = $activity_id;

                        $DB->execute("Update {tool_leeloolxp_sync}  set `enabled` = '1' where activityid = '$activity_id_moodle_arr'");

                        $msg = 'Sychronizationed successfully.';

                    }

                }

            }

            $i++; 

            

        }






        if(isset($_REQUEST['quiz_sync'])) {

            foreach ($_REQUEST['quiz_sync'] as $key => $value) {

                $DB->execute("Update {tool_leeloolxp_sync}  set `is_quiz` = '1' where activityid = '$value'");

                $is_q_post = [

                    'activity_id' => $value,

                ];

                $ch = curl_init($teamnio_url.'/admin/sync_moodle_course/is_quiz_update');

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                curl_setopt($ch, CURLOPT_POSTFIELDS, $is_q_post);

                $response = curl_exec($ch);

                curl_close($ch);

            }

        }

}





echo $OUTPUT->header();



echo $OUTPUT->heading_with_help('Teamnio Activities and Resource Synchronizer', 'Teamnio Activities Synchronizer');



if($msg!='') {
    echo "<p style='color:green;'>".$msg."</p>";
}
if (!empty($error)) {
    echo $OUTPUT->container($error, 'leeloolxp_sync_myformerror');
} 







if( !isset($_REQUEST['action'])  ) {



?>



<div id="accordion">



<?php 



















$categories = $DB->get_records('course_categories', array()); // fetch all exist course from



if(!empty($categories)) {



    foreach ($categories as $key => $cat_value) {







?>



<div class="card">



            <div class="card-header" id="heading<?php echo $cat_value->id; ?>">



               <table>



                   <tr>



                       <td>



                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse<?php echo $cat_value->id; ?>" aria-expanded="false" aria-controls="collapse<?php echo $cat_value->id; ?>">



                                <?php echo $cat_value->name;?>



                            </button>



                       </td>



                       <td>Synced?</td>



                   </tr>



               </table>



            </div>



            <div id="collapse<?php echo $cat_value->id; ?>" class="collapse" aria-labelledby="heading<?php echo $cat_value->id; ?>" data-parent="#accordion">



              <div class="card-body">



                <div class="card-table">



                    <table>



                        <?php 



                        $courses = $DB->get_records('course', array('category'=>$cat_value->id));  



                        if(!empty($courses)) {







                            foreach ($courses as $cours_key => $course_value) {



                            



                        ?> 



                        <tr>



                            <td>



                                <div class="tqs-left">



                                    <i class="fas fa-recycle"></i>



                                    <span><?php echo $course_value->fullname;?></span>



                                </div>



                            </td>



                            <td>



                                <div class="tqs-right">



                                    <?php 



                                    $already_sync = false;



                                    $course_synced_query = $DB->get_records('tool_leeloolxp_sync', array('courseid' => $course_value->id));



                                    if(!empty($course_synced_query)) { $already_sync = true; }



                                    if($already_sync) { ?>



                                        <span class="tqs-span-yes">Yes</span>



                                    <?php } else { ?>  <span class="tqs-span-no">No</span> <?php } ?> 



                                    <ul>



                                        <?php if($already_sync) { ?>



                                        <li><a href="<?php echo  parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);?>?action=add&courseid=<?php echo  $course_value->id;?>">Edit</a></li>



                                        <li><a href="#" onclick="UnsyncCourse('<?php echo $course_value->fullname;?>','<?php echo $course_value->id;?>');">Unsync</a></li>

                                        <li><a href="<?php echo parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);?>?resync=resync&courseid_resync=<?php echo  $course_value->id;?>">Resync</a></li>



                                    <?php } else { ?>



                                        <li><a href="<?php echo  parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);?>?action=add&courseid=<?php echo  $course_value->id;?>">Add</a></li>
                                        <li><a href="<?php //echo  parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);?>?resync=resync&courseid_resync=<?php echo  $course_value->id;?>">Resync</a></li>



                                    <?php } ?>





                                    </ul>



                                    <span class="tqs-span-info"><i class="fas fa-info"></i>i</span>



                                </div>



                            </td>



                        </tr>



                    <?php } } ?>



                    </table>



                </div>



              </div>



            </div>



        </div>



<?php



    }



}



















?>







</div>



<?php



} // close action not set







if( isset($_REQUEST['action'])  ) { ?>



<div class="back-arrow-left"><a href="<?php echo parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);?>"><i class="fa fa-arrow-left"></i> Back to courses list</a></div>



<table id="acivity_sync_table"><tr><th>Section</th> <th>Name</th><th>Teamnio Activity Tracker <br> <input type="checkbox" name="all_activity_checkbox" id="all_activity_checkbox" onchange="check_all_activity();"> Select all  </th> <th>Teamnio Quiz Tracker <br> <input type="checkbox" name="all_is_quiz_checkbox" id="all_is_quiz_checkbox" onchange="check_all_is_quiz();"> Select all </th></tr>

<form method="post">

    <?php







    if( $_REQUEST['action'] == 'add')  { 



        $courseid = $_REQUEST['courseid'];



        $course_id = $courseid;



        $course_details = $DB->get_record('course', array('id' => $course_id)); // fetch all exist course from 


            $table = 'course_sections'; // section table name.







            $sections = $DB->get_records($table, array('course' => $course_id)); // fetch sections of each course.



            $course = get_course($course_id);

            $modinfo = get_fast_modinfo($course); 



            if (!empty($sections)) {



                foreach ($sections as $section_key => $sections_details) {



                    if ($sections_details->name != '') {



                        $modules_course = $DB->get_records("course_modules", array('section' => $sections_details->id)); // fecth modules and instaced of modules ?>



                        



                         



                                        <?php



                                        if (!empty($modules_course)) {



                                            foreach ($modules_course as $course_module_details) {



                                                $module_id = $course_module_details->module;



                                                $instance = $course_module_details->instance;



                                                



                                                $modules = $DB->get_records("modules", array('id' => $module_id)); // fetch modules for real table name\



                                                if (!empty($modules)) {



                                                    foreach ($modules as $key => $value) {





                                                        



                                                        $tbl = $value->name;



                                                        $module_detail = $DB->get_records($tbl, array('id' => $instance)); // fetch activities and resources based on instance and module name table.



                                                         if (!empty($module_detail)) {



                                                            foreach ($module_detail as $key => $value_final) {



                                                                $activity_ids = $DB->get_record('course_modules', array('instance' => $instance,'module'=>$module_id));   



                                                                $already_enabled = $DB->get_record_sql( "SELECT id FROM {tool_leeloolxp_sync} where activityid = '$activity_ids->id' and enabled = '1'") ;



                                                                $enabled = false;



                                                                if(!empty($already_enabled)) {



                                                                    $enabled = true;



                                                                } ?>



                                                                    <tr>



                            <td><?php $old_sections_name =='';  if($old_sections_name!=$sections_details->name)  { echo $sections_details->name;  ?> - <?php echo $course_details->fullname; }  ?></td>                                        



                                                                    <td>



                                                                        <div class="tqs-left">







                                                                            <?php 

                                                                            $cm = $modinfo->cms[$activity_ids->id];

                                                                            if($cm){

                                                                                $icon = '<img src="' . $cm->get_icon_url() . '" class="icon" alt="" />&nbsp;';

                                                                            }else{

                                                                                $icon = '<i class="fa fa-recycle"></i>';

                                                                            }

                                                                            echo $icon; ?>







                                                                            <span><?php $old_sections_name  =  $sections_details->name; echo $value_final->name; ?></span>







                                                                        </div>



                                                                    </td>



                                                                    <td>



                                                                        <div class="tqs-right">



                                                                            <span class="tqs-span-<?php if($enabled) { echo "yes";  } else { echo "no";  } ?>"><?php if($enabled) { echo "Yes";  } else { echo "No";  } ?> </span>



                                                                            <ul>



                                                                                



                                                                                    <?php $url  =  parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                                                                                    ?>
                                                                                    <li><a  href="<?php echo $url;?>?resync_activity=1&activity_id=<?php echo $activity_ids->id;?>&activity_name=<?php echo  $value_final->name?>">Resync</a></li>

                                                                                     <?php



                                                                                    if($enabled) {



                                                                                        ?>
                                                                                        <li><a onclick="UnsyncActivity('<?php echo $activity_ids->id; ?>')" href="#">Unsync</a></li><!-- <li><a href="<?php echo $url?>?course_id_date=<?php echo $course_id; ?>">Sync Date</a></li> -->



                                                                                    <?php } else { 



                                                                                        $query_string = $course_details->fullname."$$".$sections_details->name."$$".$value_final->name."$$".$activity_ids->id."$$".$course_id."$$".$sections_details->summary."$$".strip_tags($value_final->intro);?>



                                                                                        <!-- <li><a onclick="" data="" href="<?php echo $url;?>?data=<?php echo $query_string; ?>">Add</a></li> -->

                                                                                        

                                                                                        <li><input class="all_activity_checkbox_single" type="checkbox" name="all_activities[]" value="<?php echo $query_string; ?>"></li>







                                                                                    <?php } ?>







                                                                                    </ul>







                                                                                    <span class="tqs-span-info"><i class="fa fa-info"></i></span>







                                                                                </div>







                                                                            </td>



                                                                            <?php if(isset($value_final->questionsperpage)) { 

                                                                                $is_quiz = $DB->get_record_sql( "SELECT id FROM {tool_leeloolxp_sync} where activityid = '$activity_ids->id' and `is_quiz` = '1'");

                                                                                        if(!empty($is_quiz)) {

                                                                                            $checked = true;

                                                                                        }  else {

                                                                                            $checked = false;

                                                                                        }

                                                                                ?> <td> <input type="checkbox" <?php if($checked) { echo "checked='checked'"; }  ?> name="quiz_sync[]" class="quiz_sync_check" value="<?php echo $activity_ids->id; ?>"></td> <?php } ?>

                                                                        </tr>



                                                                            <?php //} // close quiz task  



                                                            } // loop close for activity and resources



                                                        }  // if close for module_detail



                                                    } //  loop close for  modules.



                                                } // single module condition close



                                            } // modules_course loop



                                        } // modules_course  condition



                        //echo "</table>";



                        //echo "</div>";  echo "</div>";  echo "</div>";



                    } // section name black if clsoe (codition)



                }







            }







        //echo "</div>";







    }  ?>

    <tr><td></td> <td></td> <td><input type="submit" name="sync_activities" value="Submit"></td>ddddddddddd <td></td> </tr>



</form>

    </table> 



<?php 



}



function reconstruct_url($url){    



    $url_parts = parse_url($url);



    $constructed_url = $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'];







    return $constructed_url;
}







?>



<script type="text/javascript">

    

    function check_all_is_quiz(){

        var maincheck_box = document.getElementById("all_is_quiz_checkbox").checked;

        if(maincheck_box) {

            var checkboxes = document.getElementsByClassName("quiz_sync_check");

            for (var i = 0; i < checkboxes.length; i++) { 

                checkboxes[i].checked = true;

            }

        }   else {

            var checkboxes = document.getElementsByClassName("quiz_sync_check");

            for (var i = 0; i < checkboxes.length; i++) { 

                checkboxes[i].checked = false;

            }

        }



    }

    function check_all_activity(){

        var maincheck_box = document.getElementById("all_activity_checkbox").checked;

        if(maincheck_box) {

            var checkboxes = document.getElementsByClassName("all_activity_checkbox_single");

            for (var i = 0; i < checkboxes.length; i++) { 

                checkboxes[i].checked = true;

            }

        }   else {

            var checkboxes = document.getElementsByClassName("all_activity_checkbox_single");

            for (var i = 0; i < checkboxes.length; i++) { 

                checkboxes[i].checked = false;

            }

        }



    }

</script>



<style>







    .card-header button {







        color: #5eb9ba;







    }







    .card-header button {







        padding: 0;







        color: #5eb9ba;







        font-size: 22px;







        font-weight: 300;







        background: none;







        border: none;







        display: block;







        width: 100%;







        text-align: left;







        cursor: pointer;







        outline: none;







    }







    .card-table table, .card-header table {







        width: 100%;







    }







    .card-table table td {







        color: #5eb9ba;







        font-size: 15px;







        padding: 10px;







        border: none;







    }







    .card-header table td {







        padding: 10px;







    }







    .card-table table td:first-child,







    .card-header table td:first-child {







        width: 75%;







    }







    .card-table table td:last-child,







    .card-header table td:last-child {







        width: 25%;







    }







    .card-table table td .tqs-right>* {







        display: inline-block;







    }







    .card-table table td .tqs-right ul {







        margin: 0 0 0 15px;
        list-style: none;
        padding: 0;
    }
    .card-table table td .tqs-right ul li {
        display: inline-block;
        margin: 0 5px;
    }







    .card-table table tr:nth-child(2) {







        background: #f2f2f2;







    }







    .card-table table td .tqs-right ul li a {







        color: #5eb9ba;







        font-size: 15px;







    }







    .card-table table td .tqs-right span.tqs-span-no,







    .card-table table td .tqs-right span.tqs-span-yes {







        padding: 7px;







        border-radius: 4px;







        color: #fff;







        min-width: 25px;







        text-align: center;







    }







    .card-table table td .tqs-right span.tqs-span-no {







        background: #d1d1d1;







    }







    .card-table table td .tqs-right span.tqs-span-yes {







        background: #5eb9ba;







    }







    .card-table table td .tqs-right span.tqs-span-info {







        float: right;







        font-size: 22px;







        font-weight: 700;







    }







</style>
<?php
echo $OUTPUT->footer(); ?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<div class="dialog-modal dialog-modal-activity" style="display: none;">
    <div class="dialog-modal-inn">
        <div id="dialog" >
            <h4>Are you sure you want to unsync this Activity/Resourse?</h4>
            <p>If you do, all users tracking data in the Activity/Resourse will be lost!</p>
            <h3>You can’t undo this.</h3>
            <div class="sure-btn">
                <button data_id = "" onclick="btn_yes_activityunsync();" class="btn btn_yes_activityunsync" >Yes, I’m sure</button>
                <button  onclick="activity_cls_popup();" class="btn activity_cls_popup" >Close</button>
            </div>
            <div class="anymore-link">
                <a href="#">I don’t need this data anymore, and never will</a>
            </div>
        </div>
    </div>
</div>

<div class="dialog-modal dialog-modal-course" style="display: none;">
    <div class="dialog-modal-inn">
        <div id="dialog" >
            <h4>Are you sure you want to unsync this course?</h4>
            <p>If you do, all users tracking data in the course will be lost!</p>
            <h3>You can’t undo this.</h3>
            <div class="sure-btn">
                <button data_id = "" data_name="" onclick="btn_yes_courseunsync();" class="btn btn_yes_courseunsync" >Yes, I’m sure</button>
                <button  onclick="course_cls_popup();" class="btn course_cls_popup" >Close</button>
            </div>
            <div class="anymore-link">
                <a href="#">I don’t need this data anymore, and never will</a>
            </div>
        </div>
    </div>
</div>



<style type="text/css"> 
.dialog-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
}
.dialog-modal-inn {
    background: #fff;
    max-width: 750px;
    padding: 50px;
    text-align: center;
    width: 100%;
}
.dialog-modal-inn h4 {
    font-weight: 400;
    margin: 0 0 25px;
    font-size: 25px;
}
.dialog-modal-inn .sure-btn button {
    font-size: 20px;
    padding: .5rem 3rem;
    color: #fff;
    background-color: #74cfd0;
    border: none;
    display: inline-block;
    text-decoration: none;
    outline: none;
    box-shadow: none;
    margin: 10px 0;
}
.dialog-modal-inn div#dialog {
    font-size: 17px;
}
.dialog-modal-inn p {
    font-size: 19px;
}
.dialog-modal-inn h3 {
    font-weight: 500;
    font-size: 22px;
    color: #f60000;
}
.sure-btn {
    margin: 50px 0 0;
}
.anymore-link {
    margin: 15px 0 0;
}
.anymore-link a {
    color: #74cfd0;
    font-size: 17px;
}


#page-wrapper { z-index: -1 !important;  } </style> 

<script type="text/javascript">
function UnsyncActivity(id) {

 /*   var a  = confirm('Do you want Unsync ? ');

    var url = '<?php echo  parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);?>';

    if(a) {

 

         

    window.location = url+'?unsync_id='+id;

    } else {

        return false;

    }*/
    //$( "#dialog" ).dialog( "open" );
    $('.dialog-modal-activity').show();
    $('.btn_yes_activityunsync').attr('data_id',id);
}

function activity_cls_popup() {
    $('.dialog-modal-activity').hide();
}

function course_cls_popup() {
    $('.dialog-modal-course').hide();
}

function btn_yes_activityunsync() {

   var id =  $('.btn_yes_activityunsync').attr('data_id');
   var url = '<?php echo  parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);?>';

   window.location = url+'?unsync_id='+id;

}

function btn_yes_courseunsync() {

    var id =  $('.btn_yes_courseunsync').attr('data_id');
    var name =  $('.btn_yes_courseunsync').attr('data_name');
    var url = '<?php echo  parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);?>';
    window.location = url+'?unsynccourse='+name+'&id='+id; 
}

function UnsyncCourse(name,id) {

/*    var a  = confirm('Do you want Unsync ? ');

    var url = '<?php echo  parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);?>';

    if(a) {



        window.location = url+'?unsynccourse='+name+'&id='+id; 

    }*/

    $('.dialog-modal-course').show();
    $('.btn_yes_courseunsync').attr('data_id',id);
    $('.btn_yes_courseunsync').attr('data_name',name);
    


}





var slides = document.getElementsByClassName("quiz_data");







for (var i = 0; i < slides.length; i++) {







    if(slides.item(i).innerHTML=='') {







       var data_id =  slides.item(i).getAttribute("data_id");







       document.getElementsByClassName('collapse'+data_id).style="display:none"; 







    }







}















    // user define fucntion to sync courses, sections and resources or activity.















    function sync_this(instance) {















        // checkbox is checked or not















        if(instance.checked) {















            var section_name = instance.getAttribute('section_name'); // get attribute of current element















            var course_name = instance.getAttribute('course_name'); // get attribute of current element















            var activity_name = instance.getAttribute('activity_name'); // get attribute of current element















            var is_quiz_task = instance.getAttribute('is_quiz_task'); // get attribute of current element















            var http = new XMLHttpRequest();















            var url = 'https://leeloolxp.com/dev/admin/sync_moodle_course/index/';















            var params = 'course_name='+course_name+'&section_name='+section_name+'&activity_name='+activity_name+'&is_quiz_task='+is_quiz_task;















            http.open('POST', url, true);































            //Send the proper header information along with the request















            http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');































            http.onreadystatechange = function() {//Call a function when the state changes.















                if(http.readyState == 4 && http.status == 200) {















                    if(http.responseText == '1') {















                        alert('synchronization done successfully.');















                    }















                }















            }















            http.send(params); // send request































        }















    }















</script>



<style>

table#acivity_sync_table {

    width: 100%;

}

table#acivity_sync_table th {

    font-size: 21px;

    font-weight: 400;

    padding: 8px;

}

table#acivity_sync_table td {

    padding: 8px;

    color: #c7c7c7;

}

table#acivity_sync_table td:nth-child(2) {

    color: #5eb9ba;

}

table#acivity_sync_table td ul {

    margin: 0;

    list-style: none;

    padding: 0;

    display: inline-block;

}

table#acivity_sync_table tbody tr {

    border-bottom: 1px solid #f4f4f4;

}

table#acivity_sync_table tbody tr:first-child {

    border-bottom: 1px solid #d9d9d9;

}

table#acivity_sync_table td .tqs-right span.tqs-span-no,

table#acivity_sync_table td .tqs-right span.tqs-span-yes {

    padding: 5px;

    display: inline-block;

    font-size: 13px;

    border-radius: 4px;

    background: #f4f4f4;

    color: #333;

}

table#acivity_sync_table td .tqs-right span.tqs-span-yes {

    background: #0094bc;

    color: #fff;

}

table#acivity_sync_table td .tqs-right ul li a {

    color: #0094bc;

}

table#acivity_sync_table td .tqs-right span.tqs-span-info {

    float: right;

    color: #0094bc;

    padding-right: 10px;

}

table#acivity_sync_table td:first-child {

    color: #5eb9ba;

    font-size: 18px;

}

table#acivity_sync_table td ul li {

    display: inline-block;

    padding: 0 5px;

}

.back-arrow-left a {

    color: #666;

    font-size: 22px;

    font-weight: 300;

}

.back-arrow-left a i {

    padding-right: 10px;

    color: #5eb9ba;

}

.back-arrow-left {

    padding: 10px 0;

}



</style>