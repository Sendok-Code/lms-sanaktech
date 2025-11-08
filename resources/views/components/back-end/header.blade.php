<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #3b82f6;
            --primary-dark: #1e40af;
            --secondary: #8b5cf6;
            --accent: #06b6d4;
            --bg-dark: #0f172a;
            --bg-darker: #0a0e27;
            --bg-card: #1e293b;
            --text-primary: #f1f5f9;
            --text-secondary: #cbd5e1;
            --border: #334155;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-primary);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        .sidebar {
            background: linear-gradient(180deg, var(--bg-darker) 0%, #0a0d1f 100%);
            border-right: 1px solid var(--border);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 280px;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 3px;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar.collapsed .sidebar-text {
            opacity: 0;
            display: none;
        }

        .sidebar.collapsed .nav-badge {
            display: none;
        }

        .sidebar.collapsed .nav-arrow {
            display: none;
        }

        .sidebar.collapsed .user-info {
            display: none;
        }

        .sidebar.collapsed .user-actions {
            display: none;
        }

        /* Sidebar Header */
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 80px;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex: 1;
        }

        .logo-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .brand-name {
            font-weight: 700;
            font-size: 1.125rem;
            color: var(--text-primary);
            letter-spacing: -0.02em;
        }

        .brand-version {
            font-size: 0.7rem;
            color: var(--text-secondary);
            opacity: 0.6;
        }

        .sidebar-toggle-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: rgba(59, 130, 246, 0.1);
            border: none;
            color: var(--primary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .sidebar-toggle-btn:hover {
            background: rgba(59, 130, 246, 0.2);
            transform: scale(1.05);
        }

        .sidebar.collapsed .sidebar-toggle-btn {
            display: none;
        }

        /* Sidebar Navigation */
        .sidebar-nav {
            flex: 1;
            padding: 1rem 0;
            overflow-y: auto;
        }

        .main-content {
            margin-left: 280px;
            transition: all 0.3s ease;
            min-height: 100vh;
            background-color: var(--bg-dark);
        }

        .main-content.expanded {
            margin-left: 80px;
        }

        .header {
            background-color: var(--bg-card);
            border-bottom: 1px solid var(--border);
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .content {
            padding: 2rem;
        }

        .nav-item {
            padding: 0.75rem 1rem;
            margin: 0.25rem 0.75rem;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .nav-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: var(--primary);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .nav-item:hover {
            background: rgba(59, 130, 246, 0.08);
            color: var(--primary);
            transform: translateX(4px);
        }

        .nav-item:hover .nav-icon {
            color: var(--primary);
            transform: scale(1.1);
        }

        .nav-item.active {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.15) 0%, rgba(59, 130, 246, 0.05) 100%);
            color: var(--primary);
        }

        .nav-item.active::before {
            transform: scaleY(1);
        }

        .nav-item.active .nav-icon {
            color: var(--primary);
        }

        .nav-item.has-submenu {
            position: relative;
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            transition: all 0.3s ease;
        }

        .nav-text {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .nav-badge {
            padding: 0.125rem 0.5rem;
            background: rgba(59, 130, 246, 0.2);
            color: var(--primary);
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 600;
            margin-left: auto;
        }

        .nav-badge.bg-success {
            background: rgba(16, 185, 129, 0.2);
            color: var(--success);
        }

        .nav-badge.bg-warning {
            background: rgba(245, 158, 11, 0.2);
            color: var(--warning);
        }

        .nav-arrow {
            width: 16px;
            height: 16px;
            color: var(--text-secondary);
            transition: transform 0.3s ease;
            margin-left: auto;
        }

        .nav-item.has-submenu.active .nav-arrow {
            transform: rotate(180deg);
        }

        /* Submenu */
        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .submenu.show {
            max-height: 500px;
        }

        .submenu-item {
            padding: 0.625rem 1rem 0.625rem 3.5rem;
            margin: 0.125rem 0.75rem;
            font-size: 0.875rem;
            position: relative;
        }

        .submenu-item::before {
            content: '';
            position: absolute;
            left: 2.25rem;
            top: 50%;
            width: 4px;
            height: 4px;
            background: var(--text-secondary);
            border-radius: 50%;
            transform: translateY(-50%);
            transition: all 0.3s ease;
        }

        .submenu-item:hover::before {
            background: var(--primary);
            width: 6px;
            height: 6px;
        }

        .submenu-item:hover {
            transform: translateX(0);
        }

        .stat-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 0.75rem;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(59, 130, 246, 0.1);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
            margin: 0.5rem 0;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-change {
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .stat-change.positive {
            color: var(--success);
        }

        .stat-change.negative {
            color: var(--danger);
        }

        .table-container {
            background-color: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 0.75rem;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: rgba(59, 130, 246, 0.1);
            border-bottom: 1px solid var(--border);
        }

        th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid var(--border);
            font-size: 0.95rem;
        }

        tbody tr:hover {
            background-color: rgba(59, 130, 246, 0.05);
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .badge-success {
            background-color: rgba(16, 185, 129, 0.2);
            color: var(--success);
        }

        .badge-warning {
            background-color: rgba(245, 158, 11, 0.2);
            color: var(--warning);
        }

        .badge-danger {
            background-color: rgba(239, 68, 68, 0.2);
            color: var(--danger);
        }

        .badge-info {
            background-color: rgba(59, 130, 246, 0.2);
            color: var(--primary);
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .btn-secondary {
            background-color: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
        }

        .btn-secondary:hover {
            background-color: rgba(59, 130, 246, 0.1);
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
        }

        .search-box {
            background-color: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 0.75rem 1rem 0.75rem 2.75rem;
            color: var(--text-primary);
            width: 100%;
            max-width: 320px;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }

        .search-box::placeholder {
            color: var(--text-secondary);
        }

        .search-box:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            background: var(--bg-darker);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--text-primary);
        }

        .grid-2 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .grid-4 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .chart-container {
            background-color: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .icon {
            width: 24px;
            height: 24px;
            display: inline-block;
        }

        .toggle-btn {
            background: none;
            border: none;
            color: var(--text-primary);
            cursor: pointer;
            font-size: 1.5rem;
            padding: 0.5rem;
        }

        /* Sidebar Footer / User Profile */
        .sidebar-footer {
            margin-top: auto;
            padding: 1rem 0.75rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            border-radius: 12px;
            background: rgba(59, 130, 246, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .user-profile::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(139, 92, 246, 0.1));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .user-profile:hover::before {
            opacity: 1;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            overflow: hidden;
            flex-shrink: 0;
            border: 2px solid var(--primary);
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-info {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--text-secondary);
            opacity: 0.8;
        }

        .user-actions {
            display: flex;
            gap: 0.5rem;
        }

        .logout-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: rgba(239, 68, 68, 0.1);
            border: none;
            color: var(--danger);
            cursor: pointer !important;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            position: relative;
            z-index: 100;
            pointer-events: auto;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.2);
            transform: scale(1.1);
        }

        .logout-btn:active {
            transform: scale(0.95);
            background: rgba(239, 68, 68, 0.3);
        }

        /* Mobile Toggle Button */
        .mobile-toggle-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(59, 130, 246, 0.1);
            border: none;
            color: var(--primary);
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .mobile-toggle-btn:hover {
            background: rgba(59, 130, 246, 0.2);
        }

        /* Page Title */
        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        /* Header Actions */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .search-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-container svg {
            position: absolute;
            left: 1rem;
            color: var(--text-secondary);
            pointer-events: none;
        }

        .header-icon-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(59, 130, 246, 0.1);
            border: none;
            color: var(--text-primary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: all 0.3s ease;
        }

        .header-icon-btn:hover {
            background: rgba(59, 130, 246, 0.15);
            transform: translateY(-2px);
        }

        .notification-dot {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 8px;
            height: 8px;
            background: var(--danger);
            border-radius: 50%;
            border: 2px solid var(--bg-card);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background-color: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 0.75rem;
            padding: 2rem;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-close {
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            font-size: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            background-color: var(--bg-dark);
            border: 1px solid var(--border);
            border-radius: 0.5rem;
            color: var(--text-primary);
            font-size: 0.95rem;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        @media (max-width: 1024px) {
            .search-container {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }

            .sidebar.collapsed {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-toggle-btn {
                display: flex;
            }

            .content {
                padding: 1rem;
            }

            .grid-2, .grid-3, .grid-4 {
                grid-template-columns: 1fr;
            }

            .header-actions {
                gap: 0.5rem;
            }

            .page-title {
                font-size: 1.125rem;
            }

            table {
                font-size: 0.85rem;
            }

            th, td {
                padding: 0.75rem 0.5rem;
            }

            .stat-value {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body></body>