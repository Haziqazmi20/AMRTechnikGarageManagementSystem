<?php
// Include Constants Page
include('../config/constants.php');

if (isset($_GET['id']) && isset($_GET['image_name'])) {
    // Process to Delete
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    if ($image_name != "") {
        $path = "../images/food/" . $image_name;
        $remove = unlink($path);

        if ($remove == false) {
            $_SESSION['delete'] = "<div class='error'>Failed to Remove Image File.</div>";
            header('location:manage-food.php');
            die();
        }
    }

    $sql = "DELETE FROM food WHERE id=$id";
    $res = mysqli_query($conn, $sql);

    if ($res == true) {
        // Food Deleted
        $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully.</div>";
        echo "<script>
                alert('Food Deleted Successfully.');
                window.location.href = 'manage-food.php';
            </script>";
    } else {
        // Failed to Delete Food
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Food.</div>";
        echo "<script>
                alert('Failed to Delete Food.');
                window.location.href = 'manage-food.php';
            </script>";
    }
} else {
    $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access.</div>";
    header('location:manage-food.php');
}
?>
