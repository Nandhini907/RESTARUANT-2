<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ember & Oak — Fine Dining</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
<style>
  :root {
    --bg: #0d0b08;
    --bg2: #131109;
    --gold: #c9a84c;
    --gold-light: #e2c97e;
    --cream: #f5efe6;
    --muted: #7a7060;
    --border: rgba(201,168,76,0.18);
    --card-bg: #181410;
    --red: #9b3a2a;
  }
  *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
  html { scroll-behavior: smooth; }
  body {
    background: var(--bg);
    color: var(--cream);
    font-family: 'Jost', sans-serif;
    font-weight: 300;
    line-height: 1.7;
    overflow-x: hidden;
  }
 
  /* ── NAV ── */
  nav {
    position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
    display: flex; align-items: center; justify-content: space-between;
    padding: 1.2rem 4rem;
    background: rgba(13,11,8,0.92);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid var(--border);
    transition: padding .3s;
  }
  nav.scrolled { padding: .8rem 4rem; }
  .nav-logo {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.6rem; font-weight: 300; letter-spacing: .15em;
    color: var(--gold); text-decoration: none;
  }
  .nav-logo span { font-style: italic; color: var(--cream); }
  .nav-links { display: flex; gap: 2.5rem; list-style: none; }
  .nav-links a {
    color: var(--cream); text-decoration: none;
    font-size: .78rem; letter-spacing: .18em; text-transform: uppercase;
    opacity: .75; transition: opacity .25s, color .25s;
  }
  .nav-links a:hover { opacity: 1; color: var(--gold); }
  .nav-reserve {
    background: transparent; border: 1px solid var(--gold);
    color: var(--gold); padding: .5rem 1.4rem;
    font-family: 'Jost', sans-serif; font-size: .75rem;
    letter-spacing: .15em; text-transform: uppercase; cursor: pointer;
    transition: background .25s, color .25s; text-decoration: none;
  }
  .nav-reserve:hover { background: var(--gold); color: var(--bg); }
  .hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; }
  .hamburger span { width: 24px; height: 1px; background: var(--cream); transition: .3s; }
 
  /* ── HERO ── */
  #home {
    min-height: 100vh;
    background: radial-gradient(ellipse at 30% 60%, rgba(201,168,76,0.07) 0%, transparent 60%),
                linear-gradient(160deg, #0d0b08 0%, #1a1208 50%, #0d0b08 100%);
    display: flex; align-items: center; justify-content: center;
    position: relative; overflow: hidden;
  }
  .hero-noise {
    position: absolute; inset: 0; opacity: .035;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='4'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
    background-size: 200px;
  }
  .hero-line {
    position: absolute; top: 50%; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, var(--border), transparent);
    transform: translateY(-50%);
  }
  .hero-content { text-align: center; position: relative; z-index: 1; padding: 2rem; }
  .hero-eyebrow {
    font-size: .72rem; letter-spacing: .35em; text-transform: uppercase;
    color: var(--gold); margin-bottom: 1.5rem; opacity: 0;
    animation: fadeUp .8s .3s forwards;
  }
  .hero-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(4rem, 10vw, 9rem);
    font-weight: 300; line-height: .9;
    color: var(--cream); letter-spacing: -.01em;
    opacity: 0; animation: fadeUp .8s .5s forwards;
  }
  .hero-title em { font-style: italic; color: var(--gold); }
  .hero-sub {
    margin-top: 1.5rem; font-size: .9rem; letter-spacing: .08em;
    color: var(--muted); max-width: 420px; margin-inline: auto;
    opacity: 0; animation: fadeUp .8s .7s forwards;
  }
  .hero-ctas {
    margin-top: 3rem; display: flex; gap: 1.2rem; justify-content: center; flex-wrap: wrap;
    opacity: 0; animation: fadeUp .8s .9s forwards;
  }
  .btn-gold {
    background: var(--gold); color: var(--bg);
    border: none; padding: .9rem 2.4rem;
    font-family: 'Jost', sans-serif; font-size: .8rem;
    letter-spacing: .18em; text-transform: uppercase; cursor: pointer;
    transition: background .25s, transform .2s; text-decoration: none; display: inline-block;
  }
  .btn-gold:hover { background: var(--gold-light); transform: translateY(-2px); }
  .btn-outline {
    background: transparent; color: var(--cream);
    border: 1px solid rgba(245,239,230,.3); padding: .9rem 2.4rem;
    font-family: 'Jost', sans-serif; font-size: .8rem;
    letter-spacing: .18em; text-transform: uppercase; cursor: pointer;
    transition: border-color .25s, color .25s; text-decoration: none; display: inline-block;
  }
  .btn-outline:hover { border-color: var(--cream); }
  .hero-scroll {
    position: absolute; bottom: 2.5rem; left: 50%; transform: translateX(-50%);
    display: flex; flex-direction: column; align-items: center; gap: .5rem;
    font-size: .65rem; letter-spacing: .25em; text-transform: uppercase; color: var(--muted);
    opacity: 0; animation: fadeUp .8s 1.2s forwards;
  }
  .scroll-line {
    width: 1px; height: 50px;
    background: linear-gradient(180deg, var(--gold), transparent);
    animation: scrollPulse 2s infinite;
  }
 
  /* ── SECTION COMMONS ── */
  section { padding: 7rem 4rem; }
  .section-label {
    font-size: .68rem; letter-spacing: .4em; text-transform: uppercase;
    color: var(--gold); margin-bottom: 1rem;
  }
  .section-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2.2rem, 5vw, 4rem);
    font-weight: 300; line-height: 1.1; color: var(--cream);
  }
  .section-title em { font-style: italic; color: var(--gold); }
  .divider {
    width: 60px; height: 1px; background: var(--gold);
    margin: 1.5rem 0;
  }
  .divider.center { margin-inline: auto; }
 
  /* ── MENU ── */
  #menu { background: var(--bg2); }
  .menu-header { text-align: center; margin-bottom: 4rem; }
  .menu-tabs {
    display: flex; justify-content: center; gap: 0; margin-bottom: 3rem;
    border: 1px solid var(--border); width: fit-content; margin-inline: auto;
  }
  .tab-btn {
    background: transparent; border: none; color: var(--muted);
    padding: .7rem 1.8rem; cursor: pointer;
    font-family: 'Jost', sans-serif; font-size: .75rem;
    letter-spacing: .15em; text-transform: uppercase;
    transition: background .25s, color .25s;
    border-right: 1px solid var(--border);
  }
  .tab-btn:last-child { border-right: none; }
  .tab-btn.active { background: var(--gold); color: var(--bg); }
  .menu-grid {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem; max-width: 1200px; margin-inline: auto;
  }
  .menu-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    padding: 0; overflow: hidden; cursor: pointer;
    transition: transform .3s, box-shadow .3s;
    position: relative;
  }
  .menu-card:hover { transform: translateY(-6px); box-shadow: 0 20px 60px rgba(0,0,0,.5); }
  .menu-card-img {
    width: 100%; height: 200px; object-fit: cover;
    display: block; transition: transform .5s;
    background: #1e1a12;
  }
  .menu-card:hover .menu-card-img { transform: scale(1.05); }
  .menu-card-img-wrap { overflow: hidden; position: relative; }
  .menu-card-badge {
    position: absolute; top: 1rem; right: 1rem;
    background: var(--gold); color: var(--bg);
    font-size: .65rem; letter-spacing: .15em; text-transform: uppercase;
    padding: .25rem .6rem;
  }
  .menu-card-body { padding: 1.5rem; }
  .menu-card-name {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.4rem; font-weight: 400; color: var(--cream);
    margin-bottom: .3rem;
  }
  .menu-card-desc { font-size: .82rem; color: var(--muted); margin-bottom: 1rem; }
  .menu-card-footer { display: flex; justify-content: space-between; align-items: center; }
  .menu-card-price {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.3rem; color: var(--gold);
  }
  .menu-card-tag {
    font-size: .65rem; letter-spacing: .1em; color: var(--muted);
    border: 1px solid var(--border); padding: .2rem .6rem;
  }
  .menu-tab-content { display: none; }
  .menu-tab-content.active { display: block; }
 
  /* ── ABOUT ── */
  #about {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 6rem; align-items: center; max-width: 1200px; margin-inline: auto;
  }
  .about-img-wrap { position: relative; }
  .about-img {
    width: 100%; aspect-ratio: 3/4; object-fit: cover;
    background: linear-gradient(135deg, #1e1a12, #2a2015);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Cormorant Garamond', serif; font-size: 5rem;
    color: var(--gold); opacity: .3; position: relative;
  }
  .about-img-placeholder {
    width: 100%; aspect-ratio: 3/4;
    background: linear-gradient(135deg, #1e1a12, #2a2015);
    border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
  }
  .about-img-deco {
    position: absolute; bottom: -2rem; right: -2rem;
    width: 200px; height: 200px;
    border: 1px solid var(--border);
    background: var(--bg2); z-index: -1;
  }
  .about-stats {
    display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-top: 3rem;
  }
  .stat { border-left: 1px solid var(--border); padding-left: 1.2rem; }
  .stat-num {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2.5rem; color: var(--gold); line-height: 1;
  }
  .stat-label { font-size: .75rem; letter-spacing: .1em; color: var(--muted); text-transform: uppercase; }
 
  /* ── GALLERY ── */
  #gallery { background: var(--bg2); text-align: center; }
  .gallery-header { margin-bottom: 3rem; }
  .gallery-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-template-rows: auto;
    gap: 1rem; max-width: 1200px; margin-inline: auto;
  }
  .gallery-item {
    overflow: hidden; cursor: pointer; position: relative;
    background: var(--card-bg); border: 1px solid var(--border);
  }
  .gallery-item:nth-child(1) { grid-column: span 2; grid-row: span 2; }
  .gallery-item:nth-child(4) { grid-column: span 2; }
  .gallery-placeholder {
    width: 100%; padding-bottom: 75%; position: relative;
    background: linear-gradient(135deg, #1e1a12 0%, #2a2015 100%);
    display: flex; align-items: center; justify-content: center;
  }
  .gallery-item:nth-child(1) .gallery-placeholder { padding-bottom: 75%; }
  .gallery-placeholder-inner {
    position: absolute; inset: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 3rem; opacity: .25;
  }
  .gallery-overlay {
    position: absolute; inset: 0;
    background: rgba(13,11,8,.5);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; transition: opacity .3s;
  }
  .gallery-item:hover .gallery-overlay { opacity: 1; }
  .gallery-overlay-icon {
    width: 48px; height: 48px; border: 1px solid var(--gold);
    display: flex; align-items: center; justify-content: center;
    color: var(--gold); font-size: 1.2rem;
  }
 
  /* Lightbox */
  .lightbox {
    display: none; position: fixed; inset: 0; z-index: 2000;
    background: rgba(0,0,0,.95);
    align-items: center; justify-content: center;
  }
  .lightbox.open { display: flex; }
  .lightbox-inner {
    max-width: 800px; width: 90%;
    background: var(--card-bg); border: 1px solid var(--border);
    position: relative; padding: 2rem;
    animation: scaleIn .3s ease;
  }
  .lightbox-close {
    position: absolute; top: 1rem; right: 1rem;
    background: none; border: none; color: var(--cream);
    font-size: 1.5rem; cursor: pointer; line-height: 1;
  }
  .lightbox-img {
    width: 100%; aspect-ratio: 16/9;
    background: linear-gradient(135deg, #1e1a12, #2a2015);
    display: flex; align-items: center; justify-content: center;
    font-size: 6rem; opacity: .3;
    margin-bottom: 1rem;
  }
  .lightbox-caption {
    font-family: 'Cormorant Garamond', serif; font-size: 1.3rem; color: var(--cream);
  }
  .lightbox-sub { font-size: .82rem; color: var(--muted); margin-top: .3rem; }
 
  /* ── RESERVATIONS ── */
  #reservations {
    background: linear-gradient(160deg, #0d0b08 0%, #1a1208 100%);
    position: relative;
  }
  .reservation-inner {
    max-width: 1100px; margin-inline: auto;
    display: grid; grid-template-columns: 1fr 1.4fr; gap: 6rem; align-items: start;
  }
  .reservation-info { position: sticky; top: 8rem; }
  .res-detail { margin-top: 2.5rem; display: flex; flex-direction: column; gap: 1.5rem; }
  .res-item { display: flex; gap: 1rem; align-items: flex-start; }
  .res-icon {
    width: 36px; height: 36px; border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    color: var(--gold); flex-shrink: 0; font-size: .9rem;
  }
  .res-item-title { font-size: .75rem; letter-spacing: .12em; text-transform: uppercase; color: var(--muted); }
  .res-item-val { color: var(--cream); font-size: .92rem; }
  form { display: flex; flex-direction: column; gap: 1.2rem; }
  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; }
  .form-group { display: flex; flex-direction: column; gap: .4rem; }
  label { font-size: .72rem; letter-spacing: .15em; text-transform: uppercase; color: var(--muted); }
  input, select, textarea {
    background: rgba(255,255,255,.04); border: 1px solid var(--border);
    color: var(--cream); padding: .8rem 1rem;
    font-family: 'Jost', sans-serif; font-size: .88rem;
    outline: none; transition: border-color .25s;
    width: 100%;
  }
  input:focus, select:focus, textarea:focus { border-color: var(--gold); }
  input::placeholder, textarea::placeholder { color: var(--muted); }
  select option { background: var(--bg); }
  textarea { resize: vertical; min-height: 100px; }
  .form-error { font-size: .75rem; color: #e07060; display: none; margin-top: .2rem; }
  .form-group.error input,
  .form-group.error select,
  .form-group.error textarea { border-color: #9b3a2a; }
  .form-group.error .form-error { display: block; }
  .form-success {
    display: none; background: rgba(201,168,76,.1);
    border: 1px solid var(--gold); padding: 1.5rem;
    text-align: center;
  }
  .form-success.show { display: block; }
  .form-success-title {
    font-family: 'Cormorant Garamond', serif; font-size: 1.8rem; color: var(--gold);
  }
 
  /* ── CONTACT ── */
  #contact { background: var(--bg2); }
  .contact-inner { max-width: 1100px; margin-inline: auto; }
  .contact-grid {
    display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 2rem; margin-top: 3rem;
  }
  .contact-card {
    border: 1px solid var(--border); padding: 2rem;
    text-align: center; transition: border-color .25s;
  }
  .contact-card:hover { border-color: var(--gold); }
  .contact-card-icon {
    width: 56px; height: 56px; border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    color: var(--gold); font-size: 1.3rem; margin: 0 auto 1.2rem;
  }
  .contact-card-title {
    font-family: 'Cormorant Garamond', serif; font-size: 1.3rem; margin-bottom: .5rem;
  }
  .contact-card-text { font-size: .85rem; color: var(--muted); line-height: 1.6; }
  .map-placeholder {
    margin-top: 3rem; width: 100%; height: 300px;
    background: linear-gradient(135deg, #131109, #1e1a12);
    border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Cormorant Garamond', serif; font-size: 1.5rem;
    color: var(--muted); gap: .5rem;
  }
 
  /* ── FOOTER ── */
  footer {
    background: #080705; border-top: 1px solid var(--border);
    padding: 3rem 4rem; text-align: center;
  }
  .footer-logo {
    font-family: 'Cormorant Garamond', serif; font-size: 2rem;
    color: var(--gold); font-weight: 300; letter-spacing: .1em;
    margin-bottom: .5rem;
  }
  .footer-text { font-size: .78rem; color: var(--muted); letter-spacing: .08em; }
  .footer-links { display: flex; justify-content: center; gap: 2rem; margin: 1.5rem 0; }
  .footer-links a {
    color: var(--muted); text-decoration: none; font-size: .75rem;
    letter-spacing: .12em; text-transform: uppercase;
    transition: color .25s;
  }
  .footer-links a:hover { color: var(--gold); }
 
  /* ── ANIMATIONS ── */
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  @keyframes scrollPulse {
    0%, 100% { opacity: .4; }
    50%       { opacity: 1; }
  }
  @keyframes scaleIn {
    from { transform: scale(.92); opacity: 0; }
    to   { transform: scale(1); opacity: 1; }
  }
  .reveal {
    opacity: 0; transform: translateY(30px);
    transition: opacity .8s, transform .8s;
  }
  .reveal.visible { opacity: 1; transform: none; }
 
  /* ── RESPONSIVE ── */
  @media (max-width: 900px) {
    nav { padding: 1rem 1.5rem; }
    .nav-links { display: none; }
    .hamburger { display: flex; }
    section { padding: 5rem 1.5rem; }
    #about { grid-template-columns: 1fr; gap: 3rem; }
    .gallery-grid { grid-template-columns: 1fr 1fr; }
    .gallery-item:nth-child(1) { grid-column: span 2; }
    .gallery-item:nth-child(4) { grid-column: span 1; }
    .reservation-inner { grid-template-columns: 1fr; gap: 3rem; }
    .reservation-info { position: static; }
    .contact-grid { grid-template-columns: 1fr; }
    .form-row { grid-template-columns: 1fr; }
    .hero-title { font-size: 3.5rem; }
  }
  @media (max-width: 600px) {
    .gallery-grid { grid-template-columns: 1fr; }
    .gallery-item:nth-child(1),
    .gallery-item:nth-child(4) { grid-column: span 1; }
    .about-stats { grid-template-columns: 1fr 1fr; }
  }
 
  /* Mobile nav */
  .mobile-nav {
    display: none; position: fixed; inset: 0; z-index: 999;
    background: rgba(13,11,8,.97); backdrop-filter: blur(12px);
    flex-direction: column; align-items: center; justify-content: center; gap: 2rem;
  }
  .mobile-nav.open { display: flex; }
  .mobile-nav a {
    color: var(--cream); text-decoration: none;
    font-family: 'Cormorant Garamond', serif; font-size: 2rem;
    font-weight: 300; letter-spacing: .08em;
    transition: color .25s;
  }
  .mobile-nav a:hover { color: var(--gold); }
  .mobile-nav-close {
    position: absolute; top: 1.5rem; right: 1.5rem;
    background: none; border: none; color: var(--cream);
    font-size: 1.5rem; cursor: pointer;
  }
</style>
</head>
<body>
 
<!-- ══ NAVIGATION ══ -->
<nav id="navbar">
  <a href="#home" class="nav-logo">Ember <span>&</span> Oak</a>
  <ul class="nav-links">
    <li><a href="#home">Home</a></li>
    <li><a href="#menu">Menu</a></li>
    <li><a href="#about">About</a></li>
    <li><a href="#gallery">Gallery</a></li>
    <li><a href="#reservations">Reservations</a></li>
    <li><a href="#contact">Contact</a></li>
  </ul>
  <a href="#reservations" class="nav-reserve">Reserve a Table</a>
  <div class="hamburger" id="hamburger" onclick="openMobileNav()">
    <span></span><span></span><span></span>
  </div>
</nav>
 
<!-- Mobile Nav -->
<div class="mobile-nav" id="mobileNav">
  <button class="mobile-nav-close" onclick="closeMobileNav()">✕</button>
  <a href="#home" onclick="closeMobileNav()">Home</a>
  <a href="#menu" onclick="closeMobileNav()">Menu</a>
  <a href="#about" onclick="closeMobileNav()">About</a>
  <a href="#gallery" onclick="closeMobileNav()">Gallery</a>
  <a href="#reservations" onclick="closeMobileNav()">Reservations</a>
  <a href="#contact" onclick="closeMobileNav()">Contact</a>
</div>
 
<!-- ══ HOME / HERO ══ -->
<section id="home">
  <div class="hero-noise"></div>
  <div class="hero-line"></div>
  <div class="hero-content">
    <p class="hero-eyebrow">Est. 2008 · Fine Dining Experience</p>
    <h1 class="hero-title">Ember<br><em>&</em> Oak</h1>
    <p class="hero-sub">Where flame meets philosophy. A culinary journey through modern heritage cuisine.</p>
    <div class="hero-ctas">
      <a href="#menu" class="btn-gold">Explore Menu</a>
      <a href="#reservations" class="btn-outline">Book a Table</a>
    </div>
  </div>
  <div class="hero-scroll">
    <div class="scroll-line"></div>
    Scroll
  </div>
</section>
 
<!-- ══ MENU ══ -->
<section id="menu">
  <div class="menu-header reveal">
    <p class="section-label">Culinary Journey</p>
    <h2 class="section-title">Our <em>Menu</em></h2>
    <div class="divider center"></div>
    <p style="color:var(--muted);font-size:.9rem;max-width:500px;margin:auto">Crafted with seasonal ingredients, each dish tells a story of provenance and passion.</p>
  </div>
  <div class="menu-tabs reveal">
    <button class="tab-btn active" onclick="switchTab('starters')">Starters</button>
    <button class="tab-btn" onclick="switchTab('mains')">Mains</button>
    <button class="tab-btn" onclick="switchTab('desserts')">Desserts</button>
    <button class="tab-btn" onclick="switchTab('drinks')">Drinks</button>
  </div>
 
  <!-- Starters -->
  <div class="menu-tab-content active" id="tab-starters">
    <div class="menu-grid">
      <div class="menu-card reveal">
        <div class="menu-card-img-wrap">
          <div class="menu-card-img" style="background:linear-gradient(135deg,#2a1f0e,#3d2e14);display:flex;align-items:center;justify-content:center;font-size:3rem;">🦪</div>
          <span class="menu-card-badge">Chef's Pick</span>
        </div>
        <div class="menu-card-body">
          <div class="menu-card-name">Oysters Rockefeller</div>
          <div class="menu-card-desc">Half-shell oysters baked with spinach, Pernod cream, and herb breadcrumbs</div>
          <div class="menu-card-footer">
            <span class="menu-card-price">₹1,850</span>
            <span class="menu-card-tag">Seafood</span>
          </div>
        </div>
      </div>
      <div class="menu-card reveal">
        <div class="menu-card-img-wrap">
          <div class="menu-card-img" style="background:linear-gradient(135deg,#1a2a1a,#243524);display:flex;align-items:center;justify-content:center;font-size:3rem;">🥗</div>
        </div>
        <div class="menu-card-body">
          <div class="menu-card-name">Burrata & Heritage Tomato</div>
          <div class="menu-card-desc">Creamy burrata, heirloom tomatoes, aged balsamic, micro basil, sea salt</div>
          <div class="menu-card-footer">
            <span class="menu-card-price">₹1,350</span>
            <span class="menu-card-tag">Vegetarian</span>
          </div>
        </div>
      </div>
      <div class="menu-card reveal">
        <div class="menu-card-img-wrap">
          <div class="menu-card-img" style="background:linear-gradient(135deg,#2a1a0e,#3d2a14);display:flex;align-items:center;justify-content:center;font-size:3rem;">🍄</div>
        </div>
        <div class="menu-card-body">
          <div class="menu-card-name">Wild Mushroom Velouté</div>
          <div class="menu-card-desc">Silky forest mushroom soup, truffle oil, chive crème fraîche, sourdough crisp</div>
          <div class="menu-card-footer">
            <span class="menu-card-price">₹980</span>
            <span class="menu-card-tag">Signature</span>
          </div>
        </div>
      </div>
    </div>
  </div>
 
  <!-- Mains -->
  <div class="menu-tab-content" id="tab-mains">
    <div class="menu-grid">
      <div class="menu-card reveal">
        <div class="menu-card-img-wrap">
          <div class="menu-card-img" style="background:linear-gradient(135deg,#2a0e0e,#3d1414);display:flex;align-items:center;justify-content:center;font-size:3rem;">🥩</div>
          <span class="menu-card-badge">Signature</span>
        </div>
        <div class="menu-card-body">
          <div class="menu-card-name">Oak-Smoked Wagyu Fillet</div>
          <div class="menu-card-desc">A5 Wagyu, red wine jus, roasted bone marrow, truffle mashed potato</div>
          <div class="menu-card-footer">
            <span class="menu-card-price">₹7,800</span>
            <span class="menu-card-tag">Premium</span>
          </div>
        </div>
      </div>
      <div class="menu-card reveal">
        <div class="menu-card-img-wrap">
          <div class="menu-card-img" style="background:linear-gradient(135deg,#0e1f2a,#142d3d);display:flex;align-items:center;justify-content:center;font-size:3rem;">🐟</div>
        </div>
        <div class="menu-card-body">
          <div class="menu-card-name">Pan-Seared Sea Bass</div>
          <div class="menu-card-desc">Line-caught sea bass, saffron beurre blanc, fennel confit, caviar pearls</div>
          <div class="menu-card-footer">
            <span class="menu-card-price">₹3,200</span>
            <span class="menu-card-tag">Seafood</span>
          </div>
        </div>
      </div>
      <div class="menu-card reveal">
        <div class="menu-card-img-wrap">
          <div class="menu-card-img" style="background:linear-gradient(135deg,#1a200e,#253014);display:flex;align-items:center;justify-content:center;font-size:3rem;">🌿</div>
        </div>
        <div class="menu-card-body">
          <div class="menu-card-name">Garden Harvest Risotto</div>
          <div class="menu-card-desc">Carnaroli rice, aged parmesan, seasonal vegetables, lemon oil, herb dust</div>
          <div class="menu-card-footer">
            <span class="menu-card-price">₹1,950</span>
            <span class="menu-card-tag">Vegetarian</span>
          </div>
        </div>
      </div>
    </div>
  </div>
 
  <!-- Desserts -->
  <div class="menu-tab-content" id="tab-desserts">
    <div class="menu-grid">
      <div class="menu-card reveal">
        <div class="menu-card-img-wrap">
          <div class="menu-card-img" style="background:linear-gradient(135deg,#2a1a00,#3d2a00);display:flex;align-items:center;justify-content:center;font-size:3rem;">🍮</div>
          <span class="menu-card-badge">Award Winning</span>
        </div>
        <div class="menu-card-body">
          <div class="menu-card-name">Crème Brûlée</div>
          <div class="menu-card-desc">Vanilla bean custard, caramelized sugar crust, seasonal berry compote</div>
          <div class="menu-card-footer">
            <span class="menu-card-price">₹780</span>
            <span class="menu-card-tag">Classic</span>
          </div>
        </div>
      </div>
      <div class="menu-card reveal">
        <div class="menu-card-img-wrap">
          <div class="menu-card-img" style="background:linear-gradient(135deg,#1a0e1a,#2a142a);display:flex;align-items:center;justify-content:center;font-size:3rem;">🍫</div>
        </div>
        <div class="menu-card-body">
          <div class="menu-card-name">Dark Chocolate Fondant</div>
          <div class="menu-card-desc">Valrhona 72% chocolate, molten center, salted caramel ice cream, gold leaf</div>
          <div class="menu-card-footer">
            <span class="menu-card-price">₹920</span>
            <span class="menu-card-tag">Indulgent</span>
          </div>
        </div>
      </div>
      <div class="menu-card reveal">
        <div class="menu-card-img-wrap">
          <div class="menu-card-img" style="background:linear-gradient(135deg,#0e1a2a,#14253d);display:flex;align-items:center;justify-content:center;font-size:3rem;">🍧</div>
        </div>
        <div class="menu-card-body">
          <div class="menu-card-name">Mango Panna Cotta</div>
          <div class="menu-card-desc">Italian set cream, Alphonso mango coulis, candied pistachios, edible flowers</div>
          <div class="menu-card-footer">
            <span class="menu-card-price">₹650</span>
            <span class="menu-card-tag">Seasonal</span>
          </div>
        </div>
      </div>
    </div>
  </div>
 
  <!-- Drinks -->
  <div class="menu-tab-content" id="tab-drinks">
    <div class="menu-grid">
      <div class="menu-card reveal">
        <div class="menu-card-img-wrap">
          <div class="menu-card-img" style="background:linear-gradient(135deg,#1a0e0e,#2a1414);display:flex;align-items:center;justify-content:center;font-size:3rem;">🍷</div>
          <span class="menu-card-badge">Sommelier's Choice</span>
        </div>
        <div class="menu-card-body">
          <div class="menu-card-name">Barolo Reserve 2018</div>
          <div class="menu-card-desc">Full-bodied Nebbiolo from Piedmont, notes of tar, rose, and dried cherry</div>
          <div class="menu-card-footer">
            <span class="menu-card-price">₹4,200</span>
            <span class="menu-card-tag">Wine</span>
          </div>
        </div>
      </div>
      <div class="menu-card reveal">
        <div class="menu-card-img-wrap">
          <div class="menu-card-img" style="background:linear-gradient(135deg,#0e1a1a,#14282a);display:flex;align-items:center;justify-content:center;font-size:3rem;">🍸</div>
        </div>
        <div class="menu-card-body">
          <div class="menu-card-name">Ember Old Fashioned</div>
          <div class="menu-card-desc">Smoked bourbon, demerara syrup, Angostura bitters, charred orange peel</div>
          <div class="menu-card-footer">
            <span class="menu-card-price">₹1,100</span>
            <span class="menu-card-tag">Cocktail</span>
          </div>
        </div>
      </div>
      <div class="menu-card reveal">
        <div class="menu-card-img-wrap">
          <div class="menu-card-img" style="background:linear-gradient(135deg,#1a1a0e,#2a2a14);display:flex;align-items:center;justify-content:center;font-size:3rem;">🫖</div>
        </div>
        <div class="menu-card-body">
          <div class="menu-card-name">Japanese Senchai Flight</div>
          <div class="menu-card-desc">Three premium green teas served ceremonially with seasonal wagashi</div>
          <div class="menu-card-footer">
            <span class="menu-card-price">₹580</span>
            <span class="menu-card-tag">Non-Alcoholic</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
 
<!-- ══ ABOUT ══ -->
<section style="padding:7rem 4rem;">
  <div id="about">
    <div class="about-img-wrap reveal">
      <div class="about-img-placeholder">
        <div style="text-align:center;color:var(--gold);opacity:.3;font-family:'Cormorant Garamond',serif;font-size:5rem;">🔥</div>
      </div>
      <div class="about-img-deco"></div>
    </div>
    <div class="reveal">
      <p class="section-label">Our Story</p>
      <h2 class="section-title">Culinary <em>Philosophy</em></h2>
      <div class="divider"></div>
      <p style="color:var(--muted);font-size:.92rem;margin-bottom:1.2rem;">
        Founded in 2008 by Chef Marcus Whitfield, Ember & Oak was born from a singular obsession: the transformative power of live fire. Every dish that leaves our kitchen carries the soul of ancient technique and the precision of modern gastronomy.
      </p>
      <p style="color:var(--muted);font-size:.92rem;margin-bottom:1.2rem;">
        We source our ingredients within a 200-kilometre radius, forging relationships with farmers, fishermen, and foragers who share our reverence for the land. The oak wood that names us comes from a single estate in Tamil Nadu — it perfumes our kitchen and every memory made within it.
      </p>
      <p style="color:var(--muted);font-size:.92rem;">
        Three Michelin stars later, we remain committed to the same truth: great cooking is an act of profound generosity.
      </p>
      <div class="about-stats">
        <div class="stat">
          <div class="stat-num">17</div>
          <div class="stat-label">Years of Excellence</div>
        </div>
        <div class="stat">
          <div class="stat-num">3★</div>
          <div class="stat-label">Michelin Stars</div>
        </div>
        <div class="stat">
          <div class="stat-num">48</div>
          <div class="stat-label">Covers Nightly</div>
        </div>
        <div class="stat">
          <div class="stat-num">200+</div>
          <div class="stat-label">Wine Labels</div>
        </div>
      </div>
    </div>
  </div>
</section>
 
<!-- ══ GALLERY ══ -->
<section id="gallery">
  <div class="gallery-header reveal">
    <p class="section-label">Visual Story</p>
    <h2 class="section-title">The <em>Gallery</em></h2>
    <div class="divider center"></div>
  </div>
  <div class="gallery-grid">
    <div class="gallery-item reveal" onclick="openLightbox('The Main Dining Room','An intimate space for 48 covers, lit by hand-blown glass pendants','🍽️')">
      <div class="gallery-placeholder"><div class="gallery-placeholder-inner" style="font-size:6rem;">🍽️</div></div>
      <div class="gallery-overlay"><div class="gallery-overlay-icon">⊕</div></div>
    </div>
    <div class="gallery-item reveal" onclick="openLightbox('Kitchen in Motion','Chef Whitfield at the hearth during evening service','👨‍🍳')">
      <div class="gallery-placeholder"><div class="gallery-placeholder-inner" style="font-size:4rem;">👨‍🍳</div></div>
      <div class="gallery-overlay"><div class="gallery-overlay-icon">⊕</div></div>
    </div>
    <div class="gallery-item reveal" onclick="openLightbox('Private Cellar','Over 200 labels curated by our head sommelier','🍷')">
      <div class="gallery-placeholder"><div class="gallery-placeholder-inner" style="font-size:4rem;">🍷</div></div>
      <div class="gallery-overlay"><div class="gallery-overlay-icon">⊕</div></div>
    </div>
    <div class="gallery-item reveal" onclick="openLightbox('Wagyu Fillet','Our signature A5 Wagyu, plated tableside','🥩')">
      <div class="gallery-placeholder"><div class="gallery-placeholder-inner" style="font-size:4rem;">🥩</div></div>
      <div class="gallery-overlay"><div class="gallery-overlay-icon">⊕</div></div>
    </div>
    <div class="gallery-item reveal" onclick="openLightbox('The Garden Terrace','Al fresco dining surrounded by herb gardens','🌿')">
      <div class="gallery-placeholder"><div class="gallery-placeholder-inner" style="font-size:4rem;">🌿</div></div>
      <div class="gallery-overlay"><div class="gallery-overlay-icon">⊕</div></div>
    </div>
    <div class="gallery-item reveal" onclick="openLightbox('Dessert Architecture','Crème Brûlée — our award-winning dessert','🍮')">
      <div class="gallery-placeholder"><div class="gallery-placeholder-inner" style="font-size:4rem;">🍮</div></div>
      <div class="gallery-overlay"><div class="gallery-overlay-icon">⊕</div></div>
    </div>
  </div>
</section>
 
<!-- Lightbox -->
<div class="lightbox" id="lightbox" onclick="closeLightbox(event)">
  <div class="lightbox-inner">
    <button class="lightbox-close" onclick="closeLightbox()">✕</button>
    <div class="lightbox-img" id="lightbox-img"></div>
    <div class="lightbox-caption" id="lightbox-caption"></div>
    <div class="lightbox-sub" id="lightbox-sub"></div>
  </div>
</div>
 
<!-- ══ RESERVATIONS ══ -->
<section id="reservations">
  <div class="reservation-inner">
    <div class="reservation-info reveal">
      <p class="section-label">Book Your Table</p>
      <h2 class="section-title">Make a <em>Reservation</em></h2>
      <div class="divider"></div>
      <p style="color:var(--muted);font-size:.88rem;margin-bottom:1rem;">
        We accept reservations up to 60 days in advance. For parties of 8 or more, please call us directly.
      </p>
      <div class="res-detail">
        <div class="res-item">
          <div class="res-icon">🕐</div>
          <div>
            <div class="res-item-title">Dinner Hours</div>
            <div class="res-item-val">Tuesday – Sunday<br>6:30 PM – 10:30 PM</div>
          </div>
        </div>
        <div class="res-item">
          <div class="res-icon">📍</div>
          <div>
            <div class="res-item-title">Location</div>
            <div class="res-item-val">12, Nungambakkam High Road<br>Chennai, Tamil Nadu 600034</div>
          </div>
        </div>
        <div class="res-item">
          <div class="res-icon">📞</div>
          <div>
            <div class="res-item-title">Telephone</div>
            <div class="res-item-val">+91 44 4321 9876</div>
          </div>
        </div>
      </div>
    </div>
 
    <div class="reveal">
      <div class="form-success" id="formSuccess">
        <div class="form-success-title">Reservation Confirmed</div>
        <p style="color:var(--muted);margin-top:.5rem;font-size:.88rem;">
          Thank you! A confirmation has been sent to your email.<br>We look forward to welcoming you.
        </p>
      </div>
      <form id="reservationForm" onsubmit="submitReservation(event)">
        <div class="form-row">
          <div class="form-group" id="fg-fname">
            <label for="fname">First Name</label>
            <input type="text" id="fname" placeholder="Marcus">
            <span class="form-error">Please enter your first name.</span>
          </div>
          <div class="form-group" id="fg-lname">
            <label for="lname">Last Name</label>
            <input type="text" id="lname" placeholder="Whitfield">
            <span class="form-error">Please enter your last name.</span>
          </div>
        </div>
        <div class="form-group" id="fg-email">
          <label for="email">Email Address</label>
          <input type="email" id="email" placeholder="hello@example.com">
          <span class="form-error">Please enter a valid email address.</span>
        </div>
        <div class="form-group" id="fg-phone">
          <label for="phone">Phone Number</label>
          <input type="tel" id="phone" placeholder="+91 98765 43210">
          <span class="form-error">Please enter your phone number.</span>
        </div>
        <div class="form-row">
          <div class="form-group" id="fg-date">
            <label for="date">Date</label>
            <input type="date" id="date">
            <span class="form-error">Please select a date.</span>
          </div>
          <div class="form-group" id="fg-time">
            <label for="time">Preferred Time</label>
            <select id="time">
              <option value="">Select time</option>
              <option>6:30 PM</option>
              <option>7:00 PM</option>
              <option>7:30 PM</option>
              <option>8:00 PM</option>
              <option>8:30 PM</option>
              <option>9:00 PM</option>
            </select>
            <span class="form-error">Please select a time.</span>
          </div>
        </div>
        <div class="form-group" id="fg-guests">
          <label for="guests">Number of Guests</label>
          <select id="guests">
            <option value="">Select guests</option>
            <option>1 Guest</option>
            <option>2 Guests</option>
            <option>3 Guests</option>
            <option>4 Guests</option>
            <option>5 Guests</option>
            <option>6 Guests</option>
            <option>7 Guests</option>
          </select>
          <span class="form-error">Please select number of guests.</span>
        </div>
        <div class="form-group">
          <label for="notes">Special Requests (Optional)</label>
          <textarea id="notes" placeholder="Dietary requirements, special occasions, seating preferences…"></textarea>
        </div>
        <button type="submit" class="btn-gold" style="width:100%;margin-top:.5rem;">Confirm Reservation</button>
      </form>
    </div>
  </div>
</section>
 
<!-- ══ CONTACT ══ -->
<section id="contact">
  <div class="contact-inner">
    <div class="reveal" style="text-align:center;">
      <p class="section-label">Get In Touch</p>
      <h2 class="section-title">Contact <em>Us</em></h2>
      <div class="divider center"></div>
    </div>
    <div class="contact-grid">
      <div class="contact-card reveal">
        <div class="contact-card-icon">📍</div>
        <div class="contact-card-title">Visit Us</div>
        <div class="contact-card-text">12, Nungambakkam High Road<br>Chennai, Tamil Nadu 600034<br>India</div>
      </div>
      <div class="contact-card reveal">
        <div class="contact-card-icon">📞</div>
        <div class="contact-card-title">Call Us</div>
        <div class="contact-card-text">+91 44 4321 9876<br>+91 98765 43210<br>Tue – Sun · 11 AM – 11 PM</div>
      </div>
      <div class="contact-card reveal">
        <div class="contact-card-icon">✉️</div>
        <div class="contact-card-title">Write to Us</div>
        <div class="contact-card-text">hello@emberandoak.in<br>events@emberandoak.in<br>We reply within 24 hours</div>
      </div>
    </div>
    <div class="map-placeholder reveal">
      <span>📍</span> Nungambakkam, Chennai
    </div>
  </div>
</section>
 
<!-- ══ FOOTER ══ -->
<footer>
  <div class="footer-logo">Ember & Oak</div>
  <div class="footer-links">
    <a href="#home">Home</a>
    <a href="#menu">Menu</a>
    <a href="#about">About</a>
    <a href="#gallery">Gallery</a>
    <a href="#reservations">Reservations</a>
    <a href="#contact">Contact</a>
  </div>
  <div class="footer-text">© 2025 Ember & Oak Fine Dining · 12 Nungambakkam High Road, Chennai</div>
</footer>
 
<script>
// ── NAV SCROLL ──
window.addEventListener('scroll', () => {
  document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 60);
});
 
// ── MOBILE NAV ──
function openMobileNav() { document.getElementById('mobileNav').classList.add('open'); }
function closeMobileNav() { document.getElementById('mobileNav').classList.remove('open'); }
 
// ── MENU TABS ──
function switchTab(tab) {
  document.querySelectorAll('.menu-tab-content').forEach(el => el.classList.remove('active'));
  document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
  document.getElementById('tab-' + tab).classList.add('active');
  event.currentTarget.classList.add('active');
}
 
// ── GALLERY LIGHTBOX ──
function openLightbox(title, sub, emoji) {
  const lb = document.getElementById('lightbox');
  document.getElementById('lightbox-img').textContent = emoji;
  document.getElementById('lightbox-img').style.fontSize = '8rem';
  document.getElementById('lightbox-caption').textContent = title;
  document.getElementById('lightbox-sub').textContent = sub;
  lb.classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closeLightbox(e) {
  if (!e || e.target === document.getElementById('lightbox') || e.target.classList.contains('lightbox-close')) {
    document.getElementById('lightbox').classList.remove('open');
    document.body.style.overflow = '';
  }
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLightbox({ target: document.getElementById('lightbox') }); });
 
// ── RESERVATION FORM VALIDATION ──
function submitReservation(e) {
  e.preventDefault();
  let valid = true;
  const checks = [
    { id: 'fname',  fg: 'fg-fname',  fn: v => v.trim().length > 0 },
    { id: 'lname',  fg: 'fg-lname',  fn: v => v.trim().length > 0 },
    { id: 'email',  fg: 'fg-email',  fn: v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v) },
    { id: 'phone',  fg: 'fg-phone',  fn: v => v.trim().length >= 7 },
    { id: 'date',   fg: 'fg-date',   fn: v => v !== '' },
    { id: 'time',   fg: 'fg-time',   fn: v => v !== '' },
    { id: 'guests', fg: 'fg-guests', fn: v => v !== '' },
  ];
 
  checks.forEach(({ id, fg, fn }) => {
    const el = document.getElementById(id);
    const fgEl = document.getElementById(fg);
    const ok = fn(el.value);
    fgEl.classList.toggle('error', !ok);
    if (!ok) valid = false;
  });
 
  if (!valid) return;
 
  // Simulate PHP backend submission
  const btn = e.target.querySelector('button[type="submit"]');
  btn.textContent = 'Processing…';
  btn.disabled = true;
 
  // Collect booking data (mirrors PHP $_POST)
  const bookingData = {
    first_name: document.getElementById('fname').value,
    last_name:  document.getElementById('lname').value,
    email:      document.getElementById('email').value,
    phone:      document.getElementById('phone').value,
    date:       document.getElementById('date').value,
    time:       document.getElementById('time').value,
    guests:     document.getElementById('guests').value,
    notes:      document.getElementById('notes').value,
    submitted:  new Date().toISOString()
  };
 
  // Store in localStorage (simulating DB insert)
  const stored = JSON.parse(localStorage.getItem('ember_bookings') || '[]');
  stored.push(bookingData);
  localStorage.setItem('ember_bookings', JSON.stringify(stored));
  console.table(bookingData); // Simulates server-side log
 
  setTimeout(() => {
    document.getElementById('reservationForm').style.display = 'none';
    document.getElementById('formSuccess').classList.add('show');
  }, 1200);
}
 
// ── SCROLL REVEAL ──
const revealEls = document.querySelectorAll('.reveal');
const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry, i) => {
    if (entry.isIntersecting) {
      setTimeout(() => entry.target.classList.add('visible'), i * 80);
      observer.unobserve(entry.target);
    }
  });
}, { threshold: 0.12 });
revealEls.forEach(el => observer.observe(el));
 
