<?php

if ( ! function_exists( 'sue_get_roles' ) ) {
	function sue_get_roles( $remove_roles = [] ) {
		global $wp_roles;

		$all_roles = $wp_roles->roles;
		$rolesArr  = [];
		foreach ( $all_roles as $role_Slug => $role_detail ) {
			$rolesArr[ $role_Slug ] = $role_detail['name'];
		}

		// Remove un-necessary roles
		foreach ( $remove_roles as $remove_role ) {
			unset( $rolesArr[ $remove_role ] );
		}

		ksort( $rolesArr );

		return $rolesArr;
	}
}

if ( ! function_exists( 'sue_get_selected_roles' ) ) {
	function sue_get_selected_roles() {
		$options        = get_option( 'sue_send_users_email' );
		$selected_roles = $options['email_send_roles'] ?? '';

		$selected_roles   = explode( ',', $selected_roles );
		$selected_roles[] = 'administrator';

		return $selected_roles;
	}
}

if ( ! function_exists( 'sue_add_email_capability_to_roles' ) ) {
	function sue_add_email_capability_to_roles( $new_roles ) {
		$all_roles = sue_get_roles( [ 'administrator' ] );
		$new_roles = explode( ',', $new_roles );

		// First remove capability from all roles except administrator
		foreach ( $all_roles as $role_slug => $name ) {
			$role = get_role( $role_slug );
			if ( $role ) {
				$role->remove_cap( SEND_USERS_EMAIL_SEND_MAIL_CAPABILITY );
			}
		}

		// Now add capability to new roles
		foreach ( $new_roles as $new_role ) {
			$role = get_role( $new_role );
			if ( $role ) {
				$role->add_cap( SEND_USERS_EMAIL_SEND_MAIL_CAPABILITY );
			}
		}
	}
}

if ( ! function_exists( 'sue_get_plugin_url' ) ) {
	function sue_get_plugin_url( $file = '' ) {
		return SEND_USERS_EMAIL_PLUGIN_BASE_URL . $file;
	}
}

if ( ! function_exists( 'sue_get_asset_url' ) ) {
	function sue_get_asset_url( $file = '' ) {
		return SEND_USERS_EMAIL_PLUGIN_BASE_URL . '/assets/' . $file;
	}
}

if ( ! function_exists( 'sue_get_asset_url_new' ) ) {
    function sue_get_asset_url_new( $file = '' ) {
        return SEND_USERS_EMAIL_PLUGIN_BASE_URL . '/assets/icons/' . $file;
    }
}

if ( ! function_exists( 'sue_get_date_range_interval' ) ) {
	function sue_get_past_dates_range_interval( $interval_days = 1 ) {

		$dates = [];

		for ( $i = 0; $i < $interval_days; $i ++ ) {
			$endDate = new \DateTime( "-$i days" );
			$dates[] = $endDate->format( 'Y-m-d' );
		}

		return array_reverse( $dates );
	}
}

if ( ! function_exists( 'sue_get_email_theme_scheme' ) ) {
	function sue_get_email_theme_scheme() {

		$email_templates = [
			'default',
			'custom',
			'blue',
			'green',
			'pink',
			'purple',
			'red',
			'yellow',
			'purity',
			'creatorloop',
			'darkmode',
			'modern',
			'dailybrief',
			'plaintext',
			'plainletter',
			'serif',
			'growthmode'
		];

		/**
		 * Add filter for future additional of dropdown theme
		 * @var mixed
		 */
		$email_templates = apply_filters('sue_get_email_theme_scheme_choices', $email_templates);

		return $email_templates;
	}
}

if ( ! function_exists( 'sue_remove_caption_shortcode' ) ) {
	function sue_remove_caption_shortcode( $content ) {

		return preg_replace( '%(\[caption\b[^\]]*\](.*?)(\[\/caption]))%', '$2', $content );
	}
}

