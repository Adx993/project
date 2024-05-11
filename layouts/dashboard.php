<?php 
require_once './con.php';
require_once 'header.php';

$check = $_SESSION['logged_user'];

// Pagination configuration
$results_per_page   = 5; // Number of results per page
$current_page       = isset($_GET['page']) ? $_GET['page'] : 1; // Get current page, default to 1 if not set

// SQL query to fetch total number of products
$sql_count          = "SELECT COUNT(*) AS total FROM `pro_products` WHERE `deleted` = '0'";
$result_count       = mysqli_query($db, $sql_count);
$row_count          = mysqli_fetch_assoc($result_count);
$total_products     = $row_count['total'];

// Calculate total pages
$total_pages        = ceil($total_products / $results_per_page);

// Calculate SQL limit starting point for the current page
$offset             = ($current_page - 1) * $results_per_page;

// SQL query to fetch products for the current page
$sql                = "SELECT * FROM `pro_products` WHERE `deleted` = '0' LIMIT $offset, $results_per_page";
$query              = mysqli_query($db, $sql);
$products           = mysqli_fetch_all($query, MYSQLI_ASSOC);

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
            // $num = ($current_page - 1) * $results_per_page + 1;
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

    <!-- Bootstrap Pagination -->
<nav aria-label="Page navigation">
    <ul class="pagination">
    <?php
    $sql = "SELECT COUNT(*) AS total FROM `pro_products` WHERE `deleted` = '0'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);
    $total_pages = ceil($row["total"] / $results_per_page);

    for ($page = 1; $page <= $total_pages; $page++) {
        $active_class = ($page == $current_page) ? 'active' : ''; 
        ?>
        <li class="page-item <?php echo $active_class; ?>">
            <a class="page-link" href="#" data-page="<?php echo $page; ?>"><?php echo $page; ?></a>
        </li>
        <?php
    }
?>
    </ul>
</nav>

</main>

<?php
require_once 'footer.php';
?>
