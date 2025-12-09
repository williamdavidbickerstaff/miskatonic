<?php
/**
 * Template Name: Talks List Layout
 * Displays all upcoming talks with filtering options
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

$events = [];

if (class_exists('EM_Events')) {
    $em_events = EM_Events::get([
        'limit' => 999,
        'orderby' => 'date'
    ]);

    foreach ($em_events as $event) {
        $name_words = explode(' ', $event->event_name);
        array_pop($name_words);

        $events[] = [
            'name' => implode(' ', $name_words),
            'image' => $event->output('#_EVENTIMAGE{medium}'),
            'date' => $event->output('#_EVENTSTARTDATE'),
            'instructor' => $event->output('#_CATEGORYNAME'),
            'excerpt' => $event->output('#_EVENTEXCERPT{50,...}'),
            'url' => $event->output('#_EVENTURL'),
            'ticket_url' => $event->output('#_ATT{paylink}'),
            'tag' => $event->output('#_EVENTTAGS'),
            'location' => $event->output('#_EVENTLOCATION'),
        ];
    }
}

$events_count = count($events);
?>


<!-- ============================================
     HERO SECTION
     ============================================ -->

<div class="mx-auto max-w-[1440px] pb-6">
    <div class="grid grid-cols-12 gap-6 mx-6">

        <!-- Wordmark -->
        <div class="col-span-4 flex flex-col items-start justify-between pt-6 h-fit">
            <?= miskatonic_wordmark('Talks') ?>
        </div>

        <!-- Navbar & Featured Event -->
        <div class="col-start-5 col-span-8 pt-6 grid grid-cols-subgrid">
            <?= insert_navbar('dark') ?>

            <?php if ($events_count > 0): ?>
                <?php $featured = $events[0]; ?>

                <div class="col-span-8 grid grid-cols-subgrid pt-6">

                    <!-- Featured Event Image -->
                    <div class="
                        group relative col-span-4
                        aspect-[4.5/4] overflow-hidden
                        [&_img]:w-full [&_img]:h-full [&_img]:object-cover
                    ">
                        <a href="<?= esc_url($featured['url']) ?>" class="absolute inset-0 z-10"></a>
                        <?= $featured['image'] ?>
                        <?= event_badge($featured['tag']) ?>
                    </div>

                    <!-- Featured Event Info -->
                    <div class="col-span-4">
                        <div class="flex flex-col justify-start items-start gap-4">

                            <!-- Title -->
                            <a href="<?= esc_url($featured['url']) ?>" class="block">
                                <div class="text-white h2-style leading-6 hover:underline">
                                    <?= esc_html($featured['name']) ?>
                                </div>
                            </a>

                            <!-- Instructor & Date -->
                            <div>
                                <span class="text-white h4-style font-bold leading-snug">
                                    <?= esc_html($featured['instructor']) ?>
                                </span>
                                <br />
                                <span class="text-white h4-style leading-snug">
                                    <?= esc_html($featured['date']) ?>
                                </span>
                            </div>

                            <!-- Excerpt -->
                            <div class="self-stretch text-white p-style leading-6">
                                <?= $featured['excerpt'] ?>
                            </div>

                            <!-- Links -->
                            <div class="flex flex-col justify-center items-start gap-2">
                                <a href="<?= esc_url($featured['url']) ?>" class="text-white link leading-4">
                                    Read more
                                </a>
                                <?= ticket_link($featured['ticket_url']) ?>
                            </div>

                        </div>
                    </div>

                </div>
            <?php endif; ?>

        </div>
    </div>


    <!-- ============================================
         FILTER & EVENTS LIST
         ============================================ -->

    <div class="grid grid-cols-12 gap-6 pt-6 mx-6">

        <!-- Sidebar Filters -->
        <div class="col-span-3 flex flex-col items-start justify-start gap-6">
            <div class="w-full flex flex-col justify-start items-start gap-6">

                <h2 class="text-white h1-style">
                    Autumn semester<br />2025
                </h2>

                <!-- Filter Checkboxes -->
                <div class="flex flex-col gap-2">
                    <?= filter_checkbox('All talks') ?>
                    <?= filter_checkbox('London') ?>
                    <?= filter_checkbox('NYC') ?>
                    <?= filter_checkbox('Online') ?>
                </div>

                <!-- Semester Pass Buttons -->
                <?= semester_pass_button('Online Semester Pass') ?>
                <?= semester_pass_button('London Semester Pass') ?>

            </div>
        </div>

        <!-- Events List -->
        <?php for ($i = 1; $i < $events_count; $i++): ?>
            <?php $event = $events[$i]; ?>

            <div class="col-start-5 col-span-8 grid grid-cols-subgrid">

                <!-- Event Image -->
                <div class="
                    group relative col-span-4
                    aspect-[4.5/4] overflow-hidden
                    [&_img]:w-full [&_img]:h-full [&_img]:object-cover
                ">
                    <a href="<?= esc_url($event['url']) ?>" class="absolute inset-0 z-10"></a>
                    <?= $event['image'] ?>
                    <?= event_badge($event['tag']) ?>
                </div>

                <!-- Event Info -->
                <div class="col-span-4">
                    <div class="flex flex-col justify-start items-start gap-4">

                        <!-- Title -->
                        <a href="<?= esc_url($event['url']) ?>" class="block">
                            <div class="text-white h2-style leading-6 hover:underline">
                                <?= esc_html($event['name']) ?>
                            </div>
                        </a>

                        <!-- Instructor & Date -->
                        <div>
                            <span class="text-white h4-style font-bold leading-snug">
                                <?= esc_html($event['instructor']) ?>
                            </span>
                            <br />
                            <span class="text-white h4-style leading-snug">
                                <?= esc_html($event['date']) ?>
                            </span>
                        </div>

                        <!-- Excerpt -->
                        <div class="self-stretch text-white p-style leading-6">
                            <?= $event['excerpt'] ?>
                        </div>

                        <!-- Links -->
                        <div class="flex flex-col justify-center items-start gap-2">
                            <a href="<?= esc_url($event['url']) ?>" class="text-white link leading-4">
                                Read more
                            </a>
                            <?= ticket_link($event['ticket_url']) ?>
                        </div>

                    </div>
                </div>

            </div>
        <?php endfor; ?>

    </div>
</div>

<?php get_footer(); ?>