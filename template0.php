<?PHP // $Id: edit.php,v 1.15 2005/07/14 20:58:07 skodak Exp $

require_once('../../config.php');
require_once('lib.php');

$id         = required_param('id', PARAM_INT);           // Course Module ID



// =========================================================================
// security checks START - only teachers edit
// =========================================================================
require_login();

//$db->debug = true;

if ($CFG->forcelogin) {
    require_login();
}

if (!$cm = get_record('course_modules', 'id', $id)) {
    error('Course Module ID is incorrect');
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

if (!file_exists($CFG->dataroot.'/'.$course->id.'/template_hiperbook'.$book->id)){ 				
	mkdir($CFG->dataroot.'/'.$course->id.'/template_hiperbook'.$book->id);
}

/// If data submitted, then process and store.
if (($form = data_submitted()) ) {


    //TODO: skip it for now
	
	
	// 3237 2659 3233 2979 9962 7131
	
	 	
		//var_dump($_FILES); die();
		 
        check_dir_exists($CFG->dataroot.'/'.$dir, true, true); // better to create now so that student submissions do not block it later
        require_once($CFG->dirroot.'/lib/uploadlib.php');
	
	
	if ($_FILES['img_hotwords_top']['tmp_name']) {
		echo $_FILES['img_hotwords_top']['tmp_name'],$CFG->dataroot.'/'.$course->id.'/template_hiperbook'.$book->id.'/'. $_FILES['img_hotwords_top']['name'];
	copy( $_FILES['img_hotwords_top']['tmp_name'],$CFG->dataroot.'/'.$course->id.'/template_hiperbook'.$book->id.'/'. $_FILES['img_hotwords_top']['name']);	    
	$book->img_hotwords_top =  $_FILES['img_hotwords_top']['name'];
	}
	if ($_FILES['img_tips_top']['tmp_name']) {				  
		copy( $_FILES['img_tips_top']['tmp_name'],$CFG->dataroot.'/'.$course->id.'/template_hiperbook'.$book->id.'/'. $_FILES['img_tips_top']['name']);	
    $book->img_tips_top =  $_FILES['img_tips_top']['name'];
	}
	
	if ($_FILES['img_suggestions_top']['tmp_name']) {	
		copy( $_FILES['img_suggestions_top']['tmp_name'],$CFG->dataroot.'/'.$course->id.'/template_hiperbook'.$book->id.'/'. $_FILES['img_suggestions_top']['name']);	
    $book->img_suggestions_top =  $_FILES['img_suggestions_top']['name'];
	}
	
	if ($_FILES['img_links_top']['tmp_name']) {	
		copy( $_FILES['img_links_top']['tmp_name'],$CFG->dataroot.'/'.$course->id.'/template_hiperbook'.$book->id.'/'. $_FILES['img_links_top']['name']);	
    $book->img_links_top =  $_FILES['img_links_top']['name'];
	}
	
	
	if ($_FILES['img_hotwords_icon']['tmp_name']) {	
		copy( $_FILES['img_hotwords_icon']['tmp_name'],$CFG->dataroot.'/'.$course->id.'/template_hiperbook'.$book->id.'/'. $_FILES['img_hotwords_icon']['name']);	
    $book->img_hotwords_icon =  $_FILES['img_hotwords_icon']['name'];
	}
	
	if ($_FILES['img_tips_icon']['tmp_name']) {	
		copy( $_FILES['img_tips_icon']['tmp_name'],$CFG->dataroot.'/'.$course->id.'/template_hiperbook'.$book->id.'/'. $_FILES['img_tips_icon']['name']);	
    $book->img_tips_icon =  $_FILES['img_tips_icon']['name'];
	}
	
	if ($_FILES['img_suggestions_icon']['tmp_name']) {
		copy( $_FILES['img_suggestions_icon']['tmp_name'],$CFG->dataroot.'/'.$course->id.'/template_hiperbook'.$book->id.'/'. $_FILES['img_suggestions_icon']['name']);	
    $book->img_suggestions_icon =  $_FILES['img_suggestions_icon']['name'];
	}
	
	
	if ($_FILES['img_links_icon']['tmp_name']) {	
		copy( $_FILES['img_links_icon']['tmp_name'],$CFG->dataroot.'/'.$course->id.'/template_hiperbook'.$book->id.'/'. $_FILES['img_links_icon']['name']);	
    $book->img_links_icon =  $_FILES['img_links_icon']['name'];
	}
	
	if ($_FILES['img_top_popup']['tmp_name']) {	
		copy( $_FILES['img_top_popup']['tmp_name'],$CFG->dataroot.'/'.$course->id.'/template_hiperbook'.$book->id.'/'. $_FILES['img_top_popup']['name']);	
    	$book->img_top_popup =  $_FILES['img_top_popup']['name'];
	}
	
	if ($_FILES['img_page_prev']['tmp_name']) {	
		copy( $_FILES['img_page_prev']['tmp_name'],$CFG->dataroot.'/'.$course->id.'/template_hiperbook'.$book->id.'/'. $_FILES['img_page_prev']['name']);	
    $book->img_page_prev =  $_FILES['img_page_prev']['name'];
	}
	
	if ($_FILES['img_page_next']['tmp_name']) {	
		copy( $_FILES['img_page_next']['tmp_name'],$CFG->dataroot.'/'.$course->id.'/template_hiperbook'.$book->id.'/'. $_FILES['img_page_next']['name']);	
    $book->img_page_next =  $_FILES['img_page_next']['name'];
	}
	
	if ($_FILES['img_separador_toc']['tmp_name']) {	
		copy( $_FILES['img_separador_toc']['tmp_name'],$CFG->dataroot.'/'.$course->id.'/template_hiperbook'.$book->id.'/'. $_FILES['img_separador_toc']['name']);	
    $book->img_separador_toc =  $_FILES['img_separador_toc']['name'];
	}
	
	if ($_FILES['img_navpath_active_start']['tmp_name']) {	
		copy( $_FILES['img_navpath_active_start']['tmp_name'],$CFG->dataroot.'/'.$course->id.'/template_hiperbook'.$book->id.'/'. $_FILES['img_navpath_active_start']['name']);	
    $book->img_navpath_active_start =  $_FILES['img_navpath_active_start']['name'];
	}
	if ($_FILES['img_navpath_active_middle']['tmp_name']) {	
		copy( $_FILES['img_navpath_active_middle']['tmp_name'],$CFG->dataroot.'/'.$course->id.'/template_hiperbook'.$book->id.'/'. $_FILES['img_navpath_active_middle']['name']);	
    $book->img_navpath_active_middle=  $_FILES['img_navpath_active_middle']['name'];
	}
	if ($_FILES['img_navpath_active_end']['tmp_name']) {	
		copy( $_FILES['img_navpath_active_end']['tmp_name'],$CFG->dataroot.'/'.$course->id.'/template_hiperbook'.$book->id.'/'. $_FILES['img_navpath_active_end']['name']);	
    $book->img_navpath_active_end =  $_FILES['img_navpath_active_end']['name'];
	}
	
	if ($_FILES['img_navpath_inactive_start']['tmp_name']) {	
		copy( $_FILES['img_navpath_inactive_start']['tmp_name'],$CFG->dataroot.'/'.$course->id.'/template_hiperbook'.$book->id.'/'. $_FILES['img_navpath_inactive_start']['name']);	
    $book->img_navpath_inactive_start =  $_FILES['img_navpath_inactive_start']['name'];
	}
	if ($_FILES['img_navpath_inactive_middle']['tmp_name']) {	
		copy( $_FILES['img_navpath_inactive_middle']['tmp_name'],$CFG->dataroot.'/'.$course->id.'/template_hiperbook'.$book->id.'/'. $_FILES['img_navpath_inactive_middle']['name']);	
    $book->img_navpath_inactive_middle=  $_FILES['img_navpath_inactive_middle']['name'];
	}
	if ($_FILES['img_navpath_inactive_end']['tmp_name']) {	
		copy( $_FILES['img_navpath_inactive_end']['tmp_name'],$CFG->dataroot.'/'.$course->id.'/template_hiperbook'.$book->id.'/'. $_FILES['img_navpath_inactive_end']['name']);	
    $book->img_navpath_inactive_end =  $_FILES['img_navpath_inactive_end']['name'];
	}
	
	
		 $book->template_main = $form->template_main;   
	 	 $book->template_hw = $form->template_hw;   
		 	 $book->template_tips = $form->template_tips;   
			 	 $book->template_suggs = $form->template_suggs;  				 
			 	  $book->template_css = $form->template_css;   
				  
				 
				  
	     if (!update_record('hiperbook', $book,$cm->instance)) {
            error('Could not update your hiperbook!');
         }
	
		 //redirect($CFG->wwwroot."/mod/hiperbook/template0.php?id=".$id);
}



if (!$book = get_record('hiperbook', 'id', $cm->instance)) {
    error('Course module is incorrect');
}


$strbook = get_string('modulename', 'hiperbook');
$strbooks = get_string('modulenameplural', 'hiperbook');
$stredit = get_string('edit'). ' templates';
$pageheading = get_string('editingpage', 'hiperbook');
///prepare the page header
///prepare the page header
/// Get all required strings
$strbooks = get_string('modulenameplural', 'hiperbook');
$strbook  = get_string('modulename', 'hiperbook');

/// Print the header
if ($course->category) {
    $navigation = '<a href="../../course/view.php?id='.$course->id.'">'.$course->shortname.'</a> ->';
} else {
    $navigation = '';
}

print_header( "$course->shortname: $strbooks",
               $course->fullname,
               "$navigation $strbooks",
               '',
               '',
               true,
               '',
               navmenu($course)
             );

			
				
?>

<form action="template0.php" method="post" enctype="multipart/form-data"> 
<input type="hidden" name="id" value="<?php echo $id; ?>"

<p>Definição de templates</p>
<p>Template de páginas padrão</p>

<?php

$usehtmleditor = can_use_html_editor();

if($book->template_main ) {

print_textarea($usehtmleditor, 24, 64, 320, 150, 'template_main', $book->template_main, $course->id);    
}


?>
<p>Template de Glossário</p>
<?php

$usehtmleditor = can_use_html_editor();



print_textarea($usehtmleditor, 24, 64, 320, 150, 'template_hw', $book->template_hw, $course->id);    

?>
<p>Template de Coment&aacute;rio</p>
<?php

print_textarea($usehtmleditor, 24, 64, 320, 150, 'template_tips', $book->template_tips, $course->id);    

?>
<p>Template de Bibliografia</p>
<?php



print_textarea($usehtmleditor, 24, 64, 320, 150, 'template_suggs', $book->template_suggs, $course->id);    

?>

<p>CSS</p>
<p>
  <?php
if ($usehtmleditor ) {
    use_html_editor();
	
}
?>
  <textarea name="template_css" cols="64" rows="20"><?php echo $book->template_css; ?></textarea>
</p>
<p>Cabeçalhos </p>
<p><img src="<?php echo $CFG->wwwroot.'/file.php/'.$cm->course.'/template_hiperbook' .$book->id."/". $book->img_hotwords_top ?>"  /> </p>
<p>Glossario 
  <input type="file" name="img_hotwords_top" />
</p>
<p><img src="<?php echo $CFG->wwwroot.'/file.php/'.$cm->course.'/template_hiperbook' .$book->id."/". $book->img_tips_top ?>"  /> </p>
<p>Dicas 
  <input type="file" name="img_tips_top"  />
</p>
<p><img src="<?php echo $CFG->wwwroot.'/file.php/'.$cm->course.'/template_hiperbook' .$book->id."/". $book->img_suggestions_top ?>"  /> </p>
<p>Bibliografia 
  <input type="file" name="img_suggestions_top" />
</p>
<p><img src="<?php echo $CFG->wwwroot.'/file.php/'.$cm->course.'/template_hiperbook' .$book->id."/". $book->img_links_top ?>"  /> </p>
<p>Links 
  <input type="file" name="img_links_top"  />
</p>
<p><img src="<?php echo $CFG->wwwroot.'/file.php/'.$cm->course.'/template_hiperbook' .$book->id."/". $book->img_top_popup ?>"  /> </p>
<p>Topo de popup 
  <input type="file" name="img_top_popup"  />
 </p>

<p>Ícones</p>
<p><img src="<?php echo $CFG->wwwroot.'/file.php/'.$cm->course.'/template_hiperbook' .$book->id."/". $book->img_hotwords_icon ?>"  /> </p>
<p>Glossario 
  <input type="file" name="img_hotwords_icon" />
</p>
<p><img src="<?php echo $CFG->wwwroot.'/file.php/'.$cm->course.'/template_hiperbook' .$book->id."/". $book->img_tips_icon ?>"  /> </p>
<p>Dicas 
  <input type="file" name="img_tips_icon"  />
</p>
<p><img src="<?php echo $CFG->wwwroot.'/file.php/'.$cm->course.'/template_hiperbook' .$book->id."/". $book->img_suggestions_icon ?>"  /> </p>
<p>Bibliografia 
  <input type="file" name="img_suggestions_icon" />
</p>
<p><img src="<?php echo $CFG->wwwroot.'/file.php/'.$cm->course.'/template_hiperbook' .$book->id."/". $book->img_links_icon ?>"  /> </p>
<p>Links 
  <input type="file" name="img_links_icon"  />
 </p>


 
 <p><img src="<?php echo $CFG->wwwroot.'/file.php/'.$cm->course.'/template_hiperbook' .$book->id."/". $book->img_page_prev ?>"  /> </p>
<p>Anterior 
  <input type="file" name="img_page_prev"  />
 </p>
 <p><img src="<?php echo $CFG->wwwroot.'/file.php/'.$cm->course.'/template_hiperbook' .$book->id."/". $book->img_page_next ?>"  /> </p>
<p>Pr&oacute;ximo 
  <input type="file" name="img_page_next"  />
 </p>
 <p><img src="<?php echo $CFG->wwwroot.'/file.php/'.$cm->course.'/template_hiperbook' .$book->id."/". $book->img_separador_toc ?>"  /> </p>
<p>Separador TOC 
  <input type="file" name="img_separador_toc"  />
 </p>
 
 
<p>Imagens dos Caminhos de Navega&ccedil;&atilde;o (Selecionado)</p>
 
  <p> Aqui
  <img src="<?php echo $CFG->wwwroot.'/file.php/'.$cm->course.'/template_hiperbook' .$book->id."/". $book->img_navpath_active_start ?>"  />
  <img src="<?php echo $CFG->wwwroot.'/file.php/'.$cm->course.'/template_hiperbook' .$book->id."/". $book->img_navpath_active_middle ?>"  />
  <img src="<?php echo $CFG->wwwroot.'/file.php/'.$cm->course.'/template_hiperbook' .$book->id."/". $book->img_navpath_active_end ?>"  /> </p>
  
<p> <input type="file" name="img_navpath_active_start"  />
  <input type="file" name="img_navpath_active_middle"  />
   <input type="file" name="img_navpath_active_end"  />
 </p>


<p>Imagens dos Caminhos de Navega&ccedil;&atilde;o (N&atilde;o -selecionado)</p> 
  <p>
  <img src="<?php echo $CFG->wwwroot.'/file.php/'.$cm->course.'/template_hiperbook' .$book->id."/". $book->img_navpath_inactive_start ?>"  />
  <img src="<?php echo $CFG->wwwroot.'/file.php/'.$cm->course.'/template_hiperbook' .$book->id."/". $book->img_navpath_inactive_middle ?>"  />
  <img src="<?php echo $CFG->wwwroot.'/file.php/'.$cm->course.'/template_hiperbook' .$book->id."/". $book->img_navpath_inactive_end ?>"  /> </p>
  
<p> <input type="file" name="img_navpath_inactive_start"  />
  <input type="file" name="img_navpath_inactive_middle"  />
   <input type="file" name="img_navpath_inactive_end"  />
 </p>
 
<p>
  <input type="submit">
</p>
</form>
<?php


print_footer($course);

?>