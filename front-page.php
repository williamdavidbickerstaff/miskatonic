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
if (class_exists('EM_Events')) {
    function debug_to_console($data)
    {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);

        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }

    $events = EM_Events::get(array(
        'limit' => 3,
        'orderby' => 'date'
    ));
    $events_length = count($events);

    // events
    $trimmed_names = [];
    $event_images = [];
    $event_instructors = [];
    $event_dates = [];
    $event_urls = [];
    $event_tickets = [];
    $event_tags = [];

    foreach ($events as $event) {
        #event name
        $event_name = $event->event_name;
        $words = explode(' ', $event_name);
        array_pop($words);
        $trimmed_name = implode(' ', $words);

        $event_image = $event->output('#_EVENTIMAGE{medium}');
        $event_date = $event->output('#_EVENTSTARTDATE');
        $event_instructor = $event->output('#_CATEGORYNAME');
        $event_url = $event->output('#_EVENTURL');
        $event_ticket = $event->output('#_ATT{paylink}');
        $event_tag = $event->output('#_EVENTTAGS');

        $trimmed_names[] = $trimmed_name;
        $event_images[] = $event_image;

        $event_dates[] = $event_date;
        $event_instructors[] = $event_instructor;
        $event_urls[] = $event_url;
        $event_tickets[] = $event_ticket;
        $event_tags[] = $event_tag;
    }

    //news

    $recent_news = new WP_Query(array(
        "posts_per_page" => "4",
        "orderby" => "date",
        "order" => "DESC",
    ));

    $news_titles = [];
    $news_contents = [];
    $news_thumbnails = [];
    $news_urls = [];

    if ($recent_news->have_posts()) {
        while ($recent_news->have_posts()) {
            $recent_news->the_post();

            $title = get_the_title();
            $content = get_the_excerpt();
            $thumbnail = get_the_post_thumbnail(null, 'large');
            $url = get_the_permalink();

            $news_titles[] = $title;
            $news_contents[] = $content;
            $news_thumbnails[] = $thumbnail;
            $news_urls[] = $url;
        }
    }

    $news_length = count($news_titles);
}
?>

