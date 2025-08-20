<?php
class category extends model
{
   protected $table = "category";
   protected $related = ['product' => ['categoryId', 'id']];
   protected $fillable = ['id', 'title', 'description'];
   protected function withCount($tables)
   {
      return $this->countSubQuery([product::class, $tables]);
   }
}
