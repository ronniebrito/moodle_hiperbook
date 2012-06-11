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

$strbook = get_string('modulename', 'hiperbook');
$strbooks = get_string('modulenameplural', 'hiperbook');
$stredit = get_string('edit'). ' templates';
$pageheading = get_string('editingpage', 'hiperbook');

if ($course->category) {
    $navigation = '<a href="../../course/view.php?id='.$course->id.'">'.$course->shortname.'</a> ->';
} else {
    $navigation = '';
}

print_header( "$course->shortname: $book->name",
              $course->fullname,
              "$navigation <a href=\"index.php?id=$course->id\">$strbooks</A> ->  <a href=\"view.php?id=$cm->id\"> $book->name </a>  ->  <a href=\"express0.php?id=$cm->id\"> implementa&ccedil;&atilde;o </a> -> criando cap&iacute;tulo",
              '',
              '',
              true,
              '',
              ''
            );
			
			
?>
<p>Criação de capítulo</p>
<form id="form1" name="form1" method="post" action="expressB.php">


    <input type="hidden" name="id" value="<?php echo $id ?>" />
  <p>Título</p>
  <p>
    <input name="titulo" type="text"  size="100" />
  </p>
  <p>Quantidade de páginas
  </p>
  <label>
  <input type="text" name="qtde_pages" id="qtde_pages" />
  <br>
  </label>
  <label>
  <input type="submit" name="button" id="button" value="Submit" />
  </label>
</form>
<?php


print_footer($course);

?>