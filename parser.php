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
<p>&lt;ARQUIVO&gt; Chamada para o arquivo &lt;/ARQUIVO&gt;</p>
<p>&lt;ARQUIVO&gt; URL do arquivo &lt;/ARQUIVO&gt;</p>
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
$conteudo = '<UNIDADE1>

<TITULO>
TECNOLOGIAS NO COTIDIANO: DESAFIOS À INCLUSÃO DIGITAL
</TITULO>

<TELA1>
	<FIGURA1>imagem.jpg<ALT> Um globo com um homem falando no celular atrás de um computador </ALT></FIGURA1>Olá, cursista,
É com grande alegria e satisfação que iniciamos o Curso Introdução à <GLOSSARIO1>Educação Digital</GLOSSARIO1> Esse curso integra um conjunto de políticas públicas voltadas à <GLOSSARIO2> inclusão digital </GLOSSARIO2>. Fazendo este curso você estará participando deste processo formativo enquanto aprende sobre mídias e tecnologias e maneja algumas ferramentas de produção disponíveis nos computadores. 
Ao mesmo tempo em que aprende como usar estas ferramentas, é importante, e vamos convidá-los para isso, que você já comece a refletir sobre as mudanças que elas possibilitam na sua trajetória pessoal e profissional. Mas antes, sobre como elas já vêm afetando nosso mundo e sobre como devemos agir para ter algum controle sobre tais mudanças.
A chegada das Tecnologias de Informação e Comunicação (TIC) na escola nos traz desafios e problemas. As soluções vão depender do contexto de cada escola, do trabalho pedagógico que nela se realiza, de seu corpo docente e discente, de sua comunidade interna e externa, dos propósitos educacionais e das estratégias que propiciam aprendizagem.
Com isso, <REFLETIR1> reflita! </REFLETIR1>
<REFLETIR1> Você já havia pensado sobre esta questão? É possível educar com as TIC? Mas, como usá-las na sala de aula com propósitos educativos? Estamos diante de um problema ou de desafios? Que tal refletir um pouco sobre estas questões. Sugerimos que além de refletir, você possa discutir com outros professores, com os gestores escolares e com os alunos. É um bom começo, concorda?</REFLETIR1>
Precisamos compreender a realidade em que atuamos e planejar a construção dos novos cenários onde aprendemos, ensinamos, consumimos, enfim, onde vivemos e nos relacionamos. Não há só um caminho, nem uma só solução – ao contrário, há uma gama de possibilidades e poderemos até encontrar novas respostas para velhas perguntas. 

<GLOSSARIO1>São todas as ações que envolvem a formação e a preparação para a Inclusão Digital. Pode também ser entendida como os processos educativos que fazem uso da tecnologia digital. Em ambos os casos deve-se buscar, além de ensinar o uso da tecnologia, analisar para que utilizar a tecnologia. Isso inclui que cada aprendiz se perceba como autor (não apenas consumidor) de informação digital, o que requer domínio de técnicas específicas de interação e produção </GLOSSARIO1>

<GLOSSARIO2>
 É a promoção do acesso à informação que está digitalizada, ou seja, que está disponível através das tecnologias digitais.
Processos de inclusão digitais compreendem ações de ampliação do acesso a computadores conectados à Internet e de formação para o seu uso competente e autônomo, buscando participação emancipatória de todos os membros da sociedade. </GLOSSARIO2>

</TELA1>
 
<TELA2>

<FIGURA>imagem.jpg<ALT> Homem caminhando no rastro de um pincel gigante</ALT></FIGURA>

Nesta primeira unidade vamos iniciar esta reflexão, ao mesmo tempo em que vamos tomando contato com algumas destas novas ferramentas, compreendendo como interagir com elas, com suas interfaces, suas possibilidades, conceituando-as e nos apropriando da linguagem da área. Faremos leituras, assistiremos a vídeos, navegaremos em páginas da Internet, publicaremos nossas ideias num fórum virtual. Vamos também conhecer alguns bons casos de uso da tecnologia digital na escola. Muita coisa?! Não se preocupe, estamos juntos. 
Além desta reflexão e do contato inicial com o computador, nesta unidade vamos também iniciar o Projeto Integrado de Aprendizagem, que estruturará a maioria das nossas atividades durante todo o curso.
Reveja os <SAIBAMAIS>objetivos da Unidade 1</SAIBAMAIS>. É importante que ao final desta Unidade você faça uma autoavaliação a partir dos objetivos de aprendizagem propostos. Registre suas trajetórias, suas dificuldades, avanços e desafios. Esta pode ser uma estratégia importante para analisar a sua caminhada neste processo formativo.
E já que estamos tratando de objetivos, veja a imagem ao lado. É um bom momento para refletir sobre a sua trajetória como educador e possíveis caminhos que deseja construir!!! Agora é com você...

<SAIBAMAIS>

 Objetivos da Unidade 1, disponibilizados na Tela 1. É uma forma de reforçá-los e orientar à aprendizagem. 
Ao final desta unidade esperamos que você chegue a:
- Conceituar o que são tecnologias e  mídias.
- Compreender a necessidade de refletir sobre as questões que antecedem às decisões relativas à inserção das tecnologias na sua prática pedagógica, percebendo a diversidade e a complexidade destas questões 
- Formar uma ideia inicial a respeito das potencialidades de processamento de informação das tecnologias digitais.
- Familiarizar-se com os recursos mais básicos do computador:  uso do mouse e teclado, identificação dos itens do desktop e uso de editores de textos simples.
- Familiarizar-se com o uso dos fóruns de discussão e com a navegação em conteúdo da Internet. 
- Ampliar sua compreensão sobre as possibilidades de comunicação disponíveis com as TIC. </SAIBAMAIS>



</TELA2>
 
<TELA3>
<FIGURA>imagem.jpg<ALT> Dedo encostando no mouse </ALT></FIGURA>


As <GLOSSARIO4> tecnologias </GLOSSARIO4> são produto e meio da relação do homem com a  natureza. Vivemos em um cenário de grandes transformações sociais e econômicas. Estas transformações estão revolucionando nossos modos de produção, de comunicação e de relacionamento e estão produzindo um intenso intercâmbio de produtos e práticas socioculturais. Nesse contexto globalizado, as novas <GLOSSARIO5> mídias </GLOSSARIO5> e tecnologias invadem nosso cotidiano. 

Como devemos, então, proceder na escola para enfrentar os problemas e desafios que se nos apresentam? Essa é uma pergunta complexa. Para respondê-la precisamos entender melhor as relações entre tecnologia e sociedade e destas com a escola. Para tal propomos a realização da atividade 1.

<GLOSSARIO4> <TITULO> Tecnologia </TITULO>
 Vamos adotar a interpretação de Martinez (2006), segundo a qual a tecnologia é o “estado da arte” da técnica. Ainda segundo o autor, “a terminação logos, (tecno)logia indica interpretação, aplicação e/ou estudo da técnica e das suas variáveis. 

Pode também ser entendida como o conhecimento técnico acumulado, a capacidade ou a arte necessárias para projetar, investigar, produzir, refinar, reutilizar/re-empregar técnicas, artefatos, ferramentas, utensílios”.

A tecnologia permite “(...) criar, transformar e modificar materiais, recursos, insumos ou a natureza como um todo, o entorno social e o próprio homem”. </GLOSSARIO4>

<GLOSSARIO5> <TITULO> Mídia </TITULO>
[do inglês media] designa os meios ou o conjunto dos meios de comunicação: jornais, revistas, TV, rádio, cinema etc. </GLOSSARIO5>
</TELA3>
<TELA4>
Atividade 1: Tecnologias na escola e na sociedade
Esta  atividade se constitui, inicialmente, da leitura do texto que segue e da elaboração de um pequeno texto com a análise do cenário de inserção dos computadores no cotidiano pedagógico de uma escola. Ela é composta de três momentos:

