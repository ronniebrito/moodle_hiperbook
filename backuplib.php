<?PHP // $Id: backuplib.php,v 1.3 2004/10/14 20:05:11 skodak Exp $
    //This php script contains all the stuff to backup/restore
    //book mods

    //This is the 'graphical' structure of the book mod:
    //
    //                       book
    //                     (CL,pk->id)
    //                        |
    //                        |
    //                        |
    //                     book_chapters
    //               (CL,pk->id, fk->bookid)
    //popup
    // Meaning: pk->primary key field of the table
    //          fk->foreign key to link with parent
    //          nt->nested field (recursive data)
    //          CL->course level info
    //          UL->user level info
    //          files->table may have files)
    //
    //-----------------------------------------------------------

    //This function executes all the backup procedure about this mod
	

				
	
				
    function hiperbook_backup_mods($bf,$preferences) {
       
	    global $CFG, $db;

        $status = true;
		
		//$CFG->debug = true;
//$db->debug = true;

        ////Iterate over book table
        if ($hyperbooks = get_records ('hiperbook', 'course', $preferences->backup_course, 'id')) {
            foreach ($hyperbooks as $hyperbook) {
               hiperbook_backup_one_mod($bf,$preferences,$hyperbook->id);
            }
        }		
        return $status;
    }
	
	function hiperbook_backup_one_mod($bf,$preferences,$book) {
	
	global $db;
				$book = get_record ('hiperbook', 'id', $book);
	 			//Start mod
                fwrite ($bf,start_tag('MOD',3,true));
                //Print book data
                fwrite ($bf,full_tag('ID',4,false,$book->id));
                fwrite ($bf,full_tag('MODTYPE',4,false,'hiperbook'));
                fwrite ($bf,full_tag('NAME',4,false,$book->name));
                fwrite ($bf,full_tag('NUMBERING',4,false,$book->numbering));
                fwrite ($bf,full_tag('DISABLEPRINTING',4,false,$book->disableprinting));
                fwrite ($bf,full_tag('CUSTOMTITLES',4,false,$book->customtitles));
                fwrite ($bf,full_tag('TIMECREATED',4,false,$book->timecreated));
                fwrite ($bf,full_tag('TIMEMODIFIED',4,false,$book->timemodified));				
				 fwrite ($bf,full_tag('TEMPLATEMAIN',4,false,$book->template_main));
				 fwrite ($bf,full_tag('TEMPLATEHW',4,false,$book->template_hw));
				 fwrite ($bf,full_tag('TEMPLATTIPS',4,false,$book->template_tips));
				 fwrite ($bf,full_tag('TEMPLATESUGGS',4,false,$book->template_suggs));
				 fwrite ($bf,full_tag('TEMPLATECSS',4,false,$book->template_css));
				 fwrite ($bf,full_tag('IMGHOTWORDSTOP',4,false,$book->img_hotwords_top));
				 fwrite ($bf,full_tag('IMGTIPSTOP',4,false,$book->img_tips_top));
				 fwrite ($bf,full_tag('IMGSUGGESTIONSTOP',4,false,$book->img_suggestions_top)); 
				 fwrite ($bf,full_tag('IMGLINKSTOP',4,false,$book->img_links_top));
				 fwrite ($bf,full_tag('IMGHOTWORDSICON',4,false,$book->img_hotwords_icon));
				  fwrite ($bf,full_tag('IMGTIPSICON',4,false,$book->img_tips_icon));
				  fwrite ($bf,full_tag('IMGSUGGESTIONSICON',4,false,$book->img_suggestions_icon)); 
				  fwrite ($bf,full_tag('IMGLINKSICON',4,false,$book->img_links_icon));
				   
				   fwrite ($bf,full_tag('OPENTOSTUDENTS',4,false,$book->opentostudents));
				   
				   fwrite ($bf,full_tag('IMGTOPPOPUP',4,false,$book->img_top_popup));
				   fwrite ($bf,full_tag('IMGPAGENEXT',4,false,$book->img_page_next));
				   fwrite ($bf,full_tag('IMGPAGEPREV',4,false,$book->img_page_prev));
				   fwrite ($bf,full_tag('IMGSEPARADORTOC',4,false,$book->img_separador_toc));
				   fwrite ($bf,full_tag('IMGNAVPATHACTIVESTART',4,false,$book->img_navpath_active_start));
				   fwrite ($bf,full_tag('IMGNAVPATHACTIVEMIDDLE',4,false,$book->img_navpath_active_middle));
				   fwrite ($bf,full_tag('IMGNAVPATHACTIVEEND',4,false,$book->img_navpath_active_end));
				   
				   fwrite ($bf,full_tag('IMGNAVPATHINACTIVESTART',4,false,$book->img_navpath_inactive_start));
				   fwrite ($bf,full_tag('IMGNAVPATHINACTIVEMIDDLE',4,false,$book->img_navpath_inactive_middle));
				   fwrite ($bf,full_tag('IMGNAVPATHINACTIVEEND',4,false,$book->img_navpath_inactive_end));
				   
				//   $db->debug=true;
				//back up the chapters
                $status = backup_hiperbook_chapters($bf,$preferences,$book);				
				
				 $status = backup_hiperbook_chapters_suggestions($bf,$preferences,$book);				
				// dicas
				 $status = backup_hiperbook_chapters_tips($bf,$preferences,$book);
								
				//hotword
				 $status = backup_hiperbook_chapters_hotwords($bf,$preferences,$book);			
				// backup pages_tips
				// backup pages_suggestions 
				// backup pages_hotwords
				$status = backup_hiperbook_navigationpaths($bf,$preferences,$book);
                
				
				//End mod
                $status = fwrite($bf,end_tag('MOD',3,true));
			
				return $status;
				
	}

    //Backup book_chapters contents (executed from book_backup_mods)
    function backup_hiperbook_chapters($bf,$preferences,$hiperbook) {


      global $CFG;
		//$CFG->debug = true;
	//	$db->debug = true;
        $status = true;  
        //Print book's chapters
		
		//echo 'backup de capitulos:'. var_dump($hiperbook);
        if ($chapters = get_records('hiperbook_chapters', 'bookid', $hiperbook->id, 'id')) {
            //Write start tag
            $status = fwrite ($bf,start_tag('CHAPTERS',4,true));
            foreach ($chapters as $ch) {
                //Start chapter
                fwrite ($bf,start_tag('CHAPTER',5,true));
                //Print chapter data
                fwrite ($bf,full_tag('ID',6,false,$ch->id));
                fwrite ($bf,full_tag('TITLE',6,false,$ch->title));
                fwrite ($bf,full_tag('HIDDEN',6,false,$ch->hidden));
                fwrite ($bf,full_tag('TIMECREATED',6,false,$ch->timecreated));
                fwrite ($bf,full_tag('TIMEMODIFIED',6,false,$ch->timemodified));
				
                fwrite ($bf,full_tag('BOOKID',6,false,$ch->bookid));
				
                fwrite ($bf,full_tag('GROUPID',6,false,$ch->groupid));
				
                fwrite ($bf,full_tag('USERID',6,false,$ch->userid));
				
                fwrite ($bf,full_tag('OPENTOSTUDENTS',6,false,$ch->opentostudents));
				
				// busca paginas
				backup_hiperbook_chapters_pages($bf,$preferences,$hiperbook, $ch);
					// links
				backup_hiperbook_chapters_links($bf,$preferences,$hiperbook, $ch);
			
						
                //End chapter
                $status = fwrite ($bf,end_tag('CHAPTER',5,true));
            }
            //Write end tag
            $status = fwrite ($bf,end_tag('CHAPTERS',4,true));
        }
        return $status;
    }
	
	
	 //Backup book_chapters contents (executed from book_backup_mods)
    function backup_hiperbook_chapters_pages($bf,$preferences,$book, $chapter) {

      global $CFG;
	  		
//$db->debug = true;

        $status = true;  
        //Print book's chapters
        if ($chapters_pages = get_records('hiperbook_chapters_pages', 'chapterid', $chapter->id, 'id')) {
		
            //Write start tag
            $status = fwrite ($bf,start_tag('CHAPTERSPAGES',4,true));
            foreach ($chapters_pages as $ch) {
                //Start chapter
                fwrite ($bf,start_tag('CHAPTERPAGE',5,true));
                //Print chapter data
                fwrite ($bf,full_tag('ID',6,false,$ch->id));
				fwrite ($bf,full_tag('CHAPTERID',6,false,$ch->chapterid));
				fwrite ($bf,full_tag('CONTENT',6,false,$ch->content));
                fwrite ($bf,full_tag('PAGENUM',6,false,$ch->pagenum));
                fwrite ($bf,full_tag('HIDDEN',6,false,$ch->hidden));
                fwrite ($bf,full_tag('TIMECREATED',6,false,$ch->timecreated));
                fwrite ($bf,full_tag('TIMEMODIFIED',6,false,$ch->timemodified));
				
                fwrite ($bf,full_tag('IDHIPERBOOK',6,false,$ch->idhiperbook));
				
                fwrite ($bf,full_tag('GROUPID',6,false,$ch->groupid));
				
                fwrite ($bf,full_tag('USERID',6,false,$ch->userid));
				
 				fwrite ($bf,full_tag('OPENTOSTUDENTS',6,false,$ch->opentostudents));
								
				// sugestoes de estudo
				//	backup_hiperbook_chapters_suggestions($bf,$preferences,$hiperbook, $ch);
				backup_hiperbook_pages_suggestions($bf,$preferences,$book, $ch);
				// dicas
				//backup_hiperbook_chapters_tips($bf,$preferences,$hiperbook, $ch);
				backup_hiperbook_pages_tips($bf,$preferences,$book, $ch);
								
				//hotword
			//	backup_hiperbook_chapters_hotwords($bf,$preferences,$hiperbook, $ch);
				backup_hiperbook_pages_hotwords($bf,$preferences,$book, $ch);
				
								
                //End chapter
                $status = fwrite ($bf,end_tag('CHAPTERPAGE',5,true));
            }
            //Write end tag
            $status = fwrite ($bf,end_tag('CHAPTERSPAGES',4,true));
        }
        return $status;
    }
	
	
	 //Backup book_chapters contents (executed from book_backup_mods)
    function backup_hiperbook_chapters_suggestions($bf,$preferences,$book) {

      global $CFG;

        $status = true;  
        //Print book's chapters
        if ($chapters_pages = get_records('hiperbook_chapters_suggestions', 'idhiperbook', $book->id, 'id')) {
		
            //Write start tag
            $status = fwrite ($bf,start_tag('CHAPTERSSUGS',4,true));
            foreach ($chapters_pages as $ch) {
                //Start chapter
                fwrite ($bf,start_tag('CHAPTERSUG',5,true));
                //Print chapter data
				
                fwrite ($bf,full_tag('ID',6,false,$ch->id));
				fwrite ($bf,full_tag('CHAPTERID',6,false,$ch->chapterid));
				fwrite ($bf,full_tag('CONTENT',6,false,$ch->content));
                fwrite ($bf,full_tag('TITLE',6,false,$ch->title));					
                fwrite ($bf,full_tag('SUGGESTIONNUM',6,false,$ch->suggestionnum));
						
                fwrite ($bf,full_tag('IDHIPERBOOK',6,false,$ch->idhiperbook));
						
                fwrite ($bf,full_tag('GROUPID',6,false,$ch->groupid));
						
                fwrite ($bf,full_tag('USERID',6,false,$ch->userid));												
						
                fwrite ($bf,full_tag('OPENTOSTUDENTS',6,false,$ch->opentostudents));
				
                //End chapter
                $status = fwrite ($bf,end_tag('CHAPTERSUG',5,true));
            }
            //Write end tag
            $status = fwrite ($bf,end_tag('CHAPTERSSUGS',4,true));
        }
        return $status;
    }
	
		 //Backup book_chapters contents (executed from book_backup_mods)
    function backup_hiperbook_chapters_tips($bf,$preferences,$book) {

      global $CFG;

        $status = true;  
        //Print book's chapters
        if ($chapters_pages = get_records('hiperbook_chapters_tips', 'idhiperbook', $book->id, 'id')) {
		
            //Write start tag
            $status = fwrite ($bf,start_tag('CHAPTERSTIPS',4,true));
            foreach ($chapters_pages as $ch) {
                //Start chapter
                fwrite ($bf,start_tag('CHAPTERTIP',5,true));
                //Print chapter data				
				
                fwrite ($bf,full_tag('ID',6,false,$ch->id));
				fwrite ($bf,full_tag('CHAPTERID',6,false,$ch->chapterid));
				fwrite ($bf,full_tag('CONTENT',6,false,$ch->content));
                fwrite ($bf,full_tag('TITLE',6,false,$ch->title));						
                fwrite ($bf,full_tag('TIPNUM',6,false,$ch->tipnum));
						
				fwrite ($bf,full_tag('IDHIPERBOOK',6,false,$ch->idhiperbook));
						
                fwrite ($bf,full_tag('GROUPID',6,false,$ch->groupid));
						
                fwrite ($bf,full_tag('USERID',6,false,$ch->userid));													
                fwrite ($bf,full_tag('OPENTOSTUDENTS',6,false,$ch->opentostudents));										
                //End chapter
                $status = fwrite ($bf,end_tag('CHAPTERTIP',5,true));
            }
            //Write end tag
            $status = fwrite ($bf,end_tag('CHAPTERSTIPS',4,true));
        }
        return $status;
    }
	
		 //Backup book_chapters contents (executed from book_backup_mods)
    function backup_hiperbook_chapters_hotwords($bf,$preferences,$book) {

      global $CFG;

        $status = true;  
        //Print book's chapters
        if ($chapters_pages = get_records('hiperbook_chapters_hotword','idhiperbook', $book->id, 'id')) {
		
            //Write start tag
            $status = fwrite ($bf,start_tag('CHAPTERSHOTWORDS',4,true));
            foreach ($chapters_pages as $ch) {
                //Start chapter
                fwrite ($bf,start_tag('CHAPTERHOTWORD',5,true));
                //Print chapter data								
                fwrite ($bf,full_tag('ID',6,false,$ch->id));
				fwrite ($bf,full_tag('CHAPTERID',6,false,$ch->chapterid));
				fwrite ($bf,full_tag('CONTENT',6,false,$ch->content));
                fwrite ($bf,full_tag('TITLE',6,false,$ch->title));						
                fwrite ($bf,full_tag('HOTWORDNUM',6,false,$ch->hotwordnum));
				
				fwrite ($bf,full_tag('IDHIPERBOOK',6,false,$ch->idhiperbook));
						
                fwrite ($bf,full_tag('GROUPID',6,false,$ch->groupid));
						
                fwrite ($bf,full_tag('USERID',6,false,$ch->userid));												
						
                fwrite ($bf,full_tag('OPENTOSTUDENTS',6,false,$ch->opentostudents));
															
                //End chapter
                $status = fwrite ($bf,end_tag('CHAPTERHOTWORD',5,true));
            }
            //Write end tag
            $status = fwrite ($bf,end_tag('CHAPTERSHOTWORDS',4,true));
        }
        return $status;
    }
	

