<?php 
function my_plugin_body_class($classes) {
    $classes[] = 'bg-black';
    return $classes;
}

add_filter('body_class', 'my_plugin_body_class');

get_header(); 
?>


  <h1 class="my-element text-3xl font-bold underline text-black">   
    Hello world!  
  </h1>

  <p> what the fuck </p>

  <div class="my-element"><p> hello </p></div>
<?php get_footer(); ?>
