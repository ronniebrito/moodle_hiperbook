<?PHP // $Id: view.php,v 1.17 2005/08/25 19:33:12 skodak Exp $
	

require_once('../../config.php');
require_once('lib.php');

//$db->debug =true;

$unlock_navpath_id = optional_param('unlock_navpath_id', 0, PARAM_INT); 
$unlock_chapter_id = optional_param('unlock_chapter_id', 0, PARAM_INT); 
$unlock_page_id = optional_param('unlock_page_id', 0, PARAM_INT); 

$id        = required_param('id', PARAM_INT);           // Course Module ID


$target_navigation_chapter = optional_param('target_navigation_chapter', 0, PARAM_INT); 

$edit      = optional_param('edit', -1, PARAM_BOOL);     // Edit mode
$pop_up        = optional_param('pop_up', PARAM_INT);           // pop up mode

$groupid =  optional_param('groupid',-1, PARAM_INT);           // pop up mode
//adicionado para navegacao por paginas de capitulos
$pagenum     = optional_param('pagenum', 1, PARAM_INT);     // Edit mode
$navigationnum     = optional_param('navigationnum', 0, PARAM_INT);     // navegação padrao pelos conteudos 

$show_navigation     = optional_param('show_navigation', 1, PARAM_INT);     // se exibe ou nao a navegação 



//$db->debug =true;
// =========================================================================
// security checks START - teachers edit; students view
// =========================================================================
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



if($target_navigation_chapter != 0 ){ 

	$navchapter = get_record_sql('select * from '.$CFG->prefix.'hiperbook_navigation_chapters nc where  nc.id =  '.$target_navigation_chapter);	
	$navpath = get_record_sql('select * from '.$CFG->prefix.'hiperbook_navigationpath np where id = '.$navchapter->navigationid );		
	$navigationnum  = $navpath->navpathnum; 
	$chapterid = $navchapter->chapterid;
	
	
}else{

	if($navigationnum !=0){
		
	$navchapter->id = 0;
	// get_record_sql('select nc.* from '.$CFG->prefix.'hiperbook_navigation_chapters nc,'.$CFG->prefix.'hiperbook_navigationpath np where np.navpathnum = ' .$navigationnum.'  and np.id = nc.navigationid 		and nc.parentnavchapterid = 0 and np.bookid='.$book->id);
		
	$navpath = get_record_sql('select * from '.$CFG->prefix.'hiperbook_navigationpath np where bookid = '.$book->id. ' and navpathnum=' . $navigationnum);	

	
	}else{
	
	// se nao definiu navigation chapter nem mudou de aba
	// busca o primeiro navchapter do capitulo da primeira aba
		//$navchapter = get_record_sql('select nc.* from '.$CFG->prefix.'hiperbook_navigation_chapters nc,'.$CFG->prefix.'hiperbook_navigationpath np where np.navpathnum = 1 and np.id = nc.navigationid		and nc.parentnavchapterid = 0 and np.bookid='.$book->id);	
		$navchapter->id = 0;	
		$navigationnum =1;
		
			$navpath = get_record_sql('select * from '.$CFG->prefix.'hiperbook_navigationpath np where bookid = '.$book->id. ' and navpathnum = 1 ' );	
	}
	
}

$isteacher = isteacheredit($course->id);
if ($isteacher) {
    if($edit != -1) {
        $USER->editing = $edit;
    } else {
        if (isset($USER->editing)) {
            $edit = $USER->editing;
        } else {
            $edit = 0;
        }
    }
} else {
    $edit = 0;
}




$groups = get_groups($course->id, $USER->id); 

if($isteacher){
	$groups = get_groups($course->id);
	if( $groupid ==-1 ) { $groupid = 0; }
}


// se groupid = -1 define grupo padrao do aluno 
if(( $groupid ==-1 )&(!$isteacher)){
	$group = array_pop($groups);
	$groupid = $group->id;
	array_push($groups,$group);

}

