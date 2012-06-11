<?PHP //$Id: restorelib.php,v 1.24 2007/01/04 23:38:26 skodak Exp $
//This php script contains all the stuff to restore 

require_once ("$CFG->dirroot/mod/hiperbook/lib.php");

function hiperbook_restore_mods($mod, $restore) {

      global $CFG, $db;


//$db->debug =true;
        $status = true;


        //Get record from backup_ids
       $data = backup_getid($restore->backup_unique_code,$mod->modtype,$mod->id);

        if ($data) {
            //Now get completed xmlized object
            $info = $data->info;
            //Now, build the hiperbook record structure
//			var_dump($info);			
            $hiperbook->course = $restore->course_id;
            $hiperbook->name = backup_todb($info['MOD']['#']['NAME']['0']['#']);
            $hiperbook->numbering = backup_todb($info['MOD']['#']['NUMBERING']['0']['#']);
            $hiperbook->disableprinting = backup_todb($info['MOD']['#']['DISABLEPRINTING']['0']['#']);
            $hiperbook->customtitles = backup_todb($info['MOD']['#']['CUSTOMTITLES']['0']['#']);
            $hiperbook->timecreated = backup_todb($info['MOD']['#']['TIMECREATED']['0']['#']);
            $hiperbook->timemodified = backup_todb($info['MOD']['#']['TIMEMODIFIED']['0']['#']);
			 $hiperbook->template_main = backup_todb($info['MOD']['#']['TEMPLATEMAIN']['0']['#']);
			 $hiperbook->template_hw = backup_todb($info['MOD']['#']['TEMPLATEHW']['0']['#']);
			 $hiperbook->template_tips = backup_todb($info['MOD']['#']['TEMPLATTIPS']['0']['#']);
			 $hiperbook->template_suggs = backup_todb($info['MOD']['#']['TEMPLATESUGGS']['0']['#']);
			 $hiperbook->template_css = backup_todb($info['MOD']['#']['TEMPLATECSS']['0']['#']);
			 $hiperbook->img_hotwords_top = backup_todb($info['MOD']['#']['IMGHOTWORDSTOP']['0']['#']);
			 $hiperbook->img_tips_top = backup_todb($info['MOD']['#']['IMGTIPSTOP']['0']['#']);
			 $hiperbook->img_suggestions_top = backup_todb($info['MOD']['#']['IMGSUGGESTIONSTOP']['0']['#']);
			 $hiperbook->img_links_top = backup_todb($info['MOD']['#']['IMGLINKSTOP']['0']['#']);
			 $hiperbook->img_hotwords_icon = backup_todb($info['MOD']['#']['IMGHOTWORDSICON']['0']['#']);
			 $hiperbook->img_tips_icon = backup_todb($info['MOD']['#']['IMGTIPSICON']['0']['#']);
			 $hiperbook->img_suggestions_icon = backup_todb($info['MOD']['#']['IMGSUGGESTIONSICON']['0']['#']);
			 $hiperbook->img_links_icon= backup_todb($info['MOD']['#']['IMGLINKSICON']['0']['#']);
			 $hiperbook->opentostudents = backup_todb($info['MOD']['#']['OPENTOSTUDENTS']['0']['#']);
			 $hiperbook->img_top_popup = backup_todb($info['MOD']['#']['IMGTOPPOPUP']['0']['#']);
			 $hiperbook->img_page_next = backup_todb($info['MOD']['#']['IMGPAGENEXT']['0']['#']);
			 
			 $hiperbook->img_page_prev = backup_todb($info['MOD']['#']['IMGPAGEPREV']['0']['#']);
			 $hiperbook->img_separador_toc = backup_todb($info['MOD']['#']['IMGSEPARADORTOC']['0']['#']);
			 
			 $hiperbook->img_navpath_active_start= backup_todb($info['MOD']['#']['IMGNAVPATHACTIVESTART']['0']['#']);
			  $hiperbook->img_navpath_active_middle= backup_todb($info['MOD']['#']['IMGNAVPATHACTIVEMIDDLE']['0']['#']);
			   $hiperbook->img_navpath_active_end= backup_todb($info['MOD']['#']['IMGNAVPATHACTIVEEND']['0']['#']);



			 $hiperbook->img_navpath_inactive_start= backup_todb($info['MOD']['#']['IMGNAVPATHINACTIVESTART']['0']['#']);
			  $hiperbook->img_navpath_inactive_middle= backup_todb($info['MOD']['#']['IMGNAVPATHINACTIVEMIDDLE']['0']['#']);
			   $hiperbook->img_navpath_inactive_end= backup_todb($info['MOD']['#']['IMGNAVPATHINACTIVEEND']['0']['#']);
			   
            //The structure is equal to the db, so insert the hiperbook
            $new_hiperbook_id = insert_record('hiperbook',$hiperbook);

            //Do some output
            echo '<ul><li>'.get_string('modulename','hiperbook').' "'.$hiperbook->name.'"<br>';

            backup_flush(300);

            if ($new_hiperbook_id) {
                //We have the newid, update backup_ids
                backup_putid($restore->backup_unique_code,$mod->modtype,
                             $mod->id, $new_hiperbook_id);							 
				
      
				$old_new_chotwords = restore_hiperbook_chapters_hotwords($new_hiperbook_id,$info,$restore);			
				
				echo 'old_new';
				//var_dump($old_new_chotwords);
				
				$old_new_ctips = restore_hiperbook_chapters_tips($new_hiperbook_id,$info,$restore);			
				
				$old_new_csuggs = restore_hiperbook_chapters_suggestions($new_hiperbook_id,$info,$restore);			
							 
							 
                //now restore chapters
				
				// qdo executar restore do relacionamento entre sug/hot/tips e a pagina, precisara atualizar idpage com nova pagina e idsug/hot/tip com o novo id correspondente armazenado nos 3 arrays criados acima (old_new)
				
				
				$old_new_pages = array(); 
                $old_new_chapters = hiperbook_chapters_restore($new_hiperbook_id, $old_new_chotwords, $old_new_ctips ,$old_new_csuggs ,$info,$restore, &$old_new_pages);	
						
				$old_new_navpaths =  hiperbook_navpaths_restore($new_hiperbook_id,$info,$restore);					
				
				hiperbook_update_links($old_new_chapters, $old_new_pages,$new_hiperbook_id); 
				hiperbook_update_parentnavpathids($old_new_navpaths, $old_new_chapters, $new_hiperbook_id);		
				
				// update pages tips. hwords and suggestions
				// atualiza relacionamentos id_page id_hotword para os novos ids
				//hiperbook_update_pages_hotwords($old_new_pages,$old_new_chotwords);
			//	hiperbook_update_pages_tips($old_new_pages,$old_new_ctips);
			//	hiperbook_update_pages_suggestions($old_new_pages,$old_new_csuggs);
				
				// atualiza a pasta dos templates
				
				rename($CFG->dataroot.'/'.$hiperbook->course.'/template_hiperbook'.$mod->id, $CFG->dataroot.'/'. $hiperbook->course.'/template_hiperbook'.$new_hiperbook_id);				
		
            } else {
                $status = false;
            }
            //Finalize ul
            echo "</ul>";
        } else {
            $status = false;
        }
        return $status;
}


    //This function restores the hiperbook_chapters
