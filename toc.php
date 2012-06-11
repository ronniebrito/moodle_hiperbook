<?PHP // $Id: toc.php,v 1.11 2005/01/01 23:12:04 skodak Exp $

defined('MOODLE_INTERNAL') or die('Direct access to this script is forbidden.');
 
/// included from mod/book/view.php and print.php
///
/// uses:
///   $chapters - all book chapters
///   $chapter - may be false
///   $cm - course module
///   $book - book
///   $edit - force editing view


/// fills:
///   $toc
///   $title (not for print)

$currtitle = '';    //active chapter title (plain text)
$currsubtitle = ''; //active subchapter if any
$prevtitle = '&nbsp;';
$toc = '';          //representation of toc (HTML)

$nch = 0; //chapter number
$ns = 0;  //subchapter number
$title = '';
$first = 1;


if (!isset($print)) {
    $print = 0;
}
 
$toc .= '<div id="toc">';
$toc .= '<img src="'.$img_separador_toc.'" /><br>';


$navpath = get_record('hiperbook_navigationpath', 'bookid', $cm->instance, 'navpathnum', $navigationnum );

//die();


//var_dump($navchapter); 
if (!$navchapter){
	$parentnavchapterid = 0;
}else{
	$parentnavchapterid = $navchapter->id;
}

