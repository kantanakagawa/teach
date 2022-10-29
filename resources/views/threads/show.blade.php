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
                <a href="{{ route('threads.index') }}" class="btn btn-primary">掲示板に戻る</a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10 mb-5">
                <section class="font-sans break-normal text-gray-900 ">
                    @foreach ($messages as $message)
                        <div class="my-2">
                            <span class="font-bold mr-3">{{ $message->user->name }}</span>
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
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <h5 class="card-header">レスを投稿する</h5>
                    <div class="card-body">
                        <form method="POST" action="{{ route('threads.messages.store', $thread->id) }}"
                            class="mb-4">
                            @csrf
                            <div class="form-group">
                                <label for="thread-first-content">内容</label>
                                <textarea name="body" class="form-control" id="thread-first-content" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">書き込む</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
