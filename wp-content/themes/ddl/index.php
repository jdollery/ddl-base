<?php get_header(); ?>

<?php if ( have_posts() ) { ?>

  <?php get_template_part('inc/banner'); ?>

  <?php if( is_active_sidebar('sidebar') ) { ?>

  <div class="posts" id="mainContent">
    <div class="content">
      <div class="content__row">
        <div class="inner">
          <div class="inner__row">

            <?php while ( have_posts() ) : the_post(); ?>

              <?php if (is_sticky()) { ?>

                <article class="item item--sticky">

                  <?php get_template_part( 'inc/post' ); ?>

                </article>

              <?php } else { ?>

                <article class="item">

                  <?php get_template_part( 'inc/post' ); ?>

                </article>

              <?php } ?>

            <?php endwhile; ?>

            <?php echo pagination(); ?>

          </div>
        </div>
        <aside class="aside" role="complementary">
          <div class="aside__content" >
            <div class="aside__row">
              <?php dynamic_sidebar('sidebar'); ?>
            </div>
          </div>
        </aside>
      </div>
    </div>
  </div>
      
  <?php } else { ?>

  <div class="posts" id="mainContent">
    <div class="content">
      <div class="content__row">
        <div class="inner">
          <div class="inner__row">

            <?php while ( have_posts() ) : the_post(); ?>

              <?php if (is_sticky()) { ?>

                <article class="item">

                  <?php get_template_part( 'inc/post' ); ?>

                </article>

              <?php } else { ?>

                <article class="item">

                  <?php get_template_part( 'inc/post' ); ?>

                </article>

              <?php } ?>

            <?php endwhile; ?>

            <?php echo pagination(); ?>

          </div>
        </div>
      </div>
    </div>
  </div>

  <?php } ?>

<?php } else { ?>

  <?php get_template_part('inc/banner'); ?>

  <div class="posts" id="mainContent">
    <div class="content">
      <div class="content__row">
        <div class="inner">
          <div class="inner__row">
            <article class="post">
              Sorry, no posts yet.
            </article>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php } ?>

<?php get_footer();?>