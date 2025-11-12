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

// Handle actions
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
        .calendar {
            width: 100%;
            border-collapse: collapse;
        }

        .calendar th,
        .calendar td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .calendar th {
            background-color: #f2f2f2;
        }

        .event {
            background-color: #e0f7fa;
        }

        .navigation {
            margin-bottom: 1rem;
        }

        .event-form {
            margin-top: 1rem;
        }

        .sidebar {
            margin-top: 102px;
            margin-bottom: 100px;
            overflow-y: scroll;
        }

        .Home_container {
            margin-left: 240px;
        }

        .event-actions {
            margin-left: 1rem;
        }

        .Home_container {
            margin-left: 240px;
            height: 1500px;
        }

        .sidebar {
            margin-top: 102px;
            margin-bottom: 100px;
            overflow-y: scroll
        }
    </style>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this event?");
        }

        function confirmLogout() {
            const confirmAction = confirm("Are you sure you want to log out?");
            if (confirmAction) {
                window.location.href = "logout.php";
            }
        }
    </script>
</head>

<body>
    <!-- Topbar and Sidebar (unchanged) -->
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

            <!-- Calendar Table (unchanged) -->
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
                                echo "<td class=\"$class\">$day";
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

            <!-- Add/Edit Event Form -->
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

            <!-- Event Details with Edit/Delete -->
            <?php if (!empty($events)): ?>
                <h3>Events</h3>
                <br>
                <?php foreach ($events as $date => $event_list): ?>
                    <h4><?php echo date('M d, Y', strtotime($date)); ?></h4>
                    <ul>
                        <?php foreach ($event_list as $event): ?>
                            <li>
                                <strong><?php echo htmlspecialchars($event['title']); ?></strong>: <?php echo htmlspecialchars($event['description']); ?>
                                <?php if (in_array($user_role, ['teacher', 'admin']) && ($event['created_by'] == $user_id || $user_role == 'admin')): ?>
                                    <div class="event-actions">
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                                            <button type="submit" name="load_edit">Edit</button>
                                        </form>
                                        <form method="POST" style="display: inline;" onsubmit="return confirmDelete()">
                                            <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                                            <button type="submit" name="delete_event">Delete</button>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            </li><br>
                        <?php endforeach; ?>
                    </ul>
                <?php endforeach; ?>
            <?php endif; ?>




        </div>
    </div>

    <img src="pictures/LOicon.png" alt="Logout" class="logout" onclick="confirmLogout()">
</body>

</html>