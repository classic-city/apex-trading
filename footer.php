<?php
/**
 * Theme footer.
 *
 * @package CCCPrimaryTheme
 */

if (! defined('ABSPATH')) {
    exit;
}
?>

</div><!-- #content -->

<footer class="site-footer">
    <div class="site-info">
        <span>&copy; <?php echo esc_html(gmdate('Y')); ?> <?php bloginfo('name'); ?></span>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
