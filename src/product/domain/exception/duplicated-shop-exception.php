<?php
namespace Affilicious\Product\Domain\Exception;

use Affilicious\Common\Domain\Exception\Domain_Exception;
use Affilicious\Product\Domain\Model\Product;
use Affilicious\Shop\Domain\Model\Shop;

if(!defined('ABSPATH')) {
    exit('Not allowed to access pages directly.');
}

class Duplicated_Shop_Exception extends Domain_Exception
{
    /**
     * @since 0.6
     * @param Shop $shop
     * @param Product $product
     */
    public function __construct(Shop $shop, Product $product)
    {
        parent::__construct(sprintf(
            'The shop #%s (%s) does already exist in the product #%s (%s)',
            $shop->get_template_id()->get_value(),
            $shop->get_title()->get_value(),
            $product->get_id()->get_value(),
            $product->get_title()->get_value()
        ));
    }
}
