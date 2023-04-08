<?php require_once('Connections/registro.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO usuarios_datos (Nombre, Cedula, `Correo electronico`, Direccion, Celular, Usuario, Clave) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Nombre'], "text"),
                       GetSQLValueString($_POST['Cedula'], "text"),
                       GetSQLValueString($_POST['Correo_electronico'], "text"),
                       GetSQLValueString($_POST['Direccion'], "text"),
                       GetSQLValueString($_POST['Celular'], "text"),
                       GetSQLValueString($_POST['Usuario'], "text"),
                       GetSQLValueString($_POST['Clave'], "text"));

  mysql_select_db($database_registro, $registro);
  $Result1 = mysql_query($insertSQL, $registro) or die(mysql_error());

  $insertGoTo = "validacion.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
<!--
body {
	font: 100%/1.4 Verdana, Arial, Helvetica, sans-serif;
	background-color: #42413C;
	margin: 0;
	padding: 0;
	color: #000;
}

/* ~~ Selectores de elemento/etiqueta ~~ */
ul, ol, dl { /* Debido a las diferencias existentes entre los navegadores, es recomendable no añadir relleno ni márgenes en las listas. Para lograr coherencia, puede especificar las cantidades deseadas aquí o en los elementos de lista (LI, DT, DD) que contienen. Recuerde que lo que haga aquí se aplicará en cascada en la lista .nav, a no ser que escriba un selector más específico. */
	padding: 0;
	margin: 0;
}
h1, h2, h3, h4, h5, h6, p {
	margin-top: 0;	 /* la eliminación del margen superior resuelve un problema que origina que los márgenes escapen de la etiqueta div contenedora. El margen inferior restante lo mantendrá separado de los elementos de que le sigan. */
	padding-right: 15px;
	padding-left: 15px; /* la adición de relleno a los lados del elemento dentro de las divs, en lugar de en las divs propiamente dichas, elimina todas las matemáticas de modelo de cuadro. Una div anidada con relleno lateral también puede usarse como método alternativo. */
}
a img { /* este selector elimina el borde azul predeterminado que se muestra en algunos navegadores alrededor de una imagen cuando está rodeada por un vínculo */
	border: none;
}
/* ~~ La aplicación de estilo a los vínculos del sitio debe permanecer en este orden (incluido el grupo de selectores que crea el efecto hover -paso por encima-). ~~ */
a:link {
	color: #42413C;
	text-decoration: underline; /* a no ser que aplique estilos a los vínculos para que tengan un aspecto muy exclusivo, es recomendable proporcionar subrayados para facilitar una identificación visual rápida */
}
a:visited {
	color: #6E6C64;
	text-decoration: underline;
}
a:hover, a:active, a:focus { /* este grupo de selectores proporcionará a un usuario que navegue mediante el teclado la misma experiencia de hover (paso por encima) que experimenta un usuario que emplea un ratón. */
	text-decoration: none;
}

/* ~~ este contenedor de anchura fija rodea a todos los demás elementos ~~ */
.container {
	width: 960px;
	background-color: #FFF;
	margin: 0 auto; /* el valor automático de los lados, unido a la anchura, centra el diseño */
}

/* ~~ Esta es la información de diseño. ~~ 

1) El relleno sólo se sitúa en la parte superior y/o inferior de la div. Los elementos situados dentro de esta div tienen relleno a los lados. Esto le ahorra las "matemáticas de modelo de cuadro". Recuerde que si añade relleno o borde lateral a la div propiamente dicha, éste se añadirá a la anchura que defina para crear la anchura *total*. También puede optar por eliminar el relleno del elemento en la div y colocar una segunda div dentro de ésta sin anchura y el relleno necesario para el diseño deseado.

*/
.content {

	padding: 10px 0;
}

/* ~~ clases float/clear varias ~~ */
.fltrt {  /* esta clase puede utilizarse para que un elemento flote en la parte derecha de la página. El elemento flotante debe preceder al elemento junto al que debe aparecer en la página. */
	float: right;
	margin-left: 8px;
}
.fltlft { /* esta clase puede utilizarse para que un elemento flote en la parte izquierda de la página. El elemento flotante debe preceder al elemento junto al que debe aparecer en la página. */
	float: left;
	margin-right: 8px;
}
.clearfloat { /* esta clase puede situarse en una <br /> o div vacía como elemento final tras la última div flotante (dentro de #container) si se elimina overflow:hidden en .container */
	clear:both;
	height:0;
	font-size: 1px;
	line-height: 0px;
}
-->
</style>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
</head>

<body>

<div class="container">
  <div class="content">
    <h1 align="center">Registro de usuarios    </h1>
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <table align="center">
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Nombre:</td>
          <td><span id="sprytextfield1">
            <input type="text" name="Nombre" value="" size="32" />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Cedula:</td>
          <td><span id="sprytextfield2">
            <input type="text" name="Cedula" value="" size="32" />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Correo electronico:</td>
          <td><span id="sprytextfield3">
            <input type="text" name="Correo_electronico" value="" size="32" />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Direccion:</td>
          <td><span id="sprytextfield4">
            <input type="text" name="Direccion" value="" size="32" />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Celular:</td>
          <td><span id="sprytextfield5">
            <input type="text" name="Celular" value="" size="32" />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Usuario:</td>
          <td><span id="sprytextfield6">
            <input type="text" name="Usuario" value="" size="32" />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Clave:</td>
          <td><span id="sprytextfield7">
            <input type="password" name="Clave" value="" size="32" />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td><input type="submit" value="Insertar registro" /></td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="form1" />
    </form>
    <form id="form2" name="form2" method="post" action="">
      <div align="center"></div>
    </form>
    <p align="center">¿Ya estas registrado?</p>
    <p align="center"><a href="validacion.php">Inicia Sesion Ya</a></p>
    <div align="center"></div>
  </div>
  <!-- end .container --></div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7");
</script>
</body>
</html>