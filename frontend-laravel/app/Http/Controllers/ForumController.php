<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class ForumController extends \Illuminate\Routing\Controller
{
    private $commentUrl;
    private $userUrl;

    public function __construct() {
        $this->userUrl = env('USER_SERVICE_URL', 'http://user-service:3001');
        $this->commentUrl = env('COMMENT_SERVICE_URL', 'http://comment-service:3002');
    }

    public function index() {
        try {
            $response = Http::get($this->commentUrl . '/forum/comment');
            $comments = $response->json();
        } catch (\Exception $e) {
            $comments = [];
        }
        return view('forum', compact('comments'));
    }

    public function register(Request $request) {
        $response = Http::post($this->userUrl . '/auth/register', [
            'email' => $request->email,
            'password' => $request->password,
        ]);
        
        return $response->json();
    }

    public function postComment(Request $request) {
        Http::post($this->commentUrl . '/forum/comment', [
            'userId' => $request->userId,
            'content' => $request->content,
        ]);
        return redirect()->back()->with('success', 'Komentar berhasil dikirim!');
    }

    public function updateComment(Request $request, $id) {
        Http::patch($this->commentUrl . "/forum/comment/{$id}", [
            'content' => $request->content,
        ]);
        return redirect()->back()->with('success', 'Komentar berhasil diperbarui!');
    }

    public function deleteComment($id) {
        Http::delete($this->commentUrl . "/forum/comment/{$id}");
        return redirect()->back()->with('success', 'Komentar berhasil dihapus!');
    }
}