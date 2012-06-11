<?php  // $Id: view.php,v 1.58 2005/03/04 10:13:42 moodler Exp $

require_once('../../config.php');
require_once('lib.php');

$id        = required_param('id', PARAM_INT);           // Course Module ID
$chapterid = optional_param('chapterid', 0, PARAM_INT); // Chapter ID
$edit      = optional_param('edit', -1, PARAM_BOOL);     // Edit mode

//adicionado para navegacao por paginas de capitulos
$pagenum     = optional_param('pagenum', 1, PARAM_INT);     // Edit mode
$navigationnum     = optional_param('navigationnum', 1, PARAM_INT);     // navegação padrao pelos conteudos 
$show_navigation     = optional_param('show_navigation', 1, PARAM_INT);     // se exibe ou nao a navegação 

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

//echo $book->id;
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

if (!$cm->visible and !$isteacher) {
    notice(get_string('activityiscurrentlyhidden'));
}
?>

<style type="text/css">@import url(<?= $CFG->wwwroot?>/mod/hiperbook/book_theme.css);</style>

<script language="JavaScript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

//-->
</script>
<?

// busca a navegacao atual
$navpath = get_record('hiperbook_navigationpath', 'navpathnum',$navigationnum, 'bookid',$book->id);
//var_dump($navpath);

//busca o hiperbook_navigation_chapters do capitulo atual na navegacao atual
$navchapter = get_record('hiperbook_navigation_chapters', 'chapterid',$chapterid, 'navigationid',$navpath->id);

$navchapterid = $navchapter->id;
if(!$navchapterid){ $navchapterid = 0; } // se nao encontrou um navchapter, esta na raiz
//var_dump($navchapterid);


/// read chapters
// busca os capitulos q aparecem na area lateral em funcao do parametro chapterid
// se chapterid = null, entao esta no inicio e busca os capitulos com parentchapter = 0
// senao busca capitulos com parentchapter = chapterid :D
$select = " AND c.hidden = '0'";
$chapters = get_records_sql('select c.id id, c.hidden hidden, c.title title, n.chapternum chapternum, n.parentnavchapterid parentnavchapterid from '.$CFG->prefix.'hiperbook_chapters c, '.$CFG->prefix.'hiperbook_navigation_chapters n,'.$CFG->prefix.'hiperbook_navigationpath p where c.bookid='.$book->id.' and n.parentnavchapterid ='. $navchapterid .' and n.chapterid = c.id and n.navigationid = p.id and p.navpathnum ='.$navigationnum . $select. " order by chapternum"); 

//echo 'select c.id id, c.hidden hidden, c.title title, n.chapternum chapternum, n.parentnavchapterid parentnavchapterid from '.$CFG->prefix.'hiperbook_chapters c, '.$CFG->prefix.'hiperbook_navigation_chapters n,'.$CFG->prefix.'hiperbook_navigationpath p where c.bookid='.$book->id.' and n.parentnavchapterid ='. $navchapterid .' and n.chapterid = c.id and n.navigationid = p.id and p.navpathnum ='.$navigationnum . $select. " order by chapternum";
//var_dump($chapters);

/*if (!$chapters) {
    if ($isteacher) {
        redirect('edit.php?id='.$cm->id); //no chapters - add new one
        die;
    } else {
        error('Error reading book chapters.');
    }
}*/


/// check chapterid and read chapter data

