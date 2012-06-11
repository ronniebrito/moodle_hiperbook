<?php
require_once('../../../config.php');
require_once('../lib.php');

$id         = required_param('id', PARAM_INT);

if (!$cm = get_record('course_modules', 'id', $id)) {
    error('Course Module ID was incorrect');
}
//$db->debug = true; 
$bookid = $cm->instance;

$metadata = get_record('hiperbook_metadata', 'bookid', $bookid);
// se n tiver metadata id para este bookid
// insere
if(!$metadata->id){
	$metadata->bookid = $bookid;
	$metadata->id = insert_record("hiperbook_metadata", $metadata);	
}

$general = get_record('hiperbook_metadata_general', 'metadata_id', $metadata->id);
$lifecicle = get_record('hiperbook_metadata_lifecicle', 'metadata_id', $metadata->id);
$educational = get_record('hiperbook_metadata_educational', 'metadata_id', $metadata->id);
$rights = get_record('hiperbook_metadata_rights', 'metadata_id', $metadata->id);
$relation = get_records('hiperbook_metadata_relation', 'metadata_id', $metadata->id);
$annotation= get_records('hiperbook_metadata_annotation', 'metadata_id', $metadata->id);

$book = get_record('hiperbook', 'id', $bookid);

//se n tem dados gravados, cria novos com valores vazios
if(!$general->metadata_id){
	$general->metadata_id = $metadata->id;
	$general->title = $book->name;
	$general->id = insert_record("hiperbook_metadata_general", $general);	
}
if(!$lifecicle->metadata_id){
	$lifecicle->metadata_id = $metadata->id;
	$lifecicle->id = insert_record("hiperbook_metadata_lifecicle", $lifecicle);	
}
if(!$educational->metadata_id){
	$educational->metadata_id = $metadata->id;
	$educational->id = insert_record("hiperbook_metadata_educational", $educational);	
}
if(!$rights->metadata_id){
	$rights->metadata_id = $metadata->id;
	$rights->id = insert_record("hiperbook_metadata_rights", $rights);	
}
if(!$relation->metadata_id){
	$relation->metadata_id = $metadata->id;
	$relation->id = insert_record("hiperbook_metadata_relation", $relation);	
}


// se tiver post then -> atualiza
if($form = data_submitted()){
	echo 'Gravou';
	// GENERAL
	$general->identifier = $form->title; // identificador = título
	$general->catalog = $form->catalog;
	$general->entry = $form->entry;
	$general->title = $form->title;
	$general->language = $form->language;
	$general->description = $form->general_description;
	$general->keyword = $form->keyword;
	$general->coverage = $form->coverage;
	$general->structure = $form->structure;
	$general->aggregation_level = $form->aggregation_level;
	if (!update_record('hiperbook_metadata_general', $general)) {
            error('Could not update hiperbook general metadata!');
    }
	//LIFECICLE
	$lifecicle->version = $form->version;
	$lifecicle->version_status = $form->version_status;
	if (!update_record('hiperbook_metadata_lifecicle', $lifecicle)) {
            error('Could not update hiperbook lifecicle metadata!');
    }
	
	//EDUCATIONAL
	$educational->interactivitytype = $form->interactivitytype;
	$educational->exercise = $form->exercise;
	$educational->slide = $form->slide;
	$educational->problem_statement = $form->problem_statement;
	$educational->index_type = $form->index_type;
	$educational->experiment = $form->experiment;
	$educational->diagram = $form->diagram;
	$educational->exam = $form->exam;
	$educational->questionnaire = $form->questionnaire ;
	$educational->narrative_text = $form->narrative_text;
	$educational->figure = $form->figure;
	$educational->graph = $form->graph;
	$educational->lecture = $form->lecture;
	$educational->simulation = $form->simulation;
	$educational->table_type = $form->table_type;
	$educational->self_assesment = $form->self_assesment;
	$educational->interactivity_level = $form->interactivity_level;
	$educational->semanticdensity = $form->semanticdensity;
	$educational->intendedrole_teacher = $form->intendedrole_teacher ;
	$educational->intendedrole_student = $form->intendedrole_student ;
	$educational->intendedrole_author = $form->intendedrole_author;
	$educational->intendedrole_manager = $form->intendedrole_manager;
	$educational->context_higher_education = $form->context_higher_education;
	$educational->context_school = $form->context_school;
	$educational->context_training = $form->context_training;
	$educational->context_other = $form->context_other;
	$educational->typicalagerange = $form->typicalagerange;
	$educational->difficulty = $form->difficulty;
	$educational->typicallearningtime = $form->typicallearningtime;
	$educational->educational_description = $form->educational_description;

	if (!update_record('hiperbook_metadata_educational', $educational)) {
            error('Could not update hiperbook educational metadata!');
    }
	//RIGHTS
	$rights->costs = $form->costs;
	$rights->copyrightandothersrestrictions= $form->copyrightandothersrestrictions;
	$rights->rights_description = $form->rights_description;
	
	if (!update_record('hiperbook_metadata_rights', $rights)) {
            error('Could not update hiperbook rights metadata!');
    }
	
/*	//RELATION
	$relation->kind = $form->kind;
	$relation->resource = $form->resource;
	$relation->identifier = $form->identifier;
	$relation->relation_description = $form->relation_description;
	$relation->catalogentry = $form->catalogentry;
	$relation->catalog = $form->catalog;
	$relation->entry = $form->entry;
	if (!update_record('hiperbook_metadata_relation', $relation)) {
            error('Could not update hiperbook metadata!');
    }*/
	
}


