<?php
use mainadmin\admin;

require_once 'header.php';
require_once './connection.php';
require_once $path . 'action/admin.php';

$products           = admin::products();
$results_per_page   = $products['results_per_page'];
$current_page       = $products['current_page'];
$total_pages        = $products['total_pages'];
$products           = $products['products'];

$check = $_SESSION['logged_user'];
?>

<main class="container">
    
    <?php foreach ($check as $key => $value){ 
        if ($key === 'name' || $key === 'created'){ ?>
            <div class="d-flex align-items-center p-3 my-3 rounded shadow-sm">
                <div class="lh-1">
                    <h1 class="h6 mb-0 lh-1"><?php echo $key === 'name' ? $value : ''; ?></h1>
                    <small><?php echo $key === 'created' ? 'Member Since ' . $value : ''; ?></small>
                </div>
            </div>
    <?php } 
    } ?>

    <table class="table table-striped">
        
        <h3>List of available Products:</h3>
            <!-- Search Section -->
        <form id="searchForm" method="post">
            <div class="row mb-3">
                <div class="col">
                    <select name="type" id="searchType" class="form-select form-select-lg">
                        <option selected>Search Type</option>
                        <option value="name">Name</option>
                        <option value="description">Description</option>
                        <option value="price">Price</option>
                    </select>
                </div>
                <div class="col">
                    <input type="text" name="search" id="searchInput" class="form-control" placeholder="Search..">
                </div>
                <input type="hidden" name="action" value="search_product">
                <div class="col">
                    <button type="button" class="btn btn-primary find">Go</button>
                </div>
            </div>
        </form>

        <thead>
            <tr>
                <th scope="col">S.No.</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col" colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $num = 1;
            foreach ($products as $product) {
            ?>
                <tr>
                    <th scope="row"><?php echo $num; ?></th>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['description']; ?></td>
                    <td><?php echo $product['price']; ?></td>
                    <td>
                        <button type="button" class="btn btn-success prod_edit" data-toggle="modal" data-target="#exampleModal" data-id="<?php echo $product['id'];?>">Edit</button>
                        <button class="btn btn-danger prod_remove" data-id="<?php echo $product['id'];?>">Remove</button>
                    </td>
                </tr>
            <?php
                $num++;
            }
            ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul id="pagination" class="pagination">
            <?php for ($page = 1; $page <= $total_pages; $page++) : ?>
                <li class="page-item <?php echo ($page == $current_page) ? 'active' : ''; ?>">
                    <a class="page-link" href="#" data-page="<?php echo $page; ?>"><?php echo $page; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>

</main>

<?php
require_once 'footer.php';
?>
