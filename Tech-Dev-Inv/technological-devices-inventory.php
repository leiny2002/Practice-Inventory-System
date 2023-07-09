<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory View</title>
  <style>
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
      text-align: center;
    }

    .header-title {
      margin: 0;
    }

    .go-back-btn {
      position: absolute;
      top: 20px;
      left: 20px;
      font-size: 24px;
      color: #ffffff;
      text-decoration: none;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
      border: 2px solid #ddd;
      border-radius: 10px;
      background-color: #fff;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .category-search {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .category {
      display: flex;
      align-items: center;
    }

    .category-title {
      font-size: 18px;
      font-weight: bold;
      margin-right: 10px;
    }

    .search-bar {
      display: flex;
      align-items: center;
    }

    .search-input {
      padding: 5px;
      width: 200px;
      border-radius: 5px 0 0 5px;
      border: none;
    }

    .search-btn {
      padding: 5px 15px;
      background-color: #4285f4;
      color: #ffffff;
      border: none;
      border-radius: 0 5px 5px 0;
      cursor: pointer;
      transition: background-color 0.3s ease;
      text-decoration: none;
      font-size: 14px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .search-btn:hover {
      background-color: #3367d6;
    }

    .list-section {
      overflow-x: auto;
    }

    .list-header {
      display: flex;
      align-items: center;
      font-weight: bold;
      border-bottom: 1px solid #ddd;
    }

    .list-header .list-title {
      flex-basis: 16.66%;
      cursor: pointer;
      padding: 10px;
    }

    .list-header .list-title:hover {
      background-color: #f5f5f5;
    }

    .list-header .arrow {
      margin-left: 5px;
    }

    .list-info {
      flex-basis: 16.66%;
      padding: 10px;
    }

    .list {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
      border-bottom: 1px solid #ddd;
      position: relative;
    }

    .list:before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(255, 255, 255, 0.8);
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.3s ease;
      z-index: 1;
      transition: opacity 0.3s ease, filter 0.3s ease;
      filter: blur(0);
    }

    .list:hover:before,
    .list:focus:before {
      opacity: 1;
      filter: blur(2px);
    }

    .list-actions {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 2;
      display: none;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .list:hover .list-actions,
    .list:focus .list-actions {
      display: flex;
      opacity: 1;
    }

    .list-actions button {
      padding: 5px 10px;
      background-color: #4285f4;
      color: #ffffff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      text-decoration: none;
      font-size: 12px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .list-actions button:hover {
      background-color: #3367d6;
    }

    .list-actions .edit {
      background-color: #ffc107;
    }

    .list-actions .remove {
      background-color: #dc3545;
    }

    /* New styles */
    .add-item-btn {
      padding: 10px 20px;
      background-color: #4caf50;
      color: #ffffff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      text-decoration: none;
      font-size: 14px;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-top: 10px;
    }

    .add-item-btn:hover {
      background-color: #45a049;
    }

    /* Modal styles */
    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      padding: 20px;
      border: none;
      width: 80%;
      max-width: 400px;
      border-radius: 5px;
      position: relative;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .close {
      position: absolute;
      top: 10px;
      right: 10px;
      color: #aaa;
      font-size: 24px;
      font-weight: bold;
      cursor: pointer;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }

    .modal-header {
      border-bottom: 1px solid #ddd;
      padding-bottom: 10px;
      margin-bottom: 20px
    }
      
    .modal-header h2 {
      margin: 0;
    }

    .modal-body {
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 10px;
    }

    .form-group label {
      font-weight: bold;
      display: block;
      margin-bottom: 5px;
    }

    .form-group input[type="text"] {
      width: 100%;
      padding: 8px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }

    .form-actions {
      text-align: right;
    }

    .form-actions button {
      padding: 8px 20px;
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
    }

    .form-actions button:hover {
      background-color: #3367d6;
    }
  </style>
</head>

<body>
  <a href="http://localhost/Practice%20Inventory%20System/Dashboard.php" class="go-back-btn">&lt;</a>

  <div class="header">
    <h1 class="header-title">Technological Devices</h1>
  </div>

  <div class="container">
    <div class="category-search">
      <div>
        <button class="add-item-btn">Add Item</button>
      </div>

      <div class="search-bar">
        <input type="text" class="search-input" placeholder="Search...">
        <button class="search-btn">Search</button>
      </div>
    </div>

    <div class="list-header">
        <div class="list-title active" data-sort="asc">Equipment ID<span class="arrow">&#9650;</span></div>
        <div class="list-title" data-sort="asc">Equipment Type<span class="arrow">&#9650;</span></div>
        <div class="list-title" data-sort="asc">Product Model<span class="arrow">&#9650;</span></div>
        <div class="list-title" data-sort="asc">Supplier<span class="arrow">&#9650;</span></div>
        <div class="list-title" data-sort="asc">Serial Number<span class="arrow">&#9650;</span></div>
        <div class="list-title" data-sort="asc">End User<span class="arrow">&#9650;</span></div>
    </div>

    <div class="list-section" id="item-list-container">

      <?php
        include('list_fetcher.php')
      ?>

    </div>
  </div>

  <!-- Add Item Modal -->
<div id="add-item-modal" class="modal">
  <div class="modal-content">
    <span class="close" id="add-item-modal-close">&times;</span>
    <div class="modal-header">
      <h2>Add Item</h2>
    </div>
    <div class="modal-body">
      <form id="add-item-form" method="post">
        <div class="form-group">
          <label for="equipment-id">Equipment ID:</label>
          <input type="text" id="equipment-id" name="equipment_id" required>
        </div>
        <div class="form-group">
          <label for="equipment-type">Equipment Type:</label>
          <input type="text" id="equipment-type" name="equipment_type" required>
        </div>
        <div class="form-group">
          <label for="product-model">Product Model:</label>
          <input type="text" id="product-model" name="product_model" required>
        </div>
        <div class="form-group">
          <label for="supplier">Supplier:</label>
          <input type="text" id="supplier" name="supplier" required>
        </div>
        <div class="form-group">
          <label for="serial-number">Serial Number:</label>
          <input type="text" id="serial-number" name="serial_number" required>
        </div>
        <div class="form-group">
          <label for="end-user">End User:</label>
          <input type="text" id="end-user" name="end_user" required>
        </div>
        <div class="form-actions">
          <button type="submit" form="add-item-form" id="add-item-button">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Item Modal -->
<div id="edit-item-modal" class="modal">
  <div class="modal-content">
    <span class="close" id="edit-item-modal-close">&times;</span>
    <div class="modal-header">
      <h2>Edit Item</h2>
    </div>
    <div class="modal-body">
      <form id="edit-item-form" method="post">
        <input type="hidden" id="edit-item-id" name="id">
        <div class="form-group">
          <label for="edit-equipment-id">Equipment ID:</label>
          <input type="text" id="edit-equipment-id" name="equipment_id" required>
        </div>
        <div class="form-group">
          <label for="edit-equipment-type">Equipment Type:</label>
          <input type="text" id="edit-equipment-type" name="equipment_type" required>
        </div>
        <div class="form-group">
          <label for="edit-product-model">Product Model:</label>
          <input type="text" id="edit-product-model" name="product_model" required>
        </div>
        <div class="form-group">
          <label for="edit-supplier">Supplier:</label>
          <input type="text" id="edit-supplier" name="supplier" required>
        </div>
        <div class="form-group">
          <label for="edit-serial-number">Serial Number:</label>
          <input type="text" id="edit-serial-number" name="serial_number" required>
        </div>
        <div class="form-group">
          <label for="edit-end-user">End User:</label>
          <input type="text" id="edit-end-user" name="end_user" required>
        </div>
        <div class="form-actions">
          <button type="submit" form="edit-item-form" id="save-item-button">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>


  <script src="td-inventory.js"></script>


</body>

</html>
