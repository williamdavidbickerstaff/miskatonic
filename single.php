<?php

//true = white
//false = black
define("theme", true);

function my_plugin_body_class($classes)
{
    $classes[] = theme ? 'bg-white' : 'bg-black';
    return $classes;
}

add_filter('body_class', 'my_plugin_body_class');
get_header();

if (em_is_event_page()):
    $event = em_get_event(get_the_ID(), 'post_id');
    $image = $event->output('#_EVENTIMAGE{medium}');
    $tags = $event->output('#_EVENTTAGS');
    $speaker = $event->output('#_CATEGORYNAME');
    $date = $event->output('#_EVENTSTARTDATE');
    $paylink = $event->output('#_ATT{paylink}');
    $ticket_price = $event->output('#_ATT{admission}');
    $watchlist = $event->output('#_ATT{watchlist}');
endif;
?>

<div class="mx-auto max-w-[1440px] pb-6
    <?php
    $text_col = theme ? 'text-black' : 'text-white';
    echo $text_col;
    ?>
">
    <div class="grid grid-cols-12 gap-6 mx-6">
        <div class="col-span-4 flex flex-col items-start justify-between pt-6 h-fit
        ">
            <a href="<?php echo home_url() ?>">
                <h1 class="title-style wordmark-element" data-wordmark>MIS</h1>
                <h1 class="title-style wordmark-element" data-wordmark>KA</h1>
                <h1 class="title-style wordmark-element" data-wordmark>TON</h1>
                <h1 class="title-style wordmark-element" data-wordmark>IC</h1>
            </a>

            <div class="col-span-2 flex flex-col items-start justify-between pt-6 gap-4">
                <h1 class="h1-style text-wrap wordmark-element" data-wordmark>
                    Institute of <br> Horror Studies
                </h1>
            </div>
        </div>

        <div class="col-start-5 col-span-8 pt-6 grid grid-cols-subgrid">

            <?php
            $navbar_col = (theme) ? 'light' : 'dark';
            echo insert_navbar($navbar_col)
                ?>

            <?php while (have_posts()):
                the_post(); ?>

                <?php if (has_post_thumbnail() && (!em_is_event_page())):
                    $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full'); ?>

                    <img class="col-span-8 mt-6 outline outline-offset-[-1px]" src="<?php echo $featured_image[0] ?>">
                    </img>

                <?php endif; ?>

                <?php if (em_is_event_page()): ?>
                    <div class="col-span-8 mt-6 relative [&_img]:w-full [&_img]:h-full [&_img]:object-cover">
                        <?= $image; ?>
                        <!-- Bottom-right badge -->
                        <div
                            class="absolute leading-none text-left bottom-4 right-4 outline w-48 p-2 bg-black text-white h4-style font-medium invert">
                            <?= $tags; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <h2 class="
                <?php $height = (em_is_event_page()) ? 'min-h-32' : '';
                echo $height; ?>
                h2-style col-span-4 mt-6
                ">
                    <?php
                    $title = get_the_title();
                    $title = preg_replace('/\s*\((online|london)\)\s*/i', '', $title);
                    echo $title;
                    ?>
                </h2>

                <?php
                if (em_is_event_page()):
                    ?>

                    <div
                        class="col-span-7 grid grid-cols-subgrid p-6 mt-6 bg-white outline outline-offset-[-1px] outline-black">
                        <!-- left text -->
                        <div class="col-span-4 justify-start flex flex-col gap-6">
                            <div>
                                <h2 class="h2-style">
                                    Speaker
                                </h2>
                                <p class="p-style-small">
                                    <?php
                                    echo $speaker;
                                    ?>
                                </p>
                            </div>
                            <div>
                                <h2 class="h2-style">
                                    Date and time
                                </h2>
                                <p class="p-style-small">
                                    <?php
                                    echo $date;
                                    ?>
                                </p>
                            </div>
                            <div>
                                <h2 class="h2-style">
                                    Admission
                                </h2>
                                <p class="p-style-small">
                                    Zoom registration links for each class are included in your order confirmation email from
                                    Billeto -- after registering, you'll receive a second email with the link to the Zoom
                                    session.
                                </p>
                            </div>
                        </div>
                        <!-- right text -->
                        <div class="col-span-3 justify-start flex flex-col gap-6">
                            <a href="<?php echo $paylink; ?>" class="block">
                                <div
                                    class="
                            bg-white outline outline-offset-[-1px] p-2.5 flex justify-between items-center invert-on-hover">
                                    <div class="justify-start p-style-small-medium">
                                        Individual Ticket
                                        <?= miskatonic_svg_ticket('class="w-auto relative inline-block h-[0.7em]"'); ?>
                                    </div>
                                    <div class="p-style-small-medium">
                                        <?php echo $ticket_price; ?>
                                    </div>
                                </div>
                            </a>
                            <div
                                class="
                            bg-white outline outline-offset-[-1px] p-2.5 flex justify-between items-center invert-on-hover">
                                <div class="justify-start p-style-small-medium">
                                    Online Semester Pass
                                    <?= miskatonic_svg_ticket('class="w-auto relative inline-block h-[0.7em]"'); ?>
                                </div>
                                <div class="p-style-small-medium">
                                    £10
                                </div>
                            </div>
                            <?php
                            if ($watchlist):
                                ?>
                                <a href="<?php echo $watchlist ?>" class="block">
                                    <div
                                        class="
                            bg-white outline outline-offset-[-1px] p-2.5 flex justify-between items-center invert-on-hover">
                                        <div class="justify-start p-style-small-medium">
                                            Watchlist
                                            <?= miskatonic_svg_ticket('class="w-auto relative inline-block h-[0.7em]"'); ?>
                                        </div>
                                        <div class="p-style-small-medium">
                                            £10
                                        </div>
                                    </div>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>


                <div class="col-span-8 w-[95%] mt-6 flex flex-col gap-6 post-content">
                    <?php the_content() ?>
                </div>


                <!-- Merch section !-->
                <?php if (em_is_event_page()): ?>

                    <section class="embla col-span-6 grid grid-cols-subgrid">

                        <div class="col-span-6 mt-24 flex items-center justify-between">
                            <h1 class="h1-style">
                                On sale at our talks
                            </h1>

                            <div class="embla__controls flex gap-4 items-center">
                                <!-- Dots -->
                                <div class="embla__dots"></div>
                            </div>
                        </div>

                        <!-- Carousel with arrows positioned on sides -->
                        <div class="col-span-6 mt-6 relative">
                            <!-- Previous Arrow - positioned on left -->
                            <button
                                class="embla__button embla__button--prev absolute left-0 top-1/2 -translate-y-1/2 z-10 p-2 hover:opacity-70 transition-opacity"
                                type="button" aria-label="Previous">
                                <?= page_turner_left('class="w-6 h-6"'); ?>
                            </button>

                            <!-- Next Arrow - positioned on right -->
                            <button
                                class="embla__button embla__button--next absolute right-0 top-1/2 -translate-y-1/2 z-10 p-2 hover:opacity-70 transition-opacity"
                                type="button" aria-label="Next">
                                <?= page_turner_right('class="w-6 h-6"'); ?>
                            </button>

                            <div class="embla__viewport">
                                <div class="embla__container">
                                    <div class="embla__slide">
                                        <div class="">
                                            <img class="self-stretch" src="https://placehold.co/212x299" />
                                            <p class="p-style-small mt-6">
                                                Bert Hardy RAF Men Poster A2
                                            </p>
                                        </div>
                                    </div>

                                    <div class="embla__slide">
                                        <div class="">
                                            <img class="self-stretch" src="https://placehold.co/212x148" />
                                            <p class="p-style-small mt-6">
                                                Boris Mikhailov: Yesterday's Sandwich Two Poster A2
                                            </p>
                                        </div>
                                    </div>

                                    <div class="embla__slide">
                                        <div class="">
                                            <img class="self-stretch" src="https://placehold.co/212x235" />
                                            <p class="p-style-small mt-6">
                                                Daido Moriyama Stray Dog Tote Bag
                                            </p>
                                        </div>
                                    </div>
                                    <div class="embla__slide">
                                        <div class="">
                                            <img class="self-stretch" src="https://placehold.co/212x299" />
                                            <p class="p-style-small mt-6">
                                                Bert Hardy RAF Men Poster A2
                                            </p>
                                        </div>
                                    </div>
                                    <div class="embla__slide">
                                        <div class="">
                                            <img class="self-stretch" src="https://placehold.co/212x299" />
                                            <p class="p-style-small mt-6">
                                                Bert Hardy RAF Men Poster A2
                                            </p>
                                        </div>
                                    </div>
                                    <div class="embla__slide">
                                        <div class="">
                                            <img class="self-stretch" src="https://placehold.co/212x299" />
                                            <p class="p-style-small mt-6">
                                                Bert Hardy RAF Men Poster A2
                                            </p>
                                        </div>
                                    </div>
                                    <div class="embla__slide">
                                        <div class="">
                                            <img class="self-stretch" src="https://placehold.co/212x299" />
                                            <p class="p-style-small mt-6">
                                                Bert Hardy RAF Men Poster A2
                                            </p>
                                        </div>
                                    </div>
                                    <div class="embla__slide">
                                        <div class="">
                                            <img class="self-stretch" src="https://placehold.co/212x299" />
                                            <p class="p-style-small mt-6">
                                                Bert Hardy RAF Men Poster A2
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </section>

                <?php endif; ?>
            <?php endwhile; ?>
        </div>
    </div>
</div>



<?php get_footer(); ?>