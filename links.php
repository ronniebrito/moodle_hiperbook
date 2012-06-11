<?PHP // $Id: view.php,v 1.17 2005/08/25 19:33:12 skodak Exp $

require_once('../../config.php');
require_once('lib.php');

//var_dump($CFG);



$pageid = required_param('pageid', PARAM_INT); 
$chapterid = required_param('chapterid', PARAM_INT); 
$id = 	required_param('id', PARAM_INT); //cm id
$edit      = optional_param('edit', -1, PARAM_BOOL);     // Edit mode
$linkid      = optional_param('linkid', -1, PARAM_INT);     // View mode
$delete      = optional_param('delete', 0, PARAM_INT);     // delete mode
$backbtn      = optional_param('backbtn', 0, PARAM_INT);     // delete mode

$linknum      = optional_param('linknum', 1, PARAM_INT);     // View mode

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

.corpotexto {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #003366; text-align: left; line-height: 15px}

-->

<?php
echo $CFG->default_template_css;
echo $book->template_css;
?>
</style>
<div id='topo_links'><img src="<?php echo $CFG->wwwroot."/file.php/".$course->id."/template_hiperbook". $book->id."/".$book->img_links_top ?>"  /></div><br>
<?php print_string('linksdescription','hiperbook');?> <br />
<?
if($delete){
	delete_records('hiperbook_chapters_links', 'id', $linkid);
}

$link = get_record('hiperbook_chapters_links', 'id', $linkid);
//$db->debug = true;

if (($form = data_submitted()) && (confirm_sesskey())) {
	$link->targetchapterid = $form->targetchapterid;
	$link->title = $form->title;
	$link->chapterid= $form->chapterid;	
	$link->linknum= $form->linknum;	
	$link->popup= $form->popup;	
	$link->show_navigation= $form->show_navigation;		
	$link->target_navigation_chapter= $form->target_navigation_chapter;		
	
	$target_navchap = get_record('hiperbook_navigation_chapters','id', $form->target_navigation_chapter);
	
	$target_page = get_record('hiperbook_chapters_pages','pagenum', $form->pagina_destino, 'chapterid', $target_navchap->chapterid);
	
	$link->idtargetpageid= $target_page->id;
	
	$link->idpage =  $form->pageid;	
	
	if ($link->id >0) { // editando uma dica -> update		
		$backbtn=1;
		if (!update_record('hiperbook_chapters_links', $link)) {
			error('Could not update your link!!!');
		 }	
	}else{ // criando uma nova -> insert
		if (!$link->id = insert_record('hiperbook_chapters_links', $link)) {
			error('Could not insert a new link!');
		}
	}
		?><script language="javascript"> window.opener.location.reload(); </script><?
}

$links = get_records_select('hiperbook_chapters_links', 'chapterid='.$chapterid. ' and idpage='. $pageid, 'id');
$linkcount = $links ? count($links) : 0;

if ($edit) { // to add a new link?>	
	<a href="links.php?linknum=<?php echo $linkcount +1 ?>&add=1&chapterid=<?php echo $chapterid ?>&id=<?= $id ?>&pageid=<?php echo $pageid ?>&edit=<?= $edit ?>"><img src="pix/add.gif" border="0"></a><br> 
	<?
} 
	
// selecionou uma dica para visualizar/editar ou adicionando uma nova, exceto p delete
if((($linkid>0)||($add))&!$delete){ 
	//echo 'add/vierw';
	require('links.htm');
	use_html_editor();
	die;
//lista de todas as dicas
}else{ 
	//echo 'lista';	
	//caso exista apenas uma dica, exibe ela
	//senao lista as dicas existentes 
	// adiciona link para sua edicao se for o caso
	//	var_dump($links);
	if ( ($edit==0)& (sizeof($links)<2)&&($links)){	
		$link= array_shift($links);
		require('links.htm');
		use_html_editor();
		die;
	}else{
$i =0;
		foreach($links as $link){					
			?> <a  href="links.php?linkid=<?=$link->id?>&id=<?=$cm->id?>&edit=1&backbtn=1&chapterid=<?=$chapterid?>&pageid=<?php echo $pageid ?>"><?= $link->title ?> </a>
				<? if($edit) { 				
				?> <a href="links.php?linkid=<?=$link->id?>&id=<?=$cm->id?>&backbtn=1&edit=1&chapterid=<?=$chapterid?>&linknum=<?= $link->linknum?>&pageid=<?php echo $pageid ?>"><img src="<?= $CFG->pixpath?>/t/edit.gif" border="0"></a>
				<a href="links.php?linkid=<?=$link->id?>&id=<?=$cm->id?>&delete=1&edit=1&chapterid=<?=$chapterid?>&pageid=<?php echo $pageid ?>"><img src="<?= $CFG->pixpath?>/t/delete.gif" border="0"></a>
			 <? $i++;				
				} ?> <br> <?
		}
	}	
}	


   

?>
	



