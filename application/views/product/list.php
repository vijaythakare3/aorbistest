
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
        <th>Image</th>
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
        <td><img src="<?php echo base_url()."uploads/".$prd['productimage']; ?>" width="80px"></td>
        <td><?php echo date("d-m-Y h:i A", strtotime($prd['created_date'])); ?></td>
        <td>
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

			var c = confirm("Are you sure? You want delete this product.");
			if(c){
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
					},
	        error: function (jqXHR, exception) {
	            var msg = '';
	            if (jqXHR.status === 0) {
	                msg = 'Not connect.\n Verify Network.';
	            } else if (jqXHR.status == 404) {
	                msg = 'Requested page not found. [404]';
	            } else if (jqXHR.status == 500) {
	                msg = 'Internal Server Error [500].';
	            } else if (exception === 'parsererror') {
	                msg = 'Requested JSON parse failed.';
	            } else if (exception === 'timeout') {
	                msg = 'Time out error.';
	            } else if (exception === 'abort') {
	                msg = 'Ajax request aborted.';
	            } else {
	                msg = 'Uncaught Error.\n' + jqXHR.responseText;
	            }
	            alert(msg);
	        }

				})
			}


		})
	})


</script>