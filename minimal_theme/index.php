<? // index.php - show frontpage, or show custom page and list of posts ?>

<? get_header(); ?> 

	<? // show front page ?>

	<? // http://codex.wordpress.org/Class_Reference/WP_Query ?>
	<? $query = new WP_Query('pagename=forside'); ?>
	<? while ($query->have_posts()) : $query->the_post(); ?>	

			<? the_post_thumbnail('medium'); ?>

			<h1><? the_title(); ?></h1>		
			
			<? if($post->post_excerpt) : ?>
				<div class="intro"><? the_excerpt(); ?></div>
			<? endif; ?>	

			<? the_content() ?>

	<? endwhile; ?>
	<?php wp_reset_query(); ?>



	<? // show list of posts ?>
	<? /*

	<? // http://codex.wordpress.org/Class_Reference/WP_Query ?>
	<? $query = new WP_Query(array ('orderby' => 'date', 'order' => 'ASC' ) ); ?>
	<? while ($query->have_posts()) : $query->the_post(); ?>	

		<div class="post">
			<a href="<? the_permalink(); ?>"><? the_post_thumbnail('medium'); ?></a>

			<h3><a href="<? the_permalink(); ?>"><? the_title(); ?></a></h3>		

			<div>		
				<? the_excerpt(); ?>
			</div>	

		</div>	

	<? endwhile; ?>	
	<?php wp_reset_query(); ?>

	*/ ?>



<? get_footer(); ?> 
	