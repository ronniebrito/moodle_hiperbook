<?PHP // $Id: mysql.php,v 1.4 2004/08/06 21:21:26 skodak Exp $



//function hiperbook_upgrade($oldversion=0) {

function xmldb_hiperbook_upgrade($oldversion=0) {
/// This function does anything necessary to upgrade
/// older versions to match current functionality


     global $CFG, $THEME, $db;

ini_set('memory_limit', '300M');

// alter tables

execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook ADD  `template_main` TEXT NULL' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook ADD  `template_hw` TEXT NULL' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook ADD  `template_tips` TEXT NULL' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook ADD  `template_suggs` TEXT NULL' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook ADD  `template_css` TEXT NULL' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook ADD  `img_hotwords_top`  VARCHAR( 255 ) NULL' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook ADD  `img_tips_top`  VARCHAR( 255 ) NULL' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook ADD  `img_suggestions_top`  VARCHAR( 255 ) NULL' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook ADD  `img_links_top`  VARCHAR( 255 ) NULL' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook ADD  `img_hotwords_icon`  VARCHAR( 255 ) NULL' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook ADD  `img_tips_icon`  VARCHAR( 255 ) NULL' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook ADD  `img_suggestions_icon`  VARCHAR( 255 ) NULL' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook ADD  `img_links_icon`  VARCHAR( 255 ) NULL' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook ADD  `opentostudents`  INT( 2 ) NULL' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook ADD  `img_top_popup`  VARCHAR( 255 ) NULL' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook ADD  `img_page_next`  VARCHAR( 255 ) NULL' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook ADD  `img_page_prev`  VARCHAR( 255 ) NULL' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook ADD  `img_separador_toc`  VARCHAR( 255 ) NULL' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook ADD  `img_navpath_active_start`  VARCHAR( 255 ) NULL' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook ADD  `img_navpath_active_middle`  VARCHAR( 255 ) NULL' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook ADD  `img_navpath_active_end`  VARCHAR( 255 ) NULL' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook ADD  `img_navpath_inactive_start`  VARCHAR( 255 ) NULL' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook ADD  `img_navpath_inactive_middle`  VARCHAR( 255 ) NULL' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook ADD  `img_navpath_inactive_end`  VARCHAR( 255 ) NULL' );

execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook_chapters ADD  `groupid`  INT( 11 )  DEFAULT 0' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook_chapters ADD  `userid`  INT( 11 ) NULL' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook_chapters ADD  `opentostudents`  INT( 1 ) DEFAULT 0' );


execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook_chapters_hotword ADD  `idhiperbook`  INT( 11 ) NULL' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook_chapters_hotword ADD  `groupid`  INT( 11 )  DEFAULT 0' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook_chapters_hotword ADD  `userid`  INT( 11 ) NULL' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook_chapters_hotword ADD  `opentostudents`  INT( 1 )  DEFAULT 0' );

execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook_chapters_links ADD  `idpage`  INT( 11 ) DEFAULT 0' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook_chapters_links ADD  `idtargetpageid`  INT( 11 ) DEFAULT 0' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook_chapters_links ADD  `target_navigation_chapter`  INT( 11 ) DEFAULT 0' );

execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook_chapters_pages ADD  `idhiperbook`  INT( 11 ) DEFAULT 0' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook_chapters_pages ADD  `groupid`  INT( 11 )  DEFAULT 0' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook_chapters_pages ADD  `userid`  INT( 11 ) DEFAULT 0' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook_chapters_pages ADD  `opentostudents`  INT( 1 )  DEFAULT 0' );

execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook_chapters_suggestions ADD  `idhiperbook`  INT( 11 ) NULL' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook_chapters_suggestions ADD  `groupid`  INT( 11 ) DEFAULT 0' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook_chapters_suggestions ADD  `userid`  INT( 11 ) DEFAULT 0' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook_chapters_suggestions ADD  `opentostudents`  INT( 1 )  DEFAULT 0' );

execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook_chapters_tips ADD  `idhiperbook`  INT( 11 ) NULL' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook_chapters_tips ADD  `groupid`  INT( 11 ) DEFAULT 0' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook_chapters_tips ADD  `userid`  INT( 11 ) DEFAULT 0' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook_chapters_tips ADD  `opentostudents`  INT( 1 ) DEFAULT 0' );

execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook_navigationpath ADD  `groupid`  INT( 11 ) DEFAULT 0' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook_navigationpath ADD  `userid`  INT( 11 ) DEFAULT 0' );
execute_sql('ALTER TABLE  '. $CFG->prefix .'hiperbook_navigationpath ADD  `opentostudents`  INT( 1 ) DEFAULT 0' );

execute_sql('CREATE TABLE IF NOT EXISTS `'. $CFG->prefix .'hiperbook_pages_hotwords` (
  `id` int(11) NOT NULL auto_increment,
  `idpage` int(11) NOT NULL,
  `idhotword` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ' );

execute_sql('CREATE TABLE IF NOT EXISTS `'. $CFG->prefix .'hiperbook_pages_suggestions` (
  `id` int(11) NOT NULL auto_increment,
  `idpage` int(11) NOT NULL,
  `idsuggestion` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1' );

execute_sql('CREATE TABLE IF NOT EXISTS `'. $CFG->prefix .'hiperbook_pages_tips` (
  `id` int(11) NOT NULL auto_increment,
  `idpage` int(11) NOT NULL,
  `idtip` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1' );
// cria tabelas




	 
	//if ($oldversion < 2008101625) {

if (true) {
	
	$hiperlivros = get_records_select('hiperbook'); 
		
	foreach($hiperlivros as $hlivro){
	
		$module = get_record('modules', 'name', 'hiperbook');
		
		$cm = get_record('course_modules', 'instance', $hlivro->id, 'module', $module->id);
		
		$chapters = get_records_select('hiperbook_chapters', 'bookid=' . $hlivro->id);
		
		foreach($chapters as $chapter){
			echo 'Processando capitulo '.$chapter->title . ' de '. $hlivro->name;
			$paginas = get_records_select('hiperbook_chapters_pages', 'chapterid='.$chapter->id );
			
			//var_dump($paginas);				
			$links = get_records_select('hiperbook_chapters_links', 'chapterid=' . $chapter->id .' and idtargetpageid=0');
			 
			$hotwords= get_records_select('hiperbook_chapters_hotword', 'chapterid='. $chapter->id);
			$tips = get_records_select('hiperbook_chapters_tips', 'chapterid='. $chapter->id);
			$suggestions= get_records_select('hiperbook_chapters_suggestions', 'chapterid='. $chapter->id);
			
			foreach($suggestions as $hotword){			
				execute_sql('update ' . $CFG->prefix .'hiperbook_chapters_suggestions set idhiperbook = ' .$hlivro->id.' where id ='.$hotword->id );
			}	
			foreach($hotwords as $hotword){				
				execute_sql('update ' . $CFG->prefix .'hiperbook_chapters_hotword set idhiperbook = ' .$hlivro->id.' where id ='.$hotword->id );
				
			}		
			foreach($tips as $hotword){	
				execute_sql('update ' . $CFG->prefix .'hiperbook_chapters_tips set idhiperbook = ' .$hlivro->id.' where id ='.$hotword->id );
				
			}		
			
			foreach($paginas as $page){
			echo 'Processando página '.$page->pagenum;
				foreach($hotwords as $hotword){
					// verifica se o titulo esta no conteudo da pagina 
					// se estiver cria relacionamento page_hotword
					if (parse_element($page->content, $hotword->title) ){		
						$ph->idpage = $page->id;
						$ph->idhotword = $hotword->id;
						$newchapterid = insert_record('hiperbook_pages_hotwords', $ph);
					}	
				}		
				foreach($tips as $hotword){
					// verifica se o titulo esta no conteudo da pagina
					// se estiver cria relacionamento page_hotword
					if (parse_element($page->content, $hotword->title) ){		
						$ph->idpage = $page->id;
						$ph->idtip = $hotword->id;
						$newchapterid = insert_record('hiperbook_pages_tips', $ph);
					}	
				}		
				foreach($suggestions as $hotword){
					// verifica se o titulo esta no conteudo da pagina
					// se estiver cria relacionamento page_hotword
					if (parse_element($page->content, $hotword->title) ){		
						$ph->idpage = $page->id;
						$ph->idsuggestion = $hotword->id;
						$newchapterid = insert_record('hiperbook_pages_suggestions', $ph);
					}				
				}			
				foreach($links as $link){
				
					// verifica se o link esta no conteudo na pagina atual
					// se estiver adidiona relacionamento page 					
					if (parse_element($page->content, $link->title) ){		
						$link->idpage = $page->id;																	
						$target_page = get_record('hiperbook_chapters_pages', 'chapterid',  $link->targetchapterid, 'pagenum','1');
						
						//var_dump($target_page);	 
											 
						echo $target_page->id;	
						$link->idtargetpageid = $target_page->id;
						
						$target_navigation_chapter = get_record('hiperbook_navigation_chapters', 'chapterid',  $link->targetchapterid);
						
						$link->target_navigation_chapter = $target_navigation_chapter->id;
						
						
						$newchapterid = update_record('hiperbook_chapters_links', $link);					}				
				}					
				
				execute_sql('update ' . $CFG->prefix .'hiperbook_chapters_pages set idhiperbook = ' .$hlivro->id.' where id ='.$page->id );		
				
				//atualiza o esquema de background das paginas
				
				$conteudo = str_replace('background="'.$CFG->wwwroot.'/file.php//template_hiperbook'.$hlivro->id.'/template_hiperlivro.gif"','background="images/template_hiperlivro.gif"', $page->content);
				
				
				
				$conteudo = str_replace('background="images/template_hiperlivro.gif"', 'background="'.$CFG->wwwroot.'/file.php/'.$cm->course.'/template_hiperbook'.$hlivro->id.'/template_hiperlivro.gif"',$conteudo);
				
				$conteudo =  addslashes($conteudo);
				
				execute_sql("update " . $CFG->prefix ."hiperbook_chapters_pages set content = '" .$conteudo."' where id =".$page->id );	
				
//				 update_record('hiperbook_chapters_pages',  $page );
			}	
			// processou paginas do capitulo
			
			 		
		}			
		// preocessou capitulo, apaga os links correspondentes iniciais com  idtargetpageid= 0			
		//	$links = get_records_select('hiperbook_chapters_links', 'chapterid=' . $chapter->id .' and idtargetpageid= 0');
		
		// copia a pasta template_hiperbook para a pasta do curso
		//adiciona o template_css do hiperlivro 
		
	

		echo 'COpiando template para'.  $CFG->dataroot.'/'.$cm->course.'/template_hiperbook' .$hlivro->id;
		
		mkdir($CFG->dataroot.'/'.$cm->course);
		mkdir($CFG->dataroot.'/'.$cm->course.'/template_hiperbook' .$hlivro->id);
		
		  $directory = opendir($CFG->dirroot.'/mod/hiperbook/template_libras/');             // Find all files
    while (false !== ($file = readdir($directory))) {
        if ($file == "." || $file == "..") {
            continue;
        }
        
		copy($CFG->dirroot.'/mod/hiperbook/template/'.$file ,$CFG->dataroot.'/'.$cm->course.'/template_hiperbook' .$hlivro->id."/".$file);
    }
			
$hlivro->template_css = "

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

#mod-hiperbook-tips #page #header,
#mod-hiperbook-suggestions #page #header,
#mod-hiperbook-hotwords #page #header {
	display:none;
	
	
}

.hiperbook_content a, .hiperbook_content a:link, .hiperbook_content a:visited{
	text-decoration:underline;
        color:#00477F;

}

#mod-hiperbook-bibliography #page{
	
	}
	
	#mod-hiperbook-bibliography #header{
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
	background-repeat:no-repeat;
	display:inline;

}


	
	
.mod-hiperbook #navpaths #past{

	
}
	
	
.mod-hiperbook #navpaths #past #main{	
	background-position:center;
	background-repeat:repeat-x;
        background-color:#2C4F6B;
	display:inline;
	text-align:center;
padding: 2px;
padding-bottom: 3px;
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
	padding-right:0px

	
}

