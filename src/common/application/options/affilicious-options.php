<?php
namespace Affilicious\Common\Application\Options;

use Carbon_Fields\Container as Carbon_Container;
use Carbon_Fields\Field as Carbon_Field;

class Affilicious_Options
{
	/**
	 * Render the settings into the admin area.
     *
	 * @since 0.7
	 */
	public function render()
	{
		do_action('affilicious_options_affilicious_before_render');

		$scripts_tab = apply_filters('affilicious_options_affilicious_container_scripts_tab', array(
			Carbon_Field::make('header_scripts', 'affilicious_options_affilicious_container_scripts_tab_custom_css_field', __('Custom CSS', 'affilicious')),
			Carbon_Field::make('footer_scripts', 'affilicious_options_affilicious_container_scripts_tab_custom_js_field', __('Custom JS', 'affilicious')),
		));

		$container = Carbon_Container::make('theme_options', 'Affilicious')
	       ->set_icon('dashicons-admin-generic')
	       ->add_tab(__('Scripts', 'affilicious'), $scripts_tab);

		apply_filters('affilicious_options_affilicious_container', $container);
        do_action('affilicious_options_affilicious_after_render');
	}

	/**
	 * Apply the saved settings.
     *
	 * @since 0.7
	 */
	public function apply()
	{
		do_action('affilicious_options_affilicious_before_apply');

        // Nothing to do here yet

		do_action('affilicious_options_affilicious_after_apply');
	}
}
