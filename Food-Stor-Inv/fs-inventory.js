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
          <div class="list-info">${item.product_exp_date}</div>
          <div class="list-info">${item.product_name}</div>
          <div class="list-info">${item.supplier}</div>
          <div class="list-info">${item.date_bought}</div>
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
        xhr.open('GET', 'search_item.php?search=' + encodeURIComponent(searchTerm), true);
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

    // Sort direction constants
    const SORT_ASC = 'asc';
    const SORT_DESC = 'desc';

    // Get the list header elements
    const listHeaders = document.querySelectorAll('.list-title');

    // Function to sort the list by a specific column
    function sortList(columnIndex, sortDirection) {
        const items = Array.from(itemListContainer.getElementsByClassName('list'));

        // Sort the items based on the column value
        items.sort((a, b) => {
            const aColumnValue = a.getElementsByClassName('list-info')[columnIndex].textContent;
            const bColumnValue = b.getElementsByClassName('list-info')[columnIndex].textContent;
            return sortDirection === SORT_ASC
                ? aColumnValue.localeCompare(bColumnValue)
                : bColumnValue.localeCompare(aColumnValue);
        });

        // Clear the existing list
        itemListContainer.innerHTML = '';

        // Append the sorted items back to the list container
        items.forEach((item) => {
            itemListContainer.appendChild(item);
        });
    }

    // Function to toggle the sort direction and update the arrow icon
    function toggleSortDirection(headerElement) {
        const arrowElement = headerElement.querySelector('.arrow');
        const currentSortDirection = headerElement.getAttribute('data-sort');

        if (currentSortDirection === SORT_ASC) {
            headerElement.setAttribute('data-sort', SORT_DESC);
            arrowElement.textContent = '\u25BC'; // Down arrow
        } else {
            headerElement.setAttribute('data-sort', SORT_ASC);
            arrowElement.textContent = '\u25B2'; // Up arrow
        }
    }

    // Add click event listeners to list headers
    listHeaders.forEach((headerElement, columnIndex) => {
        headerElement.addEventListener('click', () => {
            const currentSortDirection = headerElement.getAttribute('data-sort');
            const newSortDirection = currentSortDirection === SORT_ASC ? SORT_DESC : SORT_ASC;

            toggleSortDirection(headerElement);
            sortList(columnIndex, newSortDirection);
        });
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
                            document.getElementById('edit-product-exp-date').value = item.product_exp_date;
                            document.getElementById('edit-product-name').value = item.product_name;
                            document.getElementById('edit-supplier').value = item.supplier;
                            document.getElementById('edit-date-bought').value = item.date_bought;

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
        const productExpDate = document.getElementById('product-exp-date').value;
        const productName = document.getElementById('product-name').value;
        const supplier = document.getElementById('supplier').value;
        const dateBought = document.getElementById('date-bought').value;

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
            'product_exp_date=' + encodeURIComponent(productExpDate) +
            '&product_name=' + encodeURIComponent(productName) +
            '&supplier=' + encodeURIComponent(supplier) +
            '&date_bought=' + encodeURIComponent(dateBought) 
        );

        // Clear form values
        document.getElementById('product-exp-date').value = '';
        document.getElementById('product-name').value = '';
        document.getElementById('supplier').value = '';
        document.getElementById('date-bought').value = '';

        // Close the add item modal
        document.getElementById('add-item-modal').style.display = 'none';
    });

    // Handle form submission for editing an item
    document.getElementById('edit-item-form').addEventListener('submit', function (e) {
        e.preventDefault();

        // Get form values
        const itemId = document.getElementById('edit-item-id').value;
        const productExpDate = document.getElementById('edit-product-exp-date').value;
        const productName = document.getElementById('edit-product-name').value;
        const supplier = document.getElementById('edit-supplier').value;
        const dateBought = document.getElementById('edit-date-bought').value;

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
            '&product_exp_date=' + encodeURIComponent(productExpDate) +
            '&product_name=' + encodeURIComponent(productName) +
            '&supplier=' + encodeURIComponent(supplier) +
            '&date_bought=' + encodeURIComponent(dateBought) 
        );
    });
});