<?php

/**
 * PROJECTS DATA
 * -------------
 * Add a new project by appending a new entry to the $projects array below.
 * The layout (includes/projects.php) renders everything automatically — no HTML changes needed.
 *
 * Available keys:
 *   'title'        => string  (project name)
 *   'image'        => string  (image URL or path — put images in /assets/img/projects/)
 *   'tech'         => array   (list of technologies used)
 *   'description'  => string  (short project summary)
 *   'link'         => string  (live demo or repository URL, use '#' if none)
 *   'github'       => string  (source code URL, optional)
 *   'featured'     => bool    (true => larger card + accent glow)
 *   'year'         => int     (optional, shown in the card corner)
 */

$projects = [
    [
        'title'       => 'AngelPanda – Premium Auto Parts Store',
        'image'       => 'assets/img/projects/luxury-car.jpg',
        'tech'        => ['PHP', 'MySQL', 'JavaScript', 'Bootstrap'],
        'description' => 'A full PHP + MySQL e-commerce website for selling auto parts, featuring shop + category filter, user login/registration, product ratings, EN/Myanmar language switch, dark mode and a complete admin CMS.',
        'link'        => '#',
        'github'      => 'https://github.com/DeeLiso/luxury_car_sell',
        'featured'    => true,
        'year'        => 2026,
    ],
    [
        'title'       => 'Card Design Effects',
        'image'       => 'assets/img/projects/card-effects.jpg',
        'tech'        => ['HTML', 'CSS', 'JavaScript'],
        'description' => 'A curated CSS collection of card design effects — Aurora mesh gradients, Claymorphism, Cyberpunk Glitch, Glassmorphism and Neumorphism — each with its own demo.',
        'link'        => '#',
        'github'      => 'https://github.com/DeeLiso/Card-Design-Effects',
        'featured'    => false,
        'year'        => 2026,
    ],
    [
        'title'       => '2D Parser Engine',
        'image'       => 'assets/img/projects/pos-helper.jpg',
        'tech'        => ['Python', 'Django', 'JSON', 'API'],
        'description' => 'A Django-powered parsing engine for 2D result data — ingests raw input, validates and processes it, then exposes clean JSON APIs for the front-end apps to consume.',
        'link'        => '#',
        'github'      => 'https://github.com/DeeLiso/2d-parser-engine',
        'featured'    => false,
        'year'        => 2026,
    ],
    [
        'title'       => 'T-MAX-OS Admin Dashboard',
        'image'       => 'assets/img/projects/admin-dashboard.jpg',
        'tech'        => ['PHP', 'MySQL', 'JavaScript', 'Bootstrap'],
        'description' => 'A PHP admin system with login/authentication, dashboard views and product management — hosted live on Vercel with a deploy workflow baked in.',
        'link'        => 'https://t-max-os.vercel.app',
        'github'      => 'https://github.com/DeeLiso/t_max_os',
        'featured'    => true,
        'year'        => 2026,
    ],
    [
        'title'       => 'TMAX Space 3D',
        'image'       => 'assets/img/projects/ws-app.jpg',
        'tech'        => ['HTML', 'CSS', 'JavaScript'],
        'description' => 'A pure front-end 3D space experience — a floating, animated 3D logo built with CSS transforms and a lightweight JavaScript animation engine.',
        'link'        => 'https://tmax-space-3d.vercel.app',
        'github'      => 'https://github.com/DeeLiso/tmax-space-3d',
        'featured'    => false,
        'year'        => 2026,
    ],
    [
        'title'       => 'TMAX D2',
        'image'       => 'assets/img/projects/wifi-monitor.jpg',
        'tech'        => ['HTML', 'CSS', 'JavaScript'],
        'description' => 'A fast, lightweight landing page built with clean semantic HTML and custom CSS — simple, responsive and deployed live on Vercel.',
        'link'        => 'https://tmaxd2.vercel.app',
        'github'      => 'https://github.com/DeeLiso/tmaxd2',
        'featured'    => false,
        'year'        => 2026,
    ],
];

/**
 * SKILLS DATA
 * -----------
 * label    => skill name
 * level    => proficiency percentage (drives the animated progress bar)
 * icon     => Font Awesome class
 * accent   => Tailwind gradient classes for the bar glow
 */
$skills = [
    [
        'label'  => 'HTML',
        'level'  => 95,
        'icon'   => 'fa-brands fa-html5',
        'accent' => 'from-orange-400 to-red-500',
    ],
    [
        'label'  => 'Tailwind CSS',
        'level'  => 90,
        'icon'   => 'fa-solid fa-wind',
        'accent' => 'from-cyan-400 to-blue-500',
    ],
    [
        'label'  => 'JavaScript',
        'level'  => 85,
        'icon'   => 'fa-brands fa-js',
        'accent' => 'from-yellow-300 to-amber-500',
    ],
    [
        'label'  => 'PHP',
        'level'  => 92,
        'icon'   => 'fa-brands fa-php',
        'accent' => 'from-indigo-400 to-violet-500',
    ],
    [
        'label'  => 'Python',
        'level'  => 75,
        'icon'   => 'fa-brands fa-python',
        'accent' => 'from-emerald-400 to-teal-500',
    ],
];

/**
 * SOCIAL LINKS
 * ------------
 * Shown in the footer / hero. Set to null to hide an entry.
 */
$socials = [
    'github'   => 'https://github.com/DeeLiso',
    'email'    => 'mailto:tmaxoffice12@gmail.com',
];

/** Global profile info — edit once, used everywhere. */
$profile = [
    'name'          => 'Aung Pyae Phyoe',
    'short_name'    => 'APP.portfolio',
    'role'          => 'Full-Stack Developer',
    'roles'         => ['Full-Stack Developer', 'PHP Engineer', 'UI/UX Enthusiast', 'Problem Solver'],
    'location'      => 'Myanmar',
    'email'         => 'tmaxoffice12@gmail.com',
    'tagline'       => "I build fast, modern and interactive web experiences that don't just look good — they feel alive.",
];

return [
    'projects' => $projects,
    'skills'   => $skills,
    'socials'  => $socials,
    'profile'  => $profile,
];
