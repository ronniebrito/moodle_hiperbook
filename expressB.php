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


$usehtmleditor = can_use_html_editor();


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
              "$navigation <a href=\"index.php?id=$course->id\">$strbooks</A> ->  <a href=\"view.php?id=$cm->id\"> $book->name </a>  ->  <a href=\"express0.php?id=$cm->id\"> implementa&ccedil;&atilde;o </a> -> adicionando capitulo",
              '',
              '',
              true,
              '',
              ''
            );
			
	
	
	
$qtde_pages = optional_param('qtde_pages', 0, PARAM_INT); 
$titulo = optional_param('titulo', '',PARAM_CLEAN); 
$gravar = optional_param('gravar', 0, PARAM_CLEAN); 


for($i = 1 ; $i <= $qtde_pages; $i++){
	$variavel = 'page_content_'.$i;
	$variavel2 = 'hw_'.$i;	
	$variavel3 = 'tips_'.$i;	
	$variavel4 = 'suggs_'.$i;	
	
	$$variavel    = optional_param('page_content_'.$i, 0, PARAM_INT); //
	$$variavel2    = optional_param('hw_'.$i, 0, PARAM_INT); //
	$$variavel3    = optional_param('tips_'.$i, 0, PARAM_INT); //
	$$variavel4    = optional_param('suggs_'.$i, 0, PARAM_INT); //
	
	for($j = 0 ; $j <6 ; $j++){	
		$variavelX = 'links_'.$i.'_'.$j;		
		$variavelY = 'links_page_'.$i.'_'.$j;				
		$variavelW = 'popup_'.$i.'_'.$j;
		$variavelZ = 'links_anchor_'.$i.'_'.$j;		
		$variavelT = 'navigation_'.$i.'_'.$j;		
		$$variavelX    = optional_param('links_'.$i.'_'.$j, 0, PARAM_INT); //	
		$$variavelY    = optional_param('links_page_'.$i.'_'.$j, 0, PARAM_INT); //				
		$$variavelW    = optional_param('popup_'.$i.'_'.$j, 0, PARAM_INT); //				
		$$variavelZ    = optional_param('links_anchor_'.$i.'_'.$j, 0 , PARAM_CLEAN ); //			
		$$variavelT    = optional_param('navigation_'.$i.'_'.$j, 0, PARAM_INT); //				
	}
}
?>

<?php
if (($form = data_submitted()) && ($gravar>0)) {

//$db->debug = true;
echo 'Gravando';
// grava capitulos



// cria o capitulo 

$chapter->title = $titulo;
$chapter->bookid = $book->id;
$chapter->userid= $USER->id;
$chapter->timecreated = time();
	
$chapterid = insert_record('hiperbook_chapters', $chapter );

for($i = 1 ; $i <= $qtde_pages; $i++){


	$variavel = 'page_content_'.$i;
	$variavel2 = 'hw_'.$i;	
	$variavel3 = 'tips_'.$i;	
	$variavel4 = 'suggs_'.$i;		
		
	$$variavel    = optional_param('page_content_'.$i, 0, PARAM_INT); //	
	$$variavel2    = optional_param('hw_'.$i, 0, PARAM_INT); //
	$$variavel3    = optional_param('tips_'.$i, 0, PARAM_INT); //
	$$variavel4    = optional_param('suggs_'.$i, 0, PARAM_INT); //
	
	// insere as pagina dos capitulo	
	
	if ($variavel ) {
		$page->chapterid = $chapterid;
		$page->idhiperbook = $book->id;
		$page->pagenum = $i;
		$page->content = $form->$variavel;
		$page->userid= $USER->id;
		$page->timecreated = time();
		$page->hidden= 0;
		$page->opentostudents= 0;
				
		$pageid = insert_record('hiperbook_chapters_pages', $page );
		
		
	//	echo $variavel3;
		//var_dump($$variavel3 );
		
		foreach($$variavel2 as $hw ){		
			$pw->idpage = $pageid;
			$pw->idhotword = $hw;
			insert_record('hiperbook_pages_hotwords', $pw);	
		}
			foreach($$variavel3 as $hw ){		
			$pw->idpage = $pageid;
			$pw->idtip = $hw;
			insert_record('hiperbook_pages_tips', $pw);	
		}
			foreach($$variavel4 as $hw ){		
			$pw->idpage = $pageid;
			$pw->idsuggestion = $hw;
			insert_record('hiperbook_pages_suggestions', $pw);	
		}
		
		
		for($j = 0 ; $j <6 ; $j++){	
		
		// cria os links 
		

			$variavelX = 'links_'.$i.'_'.$j;		
			$variavelY = 'links_page_'.$i.'_'.$j;				
			$variavelW = 'popup_'.$i.'_'.$j;
			$variavelZ = 'links_anchor_'.$i.'_'.$j;
			$variavelT = 'navigation_'.$i.'_'.$j;
			
		//var_dump($$variavelX );			
			$db->debug = true;
			if ($$variavelX >0 ) {
				$link->chapterid = $chapterid;
				$link->targetchapterid = $$variavelX;
				// busca o id da pagina com este pagenum
				$target_page = get_record('hiperbook_chapters_pages','pagenum', $$variavelY, 'chapterid', $$variavelX);
				
				if ($target_page) {
					$link->idtargetpageid = $target_page->id;
					$link->targetchapterid = $target_page->chapterid;
					$link->title = $$variavelZ; 
					$link->popup = $$variavelW;
					$link->show_navigation = $$variavelT;
					$link->idpage = $pageid;
					insert_record('hiperbook_chapters_links', $link);					
				
				} 		
			}							
		}
	}
}

//redirect($CFG->wwwroot .'/mod/hiperbook/express0.php?id='.$id);	

}


