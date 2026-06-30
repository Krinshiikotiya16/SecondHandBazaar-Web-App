<?php
session_start();
include "../config/db.php";
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// ============================================
// ADMIN LOGIN CHECK
// ============================================
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

mysqli_set_charset($con, "utf8mb4");

// ============================================
// SAFE QUERY FUNCTION
// ============================================
function safe_query($con, $query) {
    $result = mysqli_query($con, $query);
    if(!$result) {
        error_log("SQL Error: " . mysqli_error($con) . " | Query: $query");
        return null;
    }
    return $result;
}

// ============================================
// GET STATISTICS
// ============================================
$total_orders = 0;
$result = safe_query($con, "SELECT COUNT(*) as count FROM orders");
if($result && $row = mysqli_fetch_assoc($result)) {
    $total_orders = $row['count'] ?? 0;
}

$total_sold = 0;
$result = safe_query($con, "SELECT COUNT(*) as count FROM item WHERE SELL_STATUS='Y'");
if($result && $row = mysqli_fetch_assoc($result)) {
    $total_sold = $row['count'] ?? 0;
}

$total_available = 0;
$result = safe_query($con, "SELECT COUNT(*) as count FROM item WHERE SELL_STATUS='N'");
if($result && $row = mysqli_fetch_assoc($result)) {
    $total_available = $row['count'] ?? 0;
}

$total_revenue = 0;
$result = safe_query($con, "SELECT COALESCE(SUM(O_PRICE), 0) as total FROM orders");
if($result && $row = mysqli_fetch_assoc($result)) {
    $total_revenue = $row['total'] ?? 0;
}