function hiperbook_chapters_restore( $new_hiperbook_id, $old_new_chotwords, $old_new_ctips ,$old_new_csuggs ,$info,$restore, &$old_new_pages) {
	
	
	

        global $CFG;
		//error_reporting(E_ALL);
        $status = true;
		
		$old_new_chapters_map = array();    

        //Get the chapters array
        $chapters = $info['MOD']['#']['CHAPTERS']['0']['#']['CHAPTER'];
        //Iterate over chapters
        for($i = 0; $i < sizeof($chapters); $i++) {
            $sub_info = $chapters[$i];    
			
            //We'll need this later!!
            $old_chapterid = $sub_info['#']['ID']['0']['#'];

            $chapter->bookid = $new_hiperbook_id;			
				
            $chapter->title = backup_todb($sub_info['#']['TITLE']['0']['#']);
            $chapter->hidden = backup_todb($sub_info['#']['HIDDEN']['0']['#']);
            $chapter->timecreated = backup_todb($sub_info['#']['TIMECREATED']['0']['#']);
            $chapter->timemodified = backup_todb($sub_info['#']['TIMEMODIFIED']['0']['#']);
			$chapter->bookid = $new_hiperbook_id;
			$chapter->groupid = backup_todb($sub_info['#']['GROUPID']['0']['#']);
			$chapter->userid= backup_todb($sub_info['#']['USERID']['0']['#']);
			$chapter->opentostudents = backup_todb($sub_info['#']['OPENTOSTUDENTS']['0']['#']);
			
				
			
			$infopages = $sub_info['#']['CHAPTERSPAGES'];
		
            //The structure is equal to the db, so insert the hiperbook_chapters           
		    $new_chapterid = insert_record ('hiperbook_chapters',$chapter);

			
//			echo 'new_chapterid='.$new_chapterid;
			
			if ($infopages){
			// busca paginas
				//echo 'paginas='; var_dump($infopages);
				$old_new_pages_aux = restore_hiperbook_chapters_pages( $new_hiperbook_id,$old_chapterid, $new_chapterid, $old_new_chotwords, $old_new_ctips ,$old_new_csuggs , $infopages['0']['#']['CHAPTERPAGE'],$restore);				
				foreach($old_new_pages_aux as $old_new_pmap){
					array_push($old_new_pages, $old_new_pmap);     
				}
				
			}
			
			$infolinks = $sub_info['#']['CHAPTERSLINKS'];
          if ($infolinks){
				restore_hiperbook_chapters_links($new_hiperbook_id,$old_chapterid, $new_chapterid,$infolinks['0']['#']['CHAPTERLINK'],$restore);
			}

            if ($new_chapterid) {
                //We have the newid, update backup_ids
                backup_putid($restore->backup_unique_code,'hiperbook_chapters',$old_chapterid,$new_chapterid);				
				$newmap = array($old_chapterid, $new_chapterid);
				array_push($old_new_chapters_map, $newmap);     
				
            } else {
                $status = false;
            }
			
			
			
        }
        return $old_new_chapters_map;
    }





// busca paginas
				
