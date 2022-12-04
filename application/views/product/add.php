<div class="container">
  <h3>Add Product</h3>
		<form class="form-horizontal" method="POST" action="" id="f_add" enctype="multipart/form-data">
		  <div class="form-group">
		    <label class="control-label col-sm-2" for="name">Name <span class="text-danger">*</span>:</label>
		    <div class="col-sm-10">
		      <input type="text" class="form-control" name="name" id="name" required placeholder="Enter product name">
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="control-label col-sm-2" for="parent">Category:</label>
		    <div class="radio">
		    	<?php foreach ($categories as $key => $cat) { ?>
		      	<label><input type="radio" name="categoryid" class="category" value="5" ><?php echo $cat['name'] ?></label>
		    	<?php } ?>
		    
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="control-label col-sm-2" for="image">Product Image <span class="text-danger">*</span>:</label>
		    <div class="col-sm-10">
		      <input type="file" class="form-control" name="image" id="image" required>
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="control-label col-sm-2" for="price">Price <span class="text-danger">*</span>:</label>
		    <div class="col-sm-10">
		      <input type="text" class="form-control" name="price" id="price" required placeholder="Enter product price">
		    </div>
		  </div>
		  <div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" class="btn btn-default">Add</button>
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