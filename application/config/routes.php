<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "basic";
$route['404_override'] = '';

$route['login'] = "basic/login";
$route['logout'] = "basic/logout";
$route['mailUsername'] = "basic/mailUsername";

$route['admissions'] = "admissionController/index";
$route['validateApplication'] = "admissionController/validateApplication";
$route['validateApplicationREST'] = "admissionController/validateApplicationREST";
$route['submitApplication'] = "admissionController/submitApplication";
$route['submitApplicationREST'] = "admissionController/submitApplicationREST";
$route['getApplicationStatus'] = "admissionController/getApplicationStatus";
$route['getApplicationStatusREST'] = "admissionController/getApplicationStatusREST";
$route['applications/(:any)/(:any)'] = "admissionController/applications/$1/$2";
$route['applicationsREST'] = "admissionController/applicationsREST";

$route['changeApplicationStatus'] = "admissionController/changeApplicationStatus";
$route['changeApplicationStatusREST'] = "admissionController/changeApplicationStatusREST";

$route['generalNotifications'] = "generalController/generalNotifications";
$route['generalNotificationsREST'] = "generalController/generalNotificationsREST";

$route['notifications/(:any)/(:any)'] = "schoolController/notifications/$1/$2";
$route['notificationsREST'] = "schoolController/notificationsREST";
$route['addOrUpdateNotification'] = "schoolController/addOrUpdateNotification";
$route['deleteNotifications'] = "schoolController/deleteNotifications";
$route['genNotificationDetails/(:any)'] = "schoolController/genNotificationDetails/$1";
$route['images/(:any)/(:any)'] = "generalController/images/$1/$2";

$route['general_information'] = "generalController/generalInformation";
$route['events'] = "generalController/events";
$route['school_calendar'] = "generalController/school_calendar";
$route['code_of_conduct'] = "generalController/code_of_conduct";

$route['about_us'] = "generalController/aboutUs";
$route['principal'] = "generalController/ourPrincipal"; 
$route['board'] = "generalController/ourBoard";
$route['our_teachers'] = "generalController/our_teachers";

$route['school_tour'] = "generalController/school_tour";
$route['clubs'] = "generalController/clubs";
$route['activities'] = "generalController/activities";

$route['edit_calendar'] = "schoolController/edit_calendar";
$route['changeCalendarPeriod'] = "schoolController/changeCalendarPeriod";
$route['addOrEditCalEvent'] = "schoolController/addOrEditCalEvent";
$route['teachers'] = "schoolController/teachers";
$route['search_teachers'] = "schoolController/teachers";
$route['teachersREST'] = "schoolController/teachersREST";
$route['addTeacher'] = "schoolController/addTeacher";

$route['classes'] = "schoolController/classes";
$route['classDetails'] = "schoolController/classDetails";
$route['deleteClassSubject'] = "schoolController/deleteClassSubject";
$route['changeSubTeacher'] = "schoolController/changeSubTeacher";
$route['addClassSubject'] = "schoolController/addClassSubject";
$route['changeTTSubject'] = "schoolController/changeTTSubject";
$route['getClassSyllabus'] = "schoolController/getClassSyllabus";
$route['saveSyllabusEdit'] = "schoolController/saveSyllabusEdit";
$route['importSyllabus'] = "schoolController/importSyllabus";
$route['getClassStudents'] = "schoolController/getClassStudents";

$route['students'] = "schoolController/students";
$route['search_students'] = "schoolController/students";
$route['fetchAllStudents'] = "schoolController/fetchAllStudents";
$route['fetchAllParents'] = "schoolController/fetchAllParents";
$route['addStudent'] = "schoolController/addStudent";

$route['inbox'] = "messageController/inbox";
$route['inbox_search'] = "messageController/inbox_search";
$route['sendInboxMessage'] = "messageController/sendInboxMessage";
$route['getInboxContent'] = "messageController/getInboxContent";
$route['markMessage'] = "messageController/markMessage";
$route['getMessageDetails'] = "messageController/getMessageDetails";
$route['sendInboxReply'] = "messageController/sendInboxReply";

