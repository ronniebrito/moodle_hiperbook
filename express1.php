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
              "$navigation <a href=\"index.php?id=$course->id\">$strbooks</A> ->  <a href=\"view.php?id=$cm->id\"> $book->name </a>  ->  <a href=\"express0.php?id=$cm->id\"> implementa&ccedil;&atilde;o </a> -> definindo Biblioteca ",
              '',
              '',
              true,
              '',
              ''
            );
			
			
?>
<form id="form1" name="form1" method="post" action="express2.php"><input type="hidden" name="id" value="<?php echo $id ?>" />
  <p>Quantidade de Gloss&aacute;rio 
    <label>
    
    <input type="text" name="qtde_hw" id="qtde_hw" />
    </label>
  </p>
  <p>Quantidade de Dicas
    <label>
    <input type="text" name="qtde_tips" id="qtde_tips" />
    </label>
  </p>
  <p>Quantidade de Bibliografia 
    <label>
    <input type="text" name="qtde_biblio" id="qtde_biblio" />
    </label>
    <label>
    <input type="submit" name="button" id="button" value="Submit" />
    </label>
  </p>
</form>
<?php


print_footer($course);

?>