<?php

use Carbon\Carbon;
use App\Helpers\IndonesiaFormat;

if (!function_exists('indonesia_date')) {
    /**
     * Format tanggal dalam bahasa Indonesia
     * 
     * @param string|Carbon $date Tanggal yang akan diformat
     * @param bool $withDay Menampilkan nama hari
     * @return string
     */
    function indonesia_date($date, bool $withDay = false): string
    {
        return app('indonesia-format')->date($date, $withDay);
    }
}

if (!function_exists('indonesia_time')) {
    /**
     * Format waktu dalam format 24 jam
     * 
     * @param string|Carbon $time Waktu yang akan diformat
     * @param bool $withSeconds Menampilkan detik
     * @return string
     */
    function indonesia_time($time, bool $withSeconds = false): string
    {
        return app('indonesia-format')->time($time, $withSeconds);
    }
}

if (!function_exists('indonesia_datetime')) {
    /**
     * Format tanggal dan waktu lengkap
     * 
     * @param string|Carbon $datetime Tanggal dan waktu yang akan diformat
     * @param bool $withSeconds Menampilkan detik
     * @return string
     */
    function indonesia_datetime($datetime, bool $withSeconds = false): string
    {
        return app('indonesia-format')->datetime($datetime, $withSeconds);
    }
}

if (!function_exists('indonesia_date_range')) {
    /**
     * Format range tanggal
     * 
     * @param string|Carbon $startDate Tanggal mulai
     * @param string|Carbon|null $endDate Tanggal selesai (opsional)
     * @return string
     */
    function indonesia_date_range($startDate, $endDate = null): string
    {
        return app('indonesia-format')->dateRange($startDate, $endDate);
    }
}

if (!function_exists('indonesia_time_range')) {
    /**
     * Format range waktu
     * 
     * @param string|Carbon $startTime Waktu mulai
     * @param string|Carbon $endTime Waktu selesai
     * @return string
     */
    function indonesia_time_range($startTime, $endTime): string
    {
        return app('indonesia-format')->timeRange($startTime, $endTime);
    }
}