// ── SET MIN DATE ──
const dateInput = document.getElementById('date');
const today = new Date().toISOString().split('T')[0];
dateInput.setAttribute('min', today);
</script>
 
<!--
╔══════════════════════════════════════════╗
║         PHP BACKEND (reserve.php)        ║
╚══════════════════════════════════════════╝
 
<?php
// reserve.php — Reservation form handler
// Database config
define('DB_HOST', 'localhost');
define('DB_NAME', 'ember_oak');
define('DB_USER', 'root');
define('DB_PASS', 'your_password');
 
header('Content-Type: application/json');
 
// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    exit;
}
 
// Sanitize inputs
function clean($val) {
    return htmlspecialchars(strip_tags(trim($val)));
}
 
$fname  = clean($_POST['first_name'] ?? '');
$lname  = clean($_POST['last_name']  ?? '');
$email  = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
$phone  = clean($_POST['phone']  ?? '');
$date   = clean($_POST['date']   ?? '');
$time   = clean($_POST['time']   ?? '');
$guests = (int)($_POST['guests'] ?? 0);
$notes  = clean($_POST['notes']  ?? '');
 
// Validation
$errors = [];
if (!$fname)                         $errors[] = 'First name is required';
if (!$lname)                         $errors[] = 'Last name is required';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email required';
if (!$phone)                         $errors[] = 'Phone is required';
if (!$date || strtotime($date) < strtotime('today')) $errors[] = 'Valid future date required';
if (!$time)                          $errors[] = 'Time selection required';
if ($guests < 1 || $guests > 7)     $errors[] = 'Guests must be 1–7';
 
