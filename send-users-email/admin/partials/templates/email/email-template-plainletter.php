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
      font-family: Georgia, 'Times New Roman', serif;
      color: #0d0d0d;
      -webkit-font-smoothing: antialiased;
    }

    .wrapper {
      width: 100%;
      background-color: #ffffff;
      padding: 0;
    }

    .container {
      max-width: 600px;
      margin: 0 auto;
      padding: 0 24px;
    }

    /* Header */
    .header {
      padding: 32px 0 24px;
      text-align: center;
      border-bottom: 1px solid #ddd;
      margin-bottom: 40px;
    }

    .pub-name {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif;
      font-size: 22px;
      font-weight: 700;
      color: #0d0d0d;
      margin: 0 0 6px 0;
      letter-spacing: -0.02em;
    }

    .pub-tagline {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif;
      font-size: 13px;
      color: #6b6b6b;
      margin: 0 0 16px 0;
    }



    /* Post header */
    .post-header {
      margin-bottom: 32px;
    }

    .post-title {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif;
      font-size: 30px;
      font-weight: 700;
      line-height: 1.2;
      color: #0d0d0d;
      margin: 0 0 12px 0;
      letter-spacing: -0.03em;
    }

    .post-subtitle {
      font-size: 18px;
      line-height: 1.5;
      color: #6b6b6b;
      margin: 0 0 20px 0;
    }

    /* Body */
    .body p {
      font-size: 18px;
      line-height: 1.8;
      color: #0d0d0d;
      margin: 0 0 24px 0;
    }

    .body p:last-child {
      margin-bottom: 0;
    }

    .body a {
      color: #0d0d0d;
      text-decoration: underline;
    }

    .body h2 {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif;
      font-size: 22px;
      font-weight: 700;
      color: #0d0d0d;
      margin: 36px 0 14px 0;
      letter-spacing: -0.02em;
    }

    .body ul,
    .body ol {
      font-size: 18px;
      line-height: 1.8;
      color: #0d0d0d;
      margin: 0 0 24px 0;
      padding-left: 26px;
    }

    .body li {
      margin-bottom: 8px;
    }

    /* Pullquote */
    .pullquote {
      border-left: 3px solid #0d0d0d;
      margin: 8px 0 32px 0;
      padding: 4px 0 4px 20px;
    }

    .pullquote p {
      font-size: 20px !important;
      font-style: italic;
      color: #333 !important;
      margin: 0 !important;
      line-height: 1.65 !important;
    }

    hr.divider {
      border: none;
      border-top: 1px solid #eee;
      margin: 36px 0;
    }



    /* Footer */
    .footer {
      margin-top: 48px;
      padding: 28px 0 40px;
      border-top: 1px solid #ddd;
      text-align: center;
    }

    .footer-pub {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif;
      font-size: 14px;
      font-weight: 700;
      color: #0d0d0d;
      margin: 0 0 8px 0;
    }

    .footer p {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif;
      font-size: 12px;
      color: #aaa;
      margin: 0 0 4px 0;
      line-height: 1.7;
    }

    .footer a {
      color: #aaa;
      text-decoration: underline;
    }

    @media (max-width: 620px) {
      .body p, .body ul, .body ol { font-size: 16px; }
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

    <!-- PUBLICATION HEADER -->
    <div class="header">
      <p class="pub-name"><?php echo $obj_template_data ? $obj_template_data->get_email_title() : ''; ?></p>
      <p class="pub-tagline"><?php echo $obj_template_data ? $obj_template_data->get_email_tagline() : ''; ?></p>
    </div>

    <!-- BODY -->
    <div class="body">
      <p><?php echo wp_kses_post( stripslashes_deep( $obj_template_data ? $obj_template_data->get_email_body() : '' ) ); ?></p>

    </div>

    <!-- FOOTER -->
    <div class="footer">
      <p><?php echo stripslashes_deep( $obj_template_data ? $obj_template_data->get_email_footer() : '' ); ?></p>
    </div>

  </div>
</div>
</body>
</html>
