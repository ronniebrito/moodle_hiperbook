<?PHP // $Id: teacheraccess.php,v 1.6 2005/07/14 20:58:07 skodak Exp $

///standard routine to allow only teachers in
///check of $id and $chapterid parameters

require_once('../../config.php');
require_once('lib.php');

$id        = required_param('id', PARAM_INT);        // Course Module ID

$chapterid = required_param('chapterid', PARAM_INT); // Chapter ID

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


if (!$chapter = get_record('hiperbook_chapters', 'id', $chapterid)) {
    error('Incorrect chapter ID');
}

if ($chapter->bookid != $book->id) {//chapter id not in this book!!!!
    error('Chapter not in this book!');
}
//var_dump($chapter);

//check all variables
unset($id);
//unset($chapterid);

?>
