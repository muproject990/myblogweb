<x-layout>

    <section class="mt-4">
        <div class="flex justify-end">
                <a href="{{route('posts.edit',$post->id)}}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Edit</a>

<form action="{{route('posts.destroy',$post->id)}}" method="post">
    @csrf
    @method('DELETE')

                <button  class="text-white bg-red-500 hover:bg-pink-800 focus:ring-4 focus:ring-pink-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-500 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Delete</button>
</form>

        </div>



    </section>

{{--    Read More   --}}
    <div class="p-6 bg-gradient-to-br from-grey-400 via-pink-500 to-red-500">
        <main class="max-w-6xl mx-auto lg:mt-20 space-y-8 bg-white rounded-lg shadow-lg overflow-hidden">
            <header class="bg-yellow-100 p-6">
                <h1 class="text-4xl font-bold text-center text-indigo-800">
                    {{ $post->title }}
                </h1>
            </header>

            <div class="px-6 py-8 bg-green-50">
                <p class="text-lg leading-relaxed text-gray-800">
                    {{ $post->content }}
                </p>
            </div>

            <footer class="bg-blue-100 p-4 text-sm text-blue-600 text-center">
                <!-- You can add additional information here, like post date or author -->
            </footer>
        </main>
    </div>



</x-layout>