if (!$cm->visible and !$isteacher) {
	notice(get_string('activityiscurrentlyhidden'));
}

?>


<?php 

if ($unlock_navpath_id){
	// abre para alunos todas os capitulos e paginas presentes no navpath
	hiperbook_unlock_navpath( $unlock_navpath_id);
}
if ($unlock_chapter_id){
	// abre para alunos todas as paginas presentes no navpath	
	hiperbook_unlock_chapter($unlock_chapter_id);
}
if ($unlock_page_id){
	// abre para alunos a pagina identificada	
	hiperbook_unlock_page($unlock_page_id);
}		




if(!$navchapterid){ $navchapterid = 0; } // se nao encontrou um navchapter, esta na raiz
//var_dump($navchapterid);

/// read chapters
// busca os capitulos q aparecem na area lateral em funcao do parametro chapterid
// se chapterid = null, entao esta no inicio e busca os capitulos com parentchapter = 0
// senao busca capitulos com parentchapter = chapterid 
// se grupos separados,  busca apenas capitulos do grupo atual
if (((!$isteacher)||(!$edit))  & ($navpath->opentostudents!=1)) {
	$select = " AND hidden = 0";
} 

// grupos separados mostra o capitulo mas sem o link
if ($cm->groupmode ==1 ) { 
//	$select.= " AND (c.groupid =".$groupid ." OR c.groupid = 0)" ;
}

$groupmode = $cm->groupmode;

$chapters = get_records_sql('select c.id id, c.hidden hidden, c.title title, nc.chapternum chapternum, nc.parentnavchapterid parentnavchapterid, nc.id target_navigation_chapter , c.opentostudents opentostudents, c.groupid groupid 
from '.$CFG->prefix.'hiperbook_chapters c, 
'.$CFG->prefix.'hiperbook_navigation_chapters nc,
'.$CFG->prefix.'hiperbook_navigationpath np 
where np.bookid='.$book->id.'
and np.id = ' .$navpath->id.'  
and np.id = nc.navigationid
and nc.chapterid = c.id
and nc.parentnavchapterid = ' .$navchapter->id . $select. "  
 order by chapternum");

/// check chapterid and read chapter data

if (($navchapter->chapterid == 0)||(is_null($navchapter->chapterid))) { // go to first chapter if no given -> mostra o sumario do navpath
//echo 'sumario';
	$conteudo = $navpath->summary;
}else{ // -> mostra a primeira pagina do capitulo
	$chapter = get_record('hiperbook_chapters', 'id', $navchapter->chapterid,'bookid', $cm->instance);   
	//check all variables -> essa zona ai n sei pra q serve (reutiliza as variaveis de/em algum lugar ....)
	unset($id);
	unset($chapterid);	
	/// chapter is hidden for students
	if (!$isteacher and $chapter->hidden) {
		error('Error reading book chapters...');
	}	
	/// chapter not part of this book!
	if ($chapter->bookid != $book->id) {
		error('Chapter not part of this book!');
	}
}

//echo " chapter:".$chapter->id;

// apos ter lido o capitulo, busca o conteudo da pagina passada por parametro
$page = get_record('hiperbook_chapters_pages', 'chapterid', $navchapter->chapterid,'pagenum',$pagenum);


//var_dump($page);

$totalpages = count_records('hiperbook_chapters_pages', 'chapterid', $chapter->id);
	$pageid = $page->id;
	// =========================================================================
	// security checks  END
	// =========================================================================
add_to_log($course->id, 'hiperbook', 'view', 'popup.php?id='.$cm->id.'&target_navigation_chapter='.$navchapter->id, $book->id, $cm->id);		

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
	
	
	print_header();				
			?>
<!-- popups inspired by DOM popup kit 

http://www.methods.co.nz/popup/popup.html

 -->
					
   <script src="prototype.js" type="text/javascript"></script>
  <script src="effects.js" type="text/javascript"></script>
  <script src="dragdrop.js" type="text/javascript"></script>
  <script src="popup.js" type="text/javascript"></script>

				
<style type="text/css">
div.popup {
  max-width: 600px;
  border: 1px solid;
  padding: 5px;
  background-color: white;
  /* The following properties should not be changed */
  position: absolute;
}

#popup_overlay {
  background-color: whitesmoke;
  /* The following properties should not be changed */
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 500px;
}

