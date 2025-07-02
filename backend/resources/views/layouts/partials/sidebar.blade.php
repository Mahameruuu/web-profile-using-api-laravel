<button onclick="document.getElementById('sidebar').classList.remove('-translate-x-full')" class="fixed top-4 left-4 z-50 p-2 xl:hidden">
  <i class="fas fa-bars text-slate-700"></i>
</button>

<aside id="sidebar" class="fixed inset-y-0 flex-wrap items-center justify-between block w-full p-0 my-4 overflow-y-auto antialiased transition-transform duration-200 bg-white border-0 shadow-xl dark:shadow-none dark:bg-slate-850 max-w-64 ease-nav-brand z-990 xl:ml-6 rounded-2xl xl:left-0 xl:translate-x-0 -translate-x-full xl:translate-x-0" aria-expanded="false">
  <div class="h-19 relative">
    <i class="absolute top-0 right-0 p-4 opacity-50 cursor-pointer fas fa-times dark:text-white text-slate-400 xl:hidden" onclick="document.getElementById('sidebar').classList.add('-translate-x-full')"></i>

    <a href="{{ route('dashboard') }}" class="block px-8 py-6 m-0 text-sm whitespace-nowrap dark:text-white text-slate-700">
      <img src="{{ asset('assets/img/logo-ct-dark.png') }}" class="inline h-full max-w-full transition-all duration-200 dark:hidden ease-nav-brand max-h-8" alt="main_logo" />
      <img src="{{ asset('assets/img/logo-ct.png') }}" class="hidden h-full max-w-full transition-all duration-200 dark:inline ease-nav-brand max-h-8" alt="main_logo" />
      <span class="ml-1 font-semibold transition-all duration-200 ease-nav-brand">Argon Dashboard</span>
    </a>
  </div>

  <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent dark:via-white" />

  <div class="items-center block w-auto max-h-screen overflow-auto h-sidenav grow basis-full">
    <ul class="flex flex-col pl-0 mb-0">

      {{-- Dashboard --}}
      <li class="mt-0.5 w-full">
        <a href="{{ route('dashboard') }}" class="py-2.7 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-colors duration-200
          {{ request()->routeIs('dashboard') ? 'bg-blue-500/13 text-slate-700 dark:text-white dark:opacity-80' : 'text-slate-700 hover:bg-gray-100 dark:text-white dark:opacity-80' }}">
          <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center text-center xl:p-2.5">
            <i class="text-blue-500 ni ni-tv-2"></i>
          </div>
          <span class="ml-1">Dashboard</span>
        </a>
      </li>

      {{-- Users --}}
      <li class="mt-0.5 w-full">
        <a href="{{ route('users.index') }}" class="py-2.7 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-colors duration-200
          {{ request()->is('users*') ? 'bg-blue-500/13 text-slate-700 dark:text-white dark:opacity-80' : 'text-slate-700 hover:bg-gray-100 dark:text-white dark:opacity-80' }}">
          <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center text-center xl:p-2.5">
            <i class="text-cyan-500 ni ni-single-02"></i>
          </div>
          <span class="ml-1">Users</span>
        </a>
      </li>


      {{-- Kegiatan --}}
      <li class="mt-0.5 w-full">
        <a href="{{ route('kegiatan.index') }}" class="py-2.7 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-colors duration-200
          {{ request()->routeIs('kegiatan.*') ? 'bg-blue-500/13 text-slate-700 dark:text-white dark:opacity-80' : 'text-slate-700 hover:bg-gray-100 dark:text-white dark:opacity-80' }}">
          <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center text-center xl:p-2.5">
            <i class="text-orange-500 ni ni-calendar-grid-58"></i>
          </div>
          <span class="ml-1">Kegiatan</span>
        </a>
      </li>

      {{-- Manajemen Input --}}
      <li class="mt-0.5 w-full">
        <a href="#" class="py-2.7 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-colors duration-200
          {{ request()->routeIs('inputs.*') ? 'bg-blue-500/13 text-slate-700 dark:text-white dark:opacity-80' : 'text-slate-700 hover:bg-gray-100 dark:text-white dark:opacity-80' }}">
          <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center text-center xl:p-2.5">
            <i class="text-orange-500 ni ni-settings"></i>
          </div>
          <span class="ml-1">Manajemen Input</span>
        </a>
      </li>

      {{-- Surat Cuti --}}
      <li class="mt-0.5 w-full">
        <a href="#" class="py-2.7 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-colors duration-200
          {{ request()->routeIs('cuti.*') ? 'bg-blue-500/13 text-slate-700 dark:text-white dark:opacity-80' : 'text-slate-700 hover:bg-gray-100 dark:text-white dark:opacity-80' }}">
          <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center text-center xl:p-2.5">
            <i class="text-red-500 ni ni-archive-2"></i>
          </div>
          <span class="ml-1">Surat Cuti</span>
        </a>
      </li>

    </ul>
  </div>
</aside>
