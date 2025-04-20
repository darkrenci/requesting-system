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

function fetchLogsData() {
    console.log("Fetching logs data...");
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "fetch_logs.php", true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            console.log("Logs data fetched successfully");
            const response = JSON.parse(xhr.responseText);
            console.log("Response: ", response);
            if (response.logs) {
                updateLogsSection(response.logs);
            } else {
                console.error("Logs data is missing in the response.");
                document.getElementById("logList").innerHTML = '<p>No logs available.</p>';
            }
        } else {
            console.error("Error fetching logs: " + xhr.statusText);
        }
    };
    xhr.onerror = function() {
        console.error("Request failed");
    };
    xhr.send();
}

function updateLogsSection(logs) {
    console.log("Updating logs section with logs: ", logs);
    const logListElement = document.getElementById("logList");
    if (logs.length > 0) {
        const tableHtml = `
            <div class="scrollable-table"> <!-- Added div with scrollable class -->
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Log Entry</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${logs.map(log => `
                            <tr>
                                <td>${log.log_date}</td>
                                <td>${log.log_entry}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>
        `;
        logListElement.innerHTML = tableHtml;
    } else {
        logListElement.innerHTML = '<p>No logs available.</p>';
    }
}


// Fetch logs when the logs section is displayed
document.getElementById('logLinkk').addEventListener('click', fetchLogsData);

// Function to switch sections
function switchSection(event, sectionId) {
    event.preventDefault();

    // Hide all sections
    const sections = document.querySelectorAll('.content-section');
    sections.forEach(section => {
        section.classList.remove("active");
    });

    // Show the clicked section
    document.getElementById(sectionId).classList.add("active");

    // Highlight the active link
    const links = document.querySelectorAll('.sidebar a');
    links.forEach(link => {
        link.classList.remove("active");
    });
    event.target.classList.add("active");

    // Fetch data for the section
    if (sectionId === "logs") {
        fetchLogsData();
    } else {
        fetchSectionData(sectionId);
    }
}

// Event listeners for navigation links
document.querySelectorAll('.sidebar a').forEach(link => {
    link.addEventListener("click", function(event) {
        const sectionId = link.id.replace("Link", "");
        switchSection(event, sectionId);
    });
});

document.addEventListener('change', function(e) {
    if (e.target.classList.contains('queue-status-dropdown')) {
        const requestId = e.target.dataset.requestId;
        const table = e.target.dataset.table;
        const newStatus = e.target.value;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_status.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log('Queue status updated.');
            } else {
                console.error('Failed to update queue status.');
            }
        };
        xhr.send(`request_id=${requestId}&table=${table}&status=${newStatus}`);
    }
});