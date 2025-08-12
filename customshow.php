<?php
$route = explode('/', $_SERVER['REQUEST_URI']);
$limit = 5;
$pageNum = $route[4];
if (count($route) > 5) {
   $start = $route[5];
   $end = $route[6];
   $table = $route[7];
}
if ($_POST) {
   $start = $_POST['start'];
   $end = $_POST['end'];
   $table = $_POST['table'];
}
$result = $table::customSelect($start, $end);
if ($table == "product") {
   if ($start < $end) {
      $result = $table::ascendingPrice($result);
   }
   if ($end < $start) {
      $result = $table::descendingPrice($result);
   }
}
$finalResult = $table::pageInitSearch($result, $pageNum, $limit);
?>
<h2><?= $table ?> List</h2>
<table style="width: 90%;">
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
      foreach ($finalResult as $row) {
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
         </tr>
      <?php
      }
      ?>
   </tbody>
</table>
<p style="margin-top: 14px; font-weight: bold;">Number of Result : <?= count($result) ?></p>
<?php
if (count($result) > $limit) {
?>
   <div class="page_num_container">
      <?php
      for ($i = 1; $i - 1 < count($result) / $limit; $i++) {
      ?>
         <a href="http://localhost/router/customshow/page/<?= $i; ?>/<?= $start; ?>/<?= $end; ?>/<?= $table ?>" class="page_num"><?= $i; ?></a>
      <?php
      }
      ?>
   </div>
<?php
}
$modelName = $table;
$result = $modelName::fields();
include 'customShowForm.php';
include 'searchForm.php';
