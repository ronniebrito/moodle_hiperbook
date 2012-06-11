<?PHP // $Id: teacheraccess.php,v 1.6 2005/07/14 20:58:07 skodak Exp $

///standard routine to allow only teachers in
///check of $id and $chapterid parameters

require_once('../../config.php');
require_once('lib.php');

$mode = optional_param('mode', 0, PARAM_CLEAN);

$lock = required_param('lock', PARAM_INT);
$navigationid   = optional_param('navigationid', -1, PARAM_INT);
$chapterid   = optional_param('chapterid', -1, PARAM_INT);
$navpathid   = optional_param('navpathid', -1, PARAM_INT);
$pageid   = optional_param('pageid', -1, PARAM_INT);
$bookid = optional_param('bookid', -1, PARAM_INT);
$tipid   = optional_param('tipid', -1, PARAM_INT);

$hotwordid   = optional_param('hotwordid',- 1, PARAM_INT);
$suggestiondid   = optional_param('suggestiondid',- 1, PARAM_INT);

$id        = required_param('id', PARAM_INT);        // Course Module ID

$navigationnum = optional_param('navigationnum',1,PARAM_INT);

require_login();

if (!confirm_sesskey()) {
    error(get_string('confirmsesskeybad', 'error')); 
}

if (!$cm = get_record('course_modules', 'id', $id)) {
    error('Course Module ID was incorrect');
}

if (!$course = get_record('course', 'id', $cm->course)) {
    error('Course is misconfigured');
}

if (!isteacheredit($course->id)) {
    error('Only editing teachers can edit books!');
}

if (!$book = get_record('hiperbook', 'id', $cm->instance)) {
    error('Course module is incorrect');
}



$db->debug=true;



switch ($mode) {
    case 'hiperbook':        
			hiperbook_unlock_hiperbook($bookid, $lock);
			
        break; 
	case 'navpath':        
			hiperbook_unlock_navpath($navpathid, $lock);
			
			
    break;
		
	case 'chapter':
			hiperbook_unlock_chapter($chapterid, $lock);
			
		
							
        break;
		
    case 'page':
			hiperbook_unlock_page($pageid, $lock);
		
		
		
        break;		
    case 'tip':
			hiperbook_unlock_tip($tipid, $lock);
		
		
        break; 
		case 'hotword':
			hiperbook_unlock_hotword($hotwordid, $lock);
		
		
        break; 
		case 'suggestion':
			hiperbook_unlock_suggestion($suggestionid, $lock);
		break;
		
}



add_to_log($course->id, 'course', 'update mod', '../mod/hiperbook/view.php?id='.$cm->id, 'hiperbook '.$book->id);
add_to_log($course->id, 'hiperbook', 'update', 'view.php?id='.$cm->id, $book->id, $cm->id);

 redirect($_SERVER['HTTP_REFERER']);


?>
