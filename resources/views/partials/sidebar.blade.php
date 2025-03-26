<aside :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
    class="sidebar fixed left-0 top-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 duration-300 ease-linear dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0"
    @click.outside="sidebarToggle = false">
    <!-- SIDEBAR HEADER -->
    <div :class="sidebarToggle ? 'justify-center' : 'justify-between'"
        class="sidebar-header flex items-center gap-2 pb-7 pt-8">
        <a href="/">
            <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
                <img class="dark:hidden" src="{{ asset('images/logo/KOHI.png') }}" alt="Logo" />
                <img class="hidden dark:block" src="{{ asset('images/logo/KOHI.png') }}" alt="Logo" />
            </span>

            <img class="logo-icon" :class="sidebarToggle ? 'lg:block' : 'hidden'"
                src="{{ asset('images/logo/KOHI.png') }}" alt="Logo" />
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
                            class="menu-item group {{ request()->routeIs('products.*') ? 'menu-item-active' : 'menu-item-inactive' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-box">
                                <path
                                    d="M21 16V8a2 2 0 0 0-1-1.73L13 2.27a2 2 0 0 0-2 0L4 6.27A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73Z" />
                                <path d="m3.3 7 8.7 5 8.7-5" />
                                <path d="M12 22V12" />
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
                                stroke-linejoin="round" class="lucide lucide-clipboard-list">
                                <path d="M8 2h8a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z" />
                                <path d="M9 6h6" />
                                <path d="M9 10h6" />
                                <path d="M9 14h6" />
                                <path d="M9 18h6" />
                            </svg>
                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Orders
                            </span>
                        </a>
                    </li>
                    <!-- Menu Item orders -->

                    <!-- Menu articles -->
                    <li>
                        <a href="{{ route('articles.index') }}"
                            @click="selected = (selected === 'Articles' ? '' : 'Articles')"
                            class="flex items-center p-3 rounded-lg transition-colors duration-200 group {{ request()->routeIs('articles.*') ? 'menu-item-active' : 'menu-item-inactive' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-file-text">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                                <line x1="16" y1="13" x2="8" y2="13" />
                                <line x1="16" y1="17" x2="8" y2="17" />
                                <polyline points="10 9 9 9 8 9" />
                            </svg>
                            <span class="ml-3" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Articles
                            </span>
                        </a>
                    </li>
                    <!-- Menu articles -->

                    <!-- Menu users -->
                    <li>
                        <a href="{{ route('users.index') }}"
                            @click="selected = (selected === 'Users' ? '' : 'Users')"
                            class="menu-item group {{ request()->routeIs('users.*') ? 'menu-item-active' : 'menu-item-inactive' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users">
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
                </ul>
            </div>
        </nav>
        <!-- Sidebar Menu End-->
    </div>
</aside>
<script>
    fetch('/api/articles')
        .then(response => response.json())
        .then(data => {
            const list = document.getElementById('article-list');
            data.forEach(article => {
                const item = document.createElement('li');
                item.className = 'bg-white p-4 rounded-lg shadow-md';
                item.innerHTML =
                    `<strong class="text-lg">${article.title}</strong><p class="text-gray-700 mt-2">${article.content}</p>`;
                list.appendChild(item);
            });
        })
        .catch(error => console.error('Error:', error));
</script>
