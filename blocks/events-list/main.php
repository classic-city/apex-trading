<?php
/**
 * Events Block ACF registration and fields.
 *
 * @package CCCPrimaryTheme
 */

if (! defined('ABSPATH')) {
    exit;
}

add_action('acf/init', 'ccc_primary_register_events_block');

function ccc_primary_register_events_block(): void
{
    if (! function_exists('acf_register_block_type')) {
        return;
    }

    acf_register_block_type([
        'name'            => 'ccc-events',
        'title'           => __('Events', 'ccc-primary-theme'),
        'description'     => __('Displays a custom list of events.', 'ccc-primary-theme'),
        'render_callback' => 'ccc_primary_render_events_block',
        'category'        => 'layout',
        'icon'            => 'calendar',
        'keywords'        => ['events', 'event', 'grid'],
        'supports'        => [
            'align'  => false,
            'anchor' => true,
            'mode'   => true,
        ],
    ]);

    ccc_primary_register_events_fields();
}

function ccc_primary_register_events_fields(): void
{
    if (! function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group([
        'key'                   => 'group_ccc_events',
        'title'                 => __('Events', 'ccc-primary-theme'),
        'fields'                => [
            [
                'key'           => 'field_ccc_events',
                'label'         => __('Events', 'ccc-primary-theme'),
                'name'          => 'events',
                'type'          => 'repeater',
                'button_label'  => __('Add Event', 'ccc-primary-theme'),
                'layout'        => 'block',
                'sub_fields'    => [
                    [
                        'key'   => 'field_ccc_event_title',
                        'label' => __('Event Title', 'ccc-primary-theme'),
                        'name'  => 'title',
                        'type'  => 'text',
                    ],
                    [
                        'key'   => 'field_ccc_event_start',
                        'label' => __('Start Date', 'ccc-primary-theme'),
                        'name'  => 'start_date',
                        'type'  => 'date_picker',
                        'display_format' => 'F j, Y',
                        'return_format'  => 'Y-m-d',
                    ],
                    [
                        'key'   => 'field_ccc_event_end',
                        'label' => __('End Date', 'ccc-primary-theme'),
                        'name'  => 'end_date',
                        'type'  => 'date_picker',
                        'display_format' => 'F j, Y',
                        'return_format'  => 'Y-m-d',
                    ],
                    [
                        'key'   => 'field_ccc_event_description',
                        'label' => __('Short Description', 'ccc-primary-theme'),
                        'name'  => 'description',
                        'type'  => 'textarea',
                    ],
                    [
                        'key'   => 'field_ccc_event_link_text',
                        'label' => __('Link Text', 'ccc-primary-theme'),
                        'name'  => 'link_text',
                        'type'  => 'text',
                    ],
                    [
                        'key'   => 'field_ccc_event_link_url',
                        'label' => __('Link URL', 'ccc-primary-theme'),
                        'name'  => 'link',
                        'type'  => 'url',
                    ],
                    [
                        'key'   => 'field_ccc_event_featured_image',
                        'label' => __('Featured Image', 'ccc-primary-theme'),
                        'name'  => 'featured_image',
                        'type'  => 'image',
                        'return_format' => 'array',
                        'preview_size'  => 'medium',
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'block',
                    'operator' => '==',
                    'value'    => 'acf/ccc-events',
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
 * Render callback for the Events block.
 */
function ccc_primary_render_events_block($block, $content = '', $is_preview = false)
{
    $block_dir = __DIR__;
    if (file_exists($block_dir . '/render.php')) {
        include $block_dir . '/render.php';
    }
}
