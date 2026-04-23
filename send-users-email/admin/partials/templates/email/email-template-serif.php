<?php
$obj_template_data = $args['obj_template_data'] ?? null;
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php bloginfo( 'name' ); ?></title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #f0ede8;
      font-family: Georgia, 'Times New Roman', serif;
      color: #1a1a1a;
    }

    .wrapper {
      width: 100%;
      background-color: #f0ede8;
      padding: 48px 0;
    }

    .container {
      max-width: 580px;
      margin: 0 auto;
      background-color: #ffffff;
    }

    /* Header */
    .header {
      padding: 48px 56px 36px;
      text-align: center;
      border-bottom: 1px solid #e8e4de;
    }

    .logo {
      display: inline-block;
      width: 56px;
      height: 56px;
      background-color: #1a1a1a;
      border-radius: 50%;
      margin-bottom: 28px;
    }

    .title {
      font-size: 26px;
      font-weight: normal;
      margin: 0 0 10px 0;
      color: #1a1a1a;
      letter-spacing: -0.01em;
      line-height: 1.2;
    }

    .tagline {
      font-family: 'Courier New', monospace;
      font-size: 11px;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: #aaa;
      margin: 0;
    }

    /* Body */
    .body {
      padding: 44px 56px 48px;
    }

    .body p {
      font-size: 16px;
      line-height: 1.85;
      color: #333;
      margin: 0 0 22px 0;
    }

    .body p:last-child {
      margin-bottom: 0;
    }

    /* Footer */
    .footer {
      padding: 24px 56px;
      border-top: 1px solid #e8e4de;
      text-align: center;
    }

    .footer p {
      font-family: 'Courier New', monospace;
      font-size: 10px;
      letter-spacing: 0.08em;
      color: #bbb;
      margin: 0 0 6px 0;
      line-height: 1.7;
    }

    .footer a {
      color: #bbb;
      text-decoration: underline;
    }

    @media (max-width: 620px) {
      .header, .body, .footer { padding-left: 28px; padding-right: 28px; }
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
      <!-- Logo: schwarzer Kreis als Platzhalter.
           Ersetzen mit: <img src="logo.png" width="56" alt="Logo"> -->
      <div class="logo">
        <?php if ($obj_template_data && $obj_template_data->get_email_logo()) : ?>
          <img src="<?php echo $obj_template_data->get_email_logo(); ?>" width="56" alt="Logo">
        <?php endif; ?>
      </div>
      <h1 class="title"><?php echo $obj_template_data ? $obj_template_data->get_email_title() : ''; ?></h1>
      <p class="tagline"><?php echo $obj_template_data ? $obj_template_data->get_email_tagline() : ''; ?></p>
    </div>

    <!-- FLIESSTEXT -->
    <div class="body">
      <?php echo $obj_template_data->get_email_body(); ?>

    </div>

    <!-- FOOTER -->
    <div class="footer">
      <?php if ( $obj_template_data && $obj_template_data->get_email_footer() ): ?>
        <p><?php echo stripslashes_deep( $obj_template_data->get_email_footer() ); ?></p>
      <?php endif; ?>
    </div>

  </div>
</div>
</body>
</html>
