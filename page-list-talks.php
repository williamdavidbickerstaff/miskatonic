<?php
/*
Template Name: Talks List Layout
*/
?>

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
    $events = EM_Events::get(array(
        'limit' => 999,
        'orderby' => 'date'
    ));

    // events

    $trimmed_names = [];
    $event_images = [];
    $event_instructors = [];
    $event_dates = [];
    $event_excerpts = [];
    $event_urls = [];
    $event_tickets = [];

    $event_ids = [];
    $post_ids = [];

    $event_tags = [];
    $event_locations = [];

    $events_length = count($events);

    foreach ($events as $event) {
        #event name
        $event_name = $event->event_name;
        $words = explode(' ', $event_name);
        array_pop($words);
        $trimmed_name = implode(' ', $words);

        $event_image = $event->output('#_EVENTIMAGE{medium}');
        $event_date = $event->output('#_EVENTSTARTDATE');
        $event_instructor = $event->output('#_CATEGORYNAME');
        $event_excerpt = $event->output('#_EVENTEXCERPT{50,...}');
        $event_url = $event->output('#_EVENTURL');
        $event_ticket = $event->output('#_ATT{paylink}');

        $event_tag = $event->output('#_EVENTTAGS');
        $event_location = $event->output('#_EVENTLOCATION');

        $event_id = $event->event_id;
        $post_id = $event->post_id;


        $trimmed_names[] = $trimmed_name;
        $event_images[] = $event_image;
        $event_instructors[] = $event_instructor;
        $event_dates[] = $event_date;
        $event_excerpts[] = $event_excerpt;
        $event_urls[] = $event_url;
        $event_tickets[] = $event_ticket;
        $event_locations[] = $event_location;
        $event_tags[] = $event_tag;

        $event_ids[] = $event_id;
        $post_ids[] = $post_id;
    }
}
?>

