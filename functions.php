<?php
/**
*Функция формата цены, которую я перенес из ранее сделанного задания в надежде
*на то что она будет ровног вызываться из этого файла после шаблонизации проекта
*/
function form_price($f_price) {
  $f_price = ceil($f_price);
  if ($f_price>=1000) {
    $f_price = number_format($f_price, 0, '', ' ');
  }
  return $f_price .' ' . '&#x20bd';
}
/**
*Функция счетчика времени до истечения действия лота
*/
function time_left($lotdate)
{
    date_default_timezone_set('Europe/Moscow');
    $final_date = date_create($lotdate);
    $cur_date = date_create("now");
    $diff = date_diff($final_date, $cur_date);
    $format_diff = date_interval_format($diff, "%d %H %I");
    $arr = explode(" ", $format_diff);

    $hours = $arr[0] * 24 + $arr[1];
    $minutes = intval($arr[2]);
    $hours = str_pad($hours, 2, "0", STR_PAD_LEFT);
    $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);
    $res[] = $hours;
    $res[] = $minutes;

    return $res;
}
