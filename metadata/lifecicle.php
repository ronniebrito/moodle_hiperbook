<?php
require_once('../../../config.php');
require_once('../lib.php');

$id         = required_param('id', PARAM_INT);
$insertmode = optional_param('insertmode', 0, PARAM_INT);
$deletemode = optional_param('deletemode', 0, PARAM_INT);
$updatemode = optional_param('updatemode', 0,PARAM_INT);
$contribution_id = optional_param('contribution_id', 0,PARAM_INT);

if (!$cm = get_record('course_modules', 'id', $id)) {
    error('Course Module ID was incorrect');
}

$bookid = $cm->instance;

$metadata = get_record('hiperbook_metadata', 'bookid', $bookid);
$lifecicle = get_record('hiperbook_metadata_lifecicle', 'metadata_id', $metadata->id);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Contribuições no Ciclo de Vida</title>
<style type="text/css">
<!--
.style3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.style4 {font-size: 12px}
-->
</style>
</head>

<body>
<?php
$contribution->metadata_lifecicle_id = $lifecicle->id;

if($updatemode){ 
	$metadata_lifecicle_contribution = get_record('hiperbook_metadata_lifecicle_contribution', 'id', $contribution_id);
  	$regcont = $metadata_lifecicle_contribution; 
}

if($deletemode){	
	delete_records('hiperbook_metadata_lifecicle_contribution','id', $contribution_id);
	echo "Registro apagado";
	die();
}


  
if($form = data_submitted()){
	if($form->updatemode == '1'){
		echo 'Gravou';
		$contribution->id = $regcont->id;
		$contribution->role=$form->role;
		$contribution->vcard = $form->vcard;
		$contribution->date = $form->date;
		if (!update_record('hiperbook_metadata_lifecicle_contribution', $contribution)) {
				error('Could not update hiperbook lifecicle contribution metadata!');
		}
	}
	if($form->insertmode =='1'){
		
		$contribution->role=$form->role;
		$contribution->vcard = $form->vcard;
		$contribution->date = $form->date;
		if (!insert_record('hiperbook_metadata_lifecicle_contribution', $contribution)) {
				error('Could not update hiperbook lifecicle contribution metadata!');
		}
		echo 'Gravou';
		die();
	}
	
}

if($updatemode){ 
	$metadata_lifecicle_contribution = get_record('hiperbook_metadata_lifecicle_contribution', 'id', $contribution_id);
  	$regcont = $metadata_lifecicle_contribution; 
}
	?>
	
	
<form action="<?php echo $PHP_SELF ?>" method="post">
<input type="hidden" name="id" value="<?php echo $id ?>" />
<input type="hidden" name="updatemode" value="<?php echo $updatemode ?>" />
<input type="hidden" name="insertmode" value="<?php echo $insertmode ?>" />
<input type="hidden" name="contribution_id" value="<?php echo $contribution_id ?>" />
<table width="759" border="0">
  <tr>
    <td colspan="6" bgcolor="#CCCCCC"><span class="style3">Ciclo de vida</span></td>
  </tr>
  <tr>
    <td colspan="6"><span class="style3">Contribui&ccedil;&otilde;es </span></td>
  </tr>
  <tr>
    <td><div align="right" class="style3">Papel</div></td>
    <td><span class="style3">
      <select name="role">
        <option value="author" <?php echo ($regcont->role=='author')?"selected":'';?>>Autor</option>
        <option value="publisher" <?php echo ($regcont->role=='publisher')?"selected":'';?>>Publicador</option>
        <option value="unknow" <?php echo ($regcont->role=='unknow')?"selected":'';?>>Desconhecido</option>
        <option value="initiator" <?php echo ($regcont->role=='initiator')?"selected":'';?>>Iniciador</option>
        <option value="terminator" <?php echo ($regcont->role=='terminator')?"selected":'';?>>Terminador</option>
        <option value="validator" <?php echo ($regcont->role=='validator')?"selected":'';?>>Validator</option>
        <option value="editor" <?php echo ($regcont->role=='editor')?"selected":'';?>>Editor</option>
        <option value="graphical designer" <?php echo ($regcont->role=='graphical designer')?"selected":'';?>>Designer gr&aacute;fico</option>
        <option value="technical implementer" <?php echo ($regcont->role=='technical implementer')?"selected":'';?>>Implementador t&eacute;cnico</option>
        <option value="content provider" <?php echo ($regcont->role=='content provider')?"selected":'';?>>Provisor de conte&uacute;do</option>
        <option value="technical validator" <?php echo ($regcont->role=='technical validator')?"selected":'';?>>Validador t&eacute;cnico</option>
        <option value="educational validator" <?php echo ($regcont->role=='educational validator')?"selected":'';?>>Validador educacional</option>
        <option value="script writer" <?php echo ($regcont->role=='script writer')?"selected":'';?>>Roteirista</option>
        <option value="instructional designer" <?php echo ($regcont->role=='instructional designer')?"selected":'';?>>Designer instrucional</option>
        <option value="subject matter expert" <?php echo ($regcont->role=='subject matter expert')?"selected":'';?>>Especialista</option>
      </select>
    </span></td>
    <td><div align="right" class="style3">
      <div align="right" class="style3">Data
        <input type="text" name="date" value="<?php echo $regcont->date?>" />
      </div>
    </div></td>
    <td width="70">&nbsp;</td>
    <td width="46">&nbsp;</td>
    <td width="182"><span class="style3">
      <label></label>
    </span></td>
  </tr>
  <tr>
    <td colspan="2"><span class="style4"></span><span class="style4"><span class="style3">Nome e informa&ccedil;&otilde;es de contato</span></span></td>
    <td><span class="style4"><span class="style3"><textarea name="vcard" cols="25" rows="5"><?php echo $regcont->vcard?></textarea>
    </span></span></td>
    <td colspan="3" valign="bottom"><div align="right"><span class="style4">
    </span></div>      <span class="style4"><label>
      <div align="right">
        <input type="submit" name="Submit" value="Salvar" />
      </div>
      </label>
    </span></td>
  </tr>
</table>
</form>
</body>
</html>
