<?php
/*
Template Name: Food Gallery
*/
get_header(); ?>

<div class="content-wrapper">
  <form method="get" class="search-bar">
    <input type="text" name="s" placeholder="Search my cooking..." value="<?php the_search_query(); ?>" />
    <button type="submit">Search</button>
  </form>

  <div class="gallery">
    <?php
    $search = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
    $args = [
      'post_type' => 'attachment',
      'post_mime_type' => 'image',
      'post_status' => 'inherit',
      'posts_per_page' => -1,
    ];
    $images = get_posts($args);
    if ($search) {
      $images = array_filter($images, function ($img) use ($search) {
        $note = get_post_meta($img->ID, 'food_notes', true);
        return stripos($note, $search) !== false;
      });
    }

    foreach ($images as $image) {
      $img_url = wp_get_attachment_url($image->ID);
      $notes = get_post_meta($image->ID, 'food_notes', true);
      ?>
      <div class="card">
        <div class="card-inner">
          <div class="card-front">
                <img src="<?= esc_url($img_url); ?>" alt="<?= esc_attr($notes ?: 'Food photo'); ?>" />
          </div>
          <div class="card-back">
            <p><?= esc_html($notes ?: 'No notes yet.') ?></p>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>

<script>
  document.querySelectorAll('.card').forEach(card => {
    card.addEventListener('click', () => {
      card.classList.toggle('flipped');
    });
  });
</script>

<?php get_footer(); ?>
