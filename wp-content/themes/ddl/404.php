<?php get_header(); ?>

<?php get_template_part('template-parts/component', 'banner'); ?>

<article class="article">
  <div class="content">
    <div class="content__row">
      <div class="inner">
        <p>This could have happened because the link is broken or the page has moved. Perhaps searching can help?</p>
        <?php get_template_part('template-parts/component', 'search'); ?>
      </div>
    </div>
  </div>
</article>

<?php get_footer(); ?>