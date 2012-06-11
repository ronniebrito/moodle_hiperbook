<?
require_once('../../../config.php');
require_once('../lib.php');

$id         = required_param('id', PARAM_INT);
$insertmode = optional_param('insertmode', 0, PARAM_INT);
$deletemode = optional_param('deletemode', 0, PARAM_INT);
$updatemode = optional_param('updatemode', 0,PARAM_INT);
$relation_id = optional_param('relation_id', 0,PARAM_INT);

if (!$cm = get_record('course_modules', 'id', $id)) {
    error('Course Module ID was incorrect');
}

$bookid = $cm->instance;

$metadata = get_record('hiperbook_metadata', 'bookid', $bookid);
$relation = get_record('hiperbook_metadata_relation', 'id', $relation_id);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.style4 {font-size: 12px}
-->
</style>
</head>

<body><?

if($updatemode){ 
	$metadata_relation = get_record('hiperbook_metadata_relation', 'id', $relation_id);
  	$reg = $metadata_relation; 
}

if($deletemode){	
	delete_records('hiperbook_metadata_relation','id', $relation_id);
	echo "Registro apagado";
	
	?><script language="javascript"> window.opener.location.reload(); </script><?
	die();
}


  
if($form = data_submitted()){
	if($form->updatemode == '1'){
		echo 'Gravou';
		$relation->id = $reg->id;
		$relation->kind = $form->kind;
		$relation->identifier= $form->identifier;
		$relation->relation_description = $form->relation_description;
		$relation->catalog= $form->catalog;
		$relation->entry= $form->entry;		
		if (!update_record('hiperbook_metadata_relation', $relation)) {
				error('Could not update hiperbook relation metadata!');
		}
	}
	if($form->insertmode =='1'){
		$relation->metadata_id = $metadata->id;	
		$relation->kind = $form->kind;
		$relation->identifier= $form->identifier;
		$relation->relation_description = $form->relation_description;
		$relation->catalog= $form->catalog;
		$relation->entry= $form->entry;		
		if (!insert_record('hiperbook_metadata_relation', $relation)) {
				error('Could not insert hiperbook relation metadata!');
		}
		echo 'Gravou';
		die();
	
	}
	?><script language="javascript"> window.opener.location.reload(); </script><?
	
}

if($updatemode){ 
	$metadata_relation = get_record('hiperbook_metadata_relation', 'id', $relation_id);
  	$reg = $metadata_relation; 
}
	?>
<form action="<?= $PHP_SELF ?>" method="post">
<input type="hidden" name="id" value="<?= $id ?>" />
<input type="hidden" name="updatemode" value="<?= $updatemode ?>" />
<input type="hidden" name="insertmode" value="<?= $insertmode ?>" />
<input type="hidden" name="relation_id" value="<?= $relation_id ?>" />
<table width="759" border="0">
  <tr>
    <td colspan="8" bgcolor="#CCCCCC"><span class="style3">Rela&ccedil;&atilde;o com outros recursos </span></td>
  </tr>
  <tr>
    <td><span class="style3">Tipo</span></td>
    <td><span class="style3">
      <select name="kind">
        <option value="IsPartOf" <?= ($reg->kind=='IsPartOf')?"selected":'';?>>&eacute; parte de </option>
        <option value="HasPart" <?= ($reg->kind=='HasPart')?"selected":'';?>>tem parte</option>
        <option value="IsVersionOf" <?= ($reg->kind=='IsVersionOf')?"selected":'';?>>&eacute; vers&atilde;o de</option>
        <option value="HasVersion" <?= ($reg->kind=='HasVersion')?"selected":'';?>>tem vers&atilde;o</option>
        <option value="IsFormatOf" <?= ($reg->kind=='IsFormatOf')?"selected":'';?>>&eacute; formato de</option>
        <option value="HasFormat" <?= ($reg->kind=='HasFormat')?"selected":'';?>>tem formato</option>
        <option value="References" <?= ($reg->kind=='References')?"selected":'';?>>referencia</option>
        <option value="IsReferencedBy" <?= ($reg->kind=='IsReferencedBy')?"selected":'';?>>&eacute; referenciado por</option>
        <option value="IsBasedOn" <?= ($reg->kind=='IsBasedOn')?"selected":'';?>>&eacute; baseado em </option>
        <option value="IsBasisFor" <?=($reg->kind=='IsBasisFor')?"selected":'';?>>&eacute; base para</option>
        <option value="Requires" <?= ($reg->kind=='Requires')?"selected":'';?>>requer</option>
        <option value="IsRequiredBy" <?= ($reg->kind=='IsRequiredBy')?"selected":'';?>>&eacute; requerido por</option>
      </select>
    </span></td>
    <td><p><span class="style1"><span class="style4"><span class="style1"><span class="style4"><span class="style4"></span></span></span></span></span></p></td>
    <td colspan="3"><span class="style4"></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td><span class="style3">Recurso:</span></td>
    <td><div align="right" class="style3"></div></td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td><span class="style3">Identificador</span></td>
    <td colspan="5"><input name="identifier" type="text" size="30" value="<?= $reg->identifier ?>" /></td>
  </tr>
  <tr>
    <td><span class="style4"><span class="style3">Descri&ccedil;&atilde;o</span></span></td>
    <td colspan="5"><div align="right" class="style3"></div>
        <span class="style3">
        <textarea name="relation_description" cols="75" rows="5"><?= $reg->relation_description ?>
      </textarea>
      </span></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><span class="style3">Informa&ccedil;&atilde;o catalogr&aacute;fica</span></td>
    <td colspan="3"><span class="style4"></span></td>
  </tr>
  <tr>
    <td><div align="right" class="style3">Tipo</div></td>
    <td><span class="style3">
      <label>
      <select name="catalog">
        <option value="ISBN" <?= ($reg->catalog=='ISBN')?"selected":'';?>>ISBN</option>
        <option value="ARIADNE" <?= ($reg->catalog=='ARIADNE')?"selected":'';?>>ARIADNE</option>
        <option value="URI" <?= ($reg->catalog=='URI')?"selected":'';?>>URI</option>
      </select>
      </label>
    </span></td>
    <td><div align="right" class="style3">Valor</div></td>
    <td colspan="3"><input name="entry" type="text" value="<?= $reg->entry?>" /></td>
  </tr>
  
  <tr>
    <td colspan="5">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
 
  <tr>
    <td><span class="style4"></span></td>
    <td colspan="3"><span class="style4"></span></td>
    <td><span class="style4">
    <input type="submit" name="Submit" value="Enviar" />
</span></td>
    <td colspan="3"><div align="right"></div></td>
  </tr>
</table>
</body>
</html>
