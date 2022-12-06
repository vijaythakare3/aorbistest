<div class="container">
  <h3>Edit Product</h3>
		<form class="form-horizontal" method="POST" action="" id="f_add" enctype="multipart/form-data">
		  <div class="form-group">
		    <label class="control-label col-sm-2" for="name">Name <span class="text-danger">*</span>:</label>
		    <div class="col-sm-10">
		      <input type="text" class="form-control" name="name" id="name" required placeholder="Enter product name" value="<?php echo $detail['name']; ?>" >
		      <span class="text-danger"><?php echo form_error('name'); ?></span>
		    </div>
		  </div>

		  <div class="form-group">
		    <label class="control-label col-sm-2" for="parent">Category:</label>
		    <div class="col-sm-10">
		    	<?php foreach ($categories as $id => $name) { ?>
		    		<div class="radio">
		      		<label><input type="radio" name="categoryid" class="category" value="<?php echo $id; ?>" <?php echo $id==$detail['categoryid'] ?'checked':''; ?> ><?php echo $name ?></label>
		    		</div>
		    	<?php } ?>
		      <span class="text-danger"><?php echo form_error('categoryid'); ?></span>
		    </div>		    
		  </div>

		  <div class="form-group">
		    <label class="control-label col-sm-2" for="image">Product Image <span class="text-danger">*</span>:</label>
		    <div class="col-sm-10">
		      <input type="file" class="form-control" name="image" id="image">
		      <img src="<?php echo base_url()."uploads/".$detail['productimage']; ?>" width="100px">
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="control-label col-sm-2" for="price">Price <span class="text-danger">*</span>:</label>
		    <div class="col-sm-10">
		      <input type="text" class="form-control" name="price" id="price" required placeholder="Enter product price"  value="<?php echo $detail['price']; ?>">
		      <span class="text-danger"><?php echo form_error('price'); ?></span>
		    </div>
		  </div>
		  <div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" class="btn btn-default">Update</button>
		    </div>
		  </div>
		</form>

</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#f_add").submit(function(){	
			var name = $("#name").val();

			if(name==''){
				alert("Enter category name");
				return false;
			}

		})


	})



</script>