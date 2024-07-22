<x-layout>

    <section class="mt-4">
        <div class="flex justify-end">


            <a href="{{ route('posts.edit', $post->id) }}"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Edit</a>

            <form action="{{ route('posts.destroy', $post->id) }}" method="post">
                @csrf
                @method('DELETE')

                <button
                    class="text-white bg-red-500 hover:bg-pink-800 focus:ring-4 focus:ring-pink-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-500 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Delete</button>

            </form>

        </div>
        <x-error>
        </x-error>



    </section>

    {{--    Read More   --}}
    <div
        class="max-w-4xl mx-auto my-8 bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700 dark:text-white">
        @if ($post->image)
            <img class="rounded-t-lg w-full h-96 object-cover"
                src="{{ asset('storage/images/' . basename($post->image)) }}" alt="{{ $post->title }}" />
        @else
            <div class="h-96 bg-gray-200 rounded-t-lg flex items-center justify-center">
                <span class="text-gray-500 text-xl">No image available</span>
            </div>
        @endif

        <div class="p-8">
            <a href="#">
                <h5
                    class="mb-4 text-3xl font-bold tracking-tight text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition duration-300">
                    {{ $post->title }}</h5>
            </a>
            <p class="mb-6 text-lg font-normal text-gray-700 dark:text-gray-300">{{ Str::limit($post->content, 200) }}
            </p>

        </div>
    </div>

    {{--  --}}

    <div class="list-group">
        @auth

            <h3 class="text-white text-3xl mb-4 bg-slate-400 p-4">Comments</h3>
            @foreach ($post->comments as $comment)
                <div class="bg-white shadow-md rounded-lg p-4 mb-4 transition duration-300 ease-in-out hover:shadow-lg">
                    <div class="flex justify-between items-start">
                        <div class="flex-grow">
                            <p class="text-gray-800 text-lg mb-2">{{ $comment->content }}</p>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="text-sm text-gray-600">By {{ $comment->user->name }}</span>
                            </div>
                        </div>
                        <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            @endforeach
        @endauth
    </div>
</x-layout>
