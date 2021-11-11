<?php

/**
 * Spiral Framework. PHP Data Grid
 *
 * @license MIT
 * @author  Anton Tsitou (Wolfy-J)
 * @author  Valentin Vintsukevich (vvval)
 */

declare(strict_types=1);

namespace Spiral\DataGrid\Specification\Value;

use Spiral\DataGrid\Specification\ValueInterface;

final class IntersectValue implements ValueInterface
{
    /** @var ValueInterface */
    private $enum;

    /**
     * @param mixed          ...$values
     */
    public function __construct(ValueInterface $enum, ...$values)
    {
        $this->enum = new EnumValue($enum, ...$values);
    }

    /**
     * @inheritDoc
     */
    public function accepts($values): bool
    {
        $values = (array)$values;

        if (count($values) === 1) {
            return $this->enum->accepts(array_values($values)[0]);
        }

        foreach ($values as $value) {
            if ($this->enum->accepts($value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function convert($values): array
    {
        $result = [];
        foreach ((array)$values as $value) {
            if ($this->enum->accepts($value)) {
                $result[] = $this->enum->convert($value);
            }
        }

        return $result;
    }
}
