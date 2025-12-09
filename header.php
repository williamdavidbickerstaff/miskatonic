<!DOCTYPE html>
<html <?php language_attributes(); ?> class="">

<head>
    <style>
        html {
            visibility: hidden;
            opacity: 0;
        }
    </style>
    <script>
        // Keep page hidden until JavaScript is ready
        // This prevents flash of unstyled content
        (function () {
            // Ensure html stays hidden
            if (document.documentElement) {
                document.documentElement.style.visibility = 'hidden';
                document.documentElement.style.opacity = '0';
            }
        })();
    </script>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>