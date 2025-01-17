<x-layout>
    @auth
        <div class="flex justify-end py-3">
            <a href="{{route('posts.create')}}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Create</a>
        </div>
{{--    for showing post created --}}
        <x-error></x-error>
    @endauth


    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        @if(isset($posts) && $posts->count() > 0)
            @foreach($posts as $post)
                <div class="max-w-sm m-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 dark:text-white ">
                    @if($post->image)
                        <a href="/posts/{{$post->id}}">

                        <img class="rounded-t-lg w-full h-48 object-cover" src="{{ asset('storage/images/' . basename($post->image)) }}" alt="{{ $post->title }}" />
                        </a>
                    <div class="my-0.2">

                        By: {{Auth::user()->name}}
                    </div>

                    @else<div class="h-48 bg-gray-200 rounded-t-lg flex items-center justify-center">
                            <span class="text-gray-500">No image available</span>
                        </div>
                    @endif
                    <div class="p-5">
                        <a href="">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{$post->title}}</h5>
                        </a>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{Str::limit($post->content, 100)}}</p>
                        <a href="/posts/{{$post->id}}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Read more
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach



        @else
            <p>No posts found.</p>
        @endif
    </div>
            <div class="mb-6 justify-center align-bottom ">
                {{$posts->links()}}
            </div>
</x-layout>
