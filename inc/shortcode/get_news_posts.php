<?php
if (!defined('WPINC')) {
    die;
}

function get_news_posts()
{
    ob_start();

    global $post;
    
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Get the current page number

    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 12,
        'order' => 'DESC',
        'paged' => $paged, // Pass the current page number to the query
    );

    $query = new WP_Query($args);
    ?>
    
    <div class="dp-dfg-container dp-dfg-layout-grid dp-dfg-skin-default">
        <div class="dp-dfg-items">

            <?php // Loop over the posts
            while ($query->have_posts()) :
                $query->the_post();

                // Loop output ?>
                <article id="post-<?php echo get_the_ID(); ?>" class="dp-dfg-item post-<?php echo get_the_ID(); ?> post type-post status-publish">
                    <figure class="dp-dfg-image entry-thumb">
                        <a href="<?php the_permalink(); ?>" class="dp-dfg-image-link">
                            <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo the_title(); ?>" class="dp-dfg-featured-image">
                        </a>
                    </figure>
                    
                    <div class="dp-dfg-header entry-header">
                        <h2 class="entry-title">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h2>
                    </div>

                    <div class="dp-dfg-meta entry-meta">
                        <span class="published">
                            <?php echo get_the_date('M j, Y'); ?>
                        </span>
                    </div>

                    <div class="dp-dfg-content entry-summary">
                        <?php the_excerpt(); ?>
                    </div>

                    <div class="et_pb_button_wrapper read-more-wrapper">
                        <a href="<?php the_permalink(); ?>" class="et_pb_button dp-dfg-more-button">
                            Read more
                        </a>
                    </div>

                </article>

            <?php endwhile; ?>

        </div>
    </div>

    <?php

    // Add pagination
    $pagination = paginate_links(array(
        'base' => get_pagenum_link(1) . '%_%',
        'format' => '?paged=%#%',
        'current' => $paged,
        'total' => $query->max_num_pages,
        'prev_text' => __('Previous'),
        'next_text' => __('Next'),
    ));

    if ($pagination) { ?>
        <div class="dp-dfg-pagination pagination">
            <?php echo $pagination; ?>
        </div>
    <?php
    }

    return ob_get_clean();
}
add_shortcode('get_news_posts', 'get_news_posts');