function backup_hiperbook_pages_suggestions($bf,$preferences,$book, $page) {

      global $CFG;

        $status = true;  
        //Print book's chapters
        if ($chapters_pages = get_records('hiperbook_pages_suggestions', 'idpage', $page->id, 'id')) {
		
            //Write start tag
            $status = fwrite ($bf,start_tag('PAGESSUGGS',4,true));
            foreach ($chapters_pages as $ch) {
                //Start chapter
                fwrite ($bf,start_tag('PAGESUGG',5,true));
                //Print chapter data								
                fwrite ($bf,full_tag('ID',6,false,$ch->id));
				fwrite ($bf,full_tag('IDPAGE',6,false,$ch->idpage));
				fwrite ($bf,full_tag('IDSUGGESTION',6,false,$ch->idsuggestion));															
                //End chapter
                $status = fwrite ($bf,end_tag('PAGESUGG',5,true));
            }
            //Write end tag
            $status = fwrite ($bf,end_tag('PAGESSUGGS',4,true));
        }
        return $status;
    }
	
function backup_hiperbook_pages_tips($bf,$preferences,$book, $page) {

      global $CFG;

        $status = true;  
        //Print book's chapters
        if ($chapters_pages = get_records('hiperbook_pages_tips', 'idpage', $page->id, 'id')) {
		
            //Write start tag
            $status = fwrite ($bf,start_tag('PAGESTIPS',4,true));
            foreach ($chapters_pages as $ch) {
                //Start chapter
                fwrite ($bf,start_tag('PAGETIP',5,true));
                //Print chapter data								
                fwrite ($bf,full_tag('ID',6,false,$ch->id));
				fwrite ($bf,full_tag('IDPAGE',6,false,$ch->idpage));
				fwrite ($bf,full_tag('IDTIP',6,false,$ch->idtip));															
                //End chapter
                $status = fwrite ($bf,end_tag('PAGETIP',5,true));
            }
            //Write end tag
            $status = fwrite ($bf,end_tag('PAGESTIPS',4,true));
        }
        return $status;
    }	
	
	
