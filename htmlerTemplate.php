<?PHP // $Id: view.php,v 1.17 2005/08/25 19:33:12 skodak Exp $
		
require_once('../../config.php');
require_once('lib.php');

//$db->debug = true;



$id        = required_param('id', PARAM_INT);           // Course Module ID
$chapterid = optional_param('chapterid', 0, PARAM_INT); // Chapter ID
$edit      = optional_param('edit', -1, PARAM_BOOL);     // Edit mode
$pop_up        = optional_param('pop_up', PARAM_INT,0);           // pop up mode

//adicionado para navegacao por paginas de capitulos
$pagenum     = optional_param('pagenum', 1, PARAM_INT);     // Edit mode
$navigationnum     = optional_param('navigationnum', 1, PARAM_INT);     // navegação padrao pelos conteudos 
$parentnavchapterid = optional_param('parentnavchapterid', 0, PARAM_INT); // Chapter ID

$show_navigation     = optional_param('show_navigation', 1, PARAM_INT);     // se exibe ou nao a navegação 
//$db->debug = true;
// =========================================================================
// security checks START - teachers edit; students view
// =========================================================================


if (!$cm = get_record('course_modules', 'id', $id)) {
    error('Course Module ID is incorrect');
}

if (!$course = get_record('course', 'id', $cm->course)) {
    error('Course is misconfigured');
}


