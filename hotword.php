<?PHP // $Id: view.php,v 1.17 2005/08/25 19:33:12 skodak Exp $

require_once('../../config.php');
require_once('lib.php');

//var_dump($CFG);

//$db->debug = true;
$groupid = optional_param('groupid', PARAM_INT); 
$pageid = required_param('pageid', PARAM_INT); 
$chapterid = required_param('chapterid', PARAM_INT); 
$id = 	required_param('id', PARAM_INT); //cm id
$edit      = optional_param('edit', -1, PARAM_BOOL);     // Edit mode
$hotwordid      = optional_param('hotwordid', -1, PARAM_INT);     // View mode
$delete      = optional_param('delete', 0, PARAM_INT);     // delete mode
$backbtn      = optional_param('backbtn', 0, PARAM_INT);     // delete mode
$add      = optional_param('add', 0, PARAM_INT);     // delete mode


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

//$db->debug=true;

$usehtmleditor = can_use_html_editor();
print_header( "",null,
				  "",
				  '',
				  '',
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

#topo_hotword{
	background-image: url(<?php echo $CFG->wwwroot. "/file.php/". $course->id. "/template_hiperbook".$book->id."/".$book->img_hotwords_top ?>);
	background-repeat:no-repeat;
	height:150px;
	width:100%;
	vertical-align:top;
	}
	<?php
echo $CFG->default_template_css;
echo $book->template_css;
?>
-->
</style>
<div id='topo_hotword'></div>
<?php 

	$strdesc = get_string('glossary', 'hiperbook');
	echo $strdesc;	
	
?><br />
<a href="<?php echo $CFG->wwwroot?>/mod/hiperbook/glossary.php?id=<?php echo $cm->id ?>&groupid=<?php echo $groupid?>"> <?php print_string('seehotwords', 'hiperbook'); ?></a><br />
<?
if($delete){
	delete_records('hiperbook_pages_hotwords', 'idhotword', $hotwordid, 'idpage', $pageid);
}

$hotword = get_record('hiperbook_chapters_hotword', 'id', $hotwordid);

if (($form = data_submitted()) && (confirm_sesskey())) {


	$hotword->content = $form->content;
	$hotword->title = $form->title;
	$hotword->chapterid= $form->chapterid;	
	$hotword->hotwordnum= $form->hotwordnum;	
	$hotword->idpage = $form->pageid;	
	$hotword->idhiperbook = $book->id;	
	$hotword->opentostudents = $page->opentostudents;
	$hotword->groupid = $form->groupid;
	$hotword->userid= $USER->id;
		
	if ($form->hotwordid_existent ==0){ 
		 $hotword->content = stripslashes($hotword->content );
		if ($hotword->id >0) { // editando	
			$backbtn=1;
			
			if (!update_record('hiperbook_chapters_hotword', $hotword)) {
				error('Could not update your hotword!!!');
			}	
		}else{ // criando uma nova -> insert
			if (!$hotword->id = insert_record('hiperbook_chapters_hotword', $hotword)) {
				error('Could not insert a new hotword!');
			}else{
				// cadastra na apgina atual
				$ph->idhotword = $hotword->id;
				$ph->idpage = $pageid;
				 insert_record('hiperbook_pages_hotwords', $ph);
			}		
		}			
	}else{
	
	// cadastra na apgina atual	
				$ph->idhotword = $form->hotwordid_existent;
				$ph->idpage = $pageid;
				 insert_record('hiperbook_pages_hotwords', $ph);
	
	}
	
	
?><script language="javascript"> window.opener.location.reload(); </script><?
}


// se grupos separados, mostra apenas todos os participantes e do grupo

if($cm->groupmode == SEPARATEGROUPS){
	$sqlaux = ' and (groupid = 0 or groupid = '.$groupid.' )';
}


$hotwords = get_records_sql('select * from '.$CFG->prefix.'hiperbook_pages_hotwords ph, '.$CFG->prefix.'hiperbook_chapters_hotword ch where ph.idpage = '.$pageid.' and ph.idhotword= ch.id '.$sqlaux ); 

//var_dump($hotwords);
$hotwordcount = $hotword ? count($hotword) : 0;

if ($edit) { // to add a new hotword?>	
	<a href="hotword.php?hotwordnum=<?= $hotwordcount +1 ?>&add=1&chapterid=<?= $chapterid ?>&id=<?= $id ?>&pageid=<?php echo $pageid ?>&edit=<?= $edit ?>&groupid=<?php echo $groupid ?>"><img src="pix/add.gif" border="0"></a><br>
	<?
} 
	
// selecionou uma dica para visualizar/editar ou adicionando uma nova, exceto p delete
if((($hotwordid>0)||($add))&!$delete){ 
	//echo 'add/vierw';
	require('hotword.htm');
	use_html_editor();
	die;
//lista de todas as dicas
}else{ 
	//echo 'lista';	
	//caso exista apenas uma dica, exibe ela
	//senao lista as dicas existentes 
	// adiciona link para sua edicao se for o caso
	//	var_dump($hotwords);
	if ( ($edit==0)& (sizeof($hotword)<2)&&($hotword)){	
		$hotword= array_shift($hotword);
		require('hotword.htm');
		use_html_editor();
		die;
	}else{
$i =0;
		foreach($hotwords as $hotword){					
			?> <a  href="hotword.php?hotwordid=<?=$hotword->id?>&id=<?=$cm->id?>&edit=<?= $edit ?>&backbtn=1&view=1&chapterid=<?=$chapterid?>&pageid=<?php echo $pageid ?>&groupid=<?php echo $groupid ?>"><?= $hotword->title ?></a>
				<? if( 
				$edit&& (isteacheredit($course->id)) || (($hotword->opentostudents==1)) &&
				(($hotword->groupid == 0 )|| ($hotword->groupid == $groupid))
				) { 			
				?> <a href="hotword.php?hotwordid=<?=$hotword->id?>&id=<?=$cm->id?>&backbtn=1&edit=1&chapterid=<?=$chapterid?>&pageid=<?php echo $pageid ?>&hotwordnum=<?= $hotword->hotwordnum?>&groupid=<?php echo $groupid ?>"><img src="<?= $CFG->pixpath?>/t/edit.gif" border="0"></a>
				<a href="hotword.php?hotwordid=<?=$hotword->id?>&id=<?=$cm->id?>&delete=1&edit=1&chapterid=<?=$chapterid?>&pageid=<?php echo $pageid ?>&groupid=<?php echo $groupid ?>"><img src="<?= $CFG->pixpath?>/t/delete.gif" border="0"></a>
			 <? $i++;
				
				} 
				if(isteacheredit($course->id)){
				
					if ($hotword->opentostudents==1) {
					
				echo '<a title="'.get_string('lock','hiperbook').'" href="lock.php?id='.$cm->id.'&hotwordid='.$hotword->id.'&sesskey='.$USER->sesskey.'&mode=hotword&lock=1"><img src="'.$CFG->pixpath.'/i/lock.gif" height="11" width="11" border="0" /></a>';
				    } else{
			 	echo '<a title="'.get_string('unlock','hiperbook').'" href="lock.php?id='.$cm->id.'&hotwordid='.$hotword->id.'&sesskey='.$USER->sesskey.'&mode=hotword&lock=0"><img src="'.$CFG->pixpath.'/i/unlock.gif" height="11" width="11" border="0" /></a>';
				
					}
				}
				?> <br> <?
		}
	}	
}	


   

?>
	