span.popup_link, a.popup_link {
  cursor: pointer;
  border-bottom: 1px dotted;
}

.popup_draghandle {
  cursor: move;
}

#mod-hiperbook-popup #page{ 
	background-image:url(<?php echo $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'. $book->img_top_popup;?>);
	background-repeat:no-repeat;
}
<?php
echo $CFG->default_template_css;
echo $book->template_css;

?>

.mod-hiperbook #navpaths #current #main{
	background-image:url(<?php echo $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'. $book->img_navpath_active_middle; ?>);
	background-position:center;
	background-repeat:repeat-x;
}
.mod-hiperbook #navpaths #current #start{
	background-image:url(<?php echo $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'. $book->img_navpath_active_start; ?>);
	background-position:center;
	background-repeat:no-repeat;
}
.mod-hiperbook #navpaths #current #end{
	background-image:url(<?php echo $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'. $book->img_navpath_active_end; ?>);
	background-position:center;
	background-repeat:no-repeat;
}
	
.mod-hiperbook #navpaths #past #main{	
	background-image:url(<?php echo $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'. $book->img_navpath_inactive_middle; ?>);
	background-position:center;
	background-repeat:repeat-x;
}
.mod-hiperbook #navpaths #past #start{
	background-image:url(<?php echo $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'. $book->img_navpath_inactive_start; ?>);
	background-position:center;
	background-repeat:no-repeat;
}

