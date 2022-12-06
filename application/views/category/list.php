
<div class="container">
  <h3>Category List</h3>
  <a href="<?php echo base_url()."index.php/category"; ?>" class ="btn btn-primary pull-right" >Add New Category</a>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Sr No.</th>
        <th>Name</th>
        <th>Parent</th>
        <th>Products</th>
        <th>Created Date</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    	<?php foreach ($categories as $key => $cat) { ?>
      <tr>
        <td><?php echo $key+1 ?></td>
        <td><?php echo $cat['name']; ?></td>
        <td><?php echo $cat['parent_name']; ?></td>
        <td><?php echo $cat['products']; ?></td>
        <td><?php echo date("d-m-Y h:i A", strtotime($cat['created_date'])); ?></td>
        <td>
        	<a href="<?php echo base_url()."index.php/category/edit/".$cat['id']; ?>">Edit</a>
        	<a class="c_delete" href="#" data-id="<?php echo $cat['id']; ?>">Delete</a>
        </td>
      </tr>
    	<?php } ?>
    </tbody>
  </table>

</div>
<script type="text/javascript">
	$(document).ready(function(){
		$(".c_delete").click(function(){
			var c = confirm("Are you sure? You want delete this category.");
			if(c){

				var id = $(this).attr("data-id");
				
				$.ajax({
					"url":"<?php echo base_url()."index.php/category/delete" ?>",
					"method":"POST",
					"data":{id:id},
					"dataType":"json",
					"success":function(res) {
						console.log(res);
							alert(res.message);
							if(res.status=='success'){
								window.location.reload();
							}
					}

				})
			}


		})
	})


</script>