<?php 

$post = get_queried_object();
setup_postdata( $post );

$page_id = ( 'page' == get_option( 'show_on_front' ) ? get_option( 'page_for_posts' ) : get_the_ID() );
$blog_description = esc_attr( get_post_meta( $page_id, 'title_description', true )); 

$archive_title = get_the_archive_title(); 
$archive_description = get_the_archive_description();

$blog_title = get_the_title( get_option('page_for_posts', true) );

$banner_alt_title = get_field('banner_alt_title');
$banner_alt_excerpt = get_field('banner_alt_excerpt');
$banner_cta = 'banner_cta';

?>

<div class="banner<?php if ( is_front_page() ) { ?> banner--home<?php } ?>">

  <?php  if ( is_front_page() ) {  //static home ?>

    <video playsinline autoplay loop muted poster="<?php echo get_template_directory_uri(); ?>/assets/img/placeholder-poster.jpg">
      <source src="<?php echo get_template_directory_uri(); ?>/assets/video/placeholder-video-compressed.mp4" type="video/mp4">
      Sorry, your browser doesn’t support embedded videos.
    </video>

  <?php } elseif ( has_post_thumbnail() ) { 
    
    // $thumb_id = get_post_thumbnail_id( $post->ID );
    // $thumb_alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
    // $thumb_title = get_the_title($thumb_id);
    // $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'full', true);
    // $thumb_url = $thumb_url_array[0];    

    $thumb_id = get_post_thumbnail_id( $post->ID );
    $thumb_alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
    $thumb_title = get_the_title($thumb_id);

    $thumb_url_array_lg = wp_get_attachment_image_src($thumb_id, 'banner_lg', true);
    $thumb_url_array_sm = wp_get_attachment_image_src($thumb_id, 'banner_sm', true);

    $thumb_url_lg = $thumb_url_array_lg[0];
    $thumb_url_sm = $thumb_url_array_sm[0];
    
    ?>

    <picture>
      <source type="image/jpg" media="(min-width: 480px)" srcset="<?php echo $thumb_url_lg ?>">
      <source type="image/jpg" media="(max-width: 479px)" srcset="<?php echo $thumb_url_sm ?>">
      <img 
        class="banner__img"
        src="<?php echo $thumb_url_lg ?>"
        alt="<?php if($thumb_alt){ echo $thumb_alt; } else { the_title(); } ?>"
        width="1920" 
        height="1080"
        decoding="async"
      >
    </picture>

    <!-- <img 
      class="banner__img"
      src="<?php echo $thumb_url ?>"
      alt="<?php if($thumb_alt){ echo $thumb_alt; } else { the_title(); } ?>"
      width="1920" 
      height="1080"
      loading="lazy"
      decoding="async"
    > -->

  <?php // } else { ?>

    <!-- <img 
      class="banner__img"
      src="<?php echo get_template_directory_uri(); ?>/assets/img/placeholder-banner.jpg"
      alt="<?php echo get_bloginfo( 'name' ) ?>"
      width="1920" 
      height="1080"
      loading="lazy"
      decoding="async"
    > -->

  <?php } ?>

  <div class="space-p">
    <div class="cell-row">
      <div class="cell-6">

        <?php if ( is_front_page() && is_home() ) { //home/blog ?>

          <h1 class="banner__title"><?php bloginfo( 'name' ); ?></h1>

          <?php if( bloginfo('description') ) { ?>
            <h4 class="banner__intro"><?php bloginfo( 'description' ); ?></h4>
          <?php } ?>

        <?php } elseif ( is_front_page() ) { //static home ?>

          <h1 class="banner__title"><?php bloginfo( 'name' ); ?></h1>

          <?php if($banner_alt_excerpt) { ?>
            <div class="banner__intro"><?php echo $banner_alt_excerpt ?></div>
          <?php } elseif( has_excerpt() ) { ?>
            <div class="banner__intro"><?php echo strip_tags( the_excerpt() ); ?></div>
          <?php } elseif( bloginfo('description') ) { ?>
            <div class="banner__intro"><?php bloginfo( 'description' ); ?></div>
          <?php } ?>

        <?php } elseif ( is_home() ) { //static blog ?>

          <?php $blogTitle = get_the_title( get_option('page_for_posts', true) ); ?>

          <h1 class="banner__title"><?php echo $blogTitle ?></h1>

          <?php get_template_part('inc/breadcrumb'); ?>

          <?php if($banner_alt_excerpt) { ?>
            <div class="banner__intro"><?php echo $banner_alt_excerpt ?></div>
          <?php } elseif( has_excerpt() ) { ?>
            <div class="banner__intro"><?php echo strip_tags( the_excerpt() ); ?></div>
          <?php } ?>

        <?php } elseif ( is_archive() ) { ?>

          <?php 
            $archiveTitle = get_the_archive_title(); 
            $archiveDescription = get_the_archive_description();
          ?>

          <h1 class="banner__title"><?php echo $archiveTitle; ?></h1>

          <?php get_template_part('inc/breadcrumb'); ?>

          <?php if($archiveDescription) { ?>
            <div class="banner__intro"><?php echo $archiveDescription ?></div>
          <?php } ?>

        <?php } elseif ( is_search() ) { ?>

          <h1 class="banner__title">Search results</h1>
          <div class="banner__intro"><h4><?php printf( esc_html__( 'You searched for: %s', 'ddl' ), '<span>' . get_search_query() . '</span>' );?></h4></div>

        <?php } elseif ( is_404() ) { ?>

          <h1 class="banner__title">Sorry, page not found.</h1>

        <?php } elseif ( is_singular( 'post' ) ) { ?>

          <?php $categories_list = preg_replace('/<a /', '<li><a ', get_the_category_list( ', ' )); ?>

          <h1 class="banner__title"><?php the_title(); ?></h1>

          <?php get_template_part('inc/breadcrumb'); ?>

          <div class="banner__meta">
            <ul class="banner__categories"><?php echo $categories_list ?></ul>
            <time class="banner__date"><i class="far fa-calendar"></i> <?php echo get_the_date(); ?></time>
          </div>

        <?php } else { ?>

          <?php if($banner_alt_title) { ?>
            <h1 class="banner__title"><?php echo $banner_alt_title ?></h1>
          <?php } else { ?>
            <h1 class="banner__title"><?php the_title(); ?></h1>
          <?php } ?>

          <?php get_template_part('inc/breadcrumb'); ?>

          <?php if($banner_alt_excerpt) { ?>
            <div class="banner__intro"><?php echo $banner_alt_excerpt ?></div>
          <?php } elseif( has_excerpt() ) { ?>
            <div class="banner__intro"><?php echo strip_tags( the_excerpt() ); ?></div>
          <?php } ?>

          <?php if( have_rows($banner_cta) ) { 

            while( have_rows($banner_cta) ): the_row(); 

            $banner_btn = get_sub_field('banner_btn');

            $banner_btn_url = $banner_btn['url'];
            $banner_btn_text = $banner_btn['title'];
            $banner_btn_target = $banner_btn['target'] ? $banner_btn['target'] : '_self';

            ?>

            <a class="btn btn--black btn--inline" href="<?php echo esc_url( $banner_btn_url ); ?>" target="<?php echo esc_attr( $banner_btn_target ); ?>">
              <?php echo esc_html( $banner_btn_text ); ?>
            </a>

            <?php endwhile; wp_reset_query();  ?>

          <?php } ?>

        <?php } ?>

      </div>
    </div>
  </div>

</div>