<ATIVIDADE1a>Momento 1: Leitura do texto. </ATIVIDADE1a>
<ATIVIDADE1b>Momento 2: Elaboração dos seus textos. </ATIVIDADE1b>
<ATIVIDADE1c>Momento 3: Discussão presencial com seus colegas e formadores. </ATIVIDADE1c>





<ATIVIDADE1a>
	<TITULO>Atividade 1.1: Momento 1 – Leitura do texto. </TITULO>
           Enquanto estiver lendo, nós iremos lhe sugerindo uma série de momentos e questões para reflexão. Em cada um deles anote as ideias, questionamentos e dúvidas que forem surgindo. Isso vai ser importante no prosseguimento da atividade.  
           
          Convidamos você a iniciar a leitura do <ARQUIVO>Texto (01)<URL>texto1.pdf</URL></ARQUIVO>: <SAIBAMAIS>Por que precisamos usar a tecnologia na escola? As relações entre a escola, a tecnologia e a sociedade</SAIBAMAIS>, da Profa. Edla Ramos. 

            <SAIBAMAIS> O texto disponibilizado para leitura é uma adaptação de um outro bastante semelhante de autoria de Edla M. F. Ramos, que consta do livro recém publicado “Informática aplicada à aprendizagem da matemática”. Este livro foi escrito para o programa de Licenciatura em Matemática à Distância oferecido pela  Universidade Federal de Santa Catarina. A autora e a Coordenação do Curso autorizaram a sua inclusão neste material. </SAIBAMAIS>
</ATIVIDADE1a>

<ATIVIDADE1b>
<TITULO> Atividade 1.2:  Momento 2 – Elaborando o seu texto</TITULO>
<FIGURA>imagem.jpg<ALT>Mãos digitando no teclado </ALT></FIGURA>
Agora que você já terminou a leitura e já discutiu as idéias principais no fórum de discussão, pense se conhece algumas escolas que possuem laboratórios de informática. Elabore, então, em dupla (par) um pequeno texto descrevendo como o laboratório é utilizado. Considere os seguintes aspectos: 
<ENUM>Quem usa o laboratório? O que os alunos fazem no laboratório? Os alunos gostam de trabalhar com os computadores? 
Foi ou não criada uma disciplina de informática na escola? 
Que mudanças a chegada do laboratório trouxe para essa escola em geral? 
<SAIBAMAIS> Continue a construção do seu texto analisando o modo como a tecnologia está sendo utilizada nessa escola. </SAIBAMAIS></ENUM>
<LEMBRETE> Lembre-se! </LEMBRETE>

<LEMBRETE> Lembre-se: em caso de dúvidas, procure conversar com o seu formador ou procure colegas e constitua grupos de estudo, de reflexão e discussão presenciais. Isso consolida a sua formação e a parceria com a comunidade escolar. Quando sentir que as ideias discutidas estão amadurecidas, que tal abrir o debate com os alunos da sua escola e, se for o caso, com alunos de escolas circunvizinhas? É um bom momento para ampliar a sua formação para o coletivo social.  </LEMBRETE>

<SAIBAMAIS> Procure basear sua análise nas reflexões que a leitura do texto lhe proporcionou. Sinta-se livre para incluir o que julgar necessário na sua análise. Sugerimos considerar alguns aspectos:

<ENUM>O uso das TIC na escola conhecida está promovendo ou não a capacidade de ser críticos, criativos e “cuidantes” (como diz Leonardo Boff)? Por quê? 
Esse uso está promovendo ou não uma aprendizagem significativa e crítica? Por quê? </ENUM>


<FIGURA> imagem.jpg <ALT> Crianças usando o computador </ALT></FIGURA>

Se você não conhece nenhuma escola que já faça uso das TIC, deve então construir um pequeno texto com alguns parágrafos desenvolvendo alguma idéia ou questionamento que a leitura lhe suscitou. Ou se preferir e houver tempo e oportunidade, você poderia visitar uma escola próxima que possui esses recursos e entrevistando os seus professores e funcionários você poderia coletar as informações necessárias.
</SAIBAMAIS>
</ATIVIDADE1b>


<ATIVIDADE1c>

<TITULO> Atividade 1.3: Momento 3 – Discussão presencial com seus colegas e formadores </TITULO>
Após ter lido, refletido e ter expressado suas reflexões num texto, prepare-se para discutir com os seus colegas e formadores elegendo aspectos relevantes.

<FIGURA> Figura6web.jpg <ALT> Composição de mãos conectadas por rede de computadores</ALT> </FIGURA>

</ATIVIDADE1c>

</TELA4>
 
<TELA5>

<TITULO> Atividade 1.4: Refletindo com Vídeo </TITULO>
Nesta atividade você vai assistir alguns vídeos que estão disponíveis na Internet. 
Há hoje uma grande quantidade de documentos de vídeo na rede, e há um site em especial chamado <SAIBAMAIS>Youtube </SAIBAMAIS>, que permite que as pessoas publiquem suas produções em vídeo para divulgá-las. Há de tudo neste site, muita coisa sem nenhuma importância, mas também muito material de grande valia. Selecionamos alguns pra você assistir.
Assim, queremos lhe dar uma ideia inicial da potencialidade da nova linguagem midiática do vídeo digital, que é diferente do cinema e da televisão, e também do potencial da Internet como ferramenta de interação e compartilhamento. Queremos ao mesmo tempo, com o conteúdo selecionado, levar-lhes a refletir sobre aspectos diversos desta tão controversa relação entre tecnologia, escola e sociedade. Por fim, queremos também alertar-lhes para a importância que a escola tem ao definir o seu papel neste processo e que os seus profissionais preparem-se para assumi-lo. 
Após assistir aos vídeos sugeridos, você deve discuti-los com seus colegas e, em seguida, todos vão escolher um tema condutor que será depois desdobrado nos pequenos grupos para a realização dos seus projetos integradores de aprendizagem.
Clique <VIDEO> aqui </VIDEO> para ver as sugestões! 
<LEMBRETE> Lembre-se! </LEMBRETE>
<LEMBRETE> O formador vai ajudá-lo a acessar o site do Youtube, no endereço http://www.youtube.com (curioso o modo como estes endereços são escritos, não? Falaremos sobre isso mais adiante). Mas, é importante que tente, experimente, aprenda com acertos e erros. Portanto, antes de procurar o formador busque navegar sozinho ou solicite a ajuda do colega ao lado, ou de um aluno. Essa é uma experiência única!!! E você pode envolver os alunos nestas atividades, incluindo discussões importantes como a qualidade das informações disponibilizadas num site como o YouTube. Fica mais esta dica pedagógica!!! </LEMBRETE> 


<SAIBAMAIS> Visite o site: www.youtube.com </SAIBAMAIS>

<VIDEO>
Após ter acesso ao site do Youtube, você deve localizar cada um dos títulos dos vídeos abaixo e assisti-los:

