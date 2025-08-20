<?php
class product extends model
{
   protected $table = "product";
   protected $related = ['category' => ['categoryId', 'id']];
   protected $fillable = ['id', 'title', 'price', 'exist', 'categoryId'];
   protected function category($fields)
   {
      if (!$this->type) {
         $this->select();
      }
      return $this->belongsTo(category::class, $fields, 'LEFT');
   }
   protected function ascendingPrice($rows)
   {
      // *الگوریتم سورت آرایه جدید
      $rows = $rows[0];
      $newRows = [];
      while (count($rows) > 0) {
         $minPrice = $rows[array_keys($rows)[0]]['price'];
         $key = 0;
         foreach ($rows as $rowIndex => $row) {
            if ($row['price'] <= $minPrice) {
               $minPrice = $row['price'];
               $key = $rowIndex;
            }
         }
         $newRows[] = $rows[$key];
         unset($rows[$key]);
      }
      return $newRows;
      // *الگوریتم تعویض جایگاه
      // for ($i = 0; $i < count($rows) - 1; $i++) {
      //    for ($j = 0; $j < count($rows) - 1; $j++) {
      //       if ($rows[$j]['price'] > $rows[$j + 1]['price']) {
      //          $min = $rows[$j];
      //          $rows[$j] = $rows[$j + 1];
      //          $rows[$j + 1] = $min;
      //       }
      //    }
      // }
      // return $rows;
      // -------------------------------------------------------
      // for ($i = 0; $i < count($rows); $i++) {
      //    for ($j = $i; $j < count($rows); $j++) {
      //       if ($rows[$j]['price'] < $rows[$i]['price']) {
      //          $min = $rows[$j];
      //          $rows[$j] = $rows[$i];
      //          $rows[$i] = $min;
      //       }
      //    }
      // }
      // return $rows;
   }
   protected function descendingPrice($rows)
   {
      // *الگوریتم سورت آرایه جدید
      $rows = $rows[0];
      $newRows = [];
      while (count($rows) > 0) {
         $maxPrice = $rows[array_keys($rows)[0]]['price'];
         $key = 0;
         foreach ($rows as $rowIndex => $row) {
            if ($row['price'] >= $maxPrice) {
               $maxPrice = $row['price'];
               $key = $rowIndex;
            }
         }
         $newRows[] = $rows[$key];
         unset($rows[$key]);
      }
      return $newRows;
      // *الگوریتم تعویض جایگاه
      // for ($i = 0; $i < count($rows) - 1; $i++) {
      //    for ($j = 0; $j < count($rows) - 1; $j++) {
      //       if ($rows[$j]['price'] < $rows[$j + 1]['price']) {
      //          $min = $rows[$j];
      //          $rows[$j] = $rows[$j + 1];
      //          $rows[$j + 1] = $min;
      //       }
      //    }
      // }
      // return $rows;
      // -------------------------------------------------------
      // for ($i = 0; $i < count($rows); $i++) {
      //    for ($j = $i; $j < count($rows); $j++) {
      //       if ($rows[$j]['price'] > $rows[$i]['price']) {
      //          $min = $rows[$j];
      //          $rows[$j] = $rows[$i];
      //          $rows[$i] = $min;
      //       }
      //    }
      // }
      // return $rows;
   }
}
