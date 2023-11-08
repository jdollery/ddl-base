<?php

if( have_rows('split_section') ){

  while( have_rows('split_section') ): the_row(); 

  $split_hide = get_sub_field('split_hide');
  $split_bg = get_sub_field('split_bg');
  $split_location = get_sub_field('split_location');
  $split_spacing = get_sub_field('split_spacing');
  $split_img = get_sub_field('split_img');
  $split_video = get_sub_field('split_video');
  $split_embed = get_sub_field('split_embed');
  $split_poster = get_sub_field('split_poster');
  $split_text = get_sub_field('split_text');

  if ($split_hide == false) {

  ?>

  <section class="split split--<?php echo esc_html($split_location['value']); ?> bg-<?php echo esc_html($split_bg['value']); ?><?php if($split_spacing && in_array('top', $split_spacing)) { ?> space-p-t<?php } ?><?php if($split_spacing && in_array('bottom', $split_spacing)) { ?> space-p-b<?php } ?>">

    <div class="split__row">

      <div class="split__one" >  
        <div class="split__media" >

          <?php if($split_video) { ?>
            <img id="videoToggle" src="<?php echo $split_poster ?>" alt="<?php the_sub_field('title'); ?>" data-url="<?php echo $split_video ?>">
          <?php } elseif($split_embed) { ?>
            <?php echo $split_embed ?>
          <?php } else { ?>
            <img src="<?php echo esc_url($split_img['url']); ?>" alt="<?php echo $split_img['alt']; ?>" loading="lazy" width="900" height="750">
          <?php } ?>
        
        </div>
      </div>

      <div class="split__two">
        <?php echo $split_text ?>
      </div>

    </div>

  </section>

  <?php

  }

  endwhile; wp_reset_postdata();  

} 

?>