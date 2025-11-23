<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "myfirstdatabase");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user role
$query = "SELECT id, role FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$user_role = $user['role'] ?? null;
$user_id = $user['id'];

// Get month/year from GET or default to current
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('n');
$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

// Validate year range
if ($year < 2024 || $year > 2040) {
    $year = date('Y');
    $month = date('n');
}

// Handle actions (Keep existing PHP logic)
$message = '';
$edit_event = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && in_array($user_role, ['teacher', 'admin'])) {
    if (isset($_POST['add_event'])) {
        $event_date = $_POST['event_date'];
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);

        $date_obj = DateTime::createFromFormat('Y-m-d', $event_date);
        $current_date = new DateTime();
        if (!$date_obj || $date_obj->format('Y-m-d') !== $event_date || $date_obj->format('Y') < 2024 || $date_obj->format('Y') > 2040 || $date_obj < $current_date) {
            $message = 'Invalid date. Must be between 2024-2040 and not in the past.';
        } elseif (!empty($title)) {
            $stmt = $conn->prepare("INSERT INTO events (event_date, title, description, created_by) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $event_date, $title, $description, $user_id);
            $stmt->execute();
            $message = 'Event added successfully!';
        } else {
            $message = 'Title is required.';
        }
    } elseif (isset($_POST['edit_event'])) {
        $event_id = (int)$_POST['event_id'];
        $event_date = $_POST['event_date'];
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);

        $date_obj = DateTime::createFromFormat('Y-m-d', $event_date);
        $current_date = new DateTime();
        if (!$date_obj || $date_obj->format('Y-m-d') !== $event_date || $date_obj->format('Y') < 2024 || $date_obj->format('Y') > 2040) {
            $message = 'Invalid date. Must be between 2024-2040.';
        } elseif (!empty($title)) {
            $stmt = $conn->prepare("UPDATE events SET event_date = ?, title = ?, description = ? WHERE id = ? AND (created_by = ? OR ? = 'admin')");
            $stmt->bind_param("sssiii", $event_date, $title, $description, $event_id, $user_id, $user_role);
            $stmt->execute();
            $message = 'Event updated successfully!';
        } else {
            $message = 'Title is required.';
        }
    } elseif (isset($_POST['delete_event'])) {
        $event_id = (int)$_POST['event_id'];
        $stmt = $conn->prepare("DELETE FROM events WHERE id = ? AND (created_by = ? OR ? = 'admin')");
        $stmt->bind_param("iis", $event_id, $user_id, $user_role);
        $stmt->execute();
        $message = 'Event deleted successfully!';
    } elseif (isset($_POST['load_edit'])) {
        $event_id = (int)$_POST['event_id'];
        $stmt = $conn->prepare("SELECT * FROM events WHERE id = ? AND (created_by = ? OR ? = 'admin')");
        $stmt->bind_param("iis", $event_id, $user_id, $user_role);
        $stmt->execute();
        $edit_result = $stmt->get_result();
        $edit_event = $edit_result->fetch_assoc();
    }
}

// Fetch events for the month
$start_date = date('Y-m-01', mktime(0, 0, 0, $month, 1, $year));
$end_date = date('Y-m-t', mktime(0, 0, 0, $month, 1, $year));
$events_query = "SELECT id, event_date, title, description, created_by FROM events WHERE event_date BETWEEN ? AND ?";
$stmt = $conn->prepare($events_query);
$stmt->bind_param("ss", $start_date, $end_date);
$stmt->execute();
$events_result = $stmt->get_result();
$events = [];
while ($row = $events_result->fetch_assoc()) {
    $events[$row['event_date']][] = $row;
}

// Encode events array as JSON for JavaScript usage
$events_json = json_encode($events);

$conn->close();

// Calendar generation (unchanged)
$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$first_day_of_month = date('w', mktime(0, 0, 0, $month, 1, $year));
$month_name = date('F', mktime(0, 0, 0, $month, 1, $year));

