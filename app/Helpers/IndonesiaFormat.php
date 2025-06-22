<?php

namespace App\Helpers;

use Carbon\Carbon;

class IndonesiaFormat
{
    /**
     * Format tanggal dalam bahasa Indonesia
     * 
     * @param string|Carbon $date Tanggal yang akan diformat
     * @param bool $withDay Menampilkan nama hari
     * @return string
     */
    public static function date($date, bool $withDay = false): string
    {
        if (!$date) return '';
        
        $date = $date instanceof Carbon ? $date : Carbon::parse($date);
        
        $format = $withDay ? 'l, d F Y' : 'd F Y';
        $formatted = $date->translatedFormat($format);
        
        // Ganti nama bulan dan hari dengan format Indonesia
        $formatted = str_replace(
            [
                'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday',
                'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December',
                'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
            ],
            [
                'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu',
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
                'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
            ],
            $formatted
        );
        
        return $formatted;
    }
    
    /**
     * Format waktu dalam format 24 jam
     * 
     * @param string|Carbon $time Waktu yang akan diformat
     * @param bool $withSeconds Menampilkan detik
     * @return string
     */
    public static function time($time, bool $withSeconds = false): string
    {
        if (!$time) return '';
        
        $time = $time instanceof Carbon ? $time : Carbon::parse($time);
        
        return $time->translatedFormat($withSeconds ? 'H:i:s' : 'H:i');
    }
    
    /**
     * Format tanggal dan waktu lengkap
     * 
     * @param string|Carbon $datetime Tanggal dan waktu yang akan diformat
     * @param bool $withSeconds Menampilkan detik
     * @return string
     */
    public static function datetime($datetime, bool $withSeconds = false): string
    {
        if (!$datetime) return '';
        
        $date = self::date($datetime, true);
        $time = self::time($datetime, $withSeconds);
        
        return "$date pukul $time WIB";
    }
    
    /**
     * Format range tanggal
     * 
     * @param string|Carbon $startDate Tanggal mulai
     * @param string|Carbon|null $endDate Tanggal selesai (opsional)
     * @return string
     */
    public static function dateRange($startDate, $endDate = null): string
    {
        if (!$startDate) return '';
        
        $start = $startDate instanceof Carbon ? $startDate : Carbon::parse($startDate);
        $end = $endDate ? ($endDate instanceof Carbon ? $endDate : Carbon::parse($endDate)) : null;
        
        $startFormatted = self::date($start, true);
        
        if (!$end || $start->isSameDay($end)) {
            return $startFormatted;
        }
        
        // Jika bulan dan tahun sama, cukup tampilkan tanggalnya saja untuk end date
        if ($start->format('m Y') === $end->format('m Y')) {
            return $startFormatted . ' - ' . self::date($end, false);
        }
        
        // Jika tahun sama, cukup tampilkan tanggal dan bulannya saja
        if ($start->format('Y') === $end->format('Y')) {
            return $startFormatted . ' - ' . self::date($end, true);
        }
        
        // Tampilkan format lengkap
        return $startFormatted . ' - ' . self::date($end, true);
    }
    
    /**
     * Format range waktu
     * 
     * @param string|Carbon $startTime Waktu mulai
     * @param string|Carbon $endTime Waktu selesai
     * @return string
     */
    public static function timeRange($startTime, $endTime): string
    {
        if (!$startTime || !$endTime) return '';
        
        $start = $startTime instanceof Carbon ? $startTime : Carbon::parse($startTime);
        $end = $endTime instanceof Carbon ? $endTime : Carbon::parse($endTime);
        
        return self::time($start) . ' - ' . self::time($end) . ' WIB';
    }
}