- Criança – a alma do negócio: este é um trailler do documentário de Estela Renner e Marcos Nisti sobre publicidade, consumo e infância. Convida você a refletir sobre seu papel dentro deste cenário e sobre o futuro da infância.
- Viciado em world warcraft: é possível, literalmente, ficar viciado em um jogo de computador? Segundo os autores deste vídeo, é possível sim.
- Fases da Revolução Industrial: aula de História destinada a alunos do Ensino fundamental, produzida pela Profa. Alessandra Nóbrega.
- O impacto da tecnologia da informação na vida social: reportagem do canal Futura abrangendo diversos impactos das TIC nas nossas vidas. Tem um conteúdo mais otimista. 
- Ladislau Dowbor – Educação e tecnologia: parte inicial de uma longa entrevista à Rede Vida que argumenta que frente à explosão atual do universo do conhecimento e das tecnologias correspondentes, a escola tem de repensar o seu papel. A visão do entrevistado é que precisamos de uma escola um pouco menos lecionadora. Se desejar ver o restante da entrevista, ela está disponível, em várias partes, no site do Youtube.  </VIDEO>


</TELA5>
 
<TELA6>
<TITULO> Atividade 2: Projeto Integrado de Aprendizagem </TITULO>

Chegou a hora de você e sua turma escolherem o <SAIBAMAIS1> tema gerador </SAIBAMAIS1> dos seus <SAIBAMAIS2> projetos integrados de aprendizagem. </SAIBAMAIS2> Seu formador vai lhes orientar sobre esta atividade
Após a escolha do tema gerador por toda a turma, cada grupo deve definir a temática-foco do projeto de aprendizagem do grupo.
Você já deve ter ouvido falar em <SAIBAMAIS3> projetos de aprendizagem </SAIBAMAIS3> (ou na aprendizagem por projetos, ou ainda na pedagogia dos projetos). Trata-se de um método de trabalho pedagógico que foca a busca de soluções para problemas que o aluno escolhe investigar. Nesse processo de investigação, os conteúdos da aprendizagem são articulados e integrados ao desenvolvimento do projeto.
<SAIBAMAIS3>Há vários textos na Internet sobre projetos de aprendizagem. Recomendamos fortemente a leitura do texto preparado para dar base à programação da Tv Escola específica sobre pedagogia de projetos. O título é “Trabalhando com projetos”. O texto tem uma linguagem simples e, a partir de um conceito mais amplo do que é um projeto, acaba sugerindo ao final vários aspectos bem práticos sobre como planejar um projeto de aprendizagem. É uma adaptação do texto “Gestão de projetos”, presente no livro Gestão da Escola, do Programa de Melhoria do Desempenho da Rede Municipal de Ensino de São Paulo, uma iniciativa da Secretaria Municipal de Educação de São Paulo, em convênio com a Fundação Instituto de Administração da Universidade de São Paulo, 1999. Disponível no endereço:
  http://www.tvebrasil.com.br/salto/boletins2002/cp/texto1.htm
</SAIBAMAIS3>
Um projeto de aprendizagem precisa ter uma temática. Isto porque um projeto de aprendizagem é um projeto de investigação. E só podemos investigar algo se sabemos o que investigar. Na verdade só nos dispomos a verdadeiramente investigar algo se estamos curiosos, se realmente queremos ou precisamos do conhecimento que vai resultar daquele processo. Por isso, esperamos que a leitura e os vídeos que sugerimos tenham lhe proporcionado um turbilhão de reflexões e lhe instigado a querer saber mais. Então, o tema do seu projeto é justamente este campo de conhecimento onde você deve buscar a resposta daquilo que você quer saber. O tema não é “o que você quer saber”. O tema é a área que você deve investigar para chegar às respostas. Por exemplo, se queremos saber sobre “produção de vídeos nas séries iniciais da educação fundamental”, o tema poderia ser definido como “Mídias e Educação”. 

<SAIBAMAIS1> Um tema gerador é um tema que aglutina muitas perguntas pertinentes e interessantes. Barbosa (2004) nos sugere que ao fazer a escolha de um tema gerador, o ponto fundamental “diz respeito à motivação. O tema não deve ser assumido pelos alunos como imposição do professor, tampouco pode ser fruto de uma curiosidade circunstancial dos alunos. O tema gerador deve constituir-se em desafio, algo que mereça investimento de tempo e esforço cognitivo.” </SAIBAMAIS1>
<SAIBAMAIS2> Como todos os grupos de trabalho devem escolher um tema desdobrado do tema gerador, estamos chamando nossos projetos de “projetos integrados de aprendizagem”, uma vez que eles estarão integrados a partir deste único tema gerador. </SAIBAMAIS2>


</TELA6> 
<TELA7>

Chegou a hora de, no seu pequeno grupo de trabalho, escolher o tema-foco e fazer a problematização preliminar do seu projeto. O tema-foco deve ser desdobrado do tema gerador (é um subtema, podemos dizer) que o grande grupo já escolheu. Para poderem decidir, pensem em quais foram as dúvidas ou indagações que estiveram mais presentes enquanto vocês assistiam aos vídeos, ou durante a discussão. Essas dúvidas podem e devem estar relacionadas com o que vocês já ouviram, viveram e experimentaram em relação às tecnologias, profissional ou pessoalmente. 
Primeiro deixem suas ideias fluírem livremente. Anotem, simplesmente. Em seguida, organizem seu texto fazendo um roteiro que contemple: as perguntas iniciais do grupo e a sua problematização; uma justificativa de por que vale a pena tentar responder estas questões, jogando mais luz sobre tais dúvidas; e, se já tiverem alguma hipótese de resposta para as questões formuladas, podem também incluir no texto. 
É importante também já ir pensando no resultado do seu projeto. Essa produção final vai expressar o aprendizado que o grupo teve. “Projetos bem sucedidos, de forma geral, são definidos a partir do problema a ser resolvido e da clareza com que se define a solução do problema. O mais importante é definir com clareza os objetivos do projeto. Uma vez decidida a realização de um projeto, deve-se discutir exaustivamente como o problema pode ser resolvido e as características do resultado final, descritas nos objetivos do projeto ou em suas metas. Sempre que possível, o próprio título do projeto deve indicar as características do resultado final (...) Quanto mais tarde se deixa para realizar essas discussões e definições, mais difícil se torna a implementação do projeto.” (Salto para o futuro, 2002)

</TELA7>
 
<TELA8>
<TITULO> Atividade 2.1: Participação em fórum de discussões on-line: publicando e navegando.</TITULO>
Como você viu no início deste Curso, a ferramenta fórum que iremos utilizar faz parte do Ambiente Virtual e-Proinfo. O <SAIBAMAIS> e-ProInfo </SAIBAMAIS> é um ambiente virtual de aprendizagem colaborativo desenvolvido pela Secretaria de Educação a Distância (SEED) do Ministério da Educação (MEC) em parceria com algumas instituições de ensino como UFRS e PUC-SP. Permite a realização de cursos a distância ou a complementação de cursos presenciais, além de diversas outras formas de apoio ao processo de ensino-aprendizagem. 
Além da ferramenta fórum que vamos utilizar, o <LEMBRETE>ambiente </LEMBRETE> contém muitos outros recursos, como, por exemplo, o bate-papo, e-mail, o quadro de avisos, de notícias, a biblioteca. 
<LEMBRETE> Antes de termos acesso ao fórum, chamamos atenção ao fato de que é comum, no início do trabalho em rede, termos uma percepção restrita à nossa atuação no presencial, tentando fazer no virtual exatamente o que fazíamos em sala de aula e, quando não é possível, podemos nos frustrar. Para evitar esse problema, é muito importante que você ouse olhar o novo com curiosidade, criatividade! Esse é nosso convite para a atividade que será proposta, conecte-se com o “olhar de criança” que há dentro de cada um de nós e divirta-se com as novidades e aprendizagens que virão!</LEMBRETE>
Seu formador vai lhe auxiliar sobre como ter acesso ao fórum “Projeto Integrado de Aprendizagem”, que foi preparado para esta atividade no ambiente e-Proinfo. Chegando lá, você vai postar o texto elaborado na Atividade 3. Mas para poder publicar um texto num fórum ele precisa ser digitado. Então, vamos ao trabalho! O seu formador irá lhe orientar sobre todos os passos, que incluem:
<ENUM>
como fazer o seu <GLOSSARIO7>login </GLOSSARIO7> no ambiente e-Proinfo;
como ter acesso ao fórum; 
e como publicar o texto no fórum digitando-o primeiro. 
</ENUM>
Após terem publicado suas propostas de temática no fórum, naveguem pra conhecer e ler as propostas dos seus colegas. Notem que vocês podem comentar e fazer sugestões uns para os outros. Desse modo, estarão iniciando uma discussão eletrônica. 
Agora, <REFLETIR> reflita!</REFLETIR>
<REFLETIR> Que diferenças você percebe entre a discussão presencial e a discussão realizada no fórum? Conversem a respeito disto. Registrem suas conclusões num cartaz para publicar no corredor da escola. </REFLETIR>
<SAIBAMAIS> “Os cursos do e-ProInfo são de responsabilidade de Instituições Públicas cadastradas ou oferecidos pelo próprio MEC. Para cadastrar uma entidade – que deve ser obrigatoriamente uma instituição publica ligada ao governo federal, estadual ou municipal – basta entrar em contato com a equipe do e-ProInfo.” (CCUEC, 2006) </SAIBAMAIS>
<GLOSSARIO7> <TITULO> Login </TITULO>
O login é o processo de conexão a um serviço computacional. Para fazê-lo você deve se identificar fornecendo o seu nome de usuário e a sua senha. Assim o sistema poderá autorizar a seu direito de uso do serviço. O termo login é um termo em inglês e o seu oposto é logoff. </GLOSSARIO7>

