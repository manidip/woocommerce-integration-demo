<?php
/**
 * Integration Demo Integration.
 *
 * @package  WC_Integration_Demo_Integration
 * @category Integration
 * @author   WooThemes
 */

if ( ! class_exists( 'WC_Integration_Demo_Integration' ) ) :

class WC_Integration_Demo_Integration extends WC_Integration {

	/**
	 * Init and hook in the integration.
	 */
	public function __construct() {
		global $woocommerce;

		$this->id                 = 'integration-demo';
		$this->method_title       = __( 'Integration Demo', 'woocommerce-integration-demo' );
		$this->method_description = __( 'An integratino demo to show you how easy it is to extend WooCommerce.', 'woocommerce-integration-demo' );

		// Load the settings.
		$this->init_form_fields();
		$this->init_settings();

		// Define user set variables.
		$this->api_key          = $this->get_option( 'api_key' );
		$this->debug            = $this->get_option( 'debug' );

		// Actions.
		add_action( 'woocommerce_update_options_integration_' .  $this->id, array( $this, 'process_admin_options' ) );

	}


	/**
	* Initialize integration settings form fields.
	*
	* @return void
	*/
	public function init_form_fields() {
		$this->form_fields = array(
			'api_key' => array(
				'title'             => __( 'API Key', 'woocommerce-integration-demo' ),
				'type'              => 'text',
				'description'       => __( 'Enter with your API Key. You can find this in "User Profile" drop-down (top right corner) > API Keys.', 'woocommerce-integration-demo' ),
				'desc_tip'          => true,
				'default'           => ''
			),
			'debug' => array(
				'title'             => __( 'Debug Log', 'woocommerce-integration-demo' ),
				'type'              => 'checkbox',
				'label'             => __( 'Enable logging', 'woocommerce-integration-demo' ),
				'default'           => 'no',
				'description'       => __( 'Log events such as API requests', 'woocommerce-integration-demo' ),
			),
			'customize_button' => array(
				'title'             => __( 'Customize!', 'woocommerce-integration-demo' ),
				'type'              => 'button',
				'custom_attributes' => array(
					'onclick' => "location.href='http://www.woothemes.com'",
				),
				'description'       => __( 'Customize your settings by going to the integration site directly.', 'woocommerce-integration-demo' ),
				'desc_tip'          => true,
			)
		);
	}


	/**
	 * Generate Button HTML.
	 */
	public function generate_button_html( $key, $data ) {
		$field    = $this->plugin_id . $this->id . '_' . $key;
		$defaults = array(
			'class'             => 'button-secondary',
			'css'               => '',
			'custom_attributes' => array(),
			'desc_tip'          => false,
			'description'       => '',
			'title'             => '',
		);

		$data = wp_parse_args( $data, $defaults );

		ob_start();
		?>
		<tr valign="top">
			<th scope="row" class="titledesc">
				<label for="<?php echo esc_attr( $field ); ?>"><?php echo wp_kses_post( $data['title'] ); ?></label>
				<?php echo $this->get_tooltip_html( $data ); ?>
			</th>
			<td class="forminp">
				<fieldset>
					<legend class="screen-reader-text"><span><?php echo wp_kses_post( $data['title'] ); ?></span></legend>
					<button class="<?php echo esc_attr( $data['class'] ); ?>" type="button" name="<?php echo esc_attr( $field ); ?>" id="<?php echo esc_attr( $field ); ?>" style="<?php echo esc_attr( $data['css'] ); ?>" <?php echo $this->get_custom_attribute_html( $data ); ?>><?php echo wp_kses_post( $data['title'] ); ?></button>
					<?php echo $this->get_description_html( $data ); ?>
				</fieldset>
			</td>
		</tr>
		<?php
		return ob_get_clean();
	}

}

endif;
