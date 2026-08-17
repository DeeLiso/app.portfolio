<?php
$profile = portfolio_profile();
$sent  = $_GET['sent'] ?? null;
$error = $_GET['error'] ?? null;
$db    = ($_GET['db'] ?? '') === '1';
$mail  = ($_GET['mail'] ?? '') === '1';
?>
<section id="contact" class="relative py-24">
    <div class="max-w-6xl mx-auto px-6">

        <div class="text-center" data-aos="fade-up">
            <p class="section-tag">Let's Talk</p>
            <h2 class="section-title">Get In <span class="gradient-text">Touch</span></h2>
        </div>

        <div class="mt-14 grid lg:grid-cols-2 gap-8 lg:gap-10 items-start">

            <!-- Info panel -->
            <div class="glass rounded-3xl p-8" data-aos="fade-right">
                <h3 class="font-display text-xl font-semibold text-white">Let's build something great together</h3>
                <p class="mt-3 text-sm text-slate-400 leading-relaxed">
                    Have a project in mind, a role to fill, or just want to say hi?
                    My inbox is always open — I usually reply within 24 hours.
                </p>

                <ul class="mt-8 space-y-5">
                    <li class="flex items-center gap-4">
                        <span class="glass w-11 h-11 rounded-xl flex items-center justify-center text-cyan-400">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider">Email</p>
                            <a href="mailto:<?= htmlspecialchars($profile['email']) ?>" class="text-sm text-slate-200 hover:text-cyan-300 transition-colors break-all">
                                <?= htmlspecialchars($profile['email']) ?>
                            </a>
                        </div>
                    </li>
                    <li class="flex items-center gap-4">
                        <span class="glass w-11 h-11 rounded-xl flex items-center justify-center text-violet-400">
                            <i class="fa-solid fa-location-dot"></i>
                        </span>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider">Location</p>
                            <p class="text-sm text-slate-200"><?= htmlspecialchars($profile['location']) ?></p>
                        </div>
                    </li>
                    <li class="flex items-center gap-4">
                        <span class="glass w-11 h-11 rounded-xl flex items-center justify-center text-pink-400">
                            <i class="fa-solid fa-circle-check"></i>
                        </span>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider">Status</p>
                            <p class="text-sm text-emerald-400 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Open to work
                            </p>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Form panel -->
            <div class="glass rounded-3xl p-8" data-aos="fade-left">
                <?php if ($sent === 'true'): ?>
                    <div class="rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-4 mb-6 text-sm text-emerald-300">
                        <p class="flex items-center gap-3">
                            <i class="fa-solid fa-circle-check"></i> Thanks! Your message has been sent successfully.
                        </p>
                        <?php if (!$db || !$mail): ?>
                            <p class="mt-2 text-xs text-emerald-400/80 flex items-center gap-2">
                                <i class="fa-solid fa-info-circle"></i>
                                Saved to database: <?= $db ? 'yes' : 'no' ?> &middot; Emailed to me: <?= $mail ? 'yes' : 'no' ?>
                            </p>
                        <?php endif; ?>
                    </div>
                <?php elseif ($error === 'true'): ?>
                    <div class="rounded-xl border border-red-500/30 bg-red-500/10 p-4 mb-6 text-sm text-red-300 flex items-center gap-3">
                        <i class="fa-solid fa-triangle-exclamation"></i> Something went wrong. Please try again.
                    </div>
                <?php endif; ?>

                <form action="send_contact.php" method="POST" class="space-y-6" novalidate>
                    <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off" aria-hidden="true">

                    <div class="grid sm:grid-cols-2 gap-6">
                        <div class="field">
                            <input type="text" name="name" id="name" placeholder=" " required
                                   class="field-input">
                            <label for="name" class="field-label">Your Name</label>
                        </div>
                        <div class="field">
                            <input type="email" name="email" id="email" placeholder=" " required
                                   class="field-input">
                            <label for="email" class="field-label">Your Email</label>
                        </div>
                    </div>

                    <div class="field">
                        <input type="text" name="subject" id="subject" placeholder=" " required
                               class="field-input">
                        <label for="subject" class="field-label">Subject</label>
                    </div>

                    <div class="field">
                        <textarea name="message" id="message" rows="5" placeholder=" " required
                                  class="field-input resize-none"></textarea>
                        <label for="message" class="field-label">Your Message</label>
                    </div>

                    <button type="submit" class="btn-glow w-full py-3.5 rounded-full font-semibold text-sm">
                        <i class="fa-solid fa-paper-plane mr-2"></i>Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
