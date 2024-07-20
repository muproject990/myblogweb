<x-layout>

    <section class="mt-4">
        <div class="flex justify-end">


                <a href="{{route('posts.edit',$post->id)}}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Edit</a>

<form action="{{route('posts.destroy',$post->id)}}" method="post">
    @csrf==
    @method('DELETE')

                <button  class="text-white bg-red-500 hover:bg-pink-800 focus:ring-4 focus:ring-pink-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-500 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Delete</button>

</form>

        </div>
    <x-error>
    </x-error>



    </section>

{{--    Read More   --}}
    <div class="max-w-4xl mx-auto my-8 bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700 dark:text-white">
        @if($post->image)
            <img class="rounded-t-lg w-full h-96 object-cover" src="{{ asset('storage/images/' . basename($post->image)) }}" alt="{{ $post->title }}" />
        @else
            <div class="h-96 bg-gray-200 rounded-t-lg flex items-center justify-center">
                <span class="text-gray-500 text-xl">No image available</span>
            </div>
        @endif

        <div class="p-8">
            <a href="#">
                <h5 class="mb-4 text-3xl font-bold tracking-tight text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition duration-300">{{$post->title}}</h5>
            </a>
            <p class="mb-6 text-lg font-normal text-gray-700 dark:text-gray-300">{{Str::limit($post->content, 200)}}</p>

        </div>
    </div>
</x-layout>