//This function restores the hiperbook_chapters
function restore_hiperbook_chapters_pages( $new_hiperbook_id,$old_chapterid, $new_chapterid, $old_new_chotwords, $old_new_ctips ,$old_new_csuggs , $infopages,$restore){
 
    global $CFG, $db;
	
	//$db->debug = true;
	$status = true;
	$old_new_pages_map = array();    

        //Get the chapters_pages array
        $chapterspages = $infopages;

        for($i = 0; $i < sizeof($chapterspages); $i++) {
            $sub_info = $chapterspages[$i];
			
	//		echo 'pagina'.$i;
			
            //We'll need this later!!
            $old_pageid = $sub_info['#']['ID']['0']['#'];
			
			//Now, build the ASSIGNMENT_CHAPTERS record structure

            $page->chapterid = $new_chapterid;		
										
            $page->content = backup_todb($sub_info['#']['CONTENT']['0']['#']);
            $page->pagenum = backup_todb($sub_info['#']['PAGENUM']['0']['#']);
            $page->hidden = backup_todb($sub_info['#']['HIDDEN']['0']['#']);
            $page->timecreated = backup_todb($sub_info['#']['TIMECREATED']['0']['#']);
            $page->timemodified = backup_todb($sub_info['#']['TIMEMODIFIED']['0']['#']); 
			$page->idhiperbook =  $new_hiperbook_id; 
			$page->groupid = backup_todb($sub_info['#']['GROUPID']['0']['#']); 
			$page->userid = backup_todb($sub_info['#']['USERID']['0']['#']); 
			$page->opentostudents = backup_todb($sub_info['#']['OPENTOSTUDENTS']['0']['#']);
			
			
       
	  
	   
		    $new_pageid = insert_record('hiperbook_chapters_pages',$page);
 
 
 			$infotips=  $sub_info['#']['PAGESTIPS']['0']["#"]["PAGETIP"];
			$infohots =  $sub_info['#']['PAGESHOTWORDS']['0']["#"]["PAGEHOTWORD"];
			$infosugs =  $sub_info['#']['PAGESSUGGS']['0']["#"]["PAGESUGG"];
		
			echo 'infohots'; var_dump($infohots);
 			if ($infosugs){
				// sugestoes de estudo
				restore_hiperbook_pages_suggestions( $new_hiperbook_id,$old_chapterid, $new_chapterid, $old_pageid, $new_pageid, $old_new_csuggs ,$infosugs,$restore);
			}
			
			if($infotips){
				// dicas
				restore_hiperbook_pages_tips( $new_hiperbook_id,$old_chapterid, $new_chapterid, $old_pageid, $new_pageid, $old_new_ctips ,$infotips,$restore);
			}
			
			if($infohots){	
				//hotword
				restore_hiperbook_pages_hotwords( $new_hiperbook_id,$old_chapterid, $new_chapterid, $old_pageid, $new_pageid, $old_new_chotwords, $infohots,$restore);
			}		
			
			
		   if ($new_pageid) {
                //We have the newid, update backup_ids            			
				$newmap = array($old_pageid, $new_pageid);
				array_push($old_new_pages_map, $newmap);     
				
            } else {
                $status = false;
            }
			
			
			
        }
        return $old_new_pages_map;

}
				
function restore_hiperbook_pages_suggestions( $new_hiperbook_id,$old_chapterid, $new_chapterid,$old_pageid, $new_pageid, $old_new_csuggs ,  $infosugs,$restore){

	    global $CFG, $db;
        $status = true;
        //Get the chapters_pages array
 		//$suggestions = $info['MOD']['#']['CHAPTERS']['0']['#']['CHAPTER']['0']['#']['CHAPTERSSUGS'];
		$suggestions = $infosugs;
		//id page e id suggestion referentes aos IDS antigos (precisa ser atualizado 		
        //Iterate over chapters
        for($i = 0; $i < sizeof($suggestions); $i++) {
            $sub_info = $suggestions[$i]; 
			
		//var_dump($sub_info); die();
            //We'll need this later!!
            $old_sugsid = $sub_info['#']['ID']['0']['#'];						
			// idpage 
			// idsuggestion									
            $suggestion->idpage = $new_pageid;//backup_todb($sub_info['#']['IDPAGE']['0']['#']);
			$suggestion->idsuggestion = backup_todb($sub_info['#']['IDSUGGESTION']['0']['#']);
		   // search for old_new map maches of id and update      		   
		   foreach ($old_new_csuggs as $cs){
		   	$cs[0] ;// old
			$cs[1];// new		   
			if($suggestion->idsuggestion == $cs[0]){  $suggestion->idsuggestion = $cs[1];}
			break;
		   }
		    $newid = insert_record('hiperbook_pages_suggestions',$suggestion);
			
        }
        return $status;

}

