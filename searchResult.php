<?php
$route = explode('/', $_SERVER['REQUEST_URI']);
$limit = 5;
$pageNum = $route[4];
if (count($route) > 5) {
   $table = $route[5];
   $field = $route[6];
   $value = $route[7];
}
if ($_POST) {
   $table = $_POST['table'];
   $field = $_POST['field'];
   $value = $_POST['value'];
}
$result = $table::where($table . '.' . $field, '=', $value);
if ($table == "product") {
   $result = $result->category('title');
}
$result = $result->pageInit($limit);
?>
<h2><?= $table ?> List</h2>
<table>
   <thead>
      <tr>
         <?php
         $fields = $table::fields();
         while ($fieldResult = $fields->fetch_assoc()) {
         ?>
            <th>
               <?php
               if ($fieldResult['Field'] == 'categoryId') {
                  echo 'category title';
               } else {
                  echo $fieldResult['Field'];
               }
               ?>
            </th>
         <?php
         }
         if ($table == "category") {
         ?>
            <th>Product Count</th>
            <th>Products</th>
         <?php
         }
         ?>
         <th>Edit</th>
         <th>Delete</th>
         <th>Show</th>
      </tr>
   </thead>
   <tbody>
      <?php
      while ($row = $result->fetch_assoc()) {
      ?>
         <tr>
            <?php
            $fields = $table::fields();
            while ($fieldResult = $fields->fetch_assoc()) {
            ?>
               <td>
                  <?php
                  if ($fieldResult['Field'] == 'categoryId') {
                     if (isset($row['category_title'])) {
                        echo $row['category_title'];
                     } else {
                        echo "This Category Has Been Deleted!";
                     }
                  } else {
                     echo $row[$fieldResult['Field']];
                  }
                  ?>
               </td>
            <?php
            }
            if ($table == "category") {
               $productCount = product::count()->where('categoryId', '=', $row['id'])->get()->fetch_assoc()['count(*)'];
            ?>
               <td><?= $productCount ?></td>
            <?php
            }
            ?>
            <td><a href="http://localhost/router/edit<?= $table; ?>/<?= $row['id']; ?>">Edit</a></td>
            <td><a href="http://localhost/router/delete/<?= $table; ?>/<?= $row['id']; ?>">Delete</a></td>
            <td><a href="http://localhost/router/show<?= $table; ?>/<?= $row['id']; ?>">Show</a></td>
            <?php
            if ($table == 'category') {
            ?>
               <td><a href="http://localhost/router/showCategoryProducts/page/1/<?= $row['id']; ?>">Products</a></td>
            <?php
            }
            ?>
         </tr>
      <?php
      }
      ?>
   </tbody>
</table>
<?php
$result = $table::where($field, '=', $value)->get();
?>
<p style="margin-top: 14px; font-weight: bold;">Number of Result : <?= $result->num_rows ?></p>
<?php
if ($result->num_rows > $limit) {
?>
   <div class="page_num_container">
      <?php
      for ($i = 1; $i - 1 < $result->num_rows / $limit; $i++) {
      ?>
         <a href="http://localhost/router/searchResult/page/<?= $i; ?>/<?= $table; ?>/<?= $field; ?>/<?= $value ?>" class="page_num"><?= $i; ?></a>
      <?php
      }
      ?>
   </div>
<?php
}
$modelName = $table;
$result = $modelName::fields();
include 'customShowForm.php';
if ($table == 'category') {
   include 'categorySelectForm.php';
}
include 'searchForm.php';
