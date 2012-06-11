<?PHP // $Id: view.php,v 1.17 2005/08/25 19:33:12 skodak Exp $
	

require_once('../../config.php');
require_once('lib.php');

$db->debug =true;

$id = required_param('id', PARAM_INT);           // Course Module ID


// =========================================================================
// security checks START - teachers edit; students view
// =========================================================================
if ($CFG->forcelogin) {
    require_login();
}

if (!$cm = get_record('course_modules', 'id', $id)) {
    error('Course Module ID is incorrect');
}

if (!$course = get_record('course', 'id', $cm->course)) {
    error('Course is misconfigured');
}

if ($course->category){
    require_login($course->id);
}

if (!$book = get_record('hiperbook', 'id', $cm->instance)) {
    error('Course module is incorrect');
} 



$conteudo = data_submitted();

echo 'data OK';

echo var_dump($conteudo);
if($conteudo) { 

echo("<BR><BR>Iniciando Parsersss <br><br>");



echo "<pre>";

	
$unit = new Unidade($conteudo->content,$book);

echo("*****************************<br>");
echo("<br>");
echo("<br>");
echo("<br>");
echo("<br>");
echo("<br>");
echo("<br>");
echo("*****************************<br>");
echo "</pre>";
}else{
		include('parserForm.html');




echo "teste";

}

/*documento texto contendo um ou mais topicos, 
compostos por telas (paginas)
em cada pagina existe tip, glossario ou bibliografia
pode tambem ter imagens, links, etc */

/*expressoe regulares usadas para buscar os itens

. ? * + ^ $ | [ ] { } ( ) \ = metacaracteres

*? = asterisco nao guloso

 /i = case insensitive
  a|b ,[abc] = texto 'a' ou texto 'b'
  . = qualquer caracter

<UNIDADE2>
<TITULO>tela 4</TITULO>
<TELA1>
CONTEUDO DA TELA UM 


<CITACAO>
citacao citacao citacaocitacao citacao citacaocitacao citacao citacaocitacao citacao c
itacaocitacao citacao citacaocitacao citacao citacaocitacao citacao citacaocitacao citacao citacaocitacao ci
tacao citacaocitacao citacao citacaocitacao citacao citacaocitacao citacao citacaocitacao citacao citacaocitacao citacao citacao
</CITACAO>
<FIGURA>Imagem1.jpg<ALT>uma tabela</ALT></FIGURA>

enumerado
<ENUM>ITEM UM 
DOIS
TRES</ENUM>

texto normal 
<LINK>acesso a url externa<URL>http://www.terra.com.br</URL></LINK>
texto normal ahahhaha 
<DESTAQUE>
isto eh um destaquer isto eh um destaquer isto eh um destaquer isto eh um destaquer isto eh um destaquer isto eh um destaquer isto eh um destaquer isto eh um destaquer isto eh um destaquer isto eh um destaquer isto eh um destaquer isto eh um destaquer isto eh um destaquer isto eh um destaquer isto eh um destaquer isto eh um destaquer 
</DESTAQUE>
<DICA>veja a dica</DICA>

<DICA><CITACAO>
citacao citacao citacaocitacao citacao citacaocitacao citacao citacaocitacao citacao c
itacaocitacao citacao citacaocitacao citacao citacaocitacao citacao citacaocitacao citacao citacaocitacao ci
tacao citacaocitacao citacao citacaocitacao citacao citacaocitacao citacao citacaocitacao citacao citacaocitacao citacao citacao
</CITACAO></DICA>


<SUGESTAOA>sugestaooo</SUGESTAOA>
<SUGESTAOA><TITULO>sug</TITULO> <FIGURA>Imagem1.jpg<ALT>uma tabela</ALT></FIGURA></SUGESTAOA>


</TELA1>

<TELA2>
CONTEUDO DA TELA dois
<IMAGEM> </IMAGEM> 
<ENUM>ITEM UM 
DOIS
TRES</ENUM>

<GLOSSARIOB>chamada do glossario B</GLOSSARIOB>
<GLOSSARIOB><TITULO>veja o glossario</TITULO>glossario </GLOSSARIOB>
</TELA2>
</UNIDADE2>

.CITACAO {
display: block;
font-family: 'trebuchet MS', 'Nimbus Sans L';
font-size: 12px;
line-height: 15px;
margin-left: 10px;
margin-right: 10px;
padding: 10px;
}

.DESTAQUE {
background-color: #F4D89A;
color: black;
display: block;
font-family: 'trebuchet MS', 'Nimbus Sans L';
margin-left: 10px;
margin-right: 10px;
padding: 10px;
}
  
*/






