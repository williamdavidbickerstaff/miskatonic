<?php
/**
 * Index Template
 * Displays recent news posts
 */

// ============================================
// SETUP
// ============================================

add_filter('body_class', function ($classes) {
    $classes[] = 'bg-black';
    return $classes;
});

get_header();

// ============================================
// DATA FETCHING
// ============================================

$news = [];

$news_query = new WP_Query([
    'posts_per_page' => 10,
    'orderby' => 'date',
    'order' => 'DESC',
]);

if ($news_query->have_posts()) {
    while ($news_query->have_posts()) {
        $news_query->the_post();
        $news[] = [
            'title' => get_the_title(),
            'content' => wp_trim_words(get_the_content(), 50, '...'),
            'thumbnail' => get_the_post_thumbnail(null, 'large'),
            'url' => get_the_permalink(),
        ];
    }
    wp_reset_postdata();
}

$news_count = count($news);
?>


<!-- ============================================
     HERO SECTION
     ============================================ -->

<div class="mx-auto max-w-[1440px] pb-6">
    <div class="grid grid-cols-12 gap-6 mx-6">

        <!-- Wordmark -->
        <div class="col-span-4 flex flex-col items-start justify-between pt-6 h-fit">
            <?= miskatonic_wordmark('News') ?>
        </div>

        <!-- Navbar & Featured Post -->
        <div class="col-start-5 col-span-8 pt-6 grid grid-cols-subgrid">
            <?= insert_navbar('dark') ?>

            <?php if ($news_count > 0): ?>
                <?php $featured = $news[0]; ?>

                <div class="col-span-8 grid grid-cols-subgrid pt-6">

                    <!-- Featured Post Image -->
                    <a href="<?= esc_url($featured['url']) ?>" class="
                            block col-span-4
                            aspect-[4.5/4] overflow-hidden
                            [&_img]:w-full [&_img]:h-full [&_img]:object-cover
                        ">
                        <?= $featured['thumbnail'] ?>
                    </a>

                    <!-- Featured Post Info -->
                    <div class="col-span-4">
                        <div class="flex flex-col justify-start items-start gap-4">

                            <!-- Title -->
                            <a href="<?= esc_url($featured['url']) ?>"
                                class="block text-white h2-style leading-6 hover:underline">
                                <?= esc_html($featured['title']) ?>
                            </a>

                            <!-- Content -->
                            <div class="self-stretch text-white p-style leading-6">
                                <?= esc_html($featured['content']) ?>
                            </div>

                            <!-- Links -->
                            <div class="flex flex-col justify-center items-start gap-2">
                                <a href="<?= esc_url($featured['url']) ?>" class="text-white link leading-4">
                                    Read more
                                </a>
                            </div>

                        </div>
                    </div>

                </div>
            <?php endif; ?>

        </div>
    </div>


    <!-- ============================================
         NEWS LIST
         ============================================ -->

    <div class="grid grid-cols-12 gap-6 mt-6 mx-6">

        <?php for ($i = 1; $i < $news_count; $i++): ?>
            <?php $article = $news[$i]; ?>

            <div class="col-start-5 col-span-8 grid grid-cols-subgrid">

                <!-- Post Image -->
                <a href="<?= esc_url($article['url']) ?>" class="
                        col-span-4
                        aspect-[4.5/4] overflow-hidden
                        [&_img]:w-full [&_img]:h-full [&_img]:object-cover
                    ">
                    <?= $article['thumbnail'] ?>
                </a>

                <!-- Post Info -->
                <div class="col-span-4">
                    <div class="flex flex-col justify-start items-start gap-4">

                        <!-- Title -->
                        <a href="<?= esc_url($article['url']) ?>"
                            class="block text-white h2-style leading-6 hover:underline">
                            <?= esc_html($article['title']) ?>
                        </a>

                        <!-- Content -->
                        <div class="self-stretch text-white p-style leading-6">
                            <?= esc_html($article['content']) ?>
                        </div>

                        <!-- Links -->
                        <div class="flex flex-col justify-center items-start gap-2">
                            <a href="<?= esc_url($article['url']) ?>" class="block text-white link leading-4">
                                Read more
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        <?php endfor; ?>

    </div>
</div>

<?php get_footer(); ?>