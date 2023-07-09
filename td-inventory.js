document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.list-section').addEventListener('click', function(event) {
      const target = event.target;
      if (target.classList.contains('edit')) {
        const itemId = target.getAttribute('data-item-id');
        openEditModal(itemId);
      } else if (target.classList.contains('remove')) {
        const itemId = target.getAttribute('data-item-id');
        removeItem(itemId);
      }
    });

    function openEditModal(itemId) {
        // Retrieve the item details using AJAX and populate the modal with the data
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_item.php?id=' + encodeURIComponent(itemId), true);
        xhr.onreadystatechange = function() {
          if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
              const contentType = xhr.getResponseHeader("content-type");
              if (contentType && contentType.indexOf("application/json") !== -1) {
                const response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                  const item = response.data;
                  // Populate the modal fields with the retrieved data
                  document.getElementById('edit-item-id').value = item.id;
                  document.getElementById('edit-equipment-id').value = item.equipment_id;
                  document.getElementById('edit-equipment-type').value = item.equipment_type;
                  document.getElementById('edit-product-model').value = item.product_model;
                  document.getElementById('edit-supplier').value = item.supplier;
                  document.getElementById('edit-serial-number').value = item.serial_number;
                  document.getElementById('edit-end-user').value = item.end_user;
                  
                  // Show the edit item modal
                  document.getElementById('edit-item-modal').style.display = 'block';
                } else {
                  console.error('Error retrieving item:', response.message);
                }
              } else {
                console.error('Invalid response format. Expected JSON.');
              }
            } else {
              console.error('Error retrieving item. Server returned status:', xhr.status);
            }
          }
        };
        xhr.send();
      }

      document.getElementById('edit-item-modal-close').addEventListener('click', function() {
    // Close the edit item modal when the close button is clicked
    document.getElementById('edit-item-modal').style.display = 'none';
  });

    function removeItem(itemId) {
      if (confirm("Are you sure you want to remove this item?")) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'remove_item.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
          if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            console.log(xhr.responseText);
            if (xhr.responseText === 'success') {
              // Reload the page if the item is successfully removed
              window.location.reload();
            }
          }
        };
        xhr.send('id=' + encodeURIComponent(itemId));
      }
    }

    document.querySelector('.add-item-btn').addEventListener('click', function() {
      // Show the add item modal
      document.getElementById('add-item-modal').style.display = 'block';
    });

    // Close the modal when the close button is clicked
    document.querySelector('.close').addEventListener('click', function() {
      document.getElementById('add-item-modal').style.display = 'none';
    });

    // Handle form submission for adding a new item
    document.getElementById('add-item-form').addEventListener('submit', function(e) {
      e.preventDefault();

      // Get form values
      const equipmentId = document.getElementById('equipment-id').value;
      const equipmentType = document.getElementById('equipment-type').value;
      const productModel = document.getElementById('product-model').value;
      const supplier = document.getElementById('supplier').value;
      const serialNumber = document.getElementById('serial-number').value;
      const endUser = document.getElementById('end-user').value;

      // Create an AJAX request
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'add_item.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
          console.log(xhr.responseText);
          if (xhr.responseText === 'success') {
            window.location.reload(); // Reload the page if the response is 'success'
          }
        }
      };
      // Send the request
      xhr.send(
        'equipment_id=' + encodeURIComponent(equipmentId) +
        '&equipment_type=' + encodeURIComponent(equipmentType) +
        '&product_model=' + encodeURIComponent(productModel) +
        '&supplier=' + encodeURIComponent(supplier) +
        '&serial_number=' + encodeURIComponent(serialNumber) +
        '&end_user=' + encodeURIComponent(endUser)
      );

      // Clear form values
      document.getElementById('equipment-id').value = '';
      document.getElementById('equipment-type').value = '';
      document.getElementById('product-model').value = '';
      document.getElementById('supplier').value = '';
      document.getElementById('serial-number').value = '';
      document.getElementById('end-user').value = '';

      // Close the add item modal
      document.getElementById('add-item-modal').style.display = 'none';
    });

    // Handle form submission for editing an item
    document.getElementById('edit-item-form').addEventListener('submit', function(e) {
      e.preventDefault();

      // Get form values
      const itemId = document.getElementById('edit-item-id').value;
      const equipmentId = document.getElementById('edit-equipment-id').value;
      const equipmentType = document.getElementById('edit-equipment-type').value;
      const productModel = document.getElementById('edit-product-model').value;
      const supplier = document.getElementById('edit-supplier').value;
      const serialNumber = document.getElementById('edit-serial-number').value;
      const endUser = document.getElementById('edit-end-user').value;

      // Create an AJAX request
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'edit_item.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
          console.log(xhr.responseText);
          if (xhr.responseText === 'success') {
            // Close the edit item modal and reload the page
            document.getElementById('edit-item-modal').style.display = 'none';
            window.location.reload();
          }
        }
      };
      // Send the request
      xhr.send(
        'id=' + encodeURIComponent(itemId) +
        '&equipment_id=' + encodeURIComponent(equipmentId) +
        '&equipment_type=' + encodeURIComponent(equipmentType) +
        '&product_model=' + encodeURIComponent(productModel) +
        '&supplier=' + encodeURIComponent(supplier) +
        '&serial_number=' + encodeURIComponent(serialNumber) +
        '&end_user=' + encodeURIComponent(endUser)
      );
    });
  });