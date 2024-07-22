<x-layout>
    @auth
        <div class="flex justify-end py-3">
            <a href="{{ route('posts.create') }}"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Create</a>
        </div>
        <x-error></x-error>
    @endauth

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        @if (isset($posts) && $posts->count() > 0)
            @foreach ($posts as $post)
                <div
                    class="max-w-sm m-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                    @if ($post->image)
                        <a href="/posts/{{ $post->id }}">
                            <img class="rounded-t-lg w-full h-48 object-cover"
                                src="{{ asset('storage/images/' . basename($post->image)) }}" alt="{{ $post->title }}" />
                        </a>
                    @else
                        <div class="h-48 bg-gray-200 rounded-t-lg flex items-center justify-center">
                            <span class="text-gray-500">No image available</span>
                        </div>
                    @endif
                    <div class="p-5">
                        <a href="">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ $post->title }}</h5>
                        </a>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                            {{ Str::limit($post->content, 100) }}</p>
                        <div class="flex justify-between items-center">
                            <a href="/posts/{{ $post->id }}"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Read more
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </a>
                            <button onclick="openCommentModal({{ $post->id }})"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-700">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Comment
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p>No posts found.</p>
        @endif
    </div>
    <div class="mb-6 justify-center align-bottom">
        {{ $posts->links() }}
    </div>
    {{-- comment --}}
    <div id="commentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Add a Comment</h3>
                <div class="mt-2 px-7 py-3">
                    <form id="commentForm">
                        @csrf
                        <input type="hidden" id="postId" name="postId">
                        <textarea id="commentContent" name="content" rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            required></textarea>
                        <button type="submit"
                            class="mt-3 px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                            Submit Comment
                        </button>
                    </form>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="closeModal"
                        class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openCommentModal(postId) {
            document.getElementById('commentModal').classList.remove('hidden');
            document.getElementById('postId').value = postId;
        }

        document.getElementById('closeModal').addEventListener('click', function() {
            document.getElementById('commentModal').classList.add('hidden');
        });

        document.getElementById('commentForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const postId = document.getElementById('postId').value;
            const content = document.getElementById('commentContent').value;

            console.log('Sending request to:', `/posts/${postId}/comments`);
            console.log('Request body:', {
                content: content
            });

            axios.post(`/posts/${postId}/comments`, {
                    content: content
                })
                .then(response => {
                    console.log('Response data:', response.data);
                    if (response.data.success) {
                        alert('Comment added successfully!');
                        document.getElementById('commentModal').classList.add('hidden');
                        document.getElementById('commentContent').value = '';
                    } else {
                        alert(response.data.message || 'Unable to add comment. Please try again later.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again later.');
                });


        });
    </script>

</x-layout>
