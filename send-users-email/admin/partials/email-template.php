<?php

$obj_template_data = $args['obj_template_data'] ?? null;
$iframe_preview = $args['iframe_preview'] ?? false;
$body_inline_styles = '';
if ( $obj_template_data->is_preview() && !$iframe_preview ) {
    ?>
    <div class="sue-pro-wrap">
        <div class="sue-pro-upgrade-banner" style="margin-bottom: 40px;">
            <div class="sue-banner-text">
                <h3><?php 
    esc_attr_e( 'You are using the free version', 'send-users-email' );
    ?></h3>
                <p><?php 
    esc_attr_e( 'Upgrade to PRO to preview and use prebuilt templates — or use your own HTML template.', 'send-users-email' );
    ?></p>
            </div>
            <a class="btn-upgrade" href="<?php 
    echo esc_url( sue_fs()->get_upgrade_url() );
    ?>" role="button">
                <?php 
    esc_attr_e( 'Upgrade to PRO', 'send-users-email' );
    ?>
            </a>
        </div>

        <h3 class="sue-plain-text-heading"><?php 
    esc_attr_e( 'Email Plain Text Preview:', 'send-users-email' );
    ?></h3>
    </div>
<?php 
}
?>


<?php 
/**
 * @var $logo
 * @var $styles
 * @var $title
 * @var $tagline
 * @var $email_body
 * @var $footer
 * @var $social
 */
?>
<!DOCTYPE html>
<html lang="en" dir="auto" class="email-content">
<head>
    <title><?php 
bloginfo( 'name' );
?></title>
    <meta charset="UTF-8"/>

    <style type="text/css">
        body {
            font-family: sans-serif;
        }
        p {
            font-family: sans-serif;
        }
        .sue-logo td {
            text-align: center;
        }

        .sue-logo img {
            max-height: 75px;
        }

        .sue-title {
            text-align: center;
        }

        .sue-tagline {
            text-align: center;
        }

        .sue-footer td {
            text-align: center;
            padding-top: 30px;
        }

        .sue-footer-social td {
            text-align: center;
            padding-top: 30px;
        }

        .aligncenter {
            display: block;
            margin-left: auto !important;
            margin-right: auto !important;
        }

        .alignleft {
            float: left;
            margin-inline-start: 0;
            margin-inline-end: 2em;
        }

        .alignright {
            float: right;
            margin-inline-start: 2em;
            margin-inline-end: 0;
        }
    </style>

	<?php 
if ( $obj_template_data && $obj_template_data->get_email_styles() ) {
    ?>
        <style>
            <?php 
    echo stripslashes_deep( wp_strip_all_tags( $obj_template_data->get_email_styles() ) );
    ?>
        </style>
	<?php 
}
?>

</head>

    <?php 
?>
<body class="sue-email-template-" style="<?php 
echo $body_inline_styles;
?>">
    <?php 
?>

<table class="sue-main-table">
	<?php 
if ( $obj_template_data && $obj_template_data->get_email_logo() ) {
    ?>
        <tr class="sue-logo">
            <td>
                <img src="<?php 
    echo esc_url_raw( $obj_template_data->get_email_logo() );
    ?>" alt="<?php 
    bloginfo( 'name' );
    ?>"/>
            </td>
        </tr>
	<?php 
}
?>

	<?php 
if ( $obj_template_data && $obj_template_data->get_email_title() || $obj_template_data && $obj_template_data->get_email_tagline() ) {
    ?>
        <tr class="sue-title-tagline">
            <td>
				<?php 
    if ( $obj_template_data && $obj_template_data->get_email_title() ) {
        ?>
                    <h2 class="sue-title"><?php 
        echo esc_html( stripslashes_deep( $obj_template_data->get_email_title() ) );
        ?></h2>
				<?php 
    }
    ?>

				<?php 
    if ( $obj_template_data && $obj_template_data->get_email_tagline() ) {
        ?>
                    <h5 class="sue-tagline"><?php 
        echo esc_html( stripslashes_deep( $obj_template_data->get_email_tagline() ) );
        ?></h5>
				<?php 
    }
    ?>
            </td>
        </tr>
	<?php 
}
?>

    <tr class="sue-email-body">
        <td>
            <?php 
if ( $obj_template_data && $obj_template_data->get_email_body() ) {
    ?>
			    <?php 
    echo $obj_template_data->get_email_body();
    ?>
            <?php 
}
?>
        </td>
    </tr>

	<?php 
if ( $obj_template_data && $obj_template_data->get_email_footer() ) {
    ?>
        <tr class="sue-footer">
            <td>
				<?php 
    echo stripslashes_deep( $obj_template_data->get_email_footer() );
    ?>
            </td>
        </tr>
	<?php 
}
?>

	<?php 
if ( $obj_template_data && !empty( $obj_template_data->get_email_social_links() ) ) {
    ?>
        <tr class="sue-footer-social">
            <td>
				<?php 
    $obj_template_data->display_social_links();
    ?>
            </td>
        </tr>
	<?php 
}
?>
</table>

</body>
</html>
