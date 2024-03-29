<?php

namespace App\Http\Controllers;

use App\Events\NewComment;
use App\Models\Comment;
use App\Models\Publication;
use App\Models\User;
use App\States\Comment\Approved;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function store(Request $request, Publication $publication): RedirectResponse
    {
        $request->validate([
            'content' => 'required|min:15|max:255',
        ]);

        /** @var User $authUser */
        $authUser = $request->user();

        /** @var Comment $comment */
        $comment = $authUser->comments()->create($request->all() + [
            'publication_id' => $publication->getKey(),
        ]);

        // If the user is the author, the email is not sent and the comment is approved
        if ($publication->user()->is($authUser)) {
            $comment->state->transitionTo(Approved::class);

            return back()->with('message', 'Your comment was created successfully.');
        }

        event(new NewComment($authUser, $comment));

        return back()->with('message', 'Your comment was created successfully, wait for a approbation by the owner.');
    }
}
