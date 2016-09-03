<?php
namespace Affilicious\Settings\Application\Setting;

use Affilicious\Product\Domain\Model\Product;
use Carbon_Fields\Container as CarbonContainer;
use Carbon_Fields\Field as CarbonField;

class ProductSettings implements SettingsInterface
{
	const LINK_WHAT_IS_TAXONOMY = 'http://codex.wordpress.org/Taxonomies';
	const LINK_RESERVED_TERMS = 'http://codex.wordpress.org/Function_Reference/register_taxonomy#Reserved_Terms';

	/**
	 * @inheritdoc
	 * @since 0.5
	 */
	public function render()
	{
		CarbonContainer::make('theme_options', __('Product', 'affilicious'))
           ->set_page_parent('Affilicious')
			->add_tab(__('General', 'affilicious'), array(
				CarbonField::make('text', 'affilicious_settings_product_general_slug', __('Slug', 'affilicious'))
		           ->help_text(__('Used as pretty permalink text (i.e. /slug/). Default is "product". To apply this change, please press the save button under Settings > Permalinks.', 'affilicious')),
			))
           ->add_tab(__('Taxonomies', 'affilicious'), array(
	           CarbonField::make('html', 'affilicious_settings_product_taxonomies_description')
	                ->set_html(sprintf('<p>%s</p>', sprintf(__('Create custom taxonomies to group products together. See this <a href="%s">link</a> for a better description.', 'affilicious'), self::LINK_WHAT_IS_TAXONOMY))),
               CarbonField::make('complex', 'affilicious_settings_product_taxonomies', __('Taxonomies', 'affilicious'))
                  ->add_fields(array(
	                  CarbonField::make('text', 'taxonomy', __('Taxonomy', 'affilicious'))
		                  ->help_text(sprintf(
		                  	__('The name of the taxonomy. Name should only contain lowercase letters and the underscore character, and not be more than 32 characters long. Care should be used in selecting a taxonomy name so that it does not conflict with other taxonomies, post types, and reserved WordPress public and private query variables. A complete list of those is described in the <a href="%s">Reserved Terms</a> section.', 'affilicious'), self::LINK_RESERVED_TERMS))
		                  ->set_required(true),
	                  CarbonField::make('text', 'slug', __('Slug', 'affilicious'))
		                  ->help_text(__('Used as pretty permalink text (i.e. /slug/). To apply this change, please press the save button under Settings > Permalinks.', 'affilicious'))
		                  ->set_required(true),
                      CarbonField::make('text', 'singular_name', __('Singular Name', 'affilicious'))
	                      ->set_required(true),
                      CarbonField::make('text', 'plural_name', __('Plural Name', 'affilicious'))
	                      ->set_required(true),
                  ))
           ));
	}

	/**
	 * @inheritdoc
	 * @since 0.5
	 */
	public function apply()
	{
		$taxonomies = carbon_get_theme_option('affilicious_settings_product_taxonomies', 'complex');
		if(!empty($taxonomies)) {
			foreach ($taxonomies as $taxonomy) {
				$labels = $this->getLabels($taxonomy);

				if(!empty($labels)) {
					register_taxonomy($taxonomy['taxonomy'], Product::POST_TYPE, array(
						'hierarchical'      => true,
						'labels'            => $labels,
						'show_ui'           => true,
						'show_admin_column' => true,
						'show_in_nav_menus' => true,
						'query_var'         => true,
						'rewrite'           => array('slug' => $taxonomy['slug']),
						'public'            => true,
					));
				}
			}
		}
	}

	/**
	 * @param array $taxonomy
	 * @since 0.5
	 * @return array|null
	 */
	private function getLabels($taxonomy)
	{
		if(empty($taxonomy['singular_name']) || empty($taxonomy['plural_name'])) {
			return null;
		}

		return array(
			'name'              => sprintf(__('%s', 'affilicious'), $taxonomy['plural_name']),
			'singular_name'     => sprintf(__('%s', 'affilicious'), $taxonomy['singular_name']),
			'search_items'      => sprintf(__('Search %s', 'affilicious'), $taxonomy['plural_name']),
			'all_items'         => sprintf(__('All %s', 'affilicious'), $taxonomy['plural_name']),
			'parent_item'       => sprintf(__('Parent %s', 'affilicious'), $taxonomy['singular_name']),
			'parent_item_colon' => sprintf(__('Parent %s:', 'affilicious'), $taxonomy['singular_name']),
			'edit_item'         => sprintf(__('Edit %s', 'affilicious'), $taxonomy['singular_name']),
			'update_item'       => sprintf(__('Update %s', 'affilicious'), $taxonomy['singular_name']),
			'add_new_item'      => sprintf(__('Add New %s', 'affilicious'), $taxonomy['singular_name']),
			'new_item_name'     => sprintf(__('New %s', 'affilicious'), $taxonomy['singular_name']),
			'menu_name'         => sprintf(__('%s', 'affilicious'), $taxonomy['plural_name']),
		);
	}
}