//var_dump($relation);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;  charset=UTF-8" />
<title>Meta-dados sobre o hiperlivro</title>
<style type="text/css">
<!--
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.style4 {font-size: 12px}
#Layer1 {
	position:absolute;
	width:200px;
	height:115px;
	z-index:1;
	left: 578px;
	top: 2937px;
}
.style7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
-->
</style>
</head>

<body>
<form action="<?php echo $PHP_SELF ?>" method="post">
<input type="hidden" name="id" value="<?php echo $id ?>" />
<table width="759" border="0" cellspacing="0" bordercolor="#000000">
  
  <tr>
    <td colspan="6" bgcolor="#FFFFFF"><span class="style3"><strong>Geral
        <label></label>
        </strong>: This category groups the general information
      that describes this learning object as a whole. </span></td>
  </tr>
 <?php $reg = $general; //so existe um registro por livro  ?>
  <tr>
    <td colspan="6" bgcolor="#999999"><span class="style3">Informa&ccedil;&atilde;o catalogr&aacute;fica </span></td>
    </tr>
  <tr>
    <td bgcolor="#999999"><div align="right" class="style3">
      <div align="left">Tipo:</div>
    </div></td>
    <td width="177" bgcolor="#999999"><span class="style3">
      <label>
      <select name="catalog">
        <option <?php echo ($reg->catalog=='ISBN')?"selected":'';?>>ISBN</option>
        <option <?php echo ($reg->catalog=='ARIADNE')?"selected":''?>>ARIADNE</option>
        <option <?php echo ($reg->catalog=='URI')?"selected":'';?>>URI</option>
      </select>
      </label>
    </span></td>
    <td width="204" bgcolor="#999999"><div align="right" class="style3">Valor/Entrada:</div></td>
    <td colspan="3" bgcolor="#999999"><input name="entry" type="text" value="<?php echo $reg->entry ?>" /></td>
  </tr>
  <tr>
    <td bgcolor="#999999"><span class="style3"> T&iacute;tulo:</span></td>
    <td colspan="5" bgcolor="#999999"><input name="title" type="text" size="75" value="<?php echo $reg->title ?>" /></td>
  </tr>
  <tr>
    <td bgcolor="#999999"><span class="style3"> L&iacute;ngua:</span></td>
    <td bgcolor="#999999"><span class="style3">
      <select name="language">
        <option value="pt_BR" <?php echo ($reg->language=='pt_BR')?"selected":'';?>>Portugu&ecirc;s-Brasil</option>
        <option value="en" <?php echo ($reg->language=='en')?"selected":'';?>>Ingl&ecirc;s</option>
      </select>
    </span></td>
    <td colspan="4" bgcolor="#999999" class="style3">The primary human language 
      used within this learning object to
      communicate to the intended user.</td>
    </tr>
  <tr>
    <td valign="top" bgcolor="#999999"><div align="left" class="style3"> Descri&ccedil;&atilde;o </div>
    <div align="left" class="style3"></div></td>
    <td colspan="5" bgcolor="#999999"><span class="style3">
      <label>
      A textual description of the content of this 
