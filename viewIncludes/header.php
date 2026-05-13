<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Urban Super Deals – Men's Fragrances</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
  <style>
    :root {
      --teal: #00b2b2;
      --teal-dark: #007f8c;
      --teal-light: #e0f7f7;
      --crimson: #c0392b;
      --gold: #c8a96e;
      --dark: #1a1a2e;
      --mid: #2d3561;
      --light-bg: #f7f8fc;
      --white: #ffffff;
      --text-main: #1e1e2e;
      --text-muted: #7a7a8c;
      --border: #e4e4ef;
      --shadow: 0 4px 24px rgba(0,178,178,0.10);
      --font-serif: 'Cormorant Garamond', Georgia, serif;
      --font-sans: 'DM Sans', sans-serif;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: var(--font-sans); background: var(--light-bg); color: var(--text-main); }

    /* ── TOPBAR ── */
    .topbar {
      background: var(--dark);
      color: #ccc;
      font-size: 0.75rem;
      padding: 6px 0;
      letter-spacing: 0.04em;
    }
    .topbar a { color: var(--teal); text-decoration: none; }

    /* ── NAVBAR ── */
    .navbar-main {
      background: var(--white);
      border-bottom: 2px solid var(--border);
      padding: 10px 0;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    }
    .navbar-brand-wrap { display: flex; align-items: center; gap: 8px; }
    .logo-icon {
      width: 44px; height: 44px;
      background: var(--crimson);
      border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
      color: white; font-size: 1.1rem; font-weight: 700;
      letter-spacing: -1px;
    }
    .logo-text { line-height: 1.1; }
    .logo-text .brand-urban { font-family: var(--font-serif); font-size: 1.15rem; font-weight: 700; color: var(--dark); }
    .logo-text .brand-sub { font-size: 0.65rem; color: var(--crimson); text-transform: uppercase; letter-spacing: 0.12em; font-weight: 600; }

    .search-bar {
      flex: 1;
      max-width: 420px;
      position: relative;
    }
    .search-bar input {
      width: 100%;
      border: 1.5px solid var(--border);
      border-radius: 6px;
      padding: 9px 40px 9px 14px;
      font-size: 0.88rem;
      font-family: var(--font-sans);
      outline: none;
      transition: border-color 0.2s;
      background: var(--light-bg);
    }
    .search-bar input:focus { border-color: var(--teal); background: white; }
    .search-bar .btn-search {
      position: absolute; right: 0; top: 0; bottom: 0;
      background: var(--teal); border: none; color: white;
      padding: 0 14px; border-radius: 0 6px 6px 0; cursor: pointer;
      transition: background 0.2s;
    }
    .search-bar .btn-search:hover { background: var(--teal-dark); }

    .brand-select {
      border: 1.5px solid var(--border);
      border-radius: 6px;
      padding: 9px 14px;
      font-size: 0.88rem;
      font-family: var(--font-sans);
      background: var(--light-bg);
      outline: none;
      cursor: pointer;
      min-width: 140px;
      transition: border-color 0.2s;
    }
    .brand-select:focus { border-color: var(--teal); }

    .nav-phone { color: var(--crimson); font-weight: 600; font-size: 0.88rem; white-space: nowrap; }
    .nav-phone i { margin-right: 4px; }
    .nav-actions { display: flex; gap: 8px; align-items: center; }
    .nav-actions a {
      display: flex; align-items: center; gap: 5px;
      color: var(--text-main); font-size: 0.84rem;
      text-decoration: none; padding: 6px 12px;
      border-radius: 6px; transition: background 0.2s, color 0.2s;
      font-weight: 500;
    }
    .nav-actions a:hover { background: var(--teal-light); color: var(--teal-dark); }
    .cart-btn { position: relative; }
    .cart-badge {
      position: absolute; top: -4px; right: -4px;
      background: var(--crimson); color: white;
      font-size: 0.6rem; border-radius: 50%;
      width: 16px; height: 16px;
      display: flex; align-items: center; justify-content: center;
      font-weight: 700;
    }

    /* ── SIDEBAR ── */
    .sidebar {
      background: white;
      border-right: 1px solid var(--border);
      min-height: calc(100vh - 120px);
      padding: 24px 0;
    }
    .sidebar-section-title {
      font-size: 0.7rem;
      text-transform: uppercase;
      letter-spacing: 0.12em;
      color: var(--text-muted);
      padding: 0 20px;
      margin-bottom: 8px;
      margin-top: 20px;
      font-weight: 600;
    }
    .sidebar-nav { list-style: none; padding: 0; }
    .sidebar-nav li a {
      display: flex; align-items: center; justify-content: space-between;
      padding: 9px 20px;
      color: var(--text-main);
      text-decoration: none;
      font-size: 0.9rem;
      border-left: 3px solid transparent;
      transition: all 0.18s;
    }
    .sidebar-nav li a:hover { background: var(--teal-light); color: var(--teal-dark); border-left-color: var(--teal); }
    .sidebar-nav li.active a { background: var(--teal-light); color: var(--teal-dark); border-left-color: var(--teal); font-weight: 600; }
    .badge-new {
      background: var(--crimson); color: white;
      font-size: 0.6rem; padding: 2px 7px;
      border-radius: 20px; font-weight: 700;
      text-transform: uppercase; letter-spacing: 0.05em;
    }

    .sidebar-divider { border: none; border-top: 1px solid var(--border); margin: 12px 20px; }

    /* ── BREADCRUMB ── */
    .breadcrumb-wrap {
      background: white;
      border-bottom: 1px solid var(--border);
      padding: 10px 20px;
      font-size: 0.84rem;
    }
    .breadcrumb-wrap a { color: var(--teal-dark); text-decoration: none; }
    .breadcrumb-wrap a:hover { text-decoration: underline; }
    .breadcrumb-sep { color: var(--text-muted); margin: 0 6px; }

    /* ── MAIN CONTENT ── */
    .main-content { padding: 24px 20px; }
    .page-title {
      font-family: var(--font-serif);
      font-size: 2.2rem;
      font-weight: 700;
      color: var(--dark);
      margin-bottom: 20px;
      letter-spacing: -0.01em;
    }

    /* ── PRODUCT GRID ── */
    .products-grid { --bs-gutter-x: 16px; --bs-gutter-y: 20px; }

    /* ── PRODUCT CARD ── */
    .product-card {
      background: white;
      border-radius: 12px;
      overflow: hidden;
      border: 1px solid var(--border);
      transition: box-shadow 0.25s, transform 0.25s;
      position: relative;
      display: flex; flex-direction: column;
    }
    .product-card:hover {
      box-shadow: 0 12px 40px rgba(0,178,178,0.15);
      transform: translateY(-4px);
    }

    /* ribbon */
    .ribbon {
      position: absolute; top: 0; left: 0;
      background: var(--teal);
      color: white;
      font-size: 0.65rem; font-weight: 700;
      text-transform: uppercase; letter-spacing: 0.1em;
      padding: 4px 10px;
      border-radius: 0 0 12px 0;
      z-index: 2;
    }

    /* wishlist */
    .wishlist-btn {
      position: absolute; top: 10px; right: 10px;
      z-index: 2;
      background: white;
      border: 1.5px solid var(--border);
      border-radius: 50%;
      width: 34px; height: 34px;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer;
      transition: all 0.2s;
      color: var(--text-muted);
      font-size: 0.95rem;
    }
    .wishlist-btn:hover, .wishlist-btn.active { color: var(--crimson); border-color: var(--crimson); }

    /* image */
    .card-img-wrap {
      height: 220px;
      display: flex; align-items: center; justify-content: center;
      background: #f0f2f8;
      padding: 16px;
      position: relative;
      overflow: hidden;
    }
    .card-img-wrap img {
      max-height: 100%; max-width: 100%;
      object-fit: contain;
      transition: transform 0.35s ease;
    }
    .product-card:hover .card-img-wrap img { transform: scale(1.07); }

    /* price strip */
    .price-strip {
      background: var(--dark);
      color: white;
      display: flex; align-items: center; justify-content: flex-end;
      gap: 10px;
      padding: 7px 14px;
    }
    .price-current { font-weight: 700; font-size: 1rem; color: var(--gold); }
    .price-old { font-size: 0.8rem; text-decoration: line-through; color: #888; }

    /* card body */
    .card-body-custom {
      padding: 14px;
      flex: 1;
      display: flex; flex-direction: column;
    }
    .card-title-custom {
      font-size: 0.88rem;
      font-weight: 500;
      color: var(--teal-dark);
      line-height: 1.4;
      flex: 1;
      margin-bottom: 12px;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
    .btn-cart {
      background: transparent;
      border: 1.5px solid var(--teal);
      color: var(--teal-dark);
      font-size: 0.83rem;
      font-weight: 600;
      padding: 8px;
      border-radius: 7px;
      width: 100%;
      cursor: pointer;
      transition: all 0.2s;
      font-family: var(--font-sans);
      letter-spacing: 0.03em;
    }
    .btn-cart:hover {
      background: var(--teal);
      color: white;
    }

    /* ── WHATSAPP BUBBLE ── */
    .wa-bubble {
      position: fixed;
      bottom: 24px; right: 24px;
      z-index: 9999;
      background: #25d366;
      color: white;
      border-radius: 50%;
      width: 54px; height: 54px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.5rem;
      box-shadow: 0 4px 20px rgba(37,211,102,0.4);
      cursor: pointer;
      text-decoration: none;
      transition: transform 0.2s;
    }
    .wa-bubble:hover { transform: scale(1.1); color: white; }

    /* ── OFFCANVAS SIDEBAR (mobile) ── */
    .offcanvas-sidebar .offcanvas-body { padding: 0; }

    /* ── HAMBURGER ── */
    .sidebar-toggle {
      display: none;
      background: none; border: none;
      font-size: 1.4rem; color: var(--dark);
      cursor: pointer;
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 991px) {
      .sidebar { display: none; }
      .sidebar-toggle { display: block; }
      .search-bar { max-width: 200px; }
      .brand-select { display: none; }
      .nav-phone { display: none; }
    }
    @media (max-width: 767px) {
      .card-img-wrap { height: 180px; }
      .page-title { font-size: 1.6rem; }
      .search-bar { max-width: 160px; }
      .wa-bubble { width: 46px; height: 46px; font-size: 1.2rem; bottom: 16px; right: 16px; }
    }
    @media (max-width: 480px) {
      .search-bar { display: none; }
    }

    /* Fade-in animation */
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(18px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .product-card { animation: fadeUp 0.45s ease both; }
  </style>
</head>
<body>