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
      background-color: #f5f5f3;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif;
      color: #1a1a1a;
      -webkit-font-smoothing: antialiased;
    }

    .wrapper {
      width: 100%;
      background-color: #f5f5f3;
      padding: 40px 0 60px;
    }

    .container {
      max-width: 560px;
      margin: 0 auto;
      background-color: #ffffff;
      border-radius: 4px;
      overflow: hidden;
    }

    /* Header */
    .header {
      padding: 36px 48px 28px;
      border-bottom: 1px solid #ebebeb;
      display: flex;
      align-items: center;
      gap: 14px;
    }

    .logo {
      display: inline-block;
      width: 32px;
      height: 32px;
      background-color: #1a1a1a;
      border-radius: 6px;
      flex-shrink: 0;
    }

    .header-text {}

    .title {
      font-size: 15px;
      font-weight: 600;
      margin: 0 0 2px 0;
      color: #1a1a1a;
      letter-spacing: -0.01em;
    }

    .tagline {
      font-size: 12px;
      color: #999;
      margin: 0;
      letter-spacing: 0;
    }



    /* Body */
    .body {
      padding: 36px 48px 40px;
    }

    .body p {
      font-size: 15px;
      line-height: 1.75;
      color: #333;
      margin: 0 0 18px 0;
    }

    .body p:last-child {
      margin-bottom: 0;
    }

    .body a {
      color: #1a1a1a;
      text-decoration: underline;
      text-decoration-color: #bbb;
      text-underline-offset: 2px;
    }

    .body a:hover {
      text-decoration-color: #1a1a1a;
    }

    .body ul,
    .body ol {
      font-size: 15px;
      line-height: 1.75;
      color: #333;
      margin: 0 0 18px 0;
      padding-left: 22px;
    }

    .body li {
      margin-bottom: 6px;
    }

    .body li:last-child {
      margin-bottom: 0;
    }

    /* Divider */
    .divider {
      border: none;
      border-top: 1px solid #ebebeb;
      margin: 28px 0;
    }

    /* Highlight block */
    .highlight {
      background-color: #f7f7f5;
      border-left: 3px solid #1a1a1a;
      padding: 14px 18px;
      margin: 0 0 18px 0;
      border-radius: 0 4px 4px 0;
    }

    .highlight p {
      margin: 0 !important;
      font-size: 14px !important;
      color: #555 !important;
    }

    /* Footer */
    .footer {
      padding: 20px 48px 28px;
      border-top: 1px solid #ebebeb;
    }

    .footer p {
      font-size: 11px;
      color: #bbb;
      margin: 0 0 4px 0;
      line-height: 1.7;
    }

    .footer a {
      color: #bbb;
      text-decoration: underline;
    }

    @media (max-width: 620px) {
      .header, .body, .footer { padding-left: 24px; padding-right: 24px; }
      .header { flex-wrap: wrap; }
      .issue-badge { margin-left: 0; width: 100%; }
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
      <!-- Logo: black square as placeholder.
           Replace with: <img src="logo.png" width="32" alt="Logo"> -->
      <div class="logo">
        <?php if($obj_template_data && $obj_template_data->get_email_logo()): ?>
          <img src="<?php echo esc_attr( $obj_template_data->get_email_logo() ); ?>" width="32" alt="Logo">
        <?php endif; ?>
      </div>
      <div class="header-text">
        <h1 class="title"><?php echo $obj_template_data ? $obj_template_data->get_email_title() : ''; ?></h1>
        <p class="tagline"><?php echo $obj_template_data ? $obj_template_data->get_email_tagline() : ''; ?></p>
      </div>
    </div>

    <!-- FLIESSTEXT -->
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
