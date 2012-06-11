<?

//copia o hiperlivro
$newbookid = $new_modis;

//copia navigationpaths com novo bookid
$navpaths = get_records_select('hiperbook_navigationpath',"bookid = $newbookid", 'navpathnum');
foreach($navaptahs as $navpath){
	$navpath->bookid = $newbookid;
	insert_record('hiperbook_navigationpath', $navpath);
}

//copia cada capitulo
$oldchapters = get_records_select('hiperbook_chapters',"bookid = $newbookid", 'chapternum');
foreach($chapters as $oldchapter){
	$newchapter = $oldchapter;
	$oldchapterid = $oldchapter->bookid;
	$newchapter->bookid = $newbookid;	
	$newchapterid = insert_record('hiperbook_chapters', $newchapter);
	
	//para cada capitulo copiado, duplica seus navigation_chapters 
	//copiando os registros de navigation_chapters com chapterid=oldchapterid
	//definindo chapterid=newchapterid
	//e navigationid = ao navigationid do novo registro da copia de navigationpath com navigationum = oldnavigationum	no novo livro  
	$oldnavigation_chapters= get_records_select('hiperbook_navigation_chapters',"chapterid= $oldchapterid");
	foreach($oldnavigation_chapters as $oldnavigation_chapter){
		$newnavigation_chapter = $oldnavigation_chapter;
		$newnavigation_chapter->chapterid = $newchapterid;	
				
		$newnavigation  = get_record_select('hiperbook_navigationpath',"bookid= $newbookid","navigation_num = $oldnavigation_chapter->navigation_num");
		$newnavigation_chapter->navigationid = $newnavigation->id;		
		
		insert_record('hiperbook_navigation_chapters', $navigation_chapter);
	}

	//copia paginas do antigo chapter definindo novo chapterid
	$oldchapters_pages= get_records_select('hiperbook_chapters_pages',"chapterid= $oldchapterid");
	foreach($oldchapters_pages as $oldchapters_page){
		$newchapter_page= $oldchapter_page;
		$newchapter_page->chapterid = $newchapterid;	
		insert_record('hiperbook_chapters_pages', $newchapter_page);
	}
	
	//copia dicas com novo chapterid
	$oldchapters_tips= get_records_select('hiperbook_chapters_tis',"chapterid= $oldchapterid");
	foreach($oldchapters_tips as $oldchapters_tip){
		$newchapter_tip= $oldchapter_tip;
		$newchapter_tip->chapterid = $newchapterid;	
		insert_record('hiperbook_chapters_tips', $newchapter_tip);
	}
	//copia sugestoes de estudo com novo chapterid
	$oldchapters_suggestions= get_records_select('hiperbook_chapters_suggestions',"chapterid= $oldchapterid");
	foreach($oldchapters_suggestions as $oldchapters_suggestion){
		$newchapter_suggestion = $oldchapter_suggestion;
		$newchapter_suggestion->chapterid = $newchapterid;	
		insert_record('hiperbook_chapters_suggestions', $newchapter_suggestion);
	}
	
	
	//copia hotwords com novo chapterid.
	$oldchapters_hotwords = get_records_select('hiperbook_chapters_hotword',"chapterid= $oldchapterid");
	foreach($oldchapters_hotwords as $oldchapters_hotword){
		$newchapter_hotword = $oldchapter_hotword;
		$newchapter_hotword->chapterid = $newchapterid;	
		insert_record('hiperbook_chapters_hotwords', $newchapter_hotword);
	}


}

	
