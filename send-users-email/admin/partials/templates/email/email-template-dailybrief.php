<?php
$obj_template_data = $args['obj_template_data'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php bloginfo( 'name' ); ?></title>
  <?php if ( $obj_template_data && $obj_template_data->get_email_styles() ): ?>
      <style>
          <?php echo stripslashes_deep( wp_strip_all_tags( $obj_template_data->get_email_styles() ) ); ?>
      </style>
  <?php endif; ?>
</head>
<body style="margin:0;padding:0;background-color:#f2ede6;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Helvetica,Arial,sans-serif;color:#1a1a1a;">
<style>
  /* Content class styles – placed in body for email client compatibility */
  .block p { font-size:15px; line-height:1.75; color:#333333; margin:0 0 16px 0; }
  .block p:last-child { margin-bottom:0; }
  .block a { color:#1a1a1a; text-decoration:underline; }
  .block ul, .block ol { font-size:15px; line-height:1.75; color:#333333; margin:0 0 16px 0; padding-left:22px; }
  .block li { margin-bottom:8px; }
  .section-header { margin-bottom:18px; }
  .section-emoji { display:inline-block; vertical-align:middle; font-size:15px; line-height:1; margin-right:6px; }
  .section-title { display:inline-block; vertical-align:middle; font-size:13px; font-weight:800; letter-spacing:0.1em; text-transform:uppercase; color:#1a1a1a; margin:0; }
  .section-line { border-top:1px solid #e0e0e0; margin:4px 0; }
  .callout { background-color:#fffbee; border-left:3px solid #f2c94c; border-radius:0 4px 4px 0; padding:14px 18px; margin:0 0 16px 0; }
  .callout p { font-size:14px; color:#555555; margin:0; }
  .story-item { padding:14px 0; border-bottom:1px solid #f5f5f5; }
  .story-item:last-child { border-bottom:none; padding-bottom:0; }
  .story-item p { margin:0; }
  .story-label { font-size:10px; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; color:#aaaaaa; margin:0 0 4px 0; }
  hr.divider { border:none; border-top:2px solid #f2c94c; margin:24px 0; }
</style>
<div style="width:100%;background-color:#f2ede6;padding:36px 0 56px;">
  <div style="max-width:580px;margin:0 auto;">

    <!-- HEADER -->
    <div style="background-color:#1a1a1a;border-radius:8px 8px 0 0;padding:32px 48px 28px;text-align:center;">
      <div style="display:inline-block;width:44px;height:44px;background-color:#f2c94c;border-radius:50%;margin-bottom:16px;">
        <?php if($obj_template_data && $obj_template_data->get_email_logo()): ?>
          <img src="<?php echo esc_attr( $obj_template_data->get_email_logo() ); ?>" width="44" alt="Logo" style="display:block;border-radius:50%;">
        <?php endif; ?>
      </div>
      <h1 style="font-size:22px;font-weight:800;color:#ffffff;margin:0 0 6px 0;letter-spacing:-0.02em;"><?php echo $obj_template_data ? $obj_template_data->get_email_title() : ''; ?></h1>
      <p style="font-size:12px;color:#888888;margin:0;letter-spacing:0.04em;"><?php echo $obj_template_data ? $obj_template_data->get_email_tagline() : ''; ?></p>
    </div>

    <!-- YELLOW INTRO STRIP -->
    <div style="background-color:#f2c94c;padding:14px 48px;text-align:center;">
      <!-- <p style="font-size:13px;font-weight:600;color:#1a1a1a;margin:0;line-height:1.5;">Good morning. Here's everything you need to know today — in 5 minutes or less. ☕</p> -->
    </div>

    <!-- INTRO BLOCK -->
    <div class="block" style="background-color:#ffffff;padding:30px 48px;border-radius:0 0 8px 8px;">
      <p><?php echo wp_kses_post( stripslashes_deep( $obj_template_data ? $obj_template_data->get_email_body() : '' ) ); ?></p>
    </div>

    <!-- FOOTER -->
    <div style="text-align:center;padding:24px 24px 0;">
      <p style="font-size:11px;color:#999999;margin:0 0 4px 0;line-height:1.7;"><?php echo stripslashes_deep( $obj_template_data ? $obj_template_data->get_email_footer() : '' ); ?></p>
    </div>

  </div>
</div>
</body>
</html>
