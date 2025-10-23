<?php
function my_plugin_body_class($classes)
{
    $classes[] = 'bg-black';
    return $classes;
}
add_filter('body_class', 'my_plugin_body_class');
get_header();
?>

<!--
frontpage start
-->

<div class="mx-auto max-w-[1300px] px-6">
    <div class="grid grid-cols-12 gap-6 min-h-[300px]">
        <!-- Left section: spans 4 of 12 columns -->
        <!--this is the wordmark section -->
        <div class="col-span-4 flex flex-col items-start pt-6">
            <h1 class="text-white title-style wordmark-element" data-wordmark>MIS</h1>
            <h1 class="text-white title-style wordmark-element" data-wordmark>KA</h1>
            <h1 class="text-white title-style wordmark-element" data-wordmark>TON</h1>
            <h1 class="text-white title-style wordmark-element" data-wordmark>IC</h1>
            <h1 class="h1-style col-span-2 mt-6 text-white text-wrap wordmark-element" data-wordmark>
                Institute of <br> Horror Studies
            </h1>
        </div>
        <!-- end of the word mark section -->

        <div class="col-start-5 col-span-8 pt-6 text-gray-200">
            <ul class="flex flex-col gap-0">
                <li class="h-full h2-style leading-none menu-item" data-menu-item>
                    <label class="h-full flex items-center justify-start">Talks</label>
                </li>
                <li class="h-full h2-style leading-none menu-item" data-menu-item>
                    <label class="h-full flex items-center justify-start">Speakers</label>
                </li>
                <li class="h-full h2-style leading-none menu-item" data-menu-item>
                    <label class="h-full flex items-center justify-start">Archive</label>
                </li>
                <li class="h-full h2-style leading-none menu-item" data-menu-item>
                    <label class="h-full flex items-center justify-start">News</label>
                </li>
                <li class="h-full h2-style leading-none menu-item" data-menu-item>
                    <label class="h-full flex items-center justify-start">FAQ</label>
                </li>
                <li class="h-full h2-style leading-none menu-item" data-menu-item>
                    <label class="h-full flex items-center justify-start">About</label>
                </li>
                <li class="h-full h2-style leading-none menu-item" data-menu-item>
                    <label class="h-full flex items-center justify-start">Contact</label>
                </li>
            </ul>

            <?php
            $talks = em_get_events(array(
                'limit' => 3,
                'orderby' => 'event_start_date',
                'order' => 'DESC',
            ));
            ?>

            <div class="aspect-[3/2] w-full relative overflow-hidden pt-6">
                [events_list limit='3', orderby='event_start_date', order='DESC']
                #_EVENTIMAGE
                [/events_list]
            </div>
        </div>
    </div>
</div>


<?php get_footer(); ?>