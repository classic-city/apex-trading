<?php
/**
 * Template part for displaying a message when no posts are found.
 *
 * @package CCCPrimaryTheme
 */

if (! defined('ABSPATH')) {
    exit;
}
?>

<section class="no-results not-found">
    <header class="page-header">
        <h1 class="page-title"><?php esc_html_e('Nothing Found', 'ccc-primary-theme'); ?></h1>
    </header>

    <div class="page-content">
        <?php
        if (is_home() && current_user_can('publish_posts')) :
            printf(
                '<p>%s</p>',
                sprintf(
                    /* translators: 1: Link to new post admin screen. */
                    esc_html__('Ready to publish your first post? %s.', 'ccc-primary-theme'),
                    '<a href="' . esc_url(admin_url('post-new.php')) . '">' . esc_html__('Get started here', 'ccc-primary-theme') . '</a>'
                )
            );
        elseif (is_search()) :
            ?>
            <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'ccc-primary-theme'); ?></p>
            <?php
            get_search_form();
        else :
            ?>
            <p><?php esc_html_e('It seems we can’t find what you’re looking for. Perhaps searching can help.', 'ccc-primary-theme'); ?></p>
            <?php
            get_search_form();
        endif;
        ?>
    </div>
</section>
