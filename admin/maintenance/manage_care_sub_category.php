<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `care_sub_categories` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<div class="card card-outline card-info">
	<div class="card-header">
		<h3 class="card-title"><?php echo isset($id) ? "Update ": "Create New " ?> Pet care and disease Sub Catgory</h3>
	</div>
	<div class="card-body">
		<form action="" id="care_category-form">
			<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
            <div class="form-group">
				<label for="care_parent_id" class="control-label">Pet care Parent Category</label>
                <select name="care_parent_id" id="care_parent_id" class="custom-select select2">
                <option value=""></option>
                <?php
                    $qry = $conn->query("SELECT * FROM `care_categories` order by care_category asc");
                    while($row= $qry->fetch_assoc()):
                ?>
                <option value="<?php echo $row['id'] ?>" <?php echo isset($care_parent_id) && $care_parent_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['care_category'] ?></option>
                <?php endwhile; ?>
                </select>
			</div>
			<div class="form-group">
				<label for="care_sub_category" class="control-label">Pet care and disease Sub Category Name</label>
                <textarea name="care_sub_category" id="" cols="30" rows="2" class="form-control form no-resize"><?php echo isset($care_sub_category) ? $care_sub_category : ''; ?></textarea>
			</div>
            <div class="form-group">
				<label for="description" class="control-label">Description</label>
                <textarea name="description" id="" cols="30" rows="2" class="form-control form no-resize summernote"><?php echo isset($description) ? $description : ''; ?></textarea>
			</div>
            <div class="form-group">
				<label for="status" class="control-label">Status</label>
                <select name="status" id="status" class="custom-select selevt">
                <option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
                <option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Inactive</option>
                </select>
			</div>
			
		</form>
	</div>
	<div class="card-footer">
		<button class="btn btn-flat btn-primary" form="care_category-form">Save</button>
		<a class="btn btn-flat btn-default" href="?page=maintenance/care_sub_category">Cancel</a>
	</div>
</div>
<script>
  
	$(document).ready(function(){
        $('.select2').select2({placeholder:"Please Select here",width:"relative"})
		$('#care_category-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_care_sub_category",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.href = "./?page=maintenance/care_sub_category";
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                            end_loader()
                    }else{
						alert_toast("An error occured",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})

        $('.summernote').summernote({
		        height: 200,
		        toolbar: [
		            [ 'style', [ 'style' ] ],
		            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
		            [ 'fontname', [ 'fontname' ] ],
		            [ 'fontsize', [ 'fontsize' ] ],
		            [ 'color', [ 'color' ] ],
		            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
		            [ 'table', [ 'table' ] ],
		            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
		        ]
		    })
	})
</script>