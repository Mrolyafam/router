<?php
$addressArr = explode("/", $_SERVER['REQUEST_URI']);
$pageNum = $addressArr[4];
$id = $addressArr[5];
$limit = 5;
$products = product::where('categoryId', '=', $id)->category('title')->pageInit($limit);
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
      foreach ($products as $proRow) {
      ?>
         <tr>
            <td><?= $proRow['id']; ?></td>
            <td><?= $proRow['title']; ?></td>
            <td><?= $proRow['price']; ?></td>
            <td><?= $proRow['exist']; ?></td>
            <td><?= $proRow['category_title']; ?></td>
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
$count = product::count()->where('categoryId', '=', $id)->get()->fetch_assoc()['count(*)'];
?>
<p style="margin-top: 14px; font-weight: bold;">Number of Rows : <?= $count ?></p>
<?php
if ($count > $products->num_rows) {
?>
   <div class="page_num_container">
      <?php
      for ($i = 1; $i - 1 < $count / $limit; $i++) {
      ?>
         <a href="http://localhost/router/showCategoryProducts/page/<?= $i; ?>/<?= $id ?>" class="page_num"><?= $i; ?></a>
      <?php
      }
      ?>
   </div>
<?php
}
