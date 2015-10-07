<? // page.php - show single page (+ list og childpages) ?>

<? get_header(); ?> 


	<? // http://codex.wordpress.org/Class_Reference/WP_Query ?>
	<? while ( have_posts() ) : the_post(); ?>

		<? the_post_thumbnail('medium'); ?>

		<h1><? the_title(); ?></h1>		

		<? if($post->post_excerpt) : ?>
			<div class="intro"><? the_excerpt(); ?></div>
		<? endif; ?>			
	
		<? the_content(); ?>

	<? endwhile; ?>


	<? // list childpages ?>
	<? /*
	<div class="childpages">

		<h2>Undersider</h2>

		<? $childPages = new WP_Query(array (
			'post_parent' => $wp_query->post->ID,
			'post_type' => 'page'
		)); ?>

		<? while ($childPages->have_posts()) : $childPages->the_post(); ?>	

			<div class="childpage">
				<? the_post_thumbnail('thumbnail'); ?>
				<a href="<? the_permalink(); ?>"><? the_title(); ?></a>
				<? echo get_the_excerpt(); ?>
			</div>

		<? endwhile; ?>	
		<?php wp_reset_query(); ?>
		
	</div>
	*/ ?>


<? get_footer(); ?> 
	

