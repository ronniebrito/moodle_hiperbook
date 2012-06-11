<?PHP // $Id: view.php,v 1.17 2005/08/25 19:33:12 skodak Exp $

require_once('../../config.php');
require_once('lib.php');

$id        = required_param('id', PARAM_INT);           // Course Module ID
$chapterid = optional_param('chapterid', 0, PARAM_INT); // Chapter ID
$edit      = optional_param('edit', -1, PARAM_BOOL);     // Edit mode

//adicionado para navegacao por paginas de capitulos
$pagenum     = optional_param('pagenum', 1, PARAM_INT);     // Edit mode
$delete      = optional_param('delete', 0, PARAM_INT);     // Edit mode
$hotwordid      = optional_param('hotwordid', 0, PARAM_INT);     // Edit mode

// =========================================================================
// security checks START - teachers edit; students view
// =========================================================================
/*if ($CFG->forcelogin) {
    require_login();
}*/

if (!$cm = get_record('course_modules', 'id', $id)) {
    error('Course Module ID is incorrect');
}

if (!$course = get_record('course', 'id', $cm->course)) {
    error('Course is misconfigured');
}

if ($course->category) {
    //require_login($course->id);
}

if (!$book = get_record('hiperbook', 'id', $cm->instance)) {
    error('Course module is incorrect');
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




if (!$cm->visible and !$isteacher) {
    notice(get_string('activityiscurrentlyhidden'));
}

if($delete){
//	$db->debug = true;
	delete_records('hiperbook_chapters_hotword', 'id', $hotwordid);
	delete_records('hiperbook_pages_hotwords', 'idhotword', $hotwordid);
}

//$db->debug = true;
/// read chapter hotwords
$hotwords = get_records_sql("select h.id, h.title, h.content from ". $CFG->prefix."hiperbook_chapters_hotword h where h.idhiperbook = '$book->id' order by h.title",false);


/// check chapterid and read chapter data



	add_to_log($course->id, 'hiperbook', 'view', 'glossary.php?id='.$cm->id.'&chapterid='.$chapter->id, $book->id, $cm->id);
	
	
	///read standard strings
	$strbooks = get_string('modulenameplural', 'hiperbook');
	$strbook  = get_string('modulename', 'hiperbook');
	$strTOC = get_string('TOC', 'hiperbook');
	
	
	print_header( "",null,
				  "",
				  '',
				  '<style type="text/css">@import url('.$CFG->wwwroot.'/mod/hiperbook/book_theme.css);</style>',
				  true,
				  null,
				  null
				);
				
?>	<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}

.corpotexto {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #003366; text-align: left; line-height: 15px}

#mod-hiperbook-glossary  #header{
	display:none;
	}

	<?php
echo $CFG->default_template_css;
echo $book->template_css;
?>
-->
</style>
<div id='topo_hotword'><img src="<?php echo $CFG->wwwroot."/file.php/".$course->id."/template_hiperbook". $book->id."/".$book->img_hotwords_top ?>" /></div>
<table border="0" cellspacing="0" width="100%" >
<tr>   
    <td valign="top" align="right">
        <?php

       // print_simple_box_start('middle', '100%');        
       
		
        $nocleanoption = new object();
        $nocleanoption->noclean = true;
		
		$conteudo .= '<div >';	
		$conteudo .=  '<table  class="hotwordslist">';		

		foreach($hotwords as $hotword){		
			$conteudo .=  '<tr>';
			$conteudo .=  '<td class="title"><a id="'.$hotword->title.'" />'.$hotword->title.'</td>';
			$conteudo .=  '</tr>';
			$conteudo .= '<tr>';
			$conteudo .= '<td class="content">'. $hotword->content;
			if ($isteacher) {  $conteudo .= '<a href="glossary.php?hotwordid='.$hotword->id.'&id='.$cm->id.'&delete=1&chapterid='.$chapterid.'&pageid='.$pageid.'&groupid='.$groupid.'"><img src="'.$CFG->pixpath.'/t/delete.gif" border="0"></a>';  }

$conteudo .= '<hr></td></tr>';
			
		}
		$conteudo .= '</table>';		
		echo format_text($conteudo, FORMAT_HTML, $nocleanoption, $course->id);
        echo '</div>';
        //print_simple_box_end();

       
        ?>    </td>  
</tr>
</table>
