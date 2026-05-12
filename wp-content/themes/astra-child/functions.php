<?php
/**
 * Astra Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child
 * @since 1.0.0
 */

// ========================
// CHILD THEME STYLES
// ========================
function astra_child_enqueue_styles() {
    $css_file = get_stylesheet_directory() . '/style.css';
    $version  = file_exists($css_file) ? filemtime($css_file) : '1.0';
    wp_enqueue_style('astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), $version, 'all');
    
    // Custom animation script
    $js_file = get_stylesheet_directory() . '/script.js';
    $js_version = file_exists($js_file) ? filemtime($js_file) : '1.0';
    wp_enqueue_script('astra-child-theme-js', get_stylesheet_directory_uri() . '/script.js', array(), $js_version, true);
}
add_action('wp_enqueue_scripts', 'astra_child_enqueue_styles', 15);

// ========================
// GOOGLE FONTS
// ========================
function sds_enqueue_google_fonts() {
    wp_enqueue_style(
        'sds-google-fonts',
        'https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&display=swap',
        array(),
        null
    );
}
add_action('wp_enqueue_scripts', 'sds_enqueue_google_fonts', 5);

function sds_preconnect_fonts($urls, $relation_type) {
    if ('preconnect' === $relation_type) {
        $urls[] = ['href' => 'https://fonts.googleapis.com', 'crossorigin' => true];
        $urls[] = ['href' => 'https://fonts.gstatic.com', 'crossorigin' => true];
    }
    return $urls;
}
add_filter('wp_resource_hints', 'sds_preconnect_fonts', 10, 2);

// ========================
// REMOVE WORDPRESS BLOAT
// ========================
function sds_remove_bloat() {
    // Remove emoji scripts & styles
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

    // Remove unnecessary meta tags
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'rest_output_link_wp_head');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_resource_hints', 2);
    remove_action('wp_head', 'feed_links_extra', 3);

    // Disable oEmbed
    remove_action('wp_head', 'wp_oembed_add_host_js');
}
add_action('init', 'sds_remove_bloat');

// Disable emoji DNS prefetch
function sds_disable_emoji_dns($urls, $relation_type) {
    if ('dns-prefetch' === $relation_type) {
        $urls = array_filter($urls, function($url) {
            return strpos($url, 'https://s.w.org/images/core/emoji/') === false;
        });
    }
    return $urls;
}
add_filter('wp_resource_hints', 'sds_disable_emoji_dns', 10, 2);

