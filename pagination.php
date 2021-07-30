<?php
// in container
$limit = 50;
if (isset($_GET["page"])) {
    $get_page = mysqli_real_escape_string($conn, $_GET["page"]);
    $page = (int) filter_var($get_page, FILTER_SANITIZE_NUMBER_INT);
    if (empty($page)) {
        $page = 1;
    }
    $offset = ($page - 1) * $limit;
} else {
    $page = 1;
    $offset = 0;
}
$get_data = mysqli_query($conn, "${SQL_CODE} LIMIT $offset, $limit;");

?>
<div class="pagination">
    <?php
    $total_rows = mysqli_num_rows(mysqli_query($conn, "SQL"));
    $base_url = "index.php";
    $next_page = $page + 1;
    $prev_page = $page - 1;
    $ends_count = 1;
    $middle_count = 1; // prev , 1, ... 3, 4, 5,... 15, next
    // $middle_count = 2; // prev , 1, ... 3, 4, 5, 6, 7, ... 15, next
    $dots = false;
    $total_pages = ceil($total_rows / $limit);
    echo "<ul>";
    if ($page > 1) {
        echo "<li><a href='$base_url?page=$prev_page'>&laquo; Prev</a></li>";
    }
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $page) {
            echo "<li class='active'><a href='$base_url?page=$i'>$i</a></li>";
            $dots = true;
        } else {
            if ($i <= $ends_count || ($page && $i >= $page - $middle_count && $i <= $page + $middle_count) || $i > $total_pages - $ends_count) {
                echo "<li><a href='$base_url?page=$i'>$i</a></li>";
                $dots = true;
            } elseif ($dots) {
                echo '<li><a>&hellip;</a></li>';
                $dots = false;
            }
        }
    }
    if ($total_pages > $page) {
        echo "<li><a href='$base_url?page=$next_page'>Next &raquo;</a></li>";
    }
    echo "</ul>";
    ?>
</div>