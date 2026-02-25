<?php
$current = basename($_SERVER['PHP_SELF']);
$folder  = basename(dirname($_SERVER['PHP_SELF']));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduTrack — Student Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --green-dark:   #1a4731;
            --green-main:   #2d7a4f;
            --green-mid:    #3a9e68;
            --green-light:  #5bbf85;
            --green-pale:   #e8f7ef;
            --green-accent: #00c96e;
            --text-dark:    #0f2419;
            --text-mid:     #3d5a47;
            --text-light:   #7a9e87;
            --white:        #ffffff;
            --bg-soft:      #f4fbf7;
            --border:       #d2ead9;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-soft);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* NAVBAR */
        .main-navbar {
            background: var(--green-dark);
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(0,0,0,0.25);
        }
        .navbar-brand-wrap {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none; padding: 14px 0;
        }
        .brand-icon {
            width: 38px; height: 38px;
            background: var(--green-accent); border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem; color: var(--green-dark); font-weight: 800;
        }
        .brand-name {
            font-family: 'DM Serif Display', serif;
            font-size: 1.4rem; color: var(--white);
        }
        .brand-name span { color: var(--green-accent); }
        .nav-links {
            display: flex; align-items: center; gap: 4px;
            list-style: none; margin: 0; padding: 0;
        }
        .nav-links a {
            display: flex; align-items: center; gap: 7px;
            padding: 8px 16px; border-radius: 8px;
            color: rgba(255,255,255,0.75); text-decoration: none;
            font-size: 0.875rem; font-weight: 500; transition: all 0.2s;
        }
        .nav-links a:hover, .nav-links a.active {
            background: rgba(255,255,255,0.12); color: var(--white);
        }
        .nav-links a.active { background: var(--green-mid); }
        .nav-links a i { font-size: 1rem; }

        /* PAGE */
        .page-content { flex: 1; padding: 2rem; }

        .page-header {
            background: linear-gradient(135deg, var(--green-dark) 0%, var(--green-main) 100%);
            border-radius: 16px; padding: 2rem 2.5rem;
            margin-bottom: 2rem; color: white;
            position: relative; overflow: hidden;
        }
        .page-header::before {
            content: ''; position: absolute;
            top: -40px; right: -40px;
            width: 180px; height: 180px;
            background: rgba(255,255,255,0.05); border-radius: 50%;
        }
        .page-header h1 {
            font-family: 'DM Serif Display', serif;
            font-size: 1.9rem; margin-bottom: 0.3rem;
        }
        .page-header p { color: rgba(255,255,255,0.7); font-size: 0.9rem; margin: 0; }

        /* CARD */
        .card { border: 1px solid var(--border); border-radius: 14px; box-shadow: 0 2px 12px rgba(45,122,79,0.06); }
        .card-header-green {
            background: linear-gradient(135deg, var(--green-dark), var(--green-main));
            color: white; border-radius: 14px 14px 0 0 !important;
            padding: 1.1rem 1.5rem; font-weight: 600; font-size: 1rem;
            display: flex; align-items: center; gap: 8px;
        }

        /* BUTTONS */
        .btn-green {
            background: var(--green-main); color: white; border: none;
            border-radius: 8px; padding: 8px 20px; font-weight: 600;
            font-size: 0.875rem; transition: all 0.2s;
        }
        .btn-green:hover {
            background: var(--green-dark); color: white;
            transform: translateY(-1px); box-shadow: 0 4px 12px rgba(45,122,79,0.3);
        }
        .btn-outline-green {
            background: transparent; color: var(--green-main);
            border: 2px solid var(--green-main); border-radius: 8px;
            padding: 6px 18px; font-weight: 600; font-size: 0.875rem; transition: all 0.2s;
        }
        .btn-outline-green:hover { background: var(--green-main); color: white; }

        /* TABLE */
        .table-custom thead th {
            background: var(--green-pale); color: var(--green-dark);
            font-weight: 700; font-size: 0.8rem;
            text-transform: uppercase; letter-spacing: 0.5px;
            border-bottom: 2px solid var(--border); padding: 12px 16px;
        }
        .table-custom tbody td {
            padding: 12px 16px; vertical-align: middle;
            border-bottom: 1px solid var(--border); font-size: 0.9rem;
        }
        .table-custom tbody tr:hover { background: var(--green-pale); }
        .table-custom tbody tr:last-child td { border-bottom: none; }

        /* GRADE BADGE */
        .grade-badge {
            padding: 4px 12px; border-radius: 20px;
            font-weight: 700; font-size: 0.8rem;
        }

        /* FORMS */
        .form-control:focus, .form-select:focus {
            border-color: var(--green-mid);
            box-shadow: 0 0 0 3px rgba(45,122,79,0.15);
        }
        .form-label { font-weight: 600; font-size: 0.875rem; color: var(--text-mid); margin-bottom: 6px; }
        .form-control, .form-select {
            border-radius: 8px; border: 1.5px solid var(--border);
            padding: 9px 14px; font-size: 0.9rem;
        }

        /* ALERT */
        .alert-success-custom {
            background: var(--green-pale); border: 1px solid var(--green-light);
            color: var(--green-dark); border-radius: 10px; padding: 12px 18px;
            display: flex; align-items: center; gap: 10px;
            font-weight: 500; font-size: 0.9rem;
        }

        /* FOOTER */
        .main-footer {
            background: var(--green-dark); color: rgba(255,255,255,0.5);
            text-align: center; padding: 1.2rem; font-size: 0.8rem; margin-top: auto;
        }
        .main-footer span { color: var(--green-accent); }

        /* ACTION BUTTONS */
        .action-btn {
            padding: 5px 12px; border-radius: 6px; font-size: 0.78rem;
            font-weight: 600; border: none; cursor: pointer;
            transition: all 0.2s; text-decoration: none;
            display: inline-flex; align-items: center; gap: 4px;
        }
        .action-btn-edit { background: #fff3cd; color: #856404; }
        .action-btn-edit:hover { background: #ffc107; color: #000; }
        .action-btn-delete { background: #fde8e8; color: #842029; }
        .action-btn-delete:hover { background: #dc3545; color: #fff; }

        /* EMPTY STATE */
        .empty-state { text-align: center; padding: 3rem; color: var(--text-light); }
        .empty-state i { font-size: 3rem; margin-bottom: 1rem; opacity: 0.4; }
        .empty-state p { font-size: 0.95rem; }

        /* ── RESPONSIVE ── */

/* Hamburger button */
.navbar-toggler-custom {
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 4px 8px;
    border-radius: 8px;
    transition: background 0.2s;
}
.navbar-toggler-custom:hover {
    background: rgba(255,255,255,0.1);
}

/* Mobile nav menu */
@media (max-width: 768px) {
    .main-navbar {
        padding: 0 1rem;
        flex-wrap: wrap;
    }

    .main-navbar > div {
        flex-wrap: wrap;
        width: 100%;
    }

    .navbar-brand-wrap {
        padding: 12px 0;
    }

    .nav-links {
        display: none;
        flex-direction: column;
        width: 100%;
        padding: 8px 0 12px;
        gap: 2px;
    }

    .nav-links.open {
        display: flex;
    }

    .nav-links a {
        padding: 10px 12px;
        border-radius: 8px;
        width: 100%;
    }

    /* Page content padding */
    .page-content {
        padding: 1rem;
    }

    /* Page header */
    .page-header {
        padding: 1.5rem !important;
    }

    .page-header h1 {
        font-size: 1.4rem !important;
    }

    /* Hero buttons stack on mobile */
    .page-header .d-flex {
        flex-direction: column;
    }

    /* Stats cards full width on mobile */
    .col-md-3 {
        width: 50% !important;
    }

    /* Tables scroll horizontally */
    .card .card-body {
        overflow-x: auto;
    }

    .table-custom {
        min-width: 500px;
    }

    /* Forms full width */
    .col-md-7, .col-md-6 {
        width: 100% !important;
    }

    /* Action buttons smaller */
    .action-btn {
        padding: 4px 8px;
        font-size: 0.72rem;
    }

    /* Toast position on mobile */
    .toast-container {
        left: 1rem !important;
        right: 1rem !important;
        top: 1rem !important;
    }
}

@media (max-width: 480px) {
    .col-md-3 {
        width: 100% !important;
    }

    .brand-name {
        font-size: 1.1rem;
    }
}
    </style>
</head>
<body>
<nav class="main-navbar">
    <div class="d-flex justify-content-between align-items-center">
        <a href="<?= $base ?>home.php" class="navbar-brand-wrap">
            
            <div class="brand-name">Student<span>Tracker</span></div>
        </a>

        <!-- Hamburger button for mobile -->
        <button class="navbar-toggler-custom d-md-none" onclick="toggleMenu()">
            <i class="bi bi-list" id="menu-icon" style="font-size:1.5rem; color:white;"></i>
        </button>

        <!-- Nav links -->
        <ul class="nav-links" id="nav-menu">
            <li><a href="<?= $base ?>home.php" class="<?= ($current === 'home.php') ? 'active' : '' ?>"><i class="bi bi-house-fill"></i> Home</a></li>
            <li><a href="<?= $base ?>students/index.php" class="<?= ($folder === 'students') ? 'active' : '' ?>"><i class="bi bi-people-fill"></i> Students</a></li>
            <li><a href="<?= $base ?>subjects/index.php" class="<?= ($folder === 'subjects') ? 'active' : '' ?>"><i class="bi bi-book-fill"></i> Subjects</a></li>
            <li><a href="<?= $base ?>grades/index.php" class="<?= ($folder === 'grades') ? 'active' : '' ?>"><i class="bi bi-bar-chart-fill"></i> Grades</a></li>
        </ul>
    </div>
</nav>