class Unidade{
  var $telas = array();
  var $titulo;
    
  function Unidade($conteudo,$book){
	  
	  global $USER;
	  // cada umidade correspode a um topico
	  
	  
	  echo $conteudo;
	  $aux = preg_match_all("/<UNIDADE(.*?)>(.*?)<TITULO>(.*?)<\/TITULO>(.*)<\/UNIDADE(\\1)>/is",$conteudo,$retorno);	
	  
	  var_dump($aux);
	  $unidade = $retorno[4][0];
	  $tituloUnidade = $retorno[3][0];
	  $nroUnidade = $retorno[1][0];
	  

	  echo "titulo". $tituloUnidade;
	  // divide a unidade em telas e extrai o titulo
	  $aux = preg_match_all("/<TELA(.*?)>(.*?)<\/TELA(\\1)>/is",$unidade,$retornoTelas);	
		  
	  $telas = $retornoTelas[2];	
	  
		  
	  
	  $chapter->title = $tituloUnidade;
	  $chapter->bookid = $book->id;
	  $chapter->userid= $USER->id;
	  $chapter->timecreated = time();
	  
	  $chapterid = insert_record('hiperbook_chapters', $chapter);

	  $this->parse_telas($telas, $retornoTelas[1], $tituloUnidade,  $chapterid , $book);	
	  
    }
    
  

    // cada tela correspode a uma pagia detro do hiperlivro 
  function parse_telas($telas, $telasindex, $tituloUnidade, $chapterid, $book){
	  global $USER;
	  $nroTela = 0;  
	  foreach($telas as $tela){
	  
		  $nroTela++;	
			  echo '<h1>parcing tela '.$nroTela.'</h1>';
		  $tela = preg_replace("(\n|\r)","<br>",$tela);	
			  
		  $aux = 1;
		  while($aux != 0){
			  $aux = preg_match_all("/<br><br>/",$tela, $retorno);		
			  $tela = preg_replace("/<br><br>/","<br>",$tela);
		  }
		  
		  // trata elemetos emdeded
		  $tela = $this->parse_titulos($tela, $titulos);
		  $tela = $this->parse_figuras($tela, $figuras);
		  $tela = $this->parse_links($tela, $links);
		  $tela = $this->parse_enums($tela, $links);
		  $tela =$this->parse_tag_div("DESTAQUE",$tela,$nroTela ,$retorno);	
		  $tela =$this->parse_tag_div("CITACAO",$tela,$nroTela ,$retorno);		

		  $page->content = addslashes($tela);
		  $page->chapterid = $chapterid;
		  $page->opentostudents = 0;
		  $page->userid = $USER->id;
		  $page->pagenum = $nroTela;
		  $page->idhiperbook = $book->id;
		  $page->hidden = 0;
		  $page->timecreated = time();
		  $page->timemodified = $page->timecreated;
		  $db->debug = true;
		  if (!$page->id = insert_record('hiperbook_chapters_pages', $page)) {
			  error('Could not insert a new page!');
		  }		
		  // processa os elemetos cotextuais
		  $tela =  $this->parse_tips($tela, $page->id,$book ,$chapterid);
		  $tela =  $this->parse_suggestions($tela, $page->id, $book , $chapterid);
		  $tela =  $this->parse_glossary($tela, $page->id, $book , $chapterid);
		  
		  $conteudo = str_replace("{conteudo}",$tela,$book->template_main);
		  $page->content = $conteudo ;
		  
		  if (!update_record('hiperbook_chapters_pages', $page,'pageid')) {
		      error('Could not update your hiperbook!');
		  }
	  }
  }

