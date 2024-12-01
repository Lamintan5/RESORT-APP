async function fetchResorts() {
    try {
        const response = await fetch('fetch_resorts.php');
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        const result = await response.json();
        if (result.success) {
            const tableBody = document.querySelector('#resorts-table tbody');
            tableBody.innerHTML = ''; // Clear existing rows
            result.data.forEach(resort => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${resort.id}</td>
                    <td>${resort.title}</td>
                    <td>${resort.location}</td>
                    <td>${resort.description}</td>
                    <td>${resort.status}</td>
                    <td>${resort.price}</td>
                    <td>
                        <button class="edit-btn" data-id="${resort.id}"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="delete-btn" data-id="${resort.id}"><i class="fa-solid fa-trash"></i></button>
                    </td>
                `;
                tableBody.appendChild(row);
            });

            document.querySelector('#resorts-table').addEventListener('click', event => {
                // Identify if the clicked element or its parent is the 'edit-btn'
                const button = event.target.closest('.edit-btn');
                if (button) {
                    const id = button.getAttribute('data-id');
                    if (id) {
                        editResort(id);
                    } else {
                        console.error('Error: Edit button clicked, but no data-id attribute found.');
                    }
                }
            });
            

            

            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', event => {
                    const id = event.target.getAttribute('data-id');
                    deleteResort(id);
                });
            });
        } else {
            alert(`Error fetching resorts: ${result.message}`);
        }
    } catch (error) {
        console.error('Error fetching resorts:', error);
    }
}

// Call fetchResorts on page load
fetchResorts();

function openModal() {
    document.getElementById('addResortModel').style.display = 'flex';
}

function closeModal() {
    document.getElementById('addResortModel').style.display = 'none';
}

document.getElementById('addResortForm').addEventListener('submit', async function (e) {
e.preventDefault();
const formData = new FormData(this);
try {
    const response = await fetch('add_resort.php', {
        method: 'POST',
        body: formData,
    });

    if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
    }

    const result = await response.json();
    if (result.success) {
        alert('Resort added successfully');
        closeModal();
        fetchResorts();
    } else {
        alert(`Error: ${result.message}`);
    }
} catch (error) {
    console.error('Error adding Resort:', error);
    alert('An error occurred. Please check the console for details.');
}
});

async function deleteResort(id) {
    if (!confirm('Are you sure you want to delete this resort?')) return;

    try {
        const response = await fetch('delete_resort.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${id}`,
        });
        const result = await response.json();
        if (result.success) {
            alert('Resort deleted successfully');
            fetchResorts(); // Refresh the table
        } else {
            alert(`Error deleting resort: ${result.message}`);
        }
    } catch (error) {
        console.error('Error deleting resort:', error);
    }
}


// Editing 


function openEditModal(resort) {
    // Pre-fill the form with resort data
    document.getElementById('edit-id').value = resort.id;
    document.getElementById('edit-title').value = resort.title;
    document.getElementById('edit-location').value = resort.location;
    document.getElementById('edit-price').value = resort.price;
    document.getElementById('edit-description').value = resort.description;

    // Open the modal
    document.getElementById('editResortModal').style.display = 'flex';
}

function closeEditModal() {
    document.getElementById('editResortModal').style.display = 'none';
}

document.getElementById('editResortForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    try {
        const response = await fetch('update_resort.php', {
            method: 'POST',
            body: formData,
        });

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const result = await response.json();
        if (result.success) {
            alert('Resort updated successfully');
            closeEditModal();
            fetchResorts(); // Refresh the table
        } else {
            alert(`Error: ${result.message}`);
        }
    } catch (error) {
        console.error('Error updating resort:', error);
        alert('An error occurred. Please check the console for details.');
    }
});

// Edit button click handler
async function editResort(id) {
    try {
        const response = await fetch(`fetch_single_resort.php?id=${id}`);
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        const result = await response.json();
        if (result.success) {
            openEditModal(result.data);
        } else {
            alert(`Error fetching resort details: ${result.message}`);
        }
    } catch (error) {
        console.error('Error fetching resort details:', error);
    }
}

