<!doctype html>
<html lang="no">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php bloginfo('description'); ?>">
	<title><?php wp_title('|',true,'right'); ?></title>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">

	<?php wp_head(); ?>

    <!--[if lt IE 9]>
      <script src="//cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.js"></script>
      <script src="//cdn.jsdelivr.net/respond/1.4.2/respond.min.js"></script>
    <![endif]-->	

</head>

<body <?php body_class(); ?>>

	<div class="navbar">
		<img src="<? bloginfo('template_url')?>/img/logo.png" alt="Logo" class="logo">
		<nav>
			<ul>
				<? wp_nav_menu(array('menu' => 'main', 'container' => false, 'items_wrap' => '%3$s', 'depth' => 1)); ?>
			</ul>
		</nav>
	</div>