  function parse_tips($tela, $pageid, $book, $chapterid){
	  
	  $item = $this->parse_tag("DICA", $tela, $pageid, $book , $chapterid );
	  return $item;
  }

  function parse_glossary($tela, $pageid, $book, $chapterid){
	  
	  $item = $this->parse_tag("GLOSSARIO", $tela, $pageid, $book , $chapterid );
	  return $item;
  }

  
  function parse_suggestions($tela, $pageid, $book, $chapterid){
	  
	  $item = $this->parse_tag("SUGESTAO", $tela, $pageid, $book , $chapterid );
	  return $item;
  } 

 
   function parse_tag($tag, $tela, $pageid, $book, $chapterid){ 	  

	  if($tag=="DICA"){
		  $template  = 	$book->template_tips;
	  }
	  if($tag=="GLOSSARIO"){
		  $template  = 	$book->template_hw;
	  }
	  if($tag=="SUGESTAO"){
		  $template  = 	$book->template_suggs;
	  }

	  $processados = array();
	  $aux = 1;
	  while($aux != 0){ 
		  $aux = preg_match_all("/<".$tag."(.*?)>(.*?)<\/".$tag."(\\1)>(.*?)<".$tag."(\\1)>(.*?)<\/".$tag."(\\1)>/is",$tela, $retorno);		
		  $tela = preg_replace("/<".$tag."(.*?)>(.*?)<\/".$tag."(\\1)>(.*?)<".$tag."(\\1)>(.*?)<\/".$tag."(\\1)>/is","<span class=\"".$tag."\"  id=\"t".$nroTela.$tag."\\1\"> \\2 </span>\\4",$tela);
		  echo 'achou '. $aux . ' '. $tag;
		  if ($aux!=0){		  
			  if ($aux ==1 ){
				  $conteudo = 	$retorno[6][0];	
				  //$titulo = 	ucfirst(trim($retorno[2][0]));	
				   $titulo = 	trim($retorno[2][0]);	
				  $conteudo =     str_replace("{conteudo}",$conteudo,$template);
				  $conteudo =     str_replace("{titulo}",$titulo,$conteudo);

				  $item->content = $conteudo;
				  $item->title = $titulo;

				  $item->chapterid = $chapterid;
				  $item->idhiperbook = $book->id;	
					  
				  if($tag == "DICA"){
					  if (!$item->id = insert_record('hiperbook_chapters_tips', $item)) {
						  error('Could not insert a new tip!');
						 
					  }
					  $rel->idpage = $pageid;
					  $rel->idtip = $item->id;
					  $rel->id = insert_record('hiperbook_pages_tips', $rel);
				  }

				  if($tag == "GLOSSARIO"){
					  if (!$item->id = insert_record('hiperbook_chapters_hotword', $item)) {
						  error('Could not insert a new hotword!');
						
					  }
					  $rel->idpage = $pageid;
					  $rel->idhotword = $item->id;
					  $rel->id = insert_record('hiperbook_pages_hotwords', $rel);
				  }

				  if($tag == "SUGESTAO"){
					  if (!$item->id = insert_record('hiperbook_chapters_suggestions', $item)) {
						  error('Could not insert a new suggestion!');
						
					  }
					  $rel->idpage = $pageid;
					  $rel->idsuggestion = $item->id;
					  $rel->id = insert_record('hiperbook_pages_suggestions', $rel);
				  }

			  }else{
			  //ech o 'achou varios';
				  for ($z=0; $z<count($retorno[0]); $z++){	
					//  $titulo = ucfirst(trim($retorno[2][$z]));
					  $titulo = trim($retorno[2][$z]);		
					  $conteudo =     str_replace("{conteudo}",$conteudo,$template);
					  $conteudo =     str_replace("{titulo}",$titulo,$conteudo);
					  $item->content = $conteudo;
					  $item->title = $titulo;
					  $item->chapterid = $chapterid;
					  $item->idhiperbook = $book->id;	
						  
					  if($tag == "DICA"){
						  if (!$item->id = insert_record('hiperbook_chapters_tips', $item)) {
							  error('Could not insert a new tip!');
							  $rel->idpage = $pageid;
							  $rel->idtip = $item->id;
							  $rel->id = insert_record('hiperbook_pages_tips', $rel);
						  }
					  }

					  if($tag == "GLOSSARIO"){
						  if (!$item->id = insert_record('hiperbook_chapters_hotword', $item)) {
							  error('Could not insert a new hotword!');
							  $rel->idpage = $pageid;
							  $rel->idhotword = $item->id;
							  $rel->id = insert_record('hiperbook_pages_hotwords', $rel);
						  }
					  }

					  if($tag == "SUGESTAO"){
						  if (!$item->id = insert_record('hiperbook_chapters_suggestions', $item)) {
							  error('Could not insert a new suggestion!');
							  $rel->idpage = $pageid;
							  $rel->idsuggestion = $item->id;
							  $rel->id = insert_record('hiperbook_pages_suggestions', $rel);
						  }
					  }		
				  }
			  }			 
		  }
	  }	
	  return $tela;  
  }