if ( ! function_exists( 'sue_log_path' ) ) {
	function sue_log_path( $filename = null ) {
		$dirDetails  = wp_upload_dir();
		$uploads_dir = trailingslashit( $dirDetails['basedir'] );

		// check if directory exists and if not create it
		if ( ! file_exists( $uploads_dir . DIRECTORY_SEPARATOR . 'send-users-email' ) ) {
			mkdir( $uploads_dir . DIRECTORY_SEPARATOR . 'send-users-email', 0755 );
		}

		// Create an index file to prevent directory browsing
		$file = $uploads_dir . DIRECTORY_SEPARATOR . 'send-users-email' . DIRECTORY_SEPARATOR . 'index.php';
		if ( ! file_exists( $file ) ) {
			file_put_contents( $file, '' );
		}

		// Create .htaccess file to prevent direct file access
		$file = $uploads_dir . DIRECTORY_SEPARATOR . 'send-users-email' . DIRECTORY_SEPARATOR . '.htaccess';
		if ( ! file_exists( $file ) ) {
			file_put_contents( $file, 'deny from all' );
		}

		$path = $uploads_dir . DIRECTORY_SEPARATOR . 'send-users-email' . DIRECTORY_SEPARATOR;
		if ( $filename ) {
			$path .= $filename;
		}

		return $path;
	}
}

if ( ! function_exists( 'sue_bytes_to_mb' ) ) {
	function sue_bytes_to_mb( $size = 0 ) {
		return number_format( $size / ( 1024 * 1024 ), 2 );
	}
}

if ( ! function_exists( 'sue_log_wp_mail_failed_error' ) ) {
	function sue_log_wp_mail_failed_error( $message ) {
		$errorLogFileName = sue_get_error_log_filename();
		if ( ! $errorLogFileName ) {
			$errorLogFileName = strtolower( wp_generate_password( 8, false ) . '-error.log' );
			$handle           = fopen( sue_log_path( $errorLogFileName ), 'w' );
			fclose( $handle );
		}
		file_put_contents( sue_log_path( $errorLogFileName ), $message, FILE_APPEND );
	}
}

if ( ! function_exists( 'sue_log_sent_emails' ) ) {
	function sue_log_sent_emails( $user_email, $email_subject, $email_body, $via = 'user' ) {
		$filename = 'email-log-' . date( 'Y-m-d' ) . '.log';
		$file     = sue_log_path( $filename );
		if ( ! file_exists( $file ) ) {
			$handle = fopen( $file, 'w' );
			fclose( $handle );
		}

		$message = '[' . date( 'Y-m-d h:i:s' ) . ']';
		$message .= ' EMAIL SENT';
		$message .= ' | ADDRESS: ' . sue_obscure_text( $user_email, 3 );
		$message .= ' | SUBJECT: ' . trim( preg_replace( '/\s+/', ' ', $email_subject ) );
		$message .= ' | VIA: ' . $via;
		$message .= ' | CONTENT: ' . preg_replace( "/[\r\n]+/", "\n", strip_tags( $email_body ) );

		file_put_contents( $file, $message, FILE_APPEND );
	}
}

if ( ! function_exists( 'sue_remove_non_email_log_filename' ) ) {
	function sue_remove_non_email_log_filename( $fileLists ) {
		// Remove other file names except email log files from array
		foreach ( $fileLists as $key => $fileList ) {
			// remove any other non log email file
			if ( strpos( $fileList, 'email-log' ) !== 0 || substr( $fileList, - 4 ) != '.log' ) {
				unset( $fileLists[ $key ] );
			}
		}

		return $fileLists;
	}
}

if ( ! function_exists( 'sue_get_error_log_filename' ) ) {
	function sue_get_error_log_filename() {
		$logFolderFiles = scandir( sue_log_path() );
		foreach ( $logFolderFiles as $key => $log_folder_file ) {
			if ( strpos( $log_folder_file, '-error.log' ) !== false ) {
				return $log_folder_file;
			}
		}

		return false;
	}
}

