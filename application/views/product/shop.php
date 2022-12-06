
<div class="container">
  <h3>Product Categories</h3>
  <?php
    foreach ($categories as $id => $name) { ?>
      <div class="section">
        <a href="#" class="product_cat" data-id="<?php echo $id; ?>" ><?php echo $name ?></a>
        <div class="row" id="list<?php echo $id; ?>">
        </div>
      </div>
    <?php } ?>
      

</div>
<script type="text/javascript">
	$(document).ready(function(){
		$(".product_cat").click(function(){
			var id = $(this).attr("data-id");
			
			$.ajax({
				"url":"<?php echo base_url()."index.php/product/getProducts" ?>",
				"method":"POST",
				"data":{id:id},
				"dataType":"json",
				"success":function(res) {
            console.log(res);
						if(res.status=='success'){
              var str = '';
              $.each(res.data, function(idx, item){
                str +='\
                    <div class="col-md-3" align="center">\
                      <span>'+item['name']+'</span><br>\
                      <span>&#8377; '+item['price']+'</span><br>\
                      <img width="150px" src="<?php echo base_url()."uploads/" ?>'+item['productimage']+'" >\
                    </div>';                
              })
              if(str==''){
                    
                str = '<div class="col-md-3" align="center">\
                          Data not found for selected category\
                    </div>';                
              }

              $("#list"+id).html(str);
						}else{
  						alert(res.message);
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



		})
	})


</script>