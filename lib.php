<?PHP // $Id: lib.php,v 1.19 2005/08/27 16:20:31 skodak Exp $


define('NUM_NONE',     '0');
define('NUM_NUMBERS',  '1');
define('NUM_BULLETS',  '2');
define('NUM_INDENTED', '3');

require_once($CFG->libdir.'/filelib.php');

// $db->debug = true;
$NUMBERING_TYPE = array (NUM_NONE       => get_string('numbering0', 'hiperbook'),
                         NUM_NUMBERS    => get_string('numbering1', 'hiperbook'),
                         NUM_BULLETS    => get_string('numbering2', 'hiperbook'),
                         NUM_INDENTED   => get_string('numbering3', 'hiperbook') );

if (!isset($CFG->hiperbook_tocwidth)) {
    set_config("hiperbook_tocwidth", 180);  // default toc width
}


/// Library of functions and constants for module 'book'

function hiperbook_add_instance($book) {
/// Given an object containing all the necessary data,
/// (defined by the form in mod.html) this function
/// will create a new instance and return the id number
/// of the new instance.

	global $CFG;

    $book->timecreated = time();
    $book->timemodified = $book->timecreated;

	
	
		$book->template_hw = '';				 
		$book->template_tips = ''; 
		$book->template_suggs = '';
		$book->img_hotwords_top = 'title_hotwords.png';
		$book->img_tips_top = 'title_tips.png';
		$book->img_suggestions_top= 'title_suggestions.png';
		$book->img_links_top= 'title_links.png';
		
		$book->img_hotwords_icon = "icone_glossario.png";			
		$book->img_tips_icon = "icone_dicas.png";			
		$book->img_suggestions_icon = "icone_sugestoes_de_estudo.png";		
		$book->img_links_icon = "icone_links.png";			
		
		$book->img_top_popup = 'top.png';
		$book->img_page_next = 'next.png';
		$book->img_page_prev = 'back.png';
		$book->img_separador_toc = 'separador_toc.png';
		
		$book->img_navpath_active_start =  'navpath_current_start.png';
		$book->img_navpath_active_middle =   'navpath_current.png';
		$book->img_navpath_active_end	=  'navpath_current_end.png';			   
		$book->img_navpath_inactive_start =  'navpath_past_start.png';		
		$book->img_navpath_inactive_middle=  'navpath_past.png';		
		$book->img_navpath_inactive_end =  'navpath_past_end.png';		
		

   $bookid= insert_record('hiperbook', $book);
   $book->id = $bookid;
   
	$book->template_css = "
	
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
#mod-hiperbook-hotword #page{
	margin-top:0px;
	padding-top:0px;
	background-color:white;
}

#mod-hiperbook-popup #page{
	margin-top:0px;
	padding-top:0px;
	background-color:white;
}


#mod-hiperbook-tips #page #header,
#mod-hiperbook-suggestions #page #header,
#mod-hiperbook-hotwords #page #header {
	display:none;
	
	
}

#mod-hiperbook-popup #bookname{
	position:absolute;
	top:25px;
	left:5px;
	font-weight:bold;
	font-style:italic;	
	font-size:14px;
	text-align:left;
} 

.mod-hiperbook #navpaths{
	margin-top:10px;
	margin-left:10px;
	display:block;
}

.mod-hiperbook #navpaths #current{
	font-family:Verdana, Arial, Helvetica, sans-serif;	
	font-size:13px;
	color:white;	
	height:22px;
}
.mod-hiperbook #navpaths #current #main{
	background-color:#233E54;	
	display:inline;
	text-align:center;
	padding:2px;
	padding-bottom:3px;
	font-weight:bold;
}

.mod-hiperbook #navpaths #current #start{
	background-position:center;
	background-repeat:no-repeat;
	display:inline;
	padding:2px;	
	padding-bottom:3px;

}
.mod-hiperbook #navpaths #current #end{
	background-position:center;
	background-repeat:no-repeat;
	display:inline;
	padding:2px;	
	padding-bottom:3px;

}	
	
.mod-hiperbook #navpaths #past{	
}
	
	
.mod-hiperbook #navpaths #past #main{	
	background-position:center;
	background-repeat:repeat-x;
	display:inline;
	text-align:center;
	padding:4px;

	
}

.mod-hiperbook #navpaths #past #main a{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	text-decoration:none;
	font-size:13px;
	color:#8FB4DF;		
	background-position:center;	
}

.mod-hiperbook #navpaths #past #start{
	background-position:center;
	background-repeat:no-repeat;
	display:inline;
	padding:4px;
	padding-right:0px

	
}

.mod-hiperbook #navpaths #past #end{
	background-position:center;
	background-repeat:no-repeat;
	display:inline;	
	padding:2px;
	padding-left:0px

}

.mod-hiperbook #breadcrumbs{
	height:18px;
	margin-left:10px;
}

.mod-hiperbook #breadcrumbs #current{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-weight:bold;
	font-size:12px;
}

.mod-hiperbook #breadcrumbs #current #main{
	display:inline;
	text-align:center;

}
.mod-hiperbook #breadcrumbs #current #start{
	display:inline;
	font-weight:normal;	
}
.mod-hiperbook #breadcrumbs #current #end{
	display:inline;
}

.mod-hiperbook #breadcrumbs #past{


}
.mod-hiperbook #breadcrumbs #past a{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	text-decoration:none;
	font-size:12px;
}
	

.mod-hiperbook #breadcrumbs #past #main{	
	display:inline;
	text-align:center;
	background-position:center;
	
}
.mod-hiperbook #breadcrumbs #past #start{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	text-decoration:none;
	font-size:12px;
	display:inline;	
	
}
.mod-hiperbook #breadcrumbs #past #end{
	display:inline;
}



.mod-hiperbook #page_navigation{
	text-align:center;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
}
.mod-hiperbook #page_navigation img{
	text-align:center;
	color:black;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-weight:bold;
	vertical-align:middle;
}

.mod-hiperbook #toc{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-weight:bold;
	font-size:12px;
	padding-left:18px;
	color:#00477F;	
	width:150px;
}

.mod-hiperbook #toc #item a{
	text-align:left;
	text-decoration:none;
	font-weight:normal;
}

.mod-hiperbook #toc #item a:visited{
	color:#8FB4DF;
}

.mod-hiperbook #toc #item{	

}

.mod-hiperbook .hiperbook_content{
	width:500px;

}

.mod-hiperbook .hiperbook_content #template_top_left{
	background-image:url(".$CFG->wwwroot."/file.php/".$book->course."/template_hiperbook".$book->id."/top_conteudo_left.gif);
	background-repeat:no-repeat;

}
.mod-hiperbook .hiperbook_content #template_top_right{
	background-image:url(".$CFG->wwwroot."/file.php/".$book->course."/template_hiperbook".$book->id."/top_conteudo_right.gif);
	background-repeat:no-repeat;
	background-position:right;

}

.mod-hiperbook .hiperbook_content #template_main{
	background-color:#efefef;
}
.mod-hiperbook .hiperbook_content #template_bottom_left{
	background-image:url(".$CFG->wwwroot."/file.php/".$book->course."/template_hiperbook".$book->id."/bottom_conteudo_left.gif);
	background-repeat:no-repeat;

}
.mod-hiperbook .hiperbook_content #template_bottom_right{
	background-image:url(".$CFG->wwwroot."/file.php/".$book->course."/template_hiperbook".$book->id."/bottom_conteudo_right.gif);
	background-repeat:no-repeat;
		background-position:right;

}


.hiperbook_content .hotwordslist{
	width:100%;
	border:0px;
	color:#003366;
}

.hiperbook_content .hotwordslist .title a{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
	font-weight:bold;
	padding-left:46px;	
}
.hiperbook_content .hotwordslist .title {
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
	font-weight:bold;
	padding-top:23px;
	padding-bottom:23px;
}

.hiperbook_content .hotwordslist .content{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
	padding-left:92px;
	padding-right:46px;
}

.mod-hiperbook #botoesLateral{
	width:250px;
	margin-left:170px;
	margin-top:10px;
}

#mod-hiperbook-tips #page {
	
	padding-top:0px;
	margin-top:0px;
	
}



.book_chapter_title {
    font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif;
    text-align: left;
    font-size: large;
    font-weight: bold;

    margin-left: 0px;
    margin-bottom: 0px;
}

.book_content {
    text-align: left;
}
.book_toc_none ul {
    margin-left: 0px;
    padding-left: 0px;
}
.book_toc_none ul ul {
    margin-left: 0px;
    padding-left: 0px;
}
.book_toc_none li {
    margin-top: 0px;
    list-style: none;
}
.book_toc_none li li {
    margin-top: 0px;
    list-style: none;
}

.mod-hiperbook #bookname{
	font-weight:bold;
	font-style:italic;	
	font-size:14px;
	margin-bottom:15px;
} 
.mod-hiperbook, a{
	color:#00477F;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	border-collapse:collapse;
	border:0px;
}


.mod-hiperbook a:link, .mod-hiperbook a:visited, .mod-hiperbook a{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	text-decoration:underline;
}

table {
border-collapse:collapse;
border-spacing:0;
}
";


		$book->template_main = '<table width="540" height="268" border="0" background="'. $CFG->wwwroot."/file.php/".$book->course."/template_hiperbook".$book->id.'/template_hiperlivro.gif"> <tbody>
  <tr height="20">
    <td height="20" id="template_top_left">
    </td>
    <td width="240" height="20" id="template_main">
    </td>
    <td width="20" height="20" id="template_main">
    </td>
    <td width="240" height="20" id="template_main">
    </td>
    <td height="20" id="template_top_right">
    </td>
  </tr>
  <tr id="template_main">
    <td width="20" height="195">
    </td>
    <td valign="top" colspan="3">
      <div align="center"></div>
      <div align="center"></div><br />
    </td>
    <td width="20">
    </td>
  </tr>
  <tr id="template_main">
    <td id="template_main">
    </td>
    <td id="template_main"><br />
    </td>
    <td id="template_main">
    </td>
    <td id="template_main">
    </td>
    <td id="template_main">
    </td>
  </tr>
  <tr>
    <td height="20" id="template_bottom_left">
    </td>
    <td height="20" id="template_main">
    </td>
    <td height="20" id="template_main">
    </td>
    <td height="20" id="template_main">
    </td>
    <td height="20" id="template_bottom_right">
    </td>
  </tr> </tbody>
</table>';

   update_record('hiperbook', $book);
	
	mkdir($CFG->dataroot.'/'.$book->course.'/template_hiperbook'.$bookid);
	
	hiperbook_COPY_RECURSIVE_DIRS($CFG->dirroot."/mod/hiperbook/template_avaad/", $CFG->dataroot.'/'.$book->course.'/template_hiperbook'.$bookid);
	
	echo $CFG->dataroot.'/'.$book->course.'/template_hiperbook'.$bookid;
	//die();
	 return $bookid;
}

function hiperbook_COPY_RECURSIVE_DIRS($dirsource, $dirdest) 
{ // recursive function to copy 
  // all subdirectories and contents: 
  
  if(is_dir($dirsource))$dir_handle=opendir($dirsource); 
  mkdir($dirdest."/".$dirsource, 0750); 
  while($file=readdir($dir_handle)) 
  { 
    if($file!="." && $file!="..") 
    { 
      	if(!is_dir($dirsource."/".$file)){
	   copy ($dirsource."/".$file, $dirdest."/".$file); 
		} else{
		 hiperbook_COPY_RECURSIVE_DIRS($dirsource."/".$file, $dirdest); 
		}
    } 
  } 
  closedir($dir_handle); 
  return true; 
}

function hiperbook_update_instance($book) {
/// Given an object containing all the necessary data,
/// (defined by the form in mod.html) this function
/// will update an existing instance with new data.

    $book->timemodified = time();
    $book->id = $book->instance;
    # May have to add extra stuff in here #
    return update_record('hiperbook', $book);
}


function hiperbook_delete_instance($id) {
/// Given an ID of an instance of this module,
/// this function will permanently delete the instance
/// and any data that depends on it.

    if (!$book = get_record('hiperbook', 'id', $id)) {
        return false;
    }
	
	$module = get_record('modules', 'name', 'hiperbook');
	$cm = get_record('course_modules', 'instance', $id,'module' ,$module->id);
	

    $result = true;
	
	$chapters = get_records_select('hiperbook_chapters',"bookid = $book->id");
	foreach($chapters as $chapter){
		hiperbook_remove_chapter($chapter->id, $cm);
	}	
	
	 if (!delete_records('hiperbook_navigationpath', 'bookid', $book->id)) {
        $result = false;
    }

    if (!delete_records('hiperbook', 'id', $book->id)) {
        $result = false;
    }
	
	
	//echo 'funcao nao disponivel';
	
    return $result;
	

}

function hiperbook_user_outline($course, $user, $mod, $book) {
/// Return a small object with summary information about what a
/// user has done with a given particular instance of this module
/// Used for user activity reports.
/// $return->time = the time they did it
/// $return->info = a short text description

    $return = null;
    return $return;
}

