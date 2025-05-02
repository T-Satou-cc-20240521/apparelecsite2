<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ここに注文一覧を取得するロジックを追加
        return view('admin.order.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // ここで注文詳細を取得するロジックを追加
        return view('admin.order.show', compact('id'));
    }

    /**
     * Update the status of the specified order.
     */
    public function updateStatus(Request $request, string $id)
    {
        // 注文ステータスを更新する処理を追加
        // 例: Order::find($id)->update(['status' => $request->status]);

        return redirect()->route('admin.order.index');
    }

    /**
     * Show the form for editing the shipment details of the specified order.
     */
    public function editShipment(string $id)
    {
        // ここで発送情報を編集するフォームを返すロジックを追加
        return view('admin.order.edit_shipment', compact('id'));
    }

    /**
     * Update the shipment details of the specified order.
     */
    public function updateShipment(Request $request, string $id)
    {
        // 発送情報を更新する処理を追加
        // 例: Order::find($id)->update(['shipment_status' => $request->shipment_status]);

        return redirect()->route('admin.order.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // 注文を削除するロジックを追加
        // 例: Order::find($id)->delete();

        return redirect()->route('admin.order.index');
    }
}
