<?php

require_once 'inc/constants.php';

if (file_exists(VITE_THEME_MANIFEST_PATH)) {
    add_action('wp_enqueue_scripts', function () {
        $manifest = json_decode(file_get_contents(VITE_THEME_MANIFEST_PATH), true);
        $themeVersion = wp_get_theme()->get('Version');
        if (is_array($manifest)) {
            foreach ($manifest as $key => $value) {
                $file = $value['file'];
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                if ($ext === 'css') {
                    wp_enqueue_style($key, VITE_THEME_ASSETS_DIR . '/' . $file, [], $themeVersion);
                } elseif ($ext === 'js') {
                    wp_enqueue_script($key, VITE_THEME_ASSETS_DIR . '/' . $file, [], $themeVersion, true);
                }
            }
        }
    });
} else {
    require_once 'inc/vite.php';
}


add_action('after_setup_theme', function () {
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    add_action('wp_enqueue_scripts', function () {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('classic-theme-styles');
        wp_dequeue_style('global-styles');
    });
});


// The proper way to enqueue GSAP script in WordPress
// wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );
function theme_gsap_script()
{
    // The core GSAP library
    wp_enqueue_script('gsap-js', 'https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js', array(), false, true);
    // ScrollTrigger - with gsap.js passed as a dependency
    wp_enqueue_script('gsap-st', 'https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/ScrollTrigger.min.js', array('gsap-js'), false, true);
}
add_action('wp_enqueue_scripts', 'theme_gsap_script');


// Replace ++++ with <hr>
function content_replacements($content)
{
    // Replace any line containing only "++++"
    $content = preg_replace('/\+{4,}/', '<hr />', $content);
    return $content;
}
add_filter('the_content', 'content_replacements');

function title_replacements($title)
{
    return ucwords(strtolower($title));
}
add_filter('the_title', 'title_replacements');

function miskatonic_svg_ticket($attrs = '')
{
    return '<svg ' . $attrs . ' width="11" height="11" viewBox="0 0 11 11" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M0.21967 9.21967C-0.0732233 9.51256 -0.0732233 9.98744 0.21967 10.2803C0.512563 10.5732 0.987437 10.5732 1.28033 10.2803L0.75 9.75L0.21967 9.21967ZM10.5 0.749999C10.5 0.335786 10.1642 -7.69011e-07 9.75 -6.04039e-07L3 -7.41016e-07C2.58579 -7.23559e-07 2.25 0.335786 2.25 0.749999C2.25 1.16421 2.58579 1.5 3 1.5L9 1.5L9 7.5C9 7.91421 9.33579 8.25 9.75 8.25C10.1642 8.25 10.5 7.91421 10.5 7.5L10.5 0.749999ZM0.75 9.75L1.28033 10.2803L10.2803 1.28033L9.75 0.749999L9.21967 0.219669L0.21967 9.21967L0.75 9.75Z"/></svg>';
}

function page_turner_left($attrs = '')
{
    return '<svg ' . $attrs . ' width="14" height="12" viewBox="0 0 14 12" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M12.75 4.77344C13.1642 4.77344 13.5 5.10922 13.5 5.52344C13.5 5.93765 13.1642 6.27344 12.75 6.27344V5.52344V4.77344ZM0.21967 6.05377C-0.0732233 5.76087 -0.0732233 5.286 0.21967 4.99311L4.99264 0.220137C5.28553 -0.0727566 5.76041 -0.0727566 6.0533 0.220137C6.34619 0.51303 6.34619 0.987904 6.0533 1.2808L1.81066 5.52344L6.0533 9.76608C6.34619 10.059 6.34619 10.5338 6.0533 10.8267C5.76041 11.1196 5.28553 11.1196 4.99264 10.8267L0.21967 6.05377ZM12.75 5.52344V6.27344L0.75 6.27344V5.52344V4.77344L12.75 4.77344V5.52344Z"/></svg>';
}

function page_turner_right($attrs = '')
{
    return '<svg ' . $attrs . ' width="14" height="12" viewBox="0 0 14 12" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M0.75 4.77344C0.335786 4.77344 0 5.10922 0 5.52344C0 5.93765 0.335786 6.27344 0.75 6.27344V5.52344V4.77344ZM13.2803 6.05377C13.5732 5.76087 13.5732 5.286 13.2803 4.99311L8.50736 0.220137C8.21447 -0.0727568 7.73959 -0.0727568 7.4467 0.220137C7.15381 0.51303 7.15381 0.987904 7.4467 1.2808L11.6893 5.52344L7.4467 9.76608C7.15381 10.059 7.15381 10.5338 7.4467 10.8267C7.73959 11.1196 8.21447 11.1196 8.50736 10.8267L13.2803 6.05377ZM0.75 5.52344V6.27344L12.75 6.27344V5.52344V4.77344L0.75 4.77344V5.52344Z"/></svg>';
}