function hiperbook_user_complete($course, $user, $mod, $book) {
/// Print a detailed representation of what a  user has done with
/// a given particular instance of this module, for user activity reports.

    return true;
}

function hiperbook_print_recent_activity($course, $isteacher, $timestart) {
/// Given a course and a time, this module should find recent activity
/// that has occurred in book activities and print it out.
/// Return true if there was output, or false is there was none.

    global $CFG;

    return false;  //  True if anything was printed, otherwise false
}

function hiperbook_cron () {
/// Function to be run periodically according to the moodle cron
/// This function searches for things that need to be done, such
/// as sending out mail, toggling flags etc ...

    global $CFG;

    return true;
}

function hiperbook_grades($bookid) {
/// Must return an array of grades for a given instance of this module,
/// indexed by user.  It also returns a maximum allowed grade.

    return NULL;
}

function hiperbook_get_participants($bookid) {
//Must return an array of user records (all data) who are participants
//for a given instance of book. Must include every user involved
//in the instance, independient of his role (student, teacher, admin...)
//See other modules as example.

    return false;
}

function hiperbook_scale_used ($bookid,$scaleid) {
//This function returns if a scale is being used by one book
//it it has support for grading and scales. Commented code should be
//modified if necessary. See forum, glossary or journal modules
//as reference.

    $return = false;

    //$rec = get_record('book','id',$bookid,'scale',"-$scaleid");
    //
    //if (!empty($rec)  && !empty($scaleid)) {
    //    $return = true;
    //}

    return $return;
}

//////////////////////////////////////////////////////////////////////////////////////
/// Any other book functions go here.  Each of them must have a name that
/// starts with hiperbook_

//check chapter ordering and
//make sure subchapter is not first in book
//hidden chapter must have all subchapters hidden too
function hiperbook_check_structure($bookid) {
}


/// prepare button to turn chapter editing on - connected with course editing
function hiperbook_edit_button($id, $courseid, $chapterid, $navigationnum,  $pagenum, $target_navigation_chapter) {
    global $CFG, $USER;


    if (isteacheredit($courseid)) {
        if (!empty($USER->editing)) {
            $string = get_string("turneditingoff");
            $edit = '0';
        } else {
            $string = get_string("turneditingon");
            $edit = '1';
        }
        return '<form target="'.$CFG->framename.'" method="get" action="'.$CFG->wwwroot.'/mod/hiperbook/view.php">'.
               '<input type="hidden" name="id" value="'.$id.'" />'.
               '<input type="hidden" name="chapterid" value="'.$chapterid.'" />'.
               '<input type="hidden" name="navigationnum" value="'.$navigationnum.'" />'.
               '<input type="hidden" name="pagenum" value="'.$pagenum.'" />'.
               '<input type="hidden" name="target_navigation_chapter" value="'.$target_navigation_chapter.'" />'.		   
               '<input type="hidden" name="edit" value="'.$edit.'" />'.
               '<input type="submit" value="'.$string.'" /></form>';
    } else {
        return '';
    }
}

/// general function for logging to table
function hiperbook_log($str1, $str2, $level = 0) {
    switch ($level) {
        case 1:
            echo '<tr><td><span class="dimmed_text">'.$str1.'</span></td><td><span class="dimmed_text">'.$str2.'</span></td></tr>';
            break;
        case 2:
            echo '<tr><td><span style="color: rgb(255, 0, 0);">'.$str1.'</span></td><td><span style="color: rgb(255, 0, 0);">'.$str2.'</span></td></tr>';
            break;
        default:
            echo '<tr><td>'.$str1.'</class></td><td>'.$str2.'</td></tr>';
            break;
    }
}

//=================================================
// import functions
//=================================================

/// normalize relative links (= remove ..)
function hiperbook_prepare_link($ref) {
    if ($ref == '') {
        return '';
    }
    $ref = str_replace('\\','/',$ref); //anti MS hack
    $cnt = substr_count($ref, '..');
    for($i=0; $i<$cnt; $i++) {
        $ref = ereg_replace('[^/]+/\.\./', '', $ref);
    }
    //still any '..' left?? == error! error!
    if (substr_count($ref, '..') > 0) {
        return '';
    }
    if (ereg('[\|\`]', $ref)) {  // check for other bad characters
        return '';
    }
    return $ref;
}

/// read chapter content from file
function hiperbook_read_chapter($base, $ref) {
    $file = $base.'/'.$ref;
    if (filesize($file) <= 0 or !is_readable($file)) {
        hiperbook_log($ref, get_string('error'), 2);
        return;
    }
    //first read data
    $handle = fopen($file, "rb");
    $contents = fread($handle, filesize($file));
    fclose($handle);
    //extract title
    if (preg_match('/<title>([^<]+)<\/title>/i', $contents, $matches)) {
        $chapter->title = $matches[1];
    } else {
        $chapter->title = $ref;
    }
    //extract page body
    if (preg_match('/<body[^>]*>(.+)<\/body>/is', $contents, $matches)) {
        $chapter->content = $matches[1];
    } else {
        hiperbook_log($ref, get_string('error'), 2);
        return;
    }
    hiperbook_log($ref, get_string('ok'));
    $chapter->importsrc = $ref;
    //extract page head
    if (preg_match('/<head[^>]*>(.+)<\/head>/is', $contents, $matches)) {
        $head = $matches[1];
        if (preg_match('/charset=([^"]+)/is', $head, $matches)) {
            $enc = $matches[1];
            $chapter->content = hiperbook_conv($enc, $chapter->content);
            $chapter->title = hiperbook_conv($enc, $chapter->title);
        }
        if (preg_match_all('/<link[^>]+rel="stylesheet"[^>]*>/i', $head, $matches)) { //dlnsk extract links to css
            for($i=0; $i<count($matches[0]); $i++){
                $chapter->content = $matches[0][$i]."\n".$chapter->content;
            }
        }
    }
    return $chapter;
}

///relink images and relative links
function hiperbook_relink($id, $bookid, $courseid) {
    global $CFG;
    if ($CFG->slasharguments) {
        $coursebase = $CFG->wwwroot.'/file.php/'.$courseid;
    } else {
        $coursebase = $CFG->wwwroot.'/file.php?file=/'.$courseid;
    }
    $chapters = get_records('hiperbook_chapters', 'bookid', $bookid, 'pagenum', 'id, pagenum, title, content, importsrc');
    $originals = array();
    foreach($chapters as $ch) {
        $originals[$ch->importsrc] = $ch;
    }
    foreach($chapters as $ch) {
        $rel = substr($ch->importsrc, 0, strrpos($ch->importsrc, '/')+1);
        $base = $coursebase.strtr(urlencode($rel), array("%2F" => "/"));  //for better internationalization (dlnsk) 
        $modified = false;
        //image relinking
        if ($ch->importsrc && preg_match_all('/(<img[^>]+src=")([^"]+)("[^>]*>)/i', $ch->content, $images)) {
            for($i = 0; $i<count($images[0]); $i++) {
                if (!preg_match('/[a-z]+:/i', $images[2][$i])) { // not absolute link
                    $link = hiperbook_prepare_link($base.$images[2][$i]);
                    if ($link == '') {
                        continue;
                    }
                    $origtag = $images[0][$i];
                    $newtag = $images[1][$i].$link.$images[3][$i];
                    $ch->content = str_replace($origtag, $newtag, $ch->content);
                    $modified = true;
                    hiperbook_log($ch->title, $images[2][$i].' --> '.$link);
                }
            }
        }
        //css relinking (dlnsk)
        if ($ch->importsrc && preg_match_all('/(<link[^>]+href=")([^"]+)("[^>]*>)/i', $ch->content, $csslinks)) {
            for($i = 0; $i<count($csslinks[0]); $i++) {
                if (!preg_match('/[a-z]+:/i', $csslinks[2][$i])) { // not absolute link
                    $link = hiperbook_prepare_link($base.$csslinks[2][$i]);
                    if ($link == '') {
                        continue;
                    }
                    $origtag = $csslinks[0][$i];
                    $newtag = $csslinks[1][$i].$link.$csslinks[3][$i];
                    $ch->content = str_replace($origtag, $newtag, $ch->content);
                    $modified = true;
                    hiperbook_log($ch->title, $csslinks[2][$i].' --> '.$link);
                }
            }
        }
        //general embed relinking - flash and others??
        if ($ch->importsrc && preg_match_all('/(<embed[^>]+src=")([^"]+)("[^>]*>)/i', $ch->content, $embeds)) {
            for($i = 0; $i<count($embeds[0]); $i++) {
                if (!preg_match('/[a-z]+:/i', $embeds[2][$i])) { // not absolute link
                    $link = hiperbook_prepare_link($base.$embeds[2][$i]);
                    if ($link == '') {
                        continue;
                    }
                    $origtag = $embeds[0][$i];
                    $newtag = $embeds[1][$i].$link.$embeds[3][$i];
                    $ch->content = str_replace($origtag, $newtag, $ch->content);
                    $modified = true;
                    hiperbook_log($ch->title, $embeds[2][$i].' --> '.$link);
                }
            }
        }
        //flash in IE <param name=movie value="something" - I do hate IE!
        if ($ch->importsrc && preg_match_all('/<param[^>]+name\s*=\s*"?movie"?[^>]*>/i', $ch->content, $params)) {
            for($i = 0; $i<count($params[0]); $i++) {
                if (preg_match('/(value=\s*")([^"]+)(")/i', $params[0][$i], $values)) {
                    if (!preg_match('/[a-z]+:/i', $values[2])) { // not absolute link
                        $link = hiperbook_prepare_link($base.$values[2]);
                        if ($link == '') {
                            continue;
                        }
                        $newvalue = $values[1].$link.$values[3];
                        $newparam = str_replace($values[0], $newvalue, $params[0][$i]);
                        $ch->content = str_replace($params[0][$i], $newparam, $ch->content);
                        $modified = true;
                        hiperbook_log($ch->title, $values[2].' --> '.$link);
                    }
                }
            }
        }
        //java applet - add code bases if not present!!!!
        if ($ch->importsrc && preg_match_all('/<applet[^>]*>/i', $ch->content, $applets)) {
            for($i = 0; $i<count($applets[0]); $i++) {
                if (!stripos($applets[0][$i], 'codebase')) {
                    $newapplet = str_ireplace('<applet', '<applet codebase="."', $applets[0][$i]);
                    $ch->content = str_replace($applets[0][$i], $newapplet, $ch->content);
                    $modified = true;
                }
            }
        }
        //relink java applet code bases
        if ($ch->importsrc && preg_match_all('/(<applet[^>]+codebase=")([^"]+)("[^>]*>)/i', $ch->content, $codebases)) {
            for($i = 0; $i<count($codebases[0]); $i++) {
                if (!preg_match('/[a-z]+:/i', $codebases[2][$i])) { // not absolute link
                    $link = hiperbook_prepare_link($base.$codebases[2][$i]);
                    if ($link == '') {
                        continue;
                    }
                    $origtag = $codebases[0][$i];
                    $newtag = $codebases[1][$i].$link.$codebases[3][$i];
                    $ch->content = str_replace($origtag, $newtag, $ch->content);
                    $modified = true;
                    hiperbook_log($ch->title, $codebases[2][$i].' --> '.$link);
                }
            }
        }
        //relative link conversion
        if ($ch->importsrc && preg_match_all('/(<a[^>]+href=")([^"^#]*)(#[^"]*)?("[^>]*>)/i', $ch->content, $links)) {
            for($i = 0; $i<count($links[0]); $i++) {
                if ($links[2][$i] != ''                         //check for inner anchor links
                && !preg_match('/[a-z]+:/i', $links[2][$i])) { //not absolute link
                    $origtag = $links[0][$i];
                    $target = hiperbook_prepare_link($rel.$links[2][$i]); //target chapter
                    if ($target != '' && array_key_exists($target, $originals)) {
                        $o = $originals[$target];
                        $newtag = $links[1][$i].$CFG->wwwroot.'/mod/hiperbook/view.php?id='.$id.'&chapterid='.$o->id.$links[3][$i].$links[4][$i];
                        $newtag = preg_replace('/target=[^\s>]/i','', $newtag);
                        $ch->content = str_replace($origtag, $newtag, $ch->content);
                        $modified = true;
                        hiperbook_log($ch->title, $links[2][$i].$links[3][$i].' --> '.$CFG->wwwroot.'/mod/hiperbook/view.php?id='.$id.'&chapterid='.$o->id.$links[3][$i]);
                    } else if ($target!='' && (!preg_match('/\.html$|\.htm$/i', $links[2][$i]))) { // other relative non html links converted to download links
                        $target = hiperbook_prepare_link($base.$links[2][$i]);
                        $origtag = $links[0][$i];
                        $newtag = $links[1][$i].$target.$links[4][$i];
                        $ch->content = str_replace($origtag, $newtag, $ch->content);
                        $modified = true;
                        hiperbook_log($ch->title, $links[2][$i].' --> '.$target);
                    }
                }
            }
        }
        if ($modified) {
            $ch->title = addslashes($ch->title);
            $ch->content = addslashes($ch->content);
            $ch->importsrc = addslashes($ch->importsrc);
            if (!update_record('hiperbook_chapters', $ch)) {
                error('Could not update your hiperbook');
            }
        }
    }
}

