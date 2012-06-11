<?PHP // $Id: view.php,v 1.17 2005/08/25 19:33:12 skodak Exp $
	
	
require_once('../../config.php');
require_once('lib.php');


$id        = required_param('id', PARAM_INT);           // Course Module ID



// =========================================================================
// security checks START - teachers edit; students view
// =========================================================================

if ($CFG->forcelogin) {
    require_login();
}

if (!$cm = get_record('course_modules', 'id', $id)) {
    error('Course Module ID is incorrect');
}

if (!$course = get_record('course', 'id', $cm->course)) {
    error('Course is misconfigured');
}

if (!$book = get_record('hiperbook', 'id', $cm->instance)) {
    error('Course module is incorrect');
}
print_header( "$course->shortname: $book->name",
				  $course->fullname,
				  "$navigation <a href=\"index.php?id=$course->id\">$strbooks</a> -> $book->name",
				  '',
				  '<style type="text/css">@import url('.$CFG->wwwroot.'/mod/hiperbook/book_theme.css);</style>',
				  true,
				  $buttons,
				  navmenu($course, $cm)
				);	
				
			hiperbook_to_scorm($id);
				
			
print_footer($course);
?>