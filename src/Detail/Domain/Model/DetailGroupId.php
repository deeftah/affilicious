<?php
namespace Affilicious\Detail\Domain\Model;

use Affilicious\Common\Domain\Exception\InvalidTypeException;
use Affilicious\Common\Domain\Model\AbstractValueObject;

if (!defined('ABSPATH')) {
    exit('Not allowed to access pages directly.');
}

class DetailGroupId extends AbstractValueObject
{
	/**
	 * @inheritdoc
	 * @since 0.5.2
	 * @throws InvalidTypeException
	 */
	public function __construct($value)
	{
		if (!is_int($value)) {
			throw new InvalidTypeException($value, 'int');
		}

		parent::__construct($value);
	}
}
