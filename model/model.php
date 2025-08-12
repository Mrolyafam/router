<?php
class model extends mainDb
{
   private $query;
   private $subQuery;
   protected $type;
   private $limit;
   private $from;
   private $join;
   private $where = [];
   private $on = [];
   public static function all()
   {
      $obj = factory::makeObj(static::class);
      return $obj->select()->get();
   }
   public static function find($id)
   {
      $obj = factory::makeObj(static::class);
      return $obj->where('id', '=', $id)->get();
   }
   public static function delete($id)
   {
      $obj = factory::makeObj(static::class);
      $obj->query = "DELETE ";
      $obj->type = 'delete';
      return $obj->from()->where('id', '=', $id)->get();
   }
   public static function create($data)
   {
      $obj = factory::makeObj(static::class);
      $table = static::$table;
      if ($table == 'product' && !isset($data['exist'])) {
         $data['exist'] = 'NOTEXIST';
      }
      $dataKeys = array_keys($data);
      $obj->query = "INSERT INTO $table (";
      foreach ($dataKeys as $index => $key) {
         if ($index == count($dataKeys) - 1) {
            $obj->query .= $key . ') VALUES (';
         } else {
            $obj->query .= $key . ',';
         }
      }
      $dataValues = array_values($data);
      foreach ($dataValues as $index => $value) {
         if ($index == count($dataValues) - 1) {
            $obj->query .= "'" . $value . "'" . ')';
         } else {
            $obj->query .= "'" . $value . "'" . ',';
         }
      }
      return $obj->get();
   }
   public static function update($data)
   {
      $obj = factory::makeObj(static::class);
      $counter = 0;
      $id = $data['id'];
      unset($data['id']);
      $table = static::$table;
      $obj->type = 'update';
      if ($table == 'product' && !isset($data['exist'])) {
         $data['exist'] = 'NOTEXIST';
      }
      $obj->query = "UPDATE $table SET ";
      foreach ($data as $key => $value) {
         if ($counter == count($data) - 1) {
            $obj->query .= $key . '=' . "'" . $value . "'";
         } else {
            $counter++;
            $obj->query .= $key . '=' . "'" . $value . "'" . ",";
         }
      }
      return $obj->where('id', '=', $id)->get();
   }
   public static function pageInit($limit)
   {
      $obj = factory::makeObj(static::class);
      $route = explode('/', $_SERVER['REQUEST_URI']);
      if ($route[3] == 'page') {
         $offset = ($route[4] - 1) * $limit;
         if (!$obj->type) {
            $obj->select();
         } elseif (!in_array($obj->type, ['select'])) {
            throw new Exception("pageInit can only be added to SELECT");
         }
         return $obj->limit($offset, $limit)->get();
      }
   }
   public static function pageInitSearch($resultArr, $pageNum, $limit)
   {
      // *الگوریتم استاد
      $offset = ($pageNum - 1) * 5;
      for ($i = $offset; $i < $offset + $limit; $i++) {
         if (isset($resultArr[$i])) {
            $newResultArr[] = $resultArr[$i];
         }
      }
      return $newResultArr;
      // --------------------------------------
      // *الگوریتم خودم
      // $count = count($resultArr);
      // for ($i = 0; $i < $count / $limit; $i++) {
      //    $newResultArr[$i + 1] = [];
      //    foreach ($resultArr as $key => $product) {
      //       if (count($newResultArr[$i + 1]) < $limit) {
      //          $newResultArr[$i + 1][] = $product;
      //          unset($resultArr[$key]);
      //       }
      //    }
      // }
      // return $newResultArr[$pageNum];
      // --------------------------------------
      // *الگوریتم خودم با کمک استاد
      // $counter = 0;
      // for ($i = 0; $i < count($resultArr); $i++) {
      //    if ($i % 5 == 0) {
      //       $counter++;
      //    }
      //    $newResultArr[$counter][] = $resultArr[$i];
      // }
      // return $newResultArr[$pageNum];
   }
   public static function customSelect($start, $end)
   {
      $select = static::select();
      if (static::$table == 'product') {
         $select = $select->category(['title']);
      }
      if (static::$table == 'category') {
         $select = $select->withCount(['product']);
      }
      if ($end > $start) {
         $limit = $end - $start;
         $selectLimit = $select->limit($start, $limit);
      }
      if ($start > $end) {
         $limit = $start - $end;
         $selectLimit = $select->limit($end, $limit);
      }
      $result = $selectLimit->get();
      $rows = [];
      while ($row = $result->fetch_assoc()) {
         $rows[] = $row;
      }
      return $rows;
   }
   public static function from()
   {
      $table = static::$table;
      $obj = factory::makeObj(static::class);
      $obj->from = " FROM $table";
      return $obj;
   }
   public static function count()
   {
      $obj = factory::makeObj(static::class);
      $obj->select(['count(*)']);
      return $obj;
   }
   public static function countSubQuery($className, $tables)
   {
      $obj = factory::makeObj(static::class);
      foreach ($tables as $table) {
         $alias = $table . '_count';
         $obj->subQuery .= ", (";
         $obj->subQuery .= $table::count()->where($className . '.' . $obj->related[$className][0], '=', static::class . '.' . $obj->related[$className][1], true)->render();
         $obj->subQuery .= ") $alias";
      }
      return $obj;
   }
   public static function select($fields = ['*'])
   {
      $obj = factory::makeObj(static::class);
      $obj->query = "SELECT ";
      foreach ($fields as $index => $field) {
         if ($index == count($fields) - 1) {
            $obj->query .= $field;
         } else {
            $obj->query .= $field . ',';
         }
      }
      $obj->from();
      $obj->type = 'select';
      return $obj;
   }
   public static function where($field, $operator, $value, $subquery = false)
   {
      $obj = factory::makeObj(static::class);
      if (!$obj->type) {
         $obj->select();
      } elseif (!in_array($obj->type, ['select', 'update', 'delete'])) {
         throw new Exception("WHERE can only be added to SELECT, UPDATE OR DELETE");
      }
      if (is_int($value) ||  $subquery) {
         $obj->where[] = "$field $operator $value ";
      } else {
         $obj->where[] = "$field $operator '$value' ";
      }
      return $obj;
   }
   public function on($field, $operator, $value, $subquery = false)
   {
      $obj = factory::makeObj(static::class);
      if (is_int($value) ||  $subquery) {
         $obj->on[] = "$field $operator $value ";
      } else {
         $obj->on[] = "$field $operator '$value' ";
      }
      return $obj;
   }
   public static function fields()
   {
      $table = static::$table;
      $obj = factory::makeObj(static::class);
      $obj->query = "DESCRIBE $table";
      return $obj->get();
   }
   public static function belongsTo($className, $fields)
   {
      $obj = factory::makeObj(static::class);
      $obj->select([static::class . '.' . '*']);
      foreach ($fields as $field) {
         $obj->query .= ',' . $className . '.' . $field;
         $obj->alias($className . '_' . $field);
      }
      $obj->join('LEFT', $className)->on(static::class . '.' . $obj->related[$className][0], '=', $className . '.' . $obj->related[$className][1], true);
      return $obj;
   }
   public static function with($className)
   {
      $obj = factory::makeObj(static::class);
      $subObj = factory::makeObj($className);
      $obj->select([static::class . '.' . '*']);
      foreach ($subObj->fillable as $field) {
         $obj->query .= ',' . $className . '.' . $field;
         $obj->alias($className . '_' . $field);
      }
      $obj->join('LEFT', $className)->on(static::class . '.' . $obj->related[$className][0], '=', $className . '.' . $obj->related[$className][1], true);
      return $obj;
   }
   public function join($joinType, $table)
   {
      $obj = factory::makeObj(static::class);
      $obj->join = ' ' . $joinType . ' JOIN ' . $table;
      return $obj;
   }
   public function alias($alias)
   {
      $obj = factory::makeObj(static::class);
      $obj->query .= ' ' . $alias;
      return $obj;
   }
   public function limit($offset, $limit)
   {
      if (!in_array($this->type, ['select'])) {
         throw new Exception("LIMIT can only be added to SELECT");
      }
      $this->limit = " LIMIT " . $offset . "," . $limit;
      return $this;
   }
   public function render()
   {
      if ($this->subQuery) {
         $this->query .= $this->subQuery;
         $this->subQuery = '';
      }
      if ($this->from) {
         $this->query .= $this->from;
         $this->from = '';
      }
      if ($this->join) {
         $this->query .= $this->join;
         $this->join = '';
      }
      if (!empty($this->on)) {
         $this->query .= " ON " . implode(' AND ', $this->on);
         $this->on = [];
      }
      if (!empty($this->where)) {
         $this->query .= " WHERE " . implode(' AND ', $this->where);
         $this->where = [];
      }
      if ($this->limit) {
         $this->query .= $this->limit;
         $this->limit = '';
      }
      $query = $this->query;
      $this->type = '';
      $this->query = '';
      var_dump($query);
      echo '<br>';
      return $query;
   }
   public function get()
   {
      self::createConn();
      return self::$connection->query($this->render());
   }
}