.mod-hiperbook #navpaths #past #end{
	background-image:url(<?php echo $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'. $book->img_navpath_inactive_end; ?>);
	background-position:center;
	background-repeat:no-repeat;
}
</style>


  
  
				<?php
				
					
		if ($book->img_page_next ){ 
			$img_page_next = $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'.$book->img_page_next;
			
		}else{
			$img_page_next = "images/next.gif";
		}
		
		
		if ($book->img_page_prev ){ 
			$img_page_prev = $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'.$book->img_page_prev;
		}else{
			$img_page_prev = "images/back.gif";
		}
		
		
		if ($book->img_separador_toc ){ 
			$img_separador_toc = $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'.$book->img_separador_toc;
		}else{
			$img_separador_toc = "images/separador_toc.jpg";
		}
		
		if ($book->img_hotwords_top ){ 
			$img_hotwords_top = $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'.$book->img_hotwords_top;
		}else{
			$img_hotwords_top = "images/title_hotwords.jpg";
		}
		
		if ($book->img_tips_top ){ 
			$img_tips_top = $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'.$book->img_tips_top;
		}else{
			$img_tips_top = "images/title_tips.jpg";
		}
		
		
		if ($book->img_suggestions_top ){ 
			$img_suggestions_top = $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'.$book->img_suggestions_top;
		}else{
			$img_suggestions_top = "images/title_suggestions.jpg";
		}
		
		if ($book->img_links_top ){ 
			$img_links_top = $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'.$book->img_links_top;
		}else{
			$img_links_top = "images/img_links_top.jpg";
		}
		
		if ($book->img_hotwords_icon ){ 
			$img_hotwords_icon = $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'.$book->img_hotwords_icon;
		}else{
			$img_hotwords_icon = "images/bot1a.gif";
		}
		
		if ($book->img_tips_icon ){ 
			$img_tips_icon = $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'.$book->img_tips_icon;
		}else{
			$img_tips_icon = "images/bot4a.gif";
		}
		
		if ($book->img_suggestions_icon ){ 
			$img_suggestions_icon = $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'.$book->img_suggestions_icon;
		}else{
			$img_suggestions_icon = "images/bot3a.gif";
		}
		
		if ($book->img_links_icon ){ 
			$img_links_icon = $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'.$book->img_links_icon;
		}else{
			$img_links_icon = "images/bot2a.gif";
		}
		
									
		
				
	/// prepare chapter navigation icons	
	// a navegacao pelos capitulos ocorre exclusivamente pela arvore e breadcrumbs
	// passa-se a utilizar a navegacao para as paginas apenas	
	if ($page){	
	   if ($totalpages > $pagenum) {
			$nextpage = $page->pagenum + 1;
		}else{
			$nextpage = '';
		}
		if ($pagenum > 1) {
			$prevpage = $page->pagenum - 1;
		}else{
			$prevpage = '';
		}				
		$pgnavigation = '';
		
		
		$pgnavigation .=' <form action="'.$PHP->SELF .'">';
  
		
		
		
		
		// pode editar a pagina se 
		// professor (edit)
		// ou 
		//    pagina aberto para alunos
		//    e sem grupos ou 
		// ou capitulo aberto para alunos, com grupos visiveis e a pagina pertence ao grupo
		
		
		
		
		// pode adicionar paginas se o chapter estiver aberto 
		// e 
		// no  modo sem grupos 
		// ou com grupos visiveis ou separados e o capitulo for do grupo
		
	
		if (
			($edit) || 
			(
				($chapter->opentostudents)&
		 		(($groupmode==0) || (($groupmode==1)&&($chapter->groupid == $groupid))) 
		 	)
		 )
		
		{ $pgnavigation .= '<a title="adicionar anterior" href="page.php?id='.$cm->id.'&chapterid='.$chapter->id.'&pagenum='. $page->pagenum .'&addprev=1&navigationnum='.$navigationnum.'&parentnavchapterid='.$parentnavchapterid.'&groupid='.$groupid.'"><img src="pix/add.gif"></a> '; }		
		
		
		
		if ($prevpage!='') {
			$pgnavigation .= '<a  href="popup.php?id='.$cm->id.'&pagenum='.$prevpage .'&target_navigation_chapter='.$target_navigation_chapter.'&show_navigation='.$show_navigation.'"><img src="'.$img_page_prev.'"/></a> ';
		} 	
				
		if ($totalpages > 1){ 
		
		$pgnavigation .= get_string('page','hiperbook')." <b>";		
		
		
		$pgnavigation .='<input type="hidden" name="id" id="id" value="'.$cm->id.'">
  <input type="hidden" name="chapterid" id="chapterid" value="'. $navchapter->chapterid.'">
  <input type="hidden" name="navigationnum" id="navigationnum" value="'.$navigationnum.'">
  
  <input type="hidden" name="target_navigation_chapter" id="target_navigation_chapter" value="'.$navchapter->id.'">
  <input type="hidden" name="parentnavchapterid" id="parentnavchapterid" value="'.$parentnavchapterid.'">
  <input type="hidden" name="show_navigation" id="show_navigation" value="'.$show_navigation.'">';
  
  
		$pgnavigation .= '<select name="pagenum" onchange="javascript:submit();">';		
		  for($i =1; $i <= $totalpages; $i++){ 
			  $pgnavigation .= '<option value="'.$i.'"';		  
			  if($pagenum == $i) { 			  
				$pgnavigation .='selected'; 
			  }			  
			  $pgnavigation .= '>'.$i.'</option>';			  
		  } 
   		$pgnavigation .= '</select>';
		
		
		 $pgnavigation .= '</b> '.get_string('from','hiperbook').' <b>'. $totalpages."</b> "; }	
		
		if ($nextpage !='') {
			$pgnavigation .= '<a " href="popup.php?id='.$cm->id.'&pagenum='.$nextpage .'&target_navigation_chapter='.$target_navigation_chapter.'&show_navigation='.$show_navigation.'"><img src="'.$img_page_next.'"/></a>';
		}	
		
		if (
			($edit) || 
			(
				($chapter->opentostudents)&
		 		(($groupmode==0) || (($groupmode==1)&&($chapter->groupid == $groupid))) 
		 	)
		 ){ $pgnavigation .= ' <a title="adicionar posterior" href="page.php?id='.$cm->id.'&target_navigation_chapter='.$navchapter->id.'&pagenum='.$page->pagenum.'&addnext=1&groupid='.$groupid.'"><img src="pix/add.gif"></a>'; }
		
		if (
			($edit) || 
			(
				($chapter->opentostudents)&
		 		(($groupmode==0) || (($groupmode==1)&&($chapter->groupid == $groupid))) 
		 	)
		 ){ $pgnavigation .= ' <a title="editar" href="page.php?id='.$cm->id.'&chapterid='.$chapter->id.'&pagenum='.$page->pagenum.'&target_navigation_chapter='.$navchapter->id.'&groupid='.$groupid.'"><img src="'.$CFG->pixpath.'/t/edit.gif"></a>'; }
		
		if (
			($edit) || 
			(
				($chapter->opentostudents)&
		 		(($groupmode==0) || (($groupmode==1)&&($chapter->groupid == $groupid))) 
		 	)
		 ){ $pgnavigation .= ' <a title="excluir" href="page.php?id='.$cm->id.'&target_navigation_chapter='.$navchapter->id.'&pagenum='.$page->pagenum.'&delete=1&groupid='.$groupid.'"><img src="'.$CFG->pixpath.'/t/delete.gif"></a>'; }
		
		if (($isteacher)&($edit)) {
		
			if ( $page->opentostudents){
				$pgnavigation .= ' <a title="'.get_string('lock','hiperbook').'" href="lock.php?id='.$cm->id.'&pageid='.$page->id.'&sesskey='.$USER->sesskey.'&mode=page&lock=1"><img src="'.$CFG->pixpath.'/i/lock.gif" height="11" width="11" border="0" /></a>';
			} else {
				$pgnavigation .= ' <a title="'.get_string('unlock','hiperbook').'" href="lock.php?id='.$cm->id.'&pageid='.$page->id.'&sesskey='.$USER->sesskey.'&mode=page&lock=0"><img src="'.$CFG->pixpath.'/i/unlock.gif" height="11" width="11" border="0" /></a>';
			}
		}
		
	}else{
	
//	var_dump($groupmode);
		if (
			(($edit) || 
			(
				($chapter->opentostudents)&&
		 		(($groupmode==0) || (($groupmode==1)&($chapter->groupid == $groupid))) 
		 	))&($navchapter->chapterid!=0)
		 ){
		 
		 	$pgnavigation .= ' <a title="Adicionar pagina" href="page.php?id='.$cm->id.'&target_navigation_chapter='.$navchapter->id.'&pagenum=1&groupid='.$groupid.'"><img src="pix/add.gif"></a>'; }
			
	
	}	
	
	
	$pgnavigation .= '</form>';
	
	
	
	// prepare $toc and $currtitle, $currsubtitle
	require('tocPopup.php');
	
	if ($edit) {
		$tocwidth = $CFG->book_tocwidth + 80;
	} else {
		$tocwidth = $CFG->book_tocwidth;
	}
	
	/*$doimport = ($isteacher and $edit) ? '<font size="-1"> (<a href="import.php?id='.$cm->id.'">'.get_string('doimport', 'book').'</a>)</font>' : '';*/



	if($navchapter->id !=0){
		$breadcrumbs .= '<td id="current"><div id="start">&nbsp;</div><div id="main"><a href="popup.php?id='.$cm->id.'&pagenum=1&navigationnum='.$navpath->navpathnum.'&target_navigation_chapter=0&show_navigation='.$show_navigation.'">'. $navpath->name.'</a></div><div id="end">&nbsp; </div></td>'. hiperbook_link_parent_chapters($navchapter->id, $cm, $groupid, true);	
}
	
	// =====================================================
	// Book display HTML code
	// =====================================================




