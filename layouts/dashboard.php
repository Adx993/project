<?php
use mainadmin\admin;

require_once 'header.php';
require_once './connection.php';
require_once $path . 'action/admin.php';

$products           = admin::products();
$results_per_page   = $products['results_per_page'];
$current_page       = $products['current_page'];
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
        <div>
            <!-- <form class="form-inline my-2 my-lg-0"> -->
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            <!-- </form> -->
        </div>

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
