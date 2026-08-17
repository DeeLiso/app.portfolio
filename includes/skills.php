<?php $skills = portfolio_data()['skills']; ?>
<section id="skills" class="relative py-24">
    <div class="max-w-6xl mx-auto px-6">

        <div class="text-center" data-aos="fade-up">
            <p class="section-tag">What I Bring</p>
            <h2 class="section-title">Skills & <span class="gradient-text">Expertise</span></h2>
        </div>

        <div class="mt-14 grid lg:grid-cols-2 gap-10 items-start">
            <!-- Animated progress bars -->
            <div class="glass rounded-3xl p-8" data-aos="fade-right">
                <h3 class="font-display text-lg font-semibold text-white mb-7 flex items-center gap-2">
                    <i class="fa-solid fa-gauge-high text-cyan-400"></i> Proficiency
                </h3>

                <div class="space-y-7">
                    <?php foreach ($skills as $i => $skill): ?>
                        <div data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                            <div class="flex items-center justify-between mb-2">
                                <span class="flex items-center gap-2.5 text-sm font-medium text-slate-200">
                                    <i class="<?= $skill['icon'] ?> w-4 text-center text-slate-400"></i>
                                    <?= htmlspecialchars($skill['label']) ?>
                                </span>
                                <span class="text-xs font-semibold text-slate-400">
                                    <span class="counter" data-target="<?= $skill['level'] ?>">0</span>%
                                </span>
                            </div>
                            <div class="h-2.5 rounded-full bg-white/5 overflow-hidden skill-track">
                                <div class="skill-bar h-full rounded-full bg-gradient-to-r <?= $skill['accent'] ?>"
                                     style="width: 0%" data-width="<?= $skill['level'] ?>"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Floating badge cloud -->
            <div class="relative flex items-center justify-center min-h-[280px] sm:min-h-[380px]" data-aos="fade-left">
                <div class="glass rounded-3xl p-6 w-full min-h-[280px] sm:min-h-[380px] flex flex-col items-center justify-center overflow-hidden">
                    <div class="text-center mb-6">
                        <i class="fa-solid fa-layer-group text-3xl text-cyan-400"></i>
                        <h3 class="font-display text-lg font-semibold text-white mt-3">Floating Tech Stack</h3>
                        <p class="text-xs text-slate-500 mt-1">Badges drift & spin on hover</p>
                    </div>

                    <div class="badge-cloud flex flex-wrap justify-center gap-3 sm:gap-4 overflow-hidden">
                        <?php foreach ($skills as $skill): ?>
                            <span class="badge glass px-4 py-2 rounded-full text-sm font-medium flex items-center gap-2"
                                  style="--delay: <?= rand(0, 8) ?>s; --x: <?= rand(-30, 30) ?>px;">
                                <i class="<?= $skill['icon'] ?> text-cyan-300"></i>
                                <?= htmlspecialchars($skill['label']) ?>
                            </span>
                        <?php endforeach; ?>
                        <span class="badge glass px-4 py-2 rounded-full text-sm font-medium flex items-center gap-2"
                              style="--delay: 2s; --x: 12px;">
                            <i class="fa-brands fa-git-alt text-pink-400"></i> Git
                        </span>
                        <span class="badge glass px-4 py-2 rounded-full text-sm font-medium flex items-center gap-2"
                              style="--delay: 5s; --x: -20px;">
                            <i class="fa-solid fa-database text-emerald-400"></i> MySQL
                        </span>
                        <span class="badge glass px-4 py-2 rounded-full text-sm font-medium flex items-center gap-2"
                              style="--delay: 7s; --x: 24px;">
                            <i class="fa-brands fa-bootstrap text-violet-400"></i> Bootstrap
                        </span>
                        <span class="badge glass px-4 py-2 rounded-full text-sm font-medium flex items-center gap-2"
                              style="--delay: 3.5s; --x: -14px;">
                            <i class="fa-brands fa-node-js text-emerald-400"></i> WebSockets
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