<div class="mx-auto max-w-[1440px] pb-6">
    <div class="grid grid-cols-12 gap-6 mx-6">
        <div class="col-span-4 flex flex-col items-start justify-between pt-6 h-fit">

            <a href="<?php echo home_url() ?>">
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
                    Talks
                </h1>
            </div>
        </div>

        <div class="col-start-5 col-span-8 pt-6 grid grid-cols-subgrid">

            <?= insert_navbar('dark'); ?>

            <div class="col-span-8 grid grid-cols-subgrid pt-6">

                <!-- image -->
                <div
                    class="group relative col-span-4 aspect-[4.5/4] overflow-hidden [&_img]:w-full [&_img]:h-full [&_img]:object-cover">

                    <a href="<?= $event_urls[0]; ?>" class="absolute inset-0 z-10"></a>

                    <?= $event_images[0]; ?>
                    <!-- Bottom-right badge -->

                    <div
                        class="group-hover:invert transition duration-300 absolute leading-none text-left bottom-4 right-4 outline w-48 p-2 bg-black text-white h4-style font-medium">
                        <?= $event_tags[0]; ?>
                    </div>

                </div>

                <div class="col-span-4">
                    <div class="flex flex-col justify-start items-start gap-4">

                        <!-- title -->
                        <a href="<?= $event_urls[0] ?>" class="block">
                            <div class="justify-start text-white h2-style leading-6 hover:underline">
                                <?= $trimmed_names[0]; ?>
                            </div>
                        </a>

                        <!-- date and instructor -->
                        <div class="justify-start"><span class="text-white h4-style font-bold leading-snug">
                                <?= $event_instructors[0]; ?>
                                <br />
                            </span>
                            <span class="text-white h4-style leading-snug">
                                <?= $event_dates[0]; ?>
                            </span>
                        </div>

                        <!-- content -->
                        <div class="self-stretch justify-start text-white p-style leading-6">
                            <?= $event_excerpts[0]; ?>
                        </div>

                        <!-- links -->
                        <div class="flex flex-col justify-center items-start gap-2">
                            <a href="<?= $event_urls[0] ?>">
                                <div class="justify-start text-white link leading-4">
                                    Read more
                                </div>
                            </a>
                            <a href="<?= $event_tickets[0] ?>" class="block">
                                <div class="justify-start text-white link leading-4">
                                    Tickets
                                    <svg class="w-auto relative inline-block h-[0.7em]" width="11" height="11"
                                        viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M0.21967 9.21967C-0.0732233 9.51256 -0.0732233 9.98744 0.21967 10.2803C0.512563 10.5732 0.987437 10.5732 1.28033 10.2803L0.75 9.75L0.21967 9.21967ZM10.5 0.749999C10.5 0.335786 10.1642 -7.69011e-07 9.75 -6.04039e-07L3 -7.41016e-07C2.58579 -7.23559e-07 2.25 0.335786 2.25 0.749999C2.25 1.16421 2.58579 1.5 3 1.5L9 1.5L9 7.5C9 7.91421 9.33579 8.25 9.75 8.25C10.1642 8.25 10.5 7.91421 10.5 7.5L10.5 0.749999ZM0.75 9.75L1.28033 10.2803L10.2803 1.28033L9.75 0.749999L9.21967 0.219669L0.21967 9.21967L0.75 9.75Z"
                                            fill="white" />
                                    </svg>
                                </div>
                            </a>
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
        <div class="col-span-3 flex flex-col items-start justify-start gap-6 pt-6">
            <div class="w-full flex flex-col justify-start items-start gap-6">
                <h2 class="text-white h1-style">Autumn semester<br />2025</h2>

                <div class="flex flex-col gap-2">

                    <!-- All talks -->
                    <label class="flex items-center justify-betweenk gap-2 text-white cursor-pointer">
                        <span class="underline">All talks</span>
                        <input type="checkbox" class="appearance-none w-4 h-4 border border-white bg-transparent
                   checked:bg-white checked:border-white
                   focus:outline-none" />
                    </label>

                    <!-- London -->
                    <label class="flex items-center gap-2 justify-between text-white cursor-pointer">
                        <span class="underline">London</span>
                        <input type="checkbox" class="appearance-none w-4 h-4 border border-white bg-transparent
                   checked:bg-white checked:border-white
                   focus:outline-none" />
                    </label>

                    <!-- NYC -->
                    <label class="flex items-center gap-2 justify-between text-white cursor-pointer">
                        <span class="underline">NYC</span>
                        <input type="checkbox" class="appearance-none w-4 h-4 border border-white bg-transparent
                   checked:bg-white checked:border-white
                   focus:outline-none" />
                    </label>

                    <!-- Online -->
                    <label class="flex items-center gap-2 justify-between text-white cursor-pointer">
                        <span class="underline">Online</span>
                        <input type="checkbox" class="appearance-none w-4 h-4 border border-white bg-transparent
                   checked:bg-white checked:border-white
                   focus:outline-none" />
                    </label>
                </div>

                <div
                    class="w-full outline outline-offset-[-1px] bg-black text-white outline-white flex justify-between items-center px-2 py-2 invert-on-hover">
                    <span class="h4-style font-medium">Online Semester Pass
                        <svg class="w-auto relative inline-block h-[0.7em]" width="11" height="11" viewBox="0 0 11 11"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0.21967 9.21967C-0.0732233 9.51256 -0.0732233 9.98744 0.21967 10.2803C0.512563 10.5732 0.987437 10.5732 1.28033 10.2803L0.75 9.75L0.21967 9.21967ZM10.5 0.749999C10.5 0.335786 10.1642 -7.69011e-07 9.75 -6.04039e-07L3 -7.41016e-07C2.58579 -7.23559e-07 2.25 0.335786 2.25 0.749999C2.25 1.16421 2.58579 1.5 3 1.5L9 1.5L9 7.5C9 7.91421 9.33579 8.25 9.75 8.25C10.1642 8.25 10.5 7.91421 10.5 7.5L10.5 0.749999ZM0.75 9.75L1.28033 10.2803L10.2803 1.28033L9.75 0.749999L9.21967 0.219669L0.21967 9.21967L0.75 9.75Z"
                                fill="white" />
                        </svg>

                    </span>
                    <span class="text-white h4-style font-medium">Sold out</span>
                </div>

                <div
                    class="w-full outline outline-offset-[-1px] bg-black outline-white text-white flex justify-between items-center px-2 py-2 invert-on-hover">
                    <span class=" h4-style font-medium">London Semester Pass
                        <svg class="w-auto relative inline-block h-[0.7em]" width="11" height="11" viewBox="0 0 11 11"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0.21967 9.21967C-0.0732233 9.51256 -0.0732233 9.98744 0.21967 10.2803C0.512563 10.5732 0.987437 10.5732 1.28033 10.2803L0.75 9.75L0.21967 9.21967ZM10.5 0.749999C10.5 0.335786 10.1642 -7.69011e-07 9.75 -6.04039e-07L3 -7.41016e-07C2.58579 -7.23559e-07 2.25 0.335786 2.25 0.749999C2.25 1.16421 2.58579 1.5 3 1.5L9 1.5L9 7.5C9 7.91421 9.33579 8.25 9.75 8.25C10.1642 8.25 10.5 7.91421 10.5 7.5L10.5 0.749999ZM0.75 9.75L1.28033 10.2803L10.2803 1.28033L9.75 0.749999L9.21967 0.219669L0.21967 9.21967L0.75 9.75Z"
                                fill="white" />
                        </svg>
                    </span>
                    <span class="text-white h4-style font-medium">Sold out</span>
                </div>

                <div class="w-full flex flex-col gap-2">
                    <h3 class="text-white h2-style leading-6">Preview <br /> Spring Semester 2026</h3>
                    <p class="text-white p-style leading-4">Get a sneak peak at all the talks next semester...
                    </p>
                </div>
            </div>
        </div>

        <!-- 
    ################################
    ||                            ||
    ||           Posts            ||
    ||                            ||
    ################################
        -->

        <?php for ($i = 1; $i < $events_length; $i++): ?>
            <div class="col-start-5 col-span-8 grid grid-cols-subgrid pt-6">
                <!-- image -->

                <div
                    class="group relative col-span-4 aspect-[4.5/4] overflow-hidden [&_img]:w-full [&_img]:h-full [&_img]:object-cover">

                    <a href="<?= $event_urls[$i]; ?>" class="absolute inset-0 z-10"></a>

                    <?= $event_images[$i]; ?>
                    <!-- Bottom-right badge -->
                    <div
                        class="group-hover:invert animation duration-300 absolute leading-none text-left bottom-4 right-4 outline w-48 p-2 bg-black text-white h4-style font-medium">
                        <?= $event_tags[$i]; ?>
                    </div>
                </div>

                <div class="col-span-4">

                    <div class="flex flex-col justify-start items-start gap-4">

                        <a href="<?= $event_urls[$i] ?>" class="block">
                            <!-- title -->
                            <div class="justify-start text-white h2-style leading-6 hover:underline">
                                <?= $trimmed_names[$i]; ?>
                            </div>
                        </a>

                        <!-- date and instructor -->
                        <div class="justify-start"><span class="text-white h4-style font-bold leading-snug">
                                <?= $event_instructors[$i]; ?>
                                <br />
                            </span>
                            <span class="text-white h4-style leading-snug">
                                <?= $event_dates[$i]; ?>
                            </span>
                        </div>

                        <!-- content -->
                        <div class="self-stretch justify-start text-white p-style leading-6">
                            <?= $event_excerpts[$i]; ?>
                        </div>

                        <!-- links -->
                        <div class="flex flex-col justify-center items-start gap-2">
                            <a href="<?= $event_urls[$i] ?>">
                                <div class="justify-start text-white link leading-4">
                                    Read more
                                </div>
                            </a>
                            <a href="<?= $event_tickets[$i] ?>" class="block">
                                <div class="justify-start text-white link leading-4">
                                    Tickets
                                    <svg class="w-auto relative inline-block h-[0.7em]" width="11" height="11"
                                        viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M0.21967 9.21967C-0.0732233 9.51256 -0.0732233 9.98744 0.21967 10.2803C0.512563 10.5732 0.987437 10.5732 1.28033 10.2803L0.75 9.75L0.21967 9.21967ZM10.5 0.749999C10.5 0.335786 10.1642 -7.69011e-07 9.75 -6.04039e-07L3 -7.41016e-07C2.58579 -7.23559e-07 2.25 0.335786 2.25 0.749999C2.25 1.16421 2.58579 1.5 3 1.5L9 1.5L9 7.5C9 7.91421 9.33579 8.25 9.75 8.25C10.1642 8.25 10.5 7.91421 10.5 7.5L10.5 0.749999ZM0.75 9.75L1.28033 10.2803L10.2803 1.28033L9.75 0.749999L9.21967 0.219669L0.21967 9.21967L0.75 9.75Z"
                                            fill="white" />
                                    </svg>
                                </div>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        <?php endfor; ?>
    </div>



</div>

<?php get_footer(); ?>