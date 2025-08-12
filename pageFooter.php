<?php
$result = footer::all();
$footerRow = $result->fetch_assoc();
if ($result->num_rows) {
?>
   <footer>
      <p>Designer Name : <?= $footerRow['designerName']; ?></p>
      <p>Phone Number : <?= $footerRow['phoneNumber']; ?></p>
      <p>© All Rights Are Reserved</p>
      <a href="http://localhost/router/delete/footer/<?= $footerRow['id']; ?>">Delete</a>
   </footer>
<?php
} else {
?>
   <footer>
      <a href="http://localhost/router/footerForm">Click here and enter your INFORMATION.</a>
   </footer>
<?php
}
?>