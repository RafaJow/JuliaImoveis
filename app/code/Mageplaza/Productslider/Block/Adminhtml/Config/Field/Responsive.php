<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_Productslider
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\Productslider\Block\Adminhtml\Config\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

/**
 * Class Responsive
 * @package Mageplaza\Productslider\Block\Adminhtml\Config\Field
 */
class Responsive extends AbstractFieldArray
{
    /**
     * @inheritdoc
     */
    protected function _prepareToRender()
    {
        $this->addColumn('size', ['label' => __('Screen size max'), 'renderer' => false, 'class' => 'required-entry validate-number validate-greater-than-zero']);
        $this->addColumn('items', ['label' => __('Number of items'), 'renderer' => false, 'class' => 'required-entry validate-number validate-greater-than-zero']);

        $this->_addAfter       = false;
        $this->_addButtonLabel = __('Add');
    }
}
