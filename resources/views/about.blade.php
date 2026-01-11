{{-- resources/views/about.blade.php --}}
@php
    use Illuminate\Support\Str;
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tentang Kami</title>

    {{-- Breeze/Tailwind via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900">
    @include('layouts.partials.public-header')

    {{-- =========================
        HERO ABOUT
    ========================== --}}
    <section class="py-8 px-8 bg-blue-50">
      <div class="max-w-7xl mx-auto">
        <div
          class="flex flex-col lg:flex-row justify-between items-center gap-12"
        >
          <div class="lg:w-1/2">
            <img
              src="{{ asset('img/tentang-kami/tentang-kami.webp') }}"
              alt="tentang kami"
              class="rounded-2xl shadow-2xl w-full"
            />
          </div>
          <div class="lg:w-1/2 space-y-6">
            <p
              class="text-blue-600 font-semibold text-sm uppercase tracking-wide"
            >
              Tentang Perusahaan
            </p>
            <h1
              class="text-4xl lg:text-5xl font-bold text-gray-900 leading-tight"
            >
              Mitra Tepat Kembangkan Bakat
            </h1>
            <p class="text-gray-600 text-lg leading-relaxed">
              Anagata Sisedu Nusantara (ASN) berdiri untuk memajukan edukasi
              Indonesia yang berfokus pada pengembangan Teknologi Digital,
              Artificial Intelligence, Bahasa dan Soft Skill untuk sekolah,
              perguruan tinggi dan publik.
              <br /><br />
              Melalui Anagata Academy dan CodingMU, kami siap mendampingi sumber
              daya insani Indonesia menuju Indonesia Emas 2045
            </p>
            <button
              class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
            >
              Company Profile
            </button>
          </div>
        </div>
      </div>
    </section>

    {{-- =========================
        2 BRAND CARDS
    ========================== --}}
    <section class="py-10 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid sm:grid-cols-2 gap-6">
                <div class="border border-gray-200 rounded-3xl p-8 bg-white shadow-sm">
                    <img src="{{ asset('img/logo/logo_aa.webp') }}" alt="Anagata Academy" class="h-12 w-auto mb-5">
                    <p class="text-gray-700 leading-relaxed">
                        Lembaga Kursus dan Pelatihan (LKP) di bawah naungan Anagata Sisedu Nusantara.
                        Anagata Academy memberikan kursus dan pelatihan kepada siswa, SDM, lembaga pendidikan, dan publik.
                    </p>
                </div>

                <div class="border border-gray-200 rounded-3xl p-8 bg-white shadow-sm">
                    <img src="{{ asset('img/logo/logo_codingmu.webp') }}" alt="CodingMU" class="h-12 w-auto mb-5">
                    <p class="text-gray-700 leading-relaxed">
                        Coding Muhammadiyah (CodingMU) adalah platform kursus coding dan teknologi digital eksklusif
                        untuk siswa, mahasiswa, dan warga Persyarikatan Muhammadiyah.
                        Bersama Muhammadiyah, ASN berkomitmen memajukan kurikulum digital di sekolah dan perguruan tinggi Muhammadiyah & ‘Aisyiyah.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- =========================
        3 PILAR
    ========================== --}}
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-2xl sm:text-4xl font-extrabold text-center">3 Pilar Pendidikan Anagata</h2>
            <p class="mt-2 text-center text-gray-600">Fokus kami untuk pendidikan yang relevan dan berdampak.</p>

            <div class="mt-10 grid md:grid-cols-3 gap-6">
                <div class="bg-white border border-gray-200 rounded-3xl p-6 shadow-sm">
                    <img src="{{ asset('img/homepage/teknologi-digital.webp') }}" alt="Teknologi Digital" class="w-full rounded-2xl mb-4 object-cover">
                    <h3 class="font-bold text-xl">Teknologi Digital</h3>
                    <p class="mt-2 text-gray-600 text-sm">Koding, web, aplikasi, dan literasi digital.</p>
                </div>

                <div class="bg-white border border-gray-200 rounded-3xl p-6 shadow-sm">
                    <img src="{{ asset('img/homepage/bahasa-dan-sastra.webp') }}" alt="Bahasa dan Sastra" class="w-full rounded-2xl mb-4 object-cover">
                    <h3 class="font-bold text-xl">Bahasa & Sastra</h3>
                    <p class="mt-2 text-gray-600 text-sm">Penguatan komunikasi dan kemampuan berbahasa.</p>
                </div>

                <div class="bg-white border border-gray-200 rounded-3xl p-6 shadow-sm">
                    <img src="{{ asset('img/homepage/soft-skill.webp') }}" alt="Soft Skill" class="w-full rounded-2xl mb-4 object-cover">
                    <h3 class="font-bold text-xl">Soft Skill</h3>
                    <p class="mt-2 text-gray-600 text-sm">Leadership, teamwork, problem solving, dan karakter.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-16">
      <div class="max-w-6xl mx-auto px-6 md:px-12 lg:px-16">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-12">
          Our Director
        </h2>

        <div
          class="flex flex-col md:flex-row items-center justify-between gap-10"
        >
          <!-- Director Image -->
          <div class="flex-1 flex justify-center">
            <img
              src="{{ asset('img/tentang-kami/SIGIT-SUTRISNO-DIRECTORr-e1740495869559.webp')}}"
              alt="Director"
              class="w-64 md:w-80 lg:w-96 rounded-xl object-cover drop-shadow-md"
            />
          </div>

          <!-- Director Description -->
          <div
            class="flex-1 bg-white border border-gray-200 rounded-2xl p-8 md:p-10 shadow-sm"
          >
            <p class="text-gray-700 leading-relaxed text-justify mb-6">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris
              sed risus at orci dignissim fringilla. Sed metus dolor, tempor sit
              amet odio non, dignissim suscipit justo. Pellentesque habitant
              morbi tristique senectus et netus et malesuada fames ac turpis
              egestas. Ut arcu ex, pulvinar eget lobortis ut, venenatis euismod
              purus. Vivamus tristique lobortis risus et pretium. Curabitur non
              felis vehicula, commodo leo id, volutpat quam. Aliquam erat
              volutpat.
            </p>
            <p class="text-gray-700 leading-relaxed text-justify mb-8">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris
              sed risus at orci dignissim fringilla. Sed metus dolor, tempor sit
              amet odio non, dignissim suscipit justo. Pellentesque habitant
              morbi tristique senectus et netus et malesuada fames ac turpis
              egestas.
            </p>
            <p class="font-semibold text-gray-900 text-center">
              Sigit Sutrisno
            </p>
            <p class="text-sm text-gray-500 text-center">Director</p>
          </div>
        </div>
      </div>
    </section>

    <section class="bg-white py-16">
      <div class="max-w-6xl mx-auto px-6 md:px-12 lg:px-16">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-12">
          Kepala Lembaga Kursus dan Digital
        </h2>

        <div
          class="flex flex-col md:flex-row items-center justify-between gap-10"
        >
          <div
            class="flex-1 bg-white border border-gray-200 rounded-2xl p-8 md:p-10 shadow-sm"
          >
            <p class="text-gray-700 leading-relaxed text-justify mb-6">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris
              sed risus at orci dignissim fringilla. Sed metus dolor, tempor sit
              amet odio non, dignissim suscipit justo. Pellentesque habitant
              morbi tristique senectus et netus et malesuada fames ac turpis
              egestas. Ut arcu ex, pulvinar eget lobortis ut, venenatis euismod
              purus. Vivamus tristique lobortis risus et pretium. Curabitur non
              felis vehicula, commodo leo id, volutpat quam. Aliquam erat
              volutpat.
            </p>
            <p class="text-gray-700 leading-relaxed text-justify mb-8">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris
              sed risus at orci dignissim fringilla. Sed metus dolor, tempor sit
              amet odio non, dignissim suscipit justo. Pellentesque habitant
              morbi tristique senectus et netus et malesuada fames ac turpis
              egestas.
            </p>
            <p class="font-semibold text-gray-900 text-center">
              Sheila Purnama
            </p>
            <p class="text-sm text-gray-500 text-center">
              Kepala Lembaga Kursus dan Digital
            </p>
          </div>
          <div class="flex-1 flex justify-center">
            <img
              src="{{ asset('img/tentang-kami/Sheila Purnama.webp') }}"
              alt="Director"
              class="w-64 md:w-80 lg:w-96 rounded-xl object-cover"
            />
          </div>
        </div>
      </div>
    </section>

    {{-- =========================
        TEAM SLIDER (Officer + Intern) - DINAMIS
    ========================== --}}
    <section class="py-14 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-2xl sm:text-4xl font-extrabold text-center">Tim Kami</h2>
            <p class="mt-2 text-center text-gray-600">Kenalan dengan tim yang menjalankan program kami.</p>

            @if(($team ?? collect())->count() === 0)
                <div class="mt-8 text-center text-gray-600">Belum ada data tim.</div>
            @else
                <div class="mt-10 relative" data-coverflow>
                    <button type="button" data-prev
                        class="absolute left-2 sm:left-6 top-1/2 -translate-y-1/2 z-40 bg-white/90 hover:bg-white border border-gray-200 shadow rounded-full w-10 h-10 grid place-items-center">
                        <span class="text-2xl leading-none text-gray-700">‹</span>
                    </button>

                    <button type="button" data-next
                        class="absolute right-2 sm:right-6 top-1/2 -translate-y-1/2 z-40 bg-white/90 hover:bg-white border border-gray-200 shadow rounded-full w-10 h-10 grid place-items-center">
                        <span class="text-2xl leading-none text-gray-700">›</span>
                    </button>

                    <div class="relative h-[540px] sm:h-[560px]">
                        @foreach($team as $p)
                            <article data-slide
                                class="absolute left-1/2 top-0 w-[280px] sm:w-[360px] lg:w-[460px] -translate-x-1/2 transition-all duration-500 ease-out">
                                <div class="text-center">
                                    <div class="h-[290px] sm:h-[320px] flex items-end justify-center">
                                        <img src="{{ $p->photo_url }}"
                                             alt="{{ $p->name }}"
                                             class="max-h-full w-auto object-contain drop-shadow-xl"
                                             loading="lazy" />
                                    </div>

                                    <h3 class="mt-3 text-xl sm:text-2xl font-extrabold text-gray-900">
                                        {{ $p->name }}
                                        @if($p->title)
                                            <span class="font-semibold text-gray-600"> — {{ $p->title }}</span>
                                        @endif
                                    </h3>

                                    <p data-bio class="mt-3 text-sm sm:text-base text-gray-700 leading-relaxed hidden">
                                        {{ Str::limit(strip_tags($p->bio), 220) }}
                                    </p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- =========================
        MENTOR SLIDER - DINAMIS
    ========================== --}}
    <section class="py-14 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-2xl sm:text-4xl font-extrabold text-center">Mentor Kami</h2>
            <p class="mt-2 text-center text-gray-600">Mentor terbaik untuk dampingi belajar.</p>

            @if(($mentors ?? collect())->count() === 0)
                <div class="mt-8 text-center text-gray-600">Belum ada data mentor.</div>
            @else
                <div class="mt-10 relative" data-coverflow>
                    <button type="button" data-prev
                        class="absolute left-2 sm:left-6 top-1/2 -translate-y-1/2 z-40 bg-white/90 hover:bg-white border border-gray-200 shadow rounded-full w-10 h-10 grid place-items-center">
                        <span class="text-2xl leading-none text-gray-700">‹</span>
                    </button>

                    <button type="button" data-next
                        class="absolute right-2 sm:right-6 top-1/2 -translate-y-1/2 z-40 bg-white/90 hover:bg-white border border-gray-200 shadow rounded-full w-10 h-10 grid place-items-center">
                        <span class="text-2xl leading-none text-gray-700">›</span>
                    </button>

                    <div class="relative h-[540px] sm:h-[560px]">
                        @foreach($mentors as $p)
                            <article data-slide
                                class="absolute left-1/2 top-0 w-[280px] sm:w-[360px] lg:w-[460px] -translate-x-1/2 transition-all duration-500 ease-out">
                                <div class="text-center">
                                    <div class="h-[290px] sm:h-[320px] flex items-end justify-center">
                                        <img src="{{ $p->photo_url }}"
                                             alt="{{ $p->name }}"
                                             class="max-h-full w-auto object-contain drop-shadow-xl"
                                             loading="lazy" />
                                    </div>

                                    <h3 class="mt-3 text-xl sm:text-2xl font-extrabold text-gray-900">
                                        {{ $p->name }}
                                        @if($p->title)
                                            <span class="font-semibold text-gray-600"> — {{ $p->title }}</span>
                                        @endif
                                    </h3>

                                    <p data-bio class="mt-3 text-sm sm:text-base text-gray-700 leading-relaxed hidden">
                                        {{ Str::limit(strip_tags($p->bio), 220) }}
                                    </p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- =========================
        VISI
    ========================== --}}
    <section class="py-14 bg-white">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-2xl sm:text-4xl font-extrabold">Visi</h2>
            <p class="mt-4 text-gray-700 text-base sm:text-lg leading-relaxed font-semibold">
                “Sebagai Mitra Tepat untuk Kembangkan Sumber Daya Manusia Indonesia yang Tangguh, Unggul dan Berkemajuan”
            </p>
        </div>
    </section>

    {{-- =========================
        MISI
    ========================== --}}
    <section class="py-14 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-2xl sm:text-4xl font-extrabold text-center">Misi</h2>

            <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
                @php
                    $misi = [
                        ['img' => 'assets/tentang-kami/misi-1.webp', 'text' => 'Mengembangkan potensi trampil'],
                        ['img' => 'assets/tentang-kami/misi-2.webp', 'text' => 'Menguatkan daya saing & wirausaha'],
                        ['img' => 'assets/tentang-kami/misi-3.webp', 'text' => 'Menghubungkan akses pendidikan yang bermutu'],
                        ['img' => 'assets/tentang-kami/misi-4.webp', 'text' => 'Memperluas peluang kerjasama pendidikan'],
                        ['img' => 'assets/tentang-kami/misi-5.webp', 'text' => 'Menumbuhkan karakter pemimpin & wirausaha'],
                    ];
                @endphp

                @foreach($misi as $item)
                    <figure class="bg-white border border-gray-200 rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition">
                        <div class="aspect-[4/3] bg-gray-100 overflow-hidden">
                            <img src="{{ asset($item['img']) }}" alt="Misi" class="w-full h-full object-cover" loading="lazy">
                        </div>
                        <figcaption class="p-4">
                            <p class="text-sm text-gray-800 text-center font-semibold">{{ $item['text'] }}</p>
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </div>
    </section>

    {{-- =========================
        FOOTER
    ========================== --}}
    @include('layouts.partials.public-footer')
    </footer>

    {{-- =========================
        JS: Mobile menu + Coverflow slider
    ========================== --}}
    <script>
        // Mobile menu toggle
        (function () {
            const btn = document.querySelector('[data-mobile-toggle]');
            const menu = document.querySelector('[data-mobile-menu]');
            if (!btn || !menu) return;

            btn.addEventListener('click', () => {
                menu.classList.toggle('hidden');
            });
        })();

        // Coverflow slider (for Team & Mentor)
        (function () {
            document.querySelectorAll('[data-coverflow]').forEach(initCoverflow);

            function initCoverflow(root) {
                const slides = Array.from(root.querySelectorAll('[data-slide]'));
                if (!slides.length) return;

                const prevBtn = root.querySelector('[data-prev]');
                const nextBtn = root.querySelector('[data-next]');
                let active = 0;

                const getStep = () => {
                    const w = window.innerWidth;
                    if (w < 640) return 190;     // mobile
                    if (w < 1024) return 300;    // tablet
                    return 380;                 // desktop
                };

                const deltaWrap = (i) => {
                    const n = slides.length;
                    let d = i - active;
                    if (d > n / 2) d -= n;
                    if (d < -n / 2) d += n;
                    return d;
                };

                const apply = () => {
                    const step = getStep();

                    slides.forEach((el, i) => {
                        const d = deltaWrap(i);
                        const abs = Math.abs(d);
                        const bio = el.querySelector('[data-bio]');

                        // show only center +/- 2
                        if (abs > 2) {
                            el.style.opacity = "0";
                            el.style.pointerEvents = "none";
                            el.style.transform = `translateX(-50%) translateX(0px) scale(0.7)`;
                            el.style.zIndex = "0";
                            if (bio) bio.classList.add('hidden');
                            return;
                        }

                        const x = d * step;
                        const scale = d === 0 ? 1 : abs === 1 ? 0.86 : 0.74;
                        const opacity = d === 0 ? 1 : abs === 1 ? 0.35 : 0.15;

                        el.style.opacity = String(opacity);
                        el.style.pointerEvents = d === 0 ? "auto" : "none";
                        el.style.transform = `translateX(-50%) translateX(${x}px) scale(${scale})`;
                        el.style.zIndex = d === 0 ? "30" : abs === 1 ? "20" : "10";

                        if (bio) {
                            if (d === 0) bio.classList.remove('hidden');
                            else bio.classList.add('hidden');
                        }
                    });

                    if (slides.length <= 1) {
                        prevBtn?.classList.add('hidden');
                        nextBtn?.classList.add('hidden');
                    }
                };

                const next = () => { active = (active + 1) % slides.length; apply(); };
                const prev = () => { active = (active - 1 + slides.length) % slides.length; apply(); };

                nextBtn?.addEventListener('click', next);
                prevBtn?.addEventListener('click', prev);

                // swipe
                let startX = null;
                root.addEventListener("touchstart", (e) => startX = e.touches[0].clientX, { passive: true });
                root.addEventListener("touchend", (e) => {
                    if (startX === null) return;
                    const endX = e.changedTouches[0].clientX;
                    const dx = endX - startX;
                    startX = null;
                    if (Math.abs(dx) > 40) dx < 0 ? next() : prev();
                });

                window.addEventListener('resize', apply);
                apply();
            }
        })();
    </script>
</body>
</html>