if ( ! function_exists( 'sue_obscure_text' ) ) {
	function sue_obscure_text( $string, $frequency = 2 ) {
		$length = strlen( $string );
		for ( $i = 0; $i < $length; $i ++ ) {
			if ( $i != 0 && $i % $frequency == 0 ) {
				$string = substr_replace( $string, '*', $i, 1 );
			}
		}

		return $string;
	}
}

/**
 * Get the plugin text domain.
 *
 * @return string The text domain for the plugin.
 */
if ( ! function_exists( 'sue_get_plugin_text_domain' ) ) {
	function sue_get_plugin_text_domain() {
		return 'send-users-email';
	}
}

/**
 * Check if the plugin is premium and can use premium code.
 * This function checks if the plugin is premium and if the user has the capability to use premium code.
 * It returns true if both conditions are met, otherwise false.
 * @return bool
 */
if ( ! function_exists( 'sue_is_premium_and_can_use_premium_code' ) ) {
	function sue_is_premium_and_can_use_premium_code(): bool {
		if ( sue_fs()->is__premium_only() 
			&& sue_fs()->can_use_premium_code() 
		) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'sue_is_woocommerce_active' ) ) {
	function sue_is_woocommerce_active(): bool {
		$active_plugins = get_option( 'active_plugins' );

		if ( ! is_array( $active_plugins ) ) {
			$active_plugins = [];
		}

		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', $active_plugins ) )
			|| ( is_multisite() && in_array( 'woocommerce/woocommerce.php', get_site_option( 'active_sitewide_plugins', array() ) ) )
		) {
			return true;
		}

		return false;
	}
}
/*
 * Check if the user is subscribed to email notifications.
 *
 * @param int|null $user_id The user ID to check. If null, checks the current user.
 * @return bool True if the user is subscribed, false otherwise.
 */
if ( ! function_exists( 'sue_is_user_email_subscribed' ) ) {
	function sue_is_user_email_subscribed($user_id = null) {
		if ( ! $user_id ) {
			$user_id = get_current_user_id();
		}

		if ( ! $user_id ) {
			return false; // No user ID provided
		}

		return SUE_Email_Subscription_User_Meta::is_email_subscribed( $user_id );
	}
}

/**
 * Render admin template file with optional arguments.
 *
 * @param string $template_path The path to the template file relative to the admin/partials/ directory.
 * @param array  $args          Optional. An associative array of arguments to extract for use in the template.
 * @param bool   $load_once     Optional. Whether to include the template file only once. Default is true.
 */
if ( ! function_exists( 'sue_render_admin_template' ) ) {
	function sue_render_admin_template($template_path, $args = [], $load_once = true) {
		$template_file = plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/' . $template_path;
		
		if ( file_exists( $template_file ) ) {
			
			if (!empty($args) && is_array($args)) {
				extract($args, EXTR_SKIP);
			}

			if ( $load_once ) {
				include_once $template_file;
			} else {
				include $template_file;
			}
		}
	}
}

/**
 * Include a template file from the admin/partials/ directory with optional arguments.
 *
 * @param string $template_path The path to the template file relative to the admin/partials/ directory.
 * @param array  $args          Optional. An associative array of arguments to extract for use in the template.
 * @param bool   $load_once     Optional. Whether to include the template file only once. Default is true.
 */
if ( ! function_exists( 'sue_include_template') ) {
	function sue_include_template($template_path, $args = [], $load_once = true) {

		$template = sue_get_plugin_dir() . 'admin/partials/' . $template_path;
		
		if ( ! file_exists( $template ) ) {
			return;
		}

		if ( ! empty( $args ) && is_array( $args ) ) {
			extract( $args );
		}

		if ( $load_once ) {
			include_once $template;
		} else {
			include $template;
		}
	}
}

/**
 * Render the email theme selection dropdown.
 *
 * @param string|null $default_email_theme The default selected email theme. If null, retrieves from options.
 */
if ( ! function_exists( 'sue_render_email_theme_to_use') ) {
	function sue_render_email_theme_to_use($default_email_theme = null) {
		if( $default_email_theme === null ) {
			$options              = get_option( 'sue_send_users_email' );
			$default_email_theme  = $options['default_email_theme'] ?? 'default';
		}

		sue_include_template( 'templates/select-theme.php', [ 'default_email_theme' => $default_email_theme ] );
	}
}

