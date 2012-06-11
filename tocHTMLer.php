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
//$toc .= '<img src="../assets/images/separador_toc.jpg" /><br>';
//$toc .= '<!--div id="toc_separator">&nbsp; </div-->';
    $toc .= '';
	//var_dump($chapters);
     foreach($chapters as $chp) {
        $i++;
		if ($chp->parentnavchapterid == $navchapterid){
				
			// busca chapternums dos capitulos pai
			//echo 'xxx'.$chp->parentnavchapterid;
			$parentchapternums = hiperbook_get_parent_chapternums($chp);	
			$parentchapternums = "";
			$letras	= array('a','b','c','d','e');	
			// se > 1.1.1
			//echo substr_count($parentchapternums,'.') ;
			if (substr_count($parentchapternums,'.') > 2 ){
				//$parentchapternums =  $letras[$chp->chapternum - 1]; 
			}
				//var_dump($parentchapternums );
			$title = trim(strip_tags($chp->title));
			$toc .= '<span id="item"><li>'.$parentchapternums.' <a title="'.htmlspecialchars($title).'" href="../../scos/cap'.$chp->id.'/1.html">'.$title.'</li></a>';	 
			$toc .=  '&nbsp;&nbsp;<br></span>';
			
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
        }
		
		//$toc .= '<div id="toc_separator">&nbsp; </div>';
		$toc .= '<img src="'.$img_separador_toc.'" /><br>';
    }
$toc .= '</div>';
?>
