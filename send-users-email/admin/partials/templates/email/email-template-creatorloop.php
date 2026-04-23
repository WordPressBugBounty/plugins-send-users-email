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
      background-color: #0f0f0f;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif;
      color: #1a1a1a;
      -webkit-font-smoothing: antialiased;
    }

    .wrapper {
      width: 100%;
      background-color: #0f0f0f;
      padding: 40px 0 60px;
    }

    .container {
      max-width: 580px;
      margin: 0 auto;
    }

    /* ── TOP NAV BAR ── */
    .topbar {
      text-align: center;
      padding: 0 0 20px 0;
    }

    .topbar-inner {
      display: inline-block;
    }

    .pub-name {
      font-size: 13px;
      font-weight: 700;
      color: #ffffff;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      margin: 0 0 10px 0;
    }

    .topbar-links {
      font-size: 11px;
      color: #666;
      margin: 0;
      letter-spacing: 0.04em;
    }

    .topbar-links a {
      color: #666;
      text-decoration: none;
    }

    .topbar-links a:hover {
      color: #999;
    }

    /* ── HERO BLOCK ── */
    .hero {
      background-color: #ffffff;
      border-radius: 8px 8px 0 0;
      padding: 44px 48px 36px;
      border-bottom: 2px solid #f0f0f0;
    }

    .edition-label {
      display: inline-block;
      background-color: #0f0f0f;
      color: #ffffff;
      font-size: 10px;
      font-weight: 700;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      padding: 5px 12px;
      border-radius: 20px;
      margin-bottom: 20px;
    }

    .hero-title {
      font-size: 28px;
      font-weight: 800;
      line-height: 1.2;
      color: #0d0d0d;
      margin: 0 0 14px 0;
      letter-spacing: -0.03em;
    }

    .hero-subtitle {
      font-size: 15px;
      line-height: 1.65;
      color: #555;
      margin: 0;
    }

    /* ── CONTENT BLOCKS ── */
    .block {
      background-color: #ffffff;
      padding: 32px 48px;
      border-bottom: 1px solid #f0f0f0;
    }

    .block:last-of-type {
      border-radius: 0 0 8px 8px;
      border-bottom: none;
    }

    .block p {
      font-size: 15px;
      line-height: 1.75;
      color: #333;
      margin: 0 0 18px 0;
    }

    .block p:last-child {
      margin-bottom: 0;
    }

    .block a {
      color: #0d0d0d;
      text-decoration: underline;
      text-decoration-color: #ccc;
      text-underline-offset: 2px;
    }

    .block a:hover {
      text-decoration-color: #0d0d0d;
    }

    .block ul,
    .block ol {
      font-size: 15px;
      line-height: 1.75;
      color: #333;
      margin: 0 0 18px 0;
      padding-left: 22px;
    }

    .block li {
      margin-bottom: 8px;
    }

    /* Section label inside a block */
    .section-label {
      font-size: 10px;
      font-weight: 700;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: #aaa;
      margin: 0 0 16px 0;
    }

    .block h2 {
      font-size: 18px;
      font-weight: 700;
      color: #0d0d0d;
      margin: 0 0 14px 0;
      letter-spacing: -0.02em;
    }

    /* ── HIGHLIGHT / CALLOUT ── */
    .callout {
      background-color: #f7f7f5;
      border-radius: 6px;
      padding: 18px 22px;
      margin: 0 0 18px 0;
    }

    .callout p {
      font-size: 14px !important;
      color: #444 !important;
      margin: 0 !important;
      line-height: 1.65 !important;
    }

    /* ── DIVIDER ── */
    hr.divider {
      border: none;
      border-top: 1px solid #f0f0f0;
      margin: 24px 0;
    }

    /* ── FOOTER ── */
    .footer {
      text-align: center;
      padding: 28px 24px 0;
    }

    .footer p {
      font-size: 11px;
      color: #444;
      margin: 0 0 5px 0;
      line-height: 1.7;
    }

    .footer a {
      color: #555;
      text-decoration: underline;
    }

    @media (max-width: 620px) {
      .hero, .block { padding-left: 24px; padding-right: 24px; }
      .hero-title { font-size: 22px; }
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

    <!-- TOP BAR -->
    <div class="topbar">
      <p class="pub-name">My Newsletter</p>
    </div>

    <!-- HERO -->
    <div class="hero">
      <h1 class="hero-title"><?php echo $obj_template_data->get_email_title(); ?></h1>
      <p class="hero-subtitle">
        <?php echo $obj_template_data->get_email_tagline(); ?>
      </p>
    </div>

    <!-- MAIN CONTENT BLOCK -->
    <div class="block">
      <?php echo $obj_template_data->get_email_body(); ?>
    </div>

    <?php if ( $obj_template_data && $obj_template_data->get_email_footer() ): ?>
      <!-- FOOTER -->
      <div class="footer">
        <p><?php echo stripslashes_deep( $obj_template_data->get_email_footer() ); ?></p>
      </div>
	<?php endif; ?>

  </div>
</div>
</body>
</html>