function restore_hiperbook_pages_tips( $new_hiperbook_id,$old_chapterid, $new_chapterid,$old_pageid, $new_pageid, $old_new_csuggs ,  $infosugs,$restore){

	    global $CFG, $db;
        $status = true;
        //Get the chapters_pages array
 		//$suggestions = $info['MOD']['#']['CHAPTERS']['0']['#']['CHAPTER']['0']['#']['CHAPTERSSUGS'];
		$suggestions = $infosugs;
		//id page e id suggestion referentes aos IDS antigos (precisa ser atualizado 		
        //Iterate over chapters
        for($i = 0; $i < sizeof($suggestions); $i++) {
            $sub_info = $suggestions[$i]; 
            //We'll need this later!!
            $old_sugsid = backup_todb($sub_info['#']['ID']['0']['#']);						
			// idpage 
			// idsuggestion									
            $suggestion->idpage = $new_pageid;// backup_todb($sub_info['#']['IDPAGE']['0']['#']);
			$suggestion->idtip = backup_todb($sub_info['#']['IDTIP']['0']['#']);
		   // search for old_new map maches of id and update      		   
		   foreach ($old_new_csuggs as $cs){
		   	$cs[0] ;// old
			$cs[1];// new		   
			if($suggestion->idtip == $cs[0]){  $suggestion->idsuggestion = $cs[1];}
			break;
		   }
		    $newid = insert_record('hiperbook_pages_tips',$suggestion);
			
        }
        return $status;

}

function restore_hiperbook_pages_hotwords( $new_hiperbook_id,$old_chapterid, $new_chapterid,$old_pageid, $new_pageid, $old_new_csuggs ,  $infosugs,$restore){

	    global $CFG, $db;
        $status = true;
        //Get the chapters_pages array
 		$suggestions = $infosugs;
		echo 'infosugs';
		var_dump($infosugs);
		//id page e id suggestion referentes aos IDS antigos (precisa ser atualizado 		
        //Iterate over chapters
        for($i = 0; $i < sizeof($suggestions); $i++) {
            $sub_info = $suggestions[$i]; 
            //We'll need this later!!
            $old_sugsid = backup_todb($sub_info['#']['ID']['0']['#']);						
			// idpage 
			// idsuggestion									
            $suggestion->idpage = $new_pageid;
			// backup_todb($sub_info['#']['IDPAGE']['0']['#']);
			$suggestion->idhotword = backup_todb($sub_info['#']['IDHOTWORD']['0']['#']);
		   // search for old_new map maches of id and update      		   
		   foreach ($old_new_csuggs as $cs){
		   	$cs[0] ;// old
			$cs[1];// new		   
			if($suggestion->idhotword == $cs[0]){  $suggestion->idhotword = $cs[1];}
			break;
		   }
		    $newid = insert_record('hiperbook_pages_hotwords',$suggestion);
			
        }
        return $status;

}

//This function restores the hiperbook_chapters
function restore_hiperbook_chapters_suggestions( $new_hiperbook_id, $info,$restore){

	    global $CFG, $db;
		
        $status = true;
		$old_new_map = array(); 		
        //Get the chapters_pages array
 		//$suggestions = $info['MOD']['#']['CHAPTERS']['0']['#']['CHAPTER']['0']['#']['CHAPTERSSUGS'];
		$suggestions = $infosugs;
		
		
					 
	$suggestions = $info['MOD']['#']['CHAPTERSSUGGS']['0']['#']['CHAPTERSUG'];
	
        //Iterate over chapters
        for($i = 0; $i < sizeof($suggestions); $i++) {
            $sub_info = $suggestions[$i]; 
            //We'll need this later!!
            $old_sugsid = backup_todb($sub_info['#']['ID']['0']['#']);		
				
			//Now, build the ASSIGNMENT_CHAPTERS record structure
            $suggestion->chapertid = $new_chapterid;							
           
            $suggestion->content = backup_todb($sub_info['#']['CONTENT']['0']['#']);
			$suggestion->title = backup_todb($sub_info['#']['TITLE']['0']['#']);
            $suggestion->suggestionnum = backup_todb($sub_info['#']['SUGGESTIONNUM']['0']['#']);            
          
			$suggestion->idhiperbook = $new_hiperbook_id;  
			$suggestion->groupid = backup_todb($sub_info['#']['GROUPID']['0']['#']); 
			$suggestion->userid = backup_todb($sub_info['#']['USERID']['0']['#']); 
			$suggestion->opentostudents = backup_todb($sub_info['#']['OPENTOSTUDENTS']['0']['#']);
			
           $newid = insert_record('hiperbook_chapters_suggestions',$suggestion);
			
		

            if ($newid) {
               	 $newmap = array($old_sugsid, $newid);			
				array_push($old_new_map, $newmap);  
            } else {
                $status = false;
            }					
			
        }
        return $old_new_map;

}

