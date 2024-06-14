<?php
include('db.php');

// Code for handling form submission
if(isset($_POST['submit']))
{
    // Add the Food in Database
    
    // Retrieve the form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    
    // Check whether the radio button for availability is checked or not
    if(isset($_POST['available']))
    {
        $available = $_POST['available'];
    }
    else
    {
        $available = "No"; // Set default value
    }
    
    // Upload the image if selected
    if(isset($_FILES['image']['name']))
    {
        $image_name = $_FILES['image']['name'];
        
        // Check if an image is selected
        if(!empty($image_name))
        {
            $ext = pathinfo($image_name, PATHINFO_EXTENSION);
            $image_name = "Food-Name-" . rand(0000, 9999) . "." . $ext;
            
            $src = $_FILES['image']['tmp_name'];
            $dst = "../images/food/" . $image_name;
            
            $upload = move_uploaded_file($src, $dst);
            
            if(!$upload)
            {
                $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                header('Location: add-food.php');
                exit();
            }
        }
    }
    else
    {
        $image_name = ""; // Set default value
    }
    
    // Insert into the database
    $sql = "INSERT INTO food (title, description, price, image_name, category_id, available) 
            VALUES ('$title', '$description', $price, '$image_name', $category, '$available')";
    
    $res = mysqli_query($conn, $sql);
    
    if($res)
    {
        $_SESSION['add'] = "<div class='success'>Food Added Successfully.</div>";
        header('Location: manage-food.php');
        exit();
    }
    else
    {
        $_SESSION['add'] = "<div class='error'>Failed to Add Food.</div>";
        header('Location: manage-food.php');
        exit();
    }
}

?>

<div class="main-content">
    <div class="wrapper">
        <div class="container">
            <center><h1>Add Food</h1></center>

            <br>

            <?php 
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
            ?>

            <div class="form-container">
                <form action="" method="POST" enctype="multipart/form-data">
                    <table class="tbl-30">
                        <tr>
                            <td>Title: </td>
                            <td>
                                <input type="text" name="title" placeholder="Title of the Food">
                            </td>
                        </tr>
                        <tr>
                            <td>Description: </td>
                            <td>
                                <textarea name="description" cols="30" rows="5" placeholder="Description of the Food."></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Price: </td>
                            <td>
                                <input type="number" name="price" step=".01">
                            </td>
                        </tr>
                        <tr>
                            <td>Select Image: </td>
                            <td>
                                <input type="file" name="image">
                            </td>
                        </tr>
                        <tr>
                            <td>Category: </td>
                            <td>
                                <select name="category">
                                    <?php
                                    $sql = "SELECT * FROM category";
                                    $res = mysqli_query($conn, $sql);
                                    $count = mysqli_num_rows($res);

                                    if($count > 0)
                                    {
                                        while($row = mysqli_fetch_assoc($res))
                                        {
                                            $id = $row['id'];
                                            $title = $row['title'];
                                            echo "<option value='$id'>$title</option>";
                                        }
                                    }
                                    else
                                    {
                                        echo "<option value='0'>No Category Found</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Available: </td>
                            <td>
                                <input type="radio" name="available" value="Yes"> Yes 
                                <input type="radio" name="available" value="No"> No
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>