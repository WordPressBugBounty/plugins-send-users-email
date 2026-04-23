<?php
$obj_template_data = $args['obj_template_data'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php bloginfo( 'name' ); ?></title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #ffffff;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif;
      color: #1a1a1a;
      -webkit-font-smoothing: antialiased;
    }

    .wrapper {
      width: 100%;
      background-color: #ffffff;
      padding: 48px 0 64px;
    }

    .container {
      max-width: 540px;
      margin: 0 auto;
      padding: 0 24px;
    }

    /* ── HEADER ── */
    .header {
      margin-bottom: 36px;
      padding-bottom: 20px;
      border-bottom: 1px solid #e0e0e0;
    }

    .pub-name {
      font-size: 14px;
      font-weight: 700;
      color: #1a1a1a;
      margin: 0 0 2px 0;
    }

    .pub-tagline {
      font-size: 13px;
      color: #888;
      margin: 0;
    }

    /* ── BODY ── */
    .body p {
      font-size: 15px;
      line-height: 1.8;
      color: #1a1a1a;
      margin: 0 0 20px 0;
    }

    .body p:last-child {
      margin-bottom: 0;
    }

    .body a {
      color: #1a1a1a;
      text-decoration: underline;
    }

    .body ul,
    .body ol {
      font-size: 15px;
      line-height: 1.8;
      color: #1a1a1a;
      margin: 0 0 20px 0;
      padding-left: 20px;
    }

    .body li {
      margin-bottom: 6px;
    }

    .body hr {
      border: none;
      border-top: 1px solid #e0e0e0;
      margin: 28px 0;
    }

    /* ── FOOTER ── */
    .footer {
      margin-top: 40px;
      padding-top: 20px;
      border-top: 1px solid #e0e0e0;
    }

    .footer p {
      font-size: 12px;
      color: #aaa;
      margin: 0 0 4px 0;
      line-height: 1.7;
    }

    .footer a {
      color: #aaa;
      text-decoration: underline;
    }
  </style>
  <?php if ( $obj_template_data && $obj_template_data->get_email_styles() ): ?>
      <style>
          <?php echo stripslashes_deep( wp_strip_all_tags( $obj_template_data->get_email_styles() ) ); ?>
      </style>
  <?php endif; ?>
</head>
<body class="sue-email-template-<?php echo $obj_template_data->get_email_style_name(); ?>">
<div class="wrapper">
  <div class="container">

    <!-- HEADER -->
    <div class="header">
      <p class="pub-name"><?php echo $obj_template_data ? $obj_template_data->get_email_title() : ''; ?></p>
      <p class="pub-tagline"><?php echo $obj_template_data ? $obj_template_data->get_email_tagline() : ''; ?></p>
    </div>

    <!-- BODY -->
    <div class="body">
      <p><?php echo $obj_template_data ? $obj_template_data->get_email_body() : ''; ?></p>
    </div>

    <!-- FOOTER -->
    <div class="footer">
      <p><?php echo stripslashes_deep( $obj_template_data ? $obj_template_data->get_email_footer() : '' ); ?></p>
    </div>

  </div>
</div>
</body>
</html>
