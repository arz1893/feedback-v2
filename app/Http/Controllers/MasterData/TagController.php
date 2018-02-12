<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Requests\MasterData\TagRequest;
use App\Http\Resources\TagCollection;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;

class TagController extends Controller
{
    public function index() {
        $tags = Tag::where('recOwner', Auth::user()->tenantId)->orderBy('name', 'asc')->get();
        return view('master_data.tag.tag_index', compact('tags'));
    }

    public function create() {
        return view('master_data.tag.tag_create');
    }

    public function store(TagRequest $request) {
        Tag::create([
            'systemId' => Uuid::generate(4),
            'name' => $request->name,
            'defValue' => $request->defValue,
            'bgColor' => $request->bgColor,
            'recOwner' => Auth::user()->tenantId,
            'syscreator' => Auth::user()->systemId
        ]);
        return redirect('tag')->with(['status' => 'A new tag has been added']);
    }

    public function edit(Tag $tag) {
        return view('master_data.tag.tag_edit', compact('tag'));
    }

    public function update(TagRequest $request, Tag $tag) {
        $tag->update($request->all());
        return redirect('tag')->with(['status' => 'Tag has been updated']);
    }

    public function deleteTag(Request $request) {
        $tag = Tag::findOrFail($request->tag_id);
        $tag->delete();
        return redirect('tag')->with(['status' => 'Tag has been deleted']);
    }

    public function getTagList($tenant_id) {
        $tags = Tag::where('recOwner', $tenant_id)->orderBy('name', 'asc')->get();
        return new TagCollection($tags);
    }
}
