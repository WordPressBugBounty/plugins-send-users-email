<?php
if (isset($_GET['wp_nonce']) && isset($_GET['action']) && $_GET['action'] === 'template_preview_iframe_action') {
    define('WP_USE_THEMES', false); 
    // Construct path from __FILE__ instead of GET to avoid encoding issues
    // This file is at: [ABSPATH]/wp-content/plugins/send-users-email/admin/template-preview.php
    // So we go up 4 directories to reach ABSPATH
    $path = dirname(__FILE__);  // /wp-content/plugins/send-users-email/admin
    $path = dirname($path);      // /wp-content/plugins/send-users-email
    $path = dirname($path);      // /wp-content/plugins
    $path = dirname($path);      // /wp-content
    $path = dirname($path);      // ABSPATH
    $path = rtrim($path, '/\\') . DIRECTORY_SEPARATOR;
    if (!file_exists($path . 'wp-load.php')) {
        die('WordPress loader not found. Checked path: ' . htmlspecialchars($path) . 'wp-load.php');
    }
    require_once($path . 'wp-load.php');

    $nonce = isset($_GET['wp_nonce']) ? sanitize_text_field($_GET['wp_nonce']) : '';
    if (!wp_verify_nonce($nonce, 'template_preview_iframe_action')) {
        die('Invalid nonce');
    }

    $preview = true; // Set a flag to indicate this is a preview
    $options = get_option('sue_send_users_email');

    // Ensure $options is an array before accessing its keys
    if ( ! is_array( $options ) ) {
        $options = [];
    }

    // Use null coalescing operator (??) for default values
    $logo = $options['logo_url'] ?? SEND_USERS_EMAIL_PLUGIN_BASE_URL . '/assets/sample-logo.png';
    $title = $options['email_title'] ?? __('This is a preview title', 'send-users-email');
    $tagline = $options['email_tagline'] ?? __('This is a preview tagline', 'send-users-email');
    $footer = $options['email_footer'] ?? __('Demo Footer Content', 'send-users-email');

    // Handle social links with a default array
    $social = $options['social'] ?? ["facebook" => "#", "instagram" => "#", "linkedin" => "#", "skype" => "#", "tiktok" => "#", "twitter" => "#", "youtube" => "#"];

    // Default email body content
    $email_body = __('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.', 'send-users-email');

    // Optional styles
    $styles = $options['email_template_style'] ?? '';

    $arg_template_data = [
        'title' => $title,
        'tagline' => $tagline,
        'email_body' => $email_body,
        'logo' => $logo,
        'footer' => $footer,
        'social' => $social,
        'styles' => $styles,
        'preview' => $preview,
        'style'   => isset($_GET['style']) ? sanitize_text_field($_GET['style']) : 'default',
    ];

    $obj_template_data = new SUE_Template_Data($arg_template_data);

    $template_data = [
        'obj_template_data' => $obj_template_data,
        'iframe_preview'    => true,
    ];

    $style = ( isset( $_GET['style'] ) ) ? sanitize_text_field( $_GET['style'] ) : 'default';

    $height_reporter = '<script>
(function(){
    function reportHeight(){
        var h = Math.max(
            document.body ? document.body.scrollHeight : 0,
            document.documentElement.scrollHeight
        );
        window.parent.postMessage({type:"sue_iframe_height",height:h},"*");
    }
    // Re-measure once all images are loaded in case they changed layout
    window.addEventListener("load", reportHeight);
    // Also fire immediately in case readyState is already complete
    if(document.readyState==="complete"){ reportHeight(); }
})();
</script>';

    ob_start();

    switch ($style) {
        case 'green':
        case 'pink':
        case 'pink':
        case 'blue':
        case 'purple':
        case 'red':
        case 'yellow':
        case 'purity':
        case 'creatorloop':
        case 'darkmode':
        case 'modern':
        case 'dailybrief':
        case 'plaintext':
        case 'plainletter':
        case 'serif':
        case 'growthmode':
            sue_include_template(
                'templates/email/email-template-'.$style.'.php',
                $template_data,
                false
            );
            break;
        case 'custom':
            echo SUE_Custom_Html_Template::parse_template(
                $title,
                $tagline,
                $email_body,
                $logo 
            );
        break;
        case 'woocommerce':
            sue_include_template(
                'templates/woo-email-template.php',
                $template_data,
                false
            );
        break;
        default:
            sue_include_template(
                'email-template.php',
                $template_data,
                false
            );
            break;
    }

    $html = ob_get_clean();

    // Inject height reporter just before </body> so it runs inside the document
    if ( stripos( $html, '</body>' ) !== false ) {
        $html = str_ireplace( '</body>', $height_reporter . '</body>', $html );
    } else {
        $html .= $height_reporter;
    }

    echo $html;

} else {
    die('Nonce not provided');
}


?>