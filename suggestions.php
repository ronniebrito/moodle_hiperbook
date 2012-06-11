<?PHP // $Id: view.php,v 1.17 2005/08/25 19:33:12 skodak Exp $

require_once('../../config.php');
require_once('lib.php');

//var_dump($CFG);

//$db->debug = true;

$groupid = required_param('groupid', PARAM_INT); 
$pageid = required_param('pageid', PARAM_INT); 
$chapterid = required_param('chapterid', PARAM_INT); 
$id = 	required_param('id', PARAM_INT); //cm id
$edit      = optional_param('edit', -1, PARAM_BOOL);     // Edit mode
$suggestionid      = optional_param('suggestionid', -1, PARAM_INT);     // View mode
$delete      = optional_param('delete', 0, PARAM_INT);     // delete mode
$backbtn      = optional_param('backbtn', 0, PARAM_INT);     // delete mode

$add = optional_param('add', 0, PARAM_INT);     // View mode


require_login();


if (!$cm = get_record('course_modules', 'id', $id)) {
    error('Course Module ID was incorrect');
}
if (!$course = get_record('course', 'id', $cm->course)) {
    error('Course is misconfigured');
}

if (!$book = get_record('hiperbook', 'id', $cm->instance)) {
    error('Course module is incorrect');
}

if (!$page = get_record('hiperbook_chapters_pages', 'id', $pageid)) {
    error('Page incorrect');
}

if (!isteacheredit($course->id)and (!$page->opentostudents)) {
    error('Unable to edit!', $_SERVER['HTTP_REFERER']);
}

$usehtmleditor = can_use_html_editor();
print_header( "",null,
				  "",
				  '',
				  '<style type="text/css">@import url('.$CFG->wwwroot.'/mod/hiperbook/book_theme.css);</style>',
				  true,
				  null,
				  null
				);

?>
<style type="text/css">
<!--

body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}

