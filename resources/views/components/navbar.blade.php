<nav class="bg-white border-gray-200 dark:bg-gray-900">
    <div class="max-w-screen-xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <a href="/posts" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Blog Website</span>
            </a>

            <div class="flex items-center space-x-4">


                @auth
                    <span class="text-blue-600 dark:text-blue-400 font-semibold h-16 flex items-center">Welcome
                        {{ Auth::user()->name }}</span>

                    <div class="h-16 flex items-center">
                        <x-search></x-search>
                    </div>

                    <form method="post" action="{{ route('logout') }}" class="h-16 flex items-center">
                        @csrf
                        <button type="submit"
                            class="text-gray-900 hover:text-blue-700 dark:text-white dark:hover:text-blue-500">Logout</button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}"
                        class="text-gray-900 hover:text-blue-700 dark:text-white dark:hover:text-blue-500 h-16 flex items-center">Login</a>
                    <a href="{{ route('register') }}"
                        class="text-gray-900 hover:text-blue-700 dark:text-white dark:hover:text-blue-500 h-16 flex items-center">Register</a>
                @endguest
            </div>
        </div>
    </div>
</nav>
