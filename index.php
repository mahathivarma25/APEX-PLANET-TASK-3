<?php
include 'db.php';

// Handle search inputs
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$page = $_GET['page'] ?? 1;
$limit = 3;
$offset = ($page - 1) * $limit;

// Build WHERE clause
$where = "WHERE 1";
if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $where .= " AND (title LIKE '%$search%' OR content LIKE '%$search%')";
}
if (!empty($category)) {
    $category = $conn->real_escape_string($category);
    $where .= " AND category = '$category'";
}

// Total results count
$countQuery = "SELECT COUNT(*) AS total FROM products $where";
$countResult = $conn->query($countQuery);
$total = $countResult->fetch_assoc()['total'];
$totalPages = ceil($total / $limit);

// Fetch results
$sql = "SELECT * FROM products $where LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Accessories Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center text-primary mb-4">Find Your Accessories</h1>

    <!-- Search Form -->
    <form class="row g-3 mb-4" method="GET" action="">
        <div class="col-md-6">
            <input type="text" name="search" class="form-control" placeholder="Search accessories..." value="<?php echo htmlspecialchars($search); ?>">
        </div>
        <div class="col-md-4">
            <select name="category" class="form-select">
                <option value="">All Categories</option>
                <option value="Wallets" <?php if ($category == 'Wallets') echo 'selected'; ?>>Wallets</option>
                <option value="Scarves" <?php if ($category == 'Scarves') echo 'selected'; ?>>Scarves</option>
                <option value="Earrings" <?php if ($category == 'Earrings') echo 'selected'; ?>>Earrings</option>
                <option value="Watches" <?php if ($category == 'Watches') echo 'selected'; ?>>Watches</option>
                <option value="Sunglasses" <?php if ($category == 'Sunglasses') echo 'selected'; ?>>Sunglasses</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Search</button>
        </div>
    </form>

    <!-- Display Results -->
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars($row['content']); ?></p>
                    <span class="badge bg-secondary"><?php echo $row['category']; ?></span>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="text-muted text-center">No products found.</p>
    <?php endif; ?>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
        <nav>
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="?search=<?php echo urlencode($search); ?>&category=<?php echo urlencode($category); ?>&page=<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
