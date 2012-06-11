<?PHP // $Id: edit.php,v 1.15 2005/07/14 20:58:07 skodak Exp $

require_once('../../config.php');
require_once('lib.php');

$pagenum    = optional_param('pagenum', 1, PARAM_INT); //-> pagenum virou chapternum
$delete    = optional_param('delete', 0, PARAM_INT); //-> para apagar
$addprev    = optional_param('addprev', 0, PARAM_INT); //-> para apagar
$addnext    = optional_param('addnext', 0, PARAM_INT); //-> para apagar
$id         = required_param('id', PARAM_INT);
$groupid = optional_param('groupid',0,PARAM_INT);

$target_navigation_chapter     = required_param('target_navigation_chapter', PARAM_INT);     // navegação padrao pelos 

// =========================================================================
// security checks START - only teachers edit
// =========================================================================

require_login();

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

$navchapter = get_record('hiperbook_navigation_chapters', 'id',$target_navigation_chapter);


if (!$chapter = get_record('hiperbook_chapters', 'id', $navchapter->chapterid)) {
    error('Chapter is misconfigured');
}
if (!isteacheredit($course->id)&($chapter->opentostudents==0)) {
    error('Only editing teachers can edit hiperbooks!', $_SERVER['HTTP_REFERER']);
}

if (($addprev==0)&($addnext==0)){
	$page = get_record('hiperbook_chapters_pages', 'chapterid', $navchapter->chapterid, 'pagenum', $pagenum);
}

// =========================================================================
// security checks END
// =========================================================================


$usehtmleditor = can_use_html_editor();

if($delete == 1){
//echo 'apaga'; 

// apaga a pagina com pagenum do parametro, subtraindo 1 de pagenum das paginas com pagenum > pagenum apagada
delete_records('hiperbook_chapters_pages','chapterid', $chapter->id,'pagenum',$pagenum);
	
$err = execute_sql("update ". $CFG->prefix."hiperbook_chapters_pages set pagenum = (pagenum -1) where chapterid = '$chapter->id' and pagenum > '$pagenum'");
$npnum = $page->pagenum-1;
redirect("view.php?id=$cm->id&target_navigation_chapter=$navchapter->id&pagenum=$npnum&groupid=$groupid");
}


/// If data submitted, then process and store.
if (($form = data_submitted()) && (confirm_sesskey())) {
    //TODO: skip it for now
    //prepare data - security checks
    //$form->title = clean_text($form->title, FORMAT_HTML);
    //$form->content = clean_text($form->content, FORMAT_HTML);
//var_dump($form);

//var_dump(data_submitted());

//$db->debug=true;
	//die();
    if (!isset($form->parentchapterid) ) {       
        $form->parentchapterid =  0;
    }
    if ($page) {
        /// editing existing page		
		
		$page->pagenum = $form->pagenum;        
        $page->timemodified = time();
			$page->content =  $form->content;
		//var_dump($page);		
		
        if (!update_record('hiperbook_chapters_pages', $page,'pageid')) {
            error('Could not update your hiperbook!');
         }
        add_to_log($course->id, 'course', 'update mod', '../mod/hiperbook/view.php?id='.$cm->id, 'hiperbook '.$book->id);
        add_to_log($course->id, 'hiperbook', 'update', '../mod/hiperbook/view.php?id='.$cm->id.'&chapterid='.$chapter->id, $book->name.' page update', $cm->id);
    } else {
	
	// creating new page
		$db->debug = true;
		if($form->addnext==1){
		    // move as paginas posteriores p frente e adiciona uma apos a atual
			execute_sql("update ". $CFG->prefix."hiperbook_chapters_pages set pagenum = (pagenum + 1) where chapterid = '$chapter->id' and pagenum > '$pagenum'");
			$page->pagenum = $form->pagenum + 1; //place after given pagenum, lets hope it is a number
		}
		if($form->addprev==1){
			// move as paginas posteriores e a atual p frente e adiciona no lugar da atual
			execute_sql("update ". $CFG->prefix."hiperbook_chapters_pages set pagenum = (pagenum + 1) where chapterid = '$chapter->id' and pagenum >= '$pagenum'");
			$page->pagenum = $form->pagenum; //place after given pagenum, lets hope it is a number	
		}
		if(($form->addprev==0)&($form->addnext==0)){
			$page->pagenum = $form->pagenum; 
		}else{
		
		}		
		//var_dump($form);
			/// adding new page (the first one)
			$page->content =  $form->content;
			$page->chapterid = $form->chapterid;
			$page->groupid = $form->groupid;
			$page->opentostudents = $form->opentostudents;
			$page->userid = $USER->id;
			$page->idhiperbook = $cm->instance;
			$page->hidden = 0;
			$page->timecreated = time();
			$page->timemodified = $page->timecreated;  
		//	$db->debug = true;      
			if (!$page->id = insert_record('hiperbook_chapters_pages', $page)) {
				error('Could not insert a new page!');
			}		
        add_to_log($course->id, 'course', 'update mod', '../mod/hiperbook/view.php?id='.$cm->id, 'hiperbook '.$book->id);
        add_to_log($course->id, 'hiperbook', 'update', '../mod/hiperbook/view.php?id='.$cm->id.'&chapterid='.$chapter->id, $book->id, $cm->id);
    }
//	var_dump($page); die();
// /view.php?id=391&chapterid=5924&navigationnum=1&parentnavchapterid=20&groupid=0
    redirect("view.php?id=$cm->id&target_navigation_chapter=$navchapter->id&pagenum=$page->pagenum&groupid=$groupid");
    
}

/// Otherwise fill and print the form.
$strbook = get_string('modulename', 'hiperbook');
$strbooks = get_string('modulenameplural', 'hiperbook');
$stredit = get_string('edit');
$pageheading = get_string('editingpage', 'hiperbook');

$usehtmleditor = can_use_html_editor();

if (!$page) {
    $page->chapterid = $chapterid;
    $page->pagenum = $pagenum;
    $page->content = $book->template_main;
	$page->opentostudents = $chapter->opentostudents;	
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
			

$icon = '<img align="absmiddle" height="16" width="16" src="icon_chapter.gif" />&nbsp;';
print_heading_with_help($pageheading, 'edit', 'hiperbook', $icon);
print_simple_box_start('center', '');

	
	
include('page.html');


print_simple_box_end();

if ($usehtmleditor ) {
    use_html_editor();
}

print_footer($course);


?>