// ============================================
// PAGE LINK CONSTANTS
// ============================================

define('PAGE_ID_TALKS', 15);
define('PAGE_ID_NEWS', 2603);
define('PAGE_ID_ARCHIVE', 252);


// ============================================
// UI COMPONENT HELPERS
// ============================================

/**
 * Render a ticket link with arrow icon
 */
function ticket_link($url, $class = 'text-white')
{
    $icon = miskatonic_svg_ticket('class="w-auto relative inline-block h-[0.7em] top-[0.1em]"');
    return '<a href="' . esc_url($url) . '" class="' . $class . ' link inline-flex items-center gap-2">
        Tickets ' . $icon . '
    </a>';
}

/**
 * Render an event tag badge
 */
function event_badge($tag, $position = 'bottom-4 right-4')
{
    return '<div class="
        group-hover:invert transition duration-300
        absolute ' . $position . '
        outline w-48 p-2
        bg-black text-white
        h4-style font-medium leading-none text-left
    ">' . $tag . '</div>';
}

/**
 * Render the main navigation menu
 */
function insert_navbar($theme = 'dark')
{
    $links = [
        ['url' => get_page_link(PAGE_ID_TALKS), 'label' => 'Talks'],
        ['url' => null, 'label' => 'Speakers'],
        ['url' => get_page_link(PAGE_ID_ARCHIVE), 'label' => 'Archive'],
        ['url' => get_page_link(PAGE_ID_NEWS), 'label' => 'News'],
        ['url' => null, 'label' => 'FAQ'],
        ['url' => null, 'label' => 'About'],
        ['url' => null, 'label' => 'Contact'],
    ];

    $output = '<ul class="flex flex-col col-span-8 gap-0 h-fit ' . $theme . '">';

    foreach ($links as $link) {
        $item = '<li class="h-full h2-style leading-none menu-item" data-menu-item>
            <label class="h-full flex items-center justify-start">' . esc_html($link['label']) . '</label>
        </li>';

        if ($link['url']) {
            $output .= '<a href="' . esc_url($link['url']) . '" class="block">' . $item . '</a>';
        } else {
            $output .= $item;
        }
    }

    $output .= '</ul>';
    return $output;
}

/**
 * Render a filter checkbox
 */
function filter_checkbox($label)
{
    return '<label class="flex items-center gap-2 justify-between text-white cursor-pointer">
        <span class="underline">' . esc_html($label) . '</span>
        <input type="checkbox" class="
            appearance-none w-4 h-4 border border-white bg-transparent
            checked:bg-white checked:border-white focus:outline-none
        " />
    </label>';
}

/**
 * Render a semester pass button
 */
function semester_pass_button($label, $status = 'Sold out')
{
    $icon = miskatonic_svg_ticket('class="w-auto relative inline-block h-[0.7em]"');
    return '<div class="
        w-full outline outline-offset-[-1px] bg-black text-white outline-white
        flex justify-between items-center px-2 py-2 invert-on-hover
    ">
        <span class="h4-style font-medium">' . esc_html($label) . ' ' . $icon . '</span>
        <span class="text-white h4-style font-medium">' . esc_html($status) . '</span>
    </div>';
}

/**
 * Render the MISKATONIC wordmark
 * @param string|null $subtitle Optional subtitle (e.g., "Talks", "Archive")
 * @param string $text_class Text color class (default: 'text-white')
 */
function miskatonic_wordmark($subtitle = null, $text_class = 'text-white')
{
    $output = '
    <a href="' . home_url() . '" class="block">
        <h1 class="' . $text_class . ' title-style wordmark-element" data-wordmark>MIS</h1>
        <h1 class="' . $text_class . ' title-style wordmark-element" data-wordmark>KA</h1>
        <h1 class="' . $text_class . ' title-style wordmark-element" data-wordmark>TON</h1>
        <h1 class="' . $text_class . ' title-style wordmark-element" data-wordmark>IC</h1>
    </a>
    <div class="col-span-2 flex flex-col items-start justify-between pt-6 gap-4">
        <h1 class="h1-style ' . $text_class . ' text-wrap wordmark-element" data-wordmark>
            Institute of <br> Horror Studies
        </h1>
    ';

    if ($subtitle) {
        $outline_class = ($text_class === 'text-white') ? 'outline-white' : 'outline-black';
        $output .= '
        <div class="w-6 h-0 outline ' . $outline_class . ' wordmark-element" data-wordmark></div>
        <h1 class="h1-style ' . $text_class . ' text-wrap wordmark-element" data-wordmark>
            ' . esc_html($subtitle) . '
        </h1>';
    }

    $output .= '</div>';

    return $output;
}
