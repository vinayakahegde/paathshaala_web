<?php
$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once( $DOC_ROOT . '/application/libraries/MemcacheLibrary.php' );

$school_id = '0';
$inbox_count = "";
$complain_count = "";

if( _MEMCACHE_ENABLED && isset($user_id) ){
    $memcache = new MemcacheLibrary();
    $inbox_count = $memcache->getKey(_INBOX_COUNT . "_" . $school_id . "_" . $user_id );
    $complain_count = $memcache->getKey(_COMPLAIN_COUNT . "_" . $school_id . "_" . $user_id );
    
}

function getMenuClass( $menuOptionUrl ){
    $request_url = trim($_SERVER['REQUEST_URI']);
    $request_url_array = explode("/", $request_url);
    $request_url = trim( $request_url_array[1] );
    $class = "";
    if( $menuOptionUrl == 'home' ){
        if( $request_url == '' || $request_url == 'logout' ){
            $class = 'class="menu_active"';
        }
    } else if( $menuOptionUrl == 'general_information' || $menuOptionUrl == 'events'
                || $menuOptionUrl == 'school_calendar' || $menuOptionUrl == 'code_of_conduct'
                || $menuOptionUrl == 'about_us' || $menuOptionUrl == 'principal'
                || $menuOptionUrl == 'board' || $menuOptionUrl == 'our_teachers'
                || $menuOptionUrl == 'school_tour' || $menuOptionUrl == 'clubs'
                || $menuOptionUrl == 'notifications' || $menuOptionUrl == 'edit_calendar' 
                || $menuOptionUrl == 'edit_school_tests' || $menuOptionUrl == 'search_teachers' 
                || $menuOptionUrl == 'search_students' ){ //edit_notifications, edit_calendar
        if( $request_url == $menuOptionUrl ){
            $class = 'class="dropdown-toggle menu_active"';
        } else {
            $class = 'class="dropdown-toggle"';
        }
    } else {
        if( $request_url == $menuOptionUrl ){
            $class = 'class="menu_active"';
        }
    }
    
    return $class;
    //border-color:#101010; background-color:#333; color:#9d9d9d
    //    background-color: #333;
    //border-color: #101010;
    //color: white
}

