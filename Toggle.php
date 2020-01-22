<?php

namespace vunamhung\cmb2;

class Toggle {
	public function __construct() {
		add_action('admin_enqueue_scripts', [$this, 'enqueue']);
		add_action('cmb2_render_toggle', [$this, 'callback'], 10, 5);
	}

	public function enqueue() {
		wp_enqueue_style('cmb-toggle', $this->dir_url('css/style.css'), [], '1.0.0');
	}

	public function callback($field, $escaped_value, $object_id, $object_type, \CMB2_Types $field_type_object) {
		$field_name = $field->_name();
		$active_value = !empty($field->args('active_value')) ? $field->args('active_value') : '1';

		$args = [
			'type' => 'checkbox',
			'id' => $field_name,
			'class' => 'input-toggle',
			'name' => $field_name,
			'desc' => '',
			'value' => $active_value,
		];

		if ($escaped_value === $active_value) {
			$args['checked'] = 'checked';
		}

		echo $field_type_object->input($args);
		printf(
			'<label for="%s" class="toggle"><span><svg width="10px" height="10px" ><path d="M5,1 L5,1 C2.790861,1 1,2.790861 1,5 L1,5 C1,7.209139 2.790861,9 5,9 L5,9 C7.209139,9 9,7.209139 9,5 L9,5 C9,2.790861 7.209139,1 5,1 L5,9 L5,1 Z"></path></svg></span></label>',
			$field_name
		);
		$field_type_object->_desc(true, true);
	}

	protected function dir_url($path) {
		return plugin_dir_url(__FILE__) . $path;
	}
}

new Toggle();
