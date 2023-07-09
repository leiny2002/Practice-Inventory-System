document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.querySelector('.search-input');
    const searchBtn = document.querySelector('.search-btn');
    const itemListContainer = document.getElementById('item-list-container');

    // Function to update the item list container with the search results
    function updateItemList(items) {
        itemListContainer.innerHTML = ''; // Clear existing item list

        if (items.length === 0) {
            // Display a message if no items match the search query
            const message = document.createElement('p');
            message.textContent = 'No items found.';
            itemListContainer.appendChild(message);
        } else {
            // Generate HTML for each item and append to the container
            items.forEach(function (item) {
                const listItem = document.createElement('div');
                listItem.className = 'list';
                listItem.innerHTML = `
          <div class="list-info">${item.equipment_id}</div>
          <div class="list-info">${item.equipment_type}</div>
          <div class="list-info">${item.product_model}</div>
          <div class="list-info">${item.supplier}</div>
          <div class="list-info">${item.serial_number}</div>
          <div class="list-info">${item.end_user}</div>
          <div class="list-actions">
            <button class="edit" data-item-id="${item.id}">Edit</button>
            <button class="remove" data-item-id="${item.id}">Remove</button>
          </div>
        `;
                itemListContainer.appendChild(listItem);
            });
        }
    }

    // Function to handle the search button click event
    function handleSearch() {
        const searchTerm = searchInput.value.trim();
        if (searchTerm === '') {
            // If search term is empty, reload the page to show default list
            window.location.reload();
        } else {
            // Perform AJAX request to fetch the search results
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'search_items.php?search=' + encodeURIComponent(searchTerm), true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    const contentType = xhr.getResponseHeader('content-type');
                    if (contentType && contentType.indexOf('application/json') !== -1) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.status === 'success') {
                            updateItemList(response.data);
                        } else {
                            console.error('Error retrieving search results:', response.message);
                        }
                    } else {
                        console.error('Invalid response format. Expected JSON.');
                    }
                }
            };
            xhr.send();
        }
    }

    // Add event listener for search button click
    searchBtn.addEventListener('click', handleSearch);

    // Add event listener for Enter key press in the search input
    searchInput.addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            handleSearch();
        }
    });

    document.querySelector('.list-section').addEventListener('click', function (event) {
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
        xhr.onreadystatechange = function () {
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

    document.getElementById('edit-item-modal-close').addEventListener('click', function () {
        // Close the edit item modal when the close button is clicked
        document.getElementById('edit-item-modal').style.display = 'none';
    });

    function removeItem(itemId) {
        if (confirm("Are you sure you want to remove this item?")) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'remove_item.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
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

    document.querySelector('.add-item-btn').addEventListener('click', function () {
        // Show the add item modal
        document.getElementById('add-item-modal').style.display = 'block';
    });

    // Close the modal when the close button is clicked
    document.querySelector('.close').addEventListener('click', function () {
        document.getElementById('add-item-modal').style.display = 'none';
    });

    // Handle form submission for adding a new item
    document.getElementById('add-item-form').addEventListener('submit', function (e) {
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
        xhr.onreadystatechange = function () {
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
    document.getElementById('edit-item-form').addEventListener('submit', function (e) {
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
        xhr.onreadystatechange = function () {
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