?><div id="bookname"><?php echo $book->name; ?></div><? 

// trata dos caminhos de navegacao

// se professor, ou sem grupos ou grupos visiveis -> mostra todos 
// grupos separados, mostra apenas os do grupo do usuario

$groupmode = groupmode($course, $cm);

// se tiver grupos, mostra caixa de selecao 
if ($groupmode >0){ 
?> 
<form action="<?php echo $CFG->wwwroot;?>/mod/hiperbook/view.php" method="submit" >


<input type="hidden" name="id" value="<?php echo $id?>" />
<input type="hidden" name="navigationnum" value="<?php echo $navigationnum?>" />
<input type="hidden" name="chapterid" value="<?php echo $chapterid?>" />
<input type="hidden" name="pagenum" value="<?php echo $pagenum?>" />
<input type="hidden" name="show_navigation" value="<?php echo $show_navigation?>" />
<?php 
  if ($groupmode == VISIBLEGROUPS) {
        $grouplabel = get_string('groupsvisible');
  } else {
  $grouplabel = get_string('groupsseparate');
 }
 echo $grouplabel;
 ?>

<select name="groupid" onchange="submit();">

<?php if ($isteacher) { ?>
<option value="0" <?php if($groupid==0) { echo "selected"; } ?>><?php print_string('allparticipants');
?> </option>

<?php } ?>



<?php

//var_dump($groups); 
foreach($groups as $group){

	?>
    <option value="<?php echo $group->id ?>" <?php if($groupid==$group->id) { echo "selected"; } ?>><?php echo $group->name; ?> </option>
    <?php
	
} ?>
<option value="0" <?php if($groupid==0) { echo "selected"; } ?>><?php print_string('allparticipants');
?> </option>
</select>
</form>
<?php

}