</TELA8>

 
<TELA9>
             A partir de agora você é parte de um grupo, sendo co-responsável pelo desenvolvimento de determinado Projeto Integrado de Aprendizagem. Sabemos que o sucesso de atividades em grupo está relacionado à qualidade do vínculo e da comunicação que se estabelecem entre seus membros. Talvez você já esteja pensando que garantir a interação entre o grupo, no período após o encontro presencial, será um grande desafio. Afinal, cada membro possui inúmeros compromissos em horários distintos e há, ainda, a distância geográfica que limita a realização de encontros presenciais. 
Agora que vocês já debateram e escreveram sobre a temática do seu projeto integrado de aprendizagem, o que acham de publicar o texto que produziram para que sejam lidos e conhecidos por todos os colegas? Como você faria isto normalmente? Como vocês fazem com seus alunos quando querem que uns conheçam os trabalhos dos outros? Vocês pediriam que eles escrevessem em papel pardo, ou publicariam as folhas na forma de varais, ou em murais? Será que temos alternativas que ampliem as possibilidades destes procedimentos com os computadores?
 
<FIGURA> Figura7web <ALT> Estátua de um homem sentado com a mão apoiando o queixo</ALT> </FIGURA>

</TELA9>
<TELA10>


Para vislumbrarmos a solução desses desafios, cabe retomarmos o princípio de que usamos as tecnologias para superar limitações e ampliar nossas possibilidades! Assim, selecionamos uma ferramenta, denominada <GLOSSARIO6> Fórum </GLOSSARIO6>, para superar limitações de tempo e espaço e possibilitar o debate e a continuidade da produção do projeto, já iniciada pelo grupo. Essa ferramenta é bastante utilizada na Educação a Distância, modalidade que lida essencialmente com os desafios citados e tem como propósito facilitar a troca de ideias e a realização de debates entre grupos. Posteriormente, na Unidade 6, aprofundaremos as possibilidades didáticas de uso da ferramenta fórum. Mas, por ora, apenas aprenderemos e experimentaremos o seu uso.
A ferramenta fórum que iremos utilizar faz parte do Ambiente Virtual e-Proinfo. O e-ProInfo é um ambiente virtual de aprendizagem colaborativo desenvolvido pela Secretaria de Educação a Distancia (SEED) do Ministério da Educação (MEC) em parceria com algumas instituições de ensino como UFRS e PUC-SP. Permite a realização de cursos a distância ou a complementação de cursos presenciais, além de diversas outras formas de apoio ao processo de ensino-aprendizagem.



<FIGURA>figura.jpg<ALT>Tela do eproinfo</ALT></FIGURA>

<GLOSSARIO6> <TITULO> Fórum </TITULO>
Os fóruns são ferramentas de comunicação da rede Internet que permitem a discussão de um grupo de pessoas em torno de um tema. O debate acontece através do envio de mensagens por escrito. Estas ficam à disposição dos participantes para leitura e comentários, dando assim continuidade ao diálogo. </GLOSSARIO6>
</TELA10>

 
<TELA11>
<TITULO> Texto (02): Computador! Que máquina é essa?  </TITULO>

Até agora você já experimentou de várias formas o computador. Já navegou na Internet, assistiu a vídeos, digitou textos (usou o mouse e o teclado) e participou de um fórum de discussões virtual e até de chat. Então, após esse contato bem mais de perto com o computador, vamos tentar entendê-lo melhor!

Será que isto é muito difícil? Você já deve ter se perguntado como será que esta máquina poderosa funciona? Bom, mais do que saber como ela funciona, queremos é aprender a utilizá-la, e vamos tratar disso com muito mais ênfase nesse curso. Afinal de contas usamos várias máquinas e não sabemos exatamente como elas funcionam. Mas para usá-las bem, precisamos ter uma ideia geral de quais são os seus componentes, para que eles servem, que cuidados devemos tomar na sua operação e manutenção.
<FIGURA>computador.jpg <ALT>Um computador, composto por gabinete, monitor, caixas de som, teclado, e mouse</ALT> </FIGURA>

<ANIMACAO> Veja a animação. </ANIMACAO>

<ANIMACAO> ANIMAÇÃO COMPUTADOR  animacao.html</ANIMACAO>

<DESTAQUE> Então ao olhar para o microcomputador que está na sua frente, tente imaginar:

Quantas coisas podem ser feitas com ele?

O que você gostaria de aprender a fazer?

Como posso melhorar os processos de ensino e de aprendizagem utilizando o computador?</DESTAQUE>


Agora, realize a <ORIENTACAO> atividade 3 </ORIENTACAO>


<ORIENTACAO> Atividade 3: Refletindo sobre o computador

           Ao ler esta seção e assistir à animação de apresentação sobre os componentes de um computador, vá anotando suas dúvidas e as dificuldades que você vai enfrentando para compreendê-lo e, ao final, se você achar necessário, você pode sugerir ao seu formador um debate para discutir a respeito. Você e o grupo poderiam analisar qual seria a melhor forma de fazer a discussão (se num outro fórum, ou se presencialmente). Pode ser um momento importante para socializar com os colegas os limites e as possibilidades desta tecnologia. </ORIENTACAO>

</TELA11>
<TELA12> 

            <DESTAQUE> Para que possamos entender preliminarmente como funciona o computador, precisamos compreender que o que ele faz é, basicamente, processar informações. </DESTAQUE>

Estas informações podem ser dados, textos, imagens, sons etc. Tal processamento inclui também a realização de cálculos e a execução de instruções sobre o que fazer com a informação. Vamos dar alguns exemplos:
	<ENUM>Suponhamos que um confeiteiro que trabalha em casa queira anunciar a venda de seus bolos e sobremesas pela Internet. Então, ele manda fazer uma página onde ele publica fotos e descrição dos bolos, vídeos de eventos dos seus clientes, preços dos produtos, formulário para encomendas etc. Quando alguém preenche este formulário informando quais produtos deseja adquirir, o computador calcula automaticamente o orçamento daquele pedido, isto porque ele já tem todas as informações necessárias: os preços, as quantidades e as instruções de como fazer o cálculo. </ENUM>

             No exemplo dado, o último tipo de informação é muito importante: esses conjuntos de instruções que orientam os computadores sobre como proceder para fazer o processamento da informação são chamados de <GLOSSARIO8> programas </GLOSSARIO8>.  O computador precisa ser orientado sobre como proceder.

