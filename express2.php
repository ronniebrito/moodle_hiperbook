<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?PHP // $Id: edit.php,v 1.15 2005/07/14 20:58:07 skodak Exp $

require_once('../../config.php');
require_once('lib.php');

$id         = required_param('id', PARAM_INT);           // Course Module ID

$gravar = optional_param('gravar', 0, PARAM_INT); 


$qtde_biblio = optional_param('qtde_biblio', 0, PARAM_INT); 
$qtde_hw      = optional_param('qtde_hw', 0, PARAM_INT); 
$qtde_tips     = optional_param('qtde_tips', 0, PARAM_INT); 

for($i = 1 ; $i <= $qtde_biblio; $i++){
	$variavel = 'suggestion_title'.$i;
	$variavel2 = 'suggestion'.$i;	
	$$variavel    = optional_param('suggestion_title'.$i, 0); //
	$$variavel2    = optional_param('suggestion'.$i, 0); //
}

for($i = 1 ; $i <= $qtde_hw; $i++){
	$variavel = 'hotword_title'.$i;
	$variavel2 = 'hotword'.$i;	
	$$variavel    = optional_param('hotword_title'.$i, 0); //
	$$variavel2    = optional_param('hotword'.$i, 0); //
}

for($i = 1 ; $i <= $qtde_tips; $i++){
	$variavel = 'tip_title'.$i;
	$variavel2 = 'tip'.$i;	
	$$variavel    = optional_param('tip_title'.$i, 0); //
	$$variavel2    = optional_param('tip'.$i, 0); //
}



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


/// If data submitted, then process and store.
if ( ($form = data_submitted() )& $gravar) {
    //TODO: skip it for now
	
//	$db->debug =true;
	// insere os registros 	 
	 
	for($i =1 ; $i <= $qtde_hw; $i++ ){	
		$variavel = 'hotword'.$i;
		$variavel2 = 'hotword_title'.$i;		
		$element->content = $$variavel;
		$element->title = $$variavel2;
		$element->hotwordnum = $i;
		$element->idhiperbook = $cm->instance;
		$element->groupid = 0;
		$element->userid = $USER->id;
		$element->opentostudents = 0;		
		 if(!$newid = insert_record('hiperbook_chapters_hotword',$element)) {
			  error('Could not update your hiperbook!');
		 }		
	}
	  
	  	for($i =1 ; $i <= $qtde_biblio; $i++ ){	
		$variavel = 'suggestion'.$i;
		$variavel2 = 'suggestion_title'.$i;		
		$element->content = $$variavel;
		$element->title = $$variavel2;
		$element->hotwordnum = $i;
		$element->idhiperbook = $cm->instance;
		$element->groupid = 0;
		$element->userid = $USER->id;
		$element->opentostudents = 0;		
		 if(!$newid = insert_record('hiperbook_chapters_suggestions',$element)) {
			  error('Could not update your hiperbook!');
		 }		
	}
	
		for($i =1 ; $i <= $qtde_tips; $i++ ){	
		$variavel = 'tip'.$i;
		$variavel2 = 'tip_title'.$i;		
		$element->content = $$variavel;
		$element->title = $$variavel2;
		$element->hotwordnum = $i;
		$element->idhiperbook = $cm->instance;
		$element->groupid = 0;
		$element->userid = $USER->id;
		$element->opentostudents = 0;		
		 if(!$newid = insert_record('hiperbook_chapters_tips',$element)) {
			  error('Could not update your hiperbook!');
		 }		
	}
	
	
	 redirect($CFG->wwwroot."/mod/hiperbook/express0.php?id=".$id);
      
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
<form id="form1" name="form1" method="post" action="express2.php">
<input type="hidden" name="id" value="<?php echo $id ?>"   />
<input type="hidden" name="qtde_hw" value="<?php echo $qtde_hw ?>"   />

<input type="hidden" name="gravar" value="1"   />

<input type="hidden" name="qtde_tips" value="<?php echo $qtde_tips ?>"   />

<input type="hidden" name="qtde_biblio" value="<?php echo $qtde_biblio ?>"   />

 <p>Glossario</p>
  

  <?php 
  
  for($i=1;$i<=$qtde_hw;$i++){


	echo '<input type="text" name="hotword_title'.$i.'" /><br>';
  		
		$d = 'hotword'.$i;
	print_textarea($usehtmleditor, 14, 44, 220, 150, $d, $book->template_hw, $course->id);    


	echo '<br>';


		
	}
   ?> 
  <p>Dicas</p>
  <p><?php 
  
  for($i=1;$i<=$qtde_tips;$i++){


	echo '<input type="text" name="tip_title'.$i.'" /><br>';
  		
	print_textarea($usehtmleditor, 14, 44, 220, 150, 'tip'.$i, $book->template_tips, $course->id);    


	echo '<br>';

	}
	
   ?> 
  <p>Bibliografias</p>
<?php 
  
  for($i=1;$i<=$qtde_biblio;$i++){


	echo '<input type="text" name="suggestion_title'.$i.'" /><br>';
  		
	print_textarea($usehtmleditor, 14, 44, 220, 150, 'suggestion'.$i, $book->template_suggs, $course->id);    


	echo '<br>';

	}
	
if ($usehtmleditor ) {
    use_html_editor();
}
   ?> 
  <p>
    <label>
    <input type="submit" name="button" id="button" value="Submit" />
    </label>
</p>
</form>
<p>&nbsp;</p>
</body>
</html>
