<?php 
/*
Template Name: Food Gallery
*/
get_header(); 
?>

<form method="get" class="search-bar" style="text-align:center; margin-bottom: 30px;">
  <input type="text" name="s" placeholder="Search my cooking..." value="<?php echo esc_attr(get_search_query()); ?>" />
  <button type="submit">Search</button>
</form>

<div class="gallery">

  <?php
  
  $search_query = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';

  $args = [
    'post_type' => 'attachment',
    'post_mime_type' => 'image',
    'post_status' => 'inherit',
    'posts_per_page' => -1,
  ];

  $images = get_posts($args);

  if ($search_query) {
    $images = array_filter($images, function ($image) use ($search_query) {
      $note = get_post_meta($image->ID, 'food_notes', true);
      return stripos($note, $search_query) !== false;
    });
  }

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