// ========================
// DEFER & ASYNC SCRIPTS
// ========================
function sds_defer_scripts($tag, $handle, $src) {
    // Don't defer admin or jQuery
    if (is_admin()) return $tag;
    $no_defer = ['jquery-core', 'jquery-migrate', 'jquery'];
    if (in_array($handle, $no_defer)) return $tag;
    
    // Defer everything else
    if (strpos($tag, 'defer') === false && strpos($tag, '<script') !== false) {
        $tag = str_replace(' src=', ' defer src=', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'sds_defer_scripts', 10, 3);

// ========================
// REMOVE QUERY STRINGS FROM STATIC RESOURCES
// ========================
function sds_remove_query_strings($src) {
    if (strpos($src, '?ver=') !== false) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'sds_remove_query_strings', 999);
add_filter('script_loader_src', 'sds_remove_query_strings', 999);

// ========================
// SLOW HEARTBEAT ON FRONTEND
// ========================
function sds_heartbeat_settings($settings) {
    $settings['interval'] = 60; // 60 seconds instead of 15
    return $settings;
}
add_filter('heartbeat_settings', 'sds_heartbeat_settings');

// Disable heartbeat entirely on frontend
function sds_disable_frontend_heartbeat() {
    if (!is_admin()) {
        wp_deregister_script('heartbeat');
    }
}
add_action('init', 'sds_disable_frontend_heartbeat', 1);

// ========================
// DISABLE XMLRPC & SELF PINGBACK
// ========================
add_filter('xmlrpc_enabled', '__return_false');
add_filter('pre_ping', function(&$links) { $links = []; });

// ========================
// LIMIT POST REVISIONS & AUTOSAVE
// ========================
if (!defined('AUTOSAVE_INTERVAL')) define('AUTOSAVE_INTERVAL', 120);

// ========================
// DISABLE DASHICONS ON FRONTEND (for non-logged-in users)
// ========================
function sds_remove_dashicons() {
    if (!is_user_logged_in()) {
        wp_deregister_style('dashicons');
    }
}
add_action('wp_enqueue_scripts', 'sds_remove_dashicons', 100);

// ========================
// DISABLE GUTENBERG BLOCK LIBRARY CSS ON FRONTEND (when not needed)
// ========================
function sds_remove_block_library_css() {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-block-style');
    wp_dequeue_style('global-styles');
}
// NOTE: We keep block CSS since we use Gutenberg blocks
// add_action('wp_enqueue_scripts', 'sds_remove_block_library_css', 100);

// ========================
// HONEYPOT ANTI-SPAM
// ========================
function add_comment_honeypot() {
    echo '<div style="display:none!important" aria-hidden="true">';
    echo '<label for="website_url">Ne pas remplir ce champ</label>';
    echo '<input type="text" id="website_url" name="website_url" value="" autocomplete="off" tabindex="-1">';
    echo '</div>';
}
add_action('comment_form_after_fields', 'add_comment_honeypot');

function check_comment_honeypot($commentdata) {
    if (!empty($_POST['website_url'])) {
        wp_die('Soumission bloquée — bot détecté.', 'Erreur', ['response' => 403]);
    }
    return $commentdata;
}
add_filter('preprocess_comment', 'check_comment_honeypot');

function block_spam_submissions() {
    if (isset($_POST['_wpcf7']) && !empty($_POST['honeypot_field'])) {
        wp_die('Spam détecté.', 'Erreur', ['response' => 403]);
    }
}
add_action('init', 'block_spam_submissions');

// ========================
// CUSTOM MEGA FOOTER
// ========================
function sds_custom_mega_footer() {
    ?>
    <footer class="sds-mega-footer">
        <div class="sds-footer-container">
            <div class="sds-footer-grid">
                
                <div class="sds-footer-col sds-footer-brand">
                    <h3>Sen Digital Solution</h3>
                    <p>Votre partenaire stratégique pour une croissance digitale explosive. Création web, marketing et identité de marque.</p>
                    <div class="sds-social-links">
                        <a href="#" aria-label="LinkedIn">in</a>
                        <a href="#" aria-label="Twitter">tw</a>
                        <a href="#" aria-label="Instagram">ig</a>
                        <a href="#" aria-label="Facebook">fb</a>
                    </div>
                </div>

                <div class="sds-footer-col">
                    <h4>Nos Services</h4>
                    <ul>
                        <li><a href="/mes_dossiers/wordpress_agency/services">Développement Web</a></li>
                        <li><a href="/mes_dossiers/wordpress_agency/services">Design UI/UX</a></li>
                        <li><a href="/mes_dossiers/wordpress_agency/services">Marketing & SEO</a></li>
                        <li><a href="/mes_dossiers/wordpress_agency/services">Identité de Marque</a></li>
                    </ul>
                </div>

                <div class="sds-footer-col">
                    <h4>L'Agence</h4>
                    <ul>
                        <li><a href="/mes_dossiers/wordpress_agency/a-propos">À propos de nous</a></li>
                        <li><a href="/mes_dossiers/wordpress_agency/portfolio">Notre Portfolio</a></li>
                        <li><a href="/mes_dossiers/wordpress_agency/blog">Blog & Actualités</a></li>
                        <li><a href="/mes_dossiers/wordpress_agency/contact">Contactez-nous</a></li>
                    </ul>
                </div>

                <div class="sds-footer-col sds-footer-newsletter">
                    <h4>Restez connectés</h4>
                    <p>Abonnez-vous à notre newsletter pour recevoir nos derniers articles et conseils.</p>
                    <form class="sds-newsletter-form">
                        <input type="email" placeholder="Votre adresse e-mail" required>
                        <button type="button">→</button>
                    </form>
                </div>

            </div>
            
            <div class="sds-footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Sen Digital Solution. Tous droits réservés.</p>
                <div class="sds-footer-legal">
                    <a href="#">Mentions légales</a>
                    <a href="#">Politique de confidentialité</a>
                </div>
            </div>
        </div>
    </footer>
    <?php
}

// Remove default Astra footer and inject ours
add_action('wp', function() {
    remove_action('astra_footer_content', 'astra_advanced_footer_markup');
    remove_action('astra_footer_content', 'astra_footer_small_footer_template');
});
add_action('astra_footer', 'sds_custom_mega_footer');

// ========================
// MARQUEE TICKER SHORTCODE
// ========================
function sds_marquee_shortcode() {
    $items = ['WordPress', 'React', 'PHP', 'JavaScript', 'Figma', 'SEO', 'UI/UX Design', 'Node.js', 'Python', 'WooCommerce', 'MySQL', 'Branding'];
    $html = '<div class="sds-marquee-wrapper">';
    $html .= '<div class="sds-marquee-track">';
    // Duplicate for seamless loop
    for ($i = 0; $i < 2; $i++) {
        foreach ($items as $item) {
            $html .= '<span class="sds-marquee-item">' . esc_html($item) . '</span>';
            $html .= '<span class="sds-marquee-dot">◆</span>';
        }
    }
    $html .= '</div></div>';
    return $html;
}
add_shortcode('sds_marquee', 'sds_marquee_shortcode');
