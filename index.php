<?php get_header(); ?>


<main id="site-content" role="main">

    <?php
        if ( have_posts() ) {

            // Load posts loop.
            while ( have_posts() ) {
                the_post();
            }

        } else {



        }
        ?>

</main>


<?php get_footer(); ?>