//$db->debug=true;
// se sem grupos ou grupos visiveis
if (($groupmode == 0 )|| ($groupmode ==VISIBLEGROUPS) ) { 
	$navpaths = get_records_select('hiperbook_navigationpath',"bookid = $book->id", 'navpathnum');
}else{
	$navpaths = get_records_select('hiperbook_navigationpath',"bookid = $book->id  AND (groupid =".$groupid ." OR groupid = 0)", 'navpathnum');
}

$select.= " AND (c.groupid =".$groupid ." OR c.groupid = 0)" ;

// caso nao houver um, cria o 'caminho padrao'
if(!$navpaths){
	$navpath->name = 'padrao';
	$navpath->bookid= $book->id;	
	$navpath->userid = $USER->id;
	// busca o ultimo navpathnum
	$navpathnum = get_record_sql('select max(navpathnum) newnavpathnum from '.$CFG->prefix.'hiperbook_navigationpath  where bookid = '.$book->id);	
	
	if ($groupid){
		$navpath->groupid = $groupid;
	}
		
	$navpath->navpathnum= $navpathnum->newnavpathnum +1;		
	if (!$navpath->id = insert_record('hiperbook_navigationpath', $navpath)) {
		error('Could not insert default navpath!');
	}
	$navigationnum =$navpath->navpathnum;
}

?>
<table id="navpaths"><tr>
<?
if(count($navpaths) > 1){	
	foreach($navpaths as $np){		
		if($np->navpathnum == $navigationnum) { 
			?> <td id="current" ><? if ($np->navpathnum=='1'){ ?> <div id="start">&nbsp;</div><? } ?><div id="main"> <?= $np->name; ?> </div><? if ($np->navpathnum==count($navpaths)){ ?><div id="end">&nbsp;</div><? } ?></td> <?
		}else{
		
		// busca o nav_chapter do nav_path q tenha parent = 0 e navigation id = 
		
		$nav_chapter_aux = get_record('hiperbook_navigation_chapters', 'parentnavchapterid','0', 'navigationid',$np->id);
			?>
			<td id="past" ><? if ($np->navpathnum=='1'){ ?> <div id="start">&nbsp;</div><? } ?><div id="main"><a href="popup.php?id=<?php echo $cm->id.'&navigationnum='.$np->navpathnum.'&groupid='.$groupid ?>"> <?= $np->name ?> </a></div><? if ($np->navpathnum==count($navpaths)){ ?><div id="end">&nbsp;</div><? } ?></td><? 
		} 
	}
}