//=================================================
// encoding conversion functions
//=================================================

function hiperbook_conv($in, $text) {
    $in = strtolower($in);
    if (!empty($CFG->unicode)) {
        $out = 'utf-8';
    } else {
        $out = get_string('thischarset');
    }
    $out = strtolower($out);
    if ($in === "windows-1250" && $out === "iso-8859-2") {
        $conv = array (130=>"&#8218;", 132=>"&#8222;", 133=>"&#8230;", 134=>"&#8224;", 135=>"&#8225;", 137=>"&#8240;", 138=>"\xa9", 139=>"&#8249;", 140=>"\xa6", 141=>"\xab", 142=>"\xae", 143=>"\xac", 145=>"&#8216;", 146=>"&#8217;", 147=>"&#8220;", 148=>"&#8221;", 149=>"&#8226;", 150=>"&#8211;", 151=>"&#8212;", 153=>"&#8482;", 154=>"\xb9", 155=>"&#8250;", 156=>"\xb6", 157=>"\xbb", 158=>"\xbe", 159=>"\xbc", 161=>"\xb7", 165=>"\xa1", 166=>"&#166;", 169=>"&#169;", 171=>"&#171;", 172=>"&#172;", 174=>"&#174;", 177=>"&#177;", 181=>"&#181;", 182=>"&#182;", 183=>"&#183;", 185=>"\xb1", 187=>"&#187;", 188=>"\xa5", 190=>"\xb5");

        $len = strlen($text);
        $res = '';
        for($i=0 ; $i<$len; $i++) {
            $num = ord($text{$i});
            if (array_key_exists($num, $conv)) {
                $res .= $conv[$num];
            } else {
                $res .= $text{$i};
            }
        }
        return $res;
    } else {
        return $text;
    }
}


//a dicionada por ronnie para leitura dos capitulos superiores para geracao dos breadcrumbs
function hiperbook_link_parent_chapters($navigation_chapter_id, $cm, $groupid=0, $popup= false){

// busca a navegacao atual
	$navigation_chapter = get_record('hiperbook_navigation_chapters', 'id',$navigation_chapter_id);		
	$chapter = get_record('hiperbook_chapters', 'id', $navigation_chapter->chapterid);	
	$navpath = get_record('hiperbook_navigationpath', 'id',$navigation_chapter->navigationid);		
		
	//se tem pai			
	if($navigation_chapter->parentnavchapterid != 0){
		$parentnavchapter =  get_record('hiperbook_navigation_chapters', 'id',$navigation_chapter->parentnavchapterid);
	
		$parentchapters_links .= hiperbook_link_parent_chapters($parentnavchapter->id, $cm, $groupid, $popup);		
	}
	$parentchapters_links .= '<td id="past"><div id="start"> > &nbsp;</div><div id="main"><a title="'.htmlspecialchars($parentchapter->title).'" href="';
	if($popup) { $parentchapters_links .= 'popup.php'; } else { $parentchapters_links .= 'view.php'; }
	$parentchapters_links .= '?id='. $cm->id.'&target_navigation_chapter='.$navigation_chapter->id.'&groupid='.$groupid.'">'.$chapter->title.'</a>  </div><div id="end">&nbsp;</div></td>';	
	return  $parentchapters_links;
}

function hiperbook_link_parent_chapters_html($navigation_chapter_id, $cm, $groupid=0 ){

// busca a navegacao atual
	$navigation_chapter = get_record('hiperbook_navigation_chapters', 'id',$navigation_chapter_id);		
	$chapter = get_record('hiperbook_chapters', 'id', $navigation_chapter->chapterid);	
	$navpath = get_record('hiperbook_navigationpath', 'id',$navigation_chapter->navigationid);		
		
	//se tem pai			
	if($navigation_chapter->parentnavchapterid != 0){
		$parentnavchapter =  get_record('hiperbook_navigation_chapters', 'id',$navigation_chapter->parentnavchapterid);
	
		$parentchapters_links .= hiperbook_link_parent_chapters_html($parentnavchapter->id, $cm, $groupid);
		
	}
	$parentchapters_links .= '<td id="past"><div id="start"> > &nbsp;</div><div id="main"><a title="'.htmlspecialchars($parentchapter->title).'" href="../../scos/cap'.$chapter->id.'/1.html">'.$chapter->title.'</a>  </div><div id="end">&nbsp;</div></td>';	
	return  $parentchapters_links;

}


// remove um capitulo
function hiperbook_remove_chapter($chapterid, $cm ){
	global $CFG;	
		hiperbook_remove_chapter_pages($chapterid, $cm );
		hiperbook_remove_chapter_tips($chapterid, $cm );
		hiperbook_remove_chapter_links($chapterid, $cm );
		hiperbook_remove_chapter_suggestions($chapterid, $cm );
		hiperbook_remove_chapter_exercises($chapterid, $cm );
		hiperbook_remove_chapter_hotword($chapterid, $cm );
		hiperbook_remove_navigation_chapter($chapterid,$cm);	
		
	//busca o cap a ser apagado
	$chapter = get_record('hiperbook_chapters', 'id', $chapterid,'bookid',$cm->instance);	
	if (!delete_records('hiperbook_chapters', 'id', $chapterid,'bookid',$cm->instance)) {
		error('Could not update your book chapters');
	}else{				
		$chapternum = $chapter->chapternum;
		$parentchapterid = $chapter->parentchapterid;
		//move os superiores para baixo				
		//$sup = get_records_sql("select * from ". $CFG->prefix."hiperbook_chapters where parentchapterid='$parentchapterid' and bookid = '$cm->instance' and chapternum > '$chapternum'");	
		foreach($sup as $subchapter){	
		  // como se estivesse movendo um cap p/ cima (e baixando os demais) em todos os navigation paths
				//hiperbook_move_chapter($cm,$subchapter->id,1,-1);					
		}
	}		
	//die();
}

// remocve as paginas no capitulo
function hiperbook_remove_chapter_pages($chapterid, $cm ){
	echo 'hiperbook_chapters_pages'. ' chapterid='. $chapterid;
	if (!delete_records('hiperbook_chapters_pages', 'chapterid', $chapterid)) {
		error('Could not update your book pages');
	}		
}
// remocve as tips no capitulo
function hiperbook_remove_chapter_tips($chapterid, $cm ){
	echo 'hiperbook_remove_chapter_tips'. ' chapterid='. $chapterid;
	if (!delete_records('hiperbook_chapters_tips', 'chapterid', $chapterid)) {
		error('Could not update your book tips');
	}
		
}
function hiperbook_remove_chapter_suggestions($chapterid, $cm ){
	echo 'hiperbook_remove_chapter_tips'. ' chapterid='. $chapterid;	
	if (!delete_records('hiperbook_chapters_suggestions', 'chapterid', $chapterid)) {
		error('Could not update your book suggestions');
	}
		
}

function hiperbook_remove_chapter_hotword($chapterid, $cm ){
	echo 'hiperbook_remove_chapter_tips'. ' chapterid='. $chapterid;
	if (!delete_records('hiperbook_chapters_hotword', 'chapterid', $chapterid)) {
		error('Could not update your book hotwords');
	}		
}

function hiperbook_remove_chapter_links($chapterid, $cm ){
	echo 'hiperbook_remove_chapter_tips'. ' chapterid='. $chapterid;
	if (!delete_records('hiperbook_chapters_links', 'chapterid', $chapterid)) {
		error('Could not update your book links');
	}		
}
function hiperbook_remove_chapter_exercises($chapterid, $cm ){

}

//remove todos os navpaths do pelo navigationnum e book id
function hiperbook_remove_navigation($navpathnum,$navigationid, $cm){
 global $CFG;
//echo 'hiperbook_remove_navigation'. ' navigationid='. $navigationid;
	
	
	if (!delete_records('hiperbook_navigationpath', 'navpathnum', $navpathnum,'bookid',$cm->instance)) 	{
		error('Could not update your book navigations');
	}	
	if (!delete_records('hiperbook_navigation_chapters', 'navigationid', $navigationid)) {
		error('Could not update your book navigations');
	}		
	
//deleted current nav path -> move superior remaining nav paths a level down	
	$x= execute_sql("update ". $CFG->prefix."hiperbook_navigationpath set navpathnum = (navpathnum - 1) where  navpathnum >'$navpathnum' and bookid = '$cm->instance'");
}

//remove a navegacao do capitulo em todos os navpaths
function hiperbook_remove_navigation_chapter($chapterid,$cm){	
	global $CFG;
	// todos os navpaths
	$navigations =get_records_select('hiperbook_navigationpath', "bookid='$cm->instance'", 'id');		
	foreach( $navigations as $navigation){
		$nav_chapter = get_record_select('hiperbook_navigation_chapters',"navigationid='$navigation->id' and chapterid ='$chapterid'");			
		$parentnavchapterid  = $nav_chapter->parentnavchapterid;			
		$x= execute_sql("update ". $CFG->prefix."hiperbook_navigation_chapters set chapternum = (chapternum - 1) where chapternum > $nav_chapter->chapternum and navigationid = '$navigation->id' and parentnavchapterid ='$parentnavchapterid'");
		if (!delete_records('hiperbook_navigation_chapters', 'chapterid', $chapterid, "navigationid" , $navigation->id)) {
			error('Could not update your book navigations');
		}
	}
}

// remove apenas a navegacao do capitulo apenas no navpath indicado
function hiperbook_remove_chapter_navpath($chapterid,$navigationnum,$parentnavchapterid,$cm){
	
	global $CFG;
	$navigation =get_record_select('hiperbook_navigationpath',"navpathnum='$navigationnum' and bookid='$cm->instance'");		
	$nav_chapter = get_record_select('hiperbook_navigation_chapters',"navigationid='$navigation->id' and chapterid ='$chapterid'");	
	$parentnavchapterid  = $nav_chapter->parentnavchapterid;
	$x= execute_sql("update ". $CFG->prefix."hiperbook_navigation_chapters set chapternum = (chapternum - 1) where chapternum > $nav_chapter->chapternum and navigationid = '$navigation->id' and parentnavchapterid ='$parentnavchapterid'");	
	if (!delete_records('hiperbook_navigation_chapters', 'chapterid', $chapterid,'navigationid',$navigation->id, 'parentnavchapterid', $parentnavchapterid)) {
		error('Could not update your book chapter´s navpath');
	}		
}

function replaceFirst($string, $search, $replace) {
		   $pos = strpos($string, $search);
		   /*echo "string".$string;
		   echo "search".$search."/";
		   echo "replace".$replace ."POS";
		   var_dump($pos);*/
		   if (is_int($pos)) {
			   $len = strlen($search);
			   return substr_replace($string, $replace, $pos, $len);
		   }
		  /* echo 'retunr'.$string;*/
		   return $string;
}	

function hiperbook_link_tips($content, $tips){	
	return hiperbook_link_common($content, $tips, "myStyleTips" );	
}

function hiperbook_link_hotwords($content, $hotwords ){
	return hiperbook_link_common($content, $hotwords, "myStyleHotword" );
}

function hiperbook_link_suggestions($content, $suggestions ){
	return hiperbook_link_common($content, $suggestions, "myStyleSuggestions" );
}