<GLOSSARIO8> 
<TITULO>
Programas
</TITULO>
Os programas também são chamados de software. Em contraposição ao termo software, termo em inglês que inicia com palavra soft, que significa leve, existe também o termo hardware, que denota a parte física do computador (pesada)
 </GLOSSARIO8>


<CITACAO> “Os programas instalados determinam o que o micro “saberá” fazer. Se você quer ser um engenheiro, primeiro precisará ir à faculdade e aprender a profissão. Com um micro não é tão diferente assim, porém o “aprendizado” não é feito através de uma faculdade, mas sim através da instalação de um programa de engenharia [...] Se você quer que o seu micro seja capaz de desenhar, basta “ensiná-lo” através da instalação um programa de desenho, como o Corel Draw! e assim por diante” (MARIMOTO, 2007). </CITACAO>

</TELA12>

 
<TELA13>
 Para fazer este processamento, os computadores, sejam quais forem, contam com Unidades Centrais de Processamento, que são informalmente chamadas de <GLOSSARIO9> processadores </GLOSSARIO9> (ou CPU). Os processadores são, vamos dizer, o cérebro dos computadores. Alguns são mais rápidos, os mais modernos em geral. Para entender melhor, se usarmos a cozinha como metáfora, diríamos que a informação seria o alimento e o processador seria o fogão. Mas você precisa mais do que o fogão numa cozinha, é preciso que os ingredientes e utensílios sejam estocados e preparados, que alguém controle o cozimento, que alguém decida o que e como cozinhar, que a comida pronta seja guardada etc. 

<GLOSSARIO9>
<TITULO>
Processadores
</TITULO>
 “Existem no mercado vários modelos de processadores, que apresentam preços e desempenho bem diferentes... Quando vamos comprar um processador, a primeira coisa que perguntamos é qual sua frequência de operação, medida em Megahertz (MHz) ou milhões de ciclos por segundo, frequência também chamada de clock...” (MARIMOTO, 2007)
</GLOSSARIO9>
O armazenamento da informação (antes e após o processamento) acontece nas unidades de armazenamento. Elas são os nossos depósitos de informação (nossos armários ou geladeiras).
 	A velocidade de trabalho dos processadores é infinitamente maior do que a busca e o retorno das informações às <GLOSSARIO10> unidades de armazenamento. </GLOSSARIO10> Isso porque o processador funciona eletronicamente, ele só entra em ação quando conectamos o computador à rede elétrica, já as unidades de disco são operadas mecânica e magneticamente e isso é bem mais lento. 

<GLOSSARIO10><TITULO>Unidades de Armazenamento</TITULO>São vários os dispositivos de armazenamento. O mais comum nos computadores atuais é o disco rígido (HD-hard disck), que fica interno ao computador e consegue armazenar grandes quantidades de dados. Você não vê esse disco. Em geral há apenas um led  (pequena luz) na frente do gabinete do computador) que é aceso quando este disco está sendo acionado. Como ele é interno ao computador, ele não serve para o transporte dos seus dados de um computador para outro, para fazer isso você precisa das unidades chamadas de flexíveis (em oposição a rígido): são os pen-drives, os CD e DVD.</GLOSSARIO10>
            Imagine uma cozinha com um superfogão, mas com uma despensa pouco prática, de modo que o cozinheiro tenha que esperar muito para que os ingredientes cheguem até ele. Pra resolver este problema existe a <GLOSSARIO11> memória principal </GLOSSARIO11>. Esta memória são como as bancadas de trabalho da nossa cozinha. Nela a informação fica prontamente à disposição do processador. O acesso a ela é bem mais rápido do que às unidades de armazenamento, é que ela também opera eletronicamente. Então, quando dizemos que temos um computador com pouca memória, temos um problema, pois nosso computador terá dificuldades para executar alguns programas. A memória é bem diferente das unidades de armazenamento também num outro aspecto. Apesar de se chamar memória, a informação só fica ali armazenada por pouco tempo, como se fosse uma memória de curto termo. Ao ser desligado o computador, toda a informação ali contida é perdida. Por isso, antes de desligar a máquina precisamos sempre cuidar de gravar (salvar) o que já produzimos numa unidade de armazenamento permanente (disco rígido ou CD). 

<GLOSSARIO11><TITULO>Memória</TITULO>Memória foi inicialmente um conceito bastante amplo, referia-se a qualquer dispositivo que permitisse a recuperação de informações (confundindo-se assim com o conceito de dispositivo de armazenamento). Atualmente o que chamamos de memória é o dispositivo que armazena os dados diretamente para o processamento. Ele também é interno ao computador (localiza-se na placa-mãe).  Ao comprar um computador, além de checar a velocidade do processador é preciso também conferir a capacidade do disco rígido e a capacidade da Memória. Estas capacidades são atualmente medidas em Gygabytes (GB).; os Bytes são medidas de quantidade de informação. Para saber mais sobre isso sugerimos que você leia as páginas:
	http://www.infowester.com/bit.php
	http://www.interney.net/intranets/?p=9755282
	http://pt.wikipedia.org/wiki/Bytes
</GLOSSARIO11>


</TELA13>
<TELA14>

<DESTAQUE> Como já foi dito, podemos então afirmar que a configuração geral de qualquer computador é formada por cinco componentes básicos: <IMAGEM DE PROCESSADOR.JPG> o processador </IMAGEM DE PROCESSADOR.JPG>, <IMAGEM DE MEMÓRIA RAM.JPG> a memória </IMAGEM DE MEMÓRIA RAM.JPG >, < IMAGEM DE UNIDADE DE ARMAZENAMENTO HD.JPG> as unidades de armazenamento </IMAGEM DE UNIDADE DE ARMAZENAMENTO HD.JPG >, < IMAGEM DE PROGRAMAS.JPG> os programas </IMAGEM DE PROGRAMAS.JPG >, e por fim, os <IMAGEM DE DISPOSITIVOS DE ENTRADA E SAÍDA.JPG > dispositivos de entrada e saída. </IMAGEM DE DISPOSITIVOS DE ENTRADA E SAÍDA.JPG > </DESTAQUE>

Na categoria de dispositivos de entrada e saída de dados, situa-se tudo o que usamos para entrar ou para visualizar as informações no computador. Aí temos como mais usados o teclado, o mouse e o monitor de vídeo; sem esses, em geral, não conseguimos fazer nada com o computador. Há outros ainda: as impressoras, os microfones, as câmaras fotográficas e filmadoras, os scanners, as mesas digitalizadoras etc. Os dispositivos citados são também conhecidos como periféricos, uma vez que eles são externos e, em geral, fazem a comunicação entre as pessoas e a máquina. Mas existe também uma outra categoria de dispositivos de entrada e saída que estão mais internos e preparam os dados para o processador: são as placas de vídeo, som etc.

          Está curioso sobre mais algum aspecto dos computadores e a pergunta está aí dando voltas na sua cabeça? Não perca a chance de aprender mais, fale com o seu formador e pergunte. Mas também converse com seus colegas e até com seus alunos sobre as questões tratadas aqui. 


</TELA14>
<TELA15>
<TITULO> Atividade 3.1: Experimentando os dispositivos do computador </TITULO>

