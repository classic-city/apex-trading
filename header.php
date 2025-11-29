<?php
/**
 * Theme header.
 *
 * @package CCCPrimaryTheme
 */

if (! defined('ABSPATH')) {
    exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="site-branding">
        <?php if (has_custom_logo()) : ?>
            <?php the_custom_logo(); ?>
        <?php endif; ?>

        <?php if (is_front_page() && is_home()) : ?>
            <h1 class="site-title">
                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                    <?php bloginfo('name'); ?>
                </a>
            </h1>
        <?php else : ?>
            <p class="site-title">
                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                    <?php bloginfo('name'); ?>
                </a>
            </p>
        <?php endif; ?>

        <?php
        $description = get_bloginfo('description', 'display');
        if (! empty($description) || is_customize_preview()) :
            ?>
            <p class="site-description"><?php echo esc_html($description); ?></p>
        <?php endif; ?>
    </div>

    <nav class="primary-navigation" role="navigation" aria-label="<?php esc_attr_e('Primary menu', 'ccc-primary-theme'); ?>">
        <?php
        wp_nav_menu(
            [
                'theme_location' => 'primary',
                'menu_id'        => 'primary-menu',
            ]
        );
        ?>
    </nav>
</header>

<div id="content" class="site-content">