if ($errors) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'errors' => $errors]);
    exit;
}
 
// DB insert
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
 
    $stmt = $pdo->prepare("
        INSERT INTO reservations
            (first_name, last_name, email, phone, date, time, guests, notes, created_at)
        VALUES
            (:fname, :lname, :email, :phone, :date, :time, :guests, :notes, NOW())
    ");
 
    $stmt->execute([
        ':fname'  => $fname,
        ':lname'  => $lname,
        ':email'  => $email,
        ':phone'  => $phone,
        ':date'   => $date,
        ':time'   => $time,
        ':guests' => $guests,
        ':notes'  => $notes,
    ]);
 
    $bookingId = $pdo->lastInsertId();
 
    // Send confirmation email
    $to      = $email;
    $subject = "Reservation Confirmed — Ember & Oak (#$bookingId)";
    $body    = "Dear $fname,\n\nYour table for $guests on $date at $time is confirmed.\n\nEmber & Oak";
    $headers = "From: hello@emberandoak.in\r\nReply-To: hello@emberandoak.in";
    mail($to, $subject, $body, $headers);
 
    echo json_encode([
        'status'     => 'success',
        'booking_id' => $bookingId,
        'message'    => 'Reservation confirmed!'
    ]);
 
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
 
═══════════════════════════════════════
SQL TABLE SCHEMA (reservations)
═══════════════════════════════════════
CREATE TABLE reservations (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    first_name  VARCHAR(100) NOT NULL,
    last_name   VARCHAR(100) NOT NULL,
    email       VARCHAR(255) NOT NULL,
    phone       VARCHAR(30)  NOT NULL,
    date        DATE         NOT NULL,
    time        VARCHAR(20)  NOT NULL,
    guests      TINYINT      NOT NULL,
    notes       TEXT,
    created_at  DATETIME     DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-->
</body>
</html>
 