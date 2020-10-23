<?php
/**
 * New rules settings table.
 *
 * @package WPDesk\FS\TableRate
 */

namespace WPDesk\FS\TableRate;

use FSVendor\WPDesk\Forms\Field;
use FSVendor\WPDesk\View\Renderer\SimplePhpRenderer;
use FSVendor\WPDesk\View\Resolver\DirResolver;

/**
 * Can display new rules settings table.
 */
class RulesSettingsField {

	/**
	 * @var string
	 */
	private $settings_field_id;

	/**
	 * @var string
	 */
	private $field_key;

	/**
	 * @var string
	 */
	private $settings_field_name;

	/**
	 * @var array
	 */
	private $data;

	/**
	 * RulesSettings constructor.
	 *
	 * @param string $settings_field_id .
	 * @param string $field_key .
	 * @param string $settings_field_name .
	 * @param array  $data Rules for shipping method.
	 */
	public function __construct( $settings_field_id, $field_key, $settings_field_name, $data ) {
		$this->settings_field_id   = $settings_field_id;
		$this->field_key           = $field_key;
		$this->settings_field_name = $settings_field_name;
		$this->data                = $data;
	}

	/**
	 * Render settings.
	 *
	 * @return string
	 */
	public function render() {
		$renderer = new SimplePhpRenderer( new DirResolver( __DIR__ . '/views' ) );
		$template_args = array(
			'field_key' => $this->field_key,
			'data'      => $this->data,
		);
		return $renderer->render( 'shipping-method-settings-rules', $template_args );
	}

}
