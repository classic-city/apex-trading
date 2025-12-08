<?php
/**
 * Post Grid ACF block registration and fields.
 *
 * @package CCCPrimaryTheme
 */

if (! defined('ABSPATH')) {
    exit;
}

add_action('acf/init', 'ccc_primary_register_post_grid_block');

/**
 * Register the Post Grid block.
 */
function ccc_primary_register_post_grid_block(): void
{
    if (! function_exists('acf_register_block_type')) {
        return;
    }

    acf_register_block_type([
        'name'            => 'ccc-post-grid',
        'title'           => __('Post Grid', 'ccc-primary-theme'),
        'description'     => __('Displays a grid of posts with configurable options.', 'ccc-primary-theme'),
        'render_callback' => 'ccc_primary_render_post_grid_block',
        'category'        => 'layout',
        'icon'            => 'grid-view',
        'keywords'        => ['posts', 'grid', 'excerpt', 'featured image'],
        'supports'        => [
            'align'  => false,
            'anchor' => true,
            'mode'   => true,
        ],
    ]);

    ccc_primary_register_post_grid_fields();
}

/**
 * Register ACF fields for the Post Grid block.
 */
function ccc_primary_register_post_grid_fields(): void
{
    if (! function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group([
        'key'                   => 'group_ccc_post_grid',
        'title'                 => __('Post Grid', 'ccc-primary-theme'),
        'fields'                => [
            [
                'key'           => 'field_ccc_pg_post_type',
                'label'         => __('Post Type', 'ccc-primary-theme'),
                'name'          => 'post_type',
                'type'          => 'select',
                'choices'       => [
                    'post' => 'Post',
                    'page' => 'Page',
                    // Add custom post types here
                ],
                'default_value' => 'post',
                'ui'            => 1,
                'wrapper'       => ['width' => 50],
            ],
            [
                'key'           => 'field_ccc_pg_posts_to_show',
                'label'         => __('Number of Posts', 'ccc-primary-theme'),
                'name'          => 'posts_to_show',
                'type'          => 'number',
                'default_value' => 4,
                'wrapper'       => ['width' => 50],
            ],
            [
                'key'   => 'field_ccc_pg_show_title',
                'label' => __('Show Title', 'ccc-primary-theme'),
                'name'  => 'show_title',
                'type'  => 'true_false',
                'ui'    => 1,
                'default_value' => 1,
                'wrapper'       => ['width' => 33],
            ],
            [
                'key'   => 'field_ccc_pg_show_excerpt',
                'label' => __('Show Excerpt', 'ccc-primary-theme'),
                'name'  => 'show_excerpt',
                'type'  => 'true_false',
                'ui'    => 1,
                'default_value' => 1,
                'wrapper'       => ['width' => 33],
            ],
            [
                'key'   => 'field_ccc_pg_show_read_more',
                'label' => __('Show Read More', 'ccc-primary-theme'),
                'name'  => 'show_read_more',
                'type'  => 'true_false',
                'ui'    => 1,
                'default_value' => 1,
                'wrapper'       => ['width' => 33],
            ],
            [
                'key'   => 'field_ccc_pg_show_featured_image',
                'label' => __('Show Featured Image', 'ccc-primary-theme'),
                'name'  => 'show_featured_image',
                'type'  => 'true_false',
                'ui'    => 1,
                'default_value' => 1,
                'wrapper'       => ['width' => 50],
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'block',
                    'operator' => '==',
                    'value'    => 'acf/ccc-post-grid',
                ],
            ],
        ],
        'position'       => 'normal',
        'style'          => 'default',
        'active'         => true,
        'show_in_rest'   => 1,
    ]);
}

/**
 * Render callback for the Post Grid block.
 *
 * @param array  $block      Block settings and attributes.
 * @param string $content    Block inner HTML (not used).
 * @param bool   $is_preview Whether this is shown in the editor preview.
 */
function ccc_primary_render_post_grid_block($block, $content = '', $is_preview = false)
{
    // Load render.php
    $block_dir = __DIR__;
    if (file_exists($block_dir . '/render.php')) {
        include $block_dir . '/render.php';
    }
}
