<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<p>Envie seu texto de acordo com o esquema</p> 
<p>&lt;UNIDADE&gt;</p>
<p>&lt;TELA&gt;</p>
<p>&lt;TITULO&gt; titulo &lt;/TITULO&gt;</p>
<p>&lt;FIGURA&gt;<br />
nome_da_imagem.jpg <br />
&lt;ALT&gt; Um  globo com um homem falando no celular atrás de um computador  &lt;/ALT&gt;<br />
&lt;/FIGURA&gt;</p>
<p>As tags seguintes definem apenas o estilo. Nao constituem link</p>
<p>&lt;DESTAQUE&gt; Texto em destaque &lt;/DESTAQUE&gt;</p>
<p>&lt;CITACAO&gt; Texto com estilo de citacao &lt;/CITACAO&gt;</p>
<p>&lt;ENUM&gt; Listagem : cada paragrafo no texto é prescedido de um marcador &lt;/ENUM&gt;</p>
<p>Os elementos contextuais sao definidos sequencialmente: 1 linke 2 conteudo exibido</p>
<p>&lt;REFLETIR&gt;link para refletir que esta no texto principal &lt;/REFLETIR&gt;</p>
<p>&lt;REFLETIR&gt; texto para reflexao &lt;/REFLETIR&gt;</p>
<p>&lt;GLOSSARIO1&gt; termo do glossario que esta no texto principal &lt;GLOSSARIO1&gt;</p>
<p>&lt;GLOSSARIO1&gt; descricao do termo &lt;/GLOSSARIO1&gt;</p>
<p>&lt;SAIBAMAIS&gt; chamada para o Saiba mais &lt;/SAIBAMAIS&gt;</p>
<p>&lt;SAIBAMAIS&gt; Texto do saiba mais &lt;/SAIBAMAIS&gt;</p>
<p>&lt;LEMBRETE&gt; Chamada para lembrete &lt;/LEMBRETE&gt;</p>
<p>&lt;LEMBRETE&gt; Texto do lembrete &lt;/LEMBRETE&gt;</p>
<p>&lt;VIDEO&gt; chamada para video &lt;/VIDEO&gt;</p>
<p>&lt;ANIMACAO&gt; Chamada para animacao &lt;/ANIMACAO&gt;</p>
<p>&lt;ANIMACAO&gt; caminho_do_arquivo.html &lt;/ANIMACAO&gt;</p>
<p>veja o arquivo &lt;LINK&gt;aqui &lt;URL&gt;nomde_do_arquivo.doc &lt;/URL&gt;&lt;/LINK&gt;</p>
<p>&lt;WEB&gt; Chamada para o pagina WEB&lt;/WEB&gt;</p>
<p>&lt;WEB&gt; URL da pagina WEB &lt;/WEB&gt;</p>
<p>&lt;ORIENTACAO&gt; link para orientacao &lt;/ORIENTACAO&gt;</p>
<p>&lt;ORIENTACAO&gt; texto com a orientacao &lt;/ORIENTACAO&gt;</p>
<p>&lt;DIARIODEBORDO&gt; Chamada para diario de bordo &lt;/DIARIODEBORDO&gt;</p>
<p>&lt;BIBLIOGRAFIA&gt; Chamada para </p>
<p>&lt;ATIVIDADE&gt; Link para atividade &lt;/ATIVIDADE&gt;</p>
<p>&lt;ATIVIDADE&gt; Texto da atividade [ pode ser colocado qualquer dos itens FIGURA, GLOSSARIO, SAIBAMAIS, REFLETIR, etc ]&lt;/ATIVIDADE&gt;</p>
<p>&lt;/TELA&gt;</p>
<p>&lt;/UNIDADE&gt;</p>
<p>&nbsp;</p>
<p>Formulario para adicionar os arquivos chamados em &lt;FIGURA&gt; &lt;VIDEO&gt; &lt;ANIMACAO&gt; &lt;ARQUIVO&gt;</p>

<?php


/*expressoe regulares usadas para buscar os itens

. ? * + ^ $ | [ ] { } ( ) \ = metacaracteres

*? = asterisco nao guloso

 /i = case insensitive
  a|b ,[abc] = texto 'a' ou texto 'b'
  . = qualquer caracter
  
*/

echo("<BR><BR>Iniciando Parser para: ".$_GET['pathxml']."<br><br>");

$conteudo = file_get_contents("./".$_GET['pathxml']);

var_dump($conteudo);
echo "<pre>";

	
$unit = new Unidade($conteudo);

