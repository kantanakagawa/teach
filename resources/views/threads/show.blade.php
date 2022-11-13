<x-app-layout>
    <div class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-8 px-8 py-4 bg-white shadow-md">
        <x-flash-message :message="session('notice')" />
        <x-validation-errors :errors="$errors" />
        <article class="mb-2">
            <h2 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-1 text-3xl md:text-4xl break-words">
                {{ $thread->title }}</h2>
            <h3>{{ $thread->user->name }}</h3>
            <p class="text-sm mb-2 md:text-base font-normal text-gray-600">
                <span
                    class="text-red-400 font-bold">{{ date('Y-m-d H:i:s', strtotime('-1 day')) < $thread->created_at ? 'NEW' : '' }}</span>
                {{ $thread->created_at }}
            </p>
            <img src="{{ $thread->image_url }}" alt="" class="mb-4">
            <a class="text-gray-700 text-base break-all" href = {{ $thread->url }}>{!! nl2br(e($thread->url)) !!}</a>
            <p class="text-gray-700 text-base break-all">{!! nl2br(e($thread->body)) !!}</p>
        </article>
        <div class="flex flex-row text-center my-4">
            @can('update', $thread)
                <a href="{{ route('threads.edit', $thread) }}"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2">編集</a>
            @endcan
            @can('delete', $thread)
                <form action="{{ route('threads.destroy', $thread) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="削除" onclick="if(!confirm('削除しますか？')){return false};"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20">
                </form>
            @endcan
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h3>{{ $thread->name }}</h3>
            </div>
            <div class="col-md-10 mb-3">
                <a href="{{ route('threads.index') }}"
                    class="relative inline-flex items-center justify-start py-3 pl-4 pr-12 overflow-hidden font-semibold text-indigo-600 transition-all duration-150 ease-in-out rounded hover:pl-10 hover:pr-6 bg-gray-50 group">
                    <span
                        class="absolute bottom-0 left-0 w-full h-1 transition-all duration-150 ease-in-out bg-indigo-600 group-hover:h-full"></span>
                    <span class="absolute right-0 pr-4 duration-200 ease-out group-hover:translate-x-12">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </span>
                    <span
                        class="absolute left-0 pl-2.5 -translate-x-12 group-hover:translate-x-0 ease-out duration-200">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </span>
                    <span
                        class="relative w-full text-left transition-colors duration-200 ease-in-out group-hover:text-white">掲示板に戻る</span>
                </a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10 mb-5">
                <section class="font-sans break-normal text-gray-900 ">
                    @foreach ($messages as $message)
                        <div class="my-2">
                            <span class="text-sm">{{ $message->created_at }}</span>
                            <p>{!! nl2br(e($message->body)) !!}</p>
                            <div class="flex justify-end text-center">
                                @can('update', $message)
                                    <a href="{{ route('threads.messages.edit', [$thread, $message]) }}"
                                        class="text-sm bg-green-400 hover:bg-green-600 text-white font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline w-20 mr-2">編集</a>
                                @endcan
                                @can('delete', $message)
                                    <form action="{{ route('threads.messages.destroy', [$thread, $message]) }}"
                                        method="post">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" value="削除"
                                            onclick="if(!confirm('削除しますか？')){return false};"
                                            class="text-sm bg-red-400 hover:bg-red-600 text-white font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline w-20">
                                    </form>
                                @endcan
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </section>
            </div>
        </div>
        <div class="sm:col-span-2">
            <label for="message" class="inline-block text-gray-800 text-sm sm:text-base mb-2">コメントを投稿する</label>
            <form method="POST" action="{{ route('threads.messages.store', $thread->id) }}" class="mb-4">
                @csrf
                <textarea name="body"
                    class="w-full h-64 bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2"></textarea>
                <div class="sm:col-span-2 flex justify-between items-center">
                    <button
                        class="inline-block bg-indigo-500 hover:bg-indigo-600 active:bg-indigo-700 focus-visible:ring ring-indigo-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3">投稿</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
