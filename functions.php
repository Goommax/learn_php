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

/*Функция валидации числового значения в поле формы*/
function val_number($num) {
 if (!empty($num)) {
   $num *= 1;
   if (is_int($num) && $num > 0) {
     return NULL;
   }
   return "Введенное число должно быть целым и больше нуля";
 }
};

/*Функция валидации даты*/
function val_date($date) {
  if (is_date_valid($date)) {
    $cur_date = date_create('now');
    $d = date_create($date);
    $dif = date_diff($d, $cur_date);
    $days = date_interval_format($dif, '%d');
    if ($days < 1) {
      return "Дата должна быть больше текущей, минимум на 1 день";
    }
  } else {
    return "Укажите дату в формате «ГГГГ-ММ-ДД»";
  }
  };

/*Функция валидации категории*/
function val_category($id, $allowed_list) {
  if (!in_array($id, $allowed_list)) {
    return "Выберите категорию из списка";
  }
};
