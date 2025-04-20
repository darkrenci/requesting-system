function generateDocument(requestId, residentId) {
    let url = '';
    switch (requestId) {
        case 'barangayClearance':
            url = `barangaypdf.php?requestId=${requestId}&residentId=${residentId}`;
            break;
        case 'businessClearance':
            url = `businesspdf.php?requestId=${requestId}&residentId=${residentId}`;
            break;
        case 'indigency':
            url = `certofindigency.php?requestId=${requestId}&residentId=${residentId}`;
            break;
        case 'residency':
            url = `certofresidency.php?requestId=${requestId}&residentId=${residentId}`;
            break;
        default:
            console.error(`Unknown request type: ${requestId}`);
    }
    window.open(url, '_blank');

    logDocumentGeneration(requestId);
}
function logDocumentGeneration(requestId) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'log_document_generation.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            console.log('Document generation logged successfully.');
        } else {
            console.error('Failed to log document generation.');
        }
    };
    xhr.send(`requestId=${requestId}`);
}

document.addEventListener('DOMContentLoaded', function() {
    const generateBtns = document.querySelectorAll('.generate-btn');
  
    generateBtns.forEach(btn => {
      btn.addEventListener('click', function() {
        const requestId = btn.dataset.requestId;
        const residentId = btn.dataset.residentId;
        const requestType = btn.dataset.requestType;
  
        let url = '';
        switch (requestType) {
          case 'barangayClearance':
            url = `barangaypdf.php?requestId=${requestId}&residentId=${residentId}`;
            break;
          case 'businessClearance':
            url = `businesspdf.php?requestId=${requestId}&residentId=${residentId}`;
            break;
          case 'indigency':
            url = `certofindigencypdf.php?requestId=${requestId}&residentId=${residentId}`;
            break;
          case 'residency':
            url = `certofresidency.php?requestId=${requestId}&residentId=${residentId}`;
            break;
          default:
            console.error(`Unknown request type: ${requestType}`);
        }
        window.open(url, '_blank');
      });
    });
  });
function downloadFile(url, fileName) {
    const a = document.createElement('a');
    a.href = url;
    a.download = fileName;
    a.style.display = 'none';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}

function updateRequestDetails(_requestId, data) {
    const requestDetails = document.getElementById("requestDetails");
    requestDetails.style.display = 'block';

    const groupedData = data.reduce((acc, row) => {
        if (!acc[row.request_type]) {
            acc[row.request_type] = [];
        }
        acc[row.request_type].push(row);
        return acc;
    }, {});

    requestDetails.innerHTML = Object.keys(groupedData).map(type => `
        <div class="requestDetails-container">
            <center><table>
                <thead>
                    <tr>
                        ${Object.keys(groupedData[type][0]).map(key => `<th>${key}</th>`).join('')}
                        <th>Remarks</th>
                        <th>Generate Document</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    ${groupedData[type].map(row => `
                        <tr id="row-${type}-${row.resident_id}">
                            ${Object.values(row).map(value => `<td>${value}</td>`).join('')}
                            <td>
                                <textarea class="px-1" name="remarks" id="remarks-${type}-${row.resident_id}"></textarea>
                                <button class="btn btn-primary post-remarks" type="button" data-resident-id="${row.resident_id}" data-request-id="${_requestId}" data-type="${type}">Post</button>
                            </td>

                            <td>
                                <center><button class="generate-btn" style="background-color: #0056b3; border: none; color: white; border-radius: 5px; cursor: pointer;" data-request-id="${_requestId}" data-resident-id="${row.resident_id}">Generate Document</button></center>
                            </td>
                            <td>
                                <button class="delete-btn" style="background-color: #CC0000; padding:10px; border: none; color: white; border-radius: 5px; cursor: pointer;" data-request-id="${_requestId}" data-resident-id="${row.resident_id}">Delete</button>
                            </td>
                        </tr>
                    `).join('')}
                </tbody>
            </table></center>
        </div>
    `).join('');

    // Add event listeners to the buttons after the HTML is set
    const generateButtons = document.querySelectorAll('.generate-btn');
    generateButtons.forEach(button => {
        button.addEventListener('click', function() {
            const requestId = this.getAttribute('data-request-id');
            const residentId = this.getAttribute('data-resident-id');

            // Debugging: log the values retrieved
            console.log('Generate button clicked:', { requestId, residentId });

            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('modalSerialNum'));
            modal.show();

            // Optionally handle the confirmation button click
            document.getElementById('confirmButton').onclick = function() {
                generateDocument(requestId, residentId); // Call your function here
                modal.hide(); // Hide the modal after confirmation
            };
        });
    });


    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const requestId = this.getAttribute('data-request-id');
            const residentId = this.getAttribute('data-resident-id');

            alert('Delete button clicked:' + requestId, { requestId, residentId });

            deleteRequest(requestId, residentId);
        });
    });

    // Attach event listeners to each "Post" button
    document.querySelectorAll('.post-remarks').forEach(button => {
        button.addEventListener('click', function() {
            const residentId = this.getAttribute('data-resident-id');
            const requestId = this.getAttribute('data-request-id'); // Get the requestId from data attribute
            const type = this.getAttribute('data-type'); // Get the type from data attribute
            const textarea = document.getElementById(`remarks-${type}-${residentId}`);
            const remarksValue = textarea.value;

            console.log("Remarks for resident ID " + residentId + ": " + remarksValue + ", Request ID: " + requestId);
            // You can now use remarksValue and requestId as needed, e.g., send it to your server
        });
    });

}


