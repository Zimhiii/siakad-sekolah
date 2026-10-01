<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= esc($title ?? 'SIAKAD') ?> - SMA IT Fithrah Insani</title>

  <!-- Bootstrap 5.3 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <!-- Google Fonts: Montserrat & Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">

  <!-- AdminLTE 4 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta3/dist/css/adminlte.min.css">
  <!-- Tabulator CSS -->
  <link rel="stylesheet" href="https://unpkg.com/tabulator-tables@5.5.0/dist/css/tabulator_bootstrap5.min.css">

  <style>
    :root {
      --siakad-primary: #1E3A5F;
      --siakad-accent: #2CA58D;
      --siakad-dark-bg: #0F1720;
      --siakad-dark-card: #182233;
    }
    body, p, span, td, th, label, input, select, textarea, .nav-link, .dropdown-item,
    .badge, .btn, .card-text, .small, small {
      font-family: 'Montserrat', system-ui, sans-serif;
    }

    h1, h2, h3, h4.fw-bold, .page-title, .content-header h1, .brand-text {
      font-family: 'Poppins', 'Montserrat', sans-serif;
      font-weight: 700;
    }

    h4, h5, h6, .card-title {
      font-family: 'Montserrat', system-ui, sans-serif;
      font-weight: 600;
    }
    /* Fix AdminLTE clearfix pseudo-element interfering with flexbox in card, card-header, card-body & card-footer */
    .card::after,
    .card::before,
    .card-header::after,
    .card-header::before,
    .card-body::after,
    .card-body::before,
    .card-footer::after,
    .card-footer::before {
      display: none !important;
      content: none !important;
      clear: none !important;
    }

    .fs-7 { font-size: 0.85rem; }
    .fs-8 { font-size: 0.75rem; }

    /* Refined Badges (Borderless Soft & Clean Look) */
    .badge,
    .badge.border {
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      gap: 0.35rem !important;
      padding: 0.38rem 0.72rem !important; /* Breathable padding X & Y */
      font-size: 0.75rem !important;        /* 12px clean */
      font-weight: 600 !important;          /* Semibold definition */
      line-height: 1.25 !important;
      letter-spacing: 0.025em !important;
      border-radius: 5px !important;        /* Radius clean modern (5px) */
      border: none !important;              /* Tanpa border */
      border-width: 0 !important;
      box-shadow: none !important;
      text-decoration: none;
      vertical-align: middle;
      white-space: nowrap;
      transition: background-color 0.15s ease, color 0.15s ease;
    }
    .badge:focus-visible {
      outline: 2px solid #0a58ca !important;
      outline-offset: 2px !important;
    }

    .badge-dot {
      display: inline-block;
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background-color: currentColor;
      flex-shrink: 0;
    }

    /* Light Theme Borderless Soft Badges (WCAG AA Compliant >= 4.5:1 for small text) */
    .badge.bg-primary,
    .badge.bg-primary.text-white {
      background-color: rgba(13, 110, 253, 0.12) !important;
      color: #0a58ca !important;
    }
    .badge.bg-success,
    .badge.bg-success.text-white {
      background-color: rgba(25, 135, 84, 0.12) !important;
      color: #146c43 !important;
    }
    .badge.bg-warning,
    .badge.bg-warning.text-dark {
      background-color: rgba(255, 193, 7, 0.20) !important;
      color: #755200 !important;
    }
    .badge.bg-danger,
    .badge.bg-danger.text-white {
      background-color: rgba(220, 53, 69, 0.12) !important;
      color: #b02a37 !important;
    }
    .badge.bg-info,
    .badge.bg-info.text-dark {
      background-color: rgba(13, 202, 240, 0.14) !important;
      color: #055160 !important;
    }
    .badge.bg-secondary,
    .badge.bg-secondary.text-white {
      background-color: rgba(108, 117, 125, 0.12) !important;
      color: #495057 !important;
    }
    .badge.bg-light,
    .badge.bg-light.text-dark {
      background-color: #e9ecef !important;
      color: #212529 !important;
      font-weight: 600 !important;
    }
    .badge.badge-code,
    .badge.font-monospace {
      font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace !important;
      letter-spacing: 0.04em !important;
    }

    /* Dark Theme Borderless Soft Badges & Secondary Text Contrast */
    [data-bs-theme="dark"] .text-secondary {
      color: #adb5bd !important;
    }
    [data-bs-theme="dark"] .badge.bg-primary,
    [data-bs-theme="dark"] .badge.bg-primary.text-white {
      background-color: rgba(13, 110, 253, 0.25) !important;
      color: #70b4ff !important;
    }
    [data-bs-theme="dark"] .badge.bg-success,
    [data-bs-theme="dark"] .badge.bg-success.text-white {
      background-color: rgba(25, 135, 84, 0.25) !important;
      color: #75b798 !important;
    }
    [data-bs-theme="dark"] .badge.bg-warning,
    [data-bs-theme="dark"] .badge.bg-warning.text-dark {
      background-color: rgba(255, 193, 7, 0.25) !important;
      color: #ffda6a !important;
    }
    [data-bs-theme="dark"] .badge.bg-danger,
    [data-bs-theme="dark"] .badge.bg-danger.text-white {
      background-color: rgba(220, 53, 69, 0.25) !important;
      color: #ea868f !important;
    }
    [data-bs-theme="dark"] .badge.bg-info,
    [data-bs-theme="dark"] .badge.bg-info.text-dark {
      background-color: rgba(13, 202, 240, 0.25) !important;
      color: #6edff6 !important;
    }
    [data-bs-theme="dark"] .badge.bg-secondary,
    [data-bs-theme="dark"] .badge.bg-secondary.text-white {
      background-color: rgba(108, 117, 125, 0.30) !important;
      color: #cbd5e1 !important;
    }
    [data-bs-theme="dark"] .badge.bg-light,
    [data-bs-theme="dark"] .badge.bg-light.text-dark {
      background-color: rgba(255, 255, 255, 0.12) !important;
      color: #f8f9fa !important;
      font-weight: 600 !important;
    }

    /* Special Contextual Badge: Active Semester (Distinct from standard status badges) */
    .badge-semester-active {
      display: inline-flex !important;
      align-items: center !important;
      margin-left: 0.35rem !important;      /* Berikan spacing sedikit dari teks semester */
      padding: 0.12rem 0.42rem !important;  /* Ukuran lebih kompak & sleek */
      font-size: 0.625rem !important;       /* Size lebih kecil (10px) */
      font-weight: 600 !important;
      line-height: 1.2 !important;
      letter-spacing: 0.025em !important;
      border-radius: 3.5px !important;
      border: none !important;
      background-color: rgba(99, 102, 241, 0.14) !important; /* Indigo lembut */
      color: #4f46e5 !important;
      vertical-align: middle;
      text-decoration: none;
    }
    [data-bs-theme="dark"] .badge-semester-active {
      background-color: rgba(129, 140, 248, 0.22) !important;
      color: #a5b4fc !important;
    }

    /* Circles enforcer (1:1 aspect ratio) */
    .rounded-circle {
      border-radius: 50% !important;
      aspect-ratio: 1 / 1 !important;
      flex-shrink: 0 !important;
    }

    img.rounded-circle,
    .user-image.rounded-circle {
      aspect-ratio: 1 / 1 !important;
      object-fit: cover !important;
      flex-shrink: 0 !important;
      display: inline-block !important;
    }

    /* Circular buttons (Theme toggle, action icon buttons) */
    .btn.rounded-circle,
    .btn-icon.rounded-circle,
    #theme-toggle-btn {
      width: 2.25rem !important;
      height: 2.25rem !important;
      min-width: 2.25rem !important;
      min-height: 2.25rem !important;
      max-width: 2.25rem !important;
      max-height: 2.25rem !important;
      padding: 0 !important;
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      border-radius: 50% !important;
      aspect-ratio: 1 / 1 !important;
      flex-shrink: 0 !important;
    }

    /* Div icon containers with rounded-circle */
    div.rounded-circle {
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      aspect-ratio: 1 / 1 !important;
      flex-shrink: 0 !important;
    }

    /* User Profile Image in Navbar */
    .user-menu .user-image,
    .nav-link .user-image {
      width: 34px !important;
      height: 34px !important;
      min-width: 34px !important;
      min-height: 34px !important;
      max-width: 34px !important;
      max-height: 34px !important;
      border-radius: 50% !important;
      object-fit: cover !important;
      aspect-ratio: 1 / 1 !important;
      flex-shrink: 0 !important;
      display: inline-block !important;
    }

    /* Notification badge dots in navbar (only spans, not img) */
    .nav-link span.rounded-circle:empty,
    span.position-absolute.rounded-circle {
      width: 8px !important;
      height: 8px !important;
      min-width: 8px !important;
      min-height: 8px !important;
      padding: 0 !important;
      aspect-ratio: 1 / 1 !important;
      border-radius: 50% !important;
      flex-shrink: 0 !important;
    }

    /* Header & Sidebar Brand Alignment */
    .app-header,
    .sidebar-brand {
      height: 3.5rem !important;
      min-height: 3.5rem !important;
      max-height: 3.5rem !important;
      padding-top: 0 !important;
      padding-bottom: 0 !important;
      box-sizing: border-box !important;
    }
    .app-header {
      display: flex !important;
      align-items: center !important;
    }
    .app-header .container-fluid {
      height: 100% !important;
      display: flex !important;
      align-items: center !important;
    }
    .app-header .navbar-nav {
      height: 100% !important;
      align-items: center !important;
    }
    .app-header .nav-link {
      display: flex !important;
      align-items: center !important;
      height: 100% !important;
      padding-top: 0 !important;
      padding-bottom: 0 !important;
    }
    .sidebar-brand {
      padding-top: 0 !important;
      padding-bottom: 0 !important;
    }
    .sidebar-brand .brand-link {
      display: flex !important;
      align-items: center !important;
      height: 100% !important;
    }
    
    /* Stepper Setup Styling */
    .wizard-stepper {
      display: flex;
      justify-content: space-between;
      position: relative;
      margin-bottom: 2rem;
    }
    .wizard-stepper::before {
      content: "";
      position: absolute;
      top: 18px;
      left: 30px;
      right: 30px;
      height: 3px;
      background: #dee2e6;
      z-index: 0;
    }
    [data-bs-theme="dark"] .wizard-stepper::before {
      background: #2a3441;
    }
    .step-item {
      position: relative;
      z-index: 1;
      text-align: center;
      flex: 1;
    }
    .step-bubble {
      width: 36px !important;
      height: 36px !important;
      min-width: 36px !important;
      min-height: 36px !important;
      border-radius: 50% !important;
      aspect-ratio: 1 / 1 !important;
      flex-shrink: 0 !important;
      background: #dee2e6;
      color: #6c757d;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      margin-bottom: 0.5rem;
      border: 3px solid var(--bs-body-bg);
      transition: all 0.3s ease;
    }
    .step-item.active .step-bubble {
      background: #0d6efd;
      color: #fff;
      box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.25);
    }
    .step-item.completed .step-bubble {
      background: #198754;
      color: #fff;
    }
    .step-label {
      font-size: 0.8rem;
      font-weight: 500;
      color: #6c757d;
      display: block;
    }
    .step-item.active .step-label {
      color: #0d6efd;
      font-weight: 700;
    }

    /* Paper Card Styling for Raport & Agenda (Formal School Document Simulation) */
    .card-paper {
      font-family: 'Times New Roman', Times, serif !important;
      color: #000000 !important;
      background-color: #ffffff !important;
      border: 1px solid #cccccc;
      box-shadow: 0 2px 12px rgba(0,0,0,0.10);
      border-radius: 4px;
    }
    .card-paper * {
      font-family: 'Times New Roman', Times, serif !important;
      color: #000000 !important;
    }
    [data-bs-theme="dark"] .card-paper {
      background-color: #ffffff !important;
      color: #000000 !important;
    }
    .card-paper .badge-edited-manual {
      font-family: 'Times New Roman', Times, serif !important;
      color: #6c757d !important;
      font-style: italic !important;
      background-color: transparent !important;
      font-size: 11px !important;
      padding: 0 !important;
      display: inline-block;
    }
    .card-paper input.form-control,
    .card-paper textarea.form-control {
      background-color: transparent !important;
      border: none !important;
      border-bottom: 1px dashed #999 !important;
      border-radius: 0 !important;
      padding: 2px 4px !important;
      font-family: 'Times New Roman', Times, serif !important;
      color: #000000 !important;
      box-shadow: none !important;
      resize: none;
    }
    .card-paper input.form-control:focus,
    .card-paper textarea.form-control:focus {
      outline: 2px solid rgba(13, 110, 253, 0.4) !important;
      outline-offset: 1px !important;
      border-bottom: 1px solid #000 !important;
      box-shadow: none !important;
      background-color: #fffde7 !important;
    }
    .card-paper table {
      border-collapse: collapse !important;
    }
    .card-paper table th,
    .card-paper table td {
      border: 1px solid #000000 !important;
      padding: 6px 8px !important;
      font-size: 13px !important;
      color: #000000 !important;
      background-color: transparent !important;
    }
    .card-paper table thead th {
      background-color: #f0f0f0 !important;
      font-weight: bold !important;
      text-align: center !important;
    }
    .card-paper table tr.baris-kelompok td {
      background-color: #e8e8e8 !important;
      font-weight: bold !important;
      font-style: italic !important;
    }
    .card-paper table.table-borderless,
    .card-paper table.table-borderless th,
    .card-paper table.table-borderless td {
      border: none !important;
    }
    
    /* Sticky bottom bar for Save Actions */
    .sticky-bottom-bar {
      position: sticky;
      bottom: 0;
      z-index: 1020;
      background: var(--bs-body-bg);
      padding: 12px 24px;
      border-top: 1px solid var(--bs-border-color);
    }

    /* Small & info boxes */
    .small-box {
      border-radius: 0.5rem;
      position: relative;
      display: block;
      margin-bottom: 20px;
      border: 1px solid var(--bs-border-color);
      color: #fff;
      padding: 1.25rem;
      overflow: hidden;
    }
    .small-box .inner h3 {
      font-size: 2.2rem;
      font-weight: 700;
      margin: 0 0 6px;
      white-space: nowrap;
      padding: 0;
    }
    .small-box .inner p {
      font-size: 0.95rem;
      margin-bottom: 0;
    }
    .small-box .icon {
      position: absolute;
      top: 15px;
      right: 15px;
      z-index: 0;
      font-size: 60px;
      color: rgba(255,255,255,.2);
    }
    .small-box .small-box-footer {
      position: relative;
      text-align: center;
      padding: 4px 0;
      color: rgba(255,255,255,.8);
      display: block;
      z-index: 10;
      background: rgba(0,0,0,.1);
      text-decoration: none;
      margin: 12px -1.25rem -1.25rem;
      font-size: 0.85rem;
      font-weight: 500;
    }
    .small-box .small-box-footer:hover {
      color: #fff;
      background: rgba(0,0,0,.15);
    }

    @media print {
      .app-header, .app-sidebar, .app-footer, .btn-no-print, .role-switcher-banner {
        display: none !important;
      }
      .app-main {
        margin: 0 !important;
        padding: 0 !important;
      }
      .card-paper {
        border: none !important;
        box-shadow: none !important;
      }
    }

    /* ==========================================================================
       Desktop 1280px Viewport Optimization Suite (Figma 1280px Canvas Export)
       ========================================================================== */
    html, body {
      max-width: 100%;
      overflow-x: hidden;
    }
    .app-wrapper {
      max-width: 100%;
      overflow-x: clip;
    }

    @media (min-width: 1100px) and (max-width: 1366px), (width: 1280px) {
      /* 1. Proportional Sidebar & Content Layout (AdminLTE 4 CSS Grid compatible) */
      :root {
        --lte-sidebar-width: 240px;
      }
      .app-sidebar {
        min-width: 240px !important;
        max-width: 240px !important;
      }
      .app-main, .app-header, .app-footer {
        margin-left: 0 !important;
      }
      .app-content {
        padding-top: 0.85rem !important;
        padding-bottom: 2rem !important;
      }
      .app-content > .container-fluid {
        padding-left: 1.25rem !important;
        padding-right: 1.25rem !important;
        max-width: 100% !important;
      }

      /* 2. Responsive Card Headers & Toolbars */
      .card-header {
        display: flex;
        flex-wrap: wrap !important;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
      }
      .card-header .btn-toolbar,
      .card-header .d-flex,
      .card-header .btn-group {
        flex-wrap: wrap;
        gap: 0.35rem;
      }

      /* 3. Optimal Table Typography & Cell Density */
      .table {
        font-size: 0.815rem;
      }
      .table th, .table td {
        padding: 0.48rem 0.58rem;
        vertical-align: middle;
        overflow-wrap: break-word;
      }
      .table-responsive {
        border-radius: inherit;
        -webkit-overflow-scrolling: touch;
      }
      
      /* Compact Buttons in Table Cells */
      .table .btn-sm,
      .table .btn-group .btn {
        padding: 0.2rem 0.45rem !important;
        font-size: 0.74rem !important;
        line-height: 1.25 !important;
      }

      /* Compact Badges in Tables */
      .table .badge {
        padding: 0.25rem 0.5rem !important;
        font-size: 0.72rem !important;
      }

      /* Compact Inputs in Table Rows */
      .table .form-control-sm,
      .table .form-select-sm {
        font-size: 0.78rem;
        padding: 0.22rem 0.4rem;
        min-height: 28px;
      }

      /* Responsive Overrides for Wide Column min-widths */
      th[style*="min-width: 300px"], td[style*="min-width: 300px"] { min-width: 210px !important; }
      th[style*="min-width: 260px"], td[style*="min-width: 260px"] { min-width: 180px !important; }
      th[style*="min-width: 240px"], td[style*="min-width: 240px"] { min-width: 170px !important; }
      th[style*="min-width: 220px"], td[style*="min-width: 220px"] { min-width: 160px !important; }
      th[style*="min-width: 200px"], td[style*="min-width: 200px"] { min-width: 150px !important; }
      th[style*="min-width: 180px"], td[style*="min-width: 180px"] { min-width: 135px !important; }
      th[style*="min-width: 140px"], td[style*="min-width: 140px"] { min-width: 105px !important; }

      /* 4. Stat & Metric Cards (Dashboard Grid) */
      .small-box .inner h3 {
        font-size: 1.45rem !important;
      }
      .small-box .inner p {
        font-size: 0.8rem !important;
      }
      .small-box .icon, .small-box .small-box-icon {
        font-size: 2.2rem !important;
      }
      .stat-summary-leger .fs-4 {
        font-size: 1.35rem !important;
      }

      /* 5. Modals Optimization (No cutoffs, perfectly centered) */
      .modal-xl {
        max-width: 1040px !important;
        width: 95% !important;
        margin-left: auto;
        margin-right: auto;
      }
      .modal-lg {
        max-width: 760px !important;
        width: 90% !important;
        margin-left: auto;
        margin-right: auto;
      }
      .modal-dialog:not(.modal-lg):not(.modal-xl) {
        max-width: 500px !important;
        width: 90% !important;
        margin-left: auto;
        margin-right: auto;
      }
      .modal-dialog {
        margin-top: 1.5rem;
        margin-bottom: 1.5rem;
      }

      /* 6. Wizard Stepper Compact Flow */
      .wizard-stepper {
        display: flex;
        flex-wrap: nowrap;
        gap: 0.35rem;
        overflow-x: auto;
        padding-bottom: 0.35rem;
      }
      .wizard-stepper .step-item {
        flex: 1 1 0;
        min-width: 100px;
        font-size: 0.72rem;
      }

      /* 7. Matriks Leger Nilai 1280px Fit */
      .table-leger {
        font-size: 0.72rem !important;
        table-layout: auto !important;
      }
      .table-leger th, .table-leger td {
        padding: 4px 3px !important;
      }
      .table-leger .sticky-col-1 {
        width: 36px !important;
      }
      .table-leger .sticky-col-2 {
        min-width: 155px !important;
        max-width: 175px !important;
        left: 36px !important;
      }
      .table-leger .sticky-col-2 .text-truncate {
        max-width: 165px !important;
      }

      /* 8. Textarea in Grading Tables */
      .table textarea {
        font-size: 0.78rem !important;
        padding: 0.25rem 0.4rem !important;
        min-height: 48px !important;
      }
    }
  </style>
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
  <div class="app-wrapper">
    <!-- Topbar -->
    <?= $this->include('layouts/topbar') ?>

    <!-- Sidebar -->
    <?= $this->include('layouts/sidebar') ?>

    <!-- Main Content Wrapper -->
    <main class="app-main">
      <!-- App Content -->
      <div class="app-content pt-3 pb-4">
        <div class="container-fluid">

          <!-- Flash Messages -->
          <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
              <i class="bi bi-check-circle-fill fs-5 me-2"></i>
              <div><?= session()->getFlashdata('success') ?></div>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <?php if (session()->getFlashdata('info')): ?>
            <div class="alert alert-info alert-dismissible fade show d-flex align-items-center" role="alert">
              <i class="bi bi-info-circle-fill fs-5 me-2"></i>
              <div><?= session()->getFlashdata('info') ?></div>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
              <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
              <div><?= session()->getFlashdata('error') ?></div>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <!-- Main Page Body Injection -->
          <?= $this->renderSection('content') ?>

        </div>
      </div>
    </main>

    <!-- Footer -->
    <?= $this->include('layouts/footer') ?>
  </div>

  <!-- Bootstrap 5.3 JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE 4 JS -->
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta3/dist/js/adminlte.min.js"></script>
  <!-- ApexCharts -->
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <!-- Tabulator JS -->
  <script src="https://unpkg.com/tabulator-tables@5.5.0/dist/js/tabulator.min.js"></script>

  <!-- Dark Mode Script -->
  <script>
    (function () {
      const getStoredTheme = () => localStorage.getItem('theme') || 'light';
      const setStoredTheme = theme => localStorage.setItem('theme', theme);

      const setTheme = function (theme) {
        document.documentElement.setAttribute('data-bs-theme', theme);
        const icon = document.getElementById('theme-icon');
        if (icon) {
          if (theme === 'dark') {
            icon.classList.remove('bi-moon-stars');
            icon.classList.add('bi-sun-fill');
          } else {
            icon.classList.remove('bi-sun-fill');
            icon.classList.add('bi-moon-stars');
          }
        }
      };

      setTheme(getStoredTheme());

      document.addEventListener('DOMContentLoaded', () => {
        const toggleBtn = document.getElementById('theme-toggle-btn');
        if (toggleBtn) {
          toggleBtn.addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            setStoredTheme(newTheme);
            setTheme(newTheme);
          });
        }
      });
    })();
  </script>

  <!-- Universal Instant Table Search & Filter Helper -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('.card-header input[placeholder*="Cari"], input[data-table-filter]').forEach(input => {
        input.addEventListener('input', function () {
          const term = this.value.toLowerCase().trim();
          const card = this.closest('.card') || document;
          const table = card.querySelector('table');
          if (!table) return;
          const rows = table.querySelectorAll('tbody tr:not(.empty-state-row):not(.baris-kelompok)');
          let visibleCount = 0;
          rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const match = text.includes(term);
            row.style.display = match ? '' : 'none';
            if (match) visibleCount++;
          });
          let emptyRow = table.querySelector('.filter-empty-row');
          if (visibleCount === 0 && term !== '') {
            if (!emptyRow) {
              const colCount = table.querySelectorAll('thead th').length || 6;
              const tr = document.createElement('tr');
              tr.className = 'filter-empty-row';
              tr.innerHTML = `<td colspan="${colCount}" class="text-center py-4 text-secondary"><i class="bi bi-search me-1"></i> Tidak ada data yang cocok dengan "${input.value}"</td>`;
              const tbody = table.querySelector('tbody');
              if (tbody) tbody.appendChild(tr);
            } else {
              emptyRow.style.display = '';
              emptyRow.querySelector('td').innerHTML = `<i class="bi bi-search me-1"></i> Tidak ada data yang cocok dengan "${input.value}"`;
            }
          } else if (emptyRow) {
            emptyRow.style.display = 'none';
          }
        });
      });
    });
  </script>

  <!-- Reusable Export & Print Helper (II.11) -->
  <script>
    window.SiakadHelper = {
      printDocument: function(title) {
        if (title) {
          const origTitle = document.title;
          document.title = title;
          window.print();
          document.title = origTitle;
        } else {
          window.print();
        }
      },
      exportTableToCSV: function(tableSelector, filename) {
        const table = document.querySelector(tableSelector);
        if (!table) return;
        let csv = [];
        const rows = table.querySelectorAll('tr');
        for (let i = 0; i < rows.length; i++) {
          let row = [], cols = rows[i].querySelectorAll('td, th');
          for (let j = 0; j < cols.length; j++) {
            let data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s+)/gm, ' ');
            data = data.replace(/"/g, '""');
            row.push('"' + data + '"');
          }
          csv.push(row.join(','));
        }
        const csvFile = new Blob([csv.join('\n')], {type: 'text/csv'});
        const downloadLink = document.createElement('a');
        downloadLink.download = (filename || 'export_siakad') + '.csv';
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = 'none';
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
      }
    };
  </script>

  <!-- Page Specific Scripts -->
  <?= $this->renderSection('scripts') ?>
</body>
</html>
