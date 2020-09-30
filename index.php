<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Admin settings and defaults
 *
 * @package leeloolxp_sync
 * @copyright  2020 Leeloo LXP (https://leeloolxp.com)
 * @author Leeloo LXP <info@leeloolxp.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define('NO_OUTPUT_BUFFERING', true);
require(__DIR__ . '/../../../config.php');
require_once($CFG->libdir . '/adminlib.php');
global $DB;
if (isset($_REQUEST['leelo_activity_data'])) {
    $courseid = $_REQUEST['course_id'];
    $activities = json_decode($_REQUEST['leelo_activity_data'], true);
    if (!empty($activities)) {
        foreach ($activities as $key => $value) {
            $activityid = $value['activity_id'];
            $startdate = strtotime($value['start_date']);
            $enddate = strtotime($value['end_date']);
            $type = $value['type'];
            $modulerecords = $DB->get_record_sql("SELECT module,instance FROM {course_modules} where id = '$activityid'");
            $moduleid = $modulerecords->module;
            $isntanceid = $modulerecords->instance;
            $modulenames = $DB->get_record_sql("SELECT name FROM {modules} where id = '$moduleid'");
            $modulename = $modulenames->name;
            if ($modulename == 'lesson') {
                $obj = new stdClass();
                $obj->id = $isntanceid;
                $obj->deadline = $enddate;
                $obj->available = $startdate;
                $DB->update_record('lesson', $obj);
            } else {
                if ($modulename == 'quiz') {
                    $obj = new stdClass();
                    $obj->id = $isntanceid;
                    $obj->timeopen = $startdate;
                    $obj->timeclose = $enddate;
                    $DB->update_record('quiz', $obj);
                } else {
                    if ($modulename == 'assign') {
                        $obj = new stdClass();
                        $obj->id = $isntanceid;
                        $obj->allowsubmissionsfromdate = $startdate;
                        $obj->duedate = $enddate;
                        $DB->update_record('assign', $obj);
                    } else {
                        if ($modulename == 'chat') {
                            $obj = new stdClass();
                            $obj->id = $isntanceid;
                            $obj->chattime = $startdate;
                            $DB->update_record('chat', $obj);
                        } else {
                            if ($modulename == 'choice') {
                                $obj = new stdClass();
                                $obj->id = $isntanceid;
                                $obj->timeopen = $startdate;
                                $obj->timeclose = $enddate;
                                $DB->update_record('choice', $obj);
                            } else {
                                if ($modulename == 'data') {
                                    $obj = new stdClass();
                                    $obj->id = $isntanceid;
                                    $obj->timeavailablefrom = $startdate;
                                    $obj->timeavailableto = $enddate;
                                    $DB->update_record('data', $obj);
                                } else {
                                    if ($modulename == 'feedback') {
                                        $obj = new stdClass();
                                        $obj->id = $isntanceid;
                                        $obj->timeopen = $startdate;
                                        $obj->timeclose = $enddate;
                                        $DB->update_record('feedback', $obj);
                                    } else {
                                        if ($modulename == 'forum') {
                                            $obj = new stdClass();
                                            $obj->id = $isntanceid;
                                            $obj->duedate = $startdate;
                                            $obj->cutoffdate = $enddate;
                                            $DB->update_record('forum', $obj);
                                        } else {
                                            if ($modulename == 'wespher') {
                                                $obj = new stdClass();
                                                $obj->id = $isntanceid;
                                                $obj->timeopen = $startdate;
                                                $DB->update_record('wespher', $obj);
                                            } else {
                                                if ($modulename == 'workshop') {
                                                    $obj = new stdClass();
                                                    $obj->id = $isntanceid;
                                                    $obj->submissionstart = $startdate;
                                                    $obj->submissionend = $enddate;
                                                    $DB->update_record('wespher', $obj);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    echo "success";die;
}
if (isset($_REQUEST['leelo_data'])) {
    $courseid = $_REQUEST['course_id'];
    $cobj = new stdClass();
    $cobj->id = $courseid;
    $cobj->startdate = strtotime($_REQUEST['project_start_date']);
    $cobj->enddate = strtotime($_REQUEST['project_end_date']);
    $DB->update_record('course', $cobj);
    $activities = json_decode($_REQUEST['leelo_data'], true);
    if (!empty($activities)) {
        foreach ($activities as $key => $value) {
            $activityid = $value['activity_id'];
            $startdate = strtotime($value['start_date']);
            $enddate = strtotime($value['end_date']);
            $type = $value['type'];
            $modulerecords = $DB->get_record_sql("SELECT module,instance FROM {course_modules} where id = '$activityid'");
            $moduleid = $modulerecords->module;
            $isntanceid = $modulerecords->instance;
            $modulenames = $DB->get_record_sql("SELECT name FROM {modules} where id = '$moduleid'");
            $modulename = $modulenames->name;
            $tbl = $modulename;
            if ($modulename == 'lesson') {
                $obj = new stdClass();
                $obj->id = $isntanceid;
                $obj->deadline = $enddate;
                $obj->available = $startdate;
                $DB->update_record('lesson', $obj);
            } else {
                if ($tbl == 'quiz') {
                    $obj = new stdClass();
                    $obj->id = $isntanceid;
                    $obj->timeopen = $startdate;
                    $obj->timeclose = $enddate;
                    $DB->update_record('quiz', $obj);
                } else {
                    if ($tbl == 'assign') {
                        $obj = new stdClass();
                        $obj->id = $isntanceid;
                        $obj->allowsubmissionsfromdate = $startdate;
                        $obj->duedate = $enddate;
                        $DB->update_record('assign', $obj);
                    } else {
                        if ($tbl == 'chat') {
                            $obj = new stdClass();
                            $obj->id = $isntanceid;
                            $obj->chattime = $startdate;
                            $DB->update_record('chat', $obj);
                        } else {
                            if ($tbl == 'choice') {
                                $obj = new stdClass();
                                $obj->id = $isntanceid;
                                $obj->timeopen = $startdate;
                                $obj->timeclose = $enddate;
                                $DB->update_record('choice', $obj);
                            } else {
                                if ($tbl == 'data') {
                                    $obj = new stdClass();
                                    $obj->id = $isntanceid;
                                    $obj->timeavailablefrom = $startdate;
                                    $obj->timeavailableto = $enddate;
                                    $DB->update_record('data', $obj);
                                } else {
                                    if ($tbl == 'feedback') {
                                        $obj = new stdClass();
                                        $obj->id = $isntanceid;
                                        $obj->timeopen = $startdate;
                                        $obj->timeclose = $enddate;
                                        $DB->update_record('feedback', $obj);
                                    } else {
                                        if ($tbl == 'forum') {
                                            $obj = new stdClass();
                                            $obj->id = $isntanceid;
                                            $obj->duedate = $startdate;
                                            $obj->cutoffdate = $enddate;
                                            $DB->update_record('forum', $obj);
                                        } else {
                                            if ($tbl == 'wespher') {
                                                $obj = new stdClass();
                                                $obj->id = $isntanceid;
                                                $obj->timeopen = $startdate;
                                                $DB->update_record('wespher', $obj);
                                            } else {
                                                if ($tbl == 'workshop') {
                                                    $obj = new stdClass();
                                                    $obj->id = $isntanceid;
                                                    $obj->submissionstart = $startdate;
                                                    $obj->submissionend = $enddate;
                                                    $DB->update_record('wespher', $obj);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    echo "success";die;
}

require_login();
admin_externalpage_setup('toolleeloolxp_sync');
$postcourses = optional_param('course', null, PARAM_RAW);
$activityset = optional_param('sync_activity_resouce', null, PARAM_RAW);
$msg = '';
$configtoolleeloolxpsync = get_config('tool_leeloolxp_sync');
$liacnsekey = $configtoolleeloolxpsync->leeloolxp_synclicensekey;
$postdata = '&license_key=' . $liacnsekey;
$ch = curl_init();
$url = 'https://leeloolxp.com/api_moodle.php/?action=page_info';
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_POST, count($postdata));
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
$output = curl_exec($ch);
curl_close($ch);
$infoteamnio = json_decode($output);
if ($infoteamnio->status != 'false') {
    $teamniourl = $infoteamnio->data->install_url;
} else {
    echo "Teamnio url not found";die;
}

if (isset($_REQUEST['resync_activity'])) {
    $activityid = $_REQUEST['activity_id'];
    $activityname = $_REQUEST['activity_name'];
    $courseid = $_REQUEST['course_id'];
    $coursedetails = $DB->get_record('course', array('id' => $courseid)); // Fetch all exist course from.
    $coursename = $coursedetails->fullname;
    $table = 'course_sections'; // Section table name.
    $sections = $DB->get_records($table, array('course' => $courseid)); // Fetch sections of each course.
    $course = get_course($courseid);
    $modinfo = get_fast_modinfo($course);
    $arrmain = array();
    if (!empty($sections)) {
        foreach ($sections as $sectionkey => $sectionsdetails) {
            if ($sectionsdetails->name != '') {
                $modulescourse = $DB->get_records("course_modules",
                array('section' => $sectionsdetails->id)); // Fecth modules and instaced of modules.
                if (!empty($modulescourse)) {
                    foreach ($modulescourse as $coursemoduledetails) {
                        $moduleid = $coursemoduledetails->module;
                        $instance = $coursemoduledetails->instance;
                        $modules = $DB->get_records("modules", array('id' => $moduleid)); // Fetch modules for real table name.
                        if (!empty($modules)) {
                            foreach ($modules as $key => $value) {
                                $tbl = $value->name;
                                $moduledetail = $DB->get_records($tbl,
                                array('id' => $instance));// Fetch activities and resources.
                                if (!empty($moduledetail)) {
                                    foreach ($moduledetail as $key => $valuefinal) {
                                        $activityids = $DB->get_record('course_modules',
                                        array('instance' => $instance, 'module' => $moduleid));
                                        $alreadyenabled = $DB->get_record_sql("SELECT id FROM {tool_leeloolxp_sync}
                                        where activityid = '$activityids->id'
                                        and enabled = '1'");
                                        $enabled = false;
                                        $enabled = true;
                                        $sectionsdetails->name;
                                        $cm = $modinfo->cms[$activityids->id];
                                        $oldsectionsname = $sectionsdetails->name;

                                        if ($tbl == 'lesson') {
                                            $activitystartdates = $valuefinal->available;
                                            $activityenddates = $valuefinal->deadline;
                                        } else {
                                            if ($tbl == 'quiz') {
                                                $activitystartdates = $valuefinal->timeopen;
                                                $activityenddates = $valuefinal->timeclose;
                                            } else {
                                                if ($tbl == 'assign') {
                                                    $activitystartdates = $valuefinal->allowsubmissionsfromdate;
                                                    $activityenddates = $valuefinal->duedate;
                                                } else {
                                                    if ($tbl == 'chat') {
                                                        $activitystartdates = $valuefinal->chattime;
                                                        $activityenddates = $valuefinal->chattime;
                                                    } else {
                                                        if ($tbl == 'choice') {
                                                            $activitystartdates = $valuefinal->timeopen;
                                                            $activityenddates = $valuefinal->timeclose;
                                                        } else {
                                                            if ($tbl == 'data') {
                                                                $activitystartdates = $valuefinal->timeavailablefrom;
                                                                $activityenddates = $valuefinal->timeavailableto;
                                                            } else {
                                                                if ($tbl == 'feedback') {
                                                                    $activitystartdates = $valuefinal->timeopen;
                                                                    $activityenddates = $valuefinal->timeclose;
                                                                } else {
                                                                    if ($tbl == 'forum') {
                                                                        $activitystartdates = $valuefinal->duedate;
                                                                        $activityenddates = $valuefinal->cutoffdate;
                                                                    } else {
                                                                        if ($tbl == 'wespher') {
                                                                            $activitystartdates = $valuefinal->timeopen;
                                                                            $activityenddates = $valuefinal->timeopen;
                                                                        } else {
                                                                            if ($tbl == 'workshop') {
                                                                                $activitystartdates = $valuefinal->submissionstart;
                                                                                $activityenddates = $valuefinal->submissionend;
                                                                            } else {
                                                                                $activitystartdates = $coursedetails->startdate;
                                                                                $activityenddates = $coursedetails->enddate;
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        if ($activityids->id == $activityid) {
                                            $activitystartdates = $activitystartdate;
                                            $activityenddates = $activityenddate;
                                            $activitytype = $tbl;
                                        }
                                    } // loop close for activity and resources
                                } // if close for module_detail
                            } //  loop close for  modules.
                        } // single module condition close
                    } // modules_course loop
                } // modules_course  condition
            } // section name black if clsoe (codition)
        }
    }

    $post = [
        'activity_id' => $activityid,
        'activity_name' => $activityname,
        'activity_start_date' => date("Y-m-d", $activitystartdates),
        'activity_end_date' => date("Y-m-d", $activityenddates),
        'activity_type' => $activitytype,
    ];
    $ch = curl_init($teamniourl . '/admin/sync_moodle_course/activity_sync');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $response = curl_exec($ch);
    curl_close($ch);
    $msg = 'Resychronizationed successfully.';
}

if (isset($_REQUEST['resync'])) {
    $courseid = $_REQUEST['courseid_resync'];
    $coursedetails = $DB->get_record('course', array('id' => $courseid)); // Fetch all exist course from.
    $projectdescription = $coursedetails->summary;
    $idnumber = $coursedetails->idnumber;
    $coursename = $coursedetails->fullname;
    $table = 'course_sections'; // Section table name.
    $sections = $DB->get_records_sql("SELECT * FROM {course_sections} where course = '$courseid' and name != ''");
    $course = get_course($courseid);
    $modinfo = get_fast_modinfo($course);
    $arrmain = array();
    if (!empty($sections)) {
        foreach ($sections as $sectionkey => $sectionsdetails) {
            if ($sectionsdetails->name != '') {
                $modulescourse = $DB->get_records("course_modules", array('section' => $sectionsdetails->id));
                if (!empty($modulescourse)) {
                    foreach ($modulescourse as $coursemoduledetails) {
                        $moduleid = $coursemoduledetails->module;
                        $instance = $coursemoduledetails->instance;
                        $modules = $DB->get_records("modules", array('id' => $moduleid));
                        if (!empty($modules)) {
                            foreach ($modules as $key => $value) {
                                $tbl = $value->name;
                                $moduledetail = $DB->get_records($tbl, array('id' => $instance));
                                if (!empty($moduledetail)) {
                                    foreach ($moduledetail as $key => $valuefinal) {
                                        $activityids = $DB->get_record('course_modules',
                                        array('instance' => $instance, 'module' => $moduleid));

                                        $alreadyenabled = $DB->get_record_sql("SELECT id FROM {tool_leeloolxp_sync}
                                        where activityid = '$activityids->id' and enabled = '1'");
                                        $enabled = false;
                                        $enabled = true;
                                        $sectionsdetails->name;
                                        $cm = $modinfo->cms[$activityids->id];
                                        $oldsectionsname = $sectionsdetails->name;

                                        if ($tbl == 'lesson') {
                                            $activitystartdates = $valuefinal->available;
                                            $activityenddates = $valuefinal->deadline;
                                        } else {
                                            if ($tbl == 'quiz') {
                                                $activitystartdates = $valuefinal->timeopen;
                                                $activityenddates = $valuefinal->timeclose;
                                            } else {
                                                if ($tbl == 'assign') {
                                                    $activitystartdates = $valuefinal->allowsubmissionsfromdate;
                                                    $activityenddates = $valuefinal->duedate;
                                                } else {
                                                    if ($tbl == 'chat') {
                                                        $activitystartdates = $valuefinal->chattime;
                                                        $activityenddates = $valuefinal->chattime;
                                                    } else {
                                                        if ($tbl == 'choice') {
                                                            $activitystartdates = $valuefinal->timeopen;
                                                            $activityenddates = $valuefinal->timeclose;
                                                        } else {
                                                            if ($tbl == 'data') {
                                                                $activitystartdates = $valuefinal->timeavailablefrom;
                                                                $activityenddates = $valuefinal->timeavailableto;
                                                            } else {
                                                                if ($tbl == 'feedback') {
                                                                    $activitystartdates = $valuefinal->timeopen;
                                                                    $activityenddates = $valuefinal->timeclose;
                                                                } else {
                                                                    if ($tbl == 'forum') {
                                                                        $activitystartdates = $valuefinal->duedate;
                                                                        $activityenddates = $valuefinal->cutoffdate;
                                                                    } else {
                                                                        if ($tbl == 'wespher') {
                                                                            $activitystartdates = $valuefinal->timeopen;
                                                                            $activityenddates = $valuefinal->timeopen;
                                                                        } else {
                                                                            if ($tbl == 'workshop') {
                                                                                $activitystartdates = $valuefinal->submissionstart;
                                                                                $activityenddates = $valuefinal->submissionend;
                                                                            } else {
                                                                                $activitystartdates = $coursedetails->startdate;
                                                                                $activityenddates = $coursedetails->enddate;
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        $arrmain[$activityids->id] =
                                        array('name' => $valuefinal->name,
                                        'activity_start_date' => $activitystartdates,
                                        'activity_end_date' => $activityenddates);
                                    } // Loop close for activity and resources.
                                } // If close for module_detail.
                            } //  Loop close for  modules.
                        } // Single module condition close.
                    } // Modules_course loop.
                } // Modules_course  condition.
            } // section name black if clsoe (codition).
        }
    }
    $post = [
        'course_id' => $courseid,
        'course_name' => $coursename,
        'activity_array' => json_encode($arrmain),
        'start_date' => $coursedetails->startdate,
        'project_description' => $projectdescription,
        'end_date' => $coursedetails->enddate,
        'moodle_course_id' => $idnumber,
        'sections' => json_encode($sections),
    ];
    $ch = curl_init($teamniourl . '/admin/sync_moodle_course/resync_course');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $response = curl_exec($ch);
    curl_close($ch);
    $msg = 'Resychronizationed successfully.';
}

if (isset($_REQUEST['unsync_id']) && !empty($_REQUEST['unsync_id'])) {
    $activityidmoodlearr = $_REQUEST['unsync_id'];
    $activitydetailsagain = $DB->get_record('tool_leeloolxp_sync',
    array('activityid' => $activityidmoodlearr));
    $taskid = $activitydetailsagain->teamnio_task_id;
    $post = ['task_id' => $taskid];
    $ch = curl_init($teamniourl . '/admin/sync_moodle_course/unsyncactivity');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $response = curl_exec($ch);
    curl_close($ch);
    $DB->execute("DELETE FROM {tool_leeloolxp_sync} where activityid = '$activityidmoodlearr'");
    $msg = 'Unsychronizationed successfully.';
}

if (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
    $courseid = $_REQUEST['id'];
    $post = ['course_id' => $courseid];
    $ch = curl_init($teamniourl . '/admin/sync_moodle_course/unsynccourse');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $response = curl_exec($ch);
    curl_close($ch);
    $DB->execute("DELETE FROM {tool_leeloolxp_sync} where courseid = '$courseid'");
    $msg = 'Unsychronizationed successfully.';
}

if (isset($_REQUEST['course_id_date']) && !empty($_REQUEST['course_id_date'])) {
    $courseidagain = $_REQUEST['course_id_date'];
    $coursedetailsagain = $DB->get_record('course', array('id' => $courseidagain));
    $post = [
        'course_id' => $coursedetailsagain->id,
        'startdate' => $coursedetailsagain->startdate,
        'enddate' => $coursedetailsagain->enddate,
    ];
    $ch = curl_init($teamniourl . '/admin/sync_moodle_course/sync_date');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $response = curl_exec($ch);
    curl_close($ch);
    $msg = 'Date Sychronizationed successfully.';
}

if (isset($_REQUEST['sync_activities'])) {
    $alldata = $_REQUEST['all_activities'];
    $i = 0;
    $moodleuserarray = array();
    $moodleuserstudentarray = array();
    $moodleuserteacherarray = array();

    foreach ($alldata as $key => $value) {
        $activityidmoodlearr = array();
        $activityset = str_replace("'", '', $value);
        $activityidarr = explode('$$', $activityset);
        $courseidagain = $activityidarr[4];
        $activitystartdate = $activityidarr[7];
        $activityenddate = $activityidarr[8];
        $activitytype = $activityidarr[9];
        $activityurl = $activityidarr[10];
        if ($i == '0') {
            $enrolleduser = $DB->get_records_sql("SELECT u.*, ue.id, e.courseid, ue.userid, e.enrol
            AS enrolmethod, FROM_UNIXTIME(ue.timecreated)
            FROM {user_enrolments} ue JOIN {enrol} e ON e.id = ue.enrolid
            AND e.status = 0 JOIN {user} u ON u.id = ue.userid
            AND u.deleted = 0 AND u.suspended = 0
            Where e.courseid = '$courseidagain'");

            foreach ($enrolleduser as $key => $moodeluservalue) {
                $sql = "SELECT r.shortname as shortname, r.id as roleid
                FROM {role_assignments} AS ra LEFT JOIN {user_enrolments} AS ue ON ra.userid = ue.userid
                LEFT JOIN {role} AS r ON ra.roleid = r.id LEFT JOIN {context} AS c
                ON c.id = ra.contextid LEFT JOIN {enrol} AS e ON e.courseid = c.instanceid
                AND ue.enrolid = e.id
                WHERE  ue.userid = '$moodeluservalue->userid' AND e.courseid = '$courseidagain'";

                $roleresult = $DB->get_records_sql($sql);

                $userrole = '';

                foreach ($roleresult as $rolekey => $rolevalues) {
                    $userrole = $rolevalues->shortname;
                    $roleid = $rolevalues->roleid;
                }
                $usertype = '';
                $teamniorole = '';
                $teamniousertype = '';
                $userdegree = $DB->get_record_sql("SELECT DISTINCT data  FROM {user_info_data}
                as fdata left join {user_info_field} as fieldss on fdata.fieldid = fieldss.id
                where fieldss.shortname = 'degree' and fdata.userid = '$moodeluservalue->userid'");
                $userdegreename = $userdegree->data;
                $userdepartment = $moodeluservalue->department;
                $userinstitution = $moodeluservalue->institution;
                $ssopluginconfig = get_config('leeloolxp_tracking_sso');
                $studentnumcombinationsval = $ssopluginconfig->student_num_combination;
                $studentdbsetarr = array();
                for ($si = 1; $studentnumcombinationsval >= $si; $si++) {
                    $studentpositionmoodle = 'student_position_moodle_' . $si;
                    $mstudentrole = $ssopluginconfig->$studentpositionmoodle;

                    $studentinstitution = 'student_institution_' . $si;
                    $mstudentinstitution = $ssopluginconfig->$studentinstitution;

                    $studentdepartment = 'student_department_' . $si;
                    $mstudentdepartment = $ssopluginconfig->$studentdepartment;

                    $studentdegree = 'student_degree_' . $si;
                    $mstudentdegree = $ssopluginconfig->$studentdegree;

                    $studentdbsetarr[$si] = $mstudentrole . "_" .
                    $mstudentinstitution . "_" . $mstudentdepartment . "_" . $mstudentdegree;
                }

                $userstudentinfo = $roleid . "_" . $userinstitution . "_" .
                $userdepartment . "_" . $userdegreename;

                $matchedvalue = array_search($userstudentinfo, $studentdbsetarr);

                if ($matchedvalue) {
                    $tcolnamestudent = 'student_position_t_' . $matchedvalue;
                    $teamniorole = $ssopluginconfig->$tcolnamestudent;
                    $usertype = 'student';
                } else {
                    $teachernumcombinations = $ssopluginconfig->teacher_num_combination;
                    $teachernumcombinationsval = $teachernumcombinations;

                    $teacherdbsetarr = array();

                    for ($si = 1; $teachernumcombinationsval >= $si; $si++) {
                        $teacherpositionmoodle = 'teacher_position_moodle_' . $si;

                        $mteacherrole = $ssopluginconfig->$teacherpositionmoodle;

                        $teacherinstitution = 'teacher_institution_' . $si;

                        $mteacherinstitution = $ssopluginconfig->$teacherinstitution;

                        $teacherdepartment = 'teacher_department_' . $si;

                        $mteacherdepartment = $ssopluginconfig->$teacherdepartment;

                        $teacherdegree = 'teacher_degree_' . $si;

                        $mteacherdegree = $ssopluginconfig->$teacherdegree;

                        $teacherdbsetarr[$si] = $mteacherrole . "_" .
                        $mteacherinstitution . "_" . $mteacherdepartment . "_" . $mteacherdegree;
                    }

                    $userteacherinfo = $roleid . "_" . $userinstitution . "_" .
                    $userdepartment . "_" . $userdegreename;
                    $matchedvalueteacher = array_search($userteacherinfo, $teacherdbsetarr);

                    if ($matchedvalueteacher) {
                        $tcolnameteacher = 'teacher_position_t_' . $matchedvalueteacher;
                        $teamniorole = $ssopluginconfig->$tcolnameteacher;
                        $usertype = 'teacher';
                    } else {
                        $usertype = 'student';
                        $teamniorole = $ssopluginconfig->default_student_position;
                    }
                }

                if ($usertype == 'student') {
                    $cancreateuser = $ssopluginconfig->web_new_user_student;
                    $userapproval = $ssopluginconfig->required_aproval_student;
                } else {
                    if ($usertype == 'teacher') {
                        $cancreateuser = $ssopluginconfig->web_new_user_teacher;
                        $userdesignation = $teamniorole;
                        $userapproval = $ssopluginconfig->required_aproval_teacher;
                    }
                }
                $enrolleduserid = $moodeluservalue->userid;
                $groupsname = $DB->get_records_sql("SELECT * FROM `{groups}` as groups left join
                {groups_members} on {groups_members}.groupid = groups.id
                where groups.courseid = '$courseidagain' and {groups_members}.userid='$enrolleduserid'");
                $usergroupsname = array();
                if (!empty($groupsname)) {
                    foreach ($groupsname as $key => $gvalue) {
                        $usergroupsname[] = $gvalue->name;
                    }
                }
                $usergroupsname = implode(',', $usergroupsname);
                $moodleurlpic = new moodle_url('/user/pix.php/' . $moodeluservalue->id . '/f.jpg');
                if ($usertype == 'student') {
                    $lastlogin = date('Y-m-d h:i:s', $moodeluservalue->lastlogin);
                    $moodleuserstudentarray[] = array(
                        'username' => $moodeluservalue->username,
                        'fullname' => ucfirst($moodeluservalue->firstname) . " " .
                        ucfirst($moodeluservalue->middlename) . " " . ucfirst($moodeluservalue->lastname),
                        'user_pic_moodle_url' => $moodleurlpic,
                        'email' => $moodeluservalue->email,
                        'city' => $moodeluservalue->city,
                        'country' => $moodeluservalue->country,
                        'timezone' => $moodeluservalue->timezone,
                        'firstnamephonetic' => $moodeluservalue->firstnamephonetic,
                        'lastnamephonetic' => $moodeluservalue->lastnamephonetic,
                        'middlename' => $moodeluservalue->middlename,
                        'alternatename' => $moodeluservalue->alternatename,
                        'icq' => $moodeluservalue->icq,
                        'skype' => $moodeluservalue->skype,
                        'aim' => $moodeluservalue->aim,
                        'yahoo' => $moodeluservalue->yahoo,
                        'msn' => $moodeluservalue->msn,
                        'idnumber' => $moodeluservalue->idnumber,
                        'institution' => $moodeluservalue->institution,
                        'department' => $moodeluservalue->department,
                        'phone' => $moodeluservalue->phone,
                        'moodle_phone' => $moodeluservalue->phone2,
                        'adress' => $moodeluservalue->adress,
                        'firstaccess' => $moodeluservalue->firstaccess,
                        'lastaccess' => $moodeluservalue->lastaccess,
                        'lastlogin' => $lastlogin,
                        'lastip' => $moodeluservalue->lastip,
                        'passwors' => $moodeluservalue->password,
                        'user_groups_name' => $usergroupsname,
                        'can_create_user' => $cancreateuser,
                        'designation' => $userdesignation,
                        'user_approval' => $userapproval,
                        'user_type' => $usertype,
                        'designation_id' => $userdesignation,
                    );
                } else {
                    if ($usertype == 'teacher') {
                        $moodleuserteacherarray[] = array('username' => $moodeluservalue->username,
                            'fullname' => ucfirst($moodeluservalue->firstname) . " " .
                            ucfirst($moodeluservalue->middlename) . " " . ucfirst($moodeluservalue->lastname),
                            'user_pic_moodle_url' => $moodleurlpic,
                            'email' => $moodeluservalue->email,
                            'city' => $moodeluservalue->city,
                            'country' => $moodeluservalue->country,
                            'timezone' => $moodeluservalue->timezone,
                            'firstnamephonetic' => $moodeluservalue->firstnamephonetic,
                            'lastnamephonetic' => $moodeluservalue->lastnamephonetic,
                            'middlename' => $moodeluservalue->middlename,
                            'alternatename' => $moodeluservalue->alternatename,
                            'icq' => $moodeluservalue->icq,
                            'skype' => $moodeluservalue->skype,
                            'aim' => $moodeluservalue->aim,
                            'yahoo' => $moodeluservalue->yahoo,
                            'msn' => $moodeluservalue->msn,
                            'idnumber' => $moodeluservalue->idnumber,
                            'institution' => $moodeluservalue->institution,
                            'department' => $moodeluservalue->department,
                            'phone' => $moodeluservalue->phone,
                            'moodle_phone' => $moodeluservalue->phone2,
                            'adress' => $moodeluservalue->adress,
                            'firstaccess' => $moodeluservalue->firstaccess,
                            'lastaccess' => $moodeluservalue->lastaccess,
                            'lastlogin' => $moodeluservalue->lastlogin,
                            'lastip' => $moodeluservalue->lastip,
                            'passwors' => $moodeluservalue->password,
                            'user_groups_name' => $usergroupsname,
                            'can_create_user' => $cancreateuser,
                            'designation' => $userdesignation,
                            'user_approval' => $userapproval,
                            'user_type' => $usertype,
                            'designation_id' => $userdesignation);
                    }
                }
            }
        }
        $activityid = $activityidarr[3];
        $secctiondescription = $activityidarr[5];
        $activitydescription = $activityidarr[6];
        $coursedetailsagain = $DB->get_record('course', array('id' => $courseidagain));
        $groupname = '';
        $post = [
            'moodle_users_students' => json_encode($moodleuserstudentarray),
            'moodle_users_teachers' => json_encode($moodleuserteacherarray),
            'course_section_activity' => $activityset,
            'is_quiz_task' => 0,
            'group_name' => $groupname,
            'project_description' => $coursedetailsagain->summary,
            'subproject_description' => $secctiondescription,
            'task_description' => $activitydescription,
            'course_id' => $coursedetailsagain->id,
            'idnumber' => $coursedetailsagain->idnumber,
            'startdate' => $coursedetailsagain->startdate,
            'activity_start_date' => $activitystartdate,
            'activity_end_date' => $activityenddate,
            'enddate' => $coursedetailsagain->enddate,
            'activity_type' => $activitytype,
            'activity_url' => $activityurl,
        ];
        $ch = curl_init($teamniourl . '/admin/sync_moodle_course/index');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $response = curl_exec($ch);
        $response = json_decode($response, true);
        curl_close($ch);
        $courseid = $courseidagain;
        $sectionid = 0;
        if (!empty($response)) {
            foreach ($response as $key => $teamniotaskid) {
                if ($teamniotaskid != '0') {
                    $alreadyexistquery = $DB->get_record_sql("SELECT id FROM {tool_leeloolxp_sync}
                    where teamnio_task_id = '$teamniotaskid'");
                    if (empty($alreadyexistquery)) {
                        $DB->execute("INSERT INTO {tool_leeloolxp_sync}
                        (`id`, `courseid`, `sectionid`, `activityid`, `enabled`, `teamnio_task_id`,`is_quiz`)
                        VALUES (NULL, '$courseid', '$sectionid', '$activityid', '1', '$teamniotaskid','0')");
                    }
                    $msg = 'Sychronizationed successfully.';
                } else {
                    $activityidmoodlearr = $activityid;
                    $DB->execute("Update {tool_leeloolxp_sync}  set `enabled` = '1'
                    where activityid = '$activityidmoodlearr'");
                    $msg = 'Sychronizationed successfully.';
                }
            }
        }

        $i++;
    }
    if (isset($_REQUEST['quiz_sync'])) {
        foreach ($_REQUEST['quiz_sync'] as $key => $value) {
            $DB->execute("Update {tool_leeloolxp_sync}  set `is_quiz` = '1'
            where activityid = '$value'");
            $isqpost = [
                'activity_id' => $value,
            ];
            $ch = curl_init($teamniourl . '/admin/sync_moodle_course/is_quiz_update');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $isqpost);
            $response = curl_exec($ch);
            curl_close($ch);
        }
    }
}
echo $OUTPUT->header();
if ($msg != '') {
    echo "<p style='color:green;'>" . $msg . "</p>";
}
if (!empty($error)) {
    echo $OUTPUT->container($error, 'leeloolxp_sync_myformerror');
}

if (!isset($_REQUEST['action'])) {
    ?> <div id="accordion">

<?php

    $categories = $DB->get_records('course_categories', array());

if (!empty($categories)) {
    foreach ($categories as $key => $catvalue) {
?>
    <div class="card">
            <div class="card-header" id="heading<?php echo $catvalue->id; ?>">
                <table>
                    <tr>
                        <td>
                            <button class="btn btn-link collapsed" 
                            data-toggle="collapse" 
                            data-target="#collapse<?php echo $catvalue->id; ?>" 
                            aria-expanded="false" aria-controls="collapse
                            <?php echo $catvalue->id; ?>"><?php echo $catvalue->name; ?></button>
                        </td>
                        <td>Synced?</td>
                    </tr>
                </table>
            </div>
            <div id="collapse<?php echo $catvalue->id; ?>" 
            class="collapse" aria-labelledby="heading<?php echo $catvalue->id; ?>" 
            data-parent="#accordion">
                <div class="card-body">
                    <div class="card-table">
                        <table>
                        <?php
                        $courses = $DB->get_records('course', array('category' => $catvalue->id));
                        if (!empty($courses)) {
                            foreach ($courses as $courskey => $coursevalue) {
?>
                                        <tr>
                                            <td>
                                                <div class="tqs-left">
                                                    <i class="fa fa-recycle"></i>
                                                    <span><?php echo $coursevalue->fullname; ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="tqs-right">
                                                <?php
                                                    $alreadysync = false;
                                                    $coursesyncedquery = $DB->get_records('tool_leeloolxp_sync',
                                                    array('courseid' => $coursevalue->id));
                                                if (!empty($coursesyncedquery)) {
                                                    $alreadysync = true;
                                                }
                                                if ($alreadysync) {
?>
                                                    <span class="tqs-span-yes">Yes</span>
                                                    <?php
                                                } else {
                                                    ?><span class="tqs-span-no">No</span><?php
                                                }
                                                    ?>
                                                    <ul>
                                                        <?php if ($alreadysync) {?>
                                                            <li><a href="<?php
                                                                echo parse_url($_SERVER['REQUEST_URI'] , PHP_URL_PATH); ?>
                                                                ?action=add&courseid=<?php echo $coursevalue->id; ?>">
                                                                Edit</a></li>
                                                            <li>
                                                                <a href="#" onclick="UnsyncCourse('<?php echo
                                                                $coursevalue->fullname; ?>
                                                                ','<?php echo $coursevalue->id; ?>');">
                                                                Unsync</a></li>
                                                            <li>
                                                            <?php $parseurl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>
                                                                <a href="<?php echo $parseurl; ?>
                                                                ?resync=resync&courseid_resync=<?php
                                                                echo $coursevalue->id; ?>">
                                                                Resync</a></li>
                                                            <?php
                                                        } else {?>
                                                                <li>
                                                                    <a href="<?php
                                                                    echo parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>
                                                                ?action=add&courseid=
                                                                <?php echo $coursevalue->id; ?>">Add</a></li>
                                                                <?php
                                                            }?>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                }
?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
        }?>
</div>



<?php }

if (isset($_REQUEST['action'])) {
    ?>
    <div class="back-arrow-left">
    <a href="<?php echo parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>">
    <i class="fa fa-arrow-left"></i> Back to courses list</a></div>
    <table id="acivity_sync_table"><tr><th>Section</th>
    <th>Name</th>
    <th>Teamnio Activity Tracker <br> 
    <input type="checkbox" name="all_activity_checkbox" 
    id="all_activity_checkbox" onchange="check_all_activity();"> Select all  </th> 
    <th>Teamnio Quiz Tracker <br> 
    <input type="checkbox" name="all_is_quiz_checkbox" 
    id="all_is_quiz_checkbox" onchange="check_all_is_quiz();"> Select all </th></tr>
        <form method="post">
            <?php
if ($_REQUEST['action'] == 'add') {
        $courseid = $_REQUEST['courseid'];

        $coursedetails = $DB->get_record('course', array('id' => $courseid));
        $table = 'course_sections';
        $sections = $DB->get_records($table, array('course' => $courseid));
        $course = get_course($courseid);
        $modinfo = get_fast_modinfo($course);

        if (!empty($sections)) {
            foreach ($sections as $sectionkey => $sectionsdetails) {
                if ($sectionsdetails->name != '') {
                    $modules_course = $DB->get_records_sql("select * from 
                    {course_modules} where `section` = '" . $sectionsdetails->id . "' order by added DESC");
                    if (!empty($modulescourse)) {
                        foreach ($modulescourse as $coursemoduledetails) {
                            $moduleid = $coursemoduledetails->module;
                            $instance = $coursemoduledetails->instance;
                            $modules = $DB->get_records("modules", array('id' => $moduleid));
                            if (!empty($modules)) {
                                foreach ($modules as $key => $value) {
                                    $tbl = $value->name;
                                    $moduledetail = $DB->get_records($tbl, array('id' => $instance));
                                    if (!empty($moduledetail)) {
                                        foreach ($moduledetail as $key => $valuefinal) {
                                            if ($tbl == 'lesson') {
                                                $activitystartdates = $valuefinal->available;
                                                $activityenddates = $valuefinal->deadline;
                                            } else {
                                                if ($tbl == 'quiz') {
                                                    $activitystartdates = $valuefinal->timeopen;
                                                    $activityenddates = $valuefinal->timeclose;
                                                } else {
                                                    if ($tbl == 'assign') {
                                                        $activitystartdates = $valuefinal->allowsubmissionsfromdate;
                                                        $activityenddates = $valuefinal->duedate;
                                                    } else {
                                                        if ($tbl == 'chat') {
                                                            $activitystartdates = $valuefinal->chattime;
                                                            $activityenddates = $valuefinal->chattime;
                                                        } else {
                                                            if ($tbl == 'choice') {
                                                                $activitystartdates = $valuefinal->timeopen;
                                                                $activityenddates = $valuefinal->timeclose;
                                                            } else {
                                                                if ($tbl == 'data') {
                                                                    $activitystartdates = $valuefinal->timeavailablefrom;
                                                                    $activityenddates = $valuefinal->timeavailableto;
                                                                } else {
                                                                    if ($tbl == 'feedback') {
                                                                        $activitystartdates = $valuefinal->timeopen;
                                                                        $activityenddates = $valuefinal->timeclose;
                                                                    } else {
                                                                        if ($tbl == 'forum') {
                                                                            $activitystartdates = 
                                                                            $valuefinal->duedate;
                                                                            $activityenddates = 
                                                                            $valuefinal->cutoffdate;
                                                                        } else {
                                                                            if ($tbl == 'wespher') {
                                                                                $activitystartdates = 
                                                                                $valuefinal->timeopen;
                                                                                $activityenddates = 
                                                                                $valuefinal->timeopen;
                                                                            } else {
                                                                                if ($tbl == 
                                                                                'workshop') {
                                                                                    $activitystartdates
                                                                                    =$valuefinal->submissionstart;
                                                                                    $activityenddates=$valuefinal->submissionend;
                                                                                } else {
                                                                                    $activitystartdates = $coursedetails->startdate;
                                                                                    $activityenddates = $coursedetails->enddate;
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                            $activityids = $DB->get_record('course_modules',
                                            array('instance' => $instance, 'module' => $moduleid));
                                            $alreadyenabled = $DB->get_record_sql("SELECT id FROM
                                            {tool_leeloolxp_sync}
                                            where activityid = '$activityids->id' and enabled = '1'");
                                            $enabled = false;

                                            if (!empty($alreadyenabled)) {
                                                $enabled = true;
                                            }?>
                                                                <tr>
                                                                    <td><?php $oldsectionsname == '';
                                                                    if ($oldsectionsname != 
                                                                    $sectionsdetails->name) {
                                                                        echo $sectionsdetails->name;?> - <?php
                                                                    echo $coursedetails->fullname;} ?
                                                                    ></td>
                                                                    <td>
                                                                        <div class="tqs-left">
                                                                            <?php
                                                    $cm = $modinfo->cms[$activityids->id];

                                            if ($cm) {
                                                $iconurl = $cm->get_icon_url();
                                                $icon = '<img src="' . $cm->get_icon_url() . '" 
                                                class="icon" alt="" />&nbsp;';
                                            } else {
                                                $icon = '<i class="fa fa-recycle"></i>';
                                                $iconurl = '';
                                            }

                                            echo $icon;?>
                                            <span><?php $oldsectionsname = $sectionsdetails->name;
                                            echo $valuefinal->name;?></span>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="tqs-right">
                                                                            <span class="tqs-span-<?php if ($enabled) {
                                                                                echo "yes";} else {echo "no";}?>">
                                                                                <?php if ($enabled) {echo "Yes";} else {
                                                                                    echo "No";}?> </span>
                                                                            <ul>
                                                                            <?php $url = parse_url($_SERVER['REQUEST_URI', 
                                                                                PHP_URL_PATH);
                                                                                if ($enabled) {
                                                ?>
                                                                                        <li><a  href="
                                                                                        <?php echo $url; ?>?resync_activity=1&
                                                                                        activity_id=<?php
                                                                                        echo $activityids->id; ?>
                                                                                        &activity_name=
                                                                                        <?php echo $valuefinal->name ?>&
                                                                                        course_id=
                                                                                        <?php echo $_REQUEST['courseid'];
                                                                                        ?>">Resync</a></li>
                                                                                        <?php
}
                                            if ($enabled) {?>
                                                                                        <li><a onclick="UnsyncActivity('<?php 
                                                                                        echo $activityids->id; ?>')" 
                                                                                        href="#">Unsync</a></li><?php } else {
                                                $querystring = $coursedetails->fullname . "$$" . 
                                                $sectionsdetails->name . "$$" . $valuefinal->name . "$$" .
                                                $activityids->id . "$$" . $courseid . "$$" .
                                                $sectionsdetails->summary . "$$" .
                                                strip_tags($valuefinal->intro . "$$" . 
                                                $activitystartdates . "$$" .
                                                $activityenddates . "$$" . $tbl . "$$" . $iconurl);?>
                                                                                            <li><input 
                                                                                            class="all_activity_checkbox_singl
                                                                                            e" type="checkbox" 
                                                                                            name="all_activities[]" value="<?
                                                                                            php echo str_replace('"', '', 
                                                                                            $querystring); ?>"></li>
                                                                                            <?php }?>
                                                                                        </ul>
                                                                                    </div>
                                                                                    </td>
                                                                                    <?php if (isset
                                                                                    ($valuefinal->questionsperpage)) {
                                                $isquiz = $DB->get_record_sql("SELECT id FROM 
                                                {tool_leeloolxp_sync} 
                                                where activityid = '$activityids->id' and `is_quiz` = '1'");

                                                if (!empty($isquiz)) {
                                                    $checked = true;
                                                } else {
                                                        $checked = false;
                                                        }
                                                ?>
                                                                                        <td style="text-align: center"> 
                                                                                        <input type="checkbox" 
                                                                                        <?php if ($checked) {
                                                                                            echo "checked='checked'";
                                                                                            }?> 
                                                                                            name="quiz_sync[]" 
                                                                                            class="quiz_sync_check" 
                                                                                            value="<?php 
                                                                                            echo $activityids->id; ?>"></td> 
                                                                                            <?php } else {?> <td></td> <?php }
                                                                                            ?>
                                                                                    </tr>



                                                                            <?php
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
?>

    <tr>
        <td></td>
        <td></td>
        <td><input type="submit" name="sync_activities" value="Submit"></td>
        <td></td>
    </tr>
</form>
</table>
<?php
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
 .card-table table td:first-child,.card-header table td:first-child {
        width: 65%;
    }
    .card-table table td:last-child,
    .card-header table td:last-child {
        width: 35%;
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
                <button data_id = "" onclick="btn_yes_activityunsync();" 
                class="btn btn_yes_activityunsync" >Yes, I’m sure</button>
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
                <button data_id = "" data_name="" onclick="btn_yes_courseunsync();" 
                class="btn btn_yes_courseunsync" >Yes, I’m sure</button>
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
#page-wrapper { z-index: -1 !important;  }
</style>
<script type="text/javascript">
function UnsyncActivity(id) {
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
   var url = '<?php echo parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>';
   window.location = url+'?unsync_id='+id;
}
function btn_yes_courseunsync() {
    var id =  $('.btn_yes_courseunsync').attr('data_id');
    var name =  $('.btn_yes_courseunsync').attr('data_name');
    var url = '<?php echo parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>';
    window.location = url+'?unsynccourse='+name+'&id='+id;
}
function UnsyncCourse(name,id) {
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