function deleteRequest(requestId, residentId) {
    // Ask for confirmation before proceeding with the deletion
    if (confirm("Are you sure you want to delete this request?")) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete_request.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            console.log('Response received:', xhr.responseText); // Debugging: Log the full response
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        console.log('Request deleted successfully.');
                        // Remove the deleted row from the table
                        const row = document.getElementById(`row-${requestId}-${residentId}`);
                        if (row) {
                            row.parentNode.removeChild(row);
                        }
                    } else {
                        console.error('Failed to delete request:', response.message);
                    }
                } catch (e) {
                    console.error('Failed to parse JSON response:', e);
                }
            } else {
                console.error('Failed to delete request. Status:', xhr.status);
            }
        };

        // Send the request with requestId and residentId as parameters
        xhr.send(`request_id=${requestId}&resident_id=${residentId}`);
    }
}







document.addEventListener("DOMContentLoaded", function() {
    const sections = document.querySelectorAll(".content-section");
    const links = document.querySelectorAll(".sidebar ul li a");
    const requestBoxes = document.querySelectorAll(".request-box");
// Fetch logs data

  // Call fetchLogsData when the logs section is clicked
  document.getElementById("logsLink").addEventListener("click", function(event) {
    event.preventDefault();
    fetchLogsData();
  });
    document.addEventListener('change', function(event) {
        if (event.target.classList.contains('queue-status-dropdown')) {
            const requestId = event.target.getAttribute('data-request-id');
            const newStatus = event.target.value;
            const table = event.target.getAttribute('data-table');
            updateRequestStatus(requestId, newStatus, table);
        }
    });

    function updateRequestStatus(requestId, newStatus, table) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "update_status.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert("Status updated successfully");
                fetchSectionData("docRequest"); // Refresh the request list
            } else {
                alert("Failed to update status");
            }
        };
        xhr.send(`requestId=${requestId}&status=${newStatus}&table=${table}`);
    }

    // Function to switch sections
    function switchSection(event, sectionId) {
        event.preventDefault();

        // Hide all sections
        sections.forEach(section => {
            section.classList.remove("active");
        });

        // Show the clicked section
        document.getElementById(sectionId).classList.add("active");

        // Highlight the active link
        links.forEach(link => {
            link.classList.remove("active");
        });
        event.target.classList.add("active");

        // Fetch data for the section
        fetchSectionData(sectionId);
    }

    // Event listeners for navigation links
    links.forEach(link => {
        link.addEventListener("click", function(event) {
            const sectionId = link.id.replace("Link", "");
            switchSection(event, sectionId);
        });
    });

    // Event listeners for document request boxes
    requestBoxes.forEach(box => {
        box.addEventListener("click", function() {
            const requestId = box.id.replace("Requests", "");
            fetchDocumentDetails(requestId);
        });
    });

    // Fetch data for the selected section
    function fetchSectionData(sectionId) {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", `fetch_data.php?section=${sectionId}`, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                updateSection(sectionId, response);
            }
        };
        xhr.send();
    }
    
    // Function to update request status
    function updateRequestStatus(requestId, newStatus, table) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "update_status.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert("Status updated successfully");
                fetchSectionData("docRequest"); // Refresh the request list
            } else {
                alert("Failed to update status");
            }
        };
        xhr.send(`requestId=${requestId}&status=${newStatus}&table=${table}`);
    }
    

    
    
    window.showUpdateForm = function(requestId) {
        document.getElementById("updateRequestId").value = requestId;
        document.getElementById("requestUpdateForm").style.display = 'block';
    };

    // Fetch details for a specific document request
    // Update the section content
    function updateSection(sectionId, data) {
        if (sectionId === "dashboard") {
            document.getElementById("numUsers").innerHTML = `Users: ${data.numUsers}`;
            document.getElementById("numBarangayClearance").innerHTML = `Barangay Clearance Requests: ${data.numBarangayClearance}`;
            document.getElementById("numBusinessClearance").innerHTML = `Business Clearance Requests: ${data.numBusinessClearance}`;
            document.getElementById("numIndigency").innerHTML = `Certificate of Indigency Requests: ${data.numIndigency}`;
            document.getElementById("numResidency").innerHTML = `Certificate of Residency Requests: ${data.numResidency}`;
            document.getElementById("numMaleUsers").innerHTML = `Male Users: ${data.numMale}`;
            document.getElementById("numFemaleUsers").innerHTML = `Female Users: ${data.numFemale}`;
        } else if (sectionId === "docRequest") {
            updateRequestList("barangayClearanceRequests", data.barangayClearance);
            updateRequestList("businessClearanceRequests", data.businessClearance);
            updateRequestList("indigencyRequests", data.indigency);
            updateRequestList("residencyRequests", data.residency);
        } else if (sectionId === "listUsers") {
            updateUserList(data.users);
        } else if (sectionId === "logs") {
            document.getElementById("logList").innerHTML = data.logs.map(log => `<div>${log}</div>`).join('');
        } else if (sectionId === "pollSystem") {
            // Since pollSystem content is already in newAdmin.php, no need to fetch
            // Just ensure the section is shown by switchSection function
            // Optionally, you can clear or update content here if needed
            console.log("Poll System section activated");
        }
    }

    // Update the document request list
    function updateRequestList(listId, requests) {
        const container = document.getElementById(listId);
        container.innerHTML = requests.map(request => `<div>${request}</div>`).join('');
    } 
    function fetchDocumentDetails(requestId) {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", `fetch_data.php?section=docDetails&requestId=${requestId}`, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                let typeId;
                switch (response.request_type) {
                    case 'barangay clearance':
                        typeId = 'barangay_clearance';
                        break;
                    case 'business clearance':
                        typeId = 'business_clearance';
                        break;
                    case 'indigency':
                        typeId = 'indigency';
                        break;
                    case 'residency':
                        typeId = 'residency';
                        break;
                    default:
                        typeId = ''; // default or unknown type
                }
                updateRequestDetails(requestId, response, typeId);
            }
        };
        xhr.send();
    }

    

    
// For getGenerateButton functi


    
    

    

    // Update the user list
    function updateUserList(users) {
        const userList = document.getElementById("userList");
        userList.innerHTML = users.map(user => `
            <tr>
                <td>${user.id}</td>
                <td>${user.fname}</td>
                <td>${user.lname}</td>
                <td>${user.mname}</td>
                <td>${user.phone}</td>
                <td>${user.gender}</td>
                <td>${user.hnum}</td>
                <td>${user.street}</td>
                <td>${user.email}</td>
                <td>${user.birthday}</td>
            </tr>
        `).join('');
    }

    // Initially fetch dashboard data
    fetchSectionData('dashboard');
});
//...

// Fetch logs data