$route['edit_tests'] = "schoolController/edit_tests";
$route['edit_school_tests'] = "schoolController/edit_school_tests";
$route['addSchoolTest'] = "schoolController/addSchoolTest";
$route['editSchoolTest'] = "schoolController/editSchoolTest";
$route['getTestDetails'] = "schoolController/getTestDetails";
$route['editSchoolTestDetail'] = "schoolController/editSchoolTestDetail";
$route['getScoreCardDetails'] = "schoolController/getScoreCardDetails";

//Admin functions
$route['addClasses'] = "adminController/addClasses";
$route['addStudents'] = "adminController/addStudents";
$route['uploadStudents'] = "adminController/uploadStudents";
$route['addTests'] = "adminController/addTests";

//Teacher Login functions
$route['teacher_test'] = "teacherController/teacher_test";
$route['getClassTestDetails'] = "teacherController/getClassTestDetails";
$route['getClassTestSubjectDetails'] = "teacherController/getClassTestSubjectDetails";
$route['saveScoreCard'] = "teacherController/saveScoreCard";
$route['saveStudentScoreCard'] = "teacherController/saveStudentScoreCard";

//Class Forum
$route['fetchForumItems'] = "parentController/fetchForumItems";
$route['addTextPost'] = "parentController/addTextPost";
$route['postComment'] = "parentController/postComment";
$route['fetchMoreFeed'] = "parentController/fetchMoreFeed";
$route['getFeedDetails'] = "parentController/getFeedDetails";
$route['fetchComments'] = "parentController/fetchComments";
$route['deletePost'] = "parentController/deletePost";
$route['deleteComment'] = "parentController/deleteComment";
$route['uploadFeedImage'] = "parentController/uploadFeedImage";

//forum - teacher login
$route['class_forum'] = "teacherController/class_forum";
$route['fetchClassForumItems'] = "teacherController/fetchClassForumItems";
$route['addClassTextPost'] = "teacherController/addClassTextPost";
$route['deleteClassPost'] = "teacherController/deleteClassPost";
$route['postClassComment'] = "teacherController/postClassComment";

//forum - school login
$route['school_class_forum'] = "schoolController/school_class_forum";
$route['addForumPost'] = "schoolController/addForumPost";

//home work
$route['home_work'] = "teacherController/home_work";
$route['fetchHomeWorkDetails'] = "teacherController/fetchHomeWorkDetails";
$route['postClassHomeWork'] = "teacherController/postClassHomeWork";
$route['deleteHomeWork'] = "teacherController/deleteHomeWork";
$route['fetchHWByTime'] = "teacherController/fetchHWByTime";
$route['parent_home_work'] = "parentController/parent_home_work";
$route['fetchSubjectHW'] = "parentController/fetchSubjectHW";
$route['fetchHWByTimeParent'] = "parentController/fetchHWByTimeParent";

//profile
$route['showProfile'] = "schoolController/showProfile";
$route['saveProfileField'] = "schoolController/saveProfileField";
$route['uploadProPic'] = "schoolController/uploadProPic";
$route['saveBulkEdit'] = "schoolController/saveBulkEdit";
$route['saveProfileDate'] = "schoolController/saveProfileDate";
$route['changePassword'] = "schoolController/changePassword";
$route['showStudentProfile'] = "schoolController/showStudentProfile";

//Timetable teacher login
$route['teacher_timetable'] = "teacherController/teacher_timetable";
$route['getTeacherTimeTable'] = "teacherController/getTeacherTimeTable";
$route['getTeacherClassTT'] = "teacherController/getTeacherClassTT";

//Timetable parent login
$route['parent_timetable'] = "parentController/parent_timetable";

//Scorecard parent login
$route['parent_score_card'] = "parentController/parent_score_card";

