<?php
$address = $_SERVER['REQUEST_URI'];
$addressArr = explode("/", $address);
$id = $addressArr[3];
$pro_count = category::where('id', '=', $id)->withCount('product')->get()->fetch_assoc();
?>
<h2>Single Category</h2>
<table>
   <thead>
      <tr>
         <th>Id</th>
         <th>Title</th>
         <th>Description</th>
         <th>Product Count</th>
         <th>Edit</th>
         <th>Delete</th>
         <th>Products</th>
      </tr>
   </thead>
   <tbody>
      <tr>
         <td><?= $pro_count['id']; ?></td>
         <td><?= $pro_count['title']; ?></td>
         <td><?= $pro_count['description']; ?></td>
         <td><?= $pro_count['product_count']; ?></td>
         <td><a href="http://localhost/router/editCategory/<?= $pro_count['id']; ?>">Edit</a></td>
         <td><a href="http://localhost/router/delete/category/<?= $pro_count['id']; ?>">Delete</a></td>
         <td><a href="http://localhost/router/showCategoryProducts/page/1/<?= $pro_count['id']; ?>">Products</a></td>
      </tr>
   </tbody>
</table>