learning object.<br />
<textarea name="general_description" cols="75" rows="7"><?php echo $reg->description ?></textarea>
      </label>
    </span>
      <p class="style3">&nbsp;</p>      </td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#999999"><div align="left" class="style3"> Palavras-chaves </div></td>
    <td colspan="5" valign="top" bgcolor="#999999"><p class="style3">A keyword or phrase describing the topic of 
      this learning object.
      </p>
      <p class="style3">
        <textarea name="keyword" cols="75" rows="5" id="keyword"><?php echo $reg->keyword ?>
      </textarea>
      </p></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#999999"><span class="style3">Abrang&ecirc;ncia </span></td>
    <td colspan="5" bgcolor="#999999"><p class="style3">The time, culture, geography or region to 
      which this learning object applies. 
      The extent or scope of the content of the 
      learning object. Coverage will typically 
      include spatial location (a place name or 
      geographic coordinates), temporal period (a
      period label, date, or date range) or 
      jurisdiction (such as a named administrative 
      entity). Recommended best practice is to 
      select a value from a controlled vocabulary
      (for example, the Thesaurus of Geographic 
      Names [TGN]) and that, where appropriate, 
      named places or time periods be used in
      preference to numeric identifiers such as sets
      of coordinates or date ranges.</p>
      <p class="style3">        </p>
        
        <textarea name="coverage" cols="75" rows="5" id="coverage"><?php echo $reg->coverage ?>
        </textarea>
            </p>
      </p></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#999999"><span class="style3">Estrutura </span></td>
    <td colspan="5" valign="top" bgcolor="#999999"><p class="style3">
      organizational structure of this<br />
      learning object.
 </p>
      <p class="style3">&nbsp;</p>
      <p class="style3">
        <select name="structure" id="structure">
          <option value="atomic" <?php echo ($reg->structure=='atomic')?"selected":'';?>>At&ocirc;mico</option>
          <option value="collection" <?php echo ($reg->structure=='collection')?"selected":'';?>>Cole&ccedil;&atilde;o</option>
          <option value="networked" <?php echo ($reg->structure=='networked')?"selected":'';?>>Rede</option>
          <option value="hierarchical" <?php echo ($reg->structure=='hierarchical')?"selected":'';?>>Hier&aacute;rquica</option>
          <option value="linear" <?php echo ($reg->structure=='linear')?"selected":'';?>>Linear</option>
        </select>
        <br />
      </p></td>
    </tr>
  <tr>
    <td bgcolor="#999999">&nbsp;</td>
    <td valign="top" bgcolor="#999999"><p class="style3"><strong>atomic</strong>: an object that
      is indivisible (in this
      context).</p>
      <p class="style3">        <strong>collection</strong>: a set of
        objects with no
        specified relationship
        between them.</p>
      <p class="style3">        <strong>networked</strong>: a set of
        objects with
        relationships that are
        unspecified.</p>
      <p class="style3">&nbsp;</p></td>
    <td valign="top" bgcolor="#999999"><p><span class="style3"><strong>linear</strong>: a set of objects
      that are fully ordered.<br />
      Example: A set of
      objects that are
      connected by  &quot;previous&quot; and &quot;next&quot;
      relationships.</span></p>
      <p><span class="style3"><strong>hierarchical</strong>: a set of
        objects whose
        relationships can be<br />
        represented by a tree
      structure.</span></p></td>
    <td width="14" bgcolor="#999999">&nbsp;</td>
    <td bgcolor="#999999">&nbsp;</td>
    <td bgcolor="#999999">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#999999">&nbsp;</td>
    <td colspan="4" bgcolor="#999999">&nbsp;</td>
    <td bgcolor="#999999">&nbsp;</td>
  </tr>
  <tr>
    <td width="95" bgcolor="#999999"><span class="style3"> Granularidade </span></td>
    <td colspan="4" bgcolor="#999999"><span class="style3">
      <select name="aggregation_level" id="aggregation_level">
        <option value="1" <?php echo ($reg->aggregation_level=='1')?"selected":'';?>>1. V&iacute;deo, Anima&ccedil;&atilde;o, Texto</option>
        <option value="2" <?php echo ($reg->aggregation_level=='2')?"selected":'';?>>2. Tópico</option>
        <option value="3" <?php echo ($reg->aggregation_level=='3')?"selected":'';?>>3. Disciplina</option>
        <option value="4" <?php echo ($reg->aggregation_level=='4')?"selected":'';?>>4. Curso</option>
      </select>
    </span></td>
    <td bgcolor="#999999"><div align="right"></div></td>
  </tr>
 
  
  <tr>
    <td bgcolor="#999999">&nbsp;</td>
    <td valign="top" bgcolor="#999999" class="style3"><p>1. If the learning object is a digital picture of the
      Mona Lisa.<br />
        </p>
      <p>2.If the learning object is a lesson with the
        digital picture of the Mona Lisa,<br />
      </p>
      <p><br />
      </p></td>
    <td valign="top" bgcolor="#999999" class="style3"><p>3. If the learning object is a course on the Mona<br />
      Lisa, </p>
      <p>4. Lastly if the learning object is a set of courses 
        with a full history, description, interpretation,
        etc. of the Mona Lisa<br />
      </p></td>
    <td colspan="3" bgcolor="#999999">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#999999"><span class="style4"></span></td>
    <td bgcolor="#999999"><span class="style4"></span></td>
    <td bgcolor="#999999"><span class="style4"></span></td>
    <td colspan="3" bgcolor="#999999"><div align="right"><span class="style4">
    </span></div>      <span class="style4"><label>
      <div align="right">
        <input type="submit" name="Submit" value="Salvar" />
      </div>
      </label>
    </span></td>
  </tr>
  <tr>
    <td colspan="6" bgcolor="#FFFFFF"><span class="style3"><strong>Ciclo de vida</strong>: This category describes the history and
      current state of this learning object and those
      entities that have affected this learning object
      during its evolution.</span></td>
  </tr>
   <?php  $reg = $lifecicle; ?>
  <tr>
    <td bgcolor="#999999"><span class="style3"> Vers&atilde;o </span></td>
    <td colspan="5" valign="top" bgcolor="#999999"><p>
      <input name="version" type="text" size="75" value="<?php echo $reg->version?>" />
    </p>
      <p class="style3">The edition of this learning object. </p></td>
  </tr>
  <tr>
    <td bgcolor="#999999"><span class="style3"> Status </span></td>
    <td colspan="5" bgcolor="#999999"><span class="style3">
      <select name="version_status">
        <option value="draft" <?php echo ($reg->version_status=='draft')?"selected":'';?>>Rascunho</option>
        <option value="final" <?php echo ($reg->version_status=='final')?"selected":'';?>>Final</option>
        <option value="revised" <?php echo ($reg->version_status=='revised')?"selected":'';?>>Revisada</option>
        <option value="unavailable" <?php echo ($reg->version_status=='unavailable')?"selected":'';?>>Indispon&iacute;vel</option>
      </select>
    </span></td>
  </tr>
  <tr>
    <td colspan="6" bgcolor="#999999"><span class="style3">Contribui&ccedil;&otilde;es </span></td>
  </tr>
 
  <tr><td bgcolor="#999999">&nbsp;</td>
    <td colspan="5" bgcolor="#999999" class="style3">Those entities (i.e., people, organizations)
      that have contributed to the state of this
      learning object during its life cycle (e.g.,
      creation, edits, publication).</td>
    </tr>
   <?php 
   $metadata_lifecicle_contribution =  get_records('hiperbook_metadata_lifecicle_contribution', 'metadata_lifecicle_id', $reg->id);
  ?>
  
   <tr>
     <td colspan="2" bgcolor="#999999"><span class="style3">Papel</span></td>
     <td colspan="2" bgcolor="#999999"><span class="style3">Nome e informa&ccedil;&otilde;es de contato </span></td>
     <td bgcolor="#999999"><div align="right"><span class="style3">Data</span></div></td>
     <td bgcolor="#999999">&nbsp;</td>
   </tr>
   <?php foreach($metadata_lifecicle_contribution as $regcont){ ?>
   <tr>
    <td colspan="2" bgcolor="#999999"><div align="right" class="style3"></div>      <span class="style3">    
       <?php echo ($regcont->role=='author')?"Autor":'';?>
	   <?php echo ($regcont->role=='publisher')?"Publicador":'';?>
       <?php echo ($regcont->role=='unknow')?"Desconhecido":'';?>
	   <?php echo ($regcont->role=='initiator')?"Iniciador":'';?>
	   <?php echo ($regcont->role=='terminator')?"Terminador":'';?>
	   <?php echo ($regcont->role=='validator')?"Validator":'';?>
	   <?php echo ($regcont->role=='editor')?"Editor":'';?>
	   <?php echo ($regcont->role=='graphical designer')?"Designer gr&aacute;fico":'';?>
	   <?php echo ($regcont->role=='technical implementer')?"Implementador t&eacute;cnico":'';?>
	   <?php echo ($regcont->role=='content provider')?"Provisor de conte&uacute;do":'';?>
	   <?php echo ($regcont->role=='technical validator')?"Validador t&eacute;cnico":'';?>
	   <?php echo ($regcont->role=='educational validator')?"Validador educacional":'';?>
	   <?php echo ($regcont->role=='script writer')?"Roteirista":'';?>
	   <?php echo ($regcont->role=='instructional designer')?"Designer instrucional":'';?>
	   <?php echo ($regcont->role=='subject matter expert')?"Especialista":'';?>
      </span></td>
    <td colspan="2" bgcolor="#999999"><div align="right" class="style3"></div>      <span class="style3"> 
      <?php echo $regcont->vcard?>
      </span></td>
    <td width="46" bgcolor="#999999"><div align="right" class="style3"></div></td>
    <td width="197" bgcolor="#999999"><span class="style3">
      <label>
      <?php echo $regcont->date?>
      </label>
    <a onclick="javascrip:window.open('lifecicle.php?id=<?php echo $cm->id ?>&updatemode=1&contribution_id=<?php echo $regcont->id ?>','relation','width=790, height=300,top=200,left=50');">  <img src="../../../theme/libras/pix/t/edit.gif" alt="edit" width="11" height="11" /></a>&nbsp;<a onclick="javascrip:window.open('lifecicle.php?id=<?php echo $cm->id ?>&deletemode=1&contribution_id=<?php echo $regcont->id ?>','relation','width=790, height=300,top=200,left=50');"><img src="../../../theme/libras/pix/t/delete.gif" alt="del" width="11" height="11" /></a></span></td>
  </tr>
  <?php } ?>
  
  <tr>
    <td bgcolor="#999999">&nbsp;</td>
    <td bgcolor="#999999">&nbsp;</td>
    <td bgcolor="#999999">&nbsp;</td>
    <td colspan="3" bgcolor="#999999"><div align="right" style="cursor: pointer"><span class="style4"><a onclick="javascrip:window.open('lifecicle.php?id=<?php echo $cm->id ?>&insertmode=1','relation','width=790, height=300,top=200,left=50');"><img src="../pix/add.gif" alt="adicionar contribuição" width="11" height="11" /></a></span></div></td>
  </tr>
  
  <tr>
    <td bgcolor="#999999"><span class="style4"></span></td>
    <td bgcolor="#999999"><span class="style4"></span></td>
    <td bgcolor="#999999"><span class="style4"></span></td>
    <td colspan="3" bgcolor="#999999"><div align="right">
      <input type="submit" name="Submit2" value="Salvar" />
    </div>      <span class="style4"></span></td>
  </tr>
  
  <tr>
    <td colspan="6" bgcolor="#FFFFFF"><span class="style3"> <strong>Educacional</strong>: This category describes the key educational
      or pedagogic characteristics of this learning
      object.<br />
      NOTE:--This is the pedagogical information
      essential to those involved in achieving a quality
      learning experience. The audience for this
      metadata includes teachers, managers, authors,
      and learners.</span></td>
  </tr>
  
    <?php  $reg = $educational; ?>
  <tr>
    <td colspan="2" bgcolor="#999999"><span class="style3">Tipo de interatividade </span></td>
    <td bgcolor="#999999"><span class="style3">
      <select name="interactivitytype">
        <option value="active" <?php echo ($reg->interactivitytype=='active')?"selected":'';?>>Ativa</option>
        <option value="expositive" <?php echo ($reg->interactivitytype=='expositive')?"selected":'';?>>Expositiva</option>
        <option value="mixed" <?php echo ($reg->interactivitytype=='mixed')?"selected":'';?>>Mista</option>
      </select>
    </span></td>
    <td colspan="3" bgcolor="#999999"><span class="style4"></span></td>
  </tr>
  <tr>
    <td height="25" colspan="2" bgcolor="#999999">&nbsp;</td>
    <td valign="top" bgcolor="#999999" class="style3"><p>Predominant mode of learning supported by
      this learning object.</p>
      <p>&quot;<strong>Active</strong>&quot; learning (e.g., learning by doing) is
        supported by content that directly induces
        productive action by the learner. An active<br />
        learning object prompts thelearner for
        semantically meaningful input or for some
        other kind of productive action or decision,<br />
        not necessarily performed within the learning
        object's framework. Active documents
        include simulations, questionnaires, and<br />
        exercises.<br />
      </p></td>
    <td valign="top" bgcolor="#999999" class="style3">&nbsp;</td>
    <td valign="top" bgcolor="#999999" class="style3">&nbsp;</td>
    <td valign="top" bgcolor="#999999" class="style3"><p>&quot;<strong>Expositive</strong>&quot; learning (e.g., passive learning)
      occurs when the learner's job mainly consists<br />
      of absorbing the content xposed to him
      (generally through text, images or sound). An
      expositive learning object displays information but does not prompt the learner
      for any semantically meaningful input.
      Expositive documents include essays, video<br />
      clips, all kinds of graphical material, and
      hypertext documents.</p>
      <p><br />
        When a learning object blends the active and
        expositive interactivity types, then its
      interactivity type is &quot;<strong>mixed</strong>&quot;.</p></td>
  </tr>
  <tr>
    <td height="25" colspan="2" bgcolor="#999999"><span class="style3">Tipos de recursos </span></td>
    <td colspan="4" bgcolor="#999999"><span class="style4"></span></td>
  </tr>
  <tr>
    <td colspan="6" valign="top" bgcolor="#999999"><span class="style3"> </span>
        <table width="100%" border="0" align="center">
          <tr>
            <td class="style3"><input <?php echo ($reg->exercise=='1')?'checked="checked"':'';?>  name="exercise" type="checkbox" id="exercise" value="1" />
              Exerc&iacute;cios </td>
            <td class="style3"><input <?php echo ($reg->slide=='1')?'checked="checked"':'';?> name="slide" type="checkbox" id="slide" value="1" />
              Slides </td>
            <td width="52%" class="style3"><input <?php echo ($reg->problem_statement=='1')?'checked="checked"':'';?>  name="problem_statement" type="checkbox" id="problem_statement" value="1" />
              Apresenta&ccedil;&atilde;o de problema </td>
          </tr>
          <tr>
            <td class="style3"><input name="index_type" <?php echo ($reg->index_type=='1')?'checked="checked"':'';?> type="checkbox" id="index" value="1" />
              &Iacute;ndice</td>
            <td class="style3"><input name="experiment" <?php echo ($reg->experiment=='1')?'checked="checked"':'';?> type="checkbox" id="experiment" value="1" />
              Experimento</td>
            <td class="style3"><input name="diagram"  <?php echo ($reg->diagram=='1')?'checked="checked"':'';?> type="checkbox" id="diagram" value="1" />
              Diagrama </td>
          </tr>
          <tr>
            <td width="27%" class="style3"><input <?php echo ($reg->exam=='1')?'checked="checked"':'';?>  name="exam" type="checkbox" id="exam" value="1" />
              Prova</td>
            <td width="21%" class="style3"><input <?php echo ($reg->questionnaire=='1')?'checked="checked"':'';?> name="questionnaire" type="checkbox" id="questionnaire" value="1" />
              Question&aacute;rio</td>
            <td class="style3"><input name="narrative_text"  <?php echo ($reg->narrative_text=='1')?'checked="checked"':'';?> type="checkbox" id="narrative_text" value="1" />
              Texto narrativo </td>
          </tr>
          <tr>
            <td class="style3"><input name="figure" <?php echo ($reg->figure=='1')?'checked="checked"':'';?> type="checkbox" id="figure" value="1" />
              Figura </td>
            <td class="style3"><input name="graph" <?php echo ($reg->graph=='1')?'checked="checked"':'';?> type="checkbox" id="graph" value="1" />
              Gr&aacute;fico</td>
            <td class="style3"><input name="lecture" <?php echo ($reg->lecture=='1')?'checked="checked"':'';?> type="checkbox" id="lecture" value="1" />
              Aula/Palestra</td>
          </tr>
          <tr>
            <td class="style3"><input name="simulation" <?php echo ($reg->simulation=='1')?'checked="checked"':'';?> type="checkbox" id="simulation" value="1" />
              Simula&ccedil;&otilde;es</td>
            <td class="style3"><input name="table_type" <?php echo ($reg->table_type=='1')?'checked="checked"':'';?> type="checkbox" id="table_type" value="1" />
              Tabela</td>
            <td class="style3"><input name="self_assesment" <?php echo ($reg->self_assesment=='1')?'checked="checked"':'';?> type="checkbox" id="self_assesment" value="1" />
              Auto-avalia&ccedil;&atilde;o </td>
          </tr>
        </table>
      <span class="style3">
        <label></label>
      </span></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#999999"><span class="style3"> N&iacute;vel de Interatividade </span></td>
    <td bgcolor="#999999"><span class="style3">
    <select name="interactivity_level">
      <option value="very low" <?php echo ($reg->interactivity_level=='very low')?"selected":'';?>>Muito baixo</option>
      <option value="low" <?php echo ($reg->interactivity_level=='low')?"selected":'';?>>Baixo</option>
      <option value="medium" <?php echo ($reg->interactivity_level=='medium')?"selected":'';?>>M&eacute;dio</option>
      <option value="high" <?php echo ($reg->interactivity_level=='high')?"selected":'';?>>Alto</option>
      <option value="very high" <?php echo ($reg->interactivity_level=='very high')?"selected":'';?>>Muito alto</option>
    </select>
    </span></td>
    <td colspan="3" bgcolor="#999999">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#999999">&nbsp;</td>
    <td colspan="4" bgcolor="#999999"><span class="style3">The degree of interactivity characterizing this
      learning object. Interactivity in this context
      refers to the degree to which the learner can
      influence the aspect or behavior of the
      learning object .</span></td>
    </tr>
  <tr>
    <td colspan="2" bgcolor="#999999">&nbsp;</td>
    <td bgcolor="#999999">&nbsp;</td>
    <td colspan="3" bgcolor="#999999">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#999999"><span class="style3"> Densidade Sem&acirc;ntica </span></td>
    <td bgcolor="#999999"><span class="style3">
      <select name="semanticdensity">
        <option value="very low" <?php echo ($reg->semanticdensity=='very low')?"selected":'';?>>Muito baixo</option>
        <option value="low" <?php echo ($reg->semanticdensity=='low')?"selected":'';?>>Baixo</option>
        <option value="medium" <?php echo ($reg->semanticdensity=='medium')?"selected":'';?>>M&eacute;dio</option>
        <option value="high" <?php echo ($reg->semanticdensity=='high')?"selected":'';?>>Alto</option>
        <option value="very high" <?php echo ($reg->semanticdensity=='very high')?"selected":'';?>>Muito alto</option>
      </select>
    </span></td>
    <td colspan="3" bgcolor="#999999"><span class="style4"></span></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#999999">&nbsp;</td>
    <td valign="top" bgcolor="#999999" class="style3"><p>The degree of conciseness of a learning
      object. The semantic density of a learning
      object may be estimated in terms of its size,
      span, or --in the case of self-timed resources
      such as audio or video-- duration.</p>
      <p><br />
        The semantic density of a learning object is
        independent of its difficulty. It is best
        illustrated with examples of expositive
        material, although it can be used with active resources as well.</p>
      <p>Exemplos</p>
      <p><strong>low semantic density</strong>: a screen filled up
        with explanatory text, a picture of a<br />
        combustion engine, and a single button
        labeled &quot;Click here to continue&quot;</p>
      <p><strong> high semantic density</strong>: screen with short
        text, same picture, and three buttons
        labeled &quot;Change compression ratio&quot;, &quot;Change octane index&quot;, &quot;Change ignition
      point advance&quot;</p></td>
    <td valign="top" bgcolor="#999999" class="style3">&nbsp;</td>
    <td valign="top" bgcolor="#999999" class="style3">&nbsp;</td>
    <td valign="top" bgcolor="#999999" class="style3"><p><strong>low semantic density</strong>: The full<br />
        recorded footage of a conversation between two
        experts on the differences
        between Asian and African
        elephants; 30 minutes duration.</p>
      <p><strong> high semantic density</strong>: An
        expertly edited abstract of the<br />
        same conversation; 5 minutes<br />
      duration</p>
      <p> <strong>medium semantic density</strong>: The
        text representation of the<br />
        theorem: For any given set j, it is
        always possible to define another
        set y, which is a superset of j.</p>
      <p><strong>very high semantic density</strong>: The
        symbolic representation<br />
        (formula) of the theorem<br />
      </p>      </td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#999999">&nbsp;</td>
    <td colspan="4" bgcolor="#999999">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#999999"><span class="style3"> Perfil do p&uacute;bico alvo </span></td>
    <td colspan="4" bgcolor="#999999"><span class="style4"></span></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#999999"><span class="style4"></span></td>
    <td colspan="4" bgcolor="#999999"><table width="100%" border="0">
        <tr>
          <td class="style3"><input name="intendedrole_teacher" <?php echo ($reg->intendedrole_teacher=='1')?'checked="checked"':'';?>  type="checkbox"  value="1" />
            Professor </td>
          <td class="style3"><input name="intendedrole_student" <?php echo ($reg->intendedrole_student=='1')?'checked="checked"':'';?> type="checkbox" value="1" />
            Aluno</td>
        </tr>
        <tr>
          <td class="style3"><input name="intendedrole_author" <?php echo ($reg->intendedrole_author=='1')?'checked="checked"':'';?> type="checkbox" value="1" />
            Autor</td>
          <td class="style3"><input name="intendedrole_manager" <?php echo ($reg->intendedrole_manager=='1')?'checked="checked"':'';?> type="checkbox" value="1" />
            Administrador</td>
        </tr>
    </table></td>
  </tr>

  <tr>
    <td colspan="2" bgcolor="#999999"><span class="style3"> Contexto </span></td>
    <td colspan="4" bgcolor="#999999"><span class="style4"></span></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#999999"><span class="style4"></span></td>
    <td colspan="4" bgcolor="#999999"><table width="100%" border="0">
        <tr>
          <td class="style3"><input name="context_higher_education" type="checkbox" id="context_higher_education" <?php echo ($reg->context_higher_education=='1')?'checked="checked"':'';?> value="1" />
            Educa&ccedil;&atilde;o Superior </td>
          <td><input name="context_school" type="checkbox" <?php echo ($reg->context_school=='1')?'checked="checked"':'';?>  value="1" />
            Escola b&aacute;sica </td>
        </tr>
        <tr>
          <td><input name="context_training" <?php echo ($reg->context_training=='1')?'checked="checked"':'';?> type="checkbox" id="context_training" value="1" />
            Treinamentos</td>
          <td><input name="context_other" <?php echo ($reg->context_other=='1')?'checked="checked"':'';?> type="checkbox" id="context_other" value="1" />
            Outros</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#999999"><span class="style3">Faixa Et&aacute;ria t&iacute;pica </span></td>
    <td bgcolor="#999999"><input name="typicalagerange" type="text" size="30" value="<?php echo $reg->typicalagerange ?>" /></td>
    <td colspan="3" bgcolor="#999999"><span class="style4"></span></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#999999"><span class="style3"> Dificuldade </span></td>
    <td bgcolor="#999999"><span class="style3">
      <select name="difficulty">
        <option value="very easy" <?php echo ($reg->difficulty=='very easy')?"selected":'';?>>Muito f&aacute;cil</option>
        <option value="easy" <?php echo ($reg->difficulty=='easy')?"selected":'';?>>F&aacute;cil</option>
        <option value="medium" <?php echo ($reg->difficulty=='very difficult')?"selected":'';?>>M&eacute;dio</option>
        <option value="difficult" <?php echo ($reg->difficulty=='difficult')?"selected":'';?>>Dif&iacute;cil</option>
        <option value="very difficult" <?php echo ($reg->difficulty=='very difficult')?"selected":'';?>>Muito dif&iacute;cil</option>
      </select>
    </span></td>
    <td colspan="3" bgcolor="#999999"><span class="style4"></span></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#999999"><span class="style3">Tempo para aprendizagem </span></td>
    <td bgcolor="#999999"><input name="typicallearningtime" type="text" size="30" value="<?php echo $reg->typicallearningtime ?>" /></td>
    <td colspan="3" bgcolor="#999999"><span class="style4"></span></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#999999"><span class="style3"> Descri&ccedil;&atilde;o de uso </span></td>
    <td colspan="4" bgcolor="#999999"><p class="style3">
      <textarea name="educational_description" cols="75" rows="5"><?php echo $reg->educational_description ?>
      </textarea>
    </p>
      <p class="style3">Comments on how this learning object is to
      be used. </p></td>
  </tr>
  
  <tr>
    <td colspan="6" bgcolor="#999999"><div align="right">
      <input type="submit" name="Submit3" value="Salvar" />
    </div></td>
  </tr>
  <tr>
    <td colspan="6" bgcolor="#FFFFFF"><span class="style7"> Direitos autorais </span></td>
  </tr>
  <?php  $reg=$rights; ?>
  <tr>
    <td bgcolor="#999999"><span class="style3">Custo</span></td>
    <td bgcolor="#999999"><span class="style3">
      <select name="costs" >
        <option value="no" <?php echo ($reg->costs=='no')?"selected":'';?>>N&atilde;o</option>
        <option value="yes" <?php echo ($reg->costs=='yes')?"selected":'';?>>Sim</option>
      </select>
    </span></td>
    <td bgcolor="#999999"><span class="style3">Restri&ccedil;&otilde;es de Copyright </span></td>
    <td colspan="3" bgcolor="#999999"><span class="style3">
      <select name="copyrightandothersrestrictions">
        <option value="no" <?php echo ($reg->copyrightandothersrestrictions=='no')?"selected":'';?>>N&atilde;o</option>
        <option value="yes" <?php echo ($reg->copyrightandothersrestrictions=='yes')?"selected":'';?>>Sim</option>
      </select>
    </span></td>
  </tr>
  <tr>
    <td height="96" colspan="2" bgcolor="#999999"><span class="style3">Descri&ccedil;&atilde;o </span></td>
    <td colspan="4" bgcolor="#999999"><span class="style3">
      <textarea name="rights_description" cols="75" rows="5"><?php echo $reg->rights_description ?></textarea>
    </span></td>
  </tr>
  <tr>
  
    <td bgcolor="#999999"><span class="style4"></span></td>
    <td bgcolor="#999999"><span class="style4"></span></td>
    <td bgcolor="#999999"><span class="style4"></span></td>
    <td colspan="3" bgcolor="#999999"><div align="right">
      <input type="submit" name="Submit4" value="Salvar" />
    </div></td>
  </tr>
  <tr>
    <td colspan="6" bgcolor="#FFFFFF"> <span class="style3"><strong>Rela&ccedil;&atilde;o com outros recursos</strong>: This category defines the relationship
        between this learning object and other
        learning objects, if any.
        To define multiple relationships, there may
        be multiple instances of this category.
      If there
        is more than one target learning object, then
        each target shall have a new relationship
      instance.</span></td>
  </tr>
    

	<?php  foreach($relation as $reg){ ?>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#999999"><span class="style3">Tipo</span></td>
    <td bgcolor="#999999"><span class="style3">
      <?php echo ($reg->kind=='IsPartOf')?"&eacute; parte de":'';?>
	  <?php echo ($reg->kind=='HasPart')?"tem parte":'';?>
	  <?php echo ($reg->kind=='IsVersionOf')?"&eacute; vers&atilde;o de":'';?>
	  <?php echo ($reg->kind=='HasVersion')?"tem vers&atilde;o":'';?>
	  <?php echo ($reg->kind=='IsFormatOf')?"&eacute; formato de":'';?>
	  <?php echo ($reg->kind=='HasFormat')?"tem formato":'';?>
	  <?php echo ($reg->kind=='References')?"referencia":'';?>
	  <?php echo ($reg->kind=='IsReferencedBy')?"&eacute; referenciado por":'';?>
	  <?php echo ($reg->kind=='IsBasedOn')?"&eacute; baseado em":'';?>
	  <?php echo ($reg->kind=='IsBasisFor')?"&eacute; base para":'';?>
	  <?php echo ($reg->kind=='Requires')?"requer":'';?>
	  <?php echo ($reg->kind=='IsRequiredBy')?"&eacute; requerido por":'';?>
    </span></td>
    <td bgcolor="#999999"><p><span class="style1"><span class="style4"><span class="style1"><span class="style4"><span class="style4"></span></span></span></span></span></p>    </td>
    <td colspan="3" bgcolor="#999999"><span class="style4"></span></td>
  </tr>  
  <tr>
    <td bgcolor="#999999"><span class="style3">Identificador</span></td>
    <td colspan="5" bgcolor="#999999"><?php echo $reg->identifier ?></td>
  </tr>
  <tr>
    <td bgcolor="#999999"><span class="style4"><span class="style3">Descri&ccedil;&atilde;o</span></span></td>
    <td colspan="5" bgcolor="#999999"><div align="right" class="style3"></div>      <span class="style3">
      <?php echo $reg->relation_description ?>
      </span></td>
  </tr>
  <tr>
    <td colspan="3" bgcolor="#999999"><span class="style3">Informa&ccedil;&atilde;o catalogr&aacute;fica</span></td>
    <td colspan="3" bgcolor="#999999"><span class="style4"></span></td>
  </tr>
  <tr>
    <td bgcolor="#999999"><div align="right" class="style3">Tipo</div></td>
    <td bgcolor="#999999"><span class="style3">
      <label><?php echo ($reg->catalog=='ISBN')?"ISBN":'';?>
	  <?php echo ($reg->catalog=='ARIADNE')?"ARIADNE":'';?>
	  <?php echo ($reg->catalog=='URI')?"URI":'';?></option>
      </select>
      </label>
    </span></td>
    <td bgcolor="#999999"><div align="right" class="style3">Valor</div></td>
    <td colspan="3" bgcolor="#999999"><?php echo $reg->entry?><a onclick="javascrip:window.open('relation.php?id=<?php echo $cm->id ?>&updatemode=1&relation_id=<?php echo $reg->id ?>','relation','width=790, height=450,top=200,left=50');">  <img src="<?php echo $CFG->wwwroot;?>/pix/t/edit.gif" alt="edit" width="11" height="11" /></a>&nbsp;<a onclick="javascrip:window.open('relation.php?id=<?php echo $cm->id ?>&deletemode=1&relation_id=<?php echo $reg->id ?>','relation','width=790, height=300,top=200,left=50');"><img src="<?php echo $CFG->wwwroot;?>/pix/t/delete.gif" alt="del" width="11" height="11" /></a></span></td>
  </tr>
  <?php } ?>
  <tr>
    <td bgcolor="#999999">&nbsp;</td>
    <td bgcolor="#999999">&nbsp;</td>
    <td bgcolor="#999999">&nbsp;</td>
    <td colspan="3" bgcolor="#999999"><div align="right"><span class="style4" style="cursor: pointer"><a   onclick="javascrip:window.open('relation.php?id=<?php echo $cm->id ?>&insertmode=1','relation','width=790, height=400');"><img src="../pix/add.gif" width="11" height="11" border="0" /></a></span></div></td>
  </tr>
  <tr>
    <td bgcolor="#999999">&nbsp;</td>
    <td bgcolor="#999999">&nbsp;</td>
    <td bgcolor="#999999">&nbsp;</td>
    <td colspan="3" bgcolor="#999999"><div align="right">
      <input type="submit" name="Submit52" value="Salvar" />
    </div></td>
  </tr>
  <tr>
    <td colspan="6" bgcolor="#FFFFFF"> <span class="style3"><strong>Anota&ccedil;&otilde;es de Uso</strong>: This category provides comments on the
        educational use of this learning object, and
        information on when and by whom the
        comments were created. 
      This category enables educators to share their
        assessments of learning objects, suggestions
      for use, etc.</span></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" valign="top"><p class="style3">&nbsp;</p>      </td>
    </tr>
		<?php  foreach($annotation as $reg){ ?>

  <tr>
    <td bgcolor="#999999"><span class="style3">Entidade</span></td>
    <td colspan="5" bgcolor="#999999"><?php echo $reg->entity ?> em <?php echo $reg->date ?></td>
  </tr>
  
  <tr>
    <td bgcolor="#999999"><span class="style4"><span class="style3">Descri&ccedil;&atilde;o</span></span></td>
    <td colspan="5" bgcolor="#999999"><div align="right" class="style3"></div>
        <span class="style3">
        <?php echo $reg->annotation_description ?>
      </span></td>
  </tr>
  <tr>
    <td colspan="3" bgcolor="#999999">&nbsp;</td>
    <td colspan="3" bgcolor="#999999"><span class="style4"></span></td>
  </tr>
  <tr>
    <td bgcolor="#999999">&nbsp;</td>
    <td bgcolor="#999999">&nbsp;</td>
    <td bgcolor="#999999">&nbsp;</td>
    <td colspan="3" bgcolor="#999999"><a onclick="javascrip:window.open('relation.php?id=<?php echo $cm->id ?>&amp;updatemode=1&amp;relation_id=<?php echo $reg->id ?>','relation','width=790, height=300,top=200,left=50');"> <img src="<?php echo $CFG->wwwroot;?>/pix/t/edit.gif" alt="edit" width="11" height="11" /></a>&nbsp;<a onclick="javascrip:window.open('relation.php?id=<?php echo $cm->id ?>&amp;deletemode=1&amp;relation_id=<?php echo $reg->id ?>','relation','width=790, height=450,top=200,left=50');"><img src="<?php echo $CFG->wwwroot;?>/pix/t/delete.gif" alt="del" width="11" height="11" /></a></span></td>
  </tr>
  <?php } ?>
  <tr>
    <td bgcolor="#999999">&nbsp;</td>
    <td bgcolor="#999999">&nbsp;</td>
    <td bgcolor="#999999">&nbsp;</td>
    <td colspan="3" bgcolor="#999999">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#999999">&nbsp;</td>
    <td bgcolor="#999999">&nbsp;</td>
    <td bgcolor="#999999">&nbsp;</td>
    <td colspan="3" bgcolor="#999999"><div align="right"><a   onclick="javascrip:window.open('annotation.php?id=<?php echo $cm->id ?>&amp;insertmode=1','relation','width=790, height=450');"><img src="../pix/add.gif" alt="Adicionar" width="11" height="11" border="0" /></a></div></td>
  </tr>
  <tr>
    <td bgcolor="#999999">&nbsp;</td>
    <td bgcolor="#999999">&nbsp;</td>
    <td bgcolor="#999999">&nbsp;</td>
    <td colspan="3" bgcolor="#999999">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#999999"><span class="style4"></span></td>
    <td bgcolor="#999999"><span class="style4"></span></td>
    <td bgcolor="#999999"><span class="style4"></span></td>
    <td colspan="3" bgcolor="#999999"><div align="right">
      <input type="submit" name="Submit5" value="Salvar" />
    </div></td>
  </tr>
</table>
</form>
</body>
</html>
