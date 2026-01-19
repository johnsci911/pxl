<x-layout title="PXL - Feed">
  <!-- Navigation -->
  @include('partials.navigation', ['showPostButton' => false])

  <!-- Content -->
  <main class="flex grow flex-col gap-4 overflow-y-auto px-4 -mp-4 py-4">
    <div class="h-full">
      <nav class="overflow-x-auto [scrollbar-width:none]">
        <ul class="min-w-max flex justify-end gap-8 text-sm">
          <li><a href="#">For you</a></li>
          <li>
            <a class="text-pxl-light/60 hover:text-pxl-light/80" href="#">Idea streams</a>
          </li>
          <li>
            <a class="text-pxl-light/60 hover:text-pxl-light/80" href="#">Following</a>
          </li>
        </ul>
      </nav>
    </div>

    <!-- Post prompt -->
    <div class="border-pxl-light/10 mt-8 flex items-start gap-4 border-b pb-4">
      <a href="{{ route('profiles.show', $profile) }}" class="shrink-0">
        <img src="{{ $profile->avatar_url }}" alt="Avatar for {{ $profile->display_name }}" class="size-10 object-cover" />
      </a>
      <!-- Form -->
      <x-post-form
        :label-text="'Post body'"
        :field-name="'content'"
        :placeholder="'What\'s up ' . $profile->handle . '?'"
        :action="route('posts.store')"
      />
    </div>

    <!-- Feed -->
    <ol class="mt-4">
      <!-- Feed item -->
      @foreach ($posts as $item)
        <x-post
          :post="$item"
          :show-engagement="true"
        />
      @endforeach
    </ol>

    <!-- Foooter -->
    <footer class="mt-30 ml-14">
      <p class="text-center">That's all, folks!</p>
      <hr class="border-pxl-light/10 my-4">

      <!-- White noise -->
      <div class="bg-[url(/resources/images/white-noise.gif)] h-20"></div>
    </footer>
  </main>

  <!-- Sidebar -->
  @include('partials.aside')
</x-layout>
