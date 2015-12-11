<? // single.php - show single post ?>

<? get_header(); ?> 

	<? while (have_posts()) : the_post(); ?>	

		<? the_post_thumbnail('large'); ?>

		<h1><? the_title(); ?></h1>	

		<? if($post->post_excerpt) : ?>
			<div class="intro"><? the_excerpt(); ?></div>
		<? endif; ?>

		<? the_content(); ?>

	<? endwhile; ?>


<? get_footer(); ?> 
	