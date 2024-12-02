<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Models\EmailLog;
use Illuminate\Support\Facades\Mail;
use App\Mail\PostNotification;

class SendEmails extends Command
{
    protected $signature = 'send:emails';
    protected $description = 'Send emails to subscribers for new posts';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $posts = Post::where('is_sent', false)->with('website.subscribers')->get();

        foreach ($posts as $post) {
            foreach ($post->website->subscribers as $subscriber) {
                Mail::to($subscriber->email)->queue(new PostNotification($post));

                EmailLog::create(['post_id' => $post->id, 'user_id' => $subscriber->id]);
            }

            $post->update(['is_sent' => true]);
        }
    }
}

