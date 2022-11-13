<x-app-layout>
    <div class="container">
        <div class="row justify-content-center">
            <x-flash-message :message="session('notice')" />
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 my-2" role="alert">
                    <p>
                        <b>{{ count($errors) }}件のエラーがあります。</b>
                    </p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="col-md-8">
                {{ $threads->links() }}
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10 mb-5">
                <section class="font-sans break-normal text-gray-900 ">
                    @foreach ($threads as $thread)
                        <div class="col-md-8">
                            <div class="container lg:w-1/2 md:w-4/5 w-11/12 mx-auto mt-8 px-8 bg-white shadow-md">
                                <div class="my-2">
                                <input type="checkbox" name="check" value="check">
                                    <div class="my-2 m-2 p-5">
                                        <h1 class="text-xl font-bold">{{ Str::limit($thread->title, 20) }}</h1>
                                        <a href = {{ $thread->url }}>{{ Str::limit($thread->url,50) }}</a>
                                        <p>{{ Str::limit($thread->body, 50) }}</p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ route('threads.show', $thread->id) }}">全部読む</a>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                </section>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="container lg:w-1/2 md:w-4/5 w-11/12 mx-auto mt-8 px-8 bg-white shadow-md">
                    <h2 class="text-center text-lg font-bold pt-6 tracking-widest">新規スレッド作成</h2>
                    @if ($errors->any())
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 my-2" role="alert">
                            <p>
                                <b>{{ count($errors) }}件のエラーがあります。</b>
                            </p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('threads.store') }}" method="POST" enctype="multipart/form-data"
                        class="rounded pt-3 pb-8 mb-4">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm mb-2" for="title">
                            </label>
                            <input type="text" name="title"
                                class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full py-2 px-3"
                                required placeholder="タイトル" value="{{ old('title') }}">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm mb-2" for="url">
                            </label>
                            <input type="url" name="url"
                                class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full py-2 px-3"
                                required placeholder="URL" value="{{ old('url') }}">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm mb-2" for="body">
                                本文
                            </label>
                            <textarea name="body" rows="10"
                                class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full py-2 px-3"
                                required>{{ old('body') }}</textarea>

                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm mb-2" for="image">
                                画像貼り付け
                            </label>
                            <input type="file" name="image" class="border-gray-300">
                        </div>
                        <input type="submit" value="投稿"
                            class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
