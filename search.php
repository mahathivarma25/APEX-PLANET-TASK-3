<?php
include 'db.php';

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

// Total count
$countQuery = "SELECT COUNT(*) AS total FROM products $where";
$countResult = $conn->query($countQuery);
$total = $countResult->fetch_assoc()['total'];
$totalPages = ceil($total / $limit);

// Fetch products
$sql = "SELECT * FROM products $where LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center text-success mb-4">Search Results</h2>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars($row['content']); ?></p>
                    <span class="badge bg-primary"><?php echo $row['category']; ?></span>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="text-center text-muted">No products found.</p>
    <?php endif; ?>

    <!-- Pagination -->
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

    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-secondary">Back to Search</a>
    </div>
</div>
</body>
</html>