.corpotexto {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #003366; text-align: left; line-height: 15px}

	
	<?php
echo $CFG->default_template_css;
echo $book->template_css;
?>
-->
</style>
<div id='topo_suggestion'><div id='topo_hotword'><img src="<?php echo $CFG->wwwroot."/file.php/".$course->id."/template_hiperbook". $book->id."/".$book->img_suggestions_top ?>" /></div></div>
<p>
  <?php 

	$strdesc = get_string('suggestion', 'hiperbook');
echo $strdesc;	
?>
  <br />
  <a href="bibliography.php?id=<?php echo $cm->id; ?> ">Ver bibliografia completa</a></p>
<p>
  <?php
if($delete){
	delete_records('hiperbook_pages_suggestions', 'idsuggestion', $suggestionid, 'idpage', $pageid);
}

$suggestion = get_record('hiperbook_chapters_suggestions', 'id', $suggestionid);

if (($form = data_submitted()) && (confirm_sesskey())) {


	$suggestion->content = $form->content;
	$suggestion->title = $form->title;
	$suggestion->chapterid= $form->chapterid;	
	$suggestion->suggestionnum= $form->suggestionnum;	
	$suggestion->idpage = $form->pageid;	
	$suggestion->idhiperbook = $book->id;	
	$suggestion->opentostudents = $page->opentostudents;
	$suggestion->groupid = $form->groupid;
	$suggestion->userid= $USER->id;
		
	if ($form->suggestionid_existent ==0){ 		
		 $suggestion->content = stripslashes($suggestion->content );
		if ($suggestion->id >0) { // editando	
			$backbtn=1;
			if (!update_record('hiperbook_chapters_suggestions', $suggestion)) {
				error('Could not update your suggestion!!!');
			}else{
			  echo "updated";
			}
		}else{ // criando uma nova -> insert
			if (!$suggestion->id = insert_record('hiperbook_chapters_suggestions', $suggestion)) {
				error('Could not insert a new suggestion!');
			}else{
				// cadastra na apgina atual
				$ph->idsuggestion = $suggestion->id;
				$ph->idpage = $pageid;
				 insert_record('hiperbook_pages_suggestions', $ph);
			}		
		}			
	}else{
	// cadastra na apgina atual	
				$ph->idsuggestion = $form->suggestionid_existent;
				$ph->idpage = $pageid;
				 insert_record('hiperbook_pages_suggestions', $ph);
	
	}
?>
  <script language="javascript"> window.opener.location.reload(); </script>
  <?
}

// se grupos separados, mostra apenas todos os participantes e do grupo

if($cm->groupmode == SEPARATEGROUPS){
	$sqlaux = ' and (groupid = 0 or groupid = '.$groupid.' )';
}


$suggestions = get_records_sql('select * from '.$CFG->prefix.'hiperbook_pages_suggestions ph, '.$CFG->prefix.'hiperbook_chapters_suggestions ch where ph.idpage = '.$pageid.' and ph.idsuggestion= ch.id '. $sqlaux); 

//var_dump($suggestions);
$suggestioncount = $suggestion ? count($suggestion) : 0;

if ($edit) { // to add a new suggestion?>	
  <a href="suggestions.php?suggestionnum=<?= $suggestioncount +1 ?>&add=1&chapterid=<?= $chapterid ?>&id=<?= $id ?>&pageid=<?php echo $pageid ?>&edit=<?= $edit ?>&groupid=<?php echo $groupid?>"><img src="pix/add.gif" border="0"></a><br>
  <?
} 
	
// selecionou uma dica para visualizar/editar ou adicionando uma nova, exceto p delete
if((($suggestionid>0)||($add))&!$delete){ 
	//echo 'add/vierw';
	require('suggestions.htm');
	use_html_editor();
	die;
//lista de todas as dicas
}else{ 
	//echo 'lista';	
	//caso exista apenas uma dica, exibe ela
	//senao lista as dicas existentes 
	// adiciona link para sua edicao se for o caso
	//	var_dump($suggestions);
	if ( ($edit==0)& (sizeof($suggestion)<2)&&($suggestion)){	
		$suggestion= array_shift($suggestion);
		require('suggestions.htm');
		use_html_editor();
		die;
	}else{
$i =0;
		foreach($suggestions as $suggestion){					
			?> 
  <a  href="suggestions.php?suggestionid=<?=$suggestion->id?>&id=<?=$cm->id?>&edit=<?= $edit ?>&backbtn=1&view=1&chapterid=<?=$chapterid?>&pageid=<?php echo $pageid ?>&groupid=<?php echo $groupid?>">
  <?= $suggestion->title ?>
  </a>
  <? if( 
				$edit&& (isteacheredit($course->id)) || (($suggestion->opentostudents==1)) &&
				(($suggestion->groupid == 0 )|| ($suggestion->groupid == $groupid))
				) { 							
				?> 
  <a href="suggestions.php?suggestionid=<?=$suggestion->id?>&id=<?=$cm->id?>&backbtn=1&edit=1&chapterid=<?=$chapterid?>&pageid=<?php echo $pageid ?>&suggestionnum=<?= $suggestion->suggestionnum?>&groupid=<?php echo $groupid?>"><img src="<?= $CFG->pixpath?>/t/edit.gif" border="0"></a>
  <a href="suggestions.php?suggestionid=<?=$suggestion->id?>&id=<?=$cm->id?>&delete=1&edit=1&chapterid=<?=$chapterid?>&pageid=<?php echo $pageid ?>&groupid=<?php echo $groupid?>"><img src="<?= $CFG->pixpath?>/t/delete.gif" border="0"></a>
  
  
  
  
      <? $i++;
				
				} 
				
				
					if(isteacheredit($course->id) & $edit){
				
					if ($suggestion->opentostudents==1) {
					
				echo '<a title="'.get_string('lock','hiperbook').'" href="lock.php?id='.$cm->id.'&suggestionid='.$suggestion->id.'&sesskey='.$USER->sesskey.'&mode=suggestion&lock=1"><img src="'.$CFG->pixpath.'/i/lock.gif" height="11" width="11" border="0" /></a>';
				    } else{
			 	echo '<a title="'.get_string('unlock','hiperbook').'" href="lock.php?id='.$cm->id.'&suggestionid='.$suggestion->id.'&sesskey='.$USER->sesskey.'&mode=suggestion&lock=0"><img src="'.$CFG->pixpath.'/i/unlock.gif" height="11" width="11" border="0" /></a>';
				
					}
				
				
				
				}
				
				?> 
   <br> 
   <?
		}
	}	
}	


   

?>
  
  
  
  
</p>
