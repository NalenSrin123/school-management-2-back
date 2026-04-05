<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    // GET /banners
    public function index()
    {
        return response()->json(Banner::all());
    }

    // POST /banners
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image'     => 'required|string',
            'title'     => 'required|string',
            'link_url'  => 'required|string',
            'is_active' => 'required|boolean',
        ]);

        $banner = Banner::create($validated);
        return response()->json($banner, 201);
    }

    // GET /banners/{id}
    public function show($id)
    {
        return response()->json(Banner::findOrFail($id));
    }

    // PUT /banners/{id}
    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $validated = $request->validate([
            'image'     => 'sometimes|string',
            'title'     => 'sometimes|string',
            'link_url'  => 'sometimes|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $banner->update($validated);
        return response()->json($banner);
    }

    // DELETE /banners/{id}
    public function destroy($id)
    {
        Banner::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully!']);
    }
}
