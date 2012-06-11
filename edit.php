<?PHP // $Id: edit.php,v 1.15 2005/07/14 20:58:07 skodak Exp $

require_once('../../config.php');
require_once('lib.php');

$id         = required_param('id', PARAM_INT);           // Course Module ID
$parentnavchapterid = required_param('parentnavchapterid',PARAM_INT);

$chapterid    = optional_param('chapterid', 1, PARAM_INT);
$chapternum    = optional_param('chapternum', 1, PARAM_INT);
$navigationnum = optional_param('navigationnum',1,PARAM_INT);
$groupid = optional_param('groupid',0,PARAM_INT);
$target_navigation_chapter = optional_param('target_navigation_chapter',0,PARAM_INT);

// =========================================================================
// security checks START - only teachers edit
// =========================================================================
require_login();

//$db->debug = true;
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

$groupmode = groupmode($course, $cm);

$navpath = get_record('hiperbook_navigationpath', 'navpathnum',$navigationnum, 'bookid',$book->id);	

// permiteeditar capitulo apenas se navpath estiver aberto ou para professores

if ( !isteacheredit($course->id) & ($navpath->opentostudents!=1 )) {
    error('Only editing teachers can edit books!', $_SERVER['HTTP_REFERER']);
}

$chapter = get_record('hiperbook_chapters', 'id', $chapterid);

//check all variables
unset($id);
unset($chapterid);


if ($chapter) {
    if ($chapter->bookid != $book->id) {//chapter id not in this book!!!!
        error('Chapter not part of this book!');
    }
 //   $chapternum = $chapter->chapternum;
} 

// =========================================================================
// security checks END
// =========================================================================


/// If data submitted, then process and store.
if (($form = data_submitted()) && (confirm_sesskey())) {


		//	$db->debug = true;
    if (!isset($form->parentnavchapterid) ) {       
        $form->parentnavchapterid =  0;
    }
    if ($chapter) {
        /// editing existing chapter
		
        $chapter->title = $form->title;
        $chapter->timemodified = time();        
        if (!update_record('hiperbook_chapters', $chapter)) {
            error('Could not update your book!');
         }
        add_to_log($course->id, 'course', 'update mod', '../mod/hiperbook/view.php?id='.$cm->id, 'hiperbook '.$book->id);
        add_to_log($course->id, 'hiperbook', 'update', 'view.php?id='.$cm->id.'&chapterid='.$chapter->id, $book->id, $cm->id);
    } else {
		// cadastro de novo capitulo
		if( $form->tipo == 'link'){ //link para um arquivo existente		 
			$chapter->id = $form->targetchapterid;			
		 }else{		 
			/// adding new chapter		
		
			// se o navpath estiver aberto, o capitulo tb estara 
			
			
        	$chapter->opentostudents= $navpath->opentostudents;	
					
			$chapter->userid = $USER->id;
        	$chapter->groupid = $form->groupid;	
			$chapter->bookid = $book->id;
			$chapter->title = $form->title;       
			$chapter->hidden = 0;
			$chapter->timecreated = time();
			$chapter->timemodified = time();	
			//var_dump($chapter);			
			if (!$chapter->id = insert_record('hiperbook_chapters', $chapter)) {
				error('Could not insert a new chapter!');
			}
		}
		// define o navpath dentro do navigationnum
		$navpath = get_record('hiperbook_navigationpath', 'bookid', $book->id,'navpathnum',$form->navigationnum);		
		//var_dump($navpath);
		$navigationchapter->navigationid =  $navpath->id;
		$navigationchapter->chapterid = $chapter->id;	
			
			
			$navpath = get_record('hiperbook_navigationpath', 'navpathnum',$navigationnum, 'bookid',$book->id);	
			
			
		$chapternum = get_record_sql('select max(chapternum) newchapternum from '.$CFG->prefix.'hiperbook_navigation_chapters where parentnavchapterid = '.$parentnavchapterid. ' and navigationid='. $navpath->id);
							
		$navigationchapter->chapternum= $chapternum->newchapternum +1;
					
		$navigationchapter->parentnavchapterid = $form->parentnavchapterid;
	//var_dump($navigationchapter);
		if(!$navigationchapter->id = insert_record('hiperbook_navigation_chapters', $navigationchapter)) {
            error('Could not insert new chapter navigation!');
        }
		
		
		//var_dump($chapter);
        add_to_log($course->id, 'course', 'update mod', '../mod/hiperbook/view.php?id='.$cm->id, 'hiperbook '.$book->id);
        add_to_log($course->id, 'hiperbook', 'update', 'view.php?id='.$cm->id.'&chapterid='.$chapter->id, $book->id, $cm->id);
    }

	$navpath = get_record('hiperbook_navigationpath', 'navpathnum',$form->navigationnum, 'bookid',$cm->instance);
	$navchapter = get_record('hiperbook_navigation_chapters', 'chapterid',$chapter->id, 'navigationid',$navpath->id,'parentnavchapterid',$parentnavchapterid);
	$parentnavchapter =  get_record('hiperbook_navigation_chapters', 'id',$navchapter->parentnavchapterid, 'navigationid',$navpath->id);


   redirect("view.php?id=$cm->id&target_navigation_chapter=$target_navigation_chapter&groupid=$groupid&parentnavchapterid=$parentnavchapter->id&navigationnum=$navigationnum");

//http://www.avaad.ufsc.br/hiperlab/avaadteste/moodle/mod/hiperbook/view.php?id=809&chapterid=944&navigationnum=1&groupid=0&parentnavchapterid=801


//http://www.avaad.ufsc.br/hiperlab/avaadteste/moodle/mod/hiperbook/view.php?id=809&chapterid=944&navigationnum=1&parentnavchapterid=9354&groupid=0

}

/// Otherwise fill and print the form.
$strbook = get_string('modulename', 'hiperbook');
$strbooks = get_string('modulenameplural', 'hiperbook');
$stredit = get_string('edit');
$pageheading = get_string('editingchapter', 'hiperbook');

$usehtmleditor = can_use_html_editor();

if (!$chapter) {
    $chapter->id = 0;
    $chapter->title = '';  
}

///prepare the page header
if ($course->category) {
    $navigation = '<a href="../../course/view.php?id='.$course->id.'">'.$course->shortname.'</a> ->';
} else {
    $navigation = '';
}

print_header( "$course->shortname: $book->name",
              $course->fullname,
              "$navigation <a href=\"index.php?id=$course->id\">$strbooks</A> -> <a href=\"view.php?id=$cm->id\">$book->name</A> -> $stredit",
              '',
              '',
              true,
              '',
              ''
            );
//var_dump($chapter);

$icon = '<img align="absmiddle" height="16" width="16" src="icon_chapter.gif" />&nbsp;';
print_heading_with_help($pageheading, 'edit', 'hiperbook', $icon);

print_simple_box_start('center', '');
include('edit.html');
print_simple_box_end();

if ($usehtmleditor ) {
    use_html_editor();
}

print_footer($course);

?>
