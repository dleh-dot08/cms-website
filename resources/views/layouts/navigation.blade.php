<nav x-data="{ open: false }" class="bg-white border-b border-gray-200">
    @php
        use App\Models\User;

        $user = auth()->user();

        $isSuperadmin = auth()->check() && $user->role === User::ROLE_SUPERADMIN;
        $isContentRole = auth()->check() && in_array($user->role, [
            User::ROLE_SUPERADMIN,
            User::ROLE_ADMIN,
            User::ROLE_MARKETING,
        ]);

        // Active states
        $isManagementActive =
            request()->routeIs('admin.users.*') ||
            request()->routeIs('admin.officers.*') ||
            request()->routeIs('admin.interns.*') ||
            request()->routeIs('admin.mentors.*') ||
            request()->routeIs('admin.peserta.*');

        $isCourseMasterActive =
            request()->routeIs('admin.program_categories.*') ||
            request()->routeIs('admin.jenjangs.*') ||
            request()->routeIs('admin.sub_programs.*') ||
            request()->routeIs('admin.courses.*') ||
            request()->routeIs('admin.course_meetings.*');

        $isContentActive =
            request()->routeIs('admin.blogs.*') ||
            request()->routeIs('admin.news.*') ||
            request()->routeIs('admin.categories.*');

        $isRecruitmentActive =
            request()->routeIs('admin.recruitment_jobs.*') ||
            request()->routeIs('admin.divisions.*') ||
            request()->routeIs('admin.work_types.*') ||
            request()->routeIs('admin.locations.*') ||
            request()->routeIs('admin.tags.*');
    @endphp

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img 
                            src="{{ asset('img/logo/ASN_logo-color.png') }}" 
                            alt="Logo ASN"
                            class="h-9 w-auto"
                        >
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:items-center space-x-8 sm:-my-px sm:ms-10">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <span class="text-gray-900 font-semibold">{{ __('Dashboard') }}</span>
                    </x-nav-link>

                    {{-- MANAGEMENT DATA (Superadmin only) --}}
                    @if ($isSuperadmin)
                        <x-dropdown align="left" width="56">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold leading-5 transition duration-150 ease-in-out
                                    {{ $isManagementActive
                                        ? 'border-indigo-500 text-gray-900 focus:outline-none'
                                        : 'border-transparent text-gray-700 hover:text-gray-900 hover:border-gray-300 focus:outline-none'
                                    }}">
                                    <span>{{ __('Management Data') }}</span>
                                    <svg class="ms-2 h-4 w-4 fill-current text-gray-900" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('admin.users.index')">
                                    {{ __('Users') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('admin.peserta.index')">
                                    {{ __('Peserta') }}
                                </x-dropdown-link>

                                <div class="border-t border-gray-200"></div>

                                <x-dropdown-link :href="route('admin.officers.index')">
                                    {{ __('Officer') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.interns.index')">
                                    {{ __('Team Intern') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.mentors.index')">
                                    {{ __('Mentor') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    @endif

                    {{-- MASTER MANAGEMENT KURSUS (default: superadmin only, ubah jika perlu) --}}
                    @if ($isSuperadmin)
                        <x-dropdown align="left" width="64">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold leading-5 transition duration-150 ease-in-out
                                    {{ $isCourseMasterActive
                                        ? 'border-indigo-500 text-gray-900 focus:outline-none'
                                        : 'border-transparent text-gray-700 hover:text-gray-900 hover:border-gray-300 focus:outline-none'
                                    }}">
                                    <span>{{ __('Master Kursus') }}</span>
                                    <svg class="ms-2 h-4 w-4 fill-current text-gray-900" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('admin.program_categories.index')">
                                    {{ __('Kategori Program') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('admin.jenjangs.index')">
                                    {{ __('Jenjang') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('admin.sub_programs.index')">
                                    {{ __('Sub Program') }}
                                </x-dropdown-link>

                                <div class="border-t border-gray-200"></div>

                                <x-dropdown-link :href="route('admin.courses.index')">
                                    {{ __('Kursus') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    @endif

                    {{-- CONTENT (superadmin/admin/marketing) --}}
                    @if ($isContentRole)
                        <x-dropdown align="left" width="56">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold leading-5 transition duration-150 ease-in-out
                                    {{ $isContentActive
                                        ? 'border-indigo-500 text-gray-900 focus:outline-none'
                                        : 'border-transparent text-gray-700 hover:text-gray-900 hover:border-gray-300 focus:outline-none'
                                    }}">
                                    <span>{{ __('Content') }}</span>
                                    <svg class="ms-2 h-4 w-4 fill-current text-gray-900" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('admin.blogs.index')">
                                    {{ __('Blog') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('admin.news.index')">
                                    {{ __('News') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('admin.categories.index')">
                                    {{ __('Categories') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>

                        {{-- RECRUITMENT (superadmin/admin/marketing) --}}
                        <x-dropdown align="left" width="64">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold leading-5 transition duration-150 ease-in-out
                                    {{ $isRecruitmentActive
                                        ? 'border-indigo-500 text-gray-900 focus:outline-none'
                                        : 'border-transparent text-gray-700 hover:text-gray-900 hover:border-gray-300 focus:outline-none'
                                    }}">
                                    <span>{{ __('Recruitment') }}</span>
                                    <svg class="ms-2 h-4 w-4 fill-current text-gray-900" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('admin.recruitment_jobs.index')">
                                    {{ __('Lowongan') }}
                                </x-dropdown-link>

                                <div class="border-t border-gray-200"></div>

                                <x-dropdown-link :href="route('admin.divisions.index')">
                                    {{ __('Divisi') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.work_types.index')">
                                    {{ __('Tipe Kerja') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.locations.index')">
                                    {{ __('Lokasi') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.tags.index')">
                                    {{ __('Tag') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-semibold rounded-md text-gray-900 bg-white hover:bg-gray-50 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-2">
                                <svg class="fill-current h-4 w-4 text-gray-900" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-900 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <span class="font-semibold text-gray-900">{{ __('Dashboard') }}</span>
            </x-responsive-nav-link>

            @if ($isSuperadmin)
                <div class="px-4 pt-4 text-xs font-bold uppercase tracking-wider text-gray-700">
                    {{ __('Management Data') }}
                </div>

                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                    <span class="font-semibold text-gray-900">{{ __('Users') }}</span>
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.peserta.index')" :active="request()->routeIs('admin.peserta.*')">
                    <span class="font-semibold text-gray-900">{{ __('Peserta') }}</span>
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.officers.index')" :active="request()->routeIs('admin.officers.*')">
                    <span class="font-semibold text-gray-900">{{ __('Officer') }}</span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.interns.index')" :active="request()->routeIs('admin.interns.*')">
                    <span class="font-semibold text-gray-900">{{ __('Team Intern') }}</span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.mentors.index')" :active="request()->routeIs('admin.mentors.*')">
                    <span class="font-semibold text-gray-900">{{ __('Mentor') }}</span>
                </x-responsive-nav-link>

                <div class="px-4 pt-4 text-xs font-bold uppercase tracking-wider text-gray-700">
                    {{ __('Master Kursus') }}
                </div>

                <x-responsive-nav-link :href="route('admin.program_categories.index')" :active="request()->routeIs('admin.program_categories.*')">
                    <span class="font-semibold text-gray-900">{{ __('Kategori Program') }}</span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.jenjangs.index')" :active="request()->routeIs('admin.jenjangs.*')">
                    <span class="font-semibold text-gray-900">{{ __('Jenjang') }}</span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.sub_programs.index')" :active="request()->routeIs('admin.sub_programs.*')">
                    <span class="font-semibold text-gray-900">{{ __('Sub Program') }}</span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.courses.index')" :active="request()->routeIs('admin.courses.*')">
                    <span class="font-semibold text-gray-900">{{ __('Kursus') }}</span>
                </x-responsive-nav-link>
            @endif

            @if ($isContentRole)
                <div class="px-4 pt-4 text-xs font-bold uppercase tracking-wider text-gray-700">
                    {{ __('Content') }}
                </div>

                <x-responsive-nav-link :href="route('admin.blogs.index')" :active="request()->routeIs('admin.blogs.*')">
                    <span class="font-semibold text-gray-900">{{ __('Blog') }}</span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.news.index')" :active="request()->routeIs('admin.news.*')">
                    <span class="font-semibold text-gray-900">{{ __('News') }}</span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                    <span class="font-semibold text-gray-900">{{ __('Categories') }}</span>
                </x-responsive-nav-link>

                <div class="px-4 pt-4 text-xs font-bold uppercase tracking-wider text-gray-700">
                    {{ __('Recruitment') }}
                </div>

                <x-responsive-nav-link :href="route('admin.recruitment_jobs.index')" :active="request()->routeIs('admin.recruitment_jobs.*')">
                    <span class="font-semibold text-gray-900">{{ __('Lowongan') }}</span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.divisions.index')" :active="request()->routeIs('admin.divisions.*')">
                    <span class="font-semibold text-gray-900">{{ __('Divisi') }}</span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.work_types.index')" :active="request()->routeIs('admin.work_types.*')">
                    <span class="font-semibold text-gray-900">{{ __('Tipe Kerja') }}</span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.locations.index')" :active="request()->routeIs('admin.locations.*')">
                    <span class="font-semibold text-gray-900">{{ __('Lokasi') }}</span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.tags.index')" :active="request()->routeIs('admin.tags.*')">
                    <span class="font-semibold text-gray-900">{{ __('Tag') }}</span>
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-semibold text-base text-gray-900">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-700">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    <span class="font-semibold text-gray-900">{{ __('Profile') }}</span>
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <span class="font-semibold text-gray-900">{{ __('Log Out') }}</span>
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
