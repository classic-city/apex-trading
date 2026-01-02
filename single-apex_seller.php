<?php
/**
 * Single seller view.
 *
 * @package CCCPrimaryTheme
 */

if (! defined('ABSPATH')) {
    exit;
}

get_header();

$state_terms = get_the_terms(get_the_ID(), APEX_SELLER_TAXONOMY);
$state_term = (! empty($state_terms) && ! is_wp_error($state_terms)) ? $state_terms[0] : null;
$city = get_post_meta(get_the_ID(), 'apex_seller_city', true);
$website = get_post_meta(get_the_ID(), 'apex_seller_website', true);
?>

<main id="primary" class="site-main">
    <?php
    while (have_posts()) :
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
                <?php if ($state_term) : ?>
                    <div class="entry-meta">
                        <a href="<?php echo esc_url(get_term_link($state_term)); ?>">
                            <?php echo esc_html($state_term->name); ?>
                        </a>
                    </div>
                <?php endif; ?>
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
            </header>

            <div class="entry-content">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="seller-logo">
                        <?php the_post_thumbnail('medium'); ?>
                    </div>
                <?php endif; ?>

                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<?php
get_footer();
