<?php

namespace App\Http\Controllers\Admin\Traits;

use Illuminate\Support\Str;

trait StrTrait
{
    /**
     * Convert a camelCase string to a human-readable format.
     * Capitalize only the first letter by default, or all words if specified.
     *
     * @param string $string
     * @param bool $capitalizeAllWords
     * @return string
     */
    public function strToHumanReadable($string, $capitalizeAllWords = false)
    {
        $snakeCase = Str::replace('_', ' ', Str::snake($string)); // Convert camelCase to snake_case and replace underscores

        return $capitalizeAllWords ? ucwords($snakeCase) : ucfirst($snakeCase); // Use ucwords() or ucfirst() based on the second parameter
    }
}