  function parse_titulos($tela, &$titulos){
    
	  $telaParsed = preg_replace("/<TITULO(.*?)>(.*?)<\/TITULO(\\1)>/is", '<b>\\2 </b>',$tela);	
	  if($telaParsed){ $tela = $telaParsed; }
	  return $tela;  
    }
    
  function parse_figuras($tela, &$figuras){  
    global $CFG, $COURSE;
    /*
    <FIGURA> 
    <URL>nome_da_imagem.jpg</URL>
  <ALT> Um globo com um homem falando no celular atrás de um computador  </ALT>
  </FIGURA>
    */
	  $aux = preg_match_all("/<FIGURA(.*?)>(.*?)<ALT>(.*?)<\/ALT>(.*?)<\/FIGURA(\\1)>/is",$tela, $retorno);	
	  echo 'figura';
	  var_dump($retorno);
	  $telaParsed = preg_replace("/<FIGURA(.*?)>(.*?)<ALT>(.*?)<\/ALT>(.*?)<\/FIGURA(\\1)>/is","<div id=\"imagem\"> <div href=\"".$CFG->wwwroot."/file.php/".$COURSE->id. "/\\2\"><img src=\"".$CFG->wwwroot."/file.php/".$COURSE->id. "/\\2\" alt=\"\\3\" /></div></div>\\4",$tela);
		  //$telaParsed =preg_replace("/src=\"(.+?)\.(...)\"/is","src=\"".$CFG->wwwroot."/file.php/".$COURSE->id. "/\\1_peq.\\2\"",$telaParsed);		
	  
	  foreach($retorno[0] as $figura){		
		  $url = trim($retorno[2]);	
		  $alt = $retorno[3];			
		  $figuras.= "<img src=\"".$url."\" alt=\"".$url."\"  />";
	  }
	  if($telaParsed){ $tela = $telaParsed;}

	  return $tela;
  }
    
