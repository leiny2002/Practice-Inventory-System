<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory System Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .header {
            background-color: #4285f4;
            color: #ffffff;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dashboard-title {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }

        .logout-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4285f4;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-right: 10px;
        }

        .logout-button:hover {
            background-color: #3367d6;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 40px;
        }

        .statistic-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            grid-gap: 30px;
        }

        .statistic-card {
            background-color: #f8f8f8;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .statistic-icon {
            font-size: 36px;
            color: #4285f4;
            margin-bottom: 10px;
        }

        .statistic-label {
            font-size: 14px;
            font-weight: bold;
            color: #333333;
            margin-bottom: 5px;
        }

        .statistic-value {
            font-size: 24px;
            font-weight: bold;
            color: #555555;
        }

        .category-container {
            display: flex;
            justify-content: center;
            margin-top: 40px;
            border-top: 1px solid #ccc;
            padding-top: 20px;
        }

        .category-card {
            background-color: #f8f8f8;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            color: #333333;
            margin: 0 10px;
        }

        .category-card:hover {
            background-color: #e0e0e0;
        }

        .category-card .statistic-icon {
            color: #555555;
        }

        .category-card .statistic-label {
            margin-bottom: 0;
            text-decoration: none;
        }

        .footer {
            background-color: #f0f0f0;
            text-align: center;
            padding: 10px;
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1 class="dashboard-title">Inventory System Dashboard</h1>
        <a href="Login.php" class="logout-button">Logout <i class="fas fa-sign-out-alt"></i></a>
    </div>

    <div class="container">
        <div class="statistic-grid">
            <div class="statistic-card">
                <div class="statistic-icon"><i class="fas fa-calendar"></i></div>
                <div class="statistic-label">Items Listed This Week</div>
                <div class="statistic-value">
                    <?php include('week_list.php'); echo getItemsListedThisWeekCount(); ?>
                </div>
            </div>

            <div class="statistic-card">
                <div class="statistic-icon"><i class="fas fa-box"></i></div>
                <div class="statistic-label">Total Items</div>
                <div class="statistic-value">
                    <?php include('total_list.php'); echo getTotalItemCount(); ?>
                </div>
            </div>

            <div class="statistic-card">
                <div class="statistic-icon"><i class="fas fa-users"></i></div>
                <div class="statistic-label">Users</div>
                <div class="statistic-value">
                    <?php include 'total_user.php'; echo getUserCount(); ?>
                </div>
            </div>
        </div>

        <div class="category-container">
            <a href="Tech-Dev-Inv/technological-devices-inventory.php" class="category-card">
                <div class="statistic-icon"><i class="fas fa-laptop"></i></div>
                <div class="statistic-label">Technological Devices</div>
            </a>

            <a href="Food-Stor-Inv/food-storage-inventory.php" class="category-card">
                <div class="statistic-icon"><i class="fas fa-hamburger"></i></div>
                <div class="statistic-label">Food Storage</div>
            </a>

            <a href="Clean-Mat-Inv/cleaning-materials-inventory.php" class="category-card">
                <div class="statistic-icon"><i class="fas fa-broom"></i></div>
                <div class="statistic-label">Cleaning Materials</div>
            </a>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>

</html>
