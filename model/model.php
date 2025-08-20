<?php
class model extends modelFacade
{
   protected $table;
   protected $type;
   private $query;
   private $subQuery;
   private $limit;
   private $from;
   private $join;
   private $group;
   private $having;
   private $coalesce;
   private $where = [];
   private $on = [];
   protected function all()
   {
      return $this->select()->get();
   }
   protected function find($id)
   {
      return $this->where(['id', '=', $id[0]])->get();
   }
   protected function delete($id)
   {
      $this->query = "DELETE ";
      $this->type = 'delete';
      return $this->from()->where(['id', '=', $id[0]])->get();
   }
   protected function create($data)
   {
      $data = $data[0];
      $table = $this->table;
      if ($table == 'product' && !isset($data['exist'])) {
         $data['exist'] = 'NOTEXIST';
      }
      $dataKeys = array_keys($data);
      $this->query = "INSERT INTO $table (";
      foreach ($dataKeys as $index => $key) {
         if ($index == count($dataKeys) - 1) {
            $this->query .= $key . ') VALUES (';
         } else {
            $this->query .= $key . ',';
         }
      }
      $dataValues = array_values($data);
      foreach ($dataValues as $index => $value) {
         if ($index == count($dataValues) - 1) {
            $this->query .= "'" . $value . "'" . ')';
         } else {
            $this->query .= "'" . $value . "'" . ',';
         }
      }
      return $this->get();
   }
   protected function update($data)
   {
      $data = $data[0];
      $counter = 0;
      $id = $data['id'];
      unset($data['id']);
      $table = $this->table;
      $this->type = 'update';
      if ($table == 'product' && !isset($data['exist'])) {
         $data['exist'] = 'NOTEXIST';
      }
      $this->query = "UPDATE $table SET ";
      foreach ($data as $key => $value) {
         if ($counter == count($data) - 1) {
            $this->query .= $key . '=' . "'" . $value . "'";
         } else {
            $counter++;
            $this->query .= $key . '=' . "'" . $value . "'" . ",";
         }
      }
      return $this->where(['id', '=', $id])->get();
   }
   protected function pageInit($limit)
   {
      $limit = $limit[0];
      $route = explode('/', $_SERVER['REQUEST_URI']);
      if ($route[3] == 'page') {
         $offset = ($route[4] - 1) * $limit;
         if (!$this->type) {
            $this->select();
         } elseif (!in_array($this->type, ['select'])) {
            throw new Exception("pageInit can only be added to SELECT");
         }
         return $this->limit($offset, $limit)->get();
      }
   }
   protected function pageInitSearch($args)
   {
      $resultArr = $args[0];
      $pageNum = $args[1];
      $limit = $args[2];
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
   protected function customSelect($args)
   {
      $start = $args[0];
      $end = $args[1];
      $select = $this->select();
      if ($this->table == 'product') {
         $select = $select->category(['title']);
      }
      if ($this->table == 'category') {
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
   protected function from()
   {
      $table = $this->table;
      $this->from = " FROM $table";
      return $this;
   }
   protected function count()
   {
      $this->select(['count(*)']);
      return $this;
   }
   protected function countSubQuery($args)
   {
      if (!$this->type) {
         $this->select([static::class . '.*']);
      }
      $className = $args[0];
      $tables = $args[1];
      foreach ($tables as $table) {
         $subObj = factory::makeObj($table);
         $alias = $table . '_count';
         $this->subQuery .= ", (";
         $this->subQuery .= $subObj->count()->where([$className . '.' . $this->related[$className][0], '=', static::class . '.' . $this->related[$className][1], true])->render();
         $this->subQuery .= ") $alias";
      }
      return $this;
   }
   protected function select($fields = ['*'])
   {
      if (empty($fields)) {
         $fields[] = '*';
      }
      $this->query = "SELECT ";
      foreach ($fields as $index => $field) {
         if ($index == count($fields) - 1) {
            $this->query .= $field;
         } else {
            $this->query .= $field . ',';
         }
      }
      $this->from();
      $this->type = 'select';
      return $this;
   }
   protected function where($args)
   {
      $field = $args[0];
      $operator = $args[1];
      $value = $args[2];
      $flag = isset($args[3]) ? $args[3] : false;
      if (!$this->type) {
         $this->select([static::class . '.*']);
      } elseif (!in_array($this->type, ['select', 'update', 'delete'])) {
         throw new Exception("WHERE can only be added to SELECT, UPDATE OR DELETE");
      }
      if (is_int($value) ||  $flag) {
         $this->where[] = "$field $operator $value ";
      } else {
         $this->where[] = "$field $operator '$value' ";
      }
      return $this;
   }
   protected function on($args)
   {
      $field = $args[0];
      $operator = $args[1];
      $value = $args[2];
      $flag = isset($args[3]) ? $args[3] : false;
      if (!$this->type) {
         $this->select();
      }
      if (is_int($value) ||  $flag) {
         $this->on[] = "$field $operator $value ";
      } else {
         $this->on[] = "$field $operator '$value' ";
      }
      return $this;
   }
   protected function fields()
   {
      $table = $this->table;
      $this->query = "DESCRIBE $table";
      return $this->get();
   }
   protected function belongsTo($className, $fields, $joinType)
   {
      if (!$this->type) {
         $this->select([static::class . '.' . '*']);
      }
      foreach ($fields as $field) {
         $this->query .= ',' . $className . '.' . $field;
         $this->alias([$className . '_' . $field]);
      }
      $this->join([$className, $joinType])->on([static::class . '.' . $this->related[$className][0], '=', $className . '.' . $this->related[$className][1], true]);
      return $this;
   }
   protected function with($args)
   {
      $className = $args[0];
      $joinType = isset($args[1]) ? $args[1] : 'LEFT';
      $subObj = factory::makeObj($className);
      $this->select([static::class . '.' . '*']);
      foreach ($subObj->fillable as $field) {
         $this->query .= ',' . $className . '.' . $field;
         $this->alias([$className . '_' . $field]);
      }
      $this->join([$className, $joinType])->on([static::class . '.' . $this->related[$className][0], '=', $className . '.' . $this->related[$className][1], true]);
      return $this;
   }
   protected function join($args)
   {
      $table = $args[0];
      $joinType = isset($args[1]) ? $args[1] : 'LEFT';
      $this->join = ' ' . $joinType . ' JOIN ' . $table;
      return $this;
   }
   protected function alias($args)
   {
      $alias = $args[0];
      $this->query .= ' ' . $alias;
      return $this;
   }
   protected function group($args)
   {
      $table = $args[0];
      $field = $args[1];
      $this->group = 'GROUP BY ' . $table . '.' . $field;
      return $this;
   }
   protected function having($args)
   {
      $field = $args[0];
      $operator = $args[1];
      $value = $args[2];
      $this->having = ' HAVING ' . $field . $operator . $value;
      return $this;
   }
   protected function coalesce($args)
   {
      if (!$this->type) {
         $this->select([static::class . '.*']);
      }
      $counter = 0;
      $this->coalesce = ', COALESCE(';
      foreach ($args[0] as $table => $field) {
         if ($counter == count($args[0]) - 1) {
            $this->coalesce .= $table . '.' . $field . ',' . '"' . $args[1][0] . '"' . ') ' . $table . '_' . $field;
         } else {
            $this->coalesce .= $table . '.' . $field . ',';
            $counter++;
         }
      }
      return $this;
   }
   protected function limit($offset, $limit)
   {
      if (!in_array($this->type, ['select'])) {
         throw new Exception("LIMIT can only be added to SELECT");
      }
      $this->limit = " LIMIT " . $offset . "," . $limit;
      return $this;
   }
   protected function render()
   {
      if ($this->coalesce) {
         $this->query .= $this->coalesce;
         $this->coalesce = '';
      }
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
      if ($this->group) {
         $this->query .= $this->group;
         $this->group = '';
      }
      if ($this->having) {
         $this->query .= $this->having;
         $this->having = '';
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
   protected function get()
   {
      $mainDb = factory::makeObj(mainDb::class);
      return $mainDb::$connection->query($this->render());
   }
}