if (($edit)||($book->opentostudents)){?> 
	<td>
        <?php 
        if($isteacher & $edit) {

?>

		<a href="navpaths.php?bookid=<?= $book->id ?>&id=<?=  $cm->id ?>&groupid=<?php echo $groupid?>&edit=1"><?php print_string('managenavpaths','hiperbook'); ?></a>

<?php
				//var_dump($ch);
				if ($ch->opentostudents==1) {
					echo ' <a title="'.get_string('lock','hiperbook').'" href="lock.php?id='.$cm->id.'&bookid='.$book->id.'&sesskey='.$USER->sesskey.'&mode=hiperbook&lock=1"><img src="'.$CFG->pixpath.'/i/lock.gif" height="11" width="11" border="0" /></a>';
				} else {
					echo ' <a title="'.get_string('unlock','hiperbook').'" href="lock.php?id='.$cm->id.'&bookid='.$book->id.'&sesskey='.$USER->sesskey.'&mode=hiperbook&lock=0"><img src="'.$CFG->pixpath.'/i/unlock.gif" height="11" width="11" border="0" /></a>';
				}
				
			}
            ?>
	</td>
<? } ?>
</tr></table>




<table border="0" cellspacing="0" >
<tr>
    <td colspan="3" valign="bottom">
			<table id="breadcrumbs" ><tr><?php echo $breadcrumbs; ?></tr></table>    </td>
  </tr>
<tr>
    <td valign="top" width="120" align="left">
        <?php
       
        echo $toc;       
      
        ?>    </td>
    <td colspan="2" >
        <?php

       // print_simple_box_start('middle', '100%');

       if ($page){
	   
	   
		// se grupos separados, nao mostra o conteudo da pagino de outros grupos
			if ($cm->groupmode ==SEPARATEGROUPS) { 	
				if ($page->groupid == $groupid || $page->groupid == 0 || $isteacher){
					$conteudo = $page->content;
				}else{
					$conteudo = get_string('pagefromothergroup','hiperbook');			
				}
			}else{
				$conteudo = $page->content;
			}	
		}
		
        $nocleanoption = new object();
        $nocleanoption->noclean = true;
        echo '<div class="hiperbook_content">';		
		
		$hotwords = get_records_sql('select * from '.$CFG->prefix.'hiperbook_pages_hotwords ph, '.$CFG->prefix.'hiperbook_chapters_hotword ch where ph.idpage = '.$page->id.' and ph.idhotword= ch.id'); 
				
		$links = get_records_select('hiperbook_chapters_links', 'idpage='.$page->id, 'LENGTH(title) DESC');		
				
		//var_dump($links);
		$tips =  get_records_sql('select * from '.$CFG->prefix.'hiperbook_pages_tips ph, '.$CFG->prefix.'hiperbook_chapters_tips ch where ph.idpage = '.$page->id.' and ph.idtip = ch.id'); 
		
		$suggestions = get_records_sql('select * from '.$CFG->prefix.'hiperbook_pages_suggestions ph, '.$CFG->prefix.'hiperbook_chapters_suggestions ch where ph.idpage = '.$page->id.' and ph.idsuggestion= ch.id'); 

		$conteudo = hiperbook_link_links($conteudo, $links,$cm->id, $navigationnum, $navchapterid, $groupid);
		// glossario
		$conteudo = hiperbook_link_hotwords($conteudo, $hotwords);		
		// comentarios
		$conteudo = hiperbook_link_tips($conteudo, $tips);
		
		// bibliografia
		$conteudo = hiperbook_link_suggestions($conteudo, $suggestions);
		
		echo format_text($conteudo, FORMAT_HTML, $nocleanoption, $course->id);
		//echo 'xx'.$conteudo.'xx';
        echo '</div>';
        //print_simple_box_end();
       
        ?>    </td>
      
