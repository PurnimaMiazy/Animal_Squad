<section class="py-5">
    <div class="container">
        <div class="card rounded-0">
            <div class="card-body">
                <?php
error_reporting(0);
 
$msg = "";
 
// If upload button is clicked ...
if (isset($_POST['upload'])) {
    $username = $_POST["username"];
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "./image/" . $filename;
    
 
    $db = mysqli_connect("localhost", "root", "", "pet_shop_db");
 
    // Get all the submitted data from the form
    $sql = "INSERT INTO image2 (username, filename) VALUES ('$username','$filename')";
    // Execute query
    mysqli_query($db, $sql);
 
    // Now let's move the uploaded image into the folder: image
    if (move_uploaded_file($tempname, $folder)) {
        echo "<h4>  Image uploaded successfully!</h4>";
    } else {
        echo "<h4>  Failed to upload image!</h4>";
    }
}

?>
 
<!DOCTYPE html>
<html>
 
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles.css" />
   
</head>
 
<body>
    <div id="content">
        <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" placeholder="Enter your Name" required>
        </div>
            <div class="form-group">
                <input class="form-control" type="file" name="uploadfile" value="" />
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit" name="upload">UPLOAD</button>
            </div>
        </form>
     </div>
    
<!-- Section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-md-3 row-cols-xl-4 justify-content-center">

            <?php
        $query = " select * from image2 ORDER BY id DESC ";
        $result = mysqli_query($db, $query);
 
        while ($data = mysqli_fetch_assoc($result)) {
        ?>
            <div class="col mb-5">
                <div class="card h-100 product-item">
                    <!-- Product image-->
                    <img  src="./image/<?php echo $data['filename']; ?>" width="150px" height="100px" style="object-fit:cover;"class="img-thumbnail" alt="" class="card-img-top">
                   
                    <!-- Product details-->
                    <div class="card-body p-4">
                        <div class="text-center">
                            <!-- Product name-->
                            <h5 class="card-title"><?php echo $data['username']; ?></h5>
                            <!-- Product price-->
                            
                        </div>
                    </div>

                </div>
            </div>
        <?php } ?>
        </div>
    </div>
</section>
<section>
</body>
 
</html>
    
            