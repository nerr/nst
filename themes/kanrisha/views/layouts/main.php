<?php 
	/* @var $this Controller */ 
	$csspath = Yii::app()->request->baseUrl."/themes/kanrisha/css/";
	$jspath  = Yii::app()->request->baseUrl."/themes/kanrisha/js/";
	$imgpath = Yii::app()->request->baseUrl."/themes/kanrisha/img/";

	include("header.php");
?>

<?php echo $content; ?>

<?php include("footer.php"); ?>