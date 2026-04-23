<?php
$default_email_theme = $args['default_email_theme'] ?? 'default';
?>
<div class="col">
    <p><strong><?php esc_attr_e( 'Select email theme to use', 'send-users-email' ); ?></strong></p>
    <select class="form-select" aria-label="Select email style" id="email_style" name="email_style">
        <?php $legacy_themes = [ 'blue', 'green', 'pink', 'purple', 'yellow', 'red' ]; ?>
        <?php foreach ( sue_get_email_theme_scheme() as $theme ): ?>
            <?php
            if ( $theme === 'custom' ) {
                $theme_label = __( 'Custom HTML Template', 'send-users-email' );
            } else {
                $theme_label = ucfirst( esc_attr( $theme ) );
            }
            if ( in_array( $theme, $legacy_themes, true ) ) {
                $theme_label .= ' (Legacy)';
            }
            ?>
            <option value="<?php esc_attr_e( esc_attr( $theme ), 'send-users-email' ); ?>"
                <?php if ( $default_email_theme == $theme ) {
                    echo 'selected';
                } ?>>
                <?php echo esc_html( $theme_label ); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>