if (!$book = get_record('hiperbook', 'id', $cm->instance)) {
    error('Course module is incorrect');
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $chapter->title; ?></title><?php 
// busca a navegacao atual
$navpath = get_record('hiperbook_navigationpath', 'navpathnum',$navigationnum, 'bookid',$book->id);
//var_dump($navpath);

//busca o hiperbook_navigation_chapters do capitulo atual na navegacao atual
$navchapter = get_record('hiperbook_navigation_chapters', 'chapterid',$chapterid, 'navigationid',$navpath->id, 'parentnavchapterid' , $parentnavchapterid);

$navchapterid = $navchapter->id;
if(!$navchapterid){ $navchapterid = 0; } // se nao encontrou um navchapter, esta na raiz


/// read chapters
// busca os capitulos q aparecem na area lateral em funcao do parametro chapterid
// se chapterid = null, entao esta no inicio e busca os capitulos com parentchapter = 0
// senao busca capitulos com parentchapter = chapterid 

$select = $isteacher ? "" : " AND hidden = '0'";
$chapters = get_records_sql('select c.id id, c.hidden hidden, c.title title, n.chapternum chapternum, n.parentnavchapterid parentnavchapterid, c.opentostudents opentostudents from '.$CFG->prefix.'hiperbook_chapters c, '.$CFG->prefix.'hiperbook_navigation_chapters n,'.$CFG->prefix.'hiperbook_navigationpath p where c.bookid='.$book->id.' and n.parentnavchapterid ='. $navchapterid .' and n.chapterid = c.id and n.navigationid = p.id and p.navpathnum ='.$navigationnum . $select. " order by chapternum"); 


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

$totalpages = count(get_records('hiperbook_chapters_pages', 'chapterid', $chapter->id));


$pageid = $page->id;
		
	///read standard strings
	$strbooks = get_string('modulenameplural', 'hiperbook');
	$strbook  = get_string('modulename', 'hiperbook');
	$strTOC = get_string('TOC', 'hiperbook');
	
	

				
			?>
<!-- popups inspired by DOM popup kit 

http://www.methods.co.nz/popup/popup.html

 -->
	
				
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

<?php 

// parse no stilo pra buscar arquivos e mudar a referencia 
// ja foram copiados por parse_pages
	
	
//$conteudoCSS =	hiperbook_parse_copy_resourses($book->template_css, $book->id) ;

//echo 'CSS conteudo';



echo $CFG->default_template_css;
echo $book->template_css;

// define a classe dos navpaths com imagens dos caminhos
?>

</style>

  <script src="../../assets/prototype.js" type="text/javascript"></script>
  <script src="../../assets/effects.js" type="text/javascript"></script>
  <script src="../../assets/dragdrop.js" type="text/javascript"></script>
  <script src="../../assets/popup.js" type="text/javascript"></script>
  <script type="text/javascript" src="../../assets/ufo.js"></script>

</head>
<body>
<div id="mod-hiperbook-popup" class="mod-hiperbook"><div id="page">
  <img src="<?php echo $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'.$book->img_top_popup; ?>" alt="top" height="50">
				<?php
				
				//define custom images					
		if ($book->img_page_next ){ 
			$img_page_next = $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'.$book->img_page_next;
			
		}else{
			$img_page_next = "../../assets/images/next.gif";
		}
		
		
		if ($book->img_page_prev ){ 
			$img_page_prev = $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'.$book->img_page_prev;
		}else{
			$img_page_prev = "../../assets/images/back.gif";
		}
		
		
		if ($book->img_separador_toc ){ 
			$img_separador_toc = $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'.$book->img_separador_toc;
		}else{
			$img_separador_toc = "../../assets/images/separador_toc.jpg";
		}
		
		if ($book->img_hotwords_top ){ 
			$img_hotwords_top = $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'.$book->img_hotwords_top;
		}else{
			$img_hotwords_top = "../../assets/images/title_hotwords.jpg";
		}
		
		if ($book->img_tips_top ){ 
			$img_tips_top = $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'.$book->img_tips_top;
		}else{
			$img_tips_top = "../../assets/images/title_tips.jpg";
		}
		
		
		if ($book->img_suggestions_top ){ 
			$img_suggestions_top = $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'.$book->img_suggestions_top;
		}else{
			$img_suggestions_top = "../../assets/images/title_suggestions.jpg";
		}
		
		if ($book->img_links_top ){ 
			$img_links_top = $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'.$book->img_links_top;
		}else{
			$img_links_top = "../../assets/images/img_links_top.jpg";
		}
		
		if ($book->img_hotwords_icon ){ 
			$img_hotwords_icon = $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'.$book->img_hotwords_icon;
		}else{
			$img_hotwords_icon = "../../assets/images/bot1a.gif";
		}
		
		if ($book->img_tips_icon ){ 
			$img_tips_icon = $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'.$book->img_tips_icon;
		}else{
			$img_tips_icon = "../../assets/images/bot4a.gif";
		}
		
		if ($book->img_suggestions_icon ){ 
			$img_suggestions_icon = $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'.$book->img_suggestions_icon;
		}else{
			$img_suggestions_icon = "../../assets/images/bot3a.gif";
		}
		
		if ($book->img_links_icon ){ 
			$img_links_icon = $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'.$book->img_links_icon;
		}else{
			$img_links_icon = "../../assets/images/bot2a.gif";
		}
				
				// prepare $toc and $currtitle, $currsubtitle
	require('tocHTMLer.php');
	
		$tocwidth = $CFG->book_tocwidth;
	
	/// prepare chapter navigation icons	
	// a navegacao pelos capitulos ocorre exclusivamente pela arvore e breadcrumbs
	// passa-se a utilizar a navegacao para as paginas apenas	
	
	$pagenum = $page->pagenum;
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
		
		if ($prevpage!='') {
			$pgnavigation .= '<a  href="'.$prevpage .'.html"><img src="'.$img_page_prev.'"/></a> ';
		} 	
		if ($totalpages > 1){ $pgnavigation .= get_string('page','hiperbook')." <b>". $pagenum . '</b> '.get_string('from','hiperbook').' <b>'. $totalpages." </b> "; }		
		if ($nextpage !='') {
			$pgnavigation .= '<a href="'.$nextpage .'.html"><img src="'.$img_page_next.'"/></a>';
		}			
	}	
	
//	var_dump($pgnavigation);
	
	
if($navchapter->id !=0){
		$breadcrumbs .= '<td id="current"><div id="start">&nbsp;</div><div id="main"><a href="../navpaths/indexnavpath'.$navigationnum.'.html">'. $navpath->name.'</a></div><div id="end">&nbsp; </div></td>'. hiperbook_link_parent_chapters_html($navchapter->id, $cm, $groupid);	
}

	
	// =====================================================
	// Book display HTML code
	// =====================================================