function backup_hiperbook_pages_hotwords($bf,$preferences,$book, $page) {

      global $CFG;

        $status = true;  
        //Print book's chapters
        if ($chapters_pages = get_records('hiperbook_pages_hotwords', 'idpage', $page->id, 'id')) {
		
            //Write start tag
            $status = fwrite ($bf,start_tag('PAGESHOTWORDS',4,true));
            foreach ($chapters_pages as $ch) {
                //Start chapter
                fwrite ($bf,start_tag('PAGEHOTWORD',5,true));
                //Print chapter data								
                fwrite ($bf,full_tag('ID',6,false,$ch->id));
				fwrite ($bf,full_tag('IDPAGE',6,false,$ch->idpage));
				fwrite ($bf,full_tag('IDHOTWORD',6,false,$ch->idhotword));															
                //End chapter
                $status = fwrite ($bf,end_tag('PAGEHOTWORD',5,true));
            }
            //Write end tag
            $status = fwrite ($bf,end_tag('PAGESHOTWORDS',4,true));
        }
        return $status;
		
}
	
		 //Backup book_chapters contents (executed from book_backup_mods)
    function backup_hiperbook_chapters_links($bf,$preferences,$book, $chapter) {

      global $CFG;

        $status = true;  
        //Print book's chapters
        if ($chapters_pages = get_records('hiperbook_chapters_links', 'chapterid', $chapter->id, 'id')) {
		
            //Write start tag
            $status = fwrite ($bf,start_tag('CHAPTERSLINKS',4,true));
            foreach ($chapters_pages as $ch) {
                //Start chapter
                fwrite ($bf,start_tag('CHAPTERLINK',5,true));
                //Print chapter data				
                fwrite ($bf,full_tag('ID',6,false,$ch->id));
				fwrite ($bf,full_tag('CHAPTERID',6,false,$ch->chapterid));
				fwrite ($bf,full_tag('TARGETCHAPTERID',6,false,$ch->targetchapterid));
                fwrite ($bf,full_tag('TITLE',6,false,$ch->title));	
				
				
                fwrite ($bf,full_tag('POPUP',6,false,$ch->popup));		
				
                fwrite ($bf,full_tag('SHOWNAVIGATION',6,false,$ch->show_navigation));	
				
                fwrite ($bf,full_tag('IDPAGE',6,false,$ch->idpage));	
				
                fwrite ($bf,full_tag('IDTARGETPAGEID',6,false,$ch->idtargetpageid));	  
				 fwrite ($bf,full_tag('TARGETNAVIGATIONCHAPTER',6,false,$ch->target_navigation_chapter));	
																
                //End chapter
                $status = fwrite ($bf,end_tag('CHAPTERLINK',5,true));
            }
            //Write end tag
            $status = fwrite ($bf,end_tag('CHAPTERSLINKS',4,true));
        }
        return $status;
    }
	

    //Return a content encoded to support interactivities linking. Every module
    //should have its own. They are called automatically from the backup procedure.
    function hiperbook_encode_content_links ($content,$preferences) {

        global $CFG;

        $base = preg_quote($CFG->wwwroot,"/");

        $result = $content;

        //Link to the list of books
        $buscar="/(".$base."\/mod\/hiperbook\/index.php\?id\=)([0-9]+)/";
        $result= preg_replace($buscar,'$@BOOKINDEX*$2@$',$result);

        //Link to book's specific chapter
        $buscar="/(".$base."\/mod\/hiperbook\/view.php\?id\=)([0-9]+)\&chapterid\=([0-9]+)/";
        $result= preg_replace($buscar,'$@BOOKCHAPTER*$2*$3@$',$result);

        //Link to book's first chapter
        $buscar="/(".$base."\/mod\/hiperbook\/view.php\?id\=)([0-9]+)/";
		
        $result= preg_replace($buscar,'$@BOOKSTART*$2@$',$result);

        return $result;
    }


	function backup_hiperbook_navigationpaths($bf,$preferences,$hiperbook){
	
	   global $CFG;

        $status = true;  
        
        if ($navpaths = get_records('hiperbook_navigationpath', 'bookid', $hiperbook->id, 'id')) {
            //Write start tag
            $status = fwrite ($bf,start_tag('NAVPATHS',4,true));
            foreach ($navpaths as $ch) {
                //Start chapter
                fwrite ($bf,start_tag('NAVPATH',5,true));
                //Print chapter data	
                fwrite ($bf,full_tag('ID',6,false,$ch->id));
                fwrite ($bf,full_tag('BOOKID',6,false,$ch->bookid));
                fwrite ($bf,full_tag('NAME',6,false,$ch->name));
                fwrite ($bf,full_tag('NAVPATHNUM',6,false,$ch->navpathnum));
                fwrite ($bf,full_tag('SUMMARY',6,false,$ch->summary));
				
 	           fwrite ($bf,full_tag('GROUPID',6,false,$ch->groupid));
						
                fwrite ($bf,full_tag('USERID',6,false,$ch->userid));												
						
                fwrite ($bf,full_tag('OPENTOSTUDENTS',6,false,$ch->opentostudents));
				backup_hiperbook_nav_chapters($bf,$preferences,$hiperbook, $ch);
			                //End chapter
                $status = fwrite ($bf,end_tag('NAVPATH',5,true));
            }
			
			
				
			
            //Write end tag
            $status = fwrite ($bf,end_tag('NAVPATHS',4,true));
        }
        return $status;
	
	}
	
	
