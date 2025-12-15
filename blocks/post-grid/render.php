<?php
/**
 * View template for the Post Grid block.
 */

if (! defined('ABSPATH')) {
    exit;
}

// Get ACF values
$post_type           = get_field('post_type') ?: 'post';
$posts_to_show       = get_field('posts_to_show') ?: 4;
$selected_posts      = get_field('select_posts'); // New: selected posts
$show_title          = get_field('show_title') ?: true;
$show_excerpt        = get_field('show_excerpt') ?: true;
$show_read_more      = get_field('show_read_more') ?: true;
$show_featured_image = get_field('show_featured_image') ?: true;

// Determine posts to query
if (! empty($selected_posts)) {
    $query_args = [
        'post_type' => $post_type,
        'post__in'  => $selected_posts,
        'orderby'   => 'post__in', // keep order as selected
        'posts_per_page' => -1,
    ];
} else {
    $query_args = [
        'post_type'      => $post_type,
        'posts_per_page' => $posts_to_show,
    ];
}

$query = new WP_Query($query_args);

if ($query->have_posts()) : ?>
    <div class="post-grid-custom">
        <div class="inner-grid-container">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <div class="post-grid-item">
                    <?php if ($show_featured_image && has_post_thumbnail()) : ?>
                        <div class="post-grid-image">
                            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
                        </div>
                    <?php endif; ?>

                    <div class="content-container">
                        <?php if ($show_title) : ?>
                            <h3 class="post-grid-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                        <?php endif; ?>

                        <?php if ($show_excerpt) : ?>
                            <p class="post-grid-excerpt">
                                <?php
                                $excerpt = wp_trim_words(get_the_excerpt(), 55, '...');
                                echo esc_html($excerpt);
                                ?>
                            </p>
                        <?php endif; ?>

                        <?php if ($show_read_more) : ?>
                            <a class="post-grid-readmore" href="<?php the_permalink(); ?>">Read Post <i class="link__icon fa fa-chevron-right"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
<?php
endif;

wp_reset_postdata();
