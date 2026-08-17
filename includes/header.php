<?php
$profile = portfolio_profile();
$nav = [
    'home'     => '#home',
    'skills'   => '#skills',
    'projects' => '#projects',
    'contact'  => '#contact',
];
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($profile['name']) ?> — <?= htmlspecialchars($profile['role']) ?></title>
    <meta name="description" content="<?= htmlspecialchars($profile['tagline']) ?>">

    <!-- Theme init (before paint to avoid flash) -->
    <script>
        (function () {
            var t = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', t);
        })();
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS (Play CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['"Space Grotesk"', 'sans-serif'],
                        body: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        base: '#070710',
                        neon: '#22d3ee',
                        neon2: '#a855f7',
                        neon3: '#f472b6',
                    },
                    boxShadow: {
                        'neon': '0 0 40px rgba(34,211,238,.35)',
                        'neon-violet': '0 0 40px rgba(168,85,247,.35)',
                    },
                }
            }
        }
    </script>

    <!-- AOS Scroll Animations -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="bg-base text-slate-200 font-body overflow-x-hidden">

    <!-- Scroll progress bar -->
    <div id="scroll-progress" class="fixed top-0 left-0 h-[3px] z-[60] pointer-events-none" style="width:0%; background:linear-gradient(90deg,#22d3ee,#a855f7,#f472b6); box-shadow:0 0 12px rgba(34,211,238,.6);"></div>

    <!-- Ambient background orbs -->
    <div class="fixed inset-0 -z-10 pointer-events-none overflow-hidden" aria-hidden="true">
        <div class="orb orb-cyan"></div>
        <div class="orb orb-violet"></div>
        <div class="orb orb-pink"></div>
        <div class="grid-overlay"></div>
        <canvas id="particles"></canvas>
    </div>

    <!-- Navbar -->
    <header id="navbar" class="fixed top-0 inset-x-0 z-50 transition-all duration-500">
        <nav class="max-w-6xl mx-auto px-6">
            <div class="flex items-center justify-between h-16">
                <a href="#home" class="font-display text-xl font-bold tracking-tight group">
                    <span class="text-white"><?= htmlspecialchars($profile['short_name']) ?></span>
                </a>

                <ul class="hidden md:flex items-center gap-8 text-sm font-medium">
                    <?php foreach ($nav as $label => $href): ?>
                        <li>
                            <a href="<?= htmlspecialchars($href) ?>"
                               class="nav-link relative text-slate-300 hover:text-white transition-colors duration-300">
                                <?= ucfirst($label) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                    <li>
                        <a href="#contact"
                           class="btn-glow px-5 py-2 rounded-full text-sm font-semibold">
                            Hire Me
                        </a>
                    </li>
                </ul>

                <div class="flex items-center gap-3">
                    <button id="theme-toggle" aria-label="Toggle theme"
                            class="w-9 h-9 rounded-full glass flex items-center justify-center text-slate-300 hover:text-cyan-300 transition-colors duration-300">
                        <i class="fa-solid fa-moon" id="theme-icon"></i>
                    </button>
                    <button id="menu-toggle" class="md:hidden text-2xl text-white" aria-label="Toggle menu">
                        <i class="fa-solid fa-bars" id="menu-icon"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile menu -->
            <div id="mobile-menu" class="md:hidden hidden">
                <ul class="glass rounded-2xl p-6 mb-4 flex flex-col gap-4 text-sm font-medium">
                    <?php foreach ($nav as $label => $href): ?>
                        <li>
                            <a href="<?= htmlspecialchars($href) ?>" class="mobile-link block text-slate-200 hover:text-cyan-300 transition-colors">
                                <?= ucfirst($label) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                    <li>
                        <a href="#contact" class="btn-glow inline-block px-5 py-2 rounded-full text-sm font-semibold">Hire Me</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