function backup_hiperbook_nav_chapters($bf,$preferences,$hiperbook,$navpath){
	
	
	// recupera os registro de modo recursivo pois a tabela tem auto relacionamento em 
	// parentnavchapterid = id
	
	   global $CFG, $db;

//$db->debug = true;
        $status = true;  
        
	//	$db->debug = true;
		
		$navpaths = get_records('hiperbook_navigation_chapters', 'navigationid', $navpath->id);
		
		 
        if ($navpaths) {
		
	//	var_dump($navpaths);
            //Write start tag
            $status = fwrite ($bf,start_tag('NAVPATHSCHAPS',4,true));
            foreach ($navpaths as $ch) {
			
		

                //Start chapter
                fwrite ($bf,start_tag('NAVPATHCHAP',5,true));
                //Print chapter data	
                fwrite ($bf,full_tag('ID',6,false,$ch->id));
                fwrite ($bf,full_tag('PARENTNAVCHAPTERID',6,false,$ch->parentnavchapterid));
                fwrite ($bf,full_tag('CHAPTERNUM',6,false,$ch->chapternum));
                fwrite ($bf,full_tag('CHAPTERID',6,false,$ch->chapterid));
                fwrite ($bf,full_tag('NAVIGATIONID',6,false,$ch->navigationid));
	            //End chapter
                $status = fwrite ($bf,end_tag('NAVPATHCHAP',5,true));
            }
			 //Write end tag
            $status = fwrite ($bf,end_tag('NAVPATHSCHAPS',4,true));
        }
        return $status;
	
	}

    ////Return an array of info (name,value)
    function hiperbook_check_backup_mods($course,$user_data=false,$backup_unique_code) {
        
		 //First the course data
         $info[0][0] = get_string('modulenameplural','hiperbook');
         $info[0][1] = count_records('hiperbook', 'course', $course);

         //No user data for books ;-)

         return $info;
    }