  function parse_links($tela, &$links){  
    /*
  <ARQUIVO> 
    chamada pra arquivo
  </ARQUIVO>
  <ARQUIVO> 
    <URL>nome_do_arquivo.pdf</URL>
  </ARQUIVO>
    */  
    //BUSCA chamadas
      $aux = preg_match_all("/<LINK(.*?)>(.*?)<URL>(.*?)<\/URL>(.*?)<\/LINK(\\1)>/is",$tela, $retorno);	
	  foreach($retorno[0] as $arquivo){		
		  $url = $retorno[7];	
		  $tela = preg_replace("/<LINK(.*?)>(.*?)<URL>(.*?)<\/URL>(.*?)<\/LINK(\\1)>/is","<a target=\"_new\" href=\"\\3\">\\2</a>",$tela);				
		  $arquivos[sizeof($arquivos)] = $arquivo;
		  //echo( $tela);	
	  }
	  
	  
	  // trata links para FLVS
	  $search = '/<a([^<]+)href=\"([^<]+)\.flv\"([^>]*)>(.*?)<\/a>/i';
  
	
	  $replace  = '&nbsp;<span  id="filme_filter"><object class="mediaplugin flv" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"';
	  $replace .= ' codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" ';
	  $replace .= ' width="240" height="200" id="flvplayer">';
	  $replace .= " <param name=\"movie\" value=\"flvplayer.swf?file=\\2.flv&autostart=0&fs=0\" />";
	  $replace .= ' <param name="quality" value="high" />';
	  $replace .= ' <param name="bgcolor" value="#FFFFFF" />';
	  $replace .= " <param name=\"flashvars\" value=\"file=\\2.flv\" />";
	  $replace .= " <embed src=\"flvplayer.swf?file=\\2.flv&autostart=0&fs=1";
	  $replace .= "  quality=\"high\" bgcolor=\"#FFFFFF\" width=\"240\" height=\"200\" name=\"flvplayer\" ";
	  $replace .= ' type="application/x-shockwave-flash" ';
	  $replace .= ' flashvars="autostart=0&fs=0&file=\\2.flv"';
	  $replace .= ' pluginspage="http://www.macromedia.com/go/getflashplayer">';
	  $replace .= '</embed>';
	  $replace .= '</object><br><a href="\\2.flv"><small><small>Download</small></small></a></span>&nbsp;';
  /*
  echo 'testes';*/
	  $tela = preg_replace($search, $replace, $tela);

	  
	  return $tela;
  }
      
  function parse_destaques($tela, &$destaques){  
    /*
  <DESTAQUE> 
    parte em destaque
  </DESTAQUE>
    */  

    //BUSCA chamadas
      $aux = preg_match_all("/<DESTAQUE(.*)>(.*?)<\/DESTAQUE(\\1)>/is",$tela, $retorno);	
	  foreach($retorno[0] as $destaque){				
		  $tela = preg_replace("/<DESTAQUE(.*)>(.*?)<\/DESTAQUE(\\1)>/is","<div class=\"destaque\">\\2</div>",$tela);				
		  $destaques[sizeof($destaques)] = $destaque;
		  //echo( $tela);	
	  }
	  return $tela;
    }
    
  function parse_citacoes($tela, &$citacoes){  
    /*
  <CITACAO> 
    texto dee (dias,2000)
  </CITACAO>
    */  

    //BUSCA chamadas
      $aux = preg_match_all("/<CITACAO(.*)>(.*?)<\/CITACAO(\\1)>/is",$tela, $retorno);	
	  foreach($retorno[0] as $citacao){				
		  $tela = preg_replace("/<CITACAO(.*)>(.*?)<\/CITACAO(\\1)>/is","<div class=\"citacao\">\\2</div>",$tela);				
		  $citacoes[sizeof($citacoes)] = $citacao;
		  //echo( $tela);	
	  }
	  return $tela;
    }
    
  function parse_enums($tela, &$enums){  
    /*
  <ENUM> 
    item 1 
    item 2
  </ENUM>

  vira

  <ul>
    <li>oitem 2</li>
    <li>item 1</li>
  </ul>

    */  

    //BUSCA chamadas
      $aux = preg_match_all("/<ENUM(.*)>(.*?)<\/ENUM(\\1)>/is",$tela, $retorno);	
	  
	  foreach($retorno[0] as $enum){	
				  $enums = split("(<br>)",$enum);
				  var_dump($tela);
				  
				  $ul = '<ul>';
				  foreach($enums as $li){
				  echo ' enum '.strlen($li);
					  if(strlen($li)>0){
						  $ul .='<li>'.$li.'</li>';
					  }
				  }
				  $ul .= '</ul>';
								  echo ' enum '.$ul; var_dump($enums);
				  $tela = str_replace($enum,$ul,$tela);
								  
		  //$tela = preg_replace("/<ENUM(.*)>(.*?)((\n|\r)(.*?))<\/ENUM(\\1)>/is","<ul><li>\\2 </li></ul>",$tela);				
		  $enums[sizeof($enums)] = $enum;
		  //var_dump($tela);	
	  }
	  return $tela;
  }