// Navigation links (unchanged)
$prev_month = $month - 1;
$prev_year = $year;
if ($prev_month < 1) {
    $prev_month = 12;
    $prev_year--;
}
$next_month = $month + 1;
$next_year = $year;
if ($next_month > 12) {
    $next_month = 1;
    $next_year++;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Calendar</title>
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="css2/dashboard.css">
    <style>
        /* ---------------------------------------------------- */
        /* 1. Sidebar and Layout Fixes (Based on previous conversation) */
        /* ---------------------------------------------------- */
        body {
            background-color: #f4f6f9;
            /* Light background for main content area */
            font-family: 'Poppins', sans-serif;
        }

        /* Fix the sidebar position to start below the Topbar (100px + 20px = 120px) */
        .sidebar {
            position: fixed;
            /* Ensure it stays in place */
            top: 120px !important;
            height: calc(100vh - 120px) !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            /* The width is assumed to be 230px from your style1.css */
        }

        /* Fix the main content area to start below the Topbar and next to the sidebar */
        .Home_container {
            /* Adjust margin-left to match sidebar width (230px) + some padding */
            margin-left: 250px;
            padding: 2rem;
            /* Push content down to start below the sticky Topbar (120px + extra padding) */
            min-height: 100vh;
            /* Ensure container spans full viewport height */
        }

        .Home_content {
            padding: 0;
            margin: 0;
        }


        /* ---------------------------------------------------- */
        /* 2. Calendar Component Styling */
        /* ---------------------------------------------------- */

        h2 {
            margin-bottom: 20px;
            font-size: 2rem;
        }

        h3 {
            color: #4CAF50;
            /* Green highlight color */
            margin-top: 30px;
            margin-bottom: 10px;
            border-bottom: 2px solid #eee;
            padding-bottom: 5px;
        }

        .navigation {
            margin-bottom: 20px;
            font-size: 1.1rem;
        }

        .navigation a {
            color: #343bc9;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.2s;
        }

        .navigation a:hover {
            color: #171d8a;
        }

        /* Calendar Table */
        .calendar {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            /* Ensures uniform column width */
            background-color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-radius: 8px;
            overflow: hidden;
            /* Helps with border-radius on table */
        }

        .calendar th,
        .calendar td {
            padding: 15px 5px;
            height: 100px;
            /* Set a minimum height for each day cell */
            vertical-align: top;
            text-align: right;
            border: 1px solid #f0f0f0;
            font-size: 1.2rem;
            position: relative;
        }

        .calendar th {
            background-color: #f0f0f0;
            color: #444;
            text-transform: uppercase;
            font-size: 0.9rem;
            padding: 10px 5px;
            text-align: center;
        }

        /* Day Number Positioning */
        .calendar td {
            font-weight: bold;
            color: #333;
        }

        /* Event Indicator */
        .calendar td small {
            display: block;
            font-size: 0.75rem;
            color: #2d6a4f;
            /* Green */
            font-weight: normal;
            margin-top: 5px;
            text-align: left;
            padding-left: 5px;
        }

        .calendar .event {
            background-color: #e6f7e9;
            /* Very light green background for event days */
            cursor: pointer;
        }

        .calendar .event:hover {
            background-color: #d8f5dc;
        }

        /* ---------------------------------------------------- */
        /* 3. Event Form Styling (Add/Edit) - Keep existing */
        /* ---------------------------------------------------- */
        .event-form {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin-bottom: 40px;
        }

        .event-form form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .event-form label {
            font-weight: 600;
            color: #555;
            margin-top: 5px;
        }

        .event-form input[type="date"],
        .event-form input[type="text"],
        .event-form textarea {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .event-form button[type="submit"] {
            background-color: #343bc9;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.2s;
            margin-top: 15px;
        }

        .event-form button[type="submit"]:hover {
            background-color: #171d8a;
        }

        .event-form a {
            /* Cancel link */
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #777;
            text-decoration: none;
        }


        /* ---------------------------------------------------- */
        /* 4. Event Details List Styling - Keep existing */
        /* ---------------------------------------------------- */

        .event-details-list {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .event-details-list h4 {
            color: #333;
            font-size: 1.1rem;
            margin-top: 20px;
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
        }

        .event-details-list ul {
            list-style: none;
            padding: 0;
            margin: 10px 0 20px 0;
        }

        .event-details-list li {
            padding: 10px 0;
            border-bottom: 1px dashed #eee;
        }

        .event-details-list li:last-child {
            border-bottom: none;
        }

        .event-details-list strong {
            color: #343bc9;
            display: block;
            margin-bottom: 3px;
        }

        .event-actions button {
            background-color: #f0f0f0;
            color: #333;
            border: 1px solid #ccc;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s;
            font-size: 0.9rem;
            margin-right: 5px;
        }

        .event-actions button:hover {
            background-color: #ddd;
        }

        /* ---------------------------------------------------- */
        /* 5. Modal Styling (NEW) */
        /* ---------------------------------------------------- */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 100;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            /* 15% from the top and centered */
            padding: 30px;
            border: 1px solid #888;
            width: 80%;
            /* Could be more or less, depending on screen size */
            max-width: 500px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .modal-content h3 {
            color: #343bc9;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }

        .modal-content p {
            margin-bottom: 10px;
            font-size: 1rem;
        }

        .modal-content p strong {
            color: #555;
            display: inline-block;
            width: 100px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 20px;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Styling for the list of events inside the modal */
        #event-list {
            list-style: none;
            padding: 0;
        }

        #event-list li {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 10px;
            border: 1px solid #eee;
        }

        #event-list li strong {
            color: #333;
            font-size: 1.1rem;
            display: block;
            margin-bottom: 5px;
        }
    </style>
    <script>
        // Store PHP events in a JavaScript variable
        const allEvents = <?php echo $events_json; ?>;

        function confirmDelete() {
            return confirm("Are you sure you want to delete this event?");
        }

        function confirmLogout() {
            const confirmAction = confirm("Are you sure you want to log out?");
            if (confirmAction) {
                window.location.href = "logout.php";
            }
        }

        /**
         * Opens the modal and displays the events for the clicked date.
         * @param {string} date - The date in 'YYYY-MM-DD' format.
         */
        function showEventDetails(date) {
            const modal = document.getElementById('eventModal');
            const eventList = document.getElementById('event-list');
            const modalDate = document.getElementById('modal-date');
            
            // Format date for display
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            const dateObj = new Date(date + 'T00:00:00'); // Add time to fix timezone issue
            modalDate.textContent = dateObj.toLocaleDateString('en-US', options);

            eventList.innerHTML = ''; // Clear previous events

            const eventsOnDate = allEvents[date];

            if (eventsOnDate && eventsOnDate.length > 0) {
                eventsOnDate.forEach(event => {
                    const listItem = document.createElement('li');
                    
                    // Create Title element
                    const title = document.createElement('strong');
                    title.textContent = event.title;

                    // Create Description element
                    const description = document.createElement('p');
                    description.innerHTML = event.description;

                    // Append to list item
                    listItem.appendChild(title);
                    listItem.appendChild(description);
                    eventList.appendChild(listItem);
                });
            } else {
                const listItem = document.createElement('li');
                listItem.textContent = 'No events scheduled for this date.';
                eventList.appendChild(listItem);
            }

            modal.style.display = 'block';
        }

        // When the user clicks on (x), close the modal
        function closeModal() {
            const modal = document.getElementById('eventModal');
            modal.style.display = 'none';
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            const modal = document.getElementById('eventModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</head>

<body>
    <div class="Topbar">
        <img class="Antipolo" src="pictures/ANTIPOLO.png">
        <h1 class="TopbarTitle1">GOLD: &nbsp; </h1>
        <h1 class="TopbarTitle2"> DXXXX daycare center</h1>
        <nav class="navbar">
            <ul>
                <li><a href="home1.php">Home</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="extra.php">Old Website</a></li>
            </ul>
        </nav>
        <a href="learning.html" class="cta-btn">Learn</a>
    </div>
    <div class="Topbarline">
        <p class="TopbarLineText">Welcome, <?php echo $_SESSION['username']; ?></p>
    </div>

    <?php include('includes/teacher_sidebar.php'); ?>

    <div class="Home_container">
        <div class="Home_content">
            <h2><?php echo $month_name . ' ' . $year; ?></h2>
            <div class="navigation">
                <a href="?month=<?php echo $prev_month; ?>&year=<?php echo $prev_year; ?>">Previous</a> |
                <a href="?month=<?php echo $next_month; ?>&year=<?php echo $next_year; ?>">Next</a>
            </div>

            <table class="calendar">
                <thead>
                    <tr>
                        <th>Sun</th>
                        <th>Mon</th>
                        <th>Tue</th>
                        <th>Wed</th>
                        <th>Thu</th>
                        <th>Fri</th>
                        <th>Sat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $day = 1;
                    for ($week = 0; $week < 6; $week++) {
                        echo '<tr>';
                        for ($weekday = 0; $weekday < 7; $weekday++) {
                            if ($week == 0 && $weekday < $first_day_of_month) {
                                echo '<td></td>';
                            } elseif ($day > $days_in_month) {
                                echo '<td></td>';
                            } else {
                                $date = sprintf('%04d-%02d-%02d', $year, $month, $day);
                                $has_event = isset($events[$date]);
                                $class = $has_event ? 'event' : '';
                                
                                // **MODIFICATION HERE:** Add onclick event to clickable cells
                                $onclick = $has_event ? "onclick=\"showEventDetails('$date')\"" : '';
                                
                                echo "<td class=\"$class\" $onclick>$day";
                                if ($has_event) {
                                    echo '<br><small>' . count($events[$date]) . ' event(s)</small>';
                                }
                                echo '</td>';
                                $day++;
                            }
                        }
                        echo '</tr>';
                        if ($day > $days_in_month) break;
                    }
                    ?>
                </tbody>
            </table>

            <br><br><br>

            <?php if (in_array($user_role, ['teacher', 'admin'])): ?>
                <div class="event-form">
                    <h3><?php echo $edit_event ? 'Edit Event' : 'Add Event'; ?></h3>
                    <?php if ($message): ?><p><?php echo htmlspecialchars($message); ?></p><?php endif; ?>
                    <form method="POST">
                        <input type="hidden" name="event_id" value="<?php echo $edit_event['id'] ?? ''; ?>">
                        <label>Date (YYYY-MM-DD):</label>
                        <input type="date" name="event_date" min="2024-01-01" max="2040-12-31" value="<?php echo $edit_event['event_date'] ?? ''; ?>" required><br>
                        <label>Title:</label><input type="text" name="title" value="<?php echo htmlspecialchars($edit_event['title'] ?? ''); ?>" required><br>
                        <label>Description:</label><textarea name="description"><?php echo htmlspecialchars($edit_event['description'] ?? ''); ?></textarea><br>
                        <button type="submit" name="<?php echo $edit_event ? 'edit_event' : 'add_event'; ?>"><?php echo $edit_event ? 'Update Event' : 'Add Event'; ?></button>
                        <?php if ($edit_event): ?><a href="calendar.php">Cancel</a><?php endif; ?>
                    </form>
                </div>
            <?php endif; ?>

            <br><br><br>

            <?php if (!empty($events)): ?>
                 <?php endif; ?>
            
            </div>
    </div>

    <div id="eventModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3>Events for <span id="modal-date"></span></h3>
            <ul id="event-list">
                </ul>
        </div>
    </div>
    <img src="pictures/LOicon.png" alt="Logout" class="logout" onclick="confirmLogout()">
</body>

</html>