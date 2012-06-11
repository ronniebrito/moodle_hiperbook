<?PHP // $Id: delete.php,v 1.11 2005/07/14 20:58:08 skodak Exp $

require('teacheraccess.php'); //page only for teachers
$confirm = optional_param('confirm', 0, PARAM_BOOL);
$justnavpath = optional_param('justnavpath', 0, PARAM_BOOL);

$id        = required_param('id', PARAM_INT);           // Course Module ID

$chapterid = optional_param('chapterid', 0, PARAM_INT); // Chapter ID
///header and strings
$strbooks = get_string('modulenameplural', 'hiperbook');
$strbook  = get_string('modulename', 'hiperbook');

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
if (!$chapter= get_record('hiperbook_chapters', 'id', $chapterid)) {
    error('Chapter is incorrect');
}

if ($course->category) {
    $navigation = '<a href="../../course/view.php?id='.$course->id.'">'.$course->shortname.'</a> ->';
} else {
    $navigation = '';
}

print_header( "$course->shortname: $hiperbook->name",
              $course->fullname,
              "$navigation <a href=index.php?id=$course->id>$strbooks</a> -> $book->name" ,
              '',
              '',
              true,
              '',
              ''
            );

var_dump($justnavpath);
var_dump($confirm);


// remove apenas a navegacao
if(($justnavpath==1)&($confirm==1)){

	 	
	add_to_log($course->id, 'course', 'update mod', '../mod/hiperbook/view.php?id='.$cm->id, 'hiperbook '.$book->id);
	add_to_log($course->id, 'hiperbook', 'update', 'view.php?id='.$cm->id, $book->id, $cm->id);  
	
	$navpath = get_record('hiperbook_navigationpath', 'navpathnum',$navigationnum, 'bookid',$cm->instance);
	$navchapter = get_record('hiperbook_navigation_chapters', 'chapterid',$chapterid, 'navigationid',$navpath->id);
	$parentnavchapter =  get_record('hiperbook_navigation_chapters', 'id',$navchapter->parentnavchapterid, 'navigationid',$navpath->id);
	
hiperbook_remove_chapter_navpath($chapterid,$navigationnum,$navchapter->parentnavchapterid->id,$cm);   	
 redirect("view.php?id=$cm->id&chapterid=$parentnavchapter->chapterid&navigationnum=$navigationnum&target_navigation_chapter=$parentnavchapter->id");
		
}


///remove o capitulo e todas a navegacoes
if (($confirm==2)&($justnavpath==0)) {  // the operation was confirmed.
echo "kapput";
	add_to_log($course->id, 'course', 'update mod', '../mod/hiperbook/view.php?id='.$cm->id, 'hiperbook '.$book->id);
	add_to_log($course->id, 'hiperbook', 'update', 'view.php?id='.$cm->id, $book->id, $cm->id);  
	$navpath = get_record('hiperbook_navigationpath', 'navpathnum',$navigationnum, 'bookid',$cm->instance);
	$navchapter = get_record('hiperbook_navigation_chapters', 'chapterid',$chapterid, 'navigationid',$navpath->id);
	$parentnavchapter =  get_record('hiperbook_navigation_chapters', 'id',$navchapter->parentnavchapterid, 'navigationid',$navpath->id);
	hiperbook_remove_chapter($chapterid,$cm); 
 redirect("view.php?id=$cm->id&chapterid=$parentnavchapter->chapterid&navigationnum=$navigationnum&target_navigation_chapter=$parentnavchapter->id");
		
} 

		
if(($justnavpath==0)&($confirm==0)){
	// não se sabe se deseja apagar apenas a nevagação ou o capitulo todo
		
		$strconfirm = "Deseja apagar apenas a navegação pelo capítulo? <br><br>
		Se <b>sim</b>, irá apagar apenas a indicação deste capítulo neste nível. Posteriormente você poderá utilizar este capítulo criando um link;<br><br>
		Se <b>não</b>, irá apagar o capitulo e sub capítulos, dicas e etc em todos os níveis. O capítulo é apagado em definitivo;";		
		echo '<br />';
		notice_yesno("<b>$chapter->title</b><p>$strconfirm</p>",
					  "delete.php?id=$cm->id&chapterid=$chapterid&justnavpath=1&confirm=1&sesskey=$USER->sesskey&navigationnum=$navigationnum",
					  "delete.php?id=$cm->id&chapterid=$chapterid&justnavpath=0&confirm=1&sesskey=$USER->sesskey&navigationnum=$navigationnum");
}

if(($confirm==1)&($justnavpath==0)) {
			// the operation has not been confirmed yet so ask the user to do so
			if ($chapter->subchapter) {
				$strconfirm = get_string('confchapterdelete','hiperbook');
			} else {
				$strconfirm = get_string('confchapterdeleteall','hiperbook');
			}
			echo '<br />';
			notice_yesno("<b>$chapter->title</b><p>$strconfirm</p>",
						  "delete.php?id=$cm->id&chapterid=$chapterid&justnavpath=0&confirm=2&sesskey=$USER->sesskey&navigationnum=$navigationnum",
						  "view.php?id=$cm->id&chapterid=$chapterid&navigationnum=$navigationnum");
}

print_footer($course);

?>
