<?php
$address = $_SERVER['REQUEST_URI'];
$addressArr = explode("/", $address);
$id = $addressArr[3];
$foundPro = product::where('product.id', '=', $id)->category('title')->get()->fetch_assoc();
?>
<h2>Single Product</h2>
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
      </tr>
   </thead>
   <tbody>
      <tr>
         <td><?= $foundPro['id']; ?></td>
         <td><?= $foundPro['title']; ?></td>
         <td><?= $foundPro['price']; ?></td>
         <td><?= $foundPro['exist']; ?></td>
         <td>
            <?php
            if (isset($foundPro['category_title'])) {
               echo $foundPro['category_title'];
            } else {
               echo "This Category Has Been Deleted!";
            }
            ?>
         </td>
         <td><a href="http://localhost/router/editProduct/<?= $foundPro['id']; ?>">Edit</a></td>
         <td><a href="http://localhost/router/delete/product/<?= $foundPro['id']; ?>">Delete</a></td>
      </tr>
   </tbody>
</table>