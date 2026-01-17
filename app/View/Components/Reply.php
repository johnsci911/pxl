<?php

namespace App\View\Components;

use App\Models\Post;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Reply extends Component
{
    public Post $post;
    public bool $showEngagement = true;
    public bool $showReplies = false;

    /**
     * Create a new component instance.
     */
    public function __construct(Post $post, bool $showEngagement = true, bool $showReplies = false)
    {
        $this->post = $post;
        $this->showEngagement = $showEngagement;
        $this->showReplies = $showReplies;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.reply');
    }
}
