<?php
/**
 * State archive showing all sellers for that state.
 *
 * @package CCCPrimaryTheme
 */

if (! defined('ABSPATH')) {
    exit;
}

$term = get_queried_object();

get_header();
?>

<main id="primary" class="site-main">
    <header class="page-header">
        <h1 class="page-title">
            <?php echo esc_html(sprintf(__('Wholesale cannabis sellers in %s', 'ccc-primary-theme'), $term->name)); ?>
        </h1>
        <?php if (! empty($term->description)) : ?>
            <div class="taxonomy-description"><?php echo wp_kses_post(wpautop($term->description)); ?></div>
        <?php endif; ?>
    </header>

    <?php if (have_posts()) : ?>
        <div class="seller-list">
            <?php
            while (have_posts()) :
                the_post();
                $city = get_post_meta(get_the_ID(), 'apex_seller_city', true);
                $website = get_post_meta(get_the_ID(), 'apex_seller_website', true);
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('seller-card'); ?>>
                    <h2 class="entry-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <?php if ($city || $website) : ?>
                        <ul class="seller-meta">
                            <?php if ($city) : ?>
                                <li><?php echo esc_html($city); ?></li>
                            <?php endif; ?>
                            <?php if ($website) : ?>
                                <li><a href="<?php echo esc_url($website); ?>" rel="noopener" target="_blank"><?php echo esc_html($website); ?></a></li>
                            <?php endif; ?>
                        </ul>
                    <?php endif; ?>
                    <div class="entry-summary">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>

        <?php the_posts_pagination(); ?>
    <?php else : ?>
        <p><?php esc_html_e('No sellers found for this state yet.', 'ccc-primary-theme'); ?></p>
    <?php endif; ?>
</main>

<?php
get_footer();
