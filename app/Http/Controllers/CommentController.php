<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\News;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Store 1 Comment
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\News $news
     * @return \App\Http\Resources\CommentResource
     */
    public function store(Request $request, News $news): CommentResource
    {
        $user = $request->user();

        $request->request->add(['author_name' => $user->name]);

        $validator = Validator::make(
            $request->all(), 
            [
                'content' => 'string|min:1|max:5000|',
                'author_name' => 'exists:users,name'
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'errors' => $validator->errors()
                ],
                422
            );
        }

        $comment = $news->comments()->create(
            $request->all()
        );
        
        return $this->show($comment);
    }
        
    /**
     * Show 1 specific resource
     * @param  \App\Models\Comment $comment
     * @return \App\Http\Resources\CommentResource
     */
    public function show(Comment $comment): CommentResource
    {
        return CommentResource::make($comment);
    }

    /**
     * Update 1 Comment
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Comment $comment
     * @return JsonResponse|NewsResource
     */
    public function update(Request $request, Comment $comment)
    {   
        $validator = Validator::make(
            $request->all(), 
            [
                'content' => 'string|min:1|max:5000|'
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'errors' => $validator->errors()
                ],
                422
            );
        }

        $comment->update(
            $request->all()
        );

        return $this->show($comment);
    }

    /**
     * Delete Comment
     * @param  \App\Models\Comment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Comment $comment): JsonResponse
    {
        if ($comment->delete()) {
            return response()->json([
                'status' => 'info',
                'message' => 'Comment id - ' . $comment->id . ' deleted'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'errors' => 'Some error(s) when tried delete Comment'
        ]);
    }
}
