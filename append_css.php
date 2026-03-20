<?php
$css = <<<CSS

/* =============================================
   Highlighted Nav Links - Hizmet Al & Bakıcı Bul (Full Border Fix)
   ============================================= */
/* Force header and nav containers to show overflow */
.header, 
.header .navbar, 
.header .navbar-nav,
.header .navbar-collapse,
.header .nav-item {
    overflow: visible !important;
}

/* Container for the highlight buttons */
.header .nav-highlight {
    margin: 0 8px; /* More space around buttons */
    padding: 5px 0; /* Vertical space to prevent clipping */
    display: flex;
    align-items: center;
    height: 100%;
}

/* The button itself */
.header .nav-link-highlight {
    color: #0357e9 !important;
    border: 2px solid #0357e9 !important; /* Force border */
    background: transparent;
    border-radius: 50px; /* Full pill shape */
    padding: 8px 20px !important;
    font-weight: 700 !important;
    font-size: 0.92rem !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    gap: 8px;
    line-height: 1.2 !important;
    white-space: nowrap;
    text-decoration: none !important;
    min-width: 140px; /* Minimum width for consistency */
    box-sizing: border-box !important;
}

.header .nav-link-highlight i {
    font-size: 0.9rem;
    margin-top: -1px; /* Optical alignment */
}

.header .nav-link-highlight:hover {
    background: #0357e9;
    color: #fff !important;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(3, 87, 233, 0.3);
    border-color: #0357e9 !important;
}

/* Active state */
.header .nav-highlight.active .nav-link-highlight {
    background: #0357e9;
    color: #fff !important;
    box-shadow: 0 4px 15px rgba(3, 87, 233, 0.25);
}

/* Mobile responsive */
@media (max-width: 991px) {
    .header .nav-highlight {
        margin: 10px 0;
        text-align: center;
        width: 100%;
        justify-content: center;
        display: flex;
    }
    .header .nav-link-highlight {
        width: 100%;
        max-width: 280px;
        padding: 12px 24px !important;
        justify-content: center;
    }
}
CSS;

file_put_contents('c:\wamp64\www\jobsportal\public\css\main.css', $css, FILE_APPEND);
echo "Appended CSS to main.css\n";
