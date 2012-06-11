<?PHP // $Id: view.php,v 1.17 2005/08/25 19:33:12 skodak Exp $


require_once('../../config.php');
require_once('lib.php');

//die();



$id        = required_param('id', PARAM_INT);           // Course Module ID


// =========================================================================
// security checks START - teachers edit; students view
// =========================================================================

if (!$cm = get_record('course_modules', 'id', $id)) {
    error('Course Module ID is incorrectss');
}

if (!$course = get_record('course', 'id', $cm->course)) {
    error('Course is misconfigured');
}

if (!$book = get_record('hiperbook', 'id', $cm->instance)) {
    error('Course module is incorrect');
}


$navigation = '<a href="../../course/view.php?id='.$course->id.'">'.$course->shortname.'</a> ->';

$strbooks = get_string('modulenameplural', 'hiperbook');
	$strbook  = get_string('modulename', 'hiperbook');
	$strTOC = get_string('TOC', 'hiperbook');

print_header( "$course->shortname: $book->name",
				  $course->fullname,
				  "$navigation <a href=\"index.php?id=$course->id\">$strbooks</a> -> $book->name",
				  '',
				  '',
				  true,
				  $buttons,
				  navmenu($course, $cm)
				);	
				
			hiperbook_to_html($cm->id);
				
			
print_footer($course);
?>
