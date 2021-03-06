<?php
namespace Affilicious\Product\Domain\Model\Complex;

use Affilicious\Common\Domain\Model\Factory_Interface;
use Affilicious\Common\Domain\Model\Key;
use Affilicious\Common\Domain\Model\Name;
use Affilicious\Common\Domain\Model\Title;

if(!defined('ABSPATH')) {
    exit('Not allowed to access pages directly.');
}

interface Complex_Product_Factory_Interface extends Factory_Interface
{
    /**
     * Create a new complex product which can be stored into the database.
     *
     * @since 0.7
     * @param Title $title
     * @param Name $name
     * @param Key $key
     * @return Complex_Product_Interface
     */
    public function create(Title $title, Name $name, Key $key);
}
