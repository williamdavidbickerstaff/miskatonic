<?php
/**
 * Template Name: Single Page
 * About page template for company information
 */

// ============================================
// THEME CONFIGURATION
// ============================================

// true = light theme (white bg), false = dark theme (black bg)
define('THEME_IS_LIGHT', true);

$theme_bg = THEME_IS_LIGHT ? 'bg-white' : 'bg-black';
$theme_text = THEME_IS_LIGHT ? 'text-black' : 'text-white';
$theme_navbar = THEME_IS_LIGHT ? 'light' : 'dark';

add_filter('body_class', function ($classes) use ($theme_bg) {
    $classes[] = $theme_bg;
    return $classes;
});

get_header();
?>


<!-- ============================================
     MAIN CONTENT
     ============================================ -->

<div class="mx-auto max-w-[1440px] pb-6 <?= $theme_text ?>">
    <div class="grid grid-cols-12 gap-6 mx-6">

        <!-- Wordmark -->
        <div class="col-span-4 flex flex-col items-start justify-between pt-6 h-fit">
            <?= miskatonic_wordmark(esc_html(get_the_title()), '') ?>
        </div>

        <!-- Main Content Area -->
        <div class="col-start-5 col-span-8 pt-6 grid grid-cols-subgrid">
            <?= insert_navbar($theme_navbar) ?>

            <?php while (have_posts()):
                the_post(); ?>

                <!-- Featured Image -->
                <?php if (has_post_thumbnail()): ?>
                    <?php $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full'); ?>
                    <div class="col-span-8 mt-6 relative aspect-hero overflow-hidden">
                        <img class="w-full h-full object-cover" src="<?= esc_url($featured_image[0]) ?>"
                            alt="<?= esc_attr(get_the_title()) ?>" />
                    </div>
                <?php endif; ?>

                <!-- Page Content -->
                <div class="col-span-8 w-[95%] mt-6 flex flex-col gap-6 post-content">
                    <?php the_content(); ?>
                </div>

            <?php endwhile; ?>
        </div>

    </div>
</div>

<?php get_footer(); ?>