Os conhecimentos adquiridos acerca dos principais dispositivos de um computador são muito úteis no momento de comprá-lo. Que tal exercitar essa habilidade? 

Os anúncios apresentados abaixo foram extraídos de uma loja na Internet. Com base nessas informações, qual notebook você escolheria comprar? Qual computador apresenta a melhor configuração de processador, memória e armazenamento (disco rígido)?

<FIGURA> <ALT> Computadores com legenda ao lado sobre anúncios </ALT>imagem.jpg</FIGURA>


</TELA15>
 

<TELA16>

<TITULO> Texto (3): Linux! Que sistema operacional é esse? Sistema Operacional? </TITULO>

           Você notou alguma diferença entre os computadores usados para a realização deste curso e os que comumente vemos em outros lugares? Já conversou sobre isto com seus colegas?

Os computadores empregados durante este curso estão usando (também se diz rodando ou executando) o sistema operacional <GLOSSARIO12> “Linux” </GLOSSARIO12>. Já os computadores que vemos na maioria dos lugares usam outro sistema operacional, o sistema <GLOSSARIO13>Windows </GLOSSARIO13>. Os laboratórios montados pelo Proinfo Integrado constituem programas governamentais de uso de software livre e utilizam o sistema operacional Linux Educacional, desenvolvido especialmente para uso de professores, gestores e alunos da rede pública de ensino. O desenvolvimento do Linux Educacional teve como premissa básica a customização (adequação) do ambiente computacional às necessidades educacionais, com aplicativos de produtividade, diversos conteúdos multimidiáticos (Portal do Professor, TV Escola, Rived, Domínio Público, dentre outros). 
<SAIBAMAIS> Saiba Mais! </SAIBAMAIS>

<SAIBAMAIS> Busque mais informações sobre Linux nos endereços: http://pt.wikipedia.org/wiki/Movimento_software_livre#Movimento_software_livre ou http://www.softwarelivre.gov.br/ </SAIBAMAIS>

<DESTAQUE>

O sistema operacional é um programa (software) que entra em funcionamento assim que o computador é ligado. “Ele gerencia todo o funcionamento do computador, inclusive a entrada e saída de dados [...] ele também oferece uma interface para interação das pessoas com o computador.” (SALES et al., 2007, p.23). É o principal programa do computador, ele define a estrutura básica sobre a qual vamos desenvolver todas as nossas atividades e sobre a qual todos os outros programas (editores de texto, navegadores de Internet) vão ser executados.

</DESTAQUE>
<GLOSSARIO12>

<TITULO> Linux </TITULO>
<FIGURA>Imagem da área de trabalho do Linux educacional.JPG<ALT> Imagem da área de trabalho do Linux educacional</ALT></FIGURA> Linux: é um sistema operacional, um software livre, com distribuição gratuita, que nasceu de um projeto de Linus Benedict Torvald. O nome Linux surgiu da mistura de Linus + Unix. Para saber mais sobre a história do Linux acesse a Wikipedia http://pt.wikipedia.org/wiki/Linux
</GLOSSARIO12>




<GLOSSARIO13> <TITULO> Windows </TITULO>
 Windows: é um sistema operacional proprietário, foi desenvolvido pela empresa multinacional de softwares dos EUA chamada de Microsoft Corporation, fundada em 1975 por Bill Gates e Paul Alle.
 </GLOSSARIO13>

          Após navegar no site, selecione informações relevantes e registre-as para discussão no próximo encontro presencial do Curso ou sugira ao seu formador a criação de um fórum para que sua turma discuta as impressões apreendidas nesta etapa do estudo. É importante entender criticamente a diferença entre software livre e proprietário. Se tiver oportunidade pense em discutir também com seus alunos sobre esta temática tão relevante. 

</TELA16>
<TELA17>

           Sobre isso é importante destacar que quando produzimos nossos trabalhos num sistema operacional, temos algumas dificuldades em transportá-los para computadores com outro sistema. Os programas que rodam num e noutros em geral apresentam incompatibilidades, embora as novas versões tenham reduzido significativamente essas dificuldades. Então, por exemplo, se você produziu um texto digital com um editor que roda sobre o Linux, vai precisar fazer algumas adaptações para poder transportá-lo para um computador que trabalhe com o sistema Windows. 
Diante disso, <REFLETIR> reflita! </REFLETIR>
<REFLETIR> Então, se você está se perguntando sobre por que usar um sistema diferente da maioria dos outros computadores, a sua pergunta é procedente. </REFLETIR>

Na verdade, a disseminação do uso de sistemas diferentes com as suas incompatibilidades traz problemas para nós, os usuários dos computadores. Mas precisamos analisar melhor esta questão.
Para que a compreendamos temos que entender a questão do software proprietário e do software livre. No primeiro caso, temos as empresas de desenvolvimento de software em geral que, como toda empresa, cobra pelo produto que desenvolve e distribui. Mas, em se tratando de produtos software há grande polêmica sobre os preços cobrados. As grandes fortunas que rapidamente se formam com a venda destes produtos demonstram, por um lado, a importância que os mesmos representam para a economia mundial e para a vida de todos nós e, por outro, o caos do processo regulatório da composição e definição destes preços. Por outro lado, a facilidade com que esses produtos podem ser duplicados (é muito fácil conseguir uma cópia de um programa de computador, basta fazer uma cópia de um CD), combinada com o nível proibitivo dos seus preços para a maioria da nossa população, geraram um mercado ilegal, o da pirataria de software, e a prática controversa da distribuição de cópias através das redes de contatos pessoais. 

</TELA17>


 
<TELA18>

Dentro deste contexto polêmico surgiu um grande movimento de redes de produção e distribuição de software: o movimento do software livre. Este movimento é fundamentado por quatro princípios que caracterizam um programa como livre. São eles a liberdade para: 
	“(0) executar o programa para qualquer propósito; 
	(1) estudar seu código fonte e adaptá-lo para que se comporte como desejado; 
	(2) copiá-lo e distribuí-lo da forma que foi recebido; e 
	(3) melhorá-lo e distribuir as modificações.” (OLIVA, 2009)
Estes princípios oferecem “intrinsecamente a liberdade necessária para a real e efetiva apropriação do conhecimento da tecnologia, uma vez que não impõem restrições no uso das ferramentas – tampouco a sua replicação para o uso doméstico ou em qualquer outro computador – possibilitando assim a livre experimentação dos recursos.” (TORRESINI, em preparação). Por isso eles definem também um método de trabalho na produção de software, um método mais horizontal, colaborativo e baseado nas relações de confiança interpessoal. “Nota-se, nas comunidades desenvolvedoras e usuárias de software livre uma forte componente de atitude colaborativa e de compartilhamento de informações para benefício de todos os interessados. Ou seja, há uma ética que permeia as trocas interpessoais nessas comunidades. Esta ética é a nosso ver aquela que deveria também orientar a construção dos valores e das trocas nas comunidades envolvidas com iniciativas educacionais.” (TORRESINI, em preparação).
</TELA18>
<TELA19>
O atual Governo Federal reconhece também a importância de direcionar esforços para a difusão do uso desse tipo de programa de computador. Esses esforços incluem desde o apoio para o desenvolvimento destes softwares até a formação profissional para o seu uso. O desenvolvimento do Linux Educacional e o seu uso – neste curso – fazem parte destes esforços. 

       Ficou então entendido por que o Linux Educacional está sendo usado neste curso? Se você quiser saber mais sobre software livre e sua importância clique <SAIBAMAIS>aqui</SAIBAMAIS>:

<SAIBAMAIS>
<TITULO>
Software Livre
</TITULO>
 Veja os sites:
