<?PHP // $Id: view.php,v 1.17 2005/08/25 19:33:12 skodak Exp $

require_once('../../config.php');
require_once('lib.php');

//var_dump($CFG);

$id = 	required_param('id', PARAM_INT); //cm id
$edit      = optional_param('edit', -1, PARAM_BOOL);     // Edit mode
$navpathid      = optional_param('navpathid', -1, PARAM_INT);     // View mode
$delete      = optional_param('delete', 0, PARAM_INT);     // delete mode
$bookid = required_param('bookid', PARAM_INT);  

$groupid = optional_param('groupid',0, PARAM_INT);  

if ($CFG->forcelogin) {
    require_login();
}

if (!$cm = get_record('course_modules', 'id', $id)) {
    error('Course Module ID is incorrect');
}

if (!$course = get_record('course', 'id', $cm->course)) {
    error('Course is misconfigured');
}

if ($course->category) {
    require_login($course->id);
}

if (!$book = get_record('hiperbook', 'id', $cm->instance)) {
    error('Course module is incorrect');
}


if (!isteacheredit($course->id)&($book->opentostudents==0)) {
    error('Unable to edit!', $_SERVER['HTTP_REFERER']);
}


$groupmode = groupmode($course, $cm);


$usehtmleditor = can_use_html_editor();