?>
<nav class="navbar navbar-inverse navbar-static-top" style="margin-bottom:0px;"> <!-- navbar-default-->
    <div class="container-fluid">
        <div class="navbar-header">
            <!--<p style="color:white;">Menu</p>-->
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#schoolMenu"> 
              <span class = "sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span> 
              <span class="icon-bar"></span> 
            </button>
        </div>
        <div id="schoolMenu" name="schoolMenu" class="collapse navbar-collapse" >
            <ul class="nav navbar-nav">
                <li id="menuHomeOption" class="navbar-btn" style="margin:0px;"><a href="/" id="menuHome" <?php echo getMenuClass( 'home' ); ?> ><strong>Home</strong></a></li>
                <?php if( !isset($user_type) ){  ?>
                <li id="menuOurSchoolOption" class="dropdown" style="margin:0px;">
                    <a data-toggle="dropdown" 
                        <?php if( getMenuClass( 'about_us' ) != 'class="dropdown-toggle"' )
                                echo getMenuClass( 'about_us' );
                              else if( getMenuClass( 'principal' ) != 'class="dropdown-toggle"' )
                                echo getMenuClass( 'principal' );
                              else if( getMenuClass( 'board' ) != 'class="dropdown-toggle"' )
                                echo getMenuClass( 'board' );
                              else
                                echo getMenuClass( 'our_teachers' ); ?> href="#"><strong>Our School</strong>
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-custom">
                        <li><a href="/about_us" id="menuAboutUs" class="dropdown-text-custom">About Us</a></li>
                        <li><a href="/principal" id="menuPrincipal" class="dropdown-text-custom">Principal's Desk</a></li>
                        <li><a href="/board" id="menuBoard" class="dropdown-text-custom">Our Board</a></li>
                        <li><a href="/our_teachers" id="menuOurTeachers" class="dropdown-text-custom">Faculty</a></li>
                    </ul>
                </li> 
                <li id="menuInformationOption" class="dropdown" style="margin:0px;"> <!-- data-hover="dropdown"  -->
                    <a data-toggle="dropdown" 
                        <?php if( getMenuClass( 'school_calendar' ) != 'class="dropdown-toggle"' )
                                echo getMenuClass( 'school_calendar' );
                              else if( getMenuClass( 'general_information' ) != 'class="dropdown-toggle"' )
                                echo getMenuClass( 'general_information' );
                              else if( getMenuClass( 'events' ) != 'class="dropdown-toggle"' )
                                echo getMenuClass( 'events' );
                              else if( getMenuClass( 'code_of_conduct' ) != 'class="dropdown-toggle"' )
                                echo getMenuClass( 'code_of_conduct' ); ?>
                              href="#"><strong>Information</strong>
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-custom">
                        <li><a href="/school_calendar" id="menuSchoolCalendar" class="dropdown-text-custom">School Calendar</a></li>
                        <li><a href="/general_information" id="menuGeneralInformation" class="dropdown-text-custom">General Information</a></li>
                        <li><a href="/events" id="menuEvents" class="dropdown-text-custom">Events</a></li>
                        <li><a href="/code_of_conduct" id="menuCodeOfConduct" class="dropdown-text-custom">Code Of Conduct</a></li>
                    </ul>
                </li> 
                <li id="menuAdmissionsOption" style="margin:0px;"><a href="/admissions" id="menuAdmissions" <?php echo getMenuClass( 'admissions' ); ?> ><strong>Admissions</strong></a></li>
                <li id="menuFacilitiesOption" class="dropdown" style="margin:0px;">
                    <a data-toggle="dropdown" 
                        <?php if( getMenuClass( 'school_tour' ) != 'class="dropdown-toggle"' )
                                echo getMenuClass( 'school_tour' );
                              else if( getMenuClass( 'clubs' ) != 'class="dropdown-toggle"' )
                                echo getMenuClass( 'clubs' ); ?>
                              href="#"><strong>Facilities</strong>
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-custom">
                        <li><a href="/school_tour" id="menuSchoolTour" class="dropdown-text-custom">School Tour</a></li>
                        <li><a href="/clubs" id="menuClubs" class="dropdown-text-custom">Clubs</a></li>
                    </ul>
                </li>
                <li id="menuGalleryOption" style="margin:0px;"><a href="/gallery" id="menuGallery" <?php echo getMenuClass( 'gallery' ); ?> ><strong>Gallery</strong></a></li>
                <li id="menuAlumniOption" style="margin:0px;"><a href="/alumni" id="menuAlumni" <?php echo getMenuClass( 'alumni' ); ?> ><strong>Alumni</strong></a></li>
                <li id="menuBlogOption" style="margin:0px;"><a href="/blog" id="menuBlog" <?php echo getMenuClass( 'blog' ); ?> ><strong>Blog</strong></a></li>
                <?php } else ?>
                <?php if( isset($user_type) && $user_type == _USER_TYPE_SCHOOL ){  ?>
                    <li id="menuInboxOption" style="margin:0px;">
                        <a href="/inbox" id="menuInbox" 
                            <?php echo getMenuClass( 'inbox' ); ?> ><strong>Inbox</strong>
                            <span class="badge" id="inbox_count" style="<?php if( $inbox_count == "" ) echo 'display:none;' ?>">
                                <?php if( $inbox_count != "" ) echo $inbox_count; ?>
                            </span>
                        </a>
                    </li>
                    <li id="menuClassesOption" style="margin:0px;">
                        <a href="/classes" id="menuClasses" 
                            <?php echo getMenuClass( 'classes' ); ?> ><strong>Classes</strong></a>
                    </li>
                    <li id="menuTeachersOption" style="margin:0px;">
                        <a href="/teachers" id="menuTeachers" 
                            <?php echo getMenuClass( 'teachers' ); ?> ><strong>Teachers</strong></a>
                    </li>
                    <li id="menuStudentsOption" style="margin:0px;">
                        <a href="/students" id="menuStudents" 
                            <?php echo getMenuClass( 'students' ); ?> ><strong>Students</strong></a>
                    </li>
                    <li id="menuClassNotifsOption" style="margin:0px;">
                        <a href="/school_class_forum" id="menuClassNotifs" 
                            <?php echo getMenuClass( 'class_notifications' ); ?> ><strong>Class Forums</strong></a>
                    </li>
                    <li id="menuApplicationsOption" style="margin:0px;">
                        <a href="/applications/1/<?php echo _ADMISSION_APPLICATION_PAGE_SIZE; ?>" id="menuApplications" 
                            <?php echo getMenuClass( 'applications' ); ?> ><strong>Applications</strong></a>
                    </li>
                    <li id="menuManageOption" class="dropdown" style="margin:0px;">
                        <a data-toggle="dropdown" 
                            <?php if( getMenuClass( 'notifications' ) != 'class="dropdown-toggle"' )
                                    echo getMenuClass( 'notifications' );
                                  else if( getMenuClass( 'edit_calendar' ) != 'class="dropdown-toggle"' )
                                    echo getMenuClass( 'edit_calendar' );
                                  else if( getMenuClass( 'edit_school_tests' ) != 'class="dropdown-toggle"' )
                                    echo getMenuClass( 'edit_school_tests' );?>
                                  href="#"><strong>Manage</strong>
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-custom">
                            <li><a href="/edit_school_tests" id="menuEditSchoolTests" class="dropdown-text-custom">Tests And Exams</a></li>
                            <li><a href="/notifications/1/<?php echo _GENERAL_NOTIFICATION_PAGE_SIZE; ?>" id="menuEditNotifications" class="dropdown-text-custom">General Notifications</a></li>
                            <li><a href="/edit_calendar" id="menuEditCalendar" class="dropdown-text-custom">School Calendar</a></li>
                        </ul>
                    </li>
                    <!-- <li id="menuNotificationsOption" style="margin:0px;">
                        <a href="/notifications/1/<?php echo _GENERAL_NOTIFICATION_PAGE_SIZE; ?>" id="menuNotifications" 
                            <?php echo getMenuClass( 'notifications' ); ?> ><strong>Notifications</strong></a>
                    </li> -->
                <?php } else if( isset($user_type) && $user_type == _USER_TYPE_ADMIN ){ ?>
                        <li id="menuAddClassesOption" style="margin:0px;">
                            <a href="/addClasses" id="menuAddClasses" 
                                <?php echo getMenuClass( 'addClasses' ); ?> ><strong>Add Classes</strong></a>
                        </li> 
                        <li id="menuAddStudentsOption" style="margin:0px;">
                            <a href="/addStudents" id="menuAddStudents" 
                                <?php echo getMenuClass( 'addStudents' ); ?> ><strong>Add Students</strong></a>
                        </li>
                        <li id="menuAddTestsOption" style="margin:0px;">
                            <a href="/addTests" id="menuAddTests" 
                                <?php echo getMenuClass( 'addTests' ); ?> ><strong>Add Tests</strong></a>
                        </li>
                <?php } else if( isset($user_type) && $user_type == _USER_TYPE_PARENT ){ ?>
                    <li id="menuInboxOption" style="margin:0px;">
                        <a href="/inbox" id="menuInbox" 
                            <?php echo getMenuClass( 'inbox' ); ?> ><strong>Inbox</strong>
                            <span class="badge" id="inbox_count" style="<?php if( $inbox_count == "" ) echo 'display:none;' ?>">
                                <?php if( $inbox_count != "" ) echo $inbox_count; ?>
                            </span>
                        </a>
                    </li>
                    <li id="menuParentTTOption" style="margin:0px;">
                        <a href="/parent_timetable" id="menuPTT" 
                            <?php echo getMenuClass( 'parent_timetable' ); ?> ><strong>Timetable</strong>
                        </a>
                    </li>
                    <li id="menuParentHWOption" style="margin:0px;">
                        <a href="/parent_home_work" id="menuParentHW" 
                            <?php echo getMenuClass( 'parent_home_work' ); ?> ><strong>Home Work</strong></a>
                    </li>
                    <li id="menuParentSCOption" style="margin:0px;">
                        <a href="/parent_score_card" id="menuParentSC" 
                            <?php echo getMenuClass( 'parent_score_card' ); ?> ><strong>Score Cards</strong></a>
                    </li>
                    <li id="menuTeachersOption" style="margin:0px;">
                        <a href="/teachers" id="menuTeachers" 
                            <?php echo getMenuClass( 'teachers' ); ?> ><strong>Teachers</strong></a>
                    </li>
                    <li id="menuParenStudentsOption" style="margin:0px;">
                        <a href="/parent_students" id="menuParentSC" 
                            <?php echo getMenuClass( 'parent_students' ); ?> ><strong>Students</strong></a>
                    </li>
                <?php } else if( isset($user_type) && $user_type == _USER_TYPE_TEACHER ){ ?>
                    <li id="menuInboxOption" style="margin:0px;">
                        <a href="/inbox" id="menuInbox" 
                            <?php echo getMenuClass( 'inbox' ); ?> ><strong>Inbox</strong>
                            <span class="badge" id="inbox_count" style="<?php if( $inbox_count == "" ) echo 'display:none;' ?>">
                                <?php if( $inbox_count != "" ) echo $inbox_count; ?>
                            </span>
                        </a>
                    </li>
                    <li id="menuClassForumOption" style="margin:0px;">
                        <a href="/class_forum" id="menuTest" 
                            <?php echo getMenuClass( 'class_forum' ); ?> ><strong>Class Forum</strong>
                        </a>
                    </li>
                    <li id="menuHomeWorkOption" style="margin:0px;">
                        <a href="/home_work" id="menuHomeWork" 
                            <?php echo getMenuClass( 'home_work' ); ?> ><strong>Home Work</strong></a>
                    </li>
                    <li id="menuSyllabusOption" style="margin:0px;">
                        <a href="/teacher_syllabus" id="menuSyllabus" 
                            <?php echo getMenuClass( 'teacher_syllabus' ); ?> ><strong>Syllabus</strong>
                        </a>
                    </li>
                    <li id="menuTestOption" style="margin:0px;">
                        <a href="/teacher_test" id="menuTest" 
                            <?php echo getMenuClass( 'teacher_test' ); ?> ><strong>Tests</strong>
                        </a>
                    </li>
                    <li id="menuTeacherTTOption" style="margin:0px;">
                        <a href="/teacher_timetable" id="menuTTT" 
                            <?php echo getMenuClass( 'teacher_timetable' ); ?> ><strong>Timetable</strong>
                        </a>
                    </li>
                    <li id="menuSearchOption" class="dropdown" style="margin:0px;">
                        <a data-toggle="dropdown" 
                            <?php if( getMenuClass( 'search_teachers' ) != 'class="dropdown-toggle"' )
                                    echo getMenuClass( 'search_teachers' );
                                  else if( getMenuClass( 'search_students' ) != 'class="dropdown-toggle"' )
                                    echo getMenuClass( 'search_students' );?>
                                  href="#"><strong>Search</strong>
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-custom">
                            <li><a href="/search_teachers" id="menuSearchTeachers" class="dropdown-text-custom">Teachers</a></li>
                            <li><a href="/search_students" id="menuSearchStudents" class="dropdown-text-custom">Students</a></li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>    