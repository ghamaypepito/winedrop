<?php

/**
 * Rounding.
 *
 * @package WPDesk\FS\TableRate
 */
namespace FSVendor\WPDesk\FS\TableRate\Weight;

/**
 * Can compute rounding precision from Flexible Shipping rules.
 */
class Rounding
{
    /**
     * @var array
     */
    private $shipping_method_rules;
    /**
     * WeightRounding constructor.
     *
     * @param array $shipping_method_rules .
     */
    public function __construct(array $shipping_method_rules)
    {
        $this->shipping_method_rules = $shipping_method_rules;
    }
    /**
     * @return int
     */
    public function get_rounding_from_rules()
    {
        $rounding = 0;
        foreach ($this->shipping_method_rules as $rule) {
            $rounding = \max($rounding, $this->get_rounding_from_rule($rule));
        }
        return $rounding;
    }
    /**
     * @param array $rule .
     *
     * @return int
     */
    private function get_rounding_from_rule(array $rule)
    {
        if ('weight' === $rule['based_on']) {
            return \max($this->get_rounding_from_value(isset($rule['min']) ? $rule['min'] : ''), $this->get_rounding_from_value(isset($rule['max']) ? $rule['max'] : ''));
        }
        return 0;
    }
    /**
     * @param string $value String representation for float.
     *
     * @return int
     */
    private function get_rounding_from_value($value)
    {
        $parts = \explode('.', $value);
        if (isset($parts[1])) {
            return \strlen($parts[1]);
        }
        return 0;
    }
}