http://pt.wikipedia.org/wiki/Software_livre
http://br-linux.org/faq-softwarelivre/

Ou assista aos vídeos disponíveis em:
http://www.youtube.com/watch?v=UvWRhnc_77Y 
http://www.youtube.com/watch?v=IJrfcQq_eIw
http://www.softwarelivre.gov.br/
 </SAIBAMAIS>
</TELA19>
<TELA20>
<TITULO>
Concluindo
</TITULO>
Nesta unidade, reconhecemos a grande importância das tecnologias em nossas vidas e começamos a compreender a necessidade de cada vez mais refletirmos e buscarmos alternativas para a inserção das TIC na nossa prática político-pedagógica. Você teve seu primeiro contato com o computador e fez diversas atividades (navegou na Internet, assistiu a vídeos, respondeu a questionários, participou de jogos e discussões virtuais) que lhe ajudaram a formar uma ideia do que é possível fazer com ele; para isso familiarizou-se com o mouse e o teclado, utilizou os recursos básicos da digitação de um texto. Nas próximas unidades você irá conhecer mais e melhor todos estes recursos. 
Você deu a largada para o mundo da informática! Como se sente agora? Apesar de dúvidas e dificuldades, falta de destreza na leitura das telas e no uso do mouse, “no nome das coisas”, você avançou! Que tal pensar no que isso significa no momento e no que significará no futuro? Você está enfrentando o desafio da inclusão digital e social. É hora de continuar sua caminhada. 
Na Unidade 2 você navegará na rede mundial de computadores e pesquisará sobre temas do seu interesse.

<DIARIODEBORDO> Diário de Bordo</DIARIODEBORDO>


<DIARIODEBORDO>É tempo de Diário de Bordo: 

Ao final de cada Unidade deste Curso, é importante que você registre as suas impressões, dificuldades, avanços e desafios enfrentados em sua travessia neste processo de inclusão digital. Não esqueça: o seu formador, além de parceiro, é seu companheiro nesta caminhada. Converse com ele sobre a escrita do Memorial e discuta com os seus colegas estratégias para elaboração desta atividade. Ao final do Curso, você disporá de um importante documento de estudo, pesquisa e reflexão. Bom trabalho!!! Agora é com você... 
</DIARIODEBORDO>

<BIBLIOGRAFIA> Referências </BIBLIOGRAFIA>

<BIBLIOGRAFIA> Referências 

BARBOSA, Eduardo Fernandes et al. Inovações pedagógicas em educação profissional: uma experiência de utilização do método de projetos na formação de competências. Boletim Técnico do SENAC: a revista da educação profissional. Rio de Janeiro, v. 30, n. 2, não paginado, maio/ago. 2004. Disponível em: <http://www.senac.br/informativo/BTS/302/boltec302d.htm>.  Acesso em: 2 jun. 2009.


BAUMAN, Zygmunt. Globalização: as conseqüências humanas. Rio de Janeiro: J. Zahar, 1999. 

D\'AMBROSIO, Ubiratan; BARROS, J. P. D. Computadores, escola e sociedade. São Paulo: Scipione, 1988. 


DAVIS, Claudia; OLIVEIRA, Zilma. Psicologia da educação. São Paulo: Cortez, 1991.


FONSECA, Renata Almeida. e-ProInfo: o ambiente de aprendizagem virtual do MEC. Boletim EAD (on-line), Campinas, n. 79, 1 fev. 2006. Disponível em: <http://www.ccuec.unicamp.br/ead/index_htmlfoco2=Publicacoes/78095/852295&focomenu=Publicacoes>. Acesso em: 2 jun. 2009.


ILLICH, Ivan. Convivencialidade. Lisboa: Publicações Europa-América, 1976. 


MARTINEZ, Vinícius Carrilho. Conceito de tecnologia.  Disponível em: <http://www.gobiernoelectronico.org/?q=node/4652>. Acesso em: 2 jun. 2009.


MORIMOTO, Carlos E. Hardware, manual completo. [S.l.]: GDH Press, 2002. Disponível em: <http://www.gdhpress.com.br/hmc/leia/index.php?p=intro-3>. Acesso em: 2 jun. 2009.


_______. Hardware, o guia definitivo. [S.l.]: GDH Press, 2007. Disponível em: <http://www.gdhpress.com.br/hardware/leia/index.php?p=intro-3>. Acesso em: 2 jun. 2009.


MORIN, Edgar. Os sete saberes necessários à educação do futuro. Brasília: UNESCO, 2000.


OLIVA, Alexandre. Síndrome de Peter Pan Digital. Revista Espírito Livre, Liberdade e Informação, [S.l.], n. 1, p. 9-10, abr. 2009. Disponível em: <http://www.revista.espiritolivre.org/?page_id=59>. Acesso em: 3 jun. 2009.


PAPERT, Seymour. A máquina das crianças. Porto Alegre: Artes Médicas, 1994.


SALES, Marcia B. et al. Informática para a terceira idade. Goiânia: R&F, 2007.


SALTO PARA O FUTURO. Trabalhando com projetos: texto básico para a discussão de todos os programas da série. [S.l.]: TVE Brasil, 2002. Texto base para a série de programas Cardápio de projetos, de 2002. Disponível em: <http://www.tvebrasil.com.br/salto/boletins2002/cp/texto1.htm>. Acesso em: 3 jun. 2009.


SILVEIRA, Sérgio Amadeu da. Exclusão digital: a miséria na era da informação. São Paulo: Fundação Perseu Abramo, 2001.


TORRESINE, Ederson. Software livre como alternativa ética para a informática na educação brasileira. (Em preparação, direitos de uso cedidos pelo autor)

VALENTE, José Armando (Org.). O computador na sociedade do conhecimento. [Brasília]: Mistério da Educação, 1998. (Informática para a mudança na educação, 2).
</BIBLIOGRAFIA>


</TELA20>


</UNIDADE1>
         
 


';

echo "<pre>";

	
$unit = new Unidade($conteudo);




echo "</pre>";

class Unidade{
  var $telas = array();
  var $titulo;
  
  function Unidade($conteudo){
  	
	$aux = preg_match_all("/<UNIDADE(.*?)>(.*?)<TITULO>(.*?)<\/TITULO>(.*)<\/UNIDADE(\\1)>/is",$conteudo,$retorno);	
	//var_dump($retorno);
	$unidade = $retorno[4][0];
	$tituloUnidade = $retorno[3][0];
	
	// divide a unidade em telas e extrai o titulo
	$aux = preg_match_all("/<TELA(.*?)>(.*?)<\/TELA(\\1)>/is",$unidade,$retornoTelas);		
	$telas = $retornoTelas[2];	
	$this->parse_telas($telas, $retornoTelas[1], $tituloUnidade);		
	//var_dump($telas);
	//$this->titulo= str_replace($retornoTelas[0],'',$unidade);	
  }
  
  // para cada tela, extrai os elementos contextuais
  //
  