function restore_hiperbook_chapters_tips( $new_hiperbook_id, $info,$restore){

   global $CFG, $db;
        $status = true;
		
		$old_new_map = array(); 		
     
 		//$suggestions = $info['MOD']['#']['CHAPTERS']['0']['#']['CHAPTER']['0']['#']['CHAPTERSSUGS'];
	
					 
	$suggestions =  $info['MOD']['#']['CHAPTERSTIPS']['0']['#']['CHAPTERTIP'];
        //Iterate over chapters
        for($i = 0; $i < sizeof($suggestions); $i++) {
            $sub_info = $suggestions[$i]; 
            //We'll need this later!!
            $old_id = $sub_info['#']['ID']['0']['#'];
			 			
			//Now, build the ASSIGNMENT_CHAPTERS record structure
			
        //    $suggestion->chapertid = $new_chapterid;	
			
				
            $suggestion->title = backup_todb($sub_info['#']['TITLE']['0']['#']);
            $suggestion->content = backup_todb($sub_info['#']['CONTENT']['0']['#']);
            $suggestion->tipnum = backup_todb($sub_info['#']['TIPNUM']['0']['#']);
         	$suggestion->idhiperbook =  $new_hiperbook_id;  
			$suggestion->groupid = backup_todb($sub_info['#']['GROUPID']['0']['#']); 
			$suggestion->userid = backup_todb($sub_info['#']['USERID']['0']['#']); 
			$suggestion->opentostudents = backup_todb($sub_info['#']['OPENTOSTUDENTS']['0']['#']);
            //The structure is equal to the db, so insert the hiperbook_chapters           
		    $newid = insert_record('hiperbook_chapters_tips',$suggestion);
	
	
          
            if ($newid) {
               	 $newmap = array($old_id, $newid);			
				array_push($old_new_map, $newmap);  
            } else {
                $status = false;
            }					
			
        }
        return $old_new_map;		
	

}

function restore_hiperbook_chapters_hotwords( $new_hiperbook_id, $info,$restore){

 global $CFG, $db;
 
 
					$old_new_map = array(); 						
					
        $status = true;
	$suggestions = $info['MOD']['#']['CHAPTERSHOTWORDS']['0']['#']['CHAPTERHOTWORD'];
        //Iterate over chapters
        for($i = 0; $i < sizeof($suggestions); $i++) {
            $sub_info = $suggestions[$i]; 
            //We'll need this later!!
            $old_id = $sub_info['#']['ID']['0']['#'];			
			//Now, build the ASSIGNMENT_CHAPTERS record structure
			
//            $suggestion->chapertid = $new_chapterid;	
			
				
            $suggestion->title = backup_todb($sub_info['#']['TITLE']['0']['#']);
            $suggestion->content = backup_todb($sub_info['#']['CONTENT']['0']['#']);
            $suggestion->tipnum = backup_todb($sub_info['#']['HOTWORDNUM']['0']['#']);
          	$suggestion->idhiperbook = $new_hiperbook_id; 
			$suggestion->groupid = backup_todb($sub_info['#']['GROUPID']['0']['#']); 
			$suggestion->userid = backup_todb($sub_info['#']['USERID']['0']['#']); 
			$suggestion->opentostudents = backup_todb($sub_info['#']['OPENTOSTUDENTS']['0']['#']);
			
            
		    $newid = insert_record('hiperbook_chapters_hotword',$suggestion);
					 
            if ($newid) {
               	 $newmap = array($old_id, $newid);			
				array_push($old_new_map, $newmap);  
            } else {
                $status = false;
            }					
			
        }
        return $old_new_map;
}

