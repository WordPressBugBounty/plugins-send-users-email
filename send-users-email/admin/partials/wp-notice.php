<?php
$message = isset( $message ) ? $message : '';
$type = isset( $type ) ? $type : 'info';
$dismissible = isset( $dismissible ) ? $dismissible : true;
?>
<div class="notice notice-<?php echo esc_attr( $type ); ?> <?php echo $dismissible ? 'is-dismissible' : ''; ?>">
    <p><?php echo esc_html( $message ); ?></p>
</div>