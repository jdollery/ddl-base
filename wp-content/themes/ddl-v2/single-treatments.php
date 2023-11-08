<?php get_header(); ?>

<?php get_template_part('inc/banner'); ?>
<?php get_template_part('inc/sections'); ?>

<?php
    
$loop = new WP_Query( array(
  'post_type' => 'treatments', 
  'order'  => 'ASC', 
  'orderby' => 'menu_order',
  'post_parent' => get_the_ID(),
  'numberposts' => -1,
) );

if ( $loop->have_posts() ) { ?>

  <?php if ( !is_single(240) ) { //Hide on Orthodontcs Page ?>

    <section class="space-p">
      <ul class="loop">

      <?php  while ( $loop->have_posts() ) : $loop->the_post(); ?>

      <li class="loop__item">
        <?php get_template_part('inc/post'); ?>
      </li>

      <?php endwhile; wp_reset_query(); ?>

      </ul>
    </section>

  <?php } ?>

<?php } ?>

<?php get_footer();?>