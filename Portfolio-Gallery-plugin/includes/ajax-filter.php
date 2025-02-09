<?php
/**
 * AJAX Filter Shortcode and Callback for Portfolio Plugin.
 */

// Shortcode to display the AJAX filter.
function portfolio_plugin_ajax_filter_shortcode() {
        $terms = get_terms(array(
            'taxonomy'   => 'portfolio_category',
            'hide_empty' => true,
        ));

        ob_start();
        ?>
        <div class="portfolio-filter">
            <button class="filter-button active" data-category=""><?php _e('All Blogs', 'portfolio-plugin'); ?></button>
            <?php
            if (!empty($terms) && !is_wp_error($terms)) {
                foreach ($terms as $term) {
                    echo '<button class="filter-button" data-category="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</button>';
                }
            }
            ?>
        </div>
        <div id="portfolio-items">
            <?php
                portfolio_plugin_get_portfolio_items('');
            ?>
        </div>
        <?php
        return ob_get_clean();
}
add_shortcode('portfolio_filter', 'portfolio_plugin_ajax_filter_shortcode');

// Helper function to output portfolio items.
function portfolio_plugin_get_portfolio_items($category_slug, $paged = 1) {
        $options = get_option('portfolio_plugin_options', []);
        $items_per_page = isset($options['items_per_page']) && $options['items_per_page'] > 0 
            ? intval($options['items_per_page']) 
            : 12;

        $args = array(
            'post_type'      => 'portfolio',
            'posts_per_page' => $items_per_page,
            'paged'          => $paged
        );
        
        if (!empty($category_slug)) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'portfolio_category',
                    'field'    => 'slug',
                    'terms'    => $category_slug,
                ),
            );
        }

        $query = new WP_Query($args);
        if ($query->have_posts()) {
            echo '<ul class="portfolio-list grid">';
            while ($query->have_posts()) {
                $query->the_post();
                ?>
                <a href="<?php the_permalink(); ?>">
                    <div class="portfolio-item">
                        <div class="portfolio-thumbnail">
                            <?php the_post_thumbnail('medium_large'); ?>
                        </div>
                        <div class="portfolio-content">
                            <h2 class="portfolio-title"><?php the_title(); ?></h2>
                            <p class="portfolio-date"><?php the_time('F j, Y') ?></p>
                            <p class="portfolio-author">
                                <img src="<?php echo esc_url(get_avatar_url(get_the_author_meta('ID'))); ?>" 
                                    alt="<?php echo esc_attr(get_the_author()); ?>">
                                <span><?php the_author(); ?></span>
                            </p>
                        </div>
                    </div>
                </a>
                <?php
            }
            echo '</ul>';

            $total_pages = $query->max_num_pages;
            if ($total_pages > 1) {
                echo '<div class="portfolio-pagination">';
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo '<a href="#" class="page-numbers" data-page="' . $i . '">' . $i . '</a>';
                }
                echo '</div>';
            }

        } else {

            echo '<p>' . __('No portfolio items found.', 'portfolio-plugin') . '</p>';

        }
        wp_reset_postdata();
}

// AJAX callback to filter portfolio items.
function portfolio_plugin_ajax_filter_callback() {

    check_ajax_referer('portfolio_filter_nonce', 'nonce');
    $category_slug = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;

    ob_start();
    portfolio_plugin_get_portfolio_items($category_slug, $paged);
    $html = ob_get_clean();

    wp_send_json_success($html);
}
add_action('wp_ajax_portfolio_filter', 'portfolio_plugin_ajax_filter_callback');
add_action('wp_ajax_nopriv_portfolio_filter', 'portfolio_plugin_ajax_filter_callback');



function portfolio_plugin_enqueue_scripts() {
    wp_enqueue_script('portfolio-plugin-ajax', plugin_dir_url(__FILE__) . 'js/portfolio-ajax.js', array('jquery'), null, true);
    
    wp_localize_script('portfolio-plugin-ajax', 'portfolioPlugin', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('portfolio_filter_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'portfolio_plugin_enqueue_scripts');