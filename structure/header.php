<!doctype HTML>
<? global $artist;?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>
        	<?=$artist;?>
        </title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link rel="stylesheet" href="structure/css/style.css" />
        <link rel="stylesheet" href="view/css/theme.css" />
        <link href="<?= URL;?>/dashboard/assets/css/bootstrap.css" rel="stylesheet">
        <link href="<?= URL;?>/dashboard/assets/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="<?= URL;?>/dashboard/assets/css/ui-lightness/jquery-ui-1.10.1.custom.css" rel="stylesheet">
        <link href="<?= URL;?>/dashboard/assets/sm/360/360player.css" rel="stylesheet">
        <link href="<?= URL;?>/dashboard/assets/sm/flashblock.css" rel="stylesheet">
        
        <style>
        <? $theme = get_theme($artist);
	       echo $theme->theme_css;
        ?>
        </style>
        
	</head>
<body>
<div class="pageContainer container">
	<div id="main">
	    <div class="headerContainer row">
	    	<div class="span12">
	       		<h1><?=$artist;?></h1>
	       		<div class="banner"></div>
	    	</div>
	    </div>
	    <div class="contentContainer">