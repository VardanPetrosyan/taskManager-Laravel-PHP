<?php
namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TablEditController
{
    public function edittable(Request $request)
    {
        switch ($request->action) {
            case 'edit':
                $request->validate([
                    'title' => 'required|max:12',
                ]);
                $editcat = Category::find($request->id);
                $editcat->name = $request->title;
                $editcat->parent = $request->parent;
                $editcat->status = $request->status;

                $editcat->save();
                $response = ['action' => $request->action, 'id' => $request->id];
                return json_encode($response);
                break;
            case 'delete':
                $category = Category::find($request->id);
                $category->status = 'passive';
                $category->save();

                $response = ['action' => $request->action, 'id' => $request->id];
                echo json_encode($response);
                die;
                break;
        }

    }
}