<?php
function my_plugin_body_class($classes)
{
    $classes[] = 'bg-black';
    return $classes;
}
add_filter('body_class', 'my_plugin_body_class');
get_header();

?>
<?php
$recent_news = new WP_Query(array(
    "posts_per_page" => "10",
    "orderby" => "date",
    "order" => "DESC",
));

$news_titles = [];
$news_contents = [];
$news_thumbnails = [];

if ($recent_news->have_posts()) {
    while ($recent_news->have_posts()) {
        $recent_news->the_post();

        $title = get_the_title();
        $content = get_the_excerpt();
        $thumbnail = get_the_post_thumbnail(null, 'large');

        $news_titles[] = $title;
        $news_contents[] = $content;
        $news_thumbnails[] = $thumbnail;
    }
}
$news_count = count($news_titles);
?>

<div class="mx-auto max-w-[1440px] pb-6">
    <div class="grid grid-cols-12 gap-6 mx-6">
        <div class="col-span-4 flex flex-col items-start justify-between pt-6 h-fit">
            <a href="<?= home_url() ?>" class="block">
                <h1 class="text-white title-style wordmark-element" data-wordmark>MIS</h1>
                <h1 class="text-white title-style wordmark-element" data-wordmark>KA</h1>
                <h1 class="text-white title-style wordmark-element" data-wordmark>TON</h1>
                <h1 class="text-white title-style wordmark-element" data-wordmark>IC</h1>
            </a>

            <div class="col-span-2 flex flex-col items-start justify-between pt-6 gap-4">
                <h1 class="h1-style text-white text-wrap wordmark-element" data-wordmark>
                    Institute of <br> Horror Studies
                </h1>

                <div class="w-6 h-0 outline outline-white wordmark-element" data-wordmark></div>

                <h1 class="h1-style text-white text-wrap wordmark-element" data-wordmark>
                    News
                </h1>
            </div>
        </div>

        <div class="col-start-5 col-span-8 pt-6 grid grid-cols-subgrid">

            <?= insert_navbar('dark') ?>

            <div class="col-span-8 grid grid-cols-subgrid pt-6">
                <!-- image -->
                <div
                    class="col-span-4 aspect-[4.5/4] overflow-hidden [&_img]:w-full [&_img]:h-full [&_img]:object-cover">
                    <?= $news_thumbnails[0]; ?>
                </div>

                <div class="col-span-4">
                    <div class="flex flex-col justify-start items-start gap-4">

                        <!-- title -->
                        <div class="justify-start text-white h2-style leading-6">
                            <?= $news_titles[0]; ?>
                        </div>

                        <!-- content -->
                        <div class="self-stretch justify-start text-white p-style leading-6">
                            <?= $news_contents[0]; ?>
                        </div>

                        <!-- links -->
                        <div class="flex flex-col justify-center items-start gap-2">
                            <div class="justify-start text-white link leading-4">
                                Read more
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- 
    ################################
    ||                            ||
    ||        Filter Box          ||
    ||                            ||
    ################################
    -->

    <div class="grid grid-cols-12 gap-6 mx-6">

        <!-- 
    ################################
    ||                            ||
    ||           Posts            ||
    ||                            ||
    ################################
        -->

        <?php for ($i = 1; $i < $news_count; $i++): ?>
            <div class="col-start-5 col-span-8 grid grid-cols-subgrid pt-6">
                <!-- image -->
                <div class="col-span-4 aspect-[4.5/4] overflow-hidden [&_img]:w-full [&_img]:h-full [&_img]:object-cover">
                    <?= $news_thumbnails[$i]; ?>
                </div>

                <div class="col-span-4">
                    <div class="flex flex-col justify-start items-start gap-4">

                        <!-- title -->
                        <div class="justify-start text-white h2-style leading-6">
                            <?= $news_titles[$i]; ?>
                        </div>

                        <!-- content -->
                        <div class="self-stretch justify-start text-white p-style leading-6">
                            <?= $news_contents[$i]; ?>
                        </div>

                        <!-- links -->
                        <div class="flex flex-col justify-center items-start gap-2">
                            <div class="justify-start text-white link leading-4">
                                Read more
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        <?php endfor; ?>
    </div>



</div>

<?php get_footer(); ?>