// backup dos arquivos referenciados pelo hlivro 

    function hiperbook_backup_files($bf,$preferences) {
        global $CFG;

        $status = true;

        //First we check to moddata exists and create it as necessary
        //in temp/backup/$backup_code  dir
        $status = check_and_create_moddata_dir($preferences->backup_unique_code);
        //Now copy the forum dir
        if ($status) {
            //Only if it exists !! Thanks to Daniel Miksik.
            if (is_dir($CFG->dataroot."/".$preferences->backup_course."/".$CFG->moddata."/forum")) {
                $handle = opendir($CFG->dataroot."/".$preferences->backup_course."/".$CFG->moddata."/forum");
                while (false!==($item = readdir($handle))) {
                    if ($item != '.' && $item != '..' && is_dir($CFG->dataroot."/".$preferences->backup_course."/".$CFG->moddata."/forum/".$item)
                        && array_key_exists($item,$preferences->mods['forum']->instances)
                        && !empty($preferences->mods['forum']->instances[$item]->backup)) {
                        $status = backup_copy_file($CFG->dataroot."/".$preferences->backup_course."/".$CFG->moddata."/forum/".$item,
                                                   $CFG->dataroot."/temp/backup/".$preferences->backup_unique_code."/moddata/forum/",$item);
                    }
                }
            }
        }

        return $status;

    }
	
	function hiperbook_backup_files_instance($bf,$preferences,$instanceid) {
        global $CFG;

        $status = true;

        //First we check to moddata exists and create it as necessary
        //in temp/backup/$backup_code  dir
        $status = check_and_create_moddata_dir($preferences->backup_unique_code);
        $status = check_dir_exists($CFG->dataroot."/temp/backup/".$preferences->backup_unique_code."/moddata/forum/",true);
        //Now copy the forum dir
        if ($status) {
            //Only if it exists !! Thanks to Daniel Miksik.
            if (is_dir($CFG->dataroot."/".$preferences->backup_course."/".$CFG->moddata."/hiperbook/".$instanceid)) {
                $status = backup_copy_file($CFG->dataroot."/".$preferences->backup_course."/".$CFG->moddata."/forum/".$instanceid,
                                           $CFG->dataroot."/temp/backup/".$preferences->backup_unique_code."/moddata/hiperbook/".$instanceid);
            }
        }

        return $status;

    }
?>