// creates the layers for tips, hotwords etc
function hiperbook_link_common($content, $elements,$styleName ){
	
	$hotwords = $elements;
	if($hotwords){		
		$x=1;		
		// titulos com \n junto com os espaços
		// pode conter . ? : " > < espaço		
		
		foreach($hotwords as $hotword){
					
			// titulos com \n junto com os espaços
			// pode conter . ? : " > < espaço
	

	$delimitador = '((\s|\.|\,|\?|\!|\@)+|(\s|\b))' ;
			$pattern_root = '';
			$elementos_raiz = explode(' ',trim($hotword->title));			
			$xx = 1;		
			foreach($elementos_raiz as $elemento){				
				$strlen1 = strlen($elemento);
				$elemento = str_replace("/","\/",$elemento);
				$strlen2 = strlen($elemento);				
				if ($strlen1 == $strlen2) {
					if ($xx == count($elementos_raiz)){
						$pattern_root .= "".quotemeta($elemento)."";
					}else{
						$pattern_root .= "".quotemeta($elemento)."(\s)+";
					}				
				}else{
					$pattern_root = $elemento;
				}
				$xx++;			
			}
			$pattern = '/'.$delimitador.'('.$pattern_root.')'.$delimitador.'/';	
				$replacement = ' <a id="popup_link_'.$styleName.$x.'" href="javascript:void(0);">\\4 \\5 </a>\\6\\7\\8';
			$content = preg_replace($pattern,$replacement,$content,1);
			$x++;	
		}
		$i=1;
		foreach($hotwords as $hotword){
			
			
		

	//if($styleName == 'myStyleHotword'){
	
			
		$txts .= '<div class="popup" style="width:770px" id="popup_'.$styleName.$i.'">    
		 <!--p><a class="popup_draghandle" href="javascript:void(0);">Drag handle</a></p-->
		 <a style="float:right" class="popup_closebox" href="javascript:void(0);">Fechar</a>
	  
			<p>' .$hotword->content.'</p>
 
</div>';
		$txts .=  '<script type="text/javascript">
			//<![CDATA[
			new Popup(\'popup_'.$styleName.$i.'\',\'popup_link_'.$styleName.$i.'\',{modal:true,duration:0.2})
			//]]>
		  </script>';
	/*}else{	
	
		$txts .= '<div class="popup" style="width:400px" id="popup_'.$styleName.$i.'">    
          	 <!--p><a class="popup_draghandle" href="javascript:void(0);">Drag handle</a></p-->
          
                <p>' .$hotword->content.'</p>
     
</div>';
		$txts .=  '<script type="text/javascript">
			//<![CDATA[
			new Popup(\'popup_'.$styleName.$i.'\',\'popup_link_'.$styleName.$i.'\', {modal:false})
			//]]>
		  </script>
		  
		';
	}*/

 
				
				$i++;	
			}
		
			return  $content.$stl . $js .$txts ;	
		}else{
		
		return $content;	
		}	
		
}
function hiperbook_links_get_parentchaptersnames($navchapterid){


	$navchapter = get_record('hiperbook_navigation_chapters','id',$navchapterid );
	$parentnavchapter = get_record('hiperbook_navigation_chapters','id',$navchapter->parentnavchapterid );
	$chapter = get_record('hiperbook_chapters','id' , $navchapter->chapterid);
	
	
	
    // se o navchapter nao eh o ultimo
	if ($navchapter->parentnavchapterid != 0 ){ 
		$names .= hiperbook_links_get_parentchaptersnames($navchapter->parentnavchapterid);
	}
    
    $names .= "  /  ".$chapter->title;
    
    
	return $names;
}
function hiperbook_link_links($content, $links, $cmid, $navigationnum, $parentnavchapterid ,$groupid=0){

global $db;

	  
		foreach($links as $link){
			
			/*INICIO */
			
			
		//	$delimitador = '((\s|\.|\?|\!|\@|\))+|(\s|\>|\<|\) ))' ;
		
		
	//	$delimitador = '((\s|\.|\,|\?|\!|\@|\>|\<))' ;
		$delimitador =  '((\s|\.|\,|\?|\!|\@)+|(\s|\b))' ;
		
			$pattern_root = '';
			$elementos_raiz = explode(' ',trim($link->title));			
			$xx = 1;		
			foreach($elementos_raiz as $elemento){
				
				$strlen1 = strlen($elemento);
				$elemento = str_replace("/","\/",$elemento);
				$strlen2 = strlen($elemento);
				
				if ($strlen1 == $strlen2) {
					if ($xx == count($elementos_raiz)){
						$pattern_root .= "".quotemeta($elemento)."";
					}else{
						$pattern_root .= "".quotemeta($elemento)."(\s)+";
					}				
				}else{
					$pattern_root = $elemento;
				}
				$xx++;
				// ((elemento)(\s)+(do)(\s)(link))
			}	
			$pattern = '/'.$delimitador.'('.$pattern_root.')'.$delimitador.'/';		
			/* FIM */ 
				//echo "xsssxx".$pattern;
		
			
		
				
		//		$db->debug = true;
				$page =  get_record('hiperbook_chapters_pages', 'id',$link->idtargetpageid);
				//echo 'page='; var_dump($page);
				$pagenum = $page->pagenum;
			
			if ($link->popup==0){				
				$replace = "<span id=\"myStyleLink\"> <a href=\"view.php?id=".$cmid."&navigationnum=".$navigationnum."&pagenum=".$pagenum."&show_navigation=".$link->show_navigation."&groupid=".$groupid."&target_navigation_chapter=".$link->target_navigation_chapter."\">".$link->title."</a></span> "; 
				
			}else{
				$replace = "<span id=\"myStyleLink\"> <a href=\"#\" onclick=\"javascript:window.open('popup.php?id=".$cmid."&navigationnum=".$navigationnum."&pagenum=".$pagenum."&show_navigation=".$link->show_navigation."&groupid=".$groupid."&target_navigation_chapter=".$link->target_navigation_chapter."','_blank','menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=780,height=650')\" >".$link->title."</a></span> \\8";
			}
			//$replace = $replace_main;
			
			//echo $replace;
			$content = preg_replace($pattern,$replace,$content,1);
			
		}		
		//var_dump($newcontent);
		return $content;
	
}


function hiperbook_move_chapter($cm,$chapterid,$up,$navigationpathid){

	// se navigationpath == -1 entao move em todos os navpaths

	global $CFG;
	//busca o cap a ser movido
	if ($navigationpathid>0){
		$chapternavpath = get_record('hiperbook_navigation_chapters', 'chapterid', $chapterid,'navigationid',$navigationpathid);
	}else{
		$chapternavpath = get_record('hiperbook_navigation_chapters', 'chapterid', $chapterid);
	}
	
	$parentnavchapterid = $chapternavpath->parentnavchapterid;  

//die();
	// se up, incrementa o chapternum imediatamente superior e decrementa o atual (de mesmo parentchapterid)
	if($up==1){
	 //swap!!!
		$newchapternum = $chapternavpath->chapternum - 1;			
		
		$x= execute_sql("update ". $CFG->prefix."hiperbook_navigation_chapters set chapternum = '55555' where chapternum='$chapternavpath->chapternum' and navigationid = '$chapternavpath->navigationid' and parentnavchapterid='$parentnavchapterid'");
		$x= execute_sql("update ". $CFG->prefix."hiperbook_navigation_chapters set chapternum = (chapternum + 1) where chapternum='$newchapternum' and navigationid = '$chapternavpath->navigationid' and parentnavchapterid='$parentnavchapterid'");
		$x= execute_sql("update ". $CFG->prefix."hiperbook_navigation_chapters set chapternum = '$newchapternum' where chapternum='55555' and navigationid = '$chapternavpath->navigationid' and parentnavchapterid='$parentnavchapterid'");

	}
	
	//se !up (down), decrementa o chapternum imediatamente superior e incrementa o atual(de mesmo parentchapterid)
	if($up==0){
	 //swap!!!
		$newchapternum = $chapternavpath->chapternum + 1;	
		$x= execute_sql("update ". $CFG->prefix."hiperbook_navigation_chapters set chapternum = '55555' where chapternum='$chapternavpath->chapternum' and navigationid = '$chapternavpath->navigationid' and parentnavchapterid='$parentnavchapterid'");	
		$x= execute_sql("update ". $CFG->prefix."hiperbook_navigation_chapters set chapternum = (chapternum - 1) where chapternum='$newchapternum' and navigationid = '$chapternavpath->navigationid' and parentnavchapterid='$parentnavchapterid'");
		$x= execute_sql("update ". $CFG->prefix."hiperbook_navigation_chapters set chapternum = '$newchapternum' where chapternum='55555' and navigationid = '$chapternavpath->navigationid' and parentnavchapterid='$parentnavchapterid'");
	}
//die();
}

function hiperbook_copy_chapter($oldbookid, $newbookid, $chapter){
		// $retona o novo chpaterid
		global $CFG, $db;
		$oldchapterid = $chapter->id;
		$chapter->bookid = $newbookid;		
		$newchapterid = insert_record('hiperbook_chapters', $chapter);	
		//copia paginas do antigo chapter definindo novo chapterid
		$oldchapters_pages= get_records_select('hiperbook_chapters_pages',"chapterid= $oldchapterid");
		foreach($oldchapters_pages as $oldchapters_page){
			$newchapter_page= $oldchapters_page;
			$newchapter_page->content = mysql_real_escape_string($oldchapters_page->content);
			$newchapter_page->chapterid = $newchapterid;	
			if(!insert_record('hiperbook_chapters_pages', $newchapter_page)){
				echo ' nao inseriu novo chapter page';
			}else{
				//echo ' inseriu novo chapter page';
			}
		}
		
		//copia dicas com novo chapterid
		$oldchapters_tips= get_records_select('hiperbook_chapters_tips',"chapterid= $oldchapterid");
		foreach($oldchapters_tips as $oldchapters_tip){
			$newchapter_tip= $oldchapters_tip;
			$newchapter_tip->chapterid = $newchapterid;	
			$newchapter_tip->content = mysql_real_escape_string($oldchapters_tip->content);
			$newchapter_tip->title = mysql_real_escape_string($oldchapters_tip->title);
			if(!insert_record('hiperbook_chapters_tips', $newchapter_tip)){
				echo 'nao inseriu novo chapter tips';
			}else{
				//echo 'inseriu novo chapter tips';
			}
		}
		//copia sugestoes de estudo com novo chapterid
		$oldchapters_suggestions= get_records_select('hiperbook_chapters_suggestions',"chapterid= $oldchapterid");
		foreach($oldchapters_suggestions as $oldchapters_suggestion){
			$newchapter_suggestion = $oldchapters_suggestion;
			$newchapter_suggestion->chapterid = $newchapterid;	
			$newchapter_suggestion->content = mysql_real_escape_string($oldchapters_suggestion->content);
			$newchapter_suggestion->title = mysql_real_escape_string($oldchapters_suggestion->title);
			if(!insert_record('hiperbook_chapters_suggestions', $newchapter_suggestion)){
				echo 'nao inseriu novo chapter suggestions';
			}else{
				//echo 'inseriu novo chapter suggestion';
			}
		}
		
		
		//copia hotwords com novo chapterid.
		$oldchapters_hotwords = get_records_select('hiperbook_chapters_hotword',"chapterid= $oldchapterid");
		foreach($oldchapters_hotwords as $oldchapters_hotword){
			$newchapter_hotword = $oldchapters_hotword;
			$newchapter_hotword->chapterid = $newchapterid;	
			$newchapter_hotword->content = mysql_real_escape_string($oldchapters_hotword->content);
			$newchapter_hotword->title = mysql_real_escape_string($oldchapters_hotword->title);
			if(!insert_record('hiperbook_chapters_hotword', $newchapter_hotword)){
			//	echo $newchapter_hotword->content;
				echo 'nao inseriu novo chapter hotword';			
			}else{
			//	echo 'inseriu novo chapter hotword';
			}
		}
	
	//copia LINKS com novo chapterid. e atualiza o targetchapoter id
		$oldchapters_links= get_records_select('hiperbook_chapters_links',"chapterid= $oldchapterid");
		foreach($oldchapters_links as $oldchapters_link){				
			$newchapter_link = $oldchapters_link;
			$newchapter_link->chapterid = $newchapterid;	
			if(!insert_record('hiperbook_chapters_links', $newchapter_link)){
				echo 'nao inseriu novo chapter links';
			}else{
				//echo 'inseriu novo chapter link';
			}
		}		
			
	return $newchapterid;
}
//copy and updates navigation_chapters of current navigationpath from old_book_id to new_book_id using old_new_chapters_map
//hiperbook_copy_navigation_chapters($new_navigation_id, $old_navigation_chapters, $old_new_chapters_map);
function hiperbook_copy_navigation_chapter($new_navigation_id,$old_navigation_chapter,$old_new_chapters_map){

global $db, $CFG;	
	$newnavigation_chapter = $oldnavigation_chapter;										
	$newnavigation_chapter->navigationid = $new_navigation_id;											
	$newnavigation_chapter->parentnavchapterid = $old_navigation_chapter->parentnavchapterid ;	
	$newnavigation_chapter->chapternum = $old_navigation_chapter->chapternum;
	$newnavigation_chapter->chapterid = $old_navigation_chapter->chapterid;	
	// varre o mapeamento atualizando o registro
	foreach($old_new_chapters_map as $map){	
		if($map[0]==$newnavigation_chapter->chapterid){
			$newnavigation_chapter->chapterid = $map[1];				
		}
	}	
	$new_nav_id = insert_record('hiperbook_navigation_chapters', $newnavigation_chapter);
	if (!$new_nav_id){
		echo ' nao inseriu novo navigation chapter';
	}else{
		//echo ' inseriu novo navigation chapter';	
	}
	return $new_nav_id;	
}


function hiperbook_get_parent_chapternums($ch){	
	global $CFG;
	//echo 'hiperbook_navigation_chapters'."chapterid". $ch->parentnavchapterid;	
	$parent_num = get_record('hiperbook_navigation_chapters',"id", $ch->parentnavchapterid );	
	//var_dump($parent_num);
	//$parent_chater = get_record('hiperbook_chapters',"chapterid", $chapterid);	
	// se tem pai busca o num 
	//echo $parent_num->parentnavchapterid;	
		// se tem pai
	if (($parent_num)){			
		$parent_chapternums = hiperbook_get_parent_chapternums($parent_num , $chapternums, $level ).'.'.$ch->chapternum;		
	}else{
		$parent_chapternums = $ch->chapternum;
	}	
	return $parent_chapternums;
}

function hiperbook_parse_copy_resourses($conteudo, $bookid, $courseid) {
global $CFG, $db;
 // book id used in callback function... 
global $bookid_aux;
$bookid_aux = $bookid;

if(!$bookid){ echo ' falout bookid'; die(); }

// prepara pasta destino dos assets
		if(!file_exists($CFG->dataroot.'/'.$courseid.'/temp/assets/'.$bookid) ) { 	mkdir($CFG->dataroot.'/'.$courseid.'/temp/assets/'.$bookid); }

// normaliza
$conteudo = str_replace('../../file.php', $CFG->wwwroot.'/file.php', $conteudo);
				
// realiza as substituicoes correspondentes:		
$conteudo = str_replace($CFG->wwwroot, '',$conteudo);

// trata a tag background="images/template_hiperlivro.gif"
// presente no template inicial, que deve apontar para 
// $CFG->wwwroot.'/file.php/'.$course->id.'/template_hiperbook'.$book->id.'/template_hiperlivro.gif';
		
//$conteudo = str_replace('background="images/template_hiperlivro.gif"', 'background="../../assets/images/template_hiperlivro.gif"',$conteudo);
		

// substitui os links e popups : 
//  popup.php?id=784&navigationnum=2&chapterid=26 -> javascript:window.open(../cap26/index.htm);
// view.php?id=5779&chapterid=10699&pagenum=1&navigationnum=1 ../cap26/index.htm
// first search for chapters, then replace				
				
		// links
		$search = "/(.*?)(\'|\")(view.php\?id\=)(.*?)&navigationnum=(.*?)&pagenum=(.*?)&show_navigation=(.*?)&groupid=(.*?)&target_navigation_chapter=(.*?)(\'|\")/";				
		preg_match_all( $search, $conteudo , $assets);
	
	//var_dump($assets);
		$views_ids = $assets[4];		
		$views_navnums= $assets[5];		
		$pagenums = $assets[6];
 		$views_show_navigation = $assets[7];
 		$views_groups = $assets[8];
 		$views_target_navigation_chapter = $assets[9];
		$count=0;
		$views_chapterids  = array();
		foreach($views_target_navigation_chapter as $nc){
			$cidAux = get_record_select('hiperbook_navigation_chapters',"id=".$nc->id );			
			$views_chapterids[$count] =  $cidAux->chapterid;				
			$count++;	
		}
		
		$count=0;
		foreach($views_chapterids as $chapterid){
			$search = 'view.php?id='.$views_ids[$count].'&navigationnum='.$views_navnums[$count].'&pagenum='.$pagenums[$count].'&show_navigation='.$views_show_navigation[$count].'&groupid='.$views_groups[$count].'&target_navigation_chapter='.$views_target_navigation_chapter[$count];			
			$replace = '../cap'.$views_chapterids[$count].'/'.$pagenums[$count].'.html';
			
			//echo 'trocando'.$search;
			$conteudo = str_replace($search,$replace,$conteudo);			
			$count++;
		}
					
		$search = "/(.*?)(\'|\")(popup.php\?id\=)(.*?)&navigationnum=(.*?)&pagenum=(.*?)&show_navigation=(.*?)&groupid=(.*?)&target_navigation_chapter=(.*?)(\'|\")/";	
		preg_match_all( $search, $conteudo , $assets);	
		
	//	var_dump($assets);
		
		$views_ids = $assets[4];		
		$views_navnums= $assets[5];		
		$pagenums = $assets[6];
 		$views_show_navigation = $assets[7];
 		$views_groups = $assets[8];
 		$views_target_navigation_chapter = $assets[9];
		$count=0;
		$views_chapterids  = array();
		foreach($views_target_navigation_chapter as $nc){			
			//$db->debug = true;
			$cidAux = get_record_select('hiperbook_navigation_chapters',"id=".$nc);
			$views_chapterids[$count] =  $cidAux->chapterid;				
			$count++;	
		}
		
		$count=0;		
		foreach($views_chapterids as $chapterid){
			$search = 'popup.php?id='.$views_ids[$count].'&navigationnum='.$views_navnums[$count].'&pagenum='.$pagenums[$count].'&show_navigation='.$views_show_navigation[$count].'&groupid='.$views_groups[$count].'&target_navigation_chapter='.$views_target_navigation_chapter[$count];			
			$replace = '../cap'.$views_chapterids[$count].'/'.$pagenums[$count].'.html';
			
		//	echo 'trocando popup'.$search. 'por'. $replace;
			$conteudo = str_replace($search,$replace,$conteudo);			
			$count++;
		}			
		
		// trata referencias para arquivos de recursos 
		// 1 - copia o recurso para a pasta de assets
		// 2 -  substitui o link no conteudo 						
		//3 - para FLVs aplica o filtro multimidia
				
						
		///filter/mediaplugin/flvplayer.swf?
		$search ='/filter/mediaplugin/flvplayer.swf';
		$replace = '../../assets/flvplayer.swf';
		$conteudo = str_replace($search, $replace, $conteudo );
		
		//echo 'replaceing flv'. $conteudo ;
	
		$search='(\\/file\\.php\\/(.*?)("|\\&|\\?|\\)))';	
		preg_match_all( $search, $conteudo , $assets);		
		$flvs = $assets[1];
		$count=0;		


		//SWFS
		foreach($flvs as $flv){		
			// copia os arquivos para a pasta de assets						
			//echo '<br>Copiando '. $CFG->dataroot.'/'.$flv . ' para '. $CFG->dataroot.'/'.$courseid.'/temp/assets/'.$bookid.'/'.basename($flv);			
			copy($CFG->dataroot.'/'.$flv, $CFG->dataroot.'/'.$courseid.'/temp/assets/'.$bookid.'/'.basename($flv) );			
			$search='/file.php/'.$flv;			
			$extensao = array_pop(explode(".",$flv));
			
			if ($extensao == "swf"){		
				///file.php/27/Fractal/levRootGardener.swf
				//$replace ='../../assets/'.$bookid_aux.'/'.basename($flv);								
				//$conteudo = str_replace($search,$replace,$conteudo);				
			}
			if($extensao == "flv"){
			//	$replace ='../../assets/'.$bookid.'/'.basename($flv)."?d=300x250";
			
				$replace =  '../../assets/'.$bookid.'/'.basename($flv);
				$conteudo = str_replace($search,$replace,$conteudo);	
			// path must be relative to player
			//flvplayer.swf?file=316/ET1_1V0A.flv" 
				$search = 'flvplayer.swf?file='.'../../assets/'.$bookid.'/'.basename($flv);
				$replace =  'flvplayer.swf?file='.$bookid.'/'.basename($flv);
				$conteudo = str_replace($search,$replace,$conteudo);	
										
			}else{
				//echo 'substituindo'. $search;			
				$replace= '../../assets/'.$bookid.'/'.basename($flv);			
				$conteudo = str_replace($search,$replace,$conteudo);			
			}
			$count++;	
		}		
		//echo $conteudo;
 return $conteudo; 
}
/*function hiperbook_filter_swf_callback($link) {
    static $count = 0;
	global $COURSE,$bookid_aux;
    $count++;
    $id = 'filter_swf_'.time().$count; //we need something unique because it might be stored in text cache
    $div_id = 'filter_swfplayer_'.time().$count;

    $width  = empty($link[3]) ? '400' : $link[3];
    $height = empty($link[4]) ? '300' : $link[4];
  //  $url = addslashes_js($link[1]);

//'../../assets/'.$bookid.'/'.basename($link[1]);

///file.php/27/Fractal/levRootGardener.swf

$nurl = addslashes_js('../../assets/'.$bookid_aux.'/'.basename($link[1]));

    return $link[0].
'<span class="mediaplugin mediaplugin_swf" id="'.$id.'">('.get_string('flashanimation', 'mediaplugin').')</span>
<div id="'.$div_id.'" class="mediaplugin_swf"></div>
<script type="text/javascript">
//<![CDATA[
  var FO = { movie:"'.$nurl.'", width:"'.$width.'", height:"'.$height.'", majorversion:"6", build:"40",
    allowscriptaccess:"never", quality: "high" };
  UFO.create(FO, "'.$div_id.'");
//]]>
</script>';
}
*/

/* EXPORT TO HTML HTML HTML */

function hiperbook_to_html($id){
global $db;

if (!$cm = get_record('course_modules', 'id', $id)) {
    error('Course Module ID is incorrect');
}
if (!$course = get_record('course', 'id', $cm->course)) {
    error('Course is misconfigured');
}
if (!$book = get_record('hiperbook', 'id', $cm->instance)) {
    error('Course module is incorrect');
}
$bookid = $book->id;
	//set_time_limit(3000);
	global $CFG,$course;	
	ob_start();
	ob_implicit_flush();
	echo "<br>Copying files\n";
	ob_flush();
	// cria a pasta de trabalho temporaria
	mkdir($CFG->dataroot.'/'.$course->id.'/temp');
	mkdir($CFG->dataroot.'/'.$course->id.'/temp/assets');	
	//copia arquivos do hiperlivro para assets
	mkdir($CFG->dataroot.'/'.$course->id.'/temp/assets/images');	
	
	// API do JS
	copy('prototype.js',$CFG->dataroot.'/'.$course->id.'/temp/assets/prototype.js');
	copy('effects.js',$CFG->dataroot.'/'.$course->id.'/temp/assets/effects.js');
	copy('dragdrop.js',$CFG->dataroot.'/'.$course->id.'/temp/assets/dragdrop.js');
	copy('popup.js',$CFG->dataroot.'/'.$course->id.'/temp/assets/popup.js');
	
	copy($CFG->dirroot.'/filter/mediaplugin/flvplayer.swf',$CFG->dataroot.'/'.$course->id.'/temp/assets/flvplayer.swf');
	
	copy($CFG->dirroot.'/filter/mediaplugin/eolas_fix.js',$CFG->dataroot.'/'.$course->id.'/temp/assets/eolas_fix.js');
	
	copy($CFG->dirroot.'/lib/ufo.js',$CFG->dataroot.'/'.$course->id.'/temp/assets/ufo.js');

	
	mkdir($CFG->dataroot.'/'.$course->id.'/temp/scos');
		
	// transforma o hiperbook em um pacote HTML , com base no esquema do SCORm dentro da estrutura
	
	/*
	/assets : pasta onde sao armazenadas as imgs, swfs e etc
	/scos : pasta onde sao gravados os capitulos e sub-itens ex /scos/14, /scos/14/dicas 
	/  
	
	*/ 
	
	
	
	//inicia pela geração das paginas html dos capityulos (resources)
	echo "<br>Processing chapters:<br>";
	
	hiperbook_parse_html_index($bookid, $cm->id);	
	hiperbook_parse_chapters_to_html($bookid, $cm->id);
	hiperbook_parse_hotwordspage($bookid,$cm->id);
	hiperbook_parse_suggestionspage($bookid,$cm->id);
		//compactando
	echo "<br>Zipping files...";
	
	$basedir =$CFG->dataroot.'/'.$course->id.'/temp';
	$fullpath = $CFG->dataroot.'/'.$course->id.'/temp';

    $directory = opendir($fullpath);             // Find all files
    while (false !== ($file = readdir($directory))) {
        if ($file == "." || $file == "..") {
            continue;
        }
        
            $filelist[] = $file;
        
    }
    closedir($directory);	
	
	if (!$book = get_record('hiperbook', 'id', $bookid)) {
        return false;
    }
	 $files = array();
                foreach ($filelist as $file) {
                   $files[] = "$basedir/$file";
                }
		
$zipfile =zip_files($files,$CFG->dataroot.'/'.$course->id."/".$book->name."_html");	
                if (!$zipfile) {
                    error(get_string("zipfileserror","error"));
                }


               
	// remove a pasta temporaria
	echo "<br>Deleting temporary data...";	
	//hiperbook_recursive_remove_directory($CFG->dataroot.'/'.$course->id.'/temp', $empty=FALSE);
	echo "<br>Saved in  <a href=".$CFG->wwwroot."/files/index.php?id=".$course->id.">". $book->name."_html.zip</a>" ;
	
}

function hiperbook_parse_html_index($bookid, $cmid){ 
global $CFG,$course, $db;
// imprime o index com primeiro navpath selecionado
$navpaths = get_records_select('hiperbook_navigationpath',"bookid = $bookid", 'navpathnum');
mkdir($CFG->dataroot.'/'.$course->id.'/temp/scos/navpaths');

//	$context = stream_context_create(array('http' => array('header'=>'Connection: close')));
	
foreach($navpaths as $np){	
	$conteudo = file_get_contents($CFG->wwwroot.'/mod/hiperbook/htmlerTemplate.php?id='.$cmid.'&navigationnum='.$np->navpathnum);
		$conteudo =	 hiperbook_parse_copy_resourses($conteudo, $np->bookid, $course->id) ;
		hiperbook_write_to_file($CFG->dataroot.'/'.$course->id.'/temp/scos/navpaths/indexnavpath'.$np->navpathnum.'.html', $conteudo ) ;
		$head = '<META HTTP-EQUIV=REFRESH CONTENT="1; URL=scos/navpaths/indexnavpath'.$np->navpathnum.'.html">';		 
		 if($np->navpathnum == 1){ 
			hiperbook_write_to_file($CFG->dataroot.'/'.$course->id.'/temp/index.html', $head ); 
		  }	
	} 					 
}

function hiperbook_parse_chapters_to_html($bookid,$cm_id){
	global $CFG,$course, $db;

	$chapters = get_records_select('hiperbook_chapters',"bookid=$bookid" );
	foreach($chapters as $chapter){
		// cria a pasta de trabalho temporaria 
		echo "<br>Processing chapter ". $chapter->title;
			ob_flush();
		mkdir($CFG->dataroot.'/'.$course->id.'/temp/scos/cap'.$chapter->id);	
$navpath = get_records_sql('select p.navpathnum, n.parentnavchapterid from '.$CFG->prefix.'hiperbook_navigation_chapters n,'.$CFG->prefix.'hiperbook_navigationpath p where n.chapterid ='. $chapter->id .' and n.navigationid = p.id'); 		
		foreach($navpath as $np){ 
			hiperbook_parse_pages($chapter->id,$cm_id,'HTML',$np->navpathnum, $np->parentnavchapterid);		
		}	 
	}
}

/* SCORM SCORM SCORM */

function hiperbook_to_scorm($id){
if (!$cm = get_record('course_modules', 'id', $id)) {
    error('Course Module ID is incorrect');
}
if (!$course = get_record('course', 'id', $cm->course)) {
    error('Course is misconfigured');
}
if (!$book = get_record('hiperbook', 'id', $cm->instance)) {
    error('Course module is incorrect');
}
$bookid = $book->id;
	set_time_limit(3000);
	global $CFG,$course;	
	ob_start();
	ob_implicit_flush();
	echo "<br>Copying files\n";
	ob_flush();
	// cria a pasta de trabalho temporaria
	mkdir($CFG->dataroot.'/'.$course->id.'/temp');
	mkdir($CFG->dataroot.'/'.$course->id.'/temp/assets');	
	//copia arquivos do hiperlivro para assets
	mkdir($CFG->dataroot.'/'.$course->id.'/temp/assets/images');			
	copy($book->img_hotwords_icon,$CFG->dataroot.'/'.$course->id.'/temp/assets/images/');
	copy($book->img_suggestions_icon,$CFG->dataroot.'/'.$course->id.'/temp/assets/images/');	
	copy('images/next.gif',$CFG->dataroot.'/'.$course->id.'/temp/assets/images/next.gif');
	copy('images/back.gif',$CFG->dataroot.'/'.$course->id.'/temp/assets/images/back.gif');
	
	copy('prototype.js',$CFG->dataroot.'/'.$course->id.'/temp/assets/prototype.js');
	copy('effects.js',$CFG->dataroot.'/'.$course->id.'/temp/assets/effects.js');
	copy('dragdrop.js',$CFG->dataroot.'/'.$course->id.'/temp/assets/dragdrop.js');
	copy('popup.js',$CFG->dataroot.'/'.$course->id.'/temp/assets/popup.js');
	copy('findAPI.js',$CFG->dataroot.'/'.$course->id.'/temp/assets/findAPI.js');

	
	mkdir($CFG->dataroot.'/'.$course->id.'/temp/scos');
		
	// transforma o hiperbook em um pacote SCORm dentro da estrutura
	
	/*
	/assets : pasta onde sao armazenadas as imgs, swfs e etc
	/scos : pasta onde sao gravados os capitulos e sub-itens ex /scos/14, /scos/14/dicas 
	/  
	
	*/ 
	
	//inicia pela geração das paginas html dos capityulos (resources)
	echo "<br>Processing chapters:<br>";
		ob_flush();
	hiperbook_parse_chapters($bookid, $cm->id, 'SCORM');
	
	hiperbook_parse_hotwordspage($bookid,$cm->id);
	hiperbook_parse_suggestionspage($bookid,$cm->id);
	// converte os navpaths e cria os elementos do modelo de navagação	
	echo "<br>Creating manifest...<br>";
		ob_flush();
	hiperbook_create_ims_manifest($bookid);
	
	//compactando
	echo "<br>Zipping files...";
		ob_flush();
	$basedir =$CFG->dataroot.'/'.$course->id.'/temp';
	$fullpath = $CFG->dataroot.'/'.$course->id.'/temp';

    $directory = opendir($fullpath);             // Find all files
    while (false !== ($file = readdir($directory))) {
        if ($file == "." || $file == "..") {
            continue;
        }
        
            $filelist[] = $file;
        
    }
    closedir($directory);	
	
	if (!$book = get_record('hiperbook', 'id', $bookid)) {
        return false;
    }
	 $files = array();
                foreach ($filelist as $file) {
                   $files[] = "$basedir/$file";
                }

                if (!zip_files($files,$CFG->dataroot.'/'.$course->id."/".$book->name."_scorm")) {
                    error(get_string("zipfileserror","error"));
                }

               
	// remove a pasta temporaria
	echo "<br>Deleting temporary data...";	
	hiperbook_recursive_remove_directory($CFG->dataroot.'/'.$course->id.'/temp', $empty=FALSE);
	echo "<br>Saved in  <a href=".$CFG->wwwroot."/files/index.php?id=".$course->id.".zip>". $book->name.".zip</a>" ;
}

function hiperbook_parse_chapters($bookid,$cm_id,$parentnavchapterid=0, $mode){
	global $CFG,$course;
	
	$chapters = get_records_select('hiperbook_chapters',"bookid=$bookid" );
	foreach($chapters as $chapter){
		// cria a pasta de trabalho temporaria 
		echo "<br>Processing chapter ". $chapter->title;
			ob_flush();
		mkdir($CFG->dataroot.'/'.$course->id.'/temp/scos/cap'.$chapter->id);
		hiperbook_parse_pages($chapter->id,$cm_id,$parentnavchapterid,$mode);
		
	}
}

function hiperbook_parse_hotwordspage($bookid ,$cm_id){
	global $CFG,$course;	
	//se tiver cria uma pasta correspondente
	$hotwords = get_records_select('hiperbook_chapters_hotword',"idhiperbook= $bookid", 'title ASC');	
	if(count($hotwords)>0){		
		mkdir($CFG->dataroot.'/'.$course->id.'/temp/scos/hotwords');
		//echo 'buscando'. $CFG->wwwroot.'/mod/hiperbook/glossary.php?id='.$cm_id;
		 $conteudo = file_get_contents($CFG->wwwroot.'/mod/hiperbook/glossary.php?id='.$cm_id);		
		 
		 $conteudo =	hiperbook_parse_copy_resourses($conteudo, $bookid, $course->id) ; 
		hiperbook_write_to_file($CFG->dataroot.'/'.$course->id.'/temp/scos/hotwords/index.html', $conteudo ) ;
	}	
}


function hiperbook_parse_suggestionspage($bookid ,$cm_id){
	global $CFG,$course;	
	//se tiver cria uma pasta correspondente
	$hotwords = get_records_select('hiperbook_chapters_suggestions',"idhiperbook= $bookid", 'title ASC');	
	if(count($hotwords)>0){		
		mkdir($CFG->dataroot.'/'.$course->id.'/temp/scos/bibliography');
		echo 'buscandoBiblio'. $CFG->wwwroot.'/mod/hiperbook/bibliography.php?id='.$cm_id;
		 $conteudo = file_get_contents($CFG->wwwroot.'/mod/hiperbook/bibliography.php?id='.$cm_id);	
		 	 
		 $conteudo =	hiperbook_parse_copy_resourses($conteudo, $bookid, $course->id) ; 
		hiperbook_write_to_file($CFG->dataroot.'/'.$course->id.'/temp/scos/bibliography/index.html', $conteudo ) ;
	}	
}


// method converts php content to HTML or SCORM
function hiperbook_parse_pages($chapterid,$cm_id, $mode= 'SCORM',$navigationnum =1,$parentnavchapterid = 0){
	global $CFG,$course;
	
	// busca as paginas
	$pages = get_records_select('hiperbook_chapters_pages',"chapterid= $chapterid");
	
	// WRITES AN EMPTY PAGE FOR CHAPTERS WITHOUT PAGES IN DATABASE 
	$conteudo = file_get_contents($CFG->wwwroot.'/mod/hiperbook/htmlerTemplate.php?chapterid='.$chapterid.'&pagenum=1&show_navigation=1&id='.$cm_id.'&navigationnum='.$navigationnum.'&parentnavchapterid='.$parentnavchapterid );	
	hiperbook_write_to_file($CFG->dataroot.'/'.$course->id.'/temp/scos/cap'.$chapterid.'/1.html',$conteudo);
	
	
	//var_dump($pages);
	foreach($pages as $page){				
		//busca o conteudo da pagina			
		echo 'buscando '. $CFG->wwwroot.'/mod/hiperbook/htmlerTemplate.php?chapterid='.$page->chapterid.'&pagenum='. $page->pagenum.'&show_navigation=1&id='.$cm_id.'&navigationnum='.$navigationnum.'&parentnavchapterid='.$parentnavchapterid;		
		if($mode == 'HTML'){	
		//	echo "HTML mode<br>";			
			 $conteudo = file_get_contents($CFG->wwwroot.'/mod/hiperbook/htmlerTemplate.php?chapterid='.$page->chapterid.'&pagenum='. $page->pagenum.'&show_navigation=1&id='.$cm_id.'&navigationnum='.$navigationnum.'&parentnavchapterid='.$parentnavchapterid );				 				 
		}else{ 
			//	echo "SCORM mode<br>";
			 $conteudo = file_get_contents($CFG->wwwroot.'/mod/hiperbook/scormerTemplate.php?chapterid='.$page->chapterid.'&pagenum='. $page->pagenum.'&show_navigation=0&id='.$cm_id);				 
		//	 echo $CFG->wwwroot.'/mod/hiperbook/scormerTemplate.php?chapterid='.$page->chapterid.'&pagenum='. $page->pagenum.'&show_navigation=0&id='.$cm_id;		 
		 }
	$conteudo =	hiperbook_parse_copy_resourses($conteudo, $page->idhiperbook, $course->id) ;
	
	ob_flush();
	hiperbook_write_to_file($CFG->dataroot.'/'.$course->id.'/temp/scos/cap'.$page->chapterid.'/'.$page->pagenum.'.html',$conteudo);		
// echo $conteudo; 
	}					
}//end parse_pages
// 

function hiperbook_create_ims_manifest($bookid){
	global $CFG,$course;	
	$out_str .= '<?xml version="1.0" encoding="UTF-8"?>';
	$out_str .='<manifest xmlns="http://www.imsproject.org/xsd/imscp_rootv1p1p2" xmlns:imsmd="http://www.imsglobal.org/xsd/imsmd_rootv1p2p1" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:adlcp="http://www.adlnet.org/xsd/adlcp_rootv1p2" identifier="MANIFEST-LIBRAS'.$bookid.'" xsi:schemaLocation="http://www.imsproject.org/xsd/imscp_rootv1p1p2 imscp_rootv1p1p2.xsd http://www.imsglobal.org/xsd/imsmd_rootv1p2p1 imsmd_rootv1p2p1.xsd http://www.adlnet.org/xsd/adlcp_rootv1p2 adlcp_rootv1p2.xsd">';
	
	$organizations = get_records_select('hiperbook_navigationpath',"bookid=$bookid" );
	

	// metadados 
	
	$out_str .= hiperbook_write_metadata($bookid);
	
	
	//var_dump($organizations);
	
	foreach($organizations as $organization){
	
		if ($i==0){
			$out_str .= "<organizations default=\"ORG-". $organization->id ."\">";
			$i++;		
		}
		$out_str .= "<organization identifier=\"ORG-". $organization->id ."\" structure=\"hierarchical\"><title>". utf8_encode($organization->name) ."</title>";		
		
		// imprime os itens a partir do pai
		$organization_itens  = get_records_sql("select i.id id, i.chapterid chapterid, i.navigationid navigationid from ". $CFG->prefix."hiperbook_navigation_chapters i where navigationid= '$organization->id' and parentnavchapterid='0' order by i.chapternum");

		$out_str .= hiperbook_print_ims_manifest_itens($organization_itens);
		$out_str .= "</organization>";		
	}
	
	$out_str .= "</organizations>";
	
	$resources = get_records_select('hiperbook_chapters',"bookid=$bookid",'id' );	
	$out_str .= "<resources>";
	$out_str .= hiperbook_print_ims_manifest_resources($resources);
	$out_str .= "</resources>";	
	$out_str .= "</manifest>";	
	
	

	hiperbook_write_to_file($CFG->dataroot.'/'.$course->id.'/temp/imsmanifest.xml',$out_str);
}

function hiperbook_print_ims_manifest_itens($organization_itens){

	global $CFG,$course;
	
	foreach($organization_itens as $organization_item){
	
		$chapter= get_record('hiperbook_chapters','id',$organization_item->chapterid);	
//var_dump($chapter);
		if ($chapter->hidden == "1"){
			$visible = 'false';
					echo 'INVISIVEL'; 
		}else{
			$visible = 'true'; 
		}
		

		$itens .= "<item identifier=\"ITEM-".$organization_item->id. "\" identifierref=\"RES-". $organization_item->chapterid."\" isvisible=\"".$visible."\"><title>".utf8_encode($chapter->title)."</title>";		
		$organization_sub_itens = get_records_sql("select i.id id, i.chapterid chapterid, i.navigationid navigationid from ". $CFG->prefix."hiperbook_navigation_chapters i where navigationid='$organization_item->navigationid' and parentnavchapterid='$organization_item->id'");		
	
		//var_dump($organization_sub_itens);
		$itens .= hiperbook_print_ims_manifest_itens($organization_sub_itens);		
		$itens .= "</item>";
		
	}

	return $itens;

}	

function hiperbook_print_ims_manifest_resources($resources){
	global $CFG,$course;
	
	
	
$vcard ="BEGIN:VCARD\nFN:Joe Friday\nTEL:+1-
919-555-7878\nTITLE:Area Administrator\,
Assistant\n
EMAIL\;TYPE=INTERN\nET:jfriday@host.c
om\nEND:VCARD\n";
	
	

	foreach($resources as $resource){
 		$out_str .= "<resource identifier=\"RES-".$resource->id."\" type=\"webcontent\" adlcp:scormtype=\"sco\" href=\"scos/cap".$resource->id."/1.html\">";
 
  // arquivos q o sco referencia (?)  
 /* <file href="Aprendizagem/textura/Conteudos/Aplicacao/introducao/index.html" /> 
  <file href="Aprendizagem/textura/Conteudos/Aplicacao/introducao/textura urbana.jpg" /> 
  */
  
  $out_str .="</resource>";
	
	

	}
	return $out_str;
}
function hiperbook_write_metadata($bookid) {


	$metadata = get_record('hiperbook_metadata','bookid',$bookid);	
	$general = get_record('hiperbook_metadata_general','metadata_id',$metadata->id);	
	

/* GENERAL */

$out_str .= '<metadata>';
$out_str .= '<imsmd:lom>';
$out_str .= '<imsmd:general>';

$out_str .='<imsmd:identifier>'.$general->identifier .'</imsmd:identifier>'; 
//titulo
$out_str .='<imsmd:title>';
$out_str .='<imsmd:langstring xml:lang="pt">'. $general->title.'</imsmd:langstring>';
$out_str .='</imsmd:title>';
// catalog
$out_str .='<imsmd:catalogentry>';
$out_str .='<imsmd:catalog>'. $general->catalog .'</imsmd:catalog>';
$out_str .='<imsmd:entry>';
$out_str .='<imsmd:langstring xml:lang="pt">'.$general->entry.'</imsmd:langstring>';
$out_str .='</imsmd:entry>';
$out_str .='</imsmd:catalogentry>';

// lingua
$out_str .='<imsmd:language>'.$general->language.'</imsmd:language>'; 
// descrição
$out_str .='<imsmd:description>';
$out_str .='<imsmd:langstring xml:lang="pt">'.$general->description.'</imsmd:langstring>';
$out_str .='</imsmd:description>';
// keywords
$out_str .='<imsmd:keyword>';
$out_str .='<imsmd:langstring xml:lang="pt">'.$general->keyword.'</imsmd:langstring>';
$out_str .='</imsmd:keyword>';
// cpverage
$out_str .='<imsmd:coverage>';
$out_str .='<imsmd:langstring 
xml:lang="en">'.$general->coverage.'</imsmd:langstring>';
$out_str .='</imsmd:coverage>';
//structure
$out_str .='<imsmd:structure>';
$out_str .='<imsmd:source>';
$out_str .='<imsmd:langstring xml:lang="pt">LOMv1.0</imsmd:langstring>'; 
$out_str .='</imsmd:source>';
$out_str .='<imsmd:value>';
$out_str .='<imsmd:langstring xml:lang="x-none">'.$general->structure.'</imsmd:langstring>';
$out_str .='</imsmd:value>';
$out_str .='</imsmd:structure>';
//aggregation level
$out_str .='<imsmd:aggregationlevel>';
$out_str .='<imsmd:source>';
$out_str .='<imsmd:langstring xml:lang="pt">LOMv1.0</imsmd:langstring>';
$out_str .='</imsmd:source>';
$out_str .='<imsmd:value>';
$out_str .='<imsmd:langstring xml:lang="x-none">4</imsmd:langstring>'; 
$out_str .='</imsmd:value>';
$out_str .='</imsmd:aggregationlevel>';
$out_str .='</imsmd:general>';

/* LIFECICLE */
$lifecicle = get_record('hiperbook_metadata_lifecicle','metadata_id',$metadata->id);	
$out_str .='<lifecycle>';
$out_str .='<version>';
$out_str .='<langstring xml:lang="en">'. $lifecicle->version .'</langstring>'; 
$out_str .='</version>';
$out_str .='<status>';
$out_str .='<source>';
$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>';
$out_str .='</source>';
$out_str .='<value>';
$out_str .='<langstring xml:lang="x-none">'. $lifecicle->version_status .'</langstring>'; 
$out_str .='</value>';
$out_str .='</status>';

$lifecicle_contributions = get_records('hiperbook_metadata_lifecicle_contribution','metadata_lifecicle_id',$lifecicle->id);	

foreach($lifecicle_contributions as $contribution){
	$out_str .='<contribute>';
	$out_str .='<role>';
	$out_str .='<source>';
	$out_str .='<langstring xml:lang="pt">LOMv1.0</langstring>'; 
	$out_str .='</source>';
	$out_str .='<value>';
	$out_str .='<langstring xml:lang="x-none">'.$contribution->role.'</langstring>'; 
	$out_str .='</value>';
	$out_str .='</role>';
	$out_str .='<centity>';
	$out_str .='<vcard>'.$contribution->vcard.'</vcard>'; 
	$out_str .='</centity>';
	$out_str .='<date>';
	$out_str .='<datetime>'.$contribution->date.'</datetime>'; 
	$out_str .='</date>';
	$out_str .='</contribute>';
}
$out_str .='</lifecycle>';

/* META-METADATA  ??*/

$out_str .='<metametadata>';
$out_str .='<identifier>um nomero aleatorio</identifier>';
$out_str .='<catalogentry>';
$out_str .='<catalog>catalogo</catalog>';
$out_str .='<entry>';
$out_str .='<langstring xml:lang="en">sdf</langstring>'; 
$out_str .='</entry>';
$out_str .='</catalogentry>';
$out_str .='<contribute>';
$out_str .='<role>';
$out_str .='<source>';
$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>'; 
$out_str .='</source>';
$out_str .='<value>';
$out_str .='<langstring xml:lang="x-none">Creator</langstring>'; 
$out_str .='</value>';
$out_str .='</role>';
$out_str .='<centity>';
$out_str .='<vcard>dsf</vcard>'; 
$out_str .='</centity>';
$out_str .='<date>';
$out_str .='<datetime>dsf</datetime>';
$out_str .='</date>';
$out_str .='</contribute>';
$out_str .='<metadatascheme>sdfs</metadatascheme>'; 
$out_str .='<language>pt_br</language>';
$out_str .='</metametadata>';

/* TECHNICAL */
/* indica quais os formatos de arquivos existentes e etc -> vazio*/
$out_str .='<technical>';
$out_str .='<format />';
$out_str .='<size />';
$out_str .='<location />';
$out_str .='<requirement>';
$out_str .='<type>';
$out_str .='<source>';
$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>'; 
$out_str .='</source>';
$out_str .='<value>';
$out_str .='<langstring xml:lang="x-none" />';
$out_str .='</value>';
$out_str .='</type>';
$out_str .='<name>';
$out_str .='<source>';
$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>'; 
$out_str .='</source>';
$out_str .='<value>';
$out_str .='<langstring xml:lang="x-none" />';
$out_str .='</value>';
$out_str .='</name>';
$out_str .='</requirement>';
$out_str .='</technical>';

/* EDUCATIONAL */
$educational = get_record('hiperbook_metadata_educational','metadata_id',$metadata->id);
$out_str .='<educational>';
$out_str .='<interactivitytype>';
$out_str .='<source>';
$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>'; 
$out_str .='</source>';
$out_str .='<value>';
$out_str .='<langstring xml:lang="x-none">'.$educational->interactivitytype.'</langstring>'; 
$out_str .='</value>';
$out_str .='</interactivitytype>';

if ($educational->exercise){
	$out_str .='<learningresourcetype>';
	$out_str .='<source>';
	$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>';
	$out_str .='</source>';
	$out_str .='<value>';
	$out_str .='<langstring xml:lang="x-none">exercise</langstring>'; 
	$out_str .='</value>';
	$out_str .='</learningresourcetype>';
}

if ($educational->simulation){
	$out_str .='<learningresourcetype>';
	$out_str .='<source>';
	$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>';
	$out_str .='</source>';
	$out_str .='<value>';
	$out_str .='<langstring xml:lang="x-none">simulation</langstring>'; 
	$out_str .='</value>';
	$out_str .='</learningresourcetype>';
}
if ($educational->questionnaire){
	$out_str .='<learningresourcetype>';
	$out_str .='<source>';
	$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>';
	$out_str .='</source>';
	$out_str .='<value>';
	$out_str .='<langstring xml:lang="x-none">questionnaire</langstring>'; 
	$out_str .='</value>';
	$out_str .='</learningresourcetype>';
}
if ($educational->diagram){
	$out_str .='<learningresourcetype>';
	$out_str .='<source>';
	$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>';
	$out_str .='</source>';
	$out_str .='<value>';
	$out_str .='<langstring xml:lang="x-none">diagram</langstring>'; 
	$out_str .='</value>';
	$out_str .='</learningresourcetype>';
}
if ($educational->figure){
	$out_str .='<learningresourcetype>';
	$out_str .='<source>';
	$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>';
	$out_str .='</source>';
	$out_str .='<value>';
	$out_str .='<langstring xml:lang="x-none">figure</langstring>'; 
	$out_str .='</value>';
	$out_str .='</learningresourcetype>';
}
if ($educational->graph){
	$out_str .='<learningresourcetype>';
	$out_str .='<source>';
	$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>';
	$out_str .='</source>';
	$out_str .='<value>';
	$out_str .='<langstring xml:lang="x-none">graph</langstring>'; 
	$out_str .='</value>';
	$out_str .='</learningresourcetype>';
}
if ($educational->index){
	$out_str .='<learningresourcetype>';
	$out_str .='<source>';
	$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>';
	$out_str .='</source>';
	$out_str .='<value>';
	$out_str .='<langstring xml:lang="x-none">index</langstring>'; 
	$out_str .='</value>';
	$out_str .='</learningresourcetype>';
}
if ($educational->slide){
	$out_str .='<learningresourcetype>';
	$out_str .='<source>';
	$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>';
	$out_str .='</source>';
	$out_str .='<value>';
	$out_str .='<langstring xml:lang="x-none">slide</langstring>'; 
	$out_str .='</value>';
	$out_str .='</learningresourcetype>';
}
if ($educational->table){
	$out_str .='<learningresourcetype>';
	$out_str .='<source>';
	$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>';
	$out_str .='</source>';
	$out_str .='<value>';
	$out_str .='<langstring xml:lang="x-none">table</langstring>'; 
	$out_str .='</value>';
	$out_str .='</learningresourcetype>';
}
if ($educational->narrative_text){
	$out_str .='<learningresourcetype>';
	$out_str .='<source>';
	$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>';
	$out_str .='</source>';
	$out_str .='<value>';
	$out_str .='<langstring xml:lang="x-none">narrative text</langstring>'; 
	$out_str .='</value>';
	$out_str .='</learningresourcetype>';
}
if ($educational->exam){
	$out_str .='<learningresourcetype>';
	$out_str .='<source>';
	$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>';
	$out_str .='</source>';
	$out_str .='<value>';
	$out_str .='<langstring xml:lang="x-none">exam</langstring>'; 
	$out_str .='</value>';
	$out_str .='</learningresourcetype>';
}
if ($educational->experiment){
	$out_str .='<learningresourcetype>';
	$out_str .='<source>';
	$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>';
	$out_str .='</source>';
	$out_str .='<value>';
	$out_str .='<langstring xml:lang="x-none">experiment</langstring>'; 
	$out_str .='</value>';
	$out_str .='</learningresourcetype>';
}
if ($educational->problem_statement){
	$out_str .='<learningresourcetype>';
	$out_str .='<source>';
	$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>';
	$out_str .='</source>';
	$out_str .='<value>';
	$out_str .='<langstring xml:lang="x-none">problem statement</langstring>'; 
	$out_str .='</value>';
	$out_str .='</learningresourcetype>';
}
if ($educational->self_assessment){
	$out_str .='<learningresourcetype>';
	$out_str .='<source>';
	$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>';
	$out_str .='</source>';
	$out_str .='<value>';
	$out_str .='<langstring xml:lang="x-none">self assessment</langstring>'; 
	$out_str .='</value>';
	$out_str .='</learningresourcetype>';
}
if ($educational->lecture){
	$out_str .='<learningresourcetype>';
	$out_str .='<source>';
	$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>';
	$out_str .='</source>';
	$out_str .='<value>';
	$out_str .='<langstring xml:lang="x-none">lecture</langstring>'; 
	$out_str .='</value>';
	$out_str .='</learningresourcetype>';
}

$out_str .='<interactivitylevel>';
$out_str .='<source>';
$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>';
$out_str .='</source>';
$out_str .='<value>';
$out_str .='<langstring xml:lang="x-none">'.$educational->interactivity_level.'</langstring>';
$out_str .='</value>';
$out_str .='</interactivitylevel>';

$out_str .='<semanticdensity>';
$out_str .='<source>';
$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>'; 
$out_str .='</source>';
$out_str .='<value>';
$out_str .='<langstring xml:lang="x-none">'.$educational->semanticdensity.'</langstring>'; 
$out_str .='</value>';
$out_str .='</semanticdensity>';

if($educational->intendedrole_manager){
	$out_str .='<intendedenduserrole>';
	$out_str .='<source>';
	$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>';
	$out_str .='</source>';
	$out_str .='<value>';
	$out_str .='<langstring xml:lang="x-none">manager</langstring>';
	$out_str .='</value>';
	$out_str .='</intendedenduserrole>';
}
if($educational->intendedrole_teacher){
	$out_str .='<intendedenduserrole>';
	$out_str .='<source>';
	$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>';
	$out_str .='</source>';
	$out_str .='<value>';
	$out_str .='<langstring xml:lang="x-none">teacher</langstring>';
	$out_str .='</value>';
	$out_str .='</intendedenduserrole>';
}
if($educational->intendedrole_student){
	$out_str .='<intendedenduserrole>';
	$out_str .='<source>';
	$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>';
	$out_str .='</source>';
	$out_str .='<value>';
	$out_str .='<langstring xml:lang="x-none">student</langstring>';
	$out_str .='</value>';
	$out_str .='</intendedenduserrole>';
}
if($educational->intendedrole_author){
	$out_str .='<intendedenduserrole>';
	$out_str .='<source>';
	$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>';
	$out_str .='</source>';
	$out_str .='<value>';
	$out_str .='<langstring xml:lang="x-none">author</langstring>';
	$out_str .='</value>';
	$out_str .='</intendedenduserrole>';
}

if($educational->context_higher_education){
	$out_str .='<context>';
	$out_str .='<source>';
	$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>';
	$out_str .='</source>';
	$out_str .='<value>';
	$out_str .='<langstring xml:lang="x-none">higher education</langstring>'; 
	$out_str .='</value>';
	$out_str .='</context>';
}
if($educational->context_school){
	$out_str .='<context>';
	$out_str .='<source>';
	$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>';
	$out_str .='</source>';
	$out_str .='<value>';
	$out_str .='<langstring xml:lang="x-none">school</langstring>'; 
	$out_str .='</value>';
	$out_str .='</context>';
}
if($educational->context_training){
	$out_str .='<context>';
	$out_str .='<source>';
	$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>';
	$out_str .='</source>';
	$out_str .='<value>';
	$out_str .='<langstring xml:lang="x-none">training</langstring>'; 
	$out_str .='</value>';
	$out_str .='</context>';
}
if($educational->context_other){
	$out_str .='<context>';
	$out_str .='<source>';
	$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>';
	$out_str .='</source>';
	$out_str .='<value>';
	$out_str .='<langstring xml:lang="x-none">other</langstring>'; 
	$out_str .='</value>';
	$out_str .='</context>';
}

$out_str .='<typicalagerange>';
$out_str .='<langstring xml:lang="en">'.$educational->typicalagerange.'</langstring>'; 
$out_str .='</typicalagerange>';

$out_str .='<difficulty>';
$out_str .='<source>';
$out_str .='<langstring xml:lang="en">LOMv1.0</langstring>';
$out_str .='</source>';
$out_str .='<value>';
$out_str .='<langstring xml:lang="x-none">'.$educational->difficulty.'</langstring>'; 
$out_str .='</value>';
$out_str .='</difficulty>';

$out_str .='<typicallearningtime>';
$out_str .='<datetime>'.$educational->typicallearningtime.'</datetime>'; 
$out_str .='</typicallearningtime>';

$out_str .='<description>';
$out_str .='<langstring xml:lang="en">'.$educational->educational_description.'</langstring>';
$out_str .='</description>';

$out_str .='<language>pt</language>';
$out_str .='</educational>';


/* Direitos autorais /*/
$rights = get_record('hiperbook_metadata_rights','metadata_id',$metadata->id);
$out_str .='<rights>';
$out_str .='<cost>';
$out_str .='<source>';
$out_str .='<langstring xml:lang="en">LOMv1.0</langstring> ';
$out_str .='</source>';
$out_str .='<value>';
$out_str .='<langstring xml:lang="x-none">'.$rights->costs .'</langstring> ';
$out_str .='</value>';
$out_str .='</cost>';
$out_str .='<copyrightandotherrestrictions>';
$out_str .='<source>';
$out_str .='<langstring xml:lang="en">LOMv1.0</langstring> ';
$out_str .='</source>';
$out_str .='<value>';
$out_str .='<langstring xml:lang="x-none">'.$rights->copyrightandotherrestrictions.'</langstring>'; 
$out_str .='</value>';
$out_str .='</copyrightandotherrestrictions>';
$out_str .='<description>';
$out_str .='<langstring xml:lang="en">'.$rights->rights_description.'</langstring> ';
$out_str .='</description>';
$out_str .='</rights>';

// ANOTAÇÔES
$annotations  = get_records('hiperbook_metadata_annotation','metadata_id',$metadata->id);
foreach($annotations as $annotation){
	$out_str .='<annotation>';
	$out_str .='<person>';
	$out_str .='<vcard>'.$annotation->entity.'</vcard>'; 
	$out_str .='</person>'; 
	$out_str .='<date>'; 
	$out_str .='<datetime>'.$annotation->date.'</datetime> '; 
	$out_str .='</date>'; 
	$out_str .='<description>'; 
	$out_str .='<langstring xml:lang="en">'.$annotation->annotation_description.'</langstring> '; 
	$out_str .='</description>'; 
	$out_str .='</annotation>'; 
}

//RELACAO COM OUTROS RECURSOS
$relations  = get_records('hiperbook_metadata_relation','metadata_id',$metadata->id);
foreach($relations as $relation){
	$out_str .='<relation>';
	$out_str .='<kind>';
	$out_str .='<source>';
	$out_str .='<langstring xml:lang="en">LOMv1.0</langstring> ';
	$out_str .='</source>';
	$out_str .='<value>';
	$out_str .='<langstring xml:lang="x-none">'.$relation->kind.'</langstring> ';
	$out_str .='</value>';
	$out_str .='</kind>';
	$out_str .='<resource>';
	$out_str .='<description>';
	$out_str .='<langstring xml:lang="en">'.$relation->relation_description.'</langstring> ';
	$out_str .='</description>';
	$out_str .='<catalogentry>';
	$out_str .='<catalog>'.$relation->catalog.'</catalog> ';
	$out_str .='<entry>';
	$out_str .='<langstring xml:lang="en">'.$relation->entry.'</langstring> ';
	$out_str .='</entry>';
	$out_str .='</catalogentry>';
	$out_str .='</resource>';
	$out_str .='</relation>';
}

}
function hiperbook_write_to_file($path,$content){
	$handle = fopen( $path, "w" ) ;
	if (fwrite($handle, $content) === FALSE) {
	   echo "Cannot write to file $path ($content)";
	   //exit;
	}
	fclose($handle);
}


function hiperbook_recursive_remove_directory($directory, $empty=FALSE)
{
	if(substr($directory,-1) == '/')
	{
		$directory = substr($directory,0,-1);
	}
	if(!file_exists($directory) || !is_dir($directory))
	{
		return FALSE;
	}elseif(is_readable($directory))
	{
		$handle = opendir($directory);
		while (FALSE !== ($item = readdir($handle)))
		{
			if($item != '.' && $item != '..')
			{
				$path = $directory.'/'.$item;
				if(is_dir($path)) 
				{
					hiperbook_recursive_remove_directory($path);
				}else{
					unlink($path);
				}
			}
		}
		closedir($handle);
		if($empty == FALSE)
		{
			if(!rmdir($directory))
			{
				return FALSE;
			}
		}
	}
	return TRUE;
}

// UNLOCK FUNCTIONS 
// se , $lock=1 nao estiver definido, abre para estudantes 
// se definir $lock = 0, fecha para esudantes 

function hiperbook_unlock_hiperbook($bookid, $lock){
global $CFG, $db;
	
	
	if ($lock == 1 ) { $value = 0; }else{$value = 1;}

    
      

	// desbloqueia o navpath e capitulos			
	$res = execute_sql("update ". $CFG->prefix."hiperbook set opentostudents = '$value' where id = '$bookid'");

	
	echo $err;
	if ($res == 0) {
		error('Could not update your hiperbook!!! :(');
	}	

	$navpaths = get_records_select('hiperbook_navigationpath', 'bookid='.$book->id);
	foreach($navpaths as $navpath) {
		hiperbook_unlock_navpath($navpath->id, $lock);			
	}			
	
}

function hiperbook_unlock_navpath ($np_id, $lock){
global $CFG, $db;
	
	if ($lock == 1 ) { $value = 0; }else{$value = 1;}

	// desbloqueia o navpath e capitulos			
	$navpath = get_record('hiperbook_navigationpath', 'id', $np_id);

	$navpath->opentostudents = $value;
	
	if (!update_record('hiperbook_navigationpath', $navpath)) {
		error('Could not update your navpath!!!');
	}	
	$chapterids = get_records_select('hiperbook_navigation_chapters', 'navigationid='.$navpath->id, 'chapterid');
	foreach($chapterids as $chapterid) {
		hiperbook_unlock_chapter($chapterid->chapterid, $lock);			
	}			
	
}
function hiperbook_unlock_chapter($cp_id, $lock){
// destrava as paginas e elementos contextuais

global $CFG, $db;
	
	if ($lock == 1 ) { $value = 0; }else{$value = 1;}
	$chapter = get_record('hiperbook_chapters', 'id', $cp_id);
	$chapter->opentostudents = $value;
	if (!update_record('hiperbook_chapters', $chapter)) {
		error('Could not update your chapter!!!');
	}
	$pageids = get_records_select('hiperbook_chapters_pages', 'chapterid='.$chapter->id, 'chapterid');
	foreach($pageids as $pageid) {
		hiperbook_unlock_page($pageid->id, $lock);			
	}		
			

}

function hiperbook_unlock_page($pageid, $lock){
global $CFG;
	
	if ($lock == 1 ) { $value = 0; }else{$value = 1;}

	$page = get_record('hiperbook_chapters_pages', 'id', $pageid);
	$page->opentostudents = $value;
	$page->content = addslashes($page->content);
	if (!update_record('hiperbook_chapters_pages', $page)) {
		error('Could not update your page!!!');
	}
	
	$tips = get_records_select('hiperbook_pages_tips', 'idpage='.$page->id, 'id');
	foreach($tips as $tip){			
		hiperbook_unlock_tip($tip->idtip, $lock);
	}		
	
	$suggs = get_records_select('hiperbook_pages_suggestions', 'idpage='.$page->id, 'id');	
	foreach($suggs as $sugg){			
		hiperbook_unlock_suggestion($sugg->idsuggestion, $lock);
	}	
	
	$hws = get_records_select('hiperbook_pages_hotwords', 'idpage='.$page->id, 'id');
	foreach($hws as $hw){			
		hiperbook_unlock_hotword($hw->idhotword, $lock);
	}	
}

function hiperbook_unlock_tip($tipid, $lock){
global $CFG;
	if ($lock == 1 ) { $value = 0; }else{$value = 1;}
	$tip = get_record('hiperbook_chapters_tips', 'id', $tipid);
	$tip->opentostudents = $value;
	
	$tip->content = addslashes($tip->content);
	if (!update_record('hiperbook_chapters_tips', $tip)) {
		error('Could not update your tip!!!');
	}		
	
	
				
				
}
function hiperbook_unlock_hotword($hw_id, $lock){
		$hotword = get_record_select('hiperbook_chapters_hotword',"id='$hw_id'");
		if ($lock == 1 ) { $value = 0; }else{$value = 1;}	
		$hotword->opentostudents = $value;
	$hotword->content = addslashes($hotword->content);
		if(!update_record('hiperbook_chapters_hotword',$hotword)){ 
			error('Could not update your hiperbook hotword');
		}	

}
function hiperbook_unlock_suggestion($sg_id, $lock){

	$suggestion = get_record_select('hiperbook_chapters_suggestions',"id='$sg_id'");	
	if ($lock == 1 ) { $value = 0; }else{$value = 1;}
	$suggestion->opentostudents = $value;
	$suggestion->content = addslashes($suggestion->content);
	if(!update_record('hiperbook_chapters_suggestions',$suggestion)){ 
		error('Could not update your hiperbook suggestion');
	}	

}

?>