.mod-hiperbook #navpaths #past #end{
	background-position:center;
	background-repeat:no-repeat;
	display:inline;	
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

	color:#00477F;
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
	font-weight:bold;
        color:#00477F;
}

.mod-hiperbook #toc #item a:visited{
	color:#8FB4DF;
}

.mod-hiperbook #toc #item{	

}

.mod-hiperbook .hiperbook_content{
	width:500px;

}
.hiperbook_content .hotwordslist{
	
	padding-top:70px;
}
.mod-hiperbook .hiperbook_content #template_main{
	background-color:#efefef;
}

.mod-hiperbook .hiperbook_content #template_top_left{
	background-image:url(".$CFG->wwwroot."/file.php/".$cm->course."/template_hiperbook".$hlivro->id."/top_conteudo_left.png);
	background-repeat:no-repeat;
}

.mod-hiperbook .hiperbook_content #template_top_right{
	background-image:url(".$CFG->wwwroot."/file.php/".$cm->course."/template_hiperbook".$hlivro->id."/top_conteudo_right.png);
	background-repeat:no-repeat;
	background-position:right;

}
.mod-hiperbook .hiperbook_content #template_bottom_left{
	background-image:url(".$CFG->wwwroot."/file.php/".$cm->course."/template_hiperbook".$hlivro->id."/bottom_conteudo_left.png);
	background-repeat:no-repeat;

}
.mod-hiperbook .hiperbook_content #template_bottom_right{
	background-image:url(".$CFG->wwwroot."/file.php/".$cm->course."/template_hiperbook".$hlivro->id."/bottom_conteudo_right.png);
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


