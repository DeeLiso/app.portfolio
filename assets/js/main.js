/* ============================================================
   MAIN JS — Typing, particles, tilt, navbar, counters, mobile menu
   ============================================================ */

(function () {
    'use strict';

    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ---------- 1. Navbar glass on scroll ---------- */
    const navbar = document.getElementById('navbar');
    const onScrollNav = () => navbar.classList.toggle('scrolled', window.scrollY > 30);
    window.addEventListener('scroll', onScrollNav, { passive: true });
    onScrollNav();

    /* ---------- 1b. Scroll progress bar ---------- */
    const progressBar = document.getElementById('scroll-progress');
    const onScrollProgress = () => {
        const scrollTop = window.scrollY;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        progressBar.style.width = (docHeight > 0 ? (scrollTop / docHeight) * 100 : 0) + '%';
    };
    window.addEventListener('scroll', onScrollProgress, { passive: true });
    window.addEventListener('resize', onScrollProgress, { passive: true });
    onScrollProgress();

    /* ---------- 1c. Theme toggle ---------- */
    const themeToggle = document.getElementById('theme-toggle');
    const themeIcon = document.getElementById('theme-icon');
    const applyTheme = (t) => {
        document.documentElement.setAttribute('data-theme', t);
        localStorage.setItem('theme', t);
        if (themeIcon) themeIcon.className = t === 'light' ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
    };
    if (themeToggle) {
        applyTheme(document.documentElement.getAttribute('data-theme') || 'dark');
        themeToggle.addEventListener('click', () => {
            const next = document.documentElement.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
            applyTheme(next);
        });
    }

    /* ---------- 2. Mobile menu toggle ---------- */
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');

    if (menuToggle) menuToggle.addEventListener('click', () => {
        const isOpen = !mobileMenu.classList.contains('hidden');
        mobileMenu.classList.toggle('hidden');
        menuIcon.className = isOpen ? 'fa-solid fa-bars' : 'fa-solid fa-xmark';
    });

    document.querySelectorAll('.mobile-link').forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
            menuIcon.className = 'fa-solid fa-bars';
        });
    });

    /* ---------- 3. Back to top ---------- */
    const toTop = document.getElementById('to-top');
    if (toTop) toTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

    /* ---------- 4. Typing effect ---------- */
    const typedEl = document.getElementById('typed');
    if (typedEl) {
        const roles = JSON.parse(typedEl.dataset.roles || '[]');
        const rolesFallback = roles.length ? roles : ['Full-Stack Developer', 'PHP Engineer', 'UI/UX Enthusiast', 'Problem Solver'];

        let roleIdx = 0, charIdx = 0, deleting = false;

        const type = () => {
            const word = rolesFallback[roleIdx];
            typedEl.textContent = word.slice(0, charIdx);

            if (!deleting) {
                if (charIdx < word.length) { charIdx++; setTimeout(type, 85); }
                else { deleting = true; setTimeout(type, 1800); }
            } else {
                if (charIdx > 0) { charIdx--; setTimeout(type, 45); }
                else {
                    deleting = false;
                    roleIdx = (roleIdx + 1) % rolesFallback.length;
                    setTimeout(type, 350);
                }
            }
        };
        type();
    }

    /* ---------- 5. Canvas particle background ---------- */
    const canvas = document.getElementById('particles');
    if (canvas && !prefersReduced) {
        const ctx = canvas.getContext('2d');
        let W, H, particles = [];
        const COLORS = ['#22d3ee', '#a855f7', '#f472b6'];

        const resize = () => {
            W = canvas.width = canvas.offsetWidth;
            H = canvas.height = canvas.offsetHeight;
            const count = Math.min(70, Math.floor((W * H) / 18000));
            particles = Array.from({ length: count }, () => ({
                x: Math.random() * W,
                y: Math.random() * H,
                r: Math.random() * 1.8 + 0.4,
                vx: (Math.random() - 0.5) * 0.35,
                vy: (Math.random() - 0.5) * 0.35,
                c: COLORS[Math.floor(Math.random() * COLORS.length)],
                a: Math.random() * 0.5 + 0.2,
            }));
        };

        const link = (p1, p2) => {
            const d = Math.hypot(p1.x - p2.x, p1.y - p2.y);
            if (d < 120) {
                ctx.strokeStyle = `rgba(148, 163, 184, ${0.16 * (1 - d / 120)})`;
                ctx.lineWidth = 0.6;
                ctx.beginPath();
                ctx.moveTo(p1.x, p1.y);
                ctx.lineTo(p2.x, p2.y);
                ctx.stroke();
            }
        };

        const tick = () => {
            ctx.clearRect(0, 0, W, H);
            for (const p of particles) {
                p.x += p.vx; p.y += p.vy;
                if (p.x < 0 || p.x > W) p.vx *= -1;
                if (p.y < 0 || p.y > H) p.vy *= -1;
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                ctx.fillStyle = p.c;
                ctx.globalAlpha = p.a;
                ctx.fill();
                ctx.globalAlpha = 1;
            }
            for (let i = 0; i < particles.length; i++)
                for (let j = i + 1; j < particles.length; j++)
                    link(particles[i], particles[j]);
            requestAnimationFrame(tick);
        };

        window.addEventListener('resize', resize);
        resize();
        tick();
    }

    /* ---------- 6. Skill bars + counters on scroll ---------- */
    const animateSkills = () => {
        document.querySelectorAll('.skill-bar').forEach(bar => {
            const width = bar.dataset.width || 0;
            bar.style.width = width + '%';
        });
        document.querySelectorAll('.counter').forEach(counter => {
            const target = +counter.dataset.target;
            let current = 0;
            const step = Math.max(1, Math.round(target / 60));
            const timer = setInterval(() => {
                current += step;
                if (current >= target) { current = target; clearInterval(timer); }
                counter.textContent = current;
            }, 24);
        });
    };

    /* ---------- 7. Intersection observers ---------- */
    const observeIn = (selector, callback) => {
        const els = document.querySelectorAll(selector);
        if (!els.length) return;
        const io = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) { callback(entry.target); io.unobserve(entry.target); }
            });
        }, { threshold: 0.25 });
        els.forEach(el => io.observe(el));
    };

    observeIn('.skill-bar', () => animateSkills());

    /* ---------- 8. 3D tilt on project cards ---------- */
    const tiltCards = document.querySelectorAll('.tilt-card');
    if (tiltCards.length && !prefersReduced) {
        const MAX = 10;

        tiltCards.forEach(card => {
            card.addEventListener('mousemove', e => {
                const rect = card.getBoundingClientRect();
                const px = (e.clientX - rect.left) / rect.width;
                const py = (e.clientY - rect.top) / rect.height;
                const rx = (0.5 - py) * MAX;
                const ry = (px - 0.5) * MAX;
                card.style.transform = `perspective(900px) rotateX(${rx}deg) rotateY(${ry}deg) translateY(-6px) scale(1.02)`;
                card.style.setProperty('--mx', (px * 100) + '%');
                card.style.setProperty('--my', (py * 100) + '%');
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'perspective(900px) rotateX(0deg) rotateY(0deg) translateY(0) scale(1)';
            });
        });
    }

    /* ---------- 9b. Floating feedback card ---------- */
    const floatCard = document.getElementById('float-card');
    const floatClose = document.getElementById('float-close');
    const floatLater = document.getElementById('float-later');
    const hideCard = () => { if (floatCard) floatCard.classList.remove('show'); };
    if (floatCard && !sessionStorage.getItem('floatCardShown')) {
        setTimeout(() => {
            floatCard.classList.add('show');
            sessionStorage.setItem('floatCardShown', '1');
        }, 3500);
    }
    if (floatClose) floatClose.addEventListener('click', hideCard);
    if (floatLater) floatLater.addEventListener('click', hideCard);

    /* ---------- 9c. Live Demo preview modal ---------- */
    const demoModal = document.getElementById('demo-modal');
    const demoFrame = document.getElementById('demo-frame');
    const demoTitle = document.getElementById('demo-title');
    const demoLoader = document.getElementById('demo-loader');
    const demoError = document.getElementById('demo-error');
    const demoOpen = document.getElementById('demo-open');
    const demoErrorOpen = document.getElementById('demo-error-open');

    const openDemo = (url, title, github) => {
        if (!demoModal || !demoFrame) return;
        const hasDemo = url && url !== '#' && !url.startsWith('#');
        demoTitle.textContent = title;
        demoLoader.style.display = 'flex';
        demoError.style.display = 'none';

        if (hasDemo) {
            demoFrame.src = url;
            demoFrame.style.display = '';
            demoOpen.href = url;
            demoOpen.innerHTML = '<i class="fa-solid fa-arrow-up-right-from-square mr-1"></i>Visit Site';
            demoErrorOpen.href = url;
            const loadTimer = setTimeout(() => { demoLoader.style.display = 'none'; }, 8000);
            demoFrame.onload = () => { demoLoader.style.display = 'none'; clearTimeout(loadTimer); };
        } else {
            demoFrame.src = 'about:blank';
            demoFrame.style.display = 'none';
            demoLoader.style.display = 'none';
            demoError.style.display = 'flex';
            const gh = github || 'https://github.com/DeeLiso';
            demoOpen.href = gh;
            demoOpen.innerHTML = '<i class="fa-brands fa-github mr-1"></i>View Code';
            demoErrorOpen.href = gh;
        }
        demoModal.classList.remove('hidden');
        demoModal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    };

    const closeDemo = () => {
        if (!demoModal) return;
        demoModal.classList.add('hidden');
        demoModal.classList.remove('flex');
        demoFrame.src = 'about:blank';
        document.body.style.overflow = '';
    };

    document.querySelectorAll('.demo-trigger').forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            openDemo(link.dataset.url, link.dataset.title, link.dataset.github);
        });
    });

    const demoClose = document.getElementById('demo-close');
    const demoBackdrop = document.getElementById('demo-backdrop');
    const demoReload = document.getElementById('demo-reload');
    if (demoClose) demoClose.addEventListener('click', closeDemo);
    if (demoBackdrop) demoBackdrop.addEventListener('click', closeDemo);
    if (demoReload && demoFrame) demoReload.addEventListener('click', () => {
        demoLoader.style.display = 'flex';
        demoFrame.src = demoFrame.src;
    });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDemo(); });

    /* ---------- 9. Footer year ---------- */
    const yearEl = document.getElementById('year');
    if (yearEl) yearEl.textContent = new Date().getFullYear();

    /* ---------- 10. AOS init ---------- */
    if (window.AOS) {
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: window.innerWidth < 640 ? 30 : 60,
        });
    }
})();
