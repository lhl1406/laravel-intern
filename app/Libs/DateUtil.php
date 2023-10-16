<?php

namespace App\Libs;

use App\Libs\{ValueUtil};
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use DatePeriod;

class DateUtil
{
    /**
     * Format date time
     * 
     * @param string $string
     * @param array $format
     * @return string|null
     */
    public static function formatDateTime($string, $format = 'Y/m/d') {
        $creator = Carbon::parse($string);
        if ($creator) {
            return $creator->format($format);
        }
        return null;
    }

    /**
     * Generate  array of Carbon objects of each day between 2 days
     *
     * @param \Carbon\Carbon $from
     * @param \Carbon\Carbon $to
     * @param string|null $format
     * @param string[] $exceptDates format Ymd
     * @param bool $inclusive
     * @return array|null
     */
    public static function dateRange(
        Carbon $from,
        Carbon $to,
        $format = null,
        $exceptDates = [],
        $inclusive = true
    ) {
        if ($from->gt($to)) {
            return null;
        }
        $from = $from->copy()->startOfDay();
        $to = $to->copy()->startOfDay();
        if ($inclusive) {
            $to->addDay();
        }
        $step = CarbonInterval::day();
        $period = new DatePeriod($from, $step, $to);
        $range = [];
        foreach ($period as $day) {
            $day = new Carbon($day);
            if (in_array($day->format('Ymd'), $exceptDates)) {
                continue;
            }
            if (isset($format)) {
                $range[] = $day->format($format);
            } else {
                $range[] = new Carbon($day);
            }
        }

        return !empty($range) ? $range : null;
    }

    /**
     * Get list range year month
     * 
     * @param int $subMonth
     * @param string $format
     * @return array
     */
    public static function getListRangeYearMonth($subMonth, $format = 'Y/m') {
        if (empty($subMonth) && !is_numeric($subMonth)) {
            return [];
        }
        $now = Carbon::now()->format('Y-m-d');
        $dateOfSubmonth = Carbon::now()->subMonthsNoOverflow($subMonth)->format('Y-m-d');
        $dateRange = CarbonPeriod::create($dateOfSubmonth, $now);
        $result = [];
        foreach ($dateRange as $key => $date) {
            $result[$date->format('Ym')] = $date->format($format);
        }
        return $result;
    }

    /**
     * Check valid date
     * 
     * @param string $strDate
     * @return boolean
     */
    public static function isValidDate($strDate) {
        try {
            $date = Carbon::parse($strDate);
            if (!is_null($date) && $date instanceof \DateTime) {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get date of the week
     * 
     * @param object|string $date
     * @return string
     */
    public static function getDateOfWeek($date) {
        $weeks = ValueUtil::get('common.week_jp');
        if (is_string($date)) {
            $date = Carbon::parse($date);
        }
        $w = (int)$date->format('w'); // index of week
        return $weeks[$w];
    }
}