echo("*****************************<br>");
echo("<br>");
echo("<br>");
echo("<br>");
$dirs=explode('/',$_GET['pathxml']);
var_dump($dirs);echo("<br>");
echo("<br>");
echo('cp -Rv templates_eproinfo2/* '.$dirs[0].'/ ');
echo(exec('cp -Rv templates_eproinfo2/* '.$dirs[0].'/ '));
echo("<br>");
echo("<br>");
echo("<br>");
echo("*****************************<br>");
echo "</pre>";

class Unidade{
  var $telas = array();
  var $titulo;
  
  function Unidade($conteudo){
  	
	$aux = preg_match_all("/<UNIDADE(.*?)>(.*?)<TITULO>(.*?)<\/TITULO>(.*)<\/UNIDADE(\\1)>/is",$conteudo,$retorno);	
	var_dump($retorno);
	$unidade = $retorno[4][0];
	$tituloUnidade = $retorno[3][0];
	$nroUnidade = $retorno[1][0];
	
	// divide a unidade em telas e extrai o titulo
	$aux = preg_match_all("/<TELA(.*?)>(.*?)<\/TELA(\\1)>/is",$unidade,$retornoTelas);		
	$telas = $retornoTelas[2];	
	
	$this->parse_telas($telas, $retornoTelas[1], $tituloUnidade, $nroUnidade);		
	//var_dump($telas);
	//$this->titulo= str_replace($retornoTelas[0],'',$unidade);	
  }
  
  // para cada tela, extrai os elementos contextuais
  //
  
