<?php 
 $care_and_disease = $conn->query("SELECT * FROM `care_and_disease`  where md5(id) = '{$_GET['id']}' ");
 if($care_and_disease->num_rows > 0){
     foreach($care_and_disease->fetch_assoc() as $k => $v){
         $$k= $v;
     }
    $upload_path = base_app.'/uploads/care_'.$id;
    $img = "";
    if(is_dir($upload_path)){
        $fileO = scandir($upload_path);
        if(isset($fileO[2]))
            $img = "uploads/care_".$id."/".$fileO[2];
        // var_dump($fileO);
    }
   
 }
?>
<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6">
                <img class="card-img-top mb-5 mb-md-0 " style="position: relative;" loading="lazy" id="display-img" src="<?php echo validate_image($img) ?>" alt="..." />
                <div class="mt-2 row gx-2 gx-lg-3 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-start">
                    <?php 
                        foreach($fileO as $k => $img):
                            if(in_array($img,array('.','..')))
                                continue;
                    ?>
                        <a href="javascript:void(0)" class="view-image <?php echo $k == 2 ? "active":'' ?>"><img src="<?php echo validate_image('uploads/care_'.$id.'/'.$img) ?>" loading="lazy"  class="img-thumbnail" alt=""></a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-6">
                <!-- <div class="small mb-1">SKU: BST-498</div> -->
                <h1 class="display-5 fw-bolder"><?php echo $care_and_disease_name ?></h1>
               
                
                <p class="lead"><?php echo stripslashes(html_entity_decode($description)) ?></p>
                
            </div>
        </div>
    </div>
</section>
<!-- Related items section-->
<section class="py-5 bg-light">
    <div class="container px-4 px-lg-5 mt-5">
        <h2 class="fw-bolder mb-4">Related pet care information</h2>
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
        <?php 
            $care_and_disease = $conn->query("SELECT * FROM `care_and_disease` where status = 1 and (category_id = '{$category_id}' or sub_category_id = '{$sub_category_id}') and id !='{$id}' order by rand() limit 4 ");
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
                    <img class="card-img-top w-100" src="<?php echo validate_image($img) ?>" alt="..." />
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
        </div>
    </div>
</section>
