<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2006 osCommerce

  Released under the GNU General Public License
*/

  $template = 'main_page';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>

<head>

<title>osCommerce :// Open Source E-Commerce Solutions</title>

<meta name="ROBOTS" content="NOFOLLOW">

<link rel="stylesheet" type="text/css" href="templates/main_page/stylesheet.css">

<link rel="stylesheet" type="text/css" href="ext/niftycorners/niftyCorners.css">
<script type="text/javascript" src="ext/niftycorners/nifty.js"></script>

</head>

<body>

<div id="pageHeader">
  <div>
    <div style="float: right; padding-top: 40px; padding-right: 15px; color: #000000; font-weight: bold;"><a href="http://www.oscommerce.com" target="_blank">osCommerce Support Site</a> &nbsp;|&nbsp; <a href="http://www.oscommerce.info" target="_blank">Knowledge Base</a> &nbsp;|&nbsp; <a href="http://forums.oscommerce.com" target="_blank">Community Support Forums</a></div>

    <a href="index.php"><img src="images/oscommerce_logo-silver.jpg" border="0" width="250" height="50" title="osCommerce, Open Source E-Commerce Solutions" style="margin: 10px 10px 0px 10px;" /></a>
  </div>
</div>

<script type="text/javascript">
<!--
  if (NiftyCheck()) {
    Rounded("div#pageHeader", "all", "#FFFFFF", "#f7f7f5", "smooth border #b3b6b0");
  }
//-->
</script>

<div id="pageContent">
<?php require('templates/pages/' . $page_contents); ?>
</div>

<div id="pageFooter">
  Copyright &copy; 2000-2006 <a href="http://www.oscommerce.com" target="_blank">osCommerce</a> (<a href="http://www.oscommerce.com/about/copyright" target="_blank">Copyright Policy</a>, <a href="http://www.oscommerce.com/about/trademark" target="_blank">Trademark Policy</a>)<br />osCommerce provides no warranty and is redistributable under the <a href="http://www.fsf.org/licenses/gpl.txt" target="_blank">GNU General Public License</a>
</div>

</body>

</html>
