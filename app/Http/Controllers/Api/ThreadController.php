<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ThreadRequest;
use App\Models\Thread;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $threads = Thread::all();
        return $threads;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ThreadRequest $request)
    {
        // インスタンスの作成
        $thread = new Thread();

        // 値の用意
        $thread->title = $request->title;
        $thread->body = $request->body;
        $thread->url = $request->url;
        $thread->image = $request->image;
        $thread->user_id = $request->user_id;

        // インスタンスに値を設定して保存
        $thread->save();

        // 登録後のデータを返す(idが追加される)
        return $thread;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $thread = Thread::find($id);
        return $thread;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ThreadRequest $request, $id)
    {
        $thread = Thread::find($id);
        $thread->title = $request->title;
        $thread->body = $request->body;
        $thread->url = $request->url;
        $thread->image = $request->image;
        $thread->user_id = $request->user_id;
        $thread->save();

        return $thread;
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
        $thread->delete();
    }
}
