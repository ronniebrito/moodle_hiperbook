<?
require_once('../../../config.php');
require_once('../lib.php');

$id         = required_param('id', PARAM_INT);
$insertmode = optional_param('insertmode', 0, PARAM_INT);
$deletemode = optional_param('deletemode', 0, PARAM_INT);
$updatemode = optional_param('updatemode', 0,PARAM_INT);
$annotation_id = optional_param('annotation_id', 0,PARAM_INT);

if (!$cm = get_record('course_modules', 'id', $id)) {
    error('Course Module ID was incorrect');
}

$bookid = $cm->instance;

$metadata = get_record('hiperbook_metadata', 'bookid', $bookid);
$annotation = get_record('hiperbook_metadata_annotation', 'id', $annotation_id);

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
	$metadata_annotation = get_record('hiperbook_metadata_annotation', 'id', $annotation_id);
  	$reg = $metadata_annotation; 
}

if($deletemode){	
	delete_records('hiperbook_metadata_annotation','id', $annotation_id);
	echo "Registro apagado";
	
	?><script language="javascript"> window.opener.location.reload(); </script><?
	die();
}


  
if($form = data_submitted()){
	if($form->updatemode == '1'){
		echo 'Gravou';
		$annotation->id = $reg->id;
		$annotation->date = $form->date;
		$annotation->identifier= $form->entity;
		$annotation->annotation_description = $form->annotation_description;
		if (!update_record('hiperbook_metadata_annotation', $annotation)) {
				error('Could not update hiperbook annotation metadata!');
		}
	}
	if($form->insertmode =='1'){
		$annotation->metadata_id = $metadata->id;	
		$annotation->entity= $form->entity;
		$annotation->date = $form->date;
		$annotation->annotation_description = $form->annotation_description;	
		if (!insert_record('hiperbook_metadata_annotation', $annotation)) {
				error('Could not insert hiperbook annotation metadata!');
		}
		echo 'Gravou';
		
	?><script language="javascript"> window.opener.location.reload(); </script><?
		die();
	
	}
	
	?><script language="javascript"> window.opener.location.reload(); </script><?
	
}

if($updatemode){ 
	$metadata_annotation = get_record('hiperbook_metadata_annotation', 'id', $annotation_id);
  	$reg = $metadata_annotation; 
}
	?>
<form action="<?= $PHP_SELF ?>" method="post">
<input type="hidden" name="id" value="<?= $id ?>" />
<input type="hidden" name="updatemode" value="<?= $updatemode ?>" />
<input type="hidden" name="insertmode" value="<?= $insertmode ?>" />
<input type="hidden" name="annotation_id" value="<?= $annotation_id ?>" />
<table width="759" border="0">
  <tr>
    <td colspan="8" bgcolor="#CCCCCC"><span class="style3">Anota&ccedil;&otilde;es de Uso </span></td>
  </tr>
  <tr>
    <td valign="top"><span class="style3">Entidade</span></td>
    <td colspan="5" valign="top"><p>
      <input name="entity" type="text" size="30" value="<?= $reg->entity ?>" />
    </p>
      <p class="style3">Entity (i.e., people, organization) that created
      this annotation. </p></td>
  </tr>
  <tr>
    <td><span class="style3">Data</span></td>
    <td colspan="5"><input name="date" type="text" size="30" value="<?= $reg->date ?>" /></td>
  </tr>
  <tr>
    <td valign="top"><span class="style4"><span class="style3">Descri&ccedil;&atilde;o</span></span></td>
    <td colspan="5" valign="top"><div align="right" class="style3"></div>
        <p class="style3">
          <textarea name="annotation_description" cols="75" rows="5"><?= $reg->annotation_description ?>
        </textarea>
      </p>
      <p class="style3">Exemplo: &quot;I have used this video clip with my
        students. They really enjoy being able to zoom<br />
        in on specific features of the painting. Make
        sure they have a broadband connection or the<br />
        experience becomes too cumbersome to be
      educationally interesting&quot;</p>      </td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  

  <tr>
    <td><span class="style4"></span></td>
    <td colspan="3"><span class="style4"></span></td>
    <td><div align="right"><span class="style4">
      <input type="submit" name="Submit" value="Enviar" />
    </span></div></td>
    <td colspan="3"><div align="right"></div></td>
  </tr>
</table>
</body>
</html>