</tr>
</table>
<table>
<tr>
<td colspan="2" > 
<div id='botoesLateral' >
<? if ($page){

$tip = get_records('hiperbook_pages_tips', 'idpage', $pageid);

$suggestion= get_records('hiperbook_pages_suggestions', 'idpage', $pageid);


$glossary = get_records('hiperbook_pages_hotwords', 'idpage', $pageid);


		
//$glossary = get_records_sql(" select h.title, h.content from ". $CFG->prefix."hiperbook_chapters c,". $CFG->prefix."hiperbook_chapters_hotword h where c.bookid = '$book->id' and c.id = h.chapterid",true);
		

	if (($edit)||($page->opentostudents)){ // para adicionar?>
	 <a href="javascript:void(0);" title="Links" onclick="javascript:window.open('links.php?chapterid=<?= $chapterid ?>&edit=1&id=<?=  $cm->id ?>&pageid=<?php echo $page->id ?>','links','menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=600,height=450,left=80,top=80')" ><img src="<?php echo $img_links_icon ?>" name="Image2"   border="0" /></a> 
	 <a href="javascript:void(0);" title="Glossário" onClick="javascript:window.open('hotword.php?chapterid=<?= $chapterid ?>&pageid=<?= $pageid ?>&edit=1&id=<?=  $cm->id ?>&groupid=<?php echo $groupid; ?>','hotword','menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=600,height=450,left=80,top=80')" ><img src="<?php echo $img_hotwords_icon ?>" name="Image1" border="0" /></a> 
	 <a  href="javascript:void(0);" onClick="javascript:window.open('tips.php?chapterid=<?= $chapterid ?>&pageid=<?= $pageid ?>&edit=1&id=<?=  $cm->id ?>&groupid=<?php echo $groupid?>','dicas','menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=600,height=450,left=80,top=80');"  ><img src="<?php echo $img_tips_icon ?>" name="Image4"   border="0" /></a>  
	 <a href="javascript:void(0);" onClick="javascript:window.open('suggestions.php?chapterid=<?= $chapterid ?>&pageid=<?= $pageid ?>&edit=1&id=<?=  $cm->id ?>&groupid=<?php echo $groupid?>','dicas','menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=600,height=450,left=80,top=80')"   ><img src="<?php echo $img_suggestions_icon ?>" name="Image3"  border="0" /></a> 
		 <? 
	}else{ 
	 // soh mostra glossario e bibliografia (suggestions)
		   //if($glossary){	?>
		    <a href="javascript:void(0);" title="Glossário" href="javascript:void(0);" onClick="javascript:window.open('glossary.php?chapterid=<?= $chapterid ?>&edit=0&id=<?=  $cm->id ?>&groupid=<?php echo $groupid?>','dicas','menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=600,height=450,left=80,top=80')" ><img src="<?php echo $img_hotwords_icon ?>"  border="0" /></a>
		 <? //}
		 // if($suggestion){	?> 
		 <a href="javascript:void(0);"  title="Bibliografia" onClick="javascript:window.open('suggestions.php?chapterid=<?= $chapterid ?>&pageid=<?= $pageid ?>&edit=0&id=<?=  $cm->id ?>&groupid=<?php echo $groupid?>','dicas','menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=600,height=450,left=80,top=80')"><img src="<?php echo $img_suggestions_icon ?>"  border="0" /></a>
		  <? //} 		  
	} // edit
} // page ?></div>

</td>
<td valign="top"> <? echo '<div  id="page_navigation">'.$pgnavigation.'</div>';?></td>

</tr>
</table>
<?php
?>
