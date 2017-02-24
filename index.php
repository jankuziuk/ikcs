<?php
/**
* Template Name: Custom Template
* MultiEdit: Right,Bottom,Left
*/

get_header(); ?>

<main class="main">
	<div class="container-fluid">
		<section class="content-wr">
			<?php if($GLOBALS['custom_options']['grid_type'] == 'two' || $GLOBALS['custom_options']['grid_type'] == 'one_left'): ?>
				<?php get_sidebar('left'); ?>
			<?php endif; ?>

			<section class="content">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php
						write_iksc_sections(1);
					?>
					<?php the_content(); ?>
				<?php endwhile; endif; ?>
			</section>

			<?php if($GLOBALS['custom_options']['grid_type'] == 'two' || $GLOBALS['custom_options']['grid_type'] == 'one_right'): ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>

		</section>
	</div>
</main>

<?php get_footer(); ?>