add_to_log($course->id, 'hiperbook', 'navpaths', 'navpaths.php?id='.$cm->id.'&chapterid='.$chapter->id, $book->id, $cm->id);
		
	///read standard strings
	$strbooks = get_string('modulenameplural', 'hiperbook');
	$strbook  = get_string('modulename', 'hiperbook');
	$strTOC = get_string('TOC', 'hiperbook');
	
	/// prepare header (not the hiperbook navigation)
	if ($course->category) {
		$navigation = '<a href="../../course/view.php?id='.$course->id.'">'.$course->shortname.'</a> ->';
	} else {
		$navigation = '';
	}
	
		$buttons = $isteacher ? '<table cellspacing="0" cellpadding="0"><tr><td>'.update_module_button($cm->id, $course->id, $strbook).'</td>'.
			   '<td>&nbsp;</td><td>'.hiperbook_edit_button($cm->id, $course->id, $chapterid,$navigationnum).'</td></tr></table>'
			   : '&nbsp;';
	
	print_header( "$course->shortname: $book->name",
				  $course->fullname,
				  "$navigation <a href=\"index.php?id=$course->id\">$strbooks</a> -> <a href=\"view.php?id=$cm->id\"> $book->name </a> -> caminhos",
				  '',
				  '',
				  true,
				  $buttons,
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

-->
</style><br />
<br />
<a href="<?php echo $CFG->wwwroot. '/mod/hiperbook/view.php?id='.$cm->id.'&navigationnum=1&pagenum=1&show_navigation=1&groupid='.$groupid;?>" ><?php print_string('back','hiperbook');?></a>
<!--img src="pix/barra_dicas.png"  border="0"--><?php print_string('navpaths','hiperbook') ?><br>
<?
if($delete){
	$navpath = get_record('hiperbook_navigationpath', 'id', $navpathid);
	$deletednum = $navpath->navpathnum;
	hiperbook_remove_navigation($deletednum,$navpathid, $cm);
}




//var_dump($navpaths);
$navpathcount = $navpaths ? count($navpaths) : 0;
$navpath = get_record('hiperbook_navigationpath', 'id', $navpathid);

if (($form = data_submitted()) && (confirm_sesskey())) {
	$navpath->name = $form->name;
	$navpath->bookid= $form->bookid;	
	$navpath->navpathnum= $form->navpathnum;
	$navpath->summary= $form->summary;
	$navpath->id = $form->navpathid;		
	
	
	// se criado por grupo, define o grupo e coloca navpath como aberto para alunos
	if(($groupid > 0)&&(!isteacheredit($course->id))) {
		$navpath->groupid = $form->groupid;
		$navpath->opentostudents = 1;
	}	
	
	
	$navpath->summary = stripslashes($navpath->summary );
	if ($navpath->id > 0) { // editando o navpath -> update			
		if (!update_record('hiperbook_navigationpath', $navpath)) {
			error('Could not update your navpath!!!');
		 }	
	}else{ // criando uma nova -> insert
	
		// busca o ultimo navpathnum
		$navpathnum = get_record_sql('select max(navpathnum) newnavpathnum from '.$CFG->prefix.'hiperbook_navigationpath  where bookid = '.$book->id);				
		$navpath->navpathnum= $navpathnum->newnavpathnum +1;	
		
		if (!$navpath->id = insert_record('hiperbook_navigationpath', $navpath)) {
			error('Could not insert a new navpath!');
		}
		
	}
	//unset($form);
	//$navpathid = $navpath->navpathid;
}


//$db->debug = true;
// se grupos separados 
$selectaux .= ' and (groupid = 0';
//if ($groupmode==SEPARATEGROUPS){
	$selectaux .= ' or groupid = '.$groupid;
//}
$selectaux .= ')';


$navpaths = get_records_select('hiperbook_navigationpath', 'bookid='.$cm->instance. $selectaux, 'navpathnum');


// to add a new navpath (no navpath specified when page called)
if ($edit<0){
?>	
<form name="navpathseditform" method="post" action="navpaths.php" >
	<?php print_string('title','hiperbook') ?><input type="text" value="<?= $navpath->title ?>" name="name"><br>
		<?php print_string('summary','hiperbook') ?>:<? 
print_textarea($usehtmleditor, 15, 64, 320, 150, 'summary', '', $course->id);    
?>
	<input type="submit" value="<?php print_string('savechanges') ?>" />
	<input  type="reset" value="<?php print_string('revert') ?>"/>
	<input type="hidden" name="bookid"   value="<?= $bookid ?>" />
	<input type="hidden" name="groupid"   value="<?= $groupid ?>" />
	<input type="hidden" name="navpathid"   value="<?= $navpathid ?>" />
	<input type="hidden" name="navpathnum"   value="<?= $navpathcount+1 ?>" />
	<input type="hidden" name="id"        value="<?php p($cm->id) ?>" />
	<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" /> 
	<input type="hidden" name="edit" value="<?= $edit?>" /> 
</form>
<? }else{ ?>

	<form name="navpathseditform" method="post" action="navpaths.php" >
		<?php print_string('title','hiperbook') ?>:<input type="text" value="<?= $navpath->name ?>" name="name"><br>
		<?php print_string('summary','hiperbook') ?>:<? 
print_textarea($usehtmleditor, 15, 64, 320, 150, 'summary', $navpath->summary, $course->id);    
?><br />
		<input type="submit" value="<?php print_string('savechanges') ?>" />
		<input  type="reset" value="<?php print_string('revert') ?>"/>
		<input type="hidden" name="bookid"   value="<?= $bookid ?>" />
		<input type="hidden" name="groupid"   value="<?= $groupid ?>" />
		<input type="hidden" name="navpathid"   value="<?= $navpathid ?>" />
		<input type="hidden" name="navpathnum"   value="<?= $navpath->navpathnum ?>" />
		<input type="hidden" name="id"        value="<?php p($cm->id) ?>" />
		<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" /> 
		<input type="hidden" name="edit" value="<?= $edit?>" /> 
	</form>
<?
}
//lista 
//var_dump($navpaths);
$i =0;

if (($book->opentostudents == 1)||($edit)) {    ?>
<a href="navpaths.php?navpathid=-1&id=<?=$cm->id?>&bookid=<?=$bookid?>&groupid=<?=$groupid?>"><img src="pix/add.gif" border="0"></a><br />
<? }
		foreach($navpaths as $navpath){		
			echo $navpath->name;			
			?> <a  href="navpaths.php?navpathid=<?=$navpath->id?>&id=<?=$cm->id?>&edit=1&bookid=<?=$bookid?>"><?= $navpath->title ?></a>
    
			<?php 
			if (($navpath->opentostudents == 1)||($edit ==1)){           
			// pode editar e apagar se pertencer ao grupo			
				if (($groupmode == 0)||($navpath->groupid == $groupid)||($navpath->groupid == 0)) { ?>                
                 	<a href="navpaths.php?navpathid=<?=$navpath->id?>&id=<?=$cm->id?>&edit=1&bookid=<?=$bookid?>&navpathnum=<?= $navpath->navpathnum?>&groupid=<?=$groupid?>"><img src="<?= $CFG->pixpath?>/t/edit.gif" border="0"></a>
                        
                    <? //dont allow deletion of initial navpath
                     if($navpath->navpathnum != 1){ ?><a href="navpaths.php?navpathid=<?=$navpath->id?>&id=<?=$cm->id?>&bookid=<?=$bookid?>&delete=1&groupid=<?=$groupid?>"><img src="<?= $CFG->pixpath?>/t/delete.gif" border="0"></a>
                    <? }
				
				 }?>
            	
                
			 <? $i++;				
			
			if(((isteacheredit($course->id)) || ($navpath->opentostudents == 1))  ){
				if ($i != 1) {
					echo ' <a title="'.get_string('up').'" href="navpathmove.php?id='.$id.'&edit=1&navpathnum='.$navpath->navpathnum.'&bookid='.$bookid.'&groupid='.$groupid.'&up=1&edit=1&sesskey='.$USER->sesskey.'"><img src="'.$CFG->pixpath.'/t/up.gif" height="11" width="11" border="0" /></a>';
				}
				if ($i != count($navpaths)) {
					echo ' <a title="'.get_string('down').'" href="navpathmove.php?id='.$id.'&edit=1&navpathnum='.$navpath->navpathnum.'&bookid='.$bookid.'&groupid='.$groupid.'&up=0&edit=1&sesskey='.$USER->sesskey.'"><img src="'.$CFG->pixpath.'/t/down.gif" height="11" width="11" border="0" /></a>';
				}
				}
				
			}
			
			
			if(($edit==1)&&(isteacheredit($course->id))){
			
				if ($navpath->opentostudents==1) {
					echo ' <a title="'.get_string('lock').'" href="lock.php?id='.$cm->id.'&navpathid='.$navpath->id.'&sesskey='.$USER->sesskey.'&mode=navpath&lock=1&edit=1"><img src="'.$CFG->pixpath.'/i/lock.gif" height="11" width="11" border="0" /></a>';
				} else {
					echo  ' <a title="'.get_string('unlock').'" href="lock.php?id='.$cm->id.'&navpathid='.$navpath->id.'&sesskey='.$USER->sesskey.'&mode=navpath&lock=0&edit=1"><img src="'.$CFG->pixpath.'/i/unlock.gif" height="11" width="11" border="0" /></a>';
				}
			}				
				 ?> <br> <?
		}
	

   use_html_editor();

?>