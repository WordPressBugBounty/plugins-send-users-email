<?php
$obj_template_data = $args['obj_template_data'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Newsletter</title>
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
      background-color: #f4f4f4;
      padding: 40px 0 48px 0;
    }

    .container {
      max-width: 600px;
      margin: 0 auto;
    }

    /* ── HEADER BANNER ── */
    .header {
      background-color: #1c1c1c;
      padding: 28px 48px 24px;
      text-align: center;
    }

    .logo-row {
      margin-bottom: 6px;
    }

    .pub-name {
      font-size: 26px;
      font-weight: 900;
      color: #ffffff;
      margin: 0 0 6px 0;
      letter-spacing: -0.03em;
      text-transform: uppercase;
    }

    .pub-name span {
      color: #e8ff47;
    }

    .pub-tagline {
      font-size: 11px;
      color: #777;
      margin: 0;
      letter-spacing: 0.08em;
      text-transform: uppercase;
    }

    /* ── INTRO TICKER ── */
    .ticker {
      background-color: #e8ff47;
      padding: 10px 48px;
      text-align: center;
    }

    .ticker p {
      font-size: 12px;
      font-weight: 700;
      color: #1c1c1c;
      margin: 0;
      letter-spacing: 0.04em;
      text-transform: uppercase;
    }

    /* ── CONTENT AREA ── */
    .content {
      background-color: #ffffff;
      padding: 0;
    }

    /* ── BRIEFS (main stories) ── */
    .brief {
      padding: 30px 48px;
      border-bottom: 1px solid #efefef;
    }

    .brief-label {
      display: inline-block;
      background-color: #e8ff47;
      color: #1c1c1c;
      font-size: 9px;
      font-weight: 800;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      padding: 3px 8px;
      margin-bottom: 12px;
    }

    .brief h2 {
      font-size: 19px;
      font-weight: 800;
      color: #1a1a1a;
      margin: 0 0 12px 0;
      line-height: 1.3;
      letter-spacing: -0.02em;
    }

    .brief p {
      font-size: 15px;
      line-height: 1.75;
      color: #333;
      margin: 0 0 14px 0;
    }

    .brief p:last-child {
      margin-bottom: 0;
    }

    .brief a {
      color: #1a1a1a;
      font-weight: 600;
      text-decoration: underline;
      text-decoration-color: #e8ff47;
      text-decoration-thickness: 2px;
      text-underline-offset: 2px;
    }

    /* ── SECTION DIVIDER ── */
    .section-divider {
      padding: 20px 48px 0;
      background-color: #ffffff;
    }

    .section-divider-inner {
      border-top: 2px solid #1c1c1c;
      padding-top: 16px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .section-divider-title {
      font-size: 11px;
      font-weight: 800;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: #1c1c1c;
      margin: 0;
      white-space: nowrap;
    }

    /* ── SNIPPETS ── */
    .snippets {
      background-color: #ffffff;
      padding: 16px 48px 30px;
      border-bottom: 1px solid #efefef;
    }

    .snippet-item {
      display: flex;
      gap: 12px;
      padding: 10px 0;
      border-bottom: 1px solid #f5f5f5;
    }

    .snippet-item:last-child {
      border-bottom: none;
      padding-bottom: 0;
    }

    .snippet-bullet {
      font-size: 15px;
      line-height: 1;
      padding-top: 2px;
      flex-shrink: 0;
    }

    .snippet-item p {
      font-size: 14px;
      line-height: 1.65;
      color: #333;
      margin: 0;
    }

    .snippet-item a {
      color: #1a1a1a;
      font-weight: 600;
      text-decoration: underline;
      text-decoration-color: #e8ff47;
      text-decoration-thickness: 2px;
      text-underline-offset: 2px;
    }

    /* ── AROUND THE WEB ── */
    .around-web {
      background-color: #ffffff;
      padding: 16px 48px 30px;
      border-bottom: 1px solid #efefef;
    }

    .web-item {
      font-size: 14px;
      line-height: 1.65;
      color: #333;
      padding: 7px 0;
      border-bottom: 1px solid #f5f5f5;
    }

    .web-item:last-child {
      border-bottom: none;
    }

    .web-item a {
      color: #1a1a1a;
      font-weight: 600;
      text-decoration: underline;
      text-decoration-color: #e8ff47;
      text-decoration-thickness: 2px;
      text-underline-offset: 2px;
    }

    /* ── SIGN-OFF ── */
    .signoff {
      background-color: #ffffff;
      padding: 28px 48px 32px;
    }

    .signoff p {
      font-size: 15px;
      line-height: 1.75;
      color: #333;
      margin: 0 0 14px 0;
    }

    .signoff p:last-child {
      margin-bottom: 0;
    }

    /* ── FOOTER ── */
    .footer {
      background-color: #1c1c1c;
      padding: 24px 48px;
      text-align: center;
    }

    .footer p {
      font-size: 11px;
      color: #555;
      margin: 0 0 4px 0;
      line-height: 1.7;
    }

    .footer a {
      color: #777;
      text-decoration: underline;
    }

    @media (max-width: 620px) {
      .header, .brief, .snippets, .around-web,
      .signoff, .footer, .ticker,
      .section-divider { padding-left: 24px; padding-right: 24px; }
      .pub-name { font-size: 20px; }
    }
  </style>
  <?php if ( $obj_template_data && $obj_template_data->get_email_styles() ): ?>
      <style>
          <?php echo stripslashes_deep( wp_strip_all_tags( $obj_template_data->get_email_styles() ) ); ?>
      </style>
  <?php endif; ?>
</head>
<body>
<div class="wrapper">
  <div class="container">

    <!-- HEADER -->
    <div class="header">
      <h1 class="pub-name"><?php echo $obj_template_data ? $obj_template_data->get_email_title() : ''; ?></h1>
      <p class="pub-tagline"><?php echo $obj_template_data ? $obj_template_data->get_email_tagline() : ''; ?></p>
    </div>

    <!-- TICKER -->
    <!-- <div class="ticker">
      <p>👋 Good morning — here's what's going on in the world today</p>
    </div> -->

    <div class="content">

      <!-- BRIEF 1 -->
      <div class="brief">
        <?php echo $obj_template_data->get_email_body(); ?>
      </div>

    </div><!-- /content -->

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
