<?php
$limit = 5;
// $result = product::with('category')->pageInit($limit);
$result = product::category(['title'])->pageInit($limit);
?>
<h2>Products List</h2>
<table style="width: 85%;">
   <thead>
      <tr>
         <th>Id</th>
         <th>Title</th>
         <th>Price</th>
         <th>Exist</th>
         <th>Category</th>
         <th>Edit</th>
         <th>Delete</th>
         <th>Show</th>
      </tr>
   </thead>
   <tbody>
      <?php
      while ($proRow = $result->fetch_assoc()) {
      ?>
         <tr>
            <td><?= $proRow['id']; ?></td>
            <td><?= $proRow['title']; ?></td>
            <td><?= $proRow['price']; ?></td>
            <td><?= $proRow['exist']; ?></td>
            <td>
               <?php
               if (isset($proRow['category_title'])) {
                  echo $proRow['category_title'];
               } else {
                  echo "This Category Has Been Deleted!";
               }
               ?>
            </td>
            <td><a href="http://localhost/router/editProduct/<?= $proRow['id']; ?>">Edit</a></td>
            <td><a href="http://localhost/router/delete/product/<?= $proRow['id']; ?>">Delete</a></td>
            <td><a href="http://localhost/router/showProduct/<?= $proRow['id']; ?>">Show</a></td>
         </tr>
      <?php
      }
      ?>
   </tbody>
</table>
<?php
$count = product::count()->get()->fetch_assoc()['count(*)'];
?>
<p style="margin-top: 14px; font-weight: bold;">Number of Rows : <?= $count ?></p>
<?php
if ($count > $result->num_rows) {
?>
   <div class="page_num_container">
      <?php
      for ($i = 1; $i - 1 < $count / $limit; $i++) {
      ?>
         <a href="http://localhost/router/product/page/<?= $i; ?>" class="page_num"><?= $i; ?></a>
      <?php
      }
      ?>
   </div>
<?php
}
$route = explode('/', $_SERVER['REQUEST_URI']);
$modelName = $route[2];
$result = $modelName::fields();
include 'customShowForm.php';
include 'searchForm.php';
