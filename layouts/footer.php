<!-- Edit Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Product Details:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post">
        <div class="modal-body" id="prodeditfield">
        
        
        </div>
        <div class="modal-footer">
            <input type="hidden" name="id" value="update_product">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary update_prod">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

</body>
<footer>
<div class="container">
<small>copyright @ADX TECH SOLUTIONS</small>
</div>
</footer>
</html>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" 
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" 
        crossorigin="anonymous" referrerpolicy="no-referrer">
</script>

<script>
    //update the product 
$(document).ready(function(){
    $('.update_prod').click(function(e){
        // var action = 'update_product';
        e.preventDefault(); 

        var formData = $('form').serialize();

        $.ajax({
            url : 'http://localhost/2024/local/PROJECT/action/request.php',
            type: 'POST',
            data: formData,
            success: function(response){
                console.log(response);
            },
            error: function(xhr, status, error){
                console.error(xhr.responseText);
            }

        }); 
    });
});


//open model for edit a product from list
$(document).ready(function(){
    $('.prod_edit').click(function(){
        var productId = $(this).attr('data-id');
        const editaction = 'edit_product';
        
        $.ajax({
            url: 'http://localhost/2024/local/PROJECT/action/request.php',
            type: 'POST',
            data: { id: productId, action: editaction },
            success: function(response){
                if(response != '2'){
                    $('#prodeditfield').html(response);
                    // setTimeout(function(){
                    //     location.reload();
                    // }, 1500);
                }else{
                    console.log(response);
                }
            },
            error: function(xhr, status, error){
                console.error(xhr.responseText);
            }
        });
    });
});

//remove a product from list
$(document).ready(function(){
    $('.prod_remove').click(function(){
        var productId = $(this).attr('data-id');
        const remoevaction = 'remove_product';
        
        $.ajax({
            url: 'http://localhost/2024/local/PROJECT/action/request.php',
            type: 'POST',
            data: { id: productId, action: remoevaction },
            success: function(response){
                if(response == '1'){
                    $('#alert').html('<div class="alert alert-success" role="alert">Product is removed.</div>');
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                }else{
                    console.log(response);
                }
            },
            error: function(xhr, status, error){
                console.error(xhr.responseText);
            }
        });
    });
});

// login a user
document.addEventListener('DOMContentLoaded', function () {
  var form = document.getElementById('loginForm');

  if (form) {
      form.addEventListener('submit', function(e) {
          e.preventDefault(); 
          var formData = new FormData(form);
          var xhr = new XMLHttpRequest();
          xhr.open('POST', 'http://localhost/2024/local/PROJECT/action/request.php', true);

          xhr.onload = function () {
              if (xhr.status) {
                  console.log("Response: ", xhr.responseText);
                  if(xhr.responseText == '1'){
                    window.location.href = 'index.php?view=dashboard';
                  }
              } else {
                  console.log("Error: ", xhr.status);
              }
          };
          xhr.onerror = function () {
              console.log("Error during the request.");
          };
          xhr.send(formData);
      });
  }

});

// pagination
$(document).ready(function(){
    $('.pagination a.page-link').click(function(e){
        e.preventDefault();
        $('.pagination a.page-link').addClass('disabled');
        
        var page = $(this).data('page');
        // console.log("Clicked page:", page);
        var clickedLink = $(this);
        $.ajax({
            url: 'http://localhost/2024/local/PROJECT/action/request.php',
            type: 'POST',
            data: { page: page, action: 'pagination' },
            success: function(response){
                $('tbody').html(response);
                $('.pagination a.page-link').removeClass('disabled');
                $('.pagination li.page-item').removeClass('active');
                clickedLink.parent().addClass('active');
            },
            error: function(xhr, status, error){
                // console.error(xhr.responseText);
                $('.pagination a.page-link').removeClass('disabled');
            }
        });
    });
});

// search product
$(document).ready(function(){
    $('.find').click(function(e){
        e.preventDefault(); 

        var formData = $('#searchForm').serialize();

        $.ajax({
            url: 'http://localhost/2024/local/PROJECT/action/request.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response){
                $('tbody').empty();
                $.each(response.products, function(index, product) {
                    var row = '<tr>' +
                        '<th scope="row">' + (index + 1) + '</th>' +
                        '<td>' + product.name + '</td>' +
                        '<td>' + product.description + '</td>' +
                        '<td>' + product.price + '</td>' +
                        '<td>' +
                        '<button type="button" class="btn btn-success prod_edit" data-toggle="modal" data-target="#exampleModal" data-id="' + product.id + '">Edit</button>' +
                        '<button class="btn btn-danger prod_remove" data-id="' + product.id + '">Remove</button>' +
                        '</td>' +
                        '</tr>';
                    $('tbody').append(row);
                });
                
                // Update pagination links
                $('#pagination').empty();
                for (var page = 1; page <= response.total_pages; page++) {
                    var link = $('<li class="page-item"><a class="page-link" href="#" data-page="' + page + '">' + page + '</a></li>');
                    if (page === response.current_page) {
                        link.addClass('active');
                    }
                    $('#pagination').append(link);
                }
            },
            error: function(xhr, status, error){
                console.error(xhr.responseText);
            }
        }); 
    });
});



</script>