//School Feed
$route['fetchSchoolForumItems'] = "schoolController/fetchSchoolForumItems";
$route['addTextPostSchool'] = "schoolController/addTextPostSchool";
$route['postSchoolComment'] = "schoolController/postSchoolComment";
$route['deleteSchoolPost'] = "schoolController/deleteSchoolPost";
$route['deleteSchoolComment'] = "schoolController/deleteSchoolComment";
$route['fetchSchoolComments'] = "schoolController/fetchSchoolComments";
$route['getSchoolFeedDetails'] = "schoolController/getSchoolFeedDetails";
$route['uploadSchoolFeedImage'] = "schoolController/uploadSchoolFeedImage";

$route['fetchTeacherDetails'] = "schoolController/fetchTeacherDetails";
$route['fetchStudentDetails'] = "schoolController/fetchStudentDetails";
$route['parent_students'] = "parentController/parent_students";

$route['fetchSchoolNotifications'] = "schoolController/fetchSchoolNotifications";
$route['fetchClassNotifications'] = "schoolController/fetchClassNotifications";

$route['validateLoginREST'] = "schoolController/validateLoginREST";
$route['lastUpdatedREST'] = "schoolController/lastUpdatedREST";
$route['getClassSubjectsREST'] = "schoolController/getClassSubjectsREST";
$route['createClassMetaTextDump'] = "schoolController/createClassMetaTextDump";
$route['createSubjectTextDump'] = "schoolController/createSubjectTextDump";
$route['createClassTextDump'] = "schoolController/createClassTextDump";
$route['fetchTeacherDetailsREST'] = "schoolController/fetchTeacherDetailsREST";
$route['fetchTeacherTTREST'] = "schoolController/fetchTeacherTTREST";
$route['fetchSchoolFeedREST'] = "schoolController/fetchSchoolFeedREST";

//test
$route['getUserDetailsFromSessionID/(:any)'] = "schoolController/getUserDetailsFromSessionID/$1";
$route['deleteSchoolPostREST'] = "schoolController/deleteSchoolPostREST";
$route['addTextPostSchoolREST'] = "schoolController/addTextPostSchoolREST";
$route['uploadSFPicREST'] = "schoolController/uploadSFPicREST";
$route['fetchSchoolNotifsREST'] = "schoolController/fetchSchoolNotifsREST";
$route['fetchSchoolCommentsREST'] = "schoolController/fetchSchoolCommentsREST";
$route['postSchoolCommentREST'] = "schoolController/postSchoolCommentREST";
$route['deleteSFCommentREST'] = "schoolController/deleteSFCommentREST";
$route['getInboxContentREST'] = "schoolController/getInboxContentREST";
$route['markMessageREST'] = "schoolController/markMessageREST";
$route['getMailDetailsREST'] = "schoolController/getMailDetailsREST";
$route['sendMailREST'] = "schoolController/sendMailREST";
$route['parentsREST'] = "schoolController/getParentsREST";
$route['studentsREST'] = "schoolController/getStudentsREST";
$route['getParentsIncREST'] = "schoolController/getParentsIncREST";
$route['getStudentsIncREST'] = "schoolController/getStudentsIncREST";
$route['fetchStudentDetailsREST'] = "schoolController/fetchStudentDetailsREST";
$route['fetchParentDetailsREST'] = "schoolController/fetchParentDetailsREST";
$route['fetchStudentScoresREST'] = "schoolController/fetchStudentScoresREST";
$route['fetchSchoolLoginProfileREST'] = "schoolController/fetchSchoolLoginProfileREST";
$route['saveProfileFieldREST'] = "schoolController/saveProfileFieldREST";
$route['changePasswordREST'] = "schoolController/changePasswordREST";
$route['uploadProfilePicREST'] = "schoolController/uploadProfilePicREST";
$route['fetchClassFeedREST'] = "schoolController/fetchClassFeedREST";

