<?php
$profile = portfolio_profile();
$profile_socials = portfolio_data()['socials'];
?>
<section id="home" class="relative min-h-screen flex items-center justify-center pt-16">
    <div class="max-w-6xl mx-auto px-6 w-full text-center relative z-10">

        <div data-aos="zoom-in" data-aos-delay="100">
            <span class="inline-flex items-center gap-2 glass rounded-full px-4 py-2 text-xs font-medium tracking-wider text-cyan-300">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Available for freelance work
            </span>
        </div>

        <h1 class="mt-8 font-display font-bold leading-tight text-3xl sm:text-5xl lg:text-7xl text-white" data-aos="fade-up" data-aos-delay="200">
            Hi, I'm
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-fuchsia-400 to-pink-400 hero-gradient">
                <?= htmlspecialchars($profile['name']) ?>
            </span>
        </h1>

        <div class="mt-5 flex items-center justify-center gap-3 flex-wrap font-display text-xl sm:text-2xl lg:text-3xl text-slate-300" data-aos="fade-up" data-aos-delay="300">
            <span>I'm a</span>
            <span id="typed" class="font-semibold text-cyan-300" data-roles='<?= json_encode($profile['roles']) ?>'></span>
            <span id="cursor" class="animate-blink text-cyan-400">|</span>
        </div>

        <p class="mt-6 max-w-2xl mx-auto text-slate-400 text-base sm:text-lg leading-relaxed" data-aos="fade-up" data-aos-delay="400">
            <?= htmlspecialchars($profile['tagline']) ?>
        </p>

        <div class="mt-10 flex items-center justify-center gap-4 flex-wrap" data-aos="fade-up" data-aos-delay="500">
            <a href="#projects" class="btn-glow px-7 py-3 rounded-full font-semibold text-sm">
                <i class="fa-solid fa-rocket mr-2"></i>View Projects
            </a>
            <a href="#contact" class="btn-ghost px-7 py-3 rounded-full font-semibold text-sm">
                <i class="fa-solid fa-envelope mr-2"></i>Get In Touch
            </a>
        </div>

        <div class="mt-14 flex items-center justify-center gap-5" data-aos="fade-up" data-aos-delay="600">
            <?php
            $icons = [
                'github'   => ['fa-brands fa-github', 'GitHub'],
                'linkedin' => ['fa-brands fa-linkedin-in', 'LinkedIn'],
                'email'    => ['fa-solid fa-envelope', 'Email'],
            ];
            foreach ($icons as $key => [$icon, $label]):
                if (empty($profile_socials[$key] ?? null)) continue;
            ?>
                <a href="<?= htmlspecialchars($profile_socials[$key]) ?>" target="_blank" rel="noopener"
                   class="social-btn glass w-11 h-11 rounded-full flex items-center justify-center text-slate-300 hover:text-cyan-300 transition-all duration-300"
                   aria-label="<?= $label ?>">
                    <i class="<?= $icon ?>"></i>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Scroll indicator -->
        <a href="#skills" class="absolute bottom-8 left-1/2 -translate-x-1/2 text-slate-500 hover:text-cyan-300 transition-colors scroll-indicator hidden sm:block" aria-label="Scroll down">
            <i class="fa-solid fa-chevron-down text-xl animate-bounce"></i>
        </a>
    </div>
</section>
