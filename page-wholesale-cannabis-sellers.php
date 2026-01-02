<?php
/**
 * Landing page for the seller directory.
 *
 * Create a WordPress page with the slug "wholesale-cannabis-sellers" to use this template.
 *
 * @package CCCPrimaryTheme
 */

if (! defined('ABSPATH')) {
    exit;
}

get_header();

$states = get_terms(
    [
        'taxonomy'   => APEX_SELLER_TAXONOMY,
        'hide_empty' => false,
        'orderby'    => 'name',
        'order'      => 'ASC',
    ]
);
?>

<main id="primary" class="site-main">
    <header class="page-header">
        <h1 class="page-title"><?php esc_html_e('Wholesale Cannabis Sellers', 'ccc-primary-theme'); ?></h1>
    </header>

    <?php if (! empty($states) && ! is_wp_error($states)) : ?>
        <ul class="seller-state-list">
            <?php foreach ($states as $state) : ?>
                <li>
                    <a href="<?php echo esc_url(get_term_link($state)); ?>">
                        <?php echo esc_html($state->name); ?>
                    </a>
                    <?php if (isset($state->count)) : ?>
                        <span class="seller-count"><?php echo (int) $state->count; ?></span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p><?php esc_html_e('States will appear here after the first data sync completes.', 'ccc-primary-theme'); ?></p>
    <?php endif; ?>
</main>

<?php
get_sidebar();
get_footer();