?><div id="bookname"><?= $book->name; ?></div><? 
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

?>
<table id="navpaths"><tr>
<?
if(count($navpaths) > 1){	
	foreach($navpaths as $np){		
		if($np->navpathnum == $navigationnum) { 
			?> <td id="current" ><? if ($np->navpathnum=='1'){ ?> <div id="start">&nbsp;</div><? } ?><div id="main"> <?= $np->name; ?> </div><? if ($np->navpathnum==count($navpaths)){ ?><div id="end">&nbsp;</div><? } ?></td> <?
		}else{
			?>
			<td id="past" ><? if ($np->navpathnum=='1'){ ?> <div id="start">&nbsp;</div><? } ?><div id="main"><a href="../navpaths/indexnavpath<?= $np->navpathnum ?>.html"> <?= $np->name ?> </a></div><? if ($np->navpathnum==count($navpaths)){ ?><div id="end">&nbsp;</div><? } ?></td><? 
		} 
	}
}

?>
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
			$conteudo = $page->content;
		}
		
        $nocleanoption = new object();
        $nocleanoption->noclean = true;
        echo '<div class="hiperbook_content">';		
		
		$hotwords = get_records_sql('select * from '.$CFG->prefix.'hiperbook_pages_hotwords ph, '.$CFG->prefix.'hiperbook_chapters_hotword ch where ph.idpage = '.$page->id.' and ph.idhotword= ch.id'); 
				
		$links = get_records_select('hiperbook_chapters_links', 'chapterid='.$chapterid, 'id');		
		
		$tips =  get_records_sql('select * from '.$CFG->prefix.'hiperbook_pages_tips ph, '.$CFG->prefix.'hiperbook_chapters_tips ch where ph.idpage = '.$page->id.' and ph.idtip = ch.id'); 
		
		$suggestions = get_records_sql('select * from '.$CFG->prefix.'hiperbook_pages_suggestions ph, '.$CFG->prefix.'hiperbook_chapters_suggestions ch where ph.idpage = '.$page->id.' and ph.idsuggestion= ch.id'); 
	
		$conteudo = hiperbook_link_links($conteudo, $links,$cm->id, $navigationnum, $parentnavchapterid);
		// glossario
		$conteudo = hiperbook_link_hotwords($conteudo, $hotwords);		
		// comentarios
		$conteudo = hiperbook_link_tips($conteudo, $tips);
		
		// bibliografia
		$conteudo = hiperbook_link_suggestions($conteudo, $suggestions);
		//echo $conteudo;
		$conteudo = str_replace(".flv",".flv?d=300x250", $conteudo);
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

//$tip = get_records('hiperbook_pages_tips', 'idpage', $pageid);

$suggestion= get_records('hiperbook_chapters_suggestions', 'idhiperbook', $book->id);
$glossary = get_records('hiperbook_chapters_hotword', 'idhiperbook', $book->id);
		
//$glossary = get_records_sql(" select h.title, h.content from ". $CFG->prefix."hiperbook_chapters c,". $CFG->prefix."hiperbook_chapters_hotword h where c.bookid = '$book->id' and c.id = h.chapterid",true);
		
	
	 // soh mostra glossario e bibliografia (suggestions)
		   if($glossary){	?>
		    <a href="javascript:void(0);" onClick="javascript:window.open('../hotwords/index.html','glossario','menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=800,height=450,left=80,top=80')"><img src="<?php echo $img_hotwords_icon; ?>" border="0" /></a>
		 <? }
		  if($suggestion){	?> 
		 <a href="javascript:void(0);" onClick="javascript:window.open('../bibliography/index.html','bibliografia','menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=800,height=450,left=80,top=80')" ><img src="<?php echo $img_suggestions_icon; ?>" border="0" /></a>
		  <? } 		  
	
} // page ?></div>

</td>
<td valign="top"> <?php echo '<div  id="page_navigation">'.$pgnavigation.'</div>';?></td>
</tr>
</table>
<script defer="defer" src="../../assets/eolas_fix.js" type="text/javascript">// <![CDATA[ ]]></script>
</div></div>
</body>
