<?PHP // $Id: move.php,v 1.9 2005/07/14 20:58:08 skodak Exp $

require_once('../../config.php');
require_once('lib.php');

$up  = optional_param('up', 0, PARAM_BOOL);

$groupid = optional_param('groupid', 0, PARAM_INT);
$bookid = required_param('bookid', PARAM_INT); 
$id = required_param('id', PARAM_INT); //cm id
$navpathnum = required_param('navpathnum', PARAM_INT); //cm id

// busca pagenum atual
// se up, incrementa o chapternum imediatamente superior e decrementa o atual (de mesmo parentbookid)
if($up==1){
 //swap!!!
	$newnavpathnum = $navpathnum - 1;	
	$x= execute_sql("update ". $CFG->prefix."hiperbook_navigationpath set navpathnum = '55555' where navpathnum='$navpathnum' and bookid = '$bookid'");
	$x= execute_sql("update ". $CFG->prefix."hiperbook_navigationpath set navpathnum = (navpathnum + 1) where  navpathnum='$newnavpathnum' and bookid = '$bookid'");
	$x= execute_sql("update ". $CFG->prefix."hiperbook_navigationpath set navpathnum = '$newnavpathnum' where navpathnum='55555' and bookid = '$bookid'");
	
}
//se !up (down), decrementa o chapternum imediatamente superior e incrementa o atual(de mesmo parentbookid)
if($up==0){
 //swap!!!
	$newnavpathnum = $navpathnum +1;	
	$x= execute_sql("update ". $CFG->prefix."hiperbook_navigationpath set navpathnum = '55555' where  navpathnum='$navpathnum' and bookid = '$bookid'");
	$x= execute_sql("update ". $CFG->prefix."hiperbook_navigationpath set navpathnum = (navpathnum - 1) where  navpathnum='$newnavpathnum' and bookid = '$bookid'");
	$x= execute_sql("update ". $CFG->prefix."hiperbook_navigationpath set navpathnum = '$newnavpathnum' where navpathnum='55555' and bookid = '$bookid'");
	
}


 redirect('navpaths.php?bookid='.$bookid.'&edit=1&id='.$id.'&groupid='.$groupid);


?>