function restore_hiperbook_chapters_links( $new_hiperbook_id,$old_chapterid, $new_chapterid, $infosugs,$restore){

	    global $CFG, $db;
		
	//	$db->debug= true;
        $status = true;
        //Get the chapters_pages array
 		//$suggestions = $info['MOD']['#']['CHAPTERS']['0']['#']['CHAPTER']['0']['#']['CHAPTERSSUGS'];
		$suggestions = $infosugs;
        //Iterate over chapters
		
		//echo 'links=';
		//var_dump($suggestions);
        for($i = 0; $i < sizeof($suggestions); $i++) {
            $sub_info = $suggestions[$i]; 
            //We'll need this later!!
            $old_id = $sub_info['#']['ID']['0']['#'];			
			//Now, build the ASSIGNMENT_CHAPTERS record structure
            $link->chapertid = $new_chapterid;
            $link->title = backup_todb($sub_info['#']['TITLE']['0']['#']);
            //$link->chapterid = backup_todb($sub_info['#']['CHAPTERID']['0']['#']);
			$link->chapterid = $new_chapterid;
            $link->targetchapterid = backup_todb($sub_info['#']['TARGETCHAPTERID']['0']['#']);
			$link->popup = backup_todb($sub_info['#']['POPUP']['0']['#']);
			$link->show_navigation = backup_todb($sub_info['#']['SHOWNAVIGATION']['0']['#']);
			$link->idpage = backup_todb($sub_info['#']['IDPAGE']['0']['#']);
			$link->idtargetpageid = backup_todb($sub_info['#']['IDTARGETPAGEID']['0']['#']);	
			$link->target_navigation_chapter = backup_todb($sub_info['#']['TARGETNAVIGATIONCHAPTER']['0']['#']);
			//The structure is equal to the db, so insert the hiperbook_chapter         
		    $newid = insert_record ('hiperbook_chapters_links',$link);
			
	 
            if ($newid) {
              
            } else {
                $status = false;
            }					
			
        }
        return $status;

}


    //This function returns a log record with all the necessay transformations
    //done. It's used by restore_log_module() to restore modules log.
    function hiperbook_restore_logs($restore,$log) {

        $status = false;

        return $status;
    }

    //Return a content decoded to support interactivities linking. Every module
    //should have its own. They are called automatically from
    //hiperbook_decode_content_links_caller() function in each module
    //in the restore process
    function hiperbook_decode_content_links ($content,$restore) {

        global $CFG;

        $result = $content;

        //Link to the list of hiperbooks

   /*     $searchstring='/\$@(hiperbookINDEX)\*([0-9]+)@\$/';
        //We look for it
        preg_match_all($searchstring,$content,$foundset);
        //If found, then we are going to look for its new id (in backup tables)
        if ($foundset[0]) {
            //print_object($foundset);                                     //Debug
            //Iterate over foundset[2]. They are the old_ids
            foreach($foundset[2] as $old_id) {
                //We get the needed variables here (course id)
                $rec = backup_getid($restore->backup_unique_code,"course",$old_id);
                //Personalize the searchstring
                $searchstring='/\$@(hiperbookINDEX)\*('.$old_id.')@\$/';
                //If it is a link to this course, update the link to its new location
                if($rec->new_id) {
                    //Now replace it
                    $result= preg_replace($searchstring,$CFG->wwwroot.'/mod/hiperbook/index.php?id='.$rec->new_id,$result);
                } else {
                    //It's a foreign link so leave it as original
                    $result= preg_replace($searchstring,$restore->original_wwwroot.'/mod/hiperbook/index.php?id='.$old_id,$result);
                }
            }
        }


        //Links to specific chapters of hiperbooks

        $searchstring='/\$@(hiperbookCHAPTER)\*([0-9]+)\*([0-9]+)@\$/';
        //We look for it
        preg_match_all($searchstring,$result,$foundset);
        //If found, then we are going to look for its new id (in backup tables)
        if ($foundset[0]) {
            //print_object($foundset);                                     //Debug
            //Iterate over foundset[2] and foundset[3]. They are the old_ids
            foreach($foundset[2] as $key => $old_id) {
                $old_id2 = $foundset[3][$key];
                //We get the needed variables here (discussion id and post id)
                $rec = backup_getid($restore->backup_unique_code,'course_modules',$old_id);
                $rec2 = backup_getid($restore->backup_unique_code,'hiperbook_chapters',$old_id2);
                //Personalize the searchstring
                $searchstring='/\$@(hiperbookCHAPTER)\*('.$old_id.')\*('.$old_id2.')@\$/';
                //If it is a link to this course, update the link to its new location
                if($rec->new_id && $rec2->new_id) {
                    //Now replace it
                    $result= preg_replace($searchstring,$CFG->wwwroot.'/mod/hiperbook/view.php?id='.$rec->new_id.'&chapterid='.$rec2->new_id,$result);
                } else {
                    //It's a foreign link so leave it as original
                    $result= preg_replace($searchstring,$restore->original_wwwroot.'/mod/hiperbook/view.php?id='.$old_id.'&chapterid='.$old_id2,$result);
                }
            }
        }


        //Links to first chapters of hiperbooks

        $searchstring='/\$@(hiperbookSTART)\*([0-9]+)@\$/';
        //We look for it
        preg_match_all($searchstring,$result,$foundset);
        //If found, then we are going to look for its new id (in backup tables)
        if ($foundset[0]) {
            //print_object($foundset);                                     //Debug
            //Iterate over foundset[2]. They are the old_ids
            foreach($foundset[2] as $old_id) {
                //We get the needed variables here (course_modules id)
                $rec = backup_getid($restore->backup_unique_code,"course_modules",$old_id);
                //Personalize the searchstring
                $searchstring='/\$@(hiperbookSTART)\*('.$old_id.')@\$/';
                //If it is a link to this course, update the link to its new location
                if($rec->new_id) {
                    //Now replace it
                    $result= preg_replace($searchstring,$CFG->wwwroot.'/mod/hiperbook/view.php?id='.$rec->new_id,$result);
                } else {
                    //It's a foreign link so leave it as original
                    $result= preg_replace($searchstring,$restore->original_wwwroot.'/mod/hiperbook/view.php?id='.$old_id,$result);
                }
            }
        }
*/
        return $result;
    }

    //This function makes all the necessary calls to xxxx_decode_content_links()
    //function in each module, passing them the desired contents to be decoded
    //from backup format to destination site/course in order to mantain inter-activities
    //working in the backup/restore process. It's called from restore_decode_content_links()
    //function in restore process
    function hiperbook_decode_content_links_caller($restore) {
        global $CFG;
        $status = true;

   /*     //Decode every hiperbook (summary) in the coure
        if ($hiperbooks = get_records_sql ("SELECT b.id, b.summary
                                   FROM {$CFG->prefix}hiperbook b
                                   WHERE b.course = $restore->course_id")) {
            //Iterate over each hiperbook->summary
            $i = 0;   //Counter to send some output to the browser to avoid timeouts
            foreach ($hiperbooks as $hiperbook) {
                //Increment counter
                $i++;
                $content = $hiperbook->summary;
                $result = restore_decode_content_links_worker($content,$restore);
                if ($result != $content) {
                    //Update record
                    $hiperbook->summary = addslashes($result);
                    $status = update_record('hiperbook',$hiperbook);
                    if ($CFG->debug>7) {
                        echo '<br /><hr />'.htmlentities($content).'<br />changed to<br />'.htmlentities($result).'<hr /><br />';
                    }
                }
                //Do some output
                if (($i+1) % 5 == 0) {
                    echo '.';
                    if (($i+1) % 100 == 0) {
                        echo '<br />';
                    }
                    backup_flush(300);
                }
            }
        }

        //Decode every CHAPTER in the course
        if ($chapters = get_records_sql ("SELECT ch.id, ch.content
                                   FROM {$CFG->prefix}hiperbook b,
                                        {$CFG->prefix}hiperbook_chapters ch
                                   WHERE b.course = $restore->course_id AND
                                         ch.hiperbookid = b.id")) {
            //Iterate over each chapter->content
            $i = 0;   //Counter to send some output to the browser to avoid timeouts
            foreach ($chapters as $chapter) {
                //Increment counter
                $i++;
                $content = $chapter->content;
                $result = restore_decode_content_links_worker($content,$restore);
                if ($result != $content) {
                    //Update record
                    $chapter->content = addslashes($result);
                    $status = update_record('hiperbook_chapters',$chapter);
                    if ($CFG->debug>7) {
                        echo '<br /><hr />'.htmlentities($content).'<br />changed to<br />'.htmlentities($result).'<hr /><br />';
                    }
                }
                //Do some output
                if (($i+1) % 5 == 0) {
                    echo '.';
                    if (($i+1) % 100 == 0) {
                        echo '<br />';
                    }
                    backup_flush(300);
                }
            }
        }*/

        return $status;
    }


 function hiperbook_navpaths_restore( $new_hiperbook_id,$info,$restore) {
		
		echo 'RESTAURANDO NAVPATHS';
		global $CFG, $db;
	//error_reporting(E_ALL);
			$status = true;

        //Get the chapters array
        $navpaths = $info['MOD']['#']['NAVPATHS']['0']['#']['NAVPATH'];
        //Iterate over chapters

		$old_new_navpaths_map = array(); 
	
//	echo  sizeof($navpaths). ' caminhos';
        for($i = 0; $i < sizeof($navpaths); $i++) {
            
			$sub_info = $navpaths[$i];
			
			$navpath->bookid = $new_hiperbook_id;			
			//var_dump($sub_info);
						
			$navpath->name = $sub_info['#']['NAME']['0']['#'];
			$navpath->navpathnum = $sub_info['#']['NAVPATHNUM']['0']['#'];
			$navpath->summary = $sub_info['#']['SUMMARY']['0']['#'];		
			$navpath->groupid = $sub_info['#']['GROUPID']['0']['#'];		
			$navpath->userid = $sub_info['#']['USERID']['0']['#'];		
			$navpath->opentostudents = $sub_info['#']['OPENTOSTUDENTS']['0']['#'];		
			
			
			
			$info_navpathchaps = $sub_info['#']['NAVPATHSCHAPS']['0']['#']['NAVPATHCHAP'];
			 
			
			$new_navpathid = insert_record ('hiperbook_navigationpath',$navpath);		
					
				//	echo 'navchaps=';
			//		var_dump($info_navpathchaps);
					
				for($j = 0; $j < sizeof($info_navpathchaps); $j++) {
					$navpathchap = $info_navpathchaps[$j];    
					//We'll need this later!!
					$old_navchapterid = backup_todb($navpathchap['#']['ID']['0']['#']);										
					$navchapter->bookid = $new_hiperbook_id;									
					$navchapter->parentnavchapterid = backup_todb($navpathchap['#']['PARENTNAVCHAPTERID']['0']['#']);
					$navchapter->chapternum = backup_todb($navpathchap['#']['CHAPTERNUM']['0']['#']);
					$navchapter->chapterid = backup_todb($navpathchap['#']['CHAPTERID']['0']['#']);
					$navchapter->navigationid= $new_navpathid;         
					$new_navchapterid = insert_record ('hiperbook_navigation_chapters',$navchapter);		
											
					$newmap = array($old_navchapterid, $new_navchapterid);
			
					array_push($old_new_navpaths_map, $newmap);  
					
				}    	
		 			 			 
            //Do some output
            if (($i+1) % 50 == 0) {
                echo '.';
                if (($i+1) % 1000 == 0) {
                    echo '<br>';
                }
                backup_flush(300);
            }			
        }
        return $old_new_navpaths_map;
		
}

 function hiperbook_update_parentnavpathids($old_new_navpaths, $old_new_chapters, $newbook_id){
 
 	global $CFG, $db;
	
	//$db->debug = true;
 
	foreach($old_new_navpaths as $old_new){	 	
		// atualiza o parent navigation id
 	 	$db->Execute('update '. $CFG->prefix . 'hiperbook_navigation_chapters nc, '. $CFG->prefix . 'hiperbook_navigationpath np  set nc.parentnavchapterid=' . $old_new[1] .' WHERE nc.parentnavchapterid='.  $old_new[0] .' and nc.navigationid=np.id and np.bookid='. $newbook_id);	
	
		// atualiza os navigation chpaters do navigation path recem atualizado 
		 foreach($old_new_chapters as $old_new_chap){	 	
				$db->Execute('update '. $CFG->prefix . 'hiperbook_navigation_chapters nc, '. $CFG->prefix . 'hiperbook_navigationpath np set nc.chapterid=' . $old_new_chap[1] .' WHERE nc.chapterid='.  $old_new_chap[0] .' and nc.navigationid=np.id and np.bookid='. $newbook_id);	 
				
		 }
	 }	
 
	
 
 }
 

