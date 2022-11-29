<?php
function goods_list_query() {
return "SELECT l.id, l.title, l.img, l.start_price, l.date_finish, c.name_category
  FROM lots l JOIN categories c ON l.category_id = c.id ORDER BY date_creation DESC;";
}

function cat_query() {
return "SELECT character_code, name_category FROM categories;";}

function lot_query($lot_id) {
return "SELECT l.id, l.title, l.start_price, l.img, l.lot_description, l.date_finish, c.name_category FROM lots l
JOIN categories c ON l.category_id = c.id WHERE l.id = $lot_id;";}

function lot_add_query($user_id) {
  return "INSERT INTO lots (title, category_id, lot_description, start_price, step, date_finish, img, user_id)
  VALUES (?, ?, ?, ?, ?, ?, ?, $user_id);";}
