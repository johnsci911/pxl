<?php

namespace App\View\Components;

use Closure;
use App\Models\Post as PostModel;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Post extends Component
{
    public PostModel $post;
    public PostModel $original; // Everything else is unused now
    public bool $showEngagement = true;
    public bool $showReplies = false;

    /**
     * Create a new component instance.
     */
    public function __construct(PostModel $post, bool $showEngagement = true, bool $showReplies = false)
    {
        // Others are unused now except for the original $post
        $this->original = $post;
        $this->post = $post->isRepost() && $post->content == null ? $post->repostOf : $post;

        $this->showEngagement = $showEngagement;
        $this->showReplies = $showReplies;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.post');
    }
}