  function parse_tags_divs($tela,$nroTela,&$js,&$lateral){

		  $lateral = '<table width="70%" border="0">';
		  $js = '';
	  $tags = array(
		  "REFLETIR",
		  "GLOSSARIO",
		  'VIDEO',
		  'ORIENTACAO',
		  'SAIBAMAIS',	
		  'LEMBRETE',
		  'BIBLIOGRAFIA',
		  'IMAGEMOVER');
		  
		  echo 'javasc'.$js;
		  foreach($tags as $tag){ 
			  $tela =$this->parse_tag_popupdiv($tag,$tela,$nroTela ,$retorno);
			  var_dump($retorno);		
			  foreach($retorno as $item ){
			  //	if ($item) { 
					  echo 'item'.$item[0].$tag;
					  
					  $texto_lateral = explode(" ",ucfirst(trim($item[1])));
					  echo 'txt';var_dump($texto_lateral);// die();
					  if(count($texto_lateral) > 4){
						  $texto_lateral_final = $texto_lateral[0].' '.$texto_lateral[1] .' '.$texto_lateral[2]. '....';
					  }else{					
						  $texto_lateral_final = $item[1];
					  }
					  $found = array($item[0], $tag);
					  array_push($foundedDivs, $found );
					  $js .= "  j(\"#t".$nroTela.$tag.$item[0]."\").createDialog({ addr:'t".$nroTela.$tag.$item[0].".html', bg: '#000', opacity: 0.9 });\n
					  j(\"#t".$nroTela.$tag.$item[0]."ico\").createDialog({ addr:'t".$nroTela.$tag.$item[0].".html', bg: '#000', opacity: 0.9 });\n 
					  j(\"#t".$nroTela.$tag.$item[0]."txt\").createDialog({ addr:'t".$nroTela.$tag.$item[0].".html', bg: '#000', opacity: 0.9 });\n";											
					  echo 'javasc'.$js;
					  $lateral .= '<tr>
				  <td width="30%"><div id="t'.$nroTela.  $tag.$item[0].'ico"><img src="icones_gif/' .$tag.'.gif" alt="'.  $tag.'" width="30" height="30"  /></div></td>
				  <td width="70%"><div id="t'.$nroTela.  $tag.$item[0].'txt"> '.$texto_lateral_final. '</div></td>
			    </tr>
			    <tr>
				  <td colspan="2"><img src="barra_lateral_verde.png" width="145" height="11" /></td>
				  </tr> ';
	  
					  
					  
			  //	}		
					  
			  }
		  } 
		  $lateral .= '</table>';   
		  
		  $tags = array("DESTAQUE",
		  "ENUM",
		  "CITACAO");
		  
		  
		  foreach($tags as $tag){ 
			  $tela =$this->parse_tag_div($tag,$tela,$nroTela ,$retorno);		
			  
		  } 
		  
		  return $tela;
  }
    
  function parse_tag_popupdiv($tag, $tela, $nroTela, &$processados){ 
	    
	  $processados = array();
	  $aux = 1;
	  while($aux != 0){
		  $aux = preg_match_all("/<".$tag."(.*?)>(.*?)<\/".$tag."(\\1)>(.*?)<".$tag."(\\1)>(.*?)<\/".$tag."(\\1)>/is",$tela, $retorno);		
	  
  //	var_dump($retorno); die();
	  
		  $tela = preg_replace("/<".$tag."(.*?)>(.*?)<\/".$tag."(\\1)>(.*?)<".$tag."(\\1)>(.*?)<\/".$tag."(\\1)>/is","<span class=\"".$tag."\"  id=\"t".$nroTela.$tag."\\1\">\\2</span>\\4",$tela);
		  echo 'achou '. $aux . ' '. $tag;
	  
		  //echo $tag. "/<".$tag."(.*)>(.*?)<\/".$tag."(\\1)>(.*?)<".$tag."(\\1)>(.*?)<\/".$tag."(\\1)>/"; var_dump($retorno);
		  if ($aux!=0){
		  
			  if ($aux ==1 ){
				  $conteudo = 	$retorno[6][0];	
				  $titulo = 	ucfirst(trim($retorno[2][0]));	
				  if($tag== 'ANIMACAO'){ 
				  
					  $conteudo = '<p align="center"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="700" height="400" title="'.$titulo.'">
    <param name="movie" value="'.$retorno[6][0].'" />
    <param name="quality" value="high" />
    <embed src="'.$retorno[6][0].'" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="700" height="400"></embed>
  </object></p>';
				  }
				  
				  $file = file_get_contents("templates_eproinfo2/templatePopup_verde.html");		
				  
				  
				  /*$aux = 1;
				  while($aux != 0){
					  $aux = preg_match_all("/<br><br>/",$conteudo, $retorno);		
					  $conteudo = preg_replace("/<br><br>/","<br>",$conteudo);
					  
				  }*/
				  $file = str_replace("{conteudo}",$conteudo,$file);
				  $file = str_replace("{titulo}",$titulo,$file);
				  
				  
				  
				  
				  file_put_contents("templates_eproinfo2/t".$nroTela.$tag. $retorno[1][0].".html"  ,$file);
				  //if ($retorno[1][0]==null){ $retorno[1][0] =1; }
				  $aux = array( $retorno[1][0] , $titulo);
				  $processados[sizeof($processados)] = $aux;
				  echo ' retornando' ; var_dump($retorno[1][0]);
				  echo 'gravando ' . $tag . ' '. $retorno[2][0];	
				  
				  
			  }else{
			  //echo 'acho varios';
			  var_dump($retorno);
				  for ($z=0; $z<count($retorno[0]); $z++){	
				  
					  if($tag== 'ANIMACAO'){ 
					  $conteudo = 	$retorno[6][$z];	
					  $conteudo = '<p align="center"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="700" height="400" title="'.$titulo.'">
    <param name="movie" value="'.$retorno[6][$z].'" />
    <param name="quality" value="high" />
    <embed src="'.$retorno[6][$z].'" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="700" height="400"></embed>
  </object></p>';
				  }
							  
				  
					  $titulo = 	ucfirst(trim($retorno[2][$z]));	
					  $file = file_get_contents( "templates_eproinfo2/templatePopup_verde.html");
					  $file = str_replace("{conteudo}",$conteudo,$file);
					  $file = str_replace("{titulo}",$titulo,$file);
					  file_put_contents("templates_eproinfo2/t".$nroTela.$tag. $retorno[1][$z].".html"  ,$file);			
					  $aux = array( $retorno[1][$z] , $titulo);		
				  //	if ($elemento[1]==null){ $elemento[1] =1; }
					  $processados[sizeof($processados)] = $aux;					
			  //	echo( $tela);	
				  }
			  }			 
		  }
	  }
	  
	  return $tela;
  } 


  function parse_tag_div($tag, $tela, $nroTela, &$processados){ 

	  $aux = 1;
	  while($aux != 0){
		  $aux = preg_match_all("/<".$tag."(.*?)>(.*?)<\/".$tag."(\\1)>/is",$tela, $retorno);		
	  
	  
		  $tela = preg_replace("/<".$tag."(.*?)>(.*?)<\/".$tag."(\\1)>/is","<span class=\"".$tag."\"  id=\"t".$nroTela.$tag."\\1\">\\2</span>\\4",$tela);
		  
	  }
	  
	  return $tela;
  } 

}



?>