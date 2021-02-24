<?php

namespace App\Http\Controllers;

use App\Eloquent\Tag;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Eloquent\Post;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Class PostController
 * @package App\Http\Controllers
 */
class PostController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return JsonResponse
	 */
	public function index()
	{
		$user = Auth::user();
		if (!$user->can('get', Post::class)) {
			return response()->json([
				'data' => false,
				'message' => 'Forbidden',
				'code' => 403
			], 403);
		}

		try {
			$items = Post::ignoreRequest(['perpage'])
				->filter()
				->orderByDesc('id');

			$items = $items->paginate(request()->get('perpage'), ['*'], 'page');
			$posts = collect(PostResource::collection($items));

			$items = collect($items);
			$items->put('data', $posts);
			$items->put('message', 'Success');
			$items->put('code', 200);

			$items->forget('first_page_url');
			$items->forget('last_page_url');
			$items->forget('next_page_url');
			$items->forget('prev_page_url');
			$items->forget('path');

			return response()->json($items, 200);
		} catch (Exception $e) {
			return response()->json([
				'data' => $e,
				'message' => 'Error',
				'code' => 500
			], 500);
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param PostRequest $request
	 * @return JsonResponse
	 */
	public function store(PostRequest $request)
	{
		try {
			$user = Auth::user();
			if (!$user->can('create', Post::class)) {
				return response()->json([
					'data' => false,
					'message' => 'Forbidden',
					'code' => 403
				], 403);
			}

			$item = new Post();
			$item->title = $request->title;
			$item->description = $request->description;
			$item->user_id = $user->id;
			$item->save();

			Tag::checkTags($request->tags, $item->id);
			$result = collect();
			$result->put('data', PostResource::make($item));
			$result->put('message', 'Success');
			$result->put('code', 200);

			return response()->json($result, 200);
		} catch (Exception $e) {
			return response()->json([
				'data' => $e,
				'message' => 'Error',
				'code' => 500
			], 500);
		}
	}
}
