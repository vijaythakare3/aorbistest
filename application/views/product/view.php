
<div class="container">
  <h3>Product List</h3>
  <a href="<?php echo base_url()."index.php/product"; ?>" class ="btn btn-primary pull-right" >Add New Product</a>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Sr No.</th>
        <th>Name</th>
        <th>Category</th>
        <th>Price</th>
        <th>Created Date</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    	<?php foreach ($products as $key => $prd) { ?>
      <tr>
        <td><?php echo $key+1 ?></td>
        <td><?php echo $prd['name']; ?></td>
        <td><?php echo $prd['category_name']; ?></td>
        <td><?php echo $prd['price']; ?></td>
        <td><?php echo date("d-m-Y h:i A", strtotime($prd['created_date'])); ?></td>
        <td>
        	<a href="<?php echo base_url()."index.php/product/view/".$prd['id']; ?>">View</a>
        	<a href="<?php echo base_url()."index.php/product/edit/".$prd['id']; ?>">Edit</a>
        	<a class="c_delete" href="#" data-id="<?php echo $prd['id']; ?>">Delete</a>
        </td>
      </tr>
    	<?php } ?>
    </tbody>
  </table>

</div>
<script type="text/javascript">
	$(document).ready(function(){
		$(".c_delete").click(function(){
			var id = $(this).attr("data-id");
			
			$.ajax({
				"url":"<?php echo base_url()."index.php/product/delete" ?>",
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



		})
	})


</script>