if ( ! function_exists( 'sue_db_prepare' ) ) {
	/**
	 * Wraps $wpdb->prepare and adds support for passing arrays as parameters
	 * (useful for IN() clauses). When an array is provided as a parameter,
	 * the first %s placeholder will be expanded into the correct number of
	 * %s placeholders and the array values will be flattened into the
	 * prepared arguments.
	 *
	 * Example:
	 * $sql = "SELECT * FROM {$table} WHERE id IN (%s) AND status = %s";
	 * $prepared = sue_db_prepare( $sql, [ [1,2,3], 'active' ] );
	 *
	 * @param string $query  SQL query with placeholders
	 * @param mixed  $params Single value or array of values/arrays
	 * @return string Prepared SQL string
	 */
	function sue_db_prepare( $query, $params = [] ) {
		global $wpdb;

		if ( ! is_array( $params ) ) {
			$params = [ $params ];
		}

		$flattened = [];
		foreach ( $params as $p ) {
			if ( is_array( $p ) ) {
				$count = count( $p );
				if ( $count === 0 ) {
					// Empty array -> use a dummy value that will never match
					$query = preg_replace( '/%s/', "('')", $query, 1 );
					continue;
				}

				$placeholders = implode( ',', array_fill( 0, $count, '%s' ) );
				$query = preg_replace( '/%s/', $placeholders, $query, 1 );
				foreach ( $p as $v ) {
					$flattened[] = $v;
				}
			} else {
				$flattened[] = $p;
			}
		}

		if ( empty( $flattened ) ) {
			return $query;
		}

		// Call prepare with varargs to be compatible with different WP versions
		$args = array_merge( [ $query ], $flattened );
		return call_user_func_array( [ $wpdb, 'prepare' ], $args );
	}
}

if ( ! function_exists('sue_make_haystack') ) 
{
	/**
	 * Convert a string or an array of strings into a single haystack string for searching.
	 * If the input is an array, it will be flattened and concatenated into a single string.
	 *
	 * @param string|array $input The input string or array of strings to convert.
	 * @return string A single haystack string containing all input values.
	 */
	function sue_make_haystack($input) {
		$fields = [
			$input->email ?? '',
			$input->first_name ?? '',
			$input->last_name ?? '',
			$input->title ?? '',
			$input->salutation ?? '',
			$input->field_01 ?? '',
			$input->field_02 ?? '',
			$input->field_03 ?? '',
			$input->field_04 ?? '',
			$input->field_05 ?? '',
		];
		
		// Minimal normalization: lowercase + trim
		// (If you want diacritics stripped server-side and have intl/Transliterator:
		// $trans = Transliterator::create('NFD; [:Nonspacing Mark:] Remove; NFC; Any-Latin; Latin-ASCII');
		// $text = $trans ? $trans->transliterate($text) : $text;
		$text = strtolower( trim( implode(' ', $fields) ) );

		return $text;
	}
}

if ( ! function_exists('sue_iframe_template_preview_url') ) 
{
	/**
	 * Check if a haystack string contains a needle string, ignoring case and whitespace.
	 *
	 * @param string $haystack The haystack string to search within.
	 * @param string $needle The needle string to search for.
	 * @return bool True if the haystack contains the needle, false otherwise.
	 */
	function sue_iframe_template_preview_url($args = []) {
		// Define a unique action
		$action = 'template_preview_iframe_action';
		// Create the nonce
		$nonce = wp_create_nonce($action);
		// Append nonce to the iframe source URL
		$style = $args['style'] ?? 'default';
		$iframe_url = add_query_arg(
			[
				'wp_nonce' => $nonce,
				'action'   => $action,
				'style'    => $style,
				'path'     => ABSPATH,
			],
			esc_attr( sue_get_plugin_url() ) . '/admin/template-preview.php'
		);

		return $iframe_url;
	}
}