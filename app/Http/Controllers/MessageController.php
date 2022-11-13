<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MessageRequest;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Thread $thread)
    {
        return view('messages.create', compact('thread'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\MessageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MessageRequest $request, Thread $thread)
    {
        $message = new Message($request->all());
        $message->user_id = $request->user()->id;
        try {
            // 登録
            $thread->messages()->save($message);
        } catch (\Exception $e) {
            return back()->withInput()->withErrors($e->getMessage());
        }

        return redirect()
            ->route('threads.show', $thread)
            ->with('notice', 'コメントを登録しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread, Message $message)
    {
        return view('messages.edit', compact('thread', 'message'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread, Message $message)
    {
        if ($request->user()->cannot('update', $message)) {
            return redirect()->route('threads.show', $thread)
                ->withErrors('自分のコメント以外は更新できません');
        }

        $message->fill($request->all());

        try {
            // 更新
            $message->save();

            return redirect()->route('threads.show', $thread)
                ->with('notice', 'コメントを更新しました');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread, Message $message)
    {
        try {
            $message->delete();

            return redirect()->route('threads.show', $thread)
                ->with('notice', 'コメントを削除しました');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