if (($edit)||($navpath->opentostudents)) { ///teacher's TOC
    $i = 0;	
	
	


	//exibicao dos capitulos
    foreach($chapters as $ch) {
	//echo 'capitulo';
	//var_dump($ch);
        $i++;
	//	if ($ch->parentnavchapterid == $navchapterid){
			$title = trim(strip_tags($ch->title));		  
			
			// busca chapternums dos capitulos pai
			$parentchapternums = hiperbook_get_parent_chapternums($ch, '', 1);			
			
		//	echo 'PARENT'.$parentchapternums;
			
			$letras	= array('a','b','c','d','e');	
			// se > 1.1.1
			//echo substr_count($parentchapternums,'.') ;
			if (substr_count($parentchapternums,'.') > 2 ){
				$parentchapternums =  $letras[$ch->chapternum - 1]; 
			}
			
			if (true){
				$parentchapternums = "&nbsp;&nbsp;<li>";
			}
			
			if($ch->groupid == $groupid ||$ch->groupid == 0 ) {
				$toc .= '<span id="item">'.$parentchapternums .' <a title="'.htmlspecialchars($title).'" href="view.php?id='.$cm->id.'&groupid='.$groupid.'&target_navigation_chapter='. $ch->target_navigation_chapter.'">'.$title.'</a>';	 
				$toc .=  '&nbsp;&nbsp;</span>';
			}else{
				$toc .= '<span id="item">'.$parentchapternums .' <a title="'.print_string('contentfromothergroup','hiperbook').'" href="javascript:void(0);">'.$title.'</a>';	 
				$toc .=  '&nbsp;&nbsp;</span>';
			}
			
			if($ch->groupid == $groupid) {
			
				if ($i != 1) {
					$toc .=  ' <a title="'.get_string('up').'" href="move.php?id='.$cm->id.'&chapternum='.$ch->chapternum.'&chapterid='.$ch->id.'&up=1&sesskey='.$USER->sesskey.'&navigationnum='.$navigationnum.'"><img src="'.$CFG->pixpath.'/t/up.gif" height="11" width="11" border="0" /></a>';
				}
				if ($i != count($chapters)) {
					$toc .=  ' <a title="'.get_string('down').'" href="move.php?id='.$cm->id.'&chapternum='.$ch->chapternum.'&chapterid='.$ch->id.'&up=0&sesskey='.$USER->sesskey.'&navigationnum='.$navigationnum.'"><img src="'.$CFG->pixpath.'/t/down.gif" height="11" width="11" border="0" /></a>';
				}
				
			
				$toc .=  ' <a title="'.get_string('edit').'" href="edit.php?id='.$cm->id.'&chapterid='.$ch->id.'&parentnavchapterid='.$parentnavchapterid.'&idnavigation='.$idnavigation.'&navigationnum='.$navigationnum.'"><img src="'.$CFG->pixpath.'/t/edit.gif" height="11" width="11" border="0" /></a>';
				$toc .=  ' <a title="'.get_string('delete').'" href="delete.php?id='.$cm->id.'&chapterid='.$ch->id.'&parentnavchapterid='.$parentnavchapterid.'&sesskey='.$USER->sesskey.'&navigationnum='.$navigationnum.'"><img src="'.$CFG->pixpath.'/t/delete.gif" height="11" width="11" border="0" /></a>';
				
				
				if ($ch->hidden==1) {
					$toc .= ' <a title="'.get_string('show').'" href="show.php?id='.$cm->id.'&chapterid='.$ch->id.'&sesskey='.$USER->sesskey.'&navigationnum='.$navigationnum.'"><img src="'.$CFG->pixpath.'/t/show.gif" height="11" width="11" border="0" /></a>';
				
				} else {
					$toc .= ' <a title="'.get_string('hide').'" href="show.php?id='.$cm->id.'&chapterid='.$ch->id.'&sesskey='.$USER->sesskey.'&navigationnum='.$navigationnum.'"><img src="'.$CFG->pixpath.'/t/hide.gif" height="11" width="11" border="0" /></a>';
				}
			}
			if($isteacher) {
				//var_dump($ch);
				if ($ch->opentostudents==1) {
					$toc .= ' <a title="'.get_string('lock','hiperbook').'" href="lock.php?id='.$cm->id.'&chapterid='.$ch->id.'&sesskey='.$USER->sesskey.'&mode=chapter&lock=1"><img src="'.$CFG->pixpath.'/i/lock.gif" height="11" width="11" border="0" /></a>';
				} else {
					$toc .= ' <a title="'.get_string('unlock','hiperbook').'" href="lock.php?id='.$cm->id.'&chapterid='.$ch->id.'&sesskey='.$USER->sesskey.'&mode=chapter&lock=0"><img src="'.$CFG->pixpath.'/i/unlock.gif" height="11" width="11" border="0" /></a>';
				}
				
			}
			$toc .="<br></span>";
			//$toc .= ' <a title="'.get_string('addafter', 'book').'" href="edit.php?id='.$cm->id.'&chapternum='.$ch->chapternum.'&parentchapterid='.$ch->chapterid.'"><img src="pix/add.gif" height="11" width="11" border="0" /></a>';
	
	//	}
			$toc .= '<img src="'.$img_separador_toc.'" /><br>';
    }
		// para adicionar capitulos
	//var_dump($chapters);
	
	if (
			($edit) || 
			(
				($navpath->opentostudents)&&
		 		(($groupmode==0) || (($groupmode>0)&($navpath->groupid == $groupid))) 
		 	)
		 ){
			$toc .= ' <a title="'.get_string('addafter', 'hiperbook').'" href="edit.php?id='.$cm->id.'&parentnavchapterid='. $parentnavchapterid.'&bookid='.$book->id.'&navigationnum='.$navigationnum.'&groupid='.$groupid.'&target_navigation_chapter='. $target_navigation_chapter.'"><img src="pix/add.gif" height="11" width="11" border="0" /></a>';		
	}

   
} else { //normal students view
    $toc .= '';
	//var_dump($chapters);
     foreach($chapters as $chp) {
        $i++;
	//	if ($chp->parentnavchapterid == $navchapterid){
				
			// busca chapternums dos capitulos pai
			//echo 'xxx'.$chp->parentnavchapterid;
			//$parentchapternums = hiperbook_get_parent_chapternums($chp);	
			
			$letras	= array('a','b','c','d','e');	
			// se > 1.1.1
			//echo substr_count($parentchapternums,'.') ;
			if (substr_count($parentchapternums,'.') > 2 ){
			//	$parentchapternums =  $letras[$chp->chapternum - 1]; 
			}
			
				//var_dump($parentchapternums );
			$title = trim(strip_tags($chp->title));
			
			if($chp->groupid == $groupid ||$chp->groupid == 0 ) {
				$toc .= '<span id="item">'.$parentchapternums .'<li> <a title="'.htmlspecialchars($title).'" href="view.php?id='.$cm->id.'&groupid='.$groupid.'&target_navigation_chapter='. $chp->target_navigation_chapter.'">'.$title.'</a></li>';	 
				$toc .=  '&nbsp;&nbsp;</span>';
			}else{
				$toc .= '<span id="item">'.$parentchapternums .'<li> <a title="'.htmlspecialchars($title).'" href="javascript:void(0);">'.$title.'</a></li>';	
				$toc .=  '&nbsp;&nbsp;</span>';
			}
						
		    /*if (!$ch->subchapter) {
                $nch++;
                $ns = 0;
                $toc .= ($first) ? '<li>' : '</ul></li><li>';
                if ($book->numbering === NUM_NUMBERS) {
                      $title = "$nch $title";
                }
            $prevtitle = $title;
            } else {
                $ns++;
                $toc .= ($first) ? '<li><ul><li>' : '<li>';
                if ($book->numbering === NUM_NUMBERS) {
                      $title = "$nch.$ns $title";
                }
            }
            if ($ch->id === $chapter->id) {
                $toc .= '<strong>'.$title.'</strong>';
                if ($ch->subchapter) {
                    $currtitle = $prevtitle;
                    $currsubtitle = $title;
                } else {
                    $currtitle = $title;
                    $currsubtitle = '&nbsp;';
                }
            } else {
                $toc .= '<a title="'.htmlspecialchars($title).'" href="view.php?id='.$cm->id.'&chapterid='.$ch->id.'">'.$title.'</a>';
            }
            $toc .= (!$ch->subchapter) ? '<ul>' : '</li>';
            $first = 0;*/
     //   }
		$toc .= '<img src="'.$img_separador_toc.'" /><br>';
    }
	$toc .= '';
    $toc .= '';
}

$toc .= '</div>';
?>
