<?php

namespace App\Helpers;

class TrueOrFalseHelper
{
    /**
     * trueOrFalse function
     *
     * @param mixed $value
     * @param boolean|null $defaultValue   Se deixar o valor como `NULL`, será feito cast de `$value`
     *
     * @see /docs/helpers/00-index.md
     *
     * @return bool
     */
    public static function trueOrFalse(
        $value = null,
        ?bool $defaultValue = false,
    ): bool {
        try {
            if (true === filter_var($value, FILTER_VALIDATE_BOOLEAN)) {
                return true;
            }

            return match (trim(strtoupper(json_encode($value)), ' \'\"')) {
                '=VERDADEIRO()', '=TRUE()', 'VERDADEIRO()', 'TRUE()', => true, // excel true values
                '=FALSO()', '=FALSE()', 'FALSO()', 'FALSE()', => false, // excel false values
                'Y', 'YES', 'V', 'VERDADEIRO', 'S', 'SIM', '1', 'T', 'TRUE', => true,
                'N', 'NO', 'F', 'FALSO', '', 'NULL', 'NULO', 'NÃO', 'NAO', '0', 'FALSE', => false,
                default => $defaultValue,
            }
            ?? boolval($value);
        } catch (\Exception $e) {
            return $defaultValue ?? boolval($value);
        }
    }
}
