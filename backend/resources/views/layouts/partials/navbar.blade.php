<nav class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all ease-in duration-250 shadow-none rounded-2xl lg:flex-nowrap lg:justify-start bg-blue-600">
    <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">

        {{-- Breadcrumb + Judul --}}
        <div>
            <ol class="flex flex-wrap pt-1 mr-12 text-sm text-white opacity-70">
                <li>Pages</li>
                <li class="pl-2 before:content-['/'] before:pr-2 text-white">Dashboard</li>
            </ol>
            <h6 class="mb-0 font-bold text-white capitalize">Dashboard</h6>
        </div>

        {{-- Profil dan Dropdown --}}
        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
            <button
                class="flex items-center text-white gap-2 focus:outline-none transition duration-200 hover:opacity-90"
                @click="open = !open"
            >
                <i class="fa fa-user text-lg"></i>
                <span class="text-sm font-medium">{{ session('user.name') }}</span>
            </button>

            <div
                x-show="open"
                x-transition
                class="absolute right-0 mt-2 w-44 bg-white text-gray-700 rounded-xl shadow-xl py-2 text-sm z-50"
            >
                <a href="{{ route('password.request') }}"
                   class="block w-full text-left px-4 py-2 hover:bg-gray-100 rounded-t-xl">
                    Ganti Password
                </a>
                <a href="{{ route('logout') }}"
                   class="block w-full text-left px-4 py-2 hover:bg-gray-100 rounded-b-xl">
                    Logout
                </a>
            </div>
        </div>
    </div>
</nav>
