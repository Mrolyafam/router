</div>
<?php
if ($uriArray[2] === "categoryForm" || $uriArray[2] === "productForm" || $uriArray[2] === "userForm" || $uriArray[2] === "editCategory" || $uriArray[2] === "editProduct" || $uriArray[2] === "editUser" || $uriArray[2] === "footerForm" || $uriArray[2] === "product" || $uriArray[2] === "category" || $uriArray[2] === "users" || $uriArray[2] === "customshow" || $uriArray[2] === "searchResult") {
?>
   <div class="empty"></div>
   <script src="http://localhost/router/index.js"></script>
<?php
}
include "pageFooter.php";
?>
</body>

</html>