if ($chapterid == '0') { // go to first chapter if no given -> mostra o sumario do navpath
	$conteudo = $navpath->summary;
}elseif( // -> mostra a primeira pagina do capitulo
	!$chapter = get_record('hiperbook_chapters', 'id', $chapterid,'bookid', $cm->instance)) {
    error('Error reading book chapters!');
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
$page = get_record('hiperbook_chapters_pages', 'chapterid', $chapterid,'pagenum',$pagenum);
$totalpages = count_records('hiperbook_chapters_pages', 'chapterid', $chapter->id);

	
	// =========================================================================
	// security checks  END
	// =========================================================================
	
	add_to_log($course->id, 'hiperbook', 'view', 'view.php?id='.$cm->id.'&chapterid='.$chapter->id, $book->id, $cm->id);
		
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
			   '<td>&nbsp;</td><td>'.hiperbook_edit_button($cm->id, $course->id, $chapter->id,$navigationnum).'</td></tr></table>'
			   : '&nbsp;';
	
	print_header();	
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
		if ($edit){ $pgnavigation .= '<a title="adicionar anterior" href="page.php?id='.$cm->id.'&chapterid='.$chapter->id.'&pagenum='. $page->pagenum .'&addprev=1&navigationnum='.$navigationnum.'"><img src="pix/add.gif"></a> '; }
		if ($prevpage!='') {
			$pgnavigation .= '<a  href="view.php?id='.$cm->id.'&chapterid='.$chapter->id.'&pagenum='.$prevpage .'&navigationnum='.$navigationnum.'&show_navigation='.$show_navigation.'"><img src="images/back.gif"/></a>';
		} 	
		if ($totalpages > 1){ $pgnavigation .= " P&aacute;gina <b>". $pagenum . '</b> de <b>'. $totalpages."</b> "; }		
		if ($nextpage !='') {
			$pgnavigation .= '<a " href="view.php?id='.$cm->id.'&chapterid='.$chapter->id.'&pagenum='.$nextpage .'&navigationnum='.$navigationnum.'&show_navigation='.$show_navigation.'"><img src="images/next.gif"/></a>';
		}	
		
		if ($edit){ $pgnavigation .= '<a title="adicionar posterior" href="page.php?id='.$cm->id.'&chapterid='.$chapter->id.'&pagenum='.$page->pagenum.'&navigationnum='.$navigationnum.'&addnext=1"> <img src="pix/add.gif"></a>'; }
		if ($edit){ $pgnavigation .= '<a title="editar" href="page.php?id='.$cm->id.'&chapterid='.$chapter->id.'&pagenum='.$page->pagenum.'&navigationnum='.$navigationnum.'">  <img src="'.$CFG->pixpath.'/t/edit.gif"> </a>'; }
		if ($edit){ $pgnavigation .= '<a title="excluir" href="page.php?id='.$cm->id.'&chapterid='.$chapter->id.'&pagenum='.$page->pagenum.'&navigationnum='.$navigationnum.'&delete=1">  <img src="'.$CFG->pixpath.'/t/delete.gif"> </a>'; }
	}else{
		if (($edit)&($chapterid !='0')){ $pgnavigation .= '<a title="Adicionar pagina" href="page.php?id='.$cm->id.'&chapterid='.$chapter->id.'&navigationnum='.$navigationnum.'&pagenum=1"> <img src="pix/add.gif"> </a>'; }
			
	
	}	
	
	
	
	// prepare $toc and $currtitle, $currsubtitle
	require('toc.php');
	
	if ($edit) {
		$tocwidth = $CFG->book_tocwidth + 80;
	} else {
		$tocwidth = $CFG->book_tocwidth;
	}
	
	/*$doimport = ($isteacher and $edit) ? '<font size="-1"> (<a href="import.php?id='.$cm->id.'">'.get_string('doimport', 'book').'</a>)</font>' : '';*/


if($chapterid !='0'){
	$breadcrumbs .= '<td id="past"><div id="start">&nbsp;</div><div id="main"><a href="view.php?id='. $cm->id.'&navigationnum='.$navigationnum.'&chapterid=0&pagenum=1&show_navigation=1">'. $navpath->name.'</a></div><div id="end">&nbsp;</div></td>'. hiperbook_link_parent_chapters($chapterid,$cm,$chapterid,$navigationnum);	
}
	
	
	// =====================================================
	// Book display HTML code
	// =====================================================

?><body onLoad="MM_preloadImages('images/bot1b.gif','images/comentarios_up.png','images/comentarios_over.png','images/comentarios_down.png','images/bot4b.gif','images/bot3b.gif')"><div id="top_img"><img src="images/top.gif" alt="top"  height="50" /></div>
  <div id="bookname"><?= strtoupper($book->name); ?></div>
<? 

// trata dos caminhos de navegacao
// caso nao houver um, cria o 'caminho padrao'
$navpaths = get_records_select('hiperbook_navigationpath',"bookid = $book->id", 'navpathnum');
if(!$navpaths){
	$navpath->name = 'padrao';
	$navpath->bookid= $book->id;	
	$navpath->navpathnum= 1;		
	if (!$navpath->id = insert_record('hiperbook_navigationpath', $navpath)) {
		error('Could not insert default navpath!');
	}
	$navigationnum =$navpath->navpathnum;
}


if($show_navigation==1){ 
?>
<table id="navpaths"><tr height="21px">
<?
if(count($navpaths) > 1){	
	foreach($navpaths as $np){		
		if($np->navpathnum == $navigationnum) { 
			?> <td id="current" ><? if ($np->navpathnum=='1'){ ?> <div id="start">&nbsp;</div><? } ?><div id="main"> <?= $np->name; ?> </div><? if ($np->navpathnum==count($navpaths)){ ?><div id="end">&nbsp;</div><? } ?></td> <?
		}else{
			?>
			<td id="past" ><? if ($np->navpathnum=='1'){ ?> <div id="start">&nbsp;</div><? } ?><div id="main"><a href="view.php?id=<?= $cm->id ?>&navigationnum=<?= $np->navpathnum ?>"> <?= $np->name ?> </a></div><? if ($np->navpathnum==count($navpaths)){ ?><div id="end">&nbsp;</div><? } ?></td><? 
		} 
	}
}

?>


<? if ($edit){?> <td><a href="javascript:void(0);" onClick="javascript:window.open('navpaths.php?bookid=<?= $book->id ?>&id=<?=  $cm->id ?>','navpaths','menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=739,height=450,left=80,top=80')">[gerenciar caminhos]</a></td>
<? } ?>
</tr></table>

<? } // show_navigation?>

