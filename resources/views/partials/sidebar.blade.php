<aside :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
    class="sidebar fixed left-0 top-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 duration-300 ease-linear dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0"
    @click.outside="sidebarToggle = false">
    <!-- SIDEBAR HEADER -->
    <div :class="sidebarToggle ? 'justify-center' : 'justify-between'"
        class="sidebar-header flex items-center gap-2 pb-7 pt-8">
        <a href="index.html">
            <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
                <img class="dark:hidden" src="{{ asset('images/logo/KOHI.png') }} alt="Logo" />
                <img class="hidden dark:block" src="{{ asset('images/logo/KOHI.png') }} alt="Logo" />
            </span>

            <img class="logo-icon" :class="sidebarToggle ? 'lg:block' : 'hidden'" src="./images/logo/KOHI.png"
                alt="Logo" />
        </a>
    </div>
    <!-- SIDEBAR HEADER -->

    <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear">
        <!-- Sidebar Menu -->
        <nav x-data="{ selected: $persist('Dashboard') }">
            <!-- Menu Group -->
            <div>
                <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
                    <span class="menu-group-title" :class="sidebarToggle ? 'lg:hidden' : ''">
                        MENU
                    </span>

                    <svg :class="sidebarToggle ? 'lg:block hidden' : 'hidden'"
                        class="menu-group-icon mx-auto fill-current" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z"
                            fill="" />
                    </svg>
                </h3>

                <ul class="mb-6 flex flex-col gap-4">
                    <svg class="menu-item-arrow"
                        :class="[(selected === 'Dashboard') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive',
                            sidebarToggle ? 'lg:hidden' : ''
                        ]"
                        width="20" height="20" viewBox="0 0 20 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">

                    </svg>
                    </a>
                    </li>
                    <!-- Menu Item Dashboard -->

                    <!-- Menu Item category -->
                    <li>
                        <a href="{{ route('categories.index') }}"
                            @click="selected = (selected === 'Profile' ? '' : 'Profile')"
                            class="menu-item group {{ request()->routeIs('categories.*') ? 'menu-item-active' : 'menu-item-inactive' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-chart-bar-stacked">
                                <path d="M11 13v4" />
                                <path d="M15 5v4" />
                                <path d="M3 3v16a2 2 0 0 0 2 2h16" />
                                <rect x="7" y="13" width="9" height="4" rx="1" />
                                <rect x="7" y="5" width="12" height="4" rx="1" />
                            </svg>
                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Category
                            </span>
                        </a>
                    </li>
                    <!-- Menu Item category -->

                    <!-- Menu Item products -->
                    <li>
                        <a href="{{ route('products.index') }}"
                            @click="selected = (selected === 'Profile' ? '' : 'Profile')"
                            class="menu-item group {{ request()->routeIs('categories.*') ? 'menu-item-active' : 'menu-item-inactive' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-chart-bar-stacked">
                                <path d="M11 13v4" />
                                <path d="M15 5v4" />
                                <path d="M3 3v16a2 2 0 0 0 2 2h16" />
                                <rect x="7" y="13" width="9" height="4" rx="1" />
                                <rect x="7" y="5" width="12" height="4" rx="1" />
                            </svg>
                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Products
                            </span>
                        </a>
                    </li>
                    <!-- Menu Item products -->

                    <!-- Menu Item orders -->
                    <li>
                        <a href="{{ route('orders.index') }}"
                            @click="selected = (selected === 'Orders' ? '' : 'Orders')"
                            class="menu-item group {{ request()->routeIs('orders.*') ? 'menu-item-active' : 'menu-item-inactive' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-chart-bar-stacked">
                                <path d="M11 13v4" />
                                <path d="M15 5v4" />
                                <path d="M3 3v16a2 2 0 0 0 2 2h16" />
                                <rect x="7" y="13" width="9" height="4" rx="1" />
                                <rect x="7" y="5" width="12" height="4" rx="1" />
                            </svg>
                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Orders
                            </span>
                        </a>
                    </li>
                    <!-- Menu Item orders -->

                    <!-- Menu users -->
                    <li>
                        <a href="{{ route('users.index') }}" @click="selected = (selected === 'Users' ? '' : 'Users')"
                            class="menu-item group {{ request()->routeIs('users.*') ? 'menu-item-active' : 'menu-item-inactive' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-users">
                                <path d="M17 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M9 21v-2a4 4 0 0 1 3-3.87" />
                                <path d="M4 8a4 4 0 1 1 8 0 4 4 0 1 1-8 0" />
                                <path d="M20 8a4 4 0 1 1-8 0 4 4 0 1 1 8 0" />
                            </svg>
                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Users
                            </span>
                        </a>
                    </li>
                    <!-- Menu users -->

                    <!-- Menu Item Profile -->
                    <li>
                        <a href="profile.html" @click="selected = (selected === 'Profile' ? '':'Profile')"
                            class="menu-item group"
                            :class="(selected === 'Profile') && (page === 'profile') ? 'menu-item-active' :
                            'menu-item-inactive'">
                            <svg :class="(selected === 'Profile') && (page === 'profile') ? 'menu-item-icon-active' :
                            'menu-item-icon-inactive'"
                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M12 3.5C7.30558 3.5 3.5 7.30558 3.5 12C3.5 14.1526 4.3002 16.1184 5.61936 17.616C6.17279 15.3096 8.24852 13.5955 10.7246 13.5955H13.2746C15.7509 13.5955 17.8268 15.31 18.38 17.6167C19.6996 16.119 20.5 14.153 20.5 12C20.5 7.30558 16.6944 3.5 12 3.5ZM17.0246 18.8566V18.8455C17.0246 16.7744 15.3457 15.0955 13.2746 15.0955H10.7246C8.65354 15.0955 6.97461 16.7744 6.97461 18.8455V18.856C8.38223 19.8895 10.1198 20.5 12 20.5C13.8798 20.5 15.6171 19.8898 17.0246 18.8566ZM2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12ZM11.9991 7.25C10.8847 7.25 9.98126 8.15342 9.98126 9.26784C9.98126 10.3823 10.8847 11.2857 11.9991 11.2857C13.1135 11.2857 14.0169 10.3823 14.0169 9.26784C14.0169 8.15342 13.1135 7.25 11.9991 7.25ZM8.48126 9.26784C8.48126 7.32499 10.0563 5.75 11.9991 5.75C13.9419 5.75 15.5169 7.32499 15.5169 9.26784C15.5169 11.2107 13.9419 12.7857 11.9991 12.7857C10.0563 12.7857 8.48126 11.2107 8.48126 9.26784Z"
                                    fill="" />
                            </svg>

                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                User Profile
                            </span>
                        </a>
                    </li>
                    <!-- Menu Item Profile -->

                    <!-- Support Group -->
                    <div>
                        <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
                            <span class="menu-group-title" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Support
                            </span>

                            <svg :class="sidebarToggle ? 'lg:block hidden' : 'hidden'"
                                class="menu-group-icon mx-auto fill-current" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z"
                                    fill="" />
                            </svg>
                        </h3>

                        <ul class="mb-6 flex flex-col gap-4">
                            <!-- Menu Item Chat -->
                            <li>
                                <a href="chat.html" @click="selected = (selected === 'Chat' ? '':'Chat')"
                                    class="menu-item group"
                                    :class="(selected === 'Chat') && (page === 'chat') ? 'menu-item-active' :
                                    'menu-item-inactive'">
                                    <svg :class="(selected === 'Chat') && (page === 'chat') ? 'menu-item-icon-active' :
                                    'menu-item-icon-inactive'"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M4.00002 12.0957C4.00002 7.67742 7.58174 4.0957 12 4.0957C16.4183 4.0957 20 7.67742 20 12.0957C20 16.514 16.4183 20.0957 12 20.0957H5.06068L6.34317 18.8132C6.48382 18.6726 6.56284 18.4818 6.56284 18.2829C6.56284 18.084 6.48382 17.8932 6.34317 17.7526C4.89463 16.304 4.00002 14.305 4.00002 12.0957ZM12 2.5957C6.75332 2.5957 2.50002 6.849 2.50002 12.0957C2.50002 14.4488 3.35633 16.603 4.77303 18.262L2.71969 20.3154C2.50519 20.5299 2.44103 20.8525 2.55711 21.1327C2.6732 21.413 2.94668 21.5957 3.25002 21.5957H12C17.2467 21.5957 21.5 17.3424 21.5 12.0957C21.5 6.849 17.2467 2.5957 12 2.5957ZM7.62502 10.8467C6.93467 10.8467 6.37502 11.4063 6.37502 12.0967C6.37502 12.787 6.93467 13.3467 7.62502 13.3467H7.62512C8.31548 13.3467 8.87512 12.787 8.87512 12.0967C8.87512 11.4063 8.31548 10.8467 7.62512 10.8467H7.62502ZM10.75 12.0967C10.75 11.4063 11.3097 10.8467 12 10.8467H12.0001C12.6905 10.8467 13.2501 11.4063 13.2501 12.0967C13.2501 12.787 12.6905 13.3467 12.0001 13.3467H12C11.3097 13.3467 10.75 12.787 10.75 12.0967ZM16.375 10.8467C15.6847 10.8467 15.125 11.4063 15.125 12.0967C15.125 12.787 15.6847 13.3467 16.375 13.3467H16.3751C17.0655 13.3467 17.6251 12.787 17.6251 12.0967C17.6251 11.4063 17.0655 10.8467 16.3751 10.8467H16.375Z"
                                            fill="" />
                                    </svg>

                                    <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                        Chat
                                    </span>
                                </a>
                            </li>
                            <!-- Menu Item Chat -->

                            <!-- Menu Item Inbox -->
                            <li>
                                <a href="#" @click.prevent="selected = (selected === 'Email' ? '':'Email')"
                                    class="menu-item group"
                                    :class="(selected === 'Email') || (page === 'inbox' || page === 'inboxDetails') ?
                                    'menu-item-active' : 'menu-item-inactive'">
                                    <svg :class="(selected === 'Email') || (page === 'inbox' || page === 'inboxDetails') ?
                                    'menu-item-icon-active' : 'menu-item-icon-inactive'"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M3.5 8.187V17.25C3.5 17.6642 3.83579 18 4.25 18H19.75C20.1642 18 20.5 17.6642 20.5 17.25V8.18747L13.2873 13.2171C12.5141 13.7563 11.4866 13.7563 10.7134 13.2171L3.5 8.187ZM20.5 6.2286C20.5 6.23039 20.5 6.23218 20.5 6.23398V6.24336C20.4976 6.31753 20.4604 6.38643 20.3992 6.42905L12.4293 11.9867C12.1716 12.1664 11.8291 12.1664 11.5713 11.9867L3.60116 6.42885C3.538 6.38481 3.50035 6.31268 3.50032 6.23568C3.50028 6.10553 3.60577 6 3.73592 6H20.2644C20.3922 6 20.4963 6.10171 20.5 6.2286ZM22 6.25648V17.25C22 18.4926 20.9926 19.5 19.75 19.5H4.25C3.00736 19.5 2 18.4926 2 17.25V6.23398C2 6.22371 2.00021 6.2135 2.00061 6.20333C2.01781 5.25971 2.78812 4.5 3.73592 4.5H20.2644C21.2229 4.5 22 5.27697 22.0001 6.23549C22.0001 6.24249 22.0001 6.24949 22 6.25648Z"
                                            fill="" />
                                    </svg>

                                    <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                        Email
                                    </span>

                                    <svg class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
                                        :class="[(selected === 'Email') ? 'menu-item-arrow-active' :
                                            'menu-item-arrow-inactive',
                                            sidebarToggle ? 'lg:hidden' : ''
                                        ]"
                                        width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke=""
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>

                                <!-- Dropdown Menu Start -->
                                <div class="translate transform overflow-hidden"
                                    :class="(selected === 'Email') ? 'block' : 'hidden'">
                                    <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                                        class="menu-dropdown mt-2 flex flex-col gap-1 pl-9">
                                        <li>
                                            <a href="inbox.html" class="menu-dropdown-item group"
                                                :class="page === 'inbox' ? 'menu-dropdown-item-active' :
                                                    'menu-dropdown-item-inactive'">
                                                Inbox
                                                <span class="absolute right-3 flex items-center gap-1">
                                                    <span class="menu-dropdown-badge"
                                                        :class="page === 'inbox' ? 'menu-dropdown-badge-active' :
                                                            'menu-dropdown-badge-inactive'">
                                                        Pro
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="inbox-details.html" class="menu-dropdown-item group"
                                                :class="page === 'inboxDetails' ? 'menu-dropdown-item-active' :
                                                    'menu-dropdown-item-inactive'">
                                                Details
                                                <span class="absolute right-3 flex items-center gap-1">
                                                    <span class="menu-dropdown-badge"
                                                        :class="page === 'inboxDetails' ? 'menu-dropdown-badge-active' :
                                                            'menu-dropdown-badge-inactive'">
                                                        Pro
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- Dropdown Menu End -->
                            </li>
                            <!-- Menu Item Inbox -->

                            <!-- Menu Item Invoice -->
                            <li>
                                <a href="invoice.html" @click="selected = (selected === 'Invoice' ? '':'Invoice')"
                                    class="menu-item group"
                                    :class="(selected === 'Invoice') && (page === 'invoice') ? 'menu-item-active' :
                                    'menu-item-inactive'">
                                    <svg :class="(selected === 'Invoice') && (page === 'invoice') ? 'menu-item-icon-active' :
                                    'menu-item-icon-inactive'"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M19.5 19.75C19.5 20.9926 18.4926 22 17.25 22H6.75C5.50736 22 4.5 20.9926 4.5 19.75V9.62105C4.5 9.02455 4.73686 8.45247 5.15851 8.03055L10.5262 2.65951C10.9482 2.23725 11.5207 2 12.1177 2H17.25C18.4926 2 19.5 3.00736 19.5 4.25V19.75ZM17.25 20.5C17.6642 20.5 18 20.1642 18 19.75V4.25C18 3.83579 17.6642 3.5 17.25 3.5H12.248L12.2509 7.49913C12.2518 8.7424 11.2442 9.75073 10.0009 9.75073H6V19.75C6 20.1642 6.33579 20.5 6.75 20.5H17.25ZM7.05913 8.25073L10.7488 4.55876L10.7509 7.5002C10.7512 7.91462 10.4153 8.25073 10.0009 8.25073H7.05913ZM8.25 14.5C8.25 14.0858 8.58579 13.75 9 13.75H15C15.4142 13.75 15.75 14.0858 15.75 14.5C15.75 14.9142 15.4142 15.25 15 15.25H9C8.58579 15.25 8.25 14.9142 8.25 14.5ZM8.25 17.5C8.25 17.0858 8.58579 16.75 9 16.75H12C12.4142 16.75 12.75 17.0858 12.75 17.5C12.75 17.9142 12.4142 18.25 12 18.25H9C8.58579 18.25 8.25 17.9142 8.25 17.5Z"
                                            fill="" />
                                    </svg>

                                    <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                        Invoice
                                    </span>
                                </a>
                            </li>
                            <!-- Menu Item Invoice -->
                        </ul>
                    </div>
                    <div>
                        <ul class="mb-6 flex flex-col gap-4">
                        </ul>
                    </div>
        </nav>
        <!-- Sidebar Menu End-->
    </div>
</aside>
