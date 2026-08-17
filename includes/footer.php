<?php $profile = portfolio_profile(); ?>
    </main>

    <!-- Footer -->
    <footer class="border-t border-white/5 mt-10">
        <div class="max-w-6xl mx-auto px-6 py-10 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-sm text-slate-500">
                © <span id="year"></span> <?= htmlspecialchars($profile['name']) ?>. Crafted with
                <span class="text-pink-500">♥</span> using PHP + Tailwind.
                <i class="fa-brands fa-windows text-slate-400 ml-2"></i>
            </p>

            <button id="to-top" aria-label="Back to top"
                    class="glass w-11 h-11 rounded-full flex items-center justify-center text-slate-300 hover:text-cyan-300 hover:-translate-y-1 transition-all duration-300">
                <i class="fa-solid fa-arrow-up"></i>
            </button>
        </div>
    </footer>

    <!-- Floating feedback card (slides in from the side) -->
    <div id="float-card" class="float-card fixed bottom-6 right-6 z-40 max-w-sm w-[calc(100vw-3rem)] sm:w-80 glass rounded-2xl p-5">
        <button id="float-close" aria-label="Dismiss"
                class="absolute top-3 right-3 w-8 h-8 rounded-full flex items-center justify-center text-slate-400 hover:text-white transition-colors">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <div class="flex items-start gap-3">
            <span class="glass w-10 h-10 rounded-xl flex items-center justify-center text-cyan-300 shrink-0">
                <i class="fa-solid fa-comment-dots"></i>
            </span>
            <div>
                <h4 class="font-display font-semibold text-white text-sm">Quick Question</h4>
                <p class="mt-1.5 text-sm text-slate-300 leading-relaxed">
                    How likely are you to recommend APP.portfolio to a friend?
                </p>
            </div>
        </div>
        <div class="mt-4 flex gap-2">
            <button class="btn-glow px-4 py-2 rounded-full text-xs font-semibold">Reply</button>
            <button id="float-later" class="btn-ghost px-4 py-2 rounded-full text-xs font-semibold">Later</button>
        </div>
    </div>

    <!-- Live Demo preview modal -->
    <div id="demo-modal" class="fixed inset-0 z-[70] hidden items-center justify-center p-2 sm:p-4" role="dialog" aria-modal="true">
        <div id="demo-backdrop" class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>
        <div class="relative w-full max-w-5xl h-[85vh] glass rounded-2xl overflow-hidden flex flex-col">
            <div class="flex items-center justify-between gap-2 sm:gap-3 px-3 sm:px-4 py-2.5 sm:py-3 border-b border-white/10">
                <div class="flex items-center gap-2.5 min-w-0">
                    <i class="fa-solid fa-globe text-cyan-400"></i>
                    <span id="demo-title" class="font-display font-semibold text-white text-sm truncate">Project</span>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <button id="demo-reload" title="Reload" aria-label="Reload"
                            class="w-9 h-9 rounded-full glass flex items-center justify-center text-slate-300 hover:text-white transition-colors">
                        <i class="fa-solid fa-rotate"></i>
                    </button>
                    <a id="demo-open" href="#" target="_blank" rel="noopener"
                       class="btn-glow px-3 sm:px-4 py-2 rounded-full text-xs font-semibold">
                        <i class="fa-solid fa-arrow-up-right-from-square sm:mr-1"></i><span class="hidden sm:inline">Visit Site</span>
                    </a>
                    <button id="demo-close" title="Close" aria-label="Close"
                            class="w-9 h-9 rounded-full glass flex items-center justify-center text-slate-300 hover:text-red-400 transition-colors">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
            <div class="relative flex-1 bg-white">
                <iframe id="demo-frame" src="about:blank" class="w-full h-full" allowfullscreen></iframe>
                <div id="demo-loader" class="absolute inset-0 flex items-center justify-center" style="background:#0f172a;">
                    <div class="flex flex-col items-center gap-3">
                        <i class="fa-solid fa-spinner fa-spin text-2xl text-cyan-400"></i>
                        <p class="text-xs text-slate-400">Loading preview…</p>
                    </div>
                </div>
                <div id="demo-error" class="absolute inset-0 hidden flex-col items-center justify-center gap-4 p-6 text-center" style="background:#0f172a;">
                    <img src="assets/img/no-demo.gif" alt="No live demo yet"
                         class="max-h-64 max-w-full rounded-xl object-contain shadow-2xl">
                    <p class="text-sm text-slate-300">No live demo yet — check out the source code on GitHub.</p>
                    <a id="demo-error-open" href="#" target="_blank" rel="noopener"
                       class="btn-glow px-5 py-2 rounded-full text-xs font-semibold">Open in new tab</a>
                </div>
            </div>
        </div>
    </div>

    <!-- AOS -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <!-- Anti-copy protection -->
    <script src="assets/js/anti-copy.js"></script>
    <!-- Main JS -->
    <script src="assets/js/main.js"></script>
</body>
</html>