function hiperbook_update_links($old_new_chapters, $old_new_pages,$new_hiperbook_id){

echo "atualizando hiperbook_update_links<br>";

//var_dump($old_new_chapters);
//var_dump($old_new_pages);
 
 global $CFG, $db;
 
// $db->debug = true;
 	// Copia e ATUALIZA OS LINKS nos registros
			foreach($old_new_chapters as $map){
				//update os targets dos links referente aos novos chapterids no novo livro
				// chapterid ja atualizado qdo copioou o capitu
				
				$linksupdate = "update ".$CFG->prefix."hiperbook_chapters_links l, ".$CFG->prefix."hiperbook_chapters c  set l.chapterid='". $map[1]."' where l.chapterid='".$map[0]."' and l.chapterid = c.id and c.bookid='". $new_hiperbook_id."'";  
				
							//	echo '<br>updating'. $linksupdate;	
				execute_sql($linksupdate,1);					
				
				$linksupdate = "update ".$CFG->prefix."hiperbook_chapters_links l, ".$CFG->prefix."hiperbook_chapters c  set l.targetchapterid='". $map[1]."' where l.targetchapterid='".$map[0]."' and l.chapterid = c.id and c.bookid='". $new_hiperbook_id."'";  
						//		echo '<br>updating'. $linksupdate;								
				execute_sql($linksupdate,1);
			
			} 
			
			foreach($old_new_pages as $map){
				//update os targets dos links referente aos novos chapterids no novo livro
				// chapterid ja atualizado qdo copioou o capitu
			//	$db->debug = true;
				$linksupdate = "update ".$CFG->prefix."hiperbook_chapters_links l, ".$CFG->prefix."hiperbook_chapters c  set l.idpage='". $map[1]."' where l.idpage='".$map[0]."' and l.chapterid = c.id and c.bookid='". $new_hiperbook_id."'";  
				
			//	echo '<br>updating'. $linksupdate ;
				execute_sql($linksupdate,1);
				
				$linksupdate = "update ".$CFG->prefix."hiperbook_chapters_links l, ".$CFG->prefix."hiperbook_chapters c  set l.idtargetpageid='". $map[1]."' where l.idtargetpageid='".$map[0]."' and l.chapterid = c.id and c.bookid='". $new_hiperbook_id."'";  
				
			//	echo '<br>updating'. $linksupdate ;
				execute_sql($linksupdate,1);
			} 
 
 }
 /*
function  hiperbook_update_pages_tips($old_new_pages,$old_new_ctips){

global $CFG, $db;
 	// atualiza old tip ids para new ids em chpaters_tips (id page ja foi atualizado qdo inseriu o registro)
	
			foreach($old_new_pages as $map){
			
				foreach($old_new_ctips as $map2){
				//update os targets dos links referente aos novos chapterids no novo livro
				// chapterid ja atualizado qdo copioou o capitu           
				$db->debug =true;                         
			
				$linksupdate = "update ".$CFG->prefix."hiperbook_pages_tips  set idtip='". $map2[1]."' where idtip='".$map2[0]."' and idpage = ".$map[1];  
				                                  
				echo '<p>'.$linksupdate;
				execute_sql($linksupdate,0);
				// dont look trhough pages, tips etc because ther should be no hard links coded in html
				// duplication occurs just into same course usualy
			} 
		}
}

 function  hiperbook_update_pages_hotwords($old_new_pages,$old_new_ctips){

global $CFG, $db;
 	// atualiza old tip ids para new ids em chpaters_tips (id page ja foi atualizado qdo inseriu o registro)
	
			foreach($old_new_pages as $map){
			
				foreach($old_new_ctips as $map2){
				//update os targets dos links referente aos novos chapterids no novo livro
				// chapterid ja atualizado qdo copioou o capitu           
				$db->debug =true;                         
			
				$linksupdate = "update ".$CFG->prefix."hiperbook_pages_hotwords  set idhotword='". $map2[1]."' where idhotword='".$map2[0]."' and idpage = ".$map[1];  
				                                  
				echo '<p>'.$linksupdate;
				execute_sql($linksupdate,0);
				// dont look trhough pages, tips etc because ther should be no hard links coded in html
				// duplication occurs just into same course usualy
				} 
			}
}

function  hiperbook_update_pages_suggestions($old_new_pages,$old_new_ctips){

global $CFG, $db;
 	// atualiza old tip ids para new ids em chpaters_tips (id page ja foi atualizado qdo inseriu o registro)
	
			foreach($old_new_pages as $map){
			
				foreach($old_new_ctips as $map2){
				//update os targets dos links referente aos novos chapterids no novo livro
				// chapterid ja atualizado qdo copioou o capitu           
				$db->debug =true;                         
			
				$linksupdate = "update ".$CFG->prefix."hiperbook_pages_suggestions  set idsuggestion='". $map2[1]."' where idsuggestion='".$map2[0]."' and idpage = ".$map[1];  
				                                  
				echo '<p>'.$linksupdate;
				execute_sql($linksupdate,0);
				// dont look trhough pages, tips etc because ther should be no hard links coded in html
				// duplication occurs just into same course usualy
			} 
		}

}*/
?>