// ============================================
// QUERY RESULTS
// ============================================
$orders_result = safe_query($con, "
    SELECT o.O_ID, o.O_DATE, o.B_ID, o.S_ID, o.I_CODE, o.O_PRICE,
           c1.C_NAME as buyer_name, c1.C_EMAIL as buyer_email,
           c2.C_NAME as seller_name, c2.C_EMAIL as seller_email,
           i.I_NAME as item_name, i.I_PRICE
    FROM orders o
    LEFT JOIN client c1 ON o.B_ID = c1.C_ID
    LEFT JOIN client c2 ON o.S_ID = c2.C_ID
    LEFT JOIN item i ON o.I_CODE = i.I_CODE
    ORDER BY o.O_DATE DESC
    LIMIT 20
");

$sold_items_result = safe_query($con, "
    SELECT i.I_CODE, i.C_ID, i.CAT_NAM, i.I_NAME, i.I_IMAGE, i.I_DATE, i.I_PRICE, i.SELL_STATUS,
           c.C_NAME as seller_name, c.C_EMAIL as seller_email
    FROM item i
    LEFT JOIN client c ON i.C_ID = c.C_ID
    WHERE i.SELL_STATUS='Y'
    ORDER BY i.I_CODE DESC
    LIMIT 15
");

$top_sellers_result = safe_query($con, "
    SELECT c.C_ID, c.C_NAME, c.C_EMAIL,
           COUNT(DISTINCT i.I_CODE) as items_sold,
           COALESCE(SUM(i.I_PRICE), 0) as total_value
    FROM client c
    LEFT JOIN item i ON c.C_ID = i.C_ID AND i.SELL_STATUS='Y'
    GROUP BY c.C_ID, c.C_NAME, c.C_EMAIL
    HAVING items_sold > 0
    ORDER BY items_sold DESC
    LIMIT 10
");

$category_stats_result = safe_query($con, "
    SELECT CAT_NAM,
           COUNT(*) as total_items,
           SUM(CASE WHEN SELL_STATUS='Y' THEN 1 ELSE 0 END) as sold_items
    FROM item
    GROUP BY CAT_NAM
    ORDER BY total_items DESC
");

$monthly_orders_result = safe_query($con, "
    SELECT DATE_FORMAT(O_DATE, '%b %Y') as month,
           COUNT(*) as order_count,
           COALESCE(SUM(O_PRICE), 0) as monthly_revenue
    FROM orders
    GROUP BY DATE_FORMAT(O_DATE, '%Y-%m')
    ORDER BY O_DATE DESC
    LIMIT 6
");

$payment_methods_result = safe_query($con, "
    SELECT
           'Razorpay' as method,
           COUNT(*) as count,
           COALESCE(SUM(O_PRICE),0) as total
    FROM orders
");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Dashboard </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #BC8F8F;
            --secondary: #DEB887;
            --accent: #ff3f6c;
            --dark: #2f261e;
            --light: #f5f5f5;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1e1e2e 0%, #2d2d3d 100%);
            color: #333;
            min-height: 100vh;
            padding: 20px;
        }

        /* HEADER */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background: white;
            padding: 20px 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            animation: slideDown 0.5s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .header h1 {
            font-size: 28px;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-right {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .logout-btn {
            background: var(--accent);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
            font-weight: 600;
        }

        .logout-btn:hover {
            background: #e63a5c;
            transform: translateY(-2px);
        }

        /* STATS GRID */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-left: 5px solid var(--primary);
            transition: all 0.3s ease;
            animation: slideUp 0.6s ease;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .stat-card.orders { border-left-color: var(--info); }
        .stat-card.sold { border-left-color: var(--success); }
        .stat-card.available { border-left-color: var(--warning); }
        .stat-card.revenue { border-left-color: var(--accent); }

        .stat-icon {
            font-size: 32px;
            margin-bottom: 10px;
            color: var(--primary);
        }

        .stat-label {
            font-size: 13px;
            color: #666;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 36px;
            font-weight: bold;
            color: var(--dark);
            margin: 10px 0;
        }

        .stat-change {
            font-size: 12px;
            color: var(--success);
        }

        /* SECTIONS */
        .section {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .section h2 {
            font-size: 22px;
            color: var(--dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 2px solid var(--light);
            padding-bottom: 15px;
        }

        /* TABLES */
        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: linear-gradient(135deg, #f5f5f5, #efefef);
        }

        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: var(--dark);
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }

        tbody tr:hover {
            background: #f9f9f9;
        }

        /* BADGES */
        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-sold { background: #dcfce7; color: #166534; }
        .badge-completed { background: #dbeafe; color: #0c4a6e; }

        /* PRICES */
        .price {
            color: var(--success);
            font-weight: 600;
        }

        /* CARDS */
        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .category-card {
            background: linear-gradient(135deg, #f5f5f5, #efefef);
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid var(--accent);
        }

        .category-card h4 {
            color: var(--dark);
            margin-bottom: 8px;
            font-size: 14px;
        }

        .category-stats {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            margin-bottom: 10px;
            color: #666;
        }

        .progress-bar {
            background: #ddd;
            height: 6px;
            border-radius: 3px;
            overflow: hidden;
        }

        .progress-fill {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            height: 100%;
            transition: width 0.3s;
        }

        /* SELLER CARDS */
        .seller-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .seller-card {
            background: linear-gradient(135deg, #f5f5f5, #efefef);
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid var(--primary);
        }

        .seller-card h4 {
            color: var(--dark);
            margin-bottom: 5px;
            font-size: 14px;
        }

        .seller-info {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            color: #666;
            margin-bottom: 10px;
        }

        .seller-stats {
            display: flex;
            gap: 20px;
            margin-top: 8px;
        }

        .seller-stat-label {
            font-size: 11px;
            color: #999;
            text-transform: uppercase;
        }

        .seller-stat-value {
            font-size: 16px;
            font-weight: bold;
            color: var(--primary);
        }
         /* admin */
         .admin-box{
  background:#fff;
  padding:25px;
  border-radius:15px;
  margin:30px 0;
  box-shadow:0 5px 15px rgba(0,0,0,.1);
  overflow-x:auto; /* important for mobile */
}

.admin-box h2{
  margin-bottom:20px;
}

/* FORM RESPONSIVE */
.admin-box form{
  display:flex;
  gap:15px;
  margin-bottom:20px;
  flex-wrap:wrap;
}

.admin-box input[type=text]{
  padding:10px;
  width:250px;
  max-width:100%;
  flex:1;
}

.admin-box input[type=file]{
  padding:8px;
  max-width:100%;
}

.admin-box button{
  background:#28a745;
  color:#fff;
  border:none;
  padding:10px 20px;
  cursor:pointer;
  border-radius:5px;
}

/* TABLE WRAPPER FOR MOBILE SCROLL */
.admin-box table{
  width:100%;
  border-collapse:collapse;
  min-width:600px; /* forces scroll instead of breaking layout */
}

.admin-box table th,
.admin-box table td{
  padding:12px;
  border:1px solid #ddd;
  text-align:center;
  font-weight:700;
  white-space:nowrap;
}

.admin-box img{
  border-radius:8px;
  max-width:60px;
  height:auto;
}

/* MOBILE FIX */
@media (max-width: 768px){
  .admin-box{
    padding:15px;
  }

  .admin-box form{
    flex-direction:column;
    align-items:stretch;
  }

  .admin-box button{
    width:100%;
  }

  .admin-box table{
    min-width:100%;
  }

  .admin-box table th,
  .admin-box table td{
    padding:8px;
    font-size:14px;
  }
}
        /* MONTHLY GRID */
        .monthly-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }

        .month-card {
            background: linear-gradient(135deg, var(--secondary), var(--primary));
            color: white;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
        }

        .month-name {
            font-size: 12px;
            opacity: 0.9;
            margin-bottom: 8px;
        }

        .month-orders {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .month-revenue {
            font-size: 13px;
            opacity: 0.9;
        }

        /* PAYMENT GRID */
        .payment-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
        }

        .payment-card {
            background: linear-gradient(135deg, #f5f5f5, #efefef);
            padding: 15px;
            border-radius: 10px;
            border-top: 3px solid var(--accent);
            text-align: center;
        }

        .payment-card h4 {
            color: var(--dark);
            margin-bottom: 8px;
            font-size: 13px;
        }

        .payment-count {
            font-size: 24px;
            font-weight: bold;
            color: var(--accent);
            margin-bottom: 5px;
        }

        .payment-amount {
            font-size: 12px;
            color: #666;
        }

        /* EMPTY STATE */
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .empty-state i {
            font-size: 48px;
            color: #ddd;
            margin-bottom: 15px;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            table {
                font-size: 12px;
            }

            th, td {
                padding: 8px;
            }

            .category-grid {
                grid-template-columns: 1fr;
            }

            .seller-grid {
                grid-template-columns: 1fr;
            }

            .monthly-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .payment-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <div class="header">
        <h1><i class="fas fa-chart-line"></i> Admin Dashboard</h1>
        <div class="header-right">
            <div style="color: #666;">Welcome, Admin</div>
            <a href="admin_logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <!-- STATISTICS CARDS -->
    <div class="stats-grid">
        <div class="stat-card orders">
            <div class="stat-icon"><i class="fas fa-shopping-cart"></i></div>
            <div class="stat-label">Total Orders</div>
            <div class="stat-value"><?php echo number_format($total_orders); ?></div>
            <div class="stat-change"><i class="fas fa-arrow-up"></i> All Time</div>
        </div>

        <div class="stat-card sold">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-label">Items Sold</div>
            <div class="stat-value"><?php echo number_format($total_sold); ?></div>
            <div class="stat-change"><i class="fas fa-arrow-up"></i> Completed</div>
        </div>

        <div class="stat-card available">
            <div class="stat-icon"><i class="fas fa-inbox"></i></div>
            <div class="stat-label">Items Available</div>
            <div class="stat-value"><?php echo number_format($total_available); ?></div>
            <div class="stat-change"><i class="fas fa-arrow-right"></i> Active</div>
        </div>

        <div class="stat-card revenue">
            <div class="stat-icon"><i class="fas fa-rupee-sign"></i></div>
            <div class="stat-label">Total Revenue</div>
            <div class="stat-value">₹<?php echo number_format($total_revenue, 2); ?></div>
            <div class="stat-change"><i class="fas fa-arrow-up"></i> Earnings</div>
        </div>
    </div>
  

    <div class="admin-box">
<h2>📂 Category Management</h2>
<form action="category_action.php" method="post" enctype="multipart/form-data">

<input type="text"
name="cat_name"
placeholder="Enter Category Name"
required>

<input type="file"
name="cat_image"
required>

<button type="submit" name="add_category">
Add Category
</button>

</form>
<br>
<table>
<tr>
<th>ID</th>
<th>Image</th>
<th>Category</th>
<th>Edit</th>
<th>Delete</th>
</tr>

<?php

$q=mysqli_query($con,"SELECT * FROM category ORDER BY CAT_ID ASC");

while($row=mysqli_fetch_assoc($q))
{

?>
<tr>
<td><?php echo $row['CAT_ID']; ?></td>
<td>
<img src="../assests/img/<?php echo $row['CAT_IMAGE']; ?>"
width="70">
</td>
<td><?php echo $row['CAT_NAM']; ?></td>
<td>
<a href="admin_dashboard.php?edit=<?php echo $row['CAT_ID']; ?>">
✏️
</a>

</td>
<td>
<a href="category_action.php?delete=<?php echo $row['CAT_ID']; ?>"
onclick="return confirm('Delete Category?')">
🗑️
</a>
</td>
</tr>
<?php
}
?>
</table>
</div>


    <!-- MONTHLY OVERVIEW -->
    <?php if($monthly_orders_result && mysqli_num_rows($monthly_orders_result) > 0): ?>
    <div class="section">
        <h2><i class="fas fa-calendar-alt"></i> Monthly Overview</h2>
        <div class="monthly-grid">
            <?php
            mysqli_data_seek($monthly_orders_result, 0);
            while($month = mysqli_fetch_assoc($monthly_orders_result)) {
                echo "
                <div class='month-card'>
                    <div class='month-name'>{$month['month']}</div>
                    <div class='month-orders'>{$month['order_count']}</div>
                    <div class='month-revenue'>₹" . number_format($month['monthly_revenue']) . "</div>
                </div>
                ";
            }
            ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- PAYMENT METHODS -->
    <?php if($payment_methods_result && mysqli_num_rows($payment_methods_result) > 0): ?>
    <div class="section">
        <h2><i class="fas fa-credit-card"></i> Payment Methods</h2>
        <div class="payment-grid">
            <?php
            mysqli_data_seek($payment_methods_result, 0);
            while($payment = mysqli_fetch_assoc($payment_methods_result)) {
                echo "
                <div class='payment-card'>
                    <h4>{$payment['method']}</h4>
                    <div class='payment-count'>{$payment['count']}</div>
                    <div class='payment-amount'>₹" . number_format($payment['total']) . "</div>
                </div>
                ";
            }
            ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- RECENT ORDERS -->
    <div class="section">
        <h2><i class="fas fa-history"></i> Recent Orders (Last 20)</h2>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Item Name</th>
                        <th>Buyer</th>
                        <th>Seller</th>
                        <th>Amount (₹)</th>
                        <th>Payment</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($orders_result && mysqli_num_rows($orders_result) > 0) {
                        while($order = mysqli_fetch_assoc($orders_result)) {
                            $buyer = $order['buyer_name'] ?? 'Unknown';
                            $seller = $order['seller_name'] ?? 'Unknown';
                            $item = $order['item_name'] ?? 'Deleted Item';
                            $payment = $order['Razorpay'] ?? 'N/A';
                            $date = isset($order['O_DATE']) ? date('d-m-Y', strtotime($order['O_DATE'])) : 'N/A';
                            
                            echo "
                            <tr>
                                <td><strong>#{$order['O_ID']}</strong></td>
                                <td>$date</td>
                                <td>$item</td>
                                <td>$buyer</td>
                                <td>$seller</td>
                                <td class='price'>₹" . number_format($order['O_PRICE'] ?? 0) . "</td>
                                <td><span class='badge badge-completed'>$payment</span></td>
                                <td><span class='badge badge-sold'>Completed</span></td>
                            </tr>
                            ";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='empty-state'><i class='fas fa-inbox'></i><p>No orders found</p></td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- SOLD ITEMS -->
    <div class="section">
        <h2><i class="fas fa-boxes"></i> Recently Sold Items (Last 15)</h2>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Item ID</th>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Seller</th>
                        <th>Email</th>
                        <th>Price (₹)</th>
                        <th>Date Sold</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($sold_items_result && mysqli_num_rows($sold_items_result) > 0) {
                        while($item = mysqli_fetch_assoc($sold_items_result)) {
                            $seller = $item['seller_name'] ?? 'Unknown';
                            $email = $item['seller_email'] ?? 'N/A';
                            $date = isset($item['I_DATE']) ? date('d-m-Y', strtotime($item['I_DATE'])) : 'N/A';
                            
                            echo "
                            <tr>
                                <td><strong>#{$item['I_CODE']}</strong></td>
                                <td>{$item['I_NAME']}</td>
                                <td><span class='badge badge-completed'>{$item['CAT_NAM']}</span></td>
                                <td>$seller</td>
                                <td><small>$email</small></td>
                                <td class='price'>₹" . number_format($item['I_PRICE'] ?? 0) . "</td>
                                <td>$date</td>
                            </tr>
                            ";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='empty-state'><i class='fas fa-inbox'></i><p>No sold items found</p></td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- TOP SELLERS -->
    <div class="section">
        <h2><i class="fas fa-star"></i> Top Sellers</h2>
        <?php
        if($top_sellers_result && mysqli_num_rows($top_sellers_result) > 0) {
            echo "<div class='seller-grid'>";
            while($seller = mysqli_fetch_assoc($top_sellers_result)) {
                $items_sold = $seller['items_sold'] ?? 0;
                $total_value = $seller['total_value'] ?? 0;
                
                echo "
                <div class='seller-card'>
                    <h4>👤 {$seller['C_NAME']}</h4>
                    <div class='seller-info'>
                        <small>{$seller['C_EMAIL']}</small>
                        <small><strong>ID:</strong> {$seller['C_ID']}</small>
                    </div>
                    <div class='seller-stats'>
                        <div>
                            <div class='seller-stat-label'>Items Sold</div>
                            <div class='seller-stat-value'>$items_sold</div>
                        </div>
                        <div>
                            <div class='seller-stat-label'>Total Value</div>
                            <div class='seller-stat-value'>₹" . number_format($total_value) . "</div>
                        </div>
                    </div>
                </div>
                ";
            }
            echo "</div>";
        } else {
            echo "<div class='empty-state'><i class='fas fa-user-slash'></i><p>No sellers with sold items</p></div>";
        }
        ?>
    </div>

    <!-- CATEGORY STATISTICS -->
    <div class="section">
        <h2><i class="fas fa-th-large"></i> Category Statistics</h2>
        <?php
        if($category_stats_result && mysqli_num_rows($category_stats_result) > 0) {
            echo "<div class='category-grid'>";
            while($category = mysqli_fetch_assoc($category_stats_result)) {
                $total = $category['total_items'] ?? 0;
                $sold = $category['sold_items'] ?? 0;
                $percentage = $total > 0 ? ($sold / $total * 100) : 0;
                
                echo "
                <div class='category-card'>
                    <h4>{$category['CAT_NAM']}</h4>
                    <div class='category-stats'>
                        <span><strong>$total</strong> Total</span>
                        <span><strong>$sold</strong> Sold</span>
                    </div>
                    <div class='progress-bar'>
                        <div class='progress-fill' style='width: {$percentage}%;'></div>
                    </div>
                    <small style='color: #999;'>" . round($percentage, 1) . "%</small>
                </div>
                ";
            }
            echo "</div>";
        } else {
            echo "<div class='empty-state'><i class='fas fa-tag'></i><p>No categories found</p></div>";
        }
        ?>
    </div>

    <!-- FOOTER -->
    <div style="text-align: center; padding: 20px; color: #999; font-size: 12px; margin-top: 50px;">
        <p>© 2026 SecondHand-Bazaar Admin Dashboard | Last Updated: <?php echo date('d-m-Y H:i:s'); ?></p>
    </div>

</body>
</html>

<?php
mysqli_close($con);
?>