<?php $projects = portfolio_data()['projects']; ?>
<section id="projects" class="relative py-24">
    <div class="max-w-6xl mx-auto px-6">

        <div class="text-center" data-aos="fade-up">
            <p class="section-tag">Recent Work</p>
            <h2 class="section-title">Featured <span class="gradient-text">Projects</span></h2>
            <p class="mt-4 text-sky-300 max-w-xl mx-auto text-sm sm:text-base">
                Hover a card to feel the depth — built with real-world tools for real-world problems.
            </p>
        </div>

        <div class="mt-14 grid sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-8">
            <?php foreach ($projects as $index => $project): ?>
                <article data-aos="fade-up" data-aos-delay="<?= ($index % 3) * 120 ?>"
                         class="tilt-card group relative rounded-3xl overflow-hidden glass project-card <?= !empty($project['featured']) ? 'featured' : '' ?>">

                    <!-- Top gradient border glow -->
                    <div class="card-glow"></div>

                    <!-- Image -->
                    <div class="relative h-52 overflow-hidden">
                        <img src="<?= htmlspecialchars($project['image']) ?>"
                             alt="<?= htmlspecialchars($project['title']) ?>"
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                             loading="lazy"
                             onerror="this.style.display='none'; this.parentElement.classList.add('img-fallback');">
                        <div class="absolute inset-0 bg-gradient-to-t from-base via-base/40 to-transparent"></div>

                        <span class="absolute top-3 left-3 glass rounded-full px-3 py-1 text-[11px] font-semibold text-cyan-300">
                            <?= $project['year'] ?>
                        </span>

                        <?php if (!empty($project['featured'])): ?>
                            <span class="absolute top-3 right-3 glass rounded-full px-3 py-1 text-[11px] font-semibold text-fuchsia-300">
                                <i class="fa-solid fa-star mr-1"></i>Featured
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- Body -->
                    <div class="p-6 relative z-10">
                        <h3 class="font-display text-lg font-semibold text-white transition-colors duration-300 group-hover:text-cyan-300">
                            <?= htmlspecialchars($project['title']) ?>
                        </h3>

                        <div class="mt-3 flex flex-wrap gap-2">
                            <?php foreach ($project['tech'] as $tech): ?>
                                <span class="chip"><?= htmlspecialchars($tech) ?></span>
                            <?php endforeach; ?>
                        </div>

                        <p class="mt-4 text-sm text-slate-400 leading-relaxed line-clamp-3">
                            <?= htmlspecialchars($project['description']) ?>
                        </p>

                        <div class="mt-5 flex items-center gap-3">
                            <a href="<?= htmlspecialchars($project['link']) ?>" target="_blank" rel="noopener"
                               class="demo-trigger inline-flex items-center gap-2 text-sm font-semibold text-cyan-400 hover:text-cyan-300 transition-colors"
                               data-url="<?= htmlspecialchars($project['link']) ?>"
                               data-title="<?= htmlspecialchars($project['title']) ?>"
                               data-github="<?= htmlspecialchars($project['github'] ?? '') ?>">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i> Live Demo
                            </a>
                            <?php if (!empty($project['github'])): ?>
                                <a href="<?= htmlspecialchars($project['github']) ?>" target="_blank" rel="noopener"
                                   class="inline-flex items-center gap-2 text-sm font-semibold text-slate-400 hover:text-white transition-colors">
                                    <i class="fa-brands fa-github"></i> Code
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <div class="mt-12 text-center" data-aos="fade-up">
            <a href="https://github.com/DeeLiso" target="_blank" rel="noopener" class="btn-ghost px-7 py-3 rounded-full font-semibold text-sm">
                <i class="fa-brands fa-github mr-2"></i>See More on GitHub
            </a>
        </div>
    </div>
</section>
