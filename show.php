<?PHP // $Id: show.php,v 1.8 2004/09/28 08:19:59 skodak Exp $

require('teacheraccess.php'); //page only for teachers

///switch hidden state


//$db->debug = true;

$chapter->hidden = $chapter->hidden ? 0 : 1;


///add slashes to all text fields
/*
$chapter->content = addslashes($chapter->content);
$chapter->title = addslashes($chapter->title);
$chapter->importsrc = addslashes($chapter->importsrc);*/


if (!update_record('hiperbook_chapters', $chapter)) {
    error('Could not update your book!');
}

///change visibility of subchapters too
/*if (!$chapter->subchapter) {
    $chapters = get_records('book_chapters', 'bookid', $book->id, 'pagenum', 'id, subchapter, hidden');
    $found = 0;
    foreach($chapters as $ch) {
        if ($ch->id === $chapter->id) {
            $found = 1;
        } else if ($found and $ch->subchapter) {
            $ch->hidden = $chapter->hidden;
            update_record('book_chapters', $ch);
        } else if ($found) {
            break;
        }
    }
}*/

add_to_log($course->id, 'course', 'update mod', '../mod/book/view.php?id='.$cm->id, 'book '.$book->id);
add_to_log($course->id, 'book', 'update', 'view.php?id='.$cm->id, $book->id, $cm->id);
//book_check_structure($book->id);

	$navpath = get_record('hiperbook_navigationpath', 'navpathnum',$navigationnum, 'bookid',$cm->instance);
	$navchapter = get_record('hiperbook_navigation_chapters', 'chapterid',$chapterid, 'navigationid',$navpath->id);
	$parentnavchapter =  get_record('hiperbook_navigation_chapters', 'id',$navchapter->parentnavchapterid, 'navigationid',$navpath->id);

redirect('view.php?id='.$cm->id.'&chapterid='.$parentnavchapter->chapterid.'&navigationnum='.$navigationnum);
die;

?>