?>

<p>Definição de capítulos</p>
<form id="form1" name="form1" method="post" action="">
<input type="hidden" name="qtde_pages" value="<?php echo  $qtde_pages ?>" />

<input type="hidden" name="titulo" value="<?php echo  $titulo ?>" />

<input type="hidden" name="id" value="<?php echo  $id ?>" />
<input type="hidden" name="gravar" value="1" />
  <label> <br />
  </label>
  <?php for($i = 1; $i <= $qtde_pages; $i++) { ?>
  
  <table width="100%" border="0">
    <tr>
      <td colspan="4">Conteúdo página <?php echo $i; ?></td>
    </tr>
    <tr>
      <td colspan="4" width="30%">
      
<?php

$d = 'page_content_'.$i;
      print_textarea($usehtmleditor,24, 44, 220, 150, $d, $book->template_main, $course->id);    
?></td>
</tr>
    <tr>
    <td>Glossário</td>
      <td>Dicas</td>
      <td>Bibliografia</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><select name="hw_<?php echo $i; ?>[]" size="6" multiple="multiple" id="hw_3">
        <?php 
	  
	  $hws = get_records_select('hiperbook_chapters_hotword', 'idhiperbook='.$cm->instance, 'id');
	   $tips = get_records_select('hiperbook_chapters_tips', 'idhiperbook='.$cm->instance, 'id');
	    $sugs = get_records_select('hiperbook_chapters_suggestions', 'idhiperbook='.$cm->instance, 'id');
		
		  $links= get_records_select('hiperbook_chapters', 'bookid='.$cm->instance, 'id');
	  
	  
	  foreach($hws as $hw) {
	  ?>
        <option value="<?php echo $hw->id ?>"><?php echo $hw->title ?></option>
        <?php } ?>
      </select></td>
      <td><select name="tips_<?php echo $i; ?>[]" size="6" multiple="multiple" >
        <?php
        foreach($tips as $hw) {
	  ?>
        <option value="<?php echo $hw->id ?>"><?php echo $hw->title ?></option>
        <?php } ?>
      </select></td>
      <td><select name="suggs_<?php echo $i; ?>[]" size="6" multiple="multiple" >
        <?php
	   
	foreach($sugs as $hw) {
	  ?>
        <option value="<?php echo $hw->id ?>"><?php echo $hw->title ?></option>
        <?php } ?>
      </select></td>
      <td style="display:run-in">       </td>
    </tr>
  </table>
    <table>
    <tr>
      <td>Links entre capítulos</td>
      <td>Âncora</td>
      <td><div align="left">Popup</div></td>
      <td><div align="left">Navegação</div></td>
      <td>Página</td>
    </tr>
    <tr>
      <td width="20%"><?php
	   
	   for ($j =0;$j<6;$j++){
	   ?>
        <select name="links_<?php echo $i; ?>_<?php echo $j; ?>">
          <option selected="selected" value="0"></option>
          <?php
			foreach($links as $hw) {
			?>
          <option value="<?php echo $hw->id ?>"><?php echo $hw->title ?> </option>
          <?php		
			 }		
		?>
        </select>
        <?php 
		
	    }	
		?>      </td>
      <td><?php  for ($j =0;$j<6;$j++){
	   ?>
        <input type="text" name="links_anchor_<?php echo $i; ?>_<?php echo $j; ?>" size="50"/> 
        <?php } ?>        </td>
      <td width="10%">
        <div align="left">
          <?php  for ($j =0;$j<6;$j++){
	   ?>
          <input type="checkbox" value="1" name="popup_<?php echo $i; ?>_<?php echo $j; ?>"  /><br />
          <?php } ?>   
        </div></td>
        <td width="10%">
        <div align="left">
          <?php  for ($j =0;$j<6;$j++){
	   ?>
          <input type="checkbox" value="1" name="navigation_<?php echo $i; ?>_<?php echo $j; ?>"  /><br />
          <?php } ?>   
        </div></td>
      <td width="10%"><?php  for ($j =0;$j<6;$j++){
	   ?>
        <input width="25" type="text" name="links_page_<?php echo $i; ?>_<?php echo $j; ?>" value="1"  />
        <?php } ?></td>
    </tr>
  </table>
  
  <?php } ?>
  <hr />
  <label><br />
  <input type="submit" name="button" id="button" value="Submit" />
  <br />
  </label>
  <label></label>
</form>
<iframe id='get_chapter_page' > </iframe>
<?php

if ($usehtmleditor ) {
    use_html_editor();
}
print_footer($course);

?>
