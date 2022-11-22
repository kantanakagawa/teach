<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Check;
use App\Http\Requests\CheckRequest;

class CheckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checks = Check::all();
        return $checks;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CheckRequest $request)
    {
        // インスタンスの作成
        $check = new check();

        // 値の用意
        $check->check = $request->check;
        $check->user_id = $request->user_id;
        $check->thread_id = $request->thread_id;
        $check->save();
        // インスタンスに値を設定して保存
        $check->save();

        // 登録後のデータを返す(idが追加される)
        return $check;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $check = Check::find($id);
        return $check;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CheckRequest $request, $id)
    {
        $check = Check::find($id);
        $check->check = $request->check;
        $check->user_id = $request->user_id;
        $check->thread_id = $request->thread_id;
        $check->save();

        return $check;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check = Check::find($id);
        $check->delete();
    }
}
