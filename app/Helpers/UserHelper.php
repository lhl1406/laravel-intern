<?php

use App\Libs\ValueUtil;
use Carbon\Carbon;

/**
 * Get user flag by position label
 * 
 * @param string $positionLabel
 * @return string
 */
function getUserFlag(string $positionLabel) {
    return ValueUtil::constToValue('user.user_flg.'.$positionLabel);
}

/**
 * Get user flag label by position id
 * 
 * @param string $id
 * @return string
 */
function getUserFlagLabel(string $positionId) {
    return ValueUtil::valueToText($positionId, 'user.user_flg') ?? '';
}

/**
 * Format date time
 * 
 * @param string $string
 * @param array $format
 * @return string|null
 */
function formatDateTime($string, $format = 'd/m/Y') {
    $creator = Carbon::parse($string);
    if ($creator && isset($string)) {
        return $creator->format($format);
    }

    return null;
}