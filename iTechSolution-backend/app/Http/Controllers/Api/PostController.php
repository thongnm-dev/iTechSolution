<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $pageSize = (int) $request->integer('pageSize', 6);

        $query = Post::query()
            ->published()
            ->with(['category', 'author', 'tags'])
            ->latest('published_at');

        if ($category = $request->string('category')->toString()) {
            $query->whereRelation('category', 'slug', $category);
        }

        if ($search = $request->string('search')->toString()) {
            $query->where('title', 'like', "%{$search}%");
        }

        $paginator = $query->paginate($pageSize)->withQueryString();

        return [
            'data' => PostResource::collection($paginator->items()),
            'total' => $paginator->total(),
            'page' => $paginator->currentPage(),
            'pageSize' => $paginator->perPage(),
        ];
    }

    public function show(string $slug)
    {
        $post = Post::query()
            ->published()
            ->with(['category', 'author', 'tags'])
            ->where('slug', $slug)
            ->firstOrFail();

        return new PostResource($post);
    }

    public function related(string $slug)
    {
        $post = Post::query()->where('slug', $slug)->firstOrFail();

        $related = Post::query()
            ->published()
            ->with(['category', 'author', 'tags'])
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        return PostResource::collection($related);
    }
}