$route['fetchClassCommentsREST'] = "schoolController/fetchClassCommentsREST";
$route['postClassCommentREST'] = "schoolController/postClassCommentREST";
$route['uploadCFPicREST'] = "schoolController/uploadCFPicREST";
$route['deleteClassPostREST'] = "schoolController/deleteClassPostREST";
$route['deleteCFCommentREST'] = "schoolController/deleteCFCommentREST";
$route['addTextPostClassREST'] = "schoolController/addTextPostClassREST";
$route['fetchClassNotifsREST'] = "schoolController/fetchClassNotifsREST";

$route['fetchTeacherProfileREST'] = "schoolController/fetchTeacherProfileREST";
$route['getCurrentTimestamp'] = "schoolController/getCurrentTimestamp";
$route['fetchHomeWorkByClassREST'] = "schoolController/fetchHomeWorkByClassREST";
$route['fetchHomeWorkByTimeREST'] = "schoolController/fetchHomeWorkByTimeREST";
$route['addHomeWorkREST'] = "schoolController/addHomeWorkREST";
$route['editHomeWorkREST'] = "schoolController/editHomeWorkREST";
$route['deleteHomeWorkREST'] = "schoolController/deleteHomeWorkREST";
$route['fetchTeacherTTSelfREST'] = "schoolController/fetchTeacherTTSelfREST";
$route['fetchClassTTREST'] = "schoolController/fetchClassTTREST";
$route['fetchClassTestsREST'] = "schoolController/fetchClassTestsREST";
$route['fetchTestScheduleREST'] = "schoolController/fetchTestScheduleREST";
$route['fetchTestSubjectsREST'] = "schoolController/fetchTestSubjectsREST";
$route['fetchTestScoresREST'] = "schoolController/fetchTestScoresREST";
$route['schoolLoginsREST'] = "schoolController/schoolLoginsREST";
$route['fetchParentProfileREST'] = "schoolController/fetchParentProfileREST";
$route['saveMemoriesREST'] = "schoolController/saveMemoriesREST";
$route['savePushTokenREST'] = "schoolController/savePushTokenREST";
//$route['setupSNSPlatformApp'] = "generalController/setupSNSPlatformApp";
$route['saveStarREST'] = "schoolController/saveStarREST";
$route['fetchStarsREST'] = "schoolController/fetchStarsREST";
$route['saveToDoItemsREST'] = "schoolController/saveToDoItemsREST";
$route['updateToDoItemsREST'] = "schoolController/updateToDoItemsREST";
$route['fetchToDoItemsREST'] = "schoolController/fetchToDoItemsREST";
$route['saveToDoItemREST'] = "schoolController/saveToDoItemREST";
$route['updateToDoItemREST'] = "schoolController/updateToDoItemREST";
$route['getPhpInfo'] = "schoolController/getPhpInfo";
$route['fetchTeacherDashboardREST'] = "schoolController/fetchTeacherDashboardREST";
$route['fetchParentDashboardREST'] = "schoolController/fetchParentDashboardREST";
$route['fetchSchoolLoginDashboardREST'] = "schoolController/fetchSchoolLoginDashboardREST";
$route['fetchUpdatedStudentsREST'] = "schoolController/fetchUpdatedStudentsREST";
$route['fetchUpdatedParentsREST'] = "schoolController/fetchUpdatedParentsREST";
$route['getPrivacySettings'] = "schoolController/getPrivacySettings";
$route['changePrivacy'] = "schoolController/changePrivacy";

//getUserDetailsFromSessionID
//Paathshaala website
$route['ps_home'] = "generalController/ps_home";

/*$route['contacts/(:any)'] = 'contacts/view/$1';
$route['contacts'] = 'contacts';*/

/*$route['default_controller'] = 'pages/view';
$route['(:any)'] = 'pages/view/$1';*/
/* End of file routes.php */
/* Location: ./application/config/routes.php */
