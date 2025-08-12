<?php
$limit = 5;
$result = category::withCount(['product'])->pageInit($limit);
?>
<h2>Categories List</h2>
<table>
   <thead>
      <tr>
         <th>Id</th>
         <th>Title</th>
         <th>Description</th>
         <th>Product Count</th>
         <th>Edit</th>
         <th>Delete</th>
         <th>Show</th>
      </tr>
   </thead>
   <tbody>
      <?php
      while ($catRow = $result->fetch_assoc()) {
         // $pro_count = product::count()->where('categoryId', '=', $catRow['id'])->get()->fetch_assoc()['count(*)'];
      ?>
         <tr>
            <td><?= $catRow['id']; ?></td>
            <td><?= $catRow['title']; ?></td>
            <td><?= $catRow['description']; ?></td>
            <td><?= $catRow['product_count']; ?></td>
            <td><a href="http://localhost/router/editCategory/<?= $catRow['id']; ?>">Edit</a></td>
            <td><a href="http://localhost/router/delete/category/<?= $catRow['id']; ?>">Delete</a></td>
            <td><a href="http://localhost/router/showCategory/<?= $catRow['id']; ?>">Show</a></td>
         </tr>
      <?php
      }
      ?>
   </tbody>
</table>
<?php
$count = category::count()->get()->fetch_assoc()['count(*)'];
?>
<p style="margin-top: 14px; font-weight: bold;">Number of Rows : <?= $count ?></p>
<?php
if ($count > $result->num_rows) {
?>
   <div class="page_num_container">
      <?php
      for ($i = 1; $i - 1 < $count / $limit; $i++) {
      ?>
         <a href="http://localhost/router/category/page/<?= $i; ?>" class="page_num"><?= $i; ?></a>
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
