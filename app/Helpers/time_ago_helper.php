<?php
function time_ago($timestamp) {
    date_default_timezone_set('Asia/Makassar');
    $currentDate = new DateTime();
    $pastDate = new DateTime($timestamp);
    $interval = $pastDate->diff($currentDate);

    if ($interval->y > 0) {
        return $interval->y . " tahun yang lalu";
    } elseif ($interval->m > 0) {
        return $interval->m . " bulan yang lalu";
    } elseif ($interval->d > 0) {
        return $interval->d . " hari yang lalu";
    } elseif ($interval->h > 0) {
        return $interval->h . " jam yang lalu";
    } elseif ($interval->i > 0) {
        return $interval->i . " menit yang lalu";
    } else {
        return "Baru saja";
    }
}