<div class="mx-auto max-w-[1440px]">

    <!-- 
    ################################
    ||                            ||
    ||  Wordmark, Navbar & Hero   ||
    ||                            ||
    ################################
    -->

    <div class="grid grid-cols-12 gap-6 mx-6">
        <div class="col-span-4 flex flex-col items-start justify-between pt-6">
            <a href="<?= home_url() ?>" class="block">
                <div>
                    <h1 class="text-white title-style wordmark-element" data-wordmark>MIS</h1>
                    <h1 class="text-white title-style wordmark-element" data-wordmark>KA</h1>
                    <h1 class="text-white title-style wordmark-element" data-wordmark>TON</h1>
                    <h1 class="text-white title-style wordmark-element" data-wordmark>IC</h1>
                    <h1 class="h1-style col-span-2 mt-6 text-white text-wrap wordmark-element" data-wordmark>
                        Institute of <br> Horror Studies
                    </h1>
                </div>
            </a>
            <div class="w-[60%]">
                <a href="<?= get_page_link(15) ?>" class="block">
                    <h1 class="h1-style text-white text-wrap hover:underline decoration-2"> Upcoming talks </h1>
                </a>
                <p class="p-style text-white text-wrap mt-2">
                    Discover what talks, events and workshops we have coming up, online and in-person.
                </p>
            </div>
        </div>

        <div class="col-start-5 col-span-8 pt-6 grid grid-cols-subgrid">

            <?= insert_navbar('dark') ?>

            <?php if ($events_length > 0): ?>

                <div class="col-span-8 mt-6">
                    <div class="group col-span-8 relative [&_img]:w-full [&_img]:h-full [&_img]:object-cover">
                        <a href="<?= $event_urls[0]; ?>" class="absolute inset-0 z-10"></a>
                        <?= $event_images[0]; ?>
                        <!-- Bottom-right badge -->
                        <div
                            class="group-hover:invert animation duration-300 absolute leading-none text-left bottom-4 right-4 outline w-48 p-2 bg-black text-white h4-style font-medium">
                            <?= $event_tags[0]; ?>
                        </div>
                    </div>
                </div>

                <!-- info box -->
                <div class="col-span-4 grid grid-cols-subgrid h-[148px] mt-6">

                    <!-- left text -->
                    <div class="flex-col justify-between items-start inline-flex col-span-3">
                        <a href="<?= $event_urls[0] ?>" class="block">
                            <h2 class="text-white h2-style leading-none justify-start hover:underline">
                                <?php echo esc_html('' . $trimmed_names[0] . ''); ?>
                            </h2>
                        </a>
                        <!-- bottom left text  -->
                        <div class="justify-start">
                            <p class="text-white h3-style">
                                <?php echo $event_instructors[0] ?>
                            </p>
                            <p class="text-white h4-style">
                                <?php echo $event_dates[0] ?>
                            </p>
                        </div>
                    </div>

                    <!-- right text -->
                    <div class="col-span-1">
                        <a href="<?= $event_tickets[0] ?>" class="text-white link inline-flex items-center gap-2"> Tickets
                            <svg class="w-auto relative inline-block h-[0.7em] top-[0.1em]" width="11" height="11"
                                viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M0.21967 9.21967C-0.0732233 9.51256 -0.0732233 9.98744 0.21967 10.2803C0.512563 10.5732 0.987437 10.5732 1.28033 10.2803L0.75 9.75L0.21967 9.21967ZM10.5 0.749999C10.5 0.335786 10.1642 -7.69011e-07 9.75 -6.04039e-07L3 -7.41016e-07C2.58579 -7.23559e-07 2.25 0.335786 2.25 0.749999C2.25 1.16421 2.58579 1.5 3 1.5L9 1.5L9 7.5C9 7.91421 9.33579 8.25 9.75 8.25C10.1642 8.25 10.5 7.91421 10.5 7.5L10.5 0.749999ZM0.75 9.75L1.28033 10.2803L10.2803 1.28033L9.75 0.749999L9.21967 0.219669L0.21967 9.21967L0.75 9.75Z"
                                    fill="white" />
                            </svg>
                        </a>
                    </div>

                </div>

            <?php endif; ?>

        </div>
    </div>

    <!--
    ################################
    ||                            ||
    ||       Upcoming Talks       ||
    ||                            ||
    ################################
    -->


    <div class="grid grid-cols-12 gap-6 mt-6 mx-6">

        <?php for ($i = 1; $i < $events_length; $i++): ?>
            <div class="grid grid-cols-subgrid col-span-4">
                <!-- image -->
                <div
                    class="group relative col-span-4 aspect-[4.5/4] overflow-hidden [&_img]:w-full [&_img]:h-full [&_img]:object-cover">
                    <a href="<?= $event_urls[$i]; ?>" class="absolute inset-0 z-10"></a>
                    <?= $event_images[$i]; ?>
                    <!-- Bottom-right badge -->
                    <div
                        class="group-hover:invert transition duration-300 absolute leading-none text-left bottom-4 right-4 outline w-48 p-2 bg-black text-white h4-style font-medium">
                        <?= $event_tags[$i]; ?>
                    </div>
                </div>

                <div class="col-span-3 flex-col justify-between items-start inline-flex mt-6 h-[148px]">
                    <a href="<?= $event_urls[$i] ?>" class="block">
                        <h1 class="text-white h2-style leading-none justify-start hover:underline">
                            <?= $trimmed_names[$i] ?>

                        </h1>
                    </a>

                    <div class="justify-start">
                        <p class="text-white h3-style">
                            <?= $event_instructors[$i] ?>
                        </p>
                        <p class="text-white h4-style">
                            <?= $event_dates[$i] ?>
                        </p>
                    </div>

                </div>
                <div class="col-span-1 mt-6">
                    <a href="<?= $event_tickets[$i] ?>" class="text-white link inline-flex items-center gap-2"> Tickets
                        <svg class="w-auto relative inline-block h-[0.7em] top-[0.1em]" width="11" height="11"
                            viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0.21967 9.21967C-0.0732233 9.51256 -0.0732233 9.98744 0.21967 10.2803C0.512563 10.5732 0.987437 10.5732 1.28033 10.2803L0.75 9.75L0.21967 9.21967ZM10.5 0.749999C10.5 0.335786 10.1642 -7.69011e-07 9.75 -6.04039e-07L3 -7.41016e-07C2.58579 -7.23559e-07 2.25 0.335786 2.25 0.749999C2.25 1.16421 2.58579 1.5 3 1.5L9 1.5L9 7.5C9 7.91421 9.33579 8.25 9.75 8.25C10.1642 8.25 10.5 7.91421 10.5 7.5L10.5 0.749999ZM0.75 9.75L1.28033 10.2803L10.2803 1.28033L9.75 0.749999L9.21967 0.219669L0.21967 9.21967L0.75 9.75Z"
                                fill="white" />
                        </svg>
                    </a>
                </div>
            </div>
        <?php endfor; ?>

        <!-- #region  Element Three-->
        <div class="col-span-4">
            <div class="w-[60%] flex-col inline-flex item-start justify-start">
                <div>
                    <a href="">
                        <h2 class="h2-style hover:underline text-white leading-snug">Our Speakers</h2>
                    </a>
                    <p class="p-style text-white mt-2">Lorem ipsum dolor sit amet, consectetur adipiscing
                        elit. Aenean laoreet,</p>
                </div>
                <div class="mt-6">
                    <a href="">
                        <h2 class="h2-style hover:underline text-white leading-snug">Our Archive</h2>
                    </a>
                    <p class="p-style text-white mt-2">Lorem ipsum dolor sit amet, consectetur adipiscing
                        elit. Aenean laoreet,</p>
                </div>

            </div>
        </div>
        <!-- #endregion -->
    </div>


    <!-- 
    ################################
    ||                            ||
    ||      Semester Passes       ||
    ||                            ||
    ################################
    -->

    <div class="grid grid-cols-12 gap-6 mt-6 mx-6">
        <div class="col-start-8 col-span-5 bg-stone-900 border border-white">
            <div class="textbox p-6 text-white">
                <h2 class="h2-style">Semester passes now sold out</h2>
                <div class="w-[90%]">
                    <p class="col-span-4 p-style-light pt-2">
                        Next semester's passes will be available soon.
                    </p>
                    <p class="col-span-4 p-style-light pt-2">
                        Miskatonic Online offers monthly classes and a discounted full semester pass, open to everyone
                        in
                        the world (not geoblocked).
                    </p>
                    <p class="col-span-4 p-style-light pt-2">
                        Miskatonic London offers monthly classes and a discounted full semester pass.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!--
    ################################
    ||                            ||
    ||    Recent News Section     ||
    ||                            ||
    ################################
    -->

    <?php if ($news_length > 0): ?>

        <div class="grid grid-cols-12 gap-6 mt-6 p-6 bg-stone-900">
            <div class="col-span-4">
                <a href=" <?= get_page_link(2603); ?>" class="block">
                    <h1 class="hover:underline decoration-2 h1-style text-white leading-none">
                        Recent news
                    </h1>
                </a>
                <p class="p-style-light text-white w-[60%] text-wrap mt-2">
                    Discover what talks, events and workshops we have coming up, online and in-person.
                </p>
            </div>

            <div class="grid grid-cols-subgrid gap-6 col-span-12">

                <?php $test = true;
                if ($test == true): ?>
                    <?php for ($i = 0; $i < $news_length; $i++): ?>
                        <div class="grid grid-cols-subgrid 
                    <?php if ($i == 0) {
                        echo "col-span-8";
                    }
                    ; ?>
                    <?php if ($i > 0) {
                        echo "col-span-4";
                    }
                    ; ?>">

                            <div class="relative overflow-hidden [&_img]:w-full [&_img]:h-full [&_img]:object-cover
                            <?php if ($i == 0) {
                                echo "col-span-8 aspect-[7/4]";
                            }
                            ; ?>
                            <?php if ($i > 0) {
                                echo "col-span-4 aspect-[4.5/4]";
                            }
                            ; ?>
                            ">
                                <a href="<?= $news_urls[$i]; ?>" class="absolute inset-0 z-10"></a>
                                <?php echo $news_thumbnails[$i] ?>
                            </div>

                            <div class="mt-6 col-span-4
                                ">
                                <a href="<?= $news_urls[$i] ?>" class="block">
                                    <h2 class="h2-style text-white leading-none">
                                        <?php echo $news_titles[$i] ?>
                                    </h2>
                                </a>

                                <p class="p-style-light text-white mt-2">
                                    <?php echo $news_contents[$i] ?>
                                </p>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <!--
    ################################
    ||                            ||
    ||          About us          ||
    ||                            ||
    ################################
    -->
    <div class="col-span-12 p-6 relative">
        <div class="relative w-full aspect-[10/4] overflow-hidden">
            <!-- Background image -->
            <img src="/wp-content/uploads/2022/08/horse_hospital.jpeg" alt="The Horse Hospital"
                class="w-full h-full object-cover" />

            <!-- Gradient overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent"></div>

            <!-- Text overlay -->
            <div class="absolute bottom-6 left-6 text-white max-w-[20%]">
                <h2 class="h1-style text-white mb-2">About us</h2>
                <p class="p-style-light">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam tempus lectus sed lectus
                    finibus.
                </p>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>