<table border="0" cellspacing="0" width="700px"  >
<tr>
    <td colspan="3" valign="bottom">
			<table id="breadcrumbs" ><tr><?php if ($show_navigation){ echo $breadcrumbs; }?></tr></table>    </td>
</tr>
<tr>
    <td valign="top" width="<? if($show_navigation){ echo "120";}else{ echo "0";} ?>" align="left">
        <?php
       
        if ($show_navigation){
		 echo $toc; }       
      
        ?>    
	
    <? if ($page){
		// para ver 
		
		$tip = get_record('hiperbook_chapters_tips', 'chapterid', $chapterid);
		$suggestion= get_record('hiperbook_chapters_suggestions', 'chapterid', $chapterid);
		$exercise= get_record('hiperbook_chapters_exercises', 'chapterid', $chapterid);
		$glossary = get_records_sql(" select h.title, h.content from ". $CFG->prefix."hiperbook_chapters c,". $CFG->prefix."hiperbook_chapters_hotword h where c.bookid = '$book->id' and c.id = h.chapterid",true);
		?>	 
	<div id='botoesLateral' style="vertical-align:bottom">
    <? if($glossary){	?>    
    <a href="javascript:void(0);"  onmouseout="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1','','images/bot1b.gif',1)" onClick="javascript:window.open('glossary.php?chapterid=<?= $chapterid ?>&edit=<?= $edit ?>&id=<?=  $cm->id ?>','dicas','menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=739,height=450,left=80,top=80')"><img src="images/bot1a.gif" name="Image1" border="0" /></a><img src="images/spacer.gif" width="15" height="10" /><? } 
	 if($suggestion){	?><a href="javascript:void(0);" onClick="javascript:window.open('suggestions.php?chapterid=<?= $chapterid ?>&edit=<?= $edit ?>&id=<?=  $cm->id ?>','dicas','menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=739,height=450,left=80,top=80')" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','images/bot3b.gif',1)"><img src="images/bot3a.gif" name="Image3" border="0" /></a> <? } ?></div>
    <?
}  ?>	

		
		</td>
    <td valign="top" colspan="2" >
        <?php

       // print_simple_box_start('middle', '100%');
        
       if ($page){
			$conteudo = $page->content;
		}
		
        $nocleanoption = new object();
        $nocleanoption->noclean = true;
        echo '<div class="hiperbook_content">';		
		$hotwords = get_records_select('hiperbook_chapters_hotword', 'chapterid='.$chapterid, 'id');	
		$links = get_records_select('hiperbook_chapters_links', 'chapterid='.$chapterid, 'id');		
		$tips = get_records_select('hiperbook_chapters_tips', 'chapterid='.$chapterid, 'id');		
		$suggestions = get_records_select('hiperbook_chapters_suggestions', 'chapterid='.$chapterid, 'id');		
		//var_dump($tips);
		// links antes para nao colocar o link dentro do hottext
		$conteudo = hiperbook_link_links($conteudo, $links,$cm->id, $navigationnum );
		// glossario
		$conteudo = hiperbook_link_hotwords($conteudo, $hotwords);		
		// comentarios
		$conteudo = hiperbook_link_tips($conteudo, $tips);
		// bibliografia
		$conteudo = hiperbook_link_suggestions($conteudo, $suggestions);
		
		echo format_text($conteudo, FORMAT_HTML, $nocleanoption, $course->id);
		//echo $conteudo;
        echo '</div>';
        //print_simple_box_end();

        
        ?>    </td>
</tr>
</table>
<table align="center">
<tr>
<!--td colspan="2"  ></td-->

<td valign="top" align="center"> <?php echo '<div  id="page_navigation">'.$pgnavigation.'';?> <form action="<?php echo $PHP->SELF ?>">
  Ir para p&aacute;gina 
  <input type="hidden" name="id" id="id" value="<?php echo $id ;?>">
  <input type="hidden" name="chapterid" id="chapterid" value="<?php echo  $chapterid;?>">
  <input type="hidden" name="navigationnum" id="navigationnum" value="<?php echo $navigationnum;?>">
  <input type="hidden" name="show_navigation" id="show_navigation" value="<?php echo  $show_navigation;?>">
  <input type="text" name="pagenum" id="pagenum" size="3">
   <input type="submit"  value="Vai">
</form>
</div></td>
</tr>
</table>