  function parse_telas($telas, $telasindex, $tituloUnidade, $nroUnidade){
  
 
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
		

		$tela = $this->parse_titulos($tela, $titulos);
		
			
		$tela = $this->parse_figuras($tela, $figuras);
		
			
		$tela = $this->parse_links($tela, $links);
			
		$tela = $this->parse_enums($tela, $enums);		
//	
		$tela = $this->parse_atividades($tela, $atividades);
		
		$tela = $this->parse_tags_divs($tela,$nroTela,$js, $lateral);
		
		//	var_dump($foundedDivs); die();
			
			
		
		
	//	$tela = $this->parse_atividades($tela,$nroTela , $atividades);
		
		
		
	//	echo 'gravando'.$js;
		$file = file_get_contents("templates_eproinfo2/templateTelas_verde.html");		
		
		$file = str_replace("{js}",$js,$file);
		$file = str_replace("{qtde_paginas}",sizeof($telas),$file);
		
		//var_dump($js); die();
	
	
	
		$file = str_replace("{nroUnidade}",$nroUnidade,$file);
		
		$file = str_replace("{conteudo}",$tela,$file);
		
		$file = str_replace("{titulo}",$tituloUnidade,$file);
		
	
		
		
		$file = str_replace("{lateral}",$lateral,$file);
		
		//var_dump( $tela);
		file_put_contents("templates_eproinfo2/pg". $nroTela.".html"  ,$file);
		
	}
  
  }
  

  
  function parse_titulos($tela, &$titulos){
  
  	$telaParsed = preg_replace("/<TITULO(.*?)>(.*?)<\/TITULO(\\1)>/is", '<b>\\2 </b>',$tela);	
	if($telaParsed){ $tela = $telaParsed; }
	return $tela;  
  }
  
  function parse_figuras($tela, &$figuras){  
  /*
  <FIGURA> 
   <URL>nome_da_imagem.jpg</URL>
<ALT> Um globo com um homem falando no celular atrás de um computador  </ALT>
</FIGURA>
  */
  	$aux = preg_match_all("/<FIGURA(.*?)>(.*?)<ALT>(.*?)<\/ALT>(.*?)<\/FIGURA(\\1)>/is",$tela, $retorno);	
	echo 'figura';
	var_dump($retorno);
	
	
	
	$telaParsed = preg_replace("/<FIGURA(.*?)>(.*?)<ALT>(.*?)<\/ALT>(.*?)<\/FIGURA(\\1)>/is","<div id=\"imagem\"> <div href=\"\\2\"><img src=\"\\2\" alt=\"\\3\" /></div></div>\\4",$tela);	
	
	
	
	
	 	$telaParsed =preg_replace("/src=\"(.+?)\.(...)\"/is","src=\"\\1_peq.\\2\"",$telaParsed);		
	
	//var_dump($telaParsed); die();
			
	foreach($retorno[0] as $figura){		
		$url = trim($retorno[2]);	
		$alt = $retorno[3];			
		$figuras.= "<img src=\"".$url."\" alt=\"".$url."\"  />";
	}
	if($telaParsed){ $tela = $telaParsed; }

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
		$tela = preg_replace("/<LINK(.*?)>(.*?)<URL>(.*?)<\/URL>(.*?)<\/LINK(\\1)>/is","<a target='_new' href=\"\\3\">\\2</a>",$tela);				
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
  
function parse_videos($tela, &$videos){  
  /*
<VIDEO> 
   chamada pra arquivo
</VIDEO>
<VIDEO> 
   <URL>nome_do_arquivo.pdf</URL>
</VIDEO>
  */  

  //BUSCA chamadas
    $aux = preg_match_all("/<VIDEO(.*)>(.*?)<\/VIDEO(\\1)>(.*?)<VIDEO(\\1)>(.*?)<URL>(.*?)<\/URL>(.*?)<\/VIDEO(\\1)>/is",$tela, $retorno);	
	foreach($retorno[0] as $arquivo){		
		$url = $retorno[7];	
		$tela = preg_replace("/<VIDEO(.*)>(.*?)<\/VIDEO(\\1)>(.*?)<VIDEO(\\1)>(.*?)<URL>(.*?)<\/URL>(.*?)<\/ARQUIVO(\\1)>/is","<a href=\"\\7\">FORMATO VIDEO \\2</a>\\4",$tela);				
		$arquivos[sizeof($video)] = $video;
	//	echo( $tela);	
	}
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


		
function parse_atividades($tela,$nroTela, &$atividades){  
  /*
  
  a atividade eh um popup HTML
  alterar o texto dento do conteudo principal, 
  extrair conteudo da atividade e criar um html para ser chamado pelo popup
  
<ATIVIDADE1.1>Momento 1: Leitura do texto. </ATIVIDADE1.1>
<ATIVIDADE1.1>
	<TITULO>Atividade 1.1: Momento 1 – Leitura do texto. </TITULO>
           Enquanto estiver lendo, nós iremos lhe sugerindo uma série de momentos e questões para reflexão. Em cada um deles anote as ideias, questionamentos e dúvidas que forem surgindo. Isso vai ser importante no prosseguimento da atividade.  
           
          Convidamos você a iniciar a leitura do <ARQUIVO>Texto (01)</ARQUIVO>: <SAIBAMAIS>Por que precisamos usar a tecnologia na escola? As relações entre a escola, a tecnologia e a sociedade</SAIBAMAIS>, da Profa. Edla Ramos. 

            <SAIBAMAIS> O texto disponibilizado para leitura é uma adaptação de um outro bastante semelhante de autoria de Edla M. F. Ramos, que consta do livro recém publicado “Informática aplicada à aprendizagem da matemática”. Este livro foi escrito para o programa de Licenciatura em Matemática à Distância oferecido pela  Universidade Federal de Santa Catarina. A autora e a Coordenação do Curso autorizaram a sua inclusão neste material. </SAIBAMAIS>
</ATIVIDADE1.1>


  */  

  //BUSCA chamadas
  
  $aux = 1;
	while($aux != 0){
		$aux = preg_match_all("/<ATIVIDADE(.*?)>(.*?)<\/ATIVIDADE(\\1)>(.*?)<ATIVIDADE(\\1)>(.*?)<\/ATIVIDADE(\\1)>/is",$tela, $retorno);	
		echo $aux;
		$tela = preg_replace("/<ATIVIDADE(.*?)>(.*?)<\/ATIVIDADE(\\1)>(.*?)<ATIVIDADE(\\1)>(.*?)<\/ATIVIDADE(\\1)>/is","<a href=\"javascript:void(0);\" onClick=\"window.open('t".$nroTela."atividade\\1.html','atividade\\1','menubar=1,resizable=1,width=800,height=400');\">\\2</a>\\4",$tela);
		
	
		if($aux >0){	echo 'atividades';var_dump($retorno);}
		// para cada atividade encontrada cria a devida pagina.html
		//foreach($retorno as $atividade){						
	
			$conteudoDaAtividade = 	$retorno[6][0];	
			
			$titulo = 	$retorno[2][0];	
			$js='';
			$conteudoDaAtividade = $this->parse_tags_divs($conteudoDaAtividade,$nroTela,&$js, &$lateral);	
			$file = file_get_contents( "templates_eproinfo2/templateAtividades_verde.html");		
			$file = str_replace("{conteudo}",$conteudoDaAtividade,$file);		
			$file = str_replace("{titulo}",$titulo,$file);	
			$file = str_replace("{lateral}",$lateral,$file);
			$file = str_replace("{js}",$js,$file);
			file_put_contents("templates_eproinfo2/t".$nroTela."atividade". $retorno[1][0].".html",$file);
			$atividades[sizeof($atividades)] = $atividade;
			//echo( $tela);	
		//}
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
		'DIARIODEBORDO',
		'LEMBRETE',
		'ANIMACAO',
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

</body>
</html>
