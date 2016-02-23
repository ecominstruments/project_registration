<?php
/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015-2016 Sebastian Iffland <Sebastian.Iffland@ecom-ex.com>, ecom instruments GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/


namespace S3b0\ProjectRegistration\ViewHelpers\Form;

/**
 * An own select viewHelper, to bring data-attributes into <option> -tags
 */
class SelectViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Form\SelectViewHelper
{

    /**
     * Initialize arguments.
     *
     * @return void
     * @api
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('optionDataAttributes', 'array', 'Additional data-attributes for options: data-{key}="property:{value}"', false);
    }

    /**
     * Render the option tags.
     *
     * @param array $options the options for the form.
     * @return string rendered tags.
     */
    protected function renderOptionTags($options)
    {
        $output = '';
        if ($this->hasArgument('prependOptionLabel')) {
            $value = $this->hasArgument('prependOptionValue') ? $this->arguments['prependOptionValue'] : '';
            $data['label'] = $this->arguments['prependOptionLabel'];
            $output .= $this->renderOptionTag($value, $data, false) . LF;
        }
        foreach ($options as $value => $label) {
            $isSelected = $this->isSelected($value);
            $output .= $this->renderOptionTag($value, $label, $isSelected) . LF;
        }
        return $output;
    }

    /**
     * Render the option tags.
     *
     * @return array an associative array of options, key will be the value of the option tag
     * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     */
    protected function getOptions()
    {
        $options = [];
        if (!is_array($this->arguments[ 'options' ]) && !$this->arguments[ 'options' ] instanceof \Traversable) {
            return $options;
        }
        $optionsArgument = $this->arguments[ 'options' ];
        foreach ($optionsArgument as $key => $value) {
            $dataAttributes = [];
            if (is_object($value) || is_array($value)) {
                  // Add additional data-attributes for option tags, if any
                if (is_object($value) && is_array($this->arguments[ 'optionDataAttributes' ]) && sizeof($this->arguments[ 'optionDataAttributes' ])) {
                    foreach ($this->arguments[ 'optionDataAttributes' ] as $attribute => $property) {
                        if ($this->persistenceManager->getIdentifierByObject($value) !== null) {
                            $propertyValue = \TYPO3\CMS\Extbase\Reflection\ObjectAccess::getPropertyPath($value, $property);
                            $dataAttributes[] = " data-{$attribute}=\"{$propertyValue}\"";
                        }
                    }
                }

                  // Set option value
                if ($this->hasArgument('optionValueField')) {
                    $key = \TYPO3\CMS\Extbase\Reflection\ObjectAccess::getPropertyPath($value, $this->arguments[ 'optionValueField' ]);
                    if (is_object($key)) {
                        if (method_exists($key, '__toString')) {
                            $key = (string)$key;
                        } else {
                            throw new \TYPO3\CMS\Fluid\Core\ViewHelper\Exception('Identifying value for object of class "' . get_class($value) . '" was an object.', 1247827428);
                        }
                    }
                    // @todo use $this->persistenceManager->isNewObject() once it is implemented
                } elseif ($this->persistenceManager->getIdentifierByObject($value) !== null) {
                    $key = $this->persistenceManager->getIdentifierByObject($value);
                } elseif (method_exists($value, '__toString')) {
                    $key = (string)$value;
                } else {
                    throw new \TYPO3\CMS\Fluid\Core\ViewHelper\Exception('No identifying value for object of class "' . get_class($value) . '" found.', 1247826696);
                }

                  // Transform $value
                if ($this->hasArgument('optionLabelField')) {
                    $value = \TYPO3\CMS\Extbase\Reflection\ObjectAccess::getPropertyPath($value, $this->arguments[ 'optionLabelField' ]);
                    if (is_object($value)) {
                        if (method_exists($value, '__toString')) {
                            $value = (string)$value;
                        } else {
                            throw new \TYPO3\CMS\Fluid\Core\ViewHelper\Exception('Label value for object of class "' . get_class($value) . '" was an object without a __toString() method.', 1247827553);
                        }
                    }
                } elseif (method_exists($value, '__toString')) {
                    $value = (string)$value;
                    // @todo use $this->persistenceManager->isNewObject() once it is implemented
                } elseif ($this->persistenceManager->getIdentifierByObject($value) !== null) {
                    $value = $this->persistenceManager->getIdentifierByObject($value);
                }
            }
            $options[ $key ] = [
                'label'           => $value,
                'data-attributes' => $dataAttributes
            ];
        }
        if ($this->arguments[ 'sortByOptionLabel' ]) {
            usort($options, function($a, $b) {
                return strtolower($a['label']) > strtolower($b['label']);
            });
        }

        return $options;
    }

    /**
     * Render one option tag
     *
     * @param string $value      value attribute of the option tag (will be escaped)
     * @param array  $data       Array(label: content of the option tag (will be escaped), data-attributes)
     * @param bool   $isSelected specifies wheter or not to add selected attribute
     *
     * @return string the rendered option tag
     */
    protected function renderOptionTag($value, $data, $isSelected)
    {
        $output = '<option value="' . htmlspecialchars($value) . '"';
        if ($isSelected) {
            $output .= ' selected="selected"';
        }
        if (is_array($data[ 'data-attributes' ]) && sizeof($data[ 'data-attributes' ])) {
            foreach ($data[ 'data-attributes' ] as $dataAttribute) {
                $output .= $dataAttribute;
            }
        }
        $output .= '>' . htmlspecialchars($data[ 'label' ]) . '</option>';

        return $output;
    }

}
