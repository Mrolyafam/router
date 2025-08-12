<?php
class category extends model
{
   protected static $table = "category";
   protected $related = ['product' => ['categoryId', 'id']];
   protected $fillable = ['id', 'title', 'description'];
   public static function withCount($tables)
   {
      return self::countSubQuery(product::class, $tables);
   }
}
