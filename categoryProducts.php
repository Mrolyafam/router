<?php
$route = explode('/', $_SERVER['REQUEST_URI']);
$limit = 5;
$pageNum = $route[4];
if (count($route) > 5) {
   $showType = $route[5];
}
if ($_POST) {
   $showType = $_POST['type'];
}
if ($showType == 'with') {
   $result = category::withCount('product')->join('product', 'INNER')->on('product.categoryId', '=', 'category.id', true)->group('category', 'id')->pageInit($limit);
   $count = category::on('product.categoryId', '=', 'category.id', true)->join('product', 'INNER')->group('category', 'id')->get()->num_rows;
}
if ($showType == 'without') {
   $result = category::withCount('product')->having('product_count', '=', 0)->pageInit($limit);
   $count = category::withCount('product')->having('product_count', '=', 0)->get()->num_rows;
}
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
         <th>Products</th>
      </tr>
   </thead>
   <tbody>
      <?php
      while ($catRow = $result->fetch_assoc()) {
      ?>
         <tr>
            <td><?= $catRow['id']; ?></td>
            <td><?= $catRow['title']; ?></td>
            <td><?= $catRow['description']; ?></td>
            <td><?= $catRow['product_count']; ?></td>
            <td><a href="http://localhost/router/editCategory/<?= $catRow['id']; ?>">Edit</a></td>
            <td><a href="http://localhost/router/delete/category/<?= $catRow['id']; ?>">Delete</a></td>
            <td><a href="http://localhost/router/showCategory/<?= $catRow['id']; ?>">Show</a></td>
            <td><a href="http://localhost/router/showCategoryProducts/page/1/<?= $catRow['id']; ?>">Products</a></td>
         </tr>
      <?php
      }
      ?>
   </tbody>
</table>
<p style="margin-top: 14px; font-weight: bold;">Number of Rows : <?= $count ?></p>
<?php
if ($count > $result->num_rows) {
?>
   <div class="page_num_container">
      <?php
      for ($i = 1; $i - 1 < $count / $limit; $i++) {
      ?>
         <a href="http://localhost/router/categoryProducts/page/<?= $i; ?>/<?= $showType ?>" class="page_num"><?= $i; ?></a>
      <?php
      }
      ?>
   </div>
<?php
}
$modelName = 'category';
$result = $modelName::fields();
include 'customShowForm.php';
include 'categorySelectForm.php';
include 'searchForm.php';
