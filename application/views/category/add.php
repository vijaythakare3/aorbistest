
<div class="container">
  <h3>Add Category</h3>
		<form class="form-horizontal" method="POST" action="" id="f_add">
		  <div class="form-group">
		    <label class="control-label col-sm-2" for="name">Name <span class="text-danger">*</span>:</label>
		    <div class="col-sm-10">
		      <input type="text" class="form-control" name="name" id="name" required placeholder="Enter category name">
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="control-label col-sm-2" for="parent">Parent Category:</label>
		    <div class="col-sm-10">
		    	<select class="form-control" id="name" name="parent">
		    		<option value="">Select Parent Category</option>
		    		<?php 
		    			foreach ($categories as $cat) {
		    				// code...
		    				echo "<option value='".$cat['id']."'>".$cat['name']."</option>";
		    			}

		    		?>
		    	</select>
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