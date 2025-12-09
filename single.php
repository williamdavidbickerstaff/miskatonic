<?php
/**
 * Single Post/Event Template
 * Handles both regular posts and Events Manager events
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

// ============================================
// DATA FETCHING
// ============================================

$is_event = em_is_event_page();
$current_event = null;
$related_events = [];

if ($is_event) {
    // Current Event Data
    $event = em_get_event(get_the_ID(), 'post_id');
    $current_event_id = $event->event_id;

    $current_event = [
        'image' => $event->output('#_EVENTIMAGE{medium}'),
        'tags' => $event->output('#_EVENTTAGS'),
        'speaker' => $event->output('#_CATEGORYNAME'),
        'date' => $event->output('#_EVENTSTARTDATE'),
        'paylink' => $event->output('#_ATT{paylink}'),
        'ticket_price' => $event->output('#_ATT{admission}'),
        'watchlist' => $event->output('#_ATT{watchlist}'),
        'is_active' => $event->start()->getTimestamp() > current_time('timestamp'),
    ];

    // Related Events (excluding current)
    if (class_exists('EM_Events')) {
        $all_events = EM_Events::get([
            'limit' => 3,
            'orderby' => 'date'
        ]);

        $filtered = array_filter($all_events, function ($evt) use ($current_event_id) {
            return $evt->event_id !== $current_event_id;
        });

        $filtered = array_slice(array_values($filtered), 0, 2);

        foreach ($filtered as $evt) {
            $name_words = explode(' ', $evt->event_name);
            array_pop($name_words);

            $related_events[] = [
                'name' => implode(' ', $name_words),
                'image' => $evt->output('#_EVENTIMAGE{medium}'),
                'date' => $evt->output('#_EVENTSTARTDATE'),
                'instructor' => $evt->output('#_CATEGORYNAME'),
                'url' => $evt->output('#_EVENTURL'),
                'ticket_url' => $evt->output('#_ATT{paylink}'),
                'tag' => $evt->output('#_EVENTTAGS'),
            ];
        }
    }
}

$related_count = count($related_events);

// Merch items for carousel
$merch_items = [
    ['image' => 'https://placehold.co/212x299', 'title' => 'Bert Hardy RAF Men Poster A2'],
    ['image' => 'https://placehold.co/212x148', 'title' => 'Boris Mikhailov: Yesterday\'s Sandwich Two Poster A2'],
    ['image' => 'https://placehold.co/212x235', 'title' => 'Daido Moriyama Stray Dog Tote Bag'],
    ['image' => 'https://placehold.co/212x299', 'title' => 'Bert Hardy RAF Men Poster A2'],
    ['image' => 'https://placehold.co/212x299', 'title' => 'Bert Hardy RAF Men Poster A2'],
    ['image' => 'https://placehold.co/212x299', 'title' => 'Bert Hardy RAF Men Poster A2'],
    ['image' => 'https://placehold.co/212x299', 'title' => 'Bert Hardy RAF Men Poster A2'],
    ['image' => 'https://placehold.co/212x299', 'title' => 'Bert Hardy RAF Men Poster A2'],
];
?>


<!-- ============================================
     MAIN CONTENT
     ============================================ -->

<div class="mx-auto max-w-[1440px] pb-6 <?= $theme_text ?>">
    <div class="grid grid-cols-12 gap-6 mx-6">

        <!-- Wordmark -->
        <div class="col-span-4 flex flex-col items-start justify-between pt-6 h-fit">
            <?= miskatonic_wordmark(null, '') ?>
        </div>

        <!-- Main Content Area -->
        <div class="col-start-5 col-span-8 pt-6 grid grid-cols-subgrid">
            <?= insert_navbar($theme_navbar) ?>

            <?php while (have_posts()):
                the_post(); ?>

                <!-- Featured Image (Posts only) -->
                <?php if (has_post_thumbnail() && !$is_event): ?>
                    <?php $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full'); ?>
                    <img class="col-span-8 mt-6 outline outline-offset-[-1px]" src="<?= esc_url($featured_image[0]) ?>"
                        alt="<?= esc_attr(get_the_title()) ?>" />
                <?php endif; ?>

                <!-- Event Image (Events only) -->
                <?php if ($is_event): ?>
                    <div class="
                        col-span-8 mt-6 relative
                        [&_img]:w-full [&_img]:h-full [&_img]:object-cover
                    ">
                        <?= $current_event['image'] ?>

                        <?php if (!empty($current_event['tags'])): ?>
                            <div class="
                                absolute bottom-4 right-4
                                outline w-48 p-2
                                bg-black text-white invert
                                h4-style font-medium leading-none text-left
                            ">
                                <?= $current_event['tags'] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Title -->
                <h2 class="
                    h2-style col-span-4 mt-6
                    <?= $is_event ? 'min-h-32' : '' ?>
                ">
                    <?php
                    $title = get_the_title();
                    $title = preg_replace('/\s*\((online|london|nyc)\)\s*/i', '', $title);
                    echo esc_html($title);
                    ?>
                </h2>

                <!-- Event Details Box (Events only) -->
                <?php if ($is_event): ?>
                    <div class="
                        col-span-7 grid grid-cols-subgrid
                        p-6 mt-6
                        bg-white outline outline-offset-[-1px] outline-black
                    ">
                        <!-- Event Info -->
                        <div class="col-span-4 justify-start flex flex-col gap-6">
                            <div>
                                <h2 class="h2-style">Speaker</h2>
                                <p class="p-style-small"><?= esc_html($current_event['speaker']) ?></p>
                            </div>
                            <div>
                                <h2 class="h2-style">Date and time</h2>
                                <p class="p-style-small"><?= esc_html($current_event['date']) ?></p>
                            </div>
                            <div>
                                <h2 class="h2-style">Admission</h2>
                                <p class="p-style-small">
                                    Zoom registration links for each class are included in your order confirmation email from
                                    Billeto -- after registering, you'll receive a second email with the link to the Zoom
                                    session.
                                </p>
                            </div>
                        </div>

                        <!-- Ticket Options (Active events only) -->
                        <?php if ($current_event['is_active']): ?>
                            <div class="col-span-3 justify-start flex flex-col gap-6">

                                <!-- Individual Ticket -->
                                <a href="<?= esc_url($current_event['paylink']) ?>" class="block">
                                    <div class="
                                        bg-white outline outline-offset-[-1px]
                                        p-2.5 flex justify-between items-center
                                        invert-on-hover
                                    ">
                                        <div class="p-style-small-medium">
                                            Individual Ticket
                                            <?= miskatonic_svg_ticket('class="w-auto relative inline-block h-[0.7em]"') ?>
                                        </div>
                                        <div class="p-style-small-medium">
                                            <?= esc_html($current_event['ticket_price']) ?>
                                        </div>
                                    </div>
                                </a>

                                <!-- Semester Pass -->
                                <div class="
                                    bg-white outline outline-offset-[-1px]
                                    p-2.5 flex justify-between items-center
                                    invert-on-hover
                                ">
                                    <div class="p-style-small-medium">
                                        Online Semester Pass
                                        <?= miskatonic_svg_ticket('class="w-auto relative inline-block h-[0.7em]"') ?>
                                    </div>
                                    <div class="p-style-small-medium">£10</div>
                                </div>

                                <!-- Watchlist (if available) -->
                                <?php if (!empty($current_event['watchlist'])): ?>
                                    <a href="<?= esc_url($current_event['watchlist']) ?>" class="block">
                                        <div class="
                                            bg-white outline outline-offset-[-1px]
                                            p-2.5 flex justify-between items-center
                                            invert-on-hover
                                        ">
                                            <div class="p-style-small-medium">
                                                Watchlist
                                                <?= miskatonic_svg_ticket('class="w-auto relative inline-block h-[0.7em]"') ?>
                                            </div>
                                        </div>
                                    </a>
                                <?php endif; ?>

                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Post Content -->
                <div class="col-span-8 w-[95%] mt-6 flex flex-col gap-6 post-content">
                    <?php the_content(); ?>
                </div>


                <!-- ============================================
                     MERCHANDISE CAROUSEL (Active Events Only)
                     ============================================ -->

                <?php if ($is_event && $current_event['is_active']): ?>
                    <section class="embla col-span-6 grid grid-cols-subgrid">

                        <!-- Carousel Header -->
                        <div class="col-span-6 mt-6 flex items-center justify-between">
                            <h1 class="h1-style">On sale at our talks</h1>
                            <div class="embla__controls flex gap-4 items-center">
                                <div class="embla__dots"></div>
                            </div>
                        </div>

                        <!-- Carousel -->
                        <div class="col-span-6 mt-6 relative">
                            <!-- Previous Arrow -->
                            <button class="
                                    scale-[70%] embla__button embla__button--prev
                                    absolute left-[-50px] top-1/2 -translate-y-1/2 z-10
                                    p-2 hover:opacity-70 transition-opacity
                                " type="button" aria-label="Previous">
                                <?= page_turner_left('class="w-6 h-6"') ?>
                            </button>

                            <!-- Next Arrow -->
                            <button class="
                                    scale-[70%] embla__button embla__button--next
                                    absolute right-[-50px] top-1/2 -translate-y-1/2 z-10
                                    p-2 hover:opacity-70 transition-opacity
                                " type="button" aria-label="Next">
                                <?= page_turner_right('class="w-6 h-6"') ?>
                            </button>

                            <!-- Slides -->
                            <div class="embla__viewport">
                                <div class="embla__container">
                                    <?php foreach ($merch_items as $item): ?>
                                        <div class="embla__slide">
                                            <div>
                                                <img class="self-stretch" src="<?= esc_url($item['image']) ?>"
                                                    alt="<?= esc_attr($item['title']) ?>" />
                                                <p class="p-style-small mt-6">
                                                    <?= esc_html($item['title']) ?>
                                                </p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                    </section>
                <?php endif; ?>

            <?php endwhile; ?>
        </div>


        <!-- ============================================
             RELATED EVENTS SECTION (Events Only)
             ============================================ -->

        <?php if ($is_event && $related_count > 0): ?>

            <!-- Section Header -->
            <div class="col-span-4 mt-24">
                <a href="<?= get_page_link(PAGE_ID_TALKS) ?>" class="block">
                    <h1 class="hover:underline decoration-2 h1-style leading-none">
                        Upcoming talks
                    </h1>
                </a>
                <p class="p-style-light w-[60%] text-wrap mt-2">
                    Discover what talks, events and workshops we have coming up, online and in-person.
                </p>
            </div>

            <!-- Related Events Grid -->
            <div class="grid-cols-subgrid grid col-span-12">

                <?php foreach ($related_events as $related): ?>
                    <div class="grid grid-cols-subgrid col-span-4">

                        <!-- Event Image -->
                        <div class="
                            group relative col-span-4
                            aspect-[4.5/4] overflow-hidden
                            [&_img]:w-full [&_img]:h-full [&_img]:object-cover
                        ">
                            <a href="<?= esc_url($related['url']) ?>" class="absolute inset-0 z-10"></a>
                            <?= $related['image'] ?>

                            <div class="
                                group-hover:invert transition duration-300
                                absolute bottom-4 right-4
                                outline w-48 p-2
                                bg-white text-black
                                h4-style font-medium leading-none text-left
                            ">
                                <?= $related['tag'] ?>
                            </div>
                        </div>

                        <!-- Event Info -->
                        <div class="col-span-3 flex-col justify-between items-start inline-flex mt-6 h-[148px]">
                            <a href="<?= esc_url($related['url']) ?>" class="block">
                                <h1 class="h2-style leading-none hover:underline">
                                    <?= esc_html($related['name']) ?>
                                </h1>
                            </a>
                            <div>
                                <p class="h3-style"><?= esc_html($related['instructor']) ?></p>
                                <p class="h4-style"><?= esc_html($related['date']) ?></p>
                            </div>
                        </div>

                        <!-- Ticket Link -->
                        <div class="col-span-1 mt-6">
                            <?= ticket_link($related['ticket_url'], '') ?>
                        </div>

                    </div>
                <?php endforeach; ?>

                <!-- Sidebar Links -->
                <div class="col-span-4">
                    <div class="w-[60%] flex-col inline-flex item-start justify-start">
                        <div>
                            <a href="">
                                <h2 class="h2-style hover:underline leading-snug">Our Speakers</h2>
                            </a>
                            <p class="p-style mt-2">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean laoreet,
                            </p>
                        </div>
                        <div class="mt-6">
                            <a href="">
                                <h2 class="h2-style hover:underline leading-snug">Our Archive</h2>
                            </a>
                            <p class="p-style mt-2">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean laoreet,
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        <?php endif; ?>

    </div>
</div>

<?php get_footer(); ?>