<div class="container">
  <h3>Add Product</h3>
		<form class="form-horizontal" method="POST" action="" id="f_add" enctype="multipart/form-data">
		  <div class="form-group">
		    <label class="control-label col-sm-2" for="name">Name <span class="text-danger">*</span>:</label>
		    <div class="col-sm-10">
		      <input type="text" class="form-control" name="name" id="name" required placeholder="Enter product name">
		      <span class="text-danger"><?php echo form_error('name'); ?></span>
		    </div>
		  </div>

		  <div class="form-group">
		    <label class="control-label col-sm-2" for="parent">Category:</label>
		    <div class="col-sm-10">
		    	<?php foreach ($categories as $id => $name) { ?>
		    		<div class="radio">
		      		<label><input type="radio" name="categoryid" class="category" value="<?php echo $id; ?>" ><?php echo $name ?></label>
		    		</div>
		    	<?php } ?>
		      <span class="text-danger"><?php echo form_error('categoryid'); ?></span>
		    </div>		    
		  </div>

		  <div class="form-group">
		    <label class="control-label col-sm-2" for="image">Product Image <span class="text-danger">*</span>:</label>
		    <div class="col-sm-10">
		      <input type="file" class="form-control" name="image" id="image" required>
		      <span class="text-danger"><?php echo $error; ?></span>
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="control-label col-sm-2" for="price">Price <span class="text-danger">*</span>:</label>
		    <div class="col-sm-10">
		      <input type="text" class="form-control" name="price" id="price" required placeholder="Enter product price">
		      <span class="text-danger"><?php echo form_error('price'); ?></span>
		    </div>
		  </div>
		  <div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" class="btn btn-default">Add Product</button>
		    </div>
		  </div>
		</form>

</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#f_add").submit(function(){	
			var name = $("#name").val();
			var price = $("#price").val();
			var msg = ''
			if(name==''){
				msg = "Enter category name";
			}
			else if(price==''){
				msg = "Enter valid price";
			}

			if(msg!=''){
				alert(msg);
				return false;
			}

		})


	})



</script>