  function parse_telas($telas, $telasindex, $tituloUnidade){
  
  echo 'parse telas';
	$nroTela = 0;  
  	foreach($telas as $tela){
		$nroTela++;
	
		$tela = $this->parse_titulos($tela, $titulos);
		$tela = $this->parse_figuras($tela, $figuras);
		$tela = $this->parse_arquivos($tela, $arquivos);
			
	//	$tela = $this->parse_destaques($tela, $destaques);
	//	$tela = $this->parse_citacoes($tela , $citacoes);	
	//	$tela = $this->parse_orientacoes($tela, $orientacoes);		
		$tela = $this->parse_enums($tela, $enums);		
//	
//		$tela = $this->parse_diario_de_bordo($tela , $diarios);
//		$tela = $this->parse_orientacoes($tela , $orientacoes);	
//	
//		$tela = $this->parse_saibamais($tela , $saibamais);
//	
//		$tela = $this->parse_atividades($tela, $atividades);
		
		
		$tela = $this->parse_tags_divs($tela,$nroTela,$js, $lateral);
		
		//	var_dump($foundedDivs); die();
			
			
		
		
		$tela = $this->parse_atividades($tela,$nroTela , $atividades);
		
		
		
	//	echo 'gravando'.$js;
		$file = file_get_contents("templates_eproinfo/templateTelas.html");		
		
		$file = str_replace("{js}",$js,$file);
		
		//var_dump($js); die();
		$tela = preg_replace("(\n|\r)","<br>",$tela);
		
		
		$aux = 1;
		while($aux != 0){
			$aux = preg_match_all("/<br><br>/",$tela, $retorno);		
		
			var_dump($aux);
			$tela = preg_replace("/<br><br>/","<br>",$tela);
			
		}
		$file = str_replace("{conteudo}",$tela,$file);
		
		$file = str_replace("{titulo}",$tituloUnidade,$file);
		
	
		
		
		$file = str_replace("{lateral}",$lateral,$file);
		
		//var_dump( $tela);
		file_put_contents("templates_eproinfo/pg". $nroTela.".html"  ,$file);		
	}
  }
  
  
  function parse_titulos($tela, &$titulos){
  	$tela = preg_replace("/<TITULO(.*)>(.*?)<\/TITULO(\\1)>/is", '<b>\\2 </b>',$tela);	
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
	
	$tela = preg_replace("/<FIGURA(.*)>(.*?)<ALT>(.*?)<\/ALT>(.*?)<\/FIGURA(\\1)>/is","<span id=\"imagem\"><img src=\"\\2\" alt=\"\\3\" /></span>\\4",$tela);				
	foreach($retorno[0] as $figura){		
		$url = $retorno[2];	
		$alt = $retorno[3];			
		$figuras.= "<img src=\"".$url."\" alt=\"".$url."\"  />";
		//echo( $tela);	
	}
	return $tela;
}
  
function parse_arquivos($tela, &$arquivos){  
  /*
<ARQUIVO> 
   chamada pra arquivo
</ARQUIVO>
<ARQUIVO> 
   <URL>nome_do_arquivo.pdf</URL>
</ARQUIVO>
  */  
  //BUSCA chamadas
    $aux = preg_match_all("/<ARQUIVO(.*)>(.*?)<URL>(.*?)<\/URL>(.*?)<\/ARQUIVO(\\1)>/is",$tela, $retorno);	
	foreach($retorno[0] as $arquivo){		
		$url = $retorno[7];	
		$tela = preg_replace("/<ARQUIVO(.*)>(.*?)<URL>(.*?)<\/URL>(.*?)<\/ARQUIVO(\\1)>/is","<a href=\"\\3\">\\2</a>",$tela);				
		$arquivos[sizeof($arquivos)] = $arquivo;
		//echo( $tela);	
	}
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
				$enums = split("(\n|\r)",$enum);
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
		$tela = preg_replace("/<ATIVIDADE(.*?)>(.*?)<\/ATIVIDADE(\\1)>(.*?)<ATIVIDADE(\\1)>(.*?)<\/ATIVIDADE(\\1)>/is","<a href=\"javascript:void(0);\" onClick=\"window.open('t".$nroTela."atividade\\1.html','atividade\\1','menubar=1,resizable=1,width=350,height=250');\">\\2</a>\\4",$tela);
		
	
		if($aux >0){	echo 'atividades';var_dump($retorno);}
		// para cada atividade encontrada cria a devida pagina.html
		//foreach($retorno as $atividade){						
	
			$conteudoDaAtividade = 	$retorno[6][0];	
			$js='';
			$conteudoDaAtividade = $this->parse_tags_divs($conteudoDaAtividade,$nroTela,&$js);	
			$file = file_get_contents( "templates_eproinfo/templateAtividades.html");		
			$file = str_replace("{conteudo}",$conteudoDaAtividade,$file);		
			$file = str_replace("{titulo}",$titulo,$file);
			file_put_contents("templates_eproinfo/t".$nroTela."atividade". $retorno[1][0].".html",$file);
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
		'BIBLIOGRAFIA');
		
		echo 'javasc'.$js;
		foreach($tags as $tag){ 
			$tela =$this->parse_tag_popupdiv($tag,$tela,$nroTela ,$retorno);
			var_dump($retorno);		
			foreach($retorno as $item ){
			//	if ($item) { 
					echo 'item'.$item[0].$tag;
					$found = array($item[0], $tag);
					array_push($foundedDivs, $found );
					$js .= "  j(\"#t".$nroTela.$tag.$item[0]."\").createDialog({ addr:'t".$nroTela.$tag.$item[0].".html', bg: '#000', opacity: 0.9 });\n
					 j(\"#t".$nroTela.$tag.$item[0]."ico\").createDialog({ addr:'t".$nroTela.$tag.$item[0].".html', bg: '#000', opacity: 0.9 });\n 
					 j(\"#t".$nroTela.$tag.$item[0]."txt\").createDialog({ addr:'t".$nroTela.$tag.$item[0].".html', bg: '#000', opacity: 0.9 });\n";	
					
										
					echo 'javasc'.$js;
					$lateral .= '<tr>
				 <td width="30%"><div id="t'.$nroTela.  $tag.$item[0].'ico"><img src="icones_gif/' .$tag.'.gif" alt="'.  $tag.'" width="30" height="30"  /></div></td>
				 <td width="70%"><div id="t'.$nroTela.  $tag.$item[0].'txt"> '.ucfirst(trim($item[1])).' </div></td>
			   </tr>
			   <tr>
				 <td colspan="2"><img src="barra_lateral.png" width="145" height="11" /></td>
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
	//	echo 'achou '. $aux . ' '. $tag;
	
		//echo $tag. "/<".$tag."(.*)>(.*?)<\/".$tag."(\\1)>(.*?)<".$tag."(\\1)>(.*?)<\/".$tag."(\\1)>/"; var_dump($retorno);
		if ($aux!=0){
		
			if ($aux ==1 ){
				$conteudo = 	$retorno[6][0];		
				$titulo = 	ucfirst(trim($retorno[2][0]));	
				$file = file_get_contents("templates_eproinfo/templatePopup.html");		
				$file = str_replace("{conteudo}",$conteudo,$file);
				$file = str_replace("{titulo}",$titulo,$file);
				file_put_contents("templates_eproinfo/t".$nroTela.$tag. $retorno[1][0].".html"  ,$file);
				//if ($retorno[1][0]==null){ $retorno[1][0] =1; }
				$aux = array( $retorno[1][0] , $titulo);
				$processados[sizeof($processados)] = $aux;
				echo ' retornando' ; var_dump($retorno[1][0]);
				echo 'gravando ' . $tag . ' '. $retorno[2][0];	
				
				
			}else{
			//echo 'acho varios';
			//var_dump($retorno);
				foreach($retorno as $elemento){				
					$conteudo = 	$elemento[6];	
					$titulo = 	ucfirst(trim($elemento[2]));	
					$file = file_get_contents( "templates_eproinfo/templatePopup.html");		
					$file = str_replace("{conteudo}",$conteudo,$file);
					$file = str_replace("{titulo}",$titulo,$file);
					file_put_contents("templates_eproinfo/t".$nroTela.$tag. $elemento[1].".html"  ,$file);					
				//	if ($elemento[1]==null){ $elemento[1] =1; }
					$processados[sizeof($processados)] = $elemento[1];					
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
