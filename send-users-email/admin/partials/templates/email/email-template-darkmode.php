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
      background-color: #141414;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif;
      color: #e8e8e8;
      -webkit-font-smoothing: antialiased;
    }

    .wrapper {
      width: 100%;
      background-color: #141414;
      padding: 48px 0 64px;
    }

    .container {
      max-width: 580px;
      margin: 0 auto;
    }

    /* ── HEADER ── */
    .header {
      padding: 40px 52px 32px;
      border-bottom: 1px solid #2a2a2a;
      text-align: center;
    }

    .logo-mark {
      display: inline-block;
      width: 40px;
      height: 40px;
      background-color: #e8e8e8;
      border-radius: 8px;
      margin-bottom: 20px;
      /* Replace with: <img src="logo.png" width="40" alt="Logo"> */
    }

    .pub-name {
      font-size: 20px;
      font-weight: 700;
      color: #ffffff;
      margin: 0 0 6px 0;
      letter-spacing: -0.02em;
    }

    .pub-tagline {
      font-size: 12px;
      color: #666666;
      margin: 0;
      letter-spacing: 0.05em;
      text-transform: uppercase;
    }

    /* ── BODY ── */
    .body {
      padding: 40px 52px 48px;
      text-align: left;
    }

    .body p {
      font-size: 15px;
      line-height: 1.85;
      color: #e2e2e2;
      margin: 0 0 22px 0;
    }

    .body a {
      color: #ffffff;
      text-decoration: underline;
    }

    .body a:hover {
      text-decoration: none;
    }

    .body strong {
      color: #ffffff;
      font-weight: 600;
    }

    .body h2 {
      font-size: 17px;
      font-weight: 700;
      color: #ffffff;
      margin: 32px 0 14px 0;
      letter-spacing: -0.02em;
    }

    .body ul,
    .body ol {
      font-size: 15px;
      line-height: 1.85;
      color: #e2e2e2;
      margin: 0 0 22px 0;
      padding-left: 22px;
    }

    .body li {
      margin-bottom: 8px;
    }

    .body hr {
      border: none;
      border-top: 1px solid #2a2a2a;
      margin: 32px 0;
    }

    /* ── CALLOUT ── */
    .callout {
      background-color: #1e1e1e;
      border: 1px solid #2e2e2e;
      border-left: 3px solid #ffffff;
      border-radius: 0 6px 6px 0;
      padding: 16px 20px;
      margin: 0 0 22px 0;
    }

    .callout p {
      font-size: 14px !important;
      color: #cccccc !important;
      margin: 0 !important;
      line-height: 1.7 !important;
    }

    /* ── FOOTER ── */
    .footer {
      padding: 24px 52px 0;
      border-top: 1px solid #2a2a2a;
      text-align: center;
    }

    .footer p {
      font-size: 11px;
      color: #666666;
      margin: 0 0 5px 0;
      line-height: 1.7;
    }

    .footer a {
      color: #777777;
      text-decoration: underline;
    }

    @media (max-width: 620px) {
      .header, .body, .footer { padding-left: 24px; padding-right: 24px; }
    }
  </style>
  <?php if ( $obj_template_data && $obj_template_data->get_email_styles() ): ?>
      <style>
          <?php echo stripslashes_deep( wp_strip_all_tags( $obj_template_data->get_email_styles() ) ); ?>
      </style>
  <?php endif; ?>
</head>
<body class="sue-email-template-<?php echo $obj_template_data->get_email_style_name(); ?>" style="margin:0;padding:0;background-color:#141414;color:#e8e8e8;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Helvetica,Arial,sans-serif;" bgcolor="#141414">
<div class="wrapper">
    <div class="container">
        <table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#141414" style="background-color:#141414;padding:48px 0 64px;">
          <tr>
            <td align="center" valign="top" style="color:#e8e8e8;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Helvetica,Arial,sans-serif;">
              <!-- Container -->
              <table width="580" cellpadding="0" cellspacing="0" border="0" style="max-width:580px;width:100%;">

                <!-- HEADER -->
                <div class="header" style="padding:40px 52px 32px;border-bottom:1px solid #2a2a2a;text-align:center;">
                  <div class="logo-mark">
                  <?php if($obj_template_data && $obj_template_data->get_email_logo()): ?>
                    <img src="<?php echo esc_attr( $obj_template_data->get_email_logo() ); ?>" width="40" alt="Logo">
                  <?php endif; ?>
                  </div>
                  <h1 class="pub-name" style="font-size:20px;font-weight:700;color:#ffffff;margin:0 0 6px 0;"><?php echo $obj_template_data ? $obj_template_data->get_email_title() : ''; ?></h1>
                  <p class="pub-tagline" style="font-size:12px;color:#666666;margin:0;text-transform:uppercase;"><?php echo $obj_template_data ? $obj_template_data->get_email_tagline() : ''; ?></p>
                </div>

                <!-- BODY -->
                <div class="body" style="padding:40px 52px 48px;">
                  <p style="font-size:15px;line-height:1.85;color:#e2e2e2;margin:0 0 22px 0;"><?php echo wp_kses_post( stripslashes_deep( $obj_template_data ? $obj_template_data->get_email_body() : '' ) ); ?></p>

                </div>

                <!-- FOOTER -->
                <div class="footer" style="padding:24px 52px 0;border-top:1px solid #2a2a2a;text-align:center;">
                  <p style="font-size:11px;color:#666666;margin:0 0 5px 0;line-height:1.7;"><?php echo stripslashes_deep( $obj_template_data ? $obj_template_data->get_email_footer() : '' ); ?></p>
                </div>

              </table>
              <!-- /Container -->
            </td>
          </tr>
        </table>
    </div>
</div>
</body>
</html>
