<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ThreadRequest;
use App\Models\Thread;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $threads = Thread::with('user')->latest()->paginate(5);
        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.creat');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ThreadRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ThreadRequest $request)
    {
        $post = new Thread($request->all());
        $post->user_id = $request->user()->id;

        if ($file = $request->file('image')) {
            $post->image = self::createFileName($file);

            // トランザクション開始
            DB::beginTransaction();
            try {
                // 登録
                $post->save();

                // 画像アップロード
                if (!Storage::putFileAs('images/posts', $file, $post->image)) {
                    // 例外を投げてロールバックさせる
                    throw new \Exception('画像ファイルの保存に失敗しました。');
                }

                // トランザクション終了(成功)
                DB::commit();
            } catch (\Exception $e) {
                // トランザクション終了(失敗)
                DB::rollback();
                return back()->withInput()->withErrors($e->getMessage());
            }
        }
        $post->save();
        return redirect()
            ->route('threads.index', $post)
            ->with('notice', '掲示板を作成しました。');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $thread = Thread::with(['user'])->find($id);
        $messages = $thread->messages()->latest()->get()->load(['user']);
        // $check = $thread->checks()->latest()->get()->load(['user']);
// ,'check'
        return view('threads.show', compact('thread', 'messages'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $thread = Thread::find($id);

        return view('threads.edit', compact('thread'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ThreadRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ThreadRequest $request, $id)
    {
        $post = Thread::find($id);

        if ($request->user()->cannot('update', $post)) {
            return redirect()->route('threads.show', $post)
                ->withErrors('自分の掲示板以外は更新できません');
        }

        $file = $request->file('image');
        if ($file) {
            $delete_file_path = $post->image_path;
            $post->image = self::createFileName($file);
        }
        $post->fill($request->all());

        // トランザクション開始
        DB::beginTransaction();
        try {
            // 更新
            $post->save();

            if ($file) {
                // 画像アップロード
                if (!Storage::putFileAs('images/posts', $file, $post->image)) {
                    // 例外を投げてロールバックさせる
                    throw new \Exception('画像ファイルの保存に失敗しました。');
                }

                // 画像削除
                if (!Storage::delete($delete_file_path)) {
                    //アップロードした画像を削除する
                    Storage::delete($post->image_path);
                    //例外を投げてロールバックさせる
                    throw new \Exception('画像ファイルの削除に失敗しました。');
                }
            }

            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }

        return redirect()->route('threads.index', $post)
            ->with('notice', '記事を更新しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $thread = Thread::find($id);
        // トランザクション開始
        DB::beginTransaction();
        try {
            $thread->delete();
            if (!empty($thread->image)) {
                // 画像削除
                if (!Storage::delete($thread->image_path)) {
                    // 例外を投げてロールバックさせる
                    throw new \Exception('画像ファイルの削除に失敗しました。');
                }
            }
            // トランザクション終了(成功)
            DB::commit();
            return redirect()->route('threads.index')
                ->with('notice', '記事を削除しました');
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }
    }
    private static function createFileName($file)
    {
        return date('YmdHis') . '_' . $file->getClientOriginalName();
    }
}
