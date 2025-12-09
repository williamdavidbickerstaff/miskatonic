<?php
/**
 * Template Name: About Page
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
            <?= miskatonic_wordmark('About', '') ?>
        </div>

        <!-- Main Content Area -->
        <div class="col-start-5 col-span-8 pt-6 grid grid-cols-subgrid">
            <?= insert_navbar($theme_navbar) ?>

            <?php while (have_posts()):
                the_post(); ?>

                <!-- Featured Image -->
                <?php if (has_post_thumbnail()): ?>
                    <?php $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full'); ?>
                    <div class="col-span-8 mt-6 relative">
                        <img class="w-full h-auto outline outline-offset-[-1px]" src="<?= esc_url($featured_image[0]) ?>"
                            alt="<?= esc_attr(get_the_title()) ?>" />
                    </div>
                <?php endif; ?>

                <!-- Page Title -->
                <h1 class="h1-style col-span-8 mt-6">
                    <?= esc_html(get_the_title()) ?>
                </h1>

                <!-- Page Content -->
                <div class="col-span-8 w-[95%] mt-6 flex flex-col gap-6 post-content">
                    <?php the_content(); ?>
                </div>

            <?php endwhile; ?>
        </div>


        <!-- ============================================
             ABOUT SECTIONS
             ============================================ -->

        <!-- Mission Section -->
        <?php
        $mission = get_field('mission_statement');
        if ($mission):
            ?>
            <div class="col-span-4 mt-24">
                <h2 class="h1-style leading-none">Our Mission</h2>
            </div>
            <div class="col-span-8 mt-24">
                <p class="p-style">
                    <?= esc_html($mission) ?>
                </p>
            </div>
        <?php endif; ?>


        <!-- Team Section -->
        <?php
        $team_members = get_field('team_members');
        if ($team_members):
            ?>
            <div class="col-span-4 mt-24">
                <h2 class="h1-style leading-none">Our Team</h2>
                <p class="p-style-light w-[60%] text-wrap mt-2">
                    Meet the people behind The Miskatonic Institute of Horror Studies.
                </p>
            </div>

            <div class="grid-cols-subgrid grid col-span-12 mt-6">
                <?php foreach ($team_members as $member): ?>
                    <div class="col-span-4 mt-6">
                        <?php if (!empty($member['photo'])): ?>
                            <div class="aspect-square overflow-hidden">
                                <img class="w-full h-full object-cover outline outline-offset-[-1px]"
                                    src="<?= esc_url($member['photo']['url']) ?>" alt="<?= esc_attr($member['name']) ?>" />
                            </div>
                        <?php endif; ?>
                        <h3 class="h2-style mt-4"><?= esc_html($member['name']) ?></h3>
                        <?php if (!empty($member['role'])): ?>
                            <p class="h4-style"><?= esc_html($member['role']) ?></p>
                        <?php endif; ?>
                        <?php if (!empty($member['bio'])): ?>
                            <p class="p-style-small mt-2"><?= esc_html($member['bio']) ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>


        <!-- History Section -->
        <?php
        $history = get_field('history');
        if ($history):
            ?>
            <div class="col-span-4 mt-24">
                <h2 class="h1-style leading-none">Our History</h2>
            </div>
            <div class="col-span-8 mt-24">
                <div class="p-style flex flex-col gap-4">
                    <?= wp_kses_post($history) ?>
                </div>
            </div>
        <?php endif; ?>


        <!-- Contact Section -->
        <div class="col-span-4 mt-24">
            <h2 class="h1-style leading-none">Get in Touch</h2>
            <p class="p-style-light w-[60%] text-wrap mt-2">
                We'd love to hear from you.
            </p>
        </div>

        <div class="col-span-8 mt-24 grid grid-cols-subgrid">
            <div class="col-span-4">
                <div class="
                    bg-white outline outline-offset-[-1px] outline-black
                    p-6 flex flex-col gap-6
                ">
                    <?php
                    $email = get_field('contact_email');
                    if ($email):
                        ?>
                        <div>
                            <h3 class="h2-style">Email</h3>
                            <a href="mailto:<?= esc_attr($email) ?>" class="p-style-small hover:underline">
                                <?= esc_html($email) ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php
                    $social_links = get_field('social_links');
                    if ($social_links):
                        ?>
                        <div>
                            <h3 class="h2-style">Follow Us</h3>
                            <div class="flex gap-4 mt-2">
                                <?php if (!empty($social_links['twitter'])): ?>
                                    <a href="<?= esc_url($social_links['twitter']) ?>" class="p-style-small hover:underline"
                                        target="_blank" rel="noopener noreferrer">
                                        Twitter
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($social_links['instagram'])): ?>
                                    <a href="<?= esc_url($social_links['instagram']) ?>" class="p-style-small hover:underline"
                                        target="_blank" rel="noopener noreferrer">
                                        Instagram
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($social_links['facebook'])): ?>
                                    <a href="<?= esc_url($social_links['facebook']) ?>" class="p-style-small hover:underline"
                                        target="_blank" rel="noopener noreferrer">
                                        Facebook
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php
                    $location = get_field('location');
                    if ($location):
                        ?>
                        <div>
                            <h3 class="h2-style">Location</h3>
                            <p class="p-style-small">
                                <?= nl2br(esc_html($location)) ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-span-4">
                <div class="w-[80%] flex-col inline-flex item-start justify-start">
                    <div>
                        <a href="<?= get_page_link(PAGE_ID_TALKS) ?>">
                            <h2 class="h2-style hover:underline leading-snug">Upcoming Talks</h2>
                        </a>
                        <p class="p-style mt-2">
                            Discover what talks, events and workshops we have coming up.
                        </p>
                    </div>
                    <div class="mt-6">
                        <a href="<?= get_page_link(PAGE_ID_ARCHIVE) ?>">
                            <h2 class="h2-style hover:underline leading-snug">Our Archive</h2>
                        </a>
                        <p class="p-style mt-2">
                            Explore our collection of past talks and recordings.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php get_footer(); ?>