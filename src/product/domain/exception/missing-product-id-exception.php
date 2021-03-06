<?php
namespace Affilicious\Product\Domain\Exception;

use Affilicious\Common\Domain\Exception\Domain_Exception;
use Affilicious\Product\Domain\Model\Product;

if(!defined('ABSPATH')) {
    exit('Not allowed to access pages directly.');
}

class Missing_Product_Id_Exception extends Domain_Exception
{
    /**
     * @since 0.6
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        parent::__construct(sprintf(
            'The product id for "%s" is missing.',
            $product
        ));
    }
}
