<?php
namespace tpaySDK\Model\Fields;

use InvalidArgumentException;

class Field implements FieldTypes
{
    protected $name = __CLASS__;

    protected $type;

    protected $maxLength;

    protected $minLength;

    protected $minimum;

    protected $maximum;

    protected $value;

    protected $pattern;

    protected $enum;

    /**
     * @var FieldValidator
     */
    protected $FieldValidator;

    private $errors = [];

    public function __construct()
    {
        $this->FieldValidator = new FieldValidator();
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setValue($value)
    {
        $this->checkMaximum($value);
        $this->checkMinimum($value);
        $this->checkMaxLength($value);
        $this->checkMinLength($value);
        if (!is_null($value)) {
            $this->checkValue($value);
        }
        if (!empty($this->errors)) {
            throw new InvalidArgumentException(print_r($this->errors, true));
        }
        $this->value = $value;

        return $this;
    }

    public function checkMaxLength($value)
    {
        if ($this->maxLength > 0 && $this->FieldValidator->isTooLong($this->maxLength, $value)) {
            $this->errors[] = sprintf('Value of field %s is too long. Max allowed %s', $this->name, $this->maxLength);
        }
    }

    public function checkMinLength($value)
    {
        if ($this->minLength > 0 && $this->FieldValidator->isTooShort($this->minLength, $value)) {
            $this->errors[] = sprintf('Value of field %s is too short. Min required %s', $this->name, $this->minLength);
        }
    }

    public function checkMaximum($value)
    {
        if ($this->maximum > 0 && $value > $this->maximum) {
            $this->errors[] = sprintf(
                'Value of field %s exceeds the limit. Max allowed %s',
                $this->name,
                $this->maximum
            );
        }
    }

    public function checkMinimum($value)
    {
        if (is_numeric($this->minimum) && $value < $this->minimum) {
            $this->errors[] = sprintf('Value of field %s is too low. Min required %s', $this->name, $this->minimum);
        }
    }

    public function checkValue($value)
    {
        if (!is_null($this->pattern) && $this->FieldValidator->isValidPattern($value, $this->pattern) === false) {
            $this->errors[] = sprintf(
                'Value of field %s is invalid. Should match %s pattern', $this->name, $this->pattern
            );
        }
        if (!is_null($this->enum) && $this->FieldValidator->isValidEnum($value, $this->enum) === false) {
            $this->errors[] = sprintf(
                'Value of field %s is invalid. Should be one of %s', $this->name, print_r($this->enum, true)
            );
        }
        if ($this->FieldValidator->isValueValidType($this->type, $value) === false) {
            $this->errors[] = sprintf(
                'Value type of field %s is invalid. Should be %s type', $this->name, $this->type
            );
        }
    }

}
