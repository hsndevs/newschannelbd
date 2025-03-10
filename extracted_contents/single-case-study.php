<?php
/*
Template Name: Case Study Loop
Template Post Type: post, page
*/
?>
<?php get_header(); ?>

<main id="primary" class="site-main">
    <?php
    if (in_category('case-study')) {
        while (have_posts()) :
            the_post();
            the_title('<h1>', '</h1>');
            the_content();
        endwhile;
    }
    ?>
</main>

<?php get_footer(); ?>