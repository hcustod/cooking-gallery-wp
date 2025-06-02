<?php get_header(); ?>

<div class="gallery">

  <?php
  $images = get_posts([
    'post_type' => 'attachment',
    'post_mime_type' => 'image',
    'post_status' => 'inherit',
    'posts_per_page' => -1,
  ]);

  foreach ($images as $image) {
    $notes = get_post_meta($image->ID, 'food_notes', true);
    $img_url = wp_get_attachment_url($image->ID);
    ?>
    <div class="card" onclick="this.classList.toggle('flipped')">
      <div class="front">
        <img src="<?= esc_url($img_url); ?>" />
      </div>
      <div class="back">
        <p><?= esc_html($notes ?: 'No notes yet.') ?></p>
      </div>
    </div>
  <?php } ?>

</div>

<?php get_footer(); ?>