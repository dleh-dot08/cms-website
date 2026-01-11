<footer class="bg-slate-100 text-gray-900 py-12">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            {{-- Col 1 --}}
            <div class="flex items-start">
                <img src="{{ asset('img/homepage/footer-1.webp') }}"
                     alt="Logo"
                     class="w-full max-w-[220px]" />
            </div>

            {{-- Col 2 --}}
            <div>
                <img src="{{ asset('img/logo/ASN_logo-color.png') }}" alt="Logo ASN" class="mb-4 max-w-[160px]" />
                <h3 class="font-extrabold text-xl mb-4">Contact Us</h3>
                <div class="space-y-2 text-sm mb-4 text-gray-700">
                    <p>✉️ office@anagataacademy.com</p>
                </div>
                <div class="flex gap-2">
                    <a href="#" class="w-9 h-9 bg-green-600 rounded-lg grid place-items-center hover:bg-green-700 text-white font-bold">W</a>
                    <a href="#" class="w-9 h-9 bg-blue-500 rounded-lg grid place-items-center hover:bg-blue-600 text-white font-bold">F</a>
                    <a href="#" class="w-9 h-9 bg-black rounded-lg grid place-items-center hover:bg-gray-800 text-white font-bold">X</a>
                    <a href="#" class="w-9 h-9 bg-red-600 rounded-lg grid place-items-center hover:bg-red-700 text-white font-bold">Y</a>
                    <a href="#" class="w-9 h-9 bg-neutral-600 rounded-lg grid place-items-center hover:bg-neutral-700 text-white font-bold">I</a>
                    <a href="#" class="w-9 h-9 bg-blue-400 rounded-lg grid place-items-center hover:bg-blue-500 text-white font-bold">L</a>
                </div>
            </div>

            {{-- Col 3 --}}
            <div>
                <img src="{{ asset('assets/homepage/QR-ASN.webp') }}" alt="QR Code"
                     class="bg-white p-2 rounded-xl mb-4 max-w-[160px]" />
                <p class="text-sm text-gray-700">
                    Revenue Tower, Lt 15, District 8 SCBD Jl. Jend. Sudirman Kav 52-53,
                    Senayan, Kec. Kebayoran Baru, Kota Jakarta Selatan 12190
                </p>
            </div>

            {{-- Col 4 --}}
            <div>
                <div class="mb-4">
                    <iframe class="w-full h-32 rounded-xl"
                            frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                            src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=id&amp;q=Revenue%20Tower%20SCBD+(Revenue%20Tower)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed">
                    </iframe>
                </div>
                <div class="space-y-1 text-sm text-gray-700">
                    <p class="font-extrabold text-gray-900">Terms & Policies</p>
                    <a href="#" class="block hover:underline">Privacy Policy</a>
                    <a href="#" class="block hover:underline">Terms of Service</a>
                </div>
            </div>
        </div>

        <div class="text-center text-sm border-t border-gray-300 pt-6 text-gray-700">
            <p class="font-extrabold text-gray-900">
                &copy; {{ date('Y') }}. All Rights Reserved PT. Anggota Sisaedu Nusantara
            </p>
            <p class="mt-2">
                Anagata Academy dan CodingMU adalah trademark PT Anagata Sisedu Nusantara.
                Terdaftar di Direktorat Jenderal Kekayaan Intelektual Republik Indonesia.
            </p>
        </div>
    </div>
</footer>
