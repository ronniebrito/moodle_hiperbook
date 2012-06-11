<?PHP // $Id: edit.php,v 1.15 2005/07/14 20:58:07 skodak Exp $

require_once('../../config.php');
require_once('lib.php');

$id         = required_param('id', PARAM_INT);           // Course Module ID

// =========================================================================
// security checks START - only teachers edit
// =========================================================================
require_login();

if (!$cm = get_record('course_modules', 'id', $id)) {
    error('Course Module ID was incorrect');
}

if (!$course = get_record('course', 'id', $cm->course)) {
    error('Course is misconfigured');
}

if (!isteacheredit($course->id)) {
    error('Only editing teachers can edit books!', $_SERVER['HTTP_REFERER']);
}

if (!$book = get_record('hiperbook', 'id', $cm->instance)) {
    error('Course module is incorrect');
}
/// Get all required strings
$strbooks = get_string('modulenameplural', 'hiperbook');
$strbook  = get_string('modulename', 'hiperbook');

$navigation = '<a href="../../course/view.php?id='.$course->id.'">'.$course->shortname.'</a> ->';

print_header( "$course->shortname: $book->name",
				  $course->fullname,
				  "$navigation <a href=\"index.php?id=$course->id\">$strbooks</a> -> <a href=\"view.php?id=$cm->id\"> $book->name </a>  -> Modo de implementa&ccedil;&atilde;o",
				  '',
				  '',
				  true,
				  $buttons,
				  null
				);	
			
?>

<p><a href="template0.php?id=<?php echo $id; ?>">Definir templates </a></p>
<p><a href="express1.php?id=<?php echo $id; ?>">Definir biblioteca de Dicas/Biliografia/Comentários</a></p>
<p><a href="expressA.php?id=<?php echo $id; ?>">Criar capitulo</a></p>
<p><a href="parserHyperbook.php?id=<?php echo $id; ?>">Parser</a></p>
<p>&nbsp;</p>
<?php

print_footer($course);

?>
