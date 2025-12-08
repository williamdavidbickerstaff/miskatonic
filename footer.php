<?php wp_footer(); ?>
</body>


<footer class="
bg-stone-900 text-white py-6 mt-6
">
    <div class="max-w-[1440px] mx-auto grid grid-cols-12 gap-6 px-6">
        <!-- Left: Logo + Text -->
        <div class="col-span-4 flex flex-col justify-between">
            <div>
                <h1 class="font-sutroBlack text-4xl font-bold leading-none">MISKA<br>TONIC</h1>
                <h2 class="font-sutro text-lg leading-none mt-2">Institute of<br>Horror Studies</h2>
                <p class="p-style mt-4 leading-none text-gray-300 w-[85%]">
                    An initiation into an understanding of horror, which is - in the end - a key to an understanding of
                    everything.
                </p>
            </div>
            <p class="text-xs text-gray-500 mt-8">
                © 2025 The Miskatonic Institute of Horror Studies
            </p>
        </div>

        <!-- 
        <div class="col-span-4 flex flex-col justify-start space-y-1">
            <a href="#" class="menu-item">Talks</a>
            <a href="#" class="menu-item">Speakers</a>
            <a href="#" class="menu-item">News</a>
            <a href="#" class="menu-item">Archive</a>
            <a href="#" class="menu-item">FAQs</a>
            <a href="#" class="menu-item">About</a>
            <a href="#" class="menu-item">Contact</a>
        </div> -->

        <ul class="flex flex-col col-span-4 gap-0 h-[70%] dark">
            <li class="h-full h2-style leading-none menu-item" data-menu-item>
                <label class="h-full flex items-center justify-start">Talks</label>
            </li>
            <li class="h-full h2-style leading-none menu-item" data-menu-item>
                <label class="h-full flex items-center justify-start">Speakers</label>
            </li>
            <li class="h-full h2-style leading-none menu-item" data-menu-item>
                <label class="h-full flex items-center justify-start">Archive</label>
            </li>
            <li class="h-full h2-style leading-none menu-item" data-menu-item>
                <label class="h-full flex items-center justify-start">News</label>
            </li>
            <li class="h-full h2-style leading-none menu-item" data-menu-item>
                <label class="h-full flex items-center justify-start">FAQ</label>
            </li>
            <li class="h-full h2-style leading-none menu-item" data-menu-item>
                <label class="h-full flex items-center justify-start">About</label>
            </li>
            <li class="h-full h2-style leading-none menu-item" data-menu-item>
                <label class="h-full flex items-center justify-start">Contact</label>
            </li>
        </ul>

        <!-- Right: Newsletter + Socials -->
        <div class="col-span-4 flex flex-col justify-between">
            <div>
                <h3 class="text-base font-semibold mb-2">Receive our newsletter</h3>
                <form class="flex flex-col space-y-2">
                    <input type="email" placeholder="Your email"
                        class="bg-transparent border border-gray-500 px-3 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-white" />
                    <button type="submit" class="text-white underline hover:no-underline text-sm w-fit">
                        Subscribe
                    </button>
                </form>
            </div>

            <!-- Social icons -->
            <div class="flex space-x-6 mt-8">
                <a href="#" aria-label="Instagram">
                    <i class="fab fa-instagram text-2xl"></i>
                </a>
                <a href="#" aria-label="Letterboxd">
                    <svg class="w-6 h-6 fill-current"><!-- letterboxd svg here --></svg>
                </a>
                <a href="#" aria-label="Facebook">
                    <i class="fab fa-facebook text-2xl"></i>
                </a>
                <a href="#" aria-label="Mastodon">
                    <i class="fab fa-mastodon text-2xl"></i>
                </a>
                <a href="#" aria-label="Vimeo">
                    <i class="fab fa-vimeo text-2xl"></i>
                </a>
            </div>
        </div>
    </div>
</footer>

</html>