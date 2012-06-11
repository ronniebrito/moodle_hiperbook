<?php  

require_once('../../config.php');
require_once('lib.php');

$id        = required_param('id', PARAM_INT);           // Course Module ID
$chapterid = optional_param('chapterid', 0, PARAM_INT); // Chapter ID
$pagenum     = optional_param('pagenum', 1, PARAM_INT);     // Edit mode


//adicionado para navegacao por paginas de capitulos
$navigationnum     = optional_param('navigationnum', 1, PARAM_INT);     // navegação padrao pelos conteudos 
$show_navigation     = optional_param('show_navigation', 1, PARAM_INT);     // se exibe ou nao a navegação 


if (!$cm = get_record('course_modules', 'id', $id)) {
    error('Course Module ID is incorrect');
}

if (!$course = get_record('course', 'id', $cm->course)) {
    error('Course is misconfigured');
}


//var_dump($cm);
if (!$book = get_record('hiperbook', 'id', $cm->instance)) {
    error('Course module is incorrect');
}

// =========================================================================
// security checks START - teachers edit; students view
// =========================================================================

$page = get_record('hiperbook_chapters_pages', 'chapterid', $chapterid,'pagenum',$pagenum);

$chapter = get_record('hiperbook_chapters', 'chapterid', $chapterid);






?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf_8" />
<title><?php echo $chapter->title; ?></title>

<?


// apos ter lido o capitulo, busca o conteudo da pagina passada por parametro
$page = get_record('hiperbook_chapters_pages', 'chapterid', $chapterid,'pagenum',$pagenum);
$totalpages = count_records('hiperbook_chapters_pages', 'chapterid', $chapterid);

	
	// =========================================================================
	// security checks  END
	// =========================================================================
	
	
	///read standard strings
	$strbooks = get_string('modulenameplural', 'hiperbook');
	$strbook  = get_string('modulename', 'hiperbook');
	$strTOC = get_string('TOC', 'hiperbook');
	
		
	
	// =====================================================
	// Book display HTML code
	// =====================================================

?>
			
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

// parse no stilo pra buscar arquivos e mudar a referencia 
// ja foram copiados por parse_pages
	
	
//$conteudoCSS =	hiperbook_parse_copy_resourses($book->template_css, $book->id) ;

//echo 'CSS conteudo';



echo $CFG->default_template_css;
echo $book->template_css;

// define a classe dos navpaths com imagens dos caminhos
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


body{ 
	margin-left:0;
	margin-top:0;
	
}
</style>

  <script src="../../assets/prototype.js" type="text/javascript"></script>
  <script src="../../assets/effects.js" type="text/javascript"></script>
  <script src="../../assets/dragdrop.js" type="text/javascript"></script>
  <script src="../../assets/popup.js" type="text/javascript"></script>

<script language="JavaScript" src="../../assets/findAPI.js"></script>
<script language="JavaScript" src="../../assets/ufo.js"></script>
<? // TRATA DO JS para status do scorm

//se primeira pagina do sco
if ($pagenum == 1) {
	// insere LMSinit 
 ?>	<script type="text/javascript"> API.LMSInitialize("") </script> <?
}
?>  
<script type="text/javascript"> API.setValue("cmi.core.lesson_status", "browsed")</script>
<?
// se ultima pagina
if ( $pagenum == $totalpages ) {
// eh a ultima, insere LMSfinish
 ?>	<script type="text/javascript"> API.LMSFinish("") </script> <?
}
?> 

</head>
<div id="mod-hiperbook-popup" class="mod-hiperbook"><div id="page">
  
				<?php
				
				//define custom images		
				//echo $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/'.$book->img_page_next;			
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
			$pgnavigation .= '<a  href="'.$prevpage .'.html"><img src="'.$img_page_prev.'"/></a>';
		} 	
		if ($totalpages > 1){ $pgnavigation .= get_string('page','hiperbook')." <b>". $pagenum . '</b>'.get_string('from','hiperbook').'<b>'. $totalpages."</b> "; }		
		if ($nextpage !='') {
			$pgnavigation .= '<a href="'.$nextpage .'.html"><img src="'.$img_page_next.'"/></a>';
		}			
	}	
	
		?>
 
<table border="0" cellspacing="0" width="700px"  >
<tr>
   
    <td valign="top" colspan="3" >
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
<table>
<tr>
<td colspan="3" > 
    <? if ($page){
		// para ver 
		
		$suggestion= get_records_sql('select * from '.$CFG->prefix.'hiperbook_pages_suggestions ph, '.$CFG->prefix.'hiperbook_chapters_suggestions ch where ph.idpage = '.$page->id.' and ph.idsuggestion= ch.id'); 
		
		$glossary = get_records_sql('select * from '.$CFG->prefix.'hiperbook_pages_hotwords ph, '.$CFG->prefix.'hiperbook_chapters_hotword ch where ph.idpage = '.$page->id.' and ph.idhotword= ch.id'); 
		?>	 
	<div id='botoesLateral' >
    <? if($page){	
   
    if($glossary){	?>
		    <a href="javascript:void(0);" onClick="javascript:window.open('../hotwords/index.html','dicas','menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=600,height=450,left=80,top=80')"><img src="<?php echo $img_hotwords_icon; ?>" border="0" /></a>
		 <? }
		  if($suggestion){	?> 
		 <a href="javascript:void(0);" onClick="javascript:window.open('../bibliography/index.html','dicas','menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=600,height=450,left=80,top=80')" ><img src="<?php echo $img_suggestions_icon; ?>" border="0" /></a>
		  <? } 		  
     } ?>
	</div>
    <?
}  ?>	
</td>
<td valign="top" align="center"> <?php echo '<div  id="page_navigation">'.$pgnavigation.'</div>';?></td>
</tr>
</table><script defer="defer" src="../../assets/eolas_fix.js" type="text/javascript">// <![CDATA[ ]]></script>
</div></div>
</body>