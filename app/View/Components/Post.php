<?php

namespace App\View\Components;

use Closure;
use App\Models\Post as PostModel;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Post extends Component
{
    public PostModel $post;
    public bool $showEngagement = false;
    public bool $showReplies = true;

    /**
     * Create a new component instance.
     */
    public function __construct(PostModel $post, bool $showEngagement = false, bool $showReplies = true)
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
        return view('components.post');
    }
}
