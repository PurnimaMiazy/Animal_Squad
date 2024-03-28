<?php 
$title = "Care for your pet in the best way";
$sub_title = "Check our tips for your pet.";
if(isset($_GET['c']) && isset($_GET['s'])){
    $care_cat_qry = $conn->query("SELECT * FROM care_categories where md5(id) = '{$_GET['c']}'");
    if($care_cat_qry->num_rows > 0){
        $title = $care_cat_qry->fetch_assoc()['care_category'];
    }
 $care_sub_cat_qry = $conn->query("SELECT * FROM care_sub_categories where md5(id) = '{$_GET['s']}'");
    if($care_sub_cat_qry->num_rows > 0){
        $sub_title = $care_sub_cat_qry->fetch_assoc()['care_sub_category'];
    }
}
elseif(isset($_GET['c'])){
    $care_cat_qry = $conn->query("SELECT * FROM care_categories where md5(id) = '{$_GET['c']}'");
    if($care_cat_qry->num_rows > 0){
        $title = $care_cat_qry->fetch_assoc()['care_category'];
    }
}
elseif(isset($_GET['s'])){
    $care_sub_cat_qry = $conn->query("SELECT * FROM care_sub_categories where md5(id) = '{$_GET['s']}'");
    if($care_sub_cat_qry->num_rows > 0){
        $title = $care_sub_cat_qry->fetch_assoc()['care_sub_category'];
    }
}
?>
<!-- Header-->
<header class="bg-dark py-5" id="main-header">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder"><?php echo $title ?></h1>
            <p class="lead fw-normal text-white-50 mb-0"><?php echo $sub_title ?></p>
        </div>
    </div>
</header>
<!-- Section-->
<section class="py-5">
    <div class="container-fluid px-4 px-lg-5 mt-5">
    <?php 
                if(isset($_GET['search'])){
                    echo "<h4 class='text-center'><b>Search Result for '".$_GET['search']."'</b></h4>";
                }
            ?>
        
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
           
            <?php 
                $whereData = "";
                if(isset($_GET['search']))
                    $whereData = " and (care_and_disease_name LIKE '%{$_GET['search']}%' or description LIKE '%{$_GET['search']}%')";
                elseif(isset($_GET['c']) && isset($_GET['s']))
                    $whereData = " and (md5(category_id) = '{$_GET['c']}' and md5(sub_category_id) = '{$_GET['s']}')";
                elseif(isset($_GET['c']))
                    $whereData = " and md5(category_id) = '{$_GET['c']}' ";
                elseif(isset($_GET['s']))
                    $whereData = " and md5(sub_category_id) = '{$_GET['s']}' ";
                $care_and_disease = $conn->query("SELECT * FROM `care_and_disease` where status = 1 {$whereData} order by rand() ");
                while($row = $care_and_disease->fetch_assoc()):
                    $upload_path = base_app.'/uploads/care_'.$row['id'];
                    $img = "";
                    if(is_dir($upload_path)){
                        $fileO = scandir($upload_path);
                        if(isset($fileO[2]))
                            $img = "uploads/care_".$row['id']."/".$fileO[2];
                        // var_dump($fileO);
                    }
                    
            ?>
            <div class="col mb-5">
                <div class="card h-100 product-item">
                    <!-- Petcare image-->
                    <img class="card-img-top w-100" src="<?php echo validate_image($img) ?>" loading="lazy" alt="..." />
                    <!-- Petcare details-->
                    <div class="card-body p-4">
                        <div class="text-center">
                            <!-- Petcare name-->
                            <h5 class="fw-bolder"><?php echo $row['care_and_disease_name'] ?></h5>
                          
                        </div>
                    </div>
                    <!-- Petcare actions-->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="text-center">
                            <a class="btn btn-flat btn-primary "   href=".?p=view_petcare&id=<?php echo md5($row['id']) ?>">View</a>
                        </div>
                        
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
            <?php 
                if($care_and_disease->num_rows <= 0){
                    echo "<h4 class='text-center'><b>No Petcare and disease listed.</b></h4>";
                }
            ?>
        </div>
    </div>
</section>