#botoesLateral{
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

#mod-hiperbook-popup #page{
	margin-top:0px;
	padding-top:0px;
	background-color:white;
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

.mod-hiperbook  #breadcrumbs a:link, .mod-hiperbook  #breadcrumbs a:visited, .mod-hiperbook #breadcrumbs a{
	text-decoration:none;
	color:#00477F;
}

table {
border-collapse:collapse;
border-spacing:0;
}


";


		$hlivro->template_main = '<table width="540" height="268" border="0" background="'. $CFG->wwwroot."/file.php/".$cm->course."/template_hiperbook".$hlivro->id.'/template_hiperlivro.png"> <tbody>
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

		$hlivro->template_hw = '';				 
		$hlivro->template_tips = ''; 
		$hlivro->template_suggs = '';
		$hlivro->img_hotwords_top = 'title_hotwords.png';
		$hlivro->img_tips_top = 'title_tips.png';
		$hlivro->img_suggestions_top= 'title_suggestions.png';
		$hlivro->img_links_top= 'title_links.png';
		
		$hlivro->img_hotwords_icon = "icone_glossario.png";			
		$hlivro->img_tips_icon = "icone_dicas.png";			
		$hlivro->img_suggestions_icon = "icone_sugestoes_de_estudo.png";		
		$hlivro->img_links_icon = "icone_links.png";			
		
		$hlivro->img_top_popup = 'top.png';
		$hlivro->img_page_next = 'next.png';
		$hlivro->img_page_prev = 'back.png';
		$hlivro->img_separador_toc = 'separador_toc.png';		
		$hlivro->img_navpath_active_start =  'navpath_current_start.png';
		$hlivro->img_navpath_active_middle =   'navpath_current.png';
		$hlivro->img_navpath_active_end	=  'navpath_current_end.png';			   
		$hlivro->img_navpath_inactive_start =  'navpath_past_start.png';		
		$hlivro->img_navpath_inactive_middle=  'navpath_past.png';		
		$hlivro->img_navpath_inactive_end =  'navpath_past_end.png';		
		$hlivro->opentostudents = 0;			 		
		update_record('hiperbook', $hlivro);
		
		
	}		
	
	// define target_navigation_chapter em chapters_links
	// target_navigation_chapter = primeiro navchapterid referente ao navigation_chapter com navchapter.chapterid = link.targetchapterid
	$links= get_records_select('hiperbook_chapters_links', 'targetchapterid!=0');
			
			foreach($links as $link){	
				
				$navchapterids = get_records_select('hiperbook_navigation_chapters', 'chapterid ='. $link->targetchapterid);
				$link->target_navigation_chapter =  $navchapterids->id;
			//	update_record('hiperbook_chapters_links', $link);
			}
}   
    return true;
}

function parse_element($content, $element){

			$delimitador = '((\s|\.|\?|\!|\@)+|(\s|\>|\<))' ;
			$pattern_root = '';
			$elementos_raiz = explode(' ',trim($element));			
			$xx = 1;		
			foreach($elementos_raiz as $elemento){
				
				$strlen1 = strlen($elemento);
				$elemento = str_replace("/","\/",$elemento);
				$strlen2 = strlen($elemento);
				
				
				if ($strlen1 == $strlen2) {
					if ($xx == count($elementos_raiz)){
	//					$pattern_root .= "(".quotemeta($elemento).")";
						//$pattern_root .= "".$elemento."";
						$pattern_root .= "".quotemeta($elemento)."";
					}else{
		//				$pattern_root .= "(".quotemeta($elemento).")(\s)+";
						//$pattern_root .= "".$elemento."(\s)+";
						$pattern_root .= "".quotemeta($elemento)."(\s)+";
					}				
				}else{
					$pattern_root = $elemento;
				}
				$xx++;
				// ((elemento)(\s)+(do)(\s)(link))
			}			
			$pattern = '/'.'('.$pattern_root.')'.'/is';		
			
			if (preg_match($pattern,$content)==0 ){$result= false; } else { $result = true;}

			
	return $result;
}
?>
