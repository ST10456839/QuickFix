<?php 
 include "db.php";
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body> <h1>List of Users</h1> <a href="add.php">Add User</a>
    <table border>
    <tr><th>ID</th><th>Name</th><th>Email</th><th>Password</th>
    <th>Action</th></tr>
    <?php
     $results = mysqli_query($link,"SELECT * FROM users");
     if(mysqli_num_rows($results)>0){
        while($row=mysqli_fetch_assoc($results)){ ?>
     <tr> 
        <td><?php echo $row['id']; ?> </td><td><?php echo $row['name']; ?> </td>
        <td><?php echo $row['email']; ?> </td><td><?php echo $row['password']; ?> </td>
        <td> 
    <a href="delete.php?id=<?php echo $row['id'];?>" onclick="return confirm('are u sure wanna delete?');" >
            Delete</a></td>
     </tr>
      <?php  }
     }else{
        echo "no data";
     }
    ?>

    </table>

    <h1>List of Products</h1> <a href="add_product.php">Add Product</a>
    <table border>
    <tr><th>ID</th><th>Name</th><th>Price</th><th>Description</th><th>Image</th><th>Action</th></tr>
    <?php
     $results = mysqli_query($link,"SELECT * FROM products");
     if(mysqli_num_rows($results)>0){
        while($row=mysqli_fetch_assoc($results)){ ?>
     <tr> 
        <td><?php echo $row['id']; ?> </td><td><?php echo $row['name']; ?> </td>
        <td><?php echo $row['price']; ?> </td><td><?php echo $row['description']; ?> </td>
        <td><img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" width="100"></td>
        <td> 
    <a href="delete_product.php?id=<?php echo $row['id'];?>" onclick="return confirm('are u sure wanna delete?');" >
            Delete</a></td>
     </tr>
      <?php  }
     }else{
        echo "no data";
     }
    ?>

    </table>
</body>
</html>