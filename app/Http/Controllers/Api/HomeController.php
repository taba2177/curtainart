<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Taba\Crm\Models\Post;
use Taba\Crm\Models\PostCategory;
use Taba\Crm\Models\ContactEntry;
use Taba\Crm\Models\CrmSetting;

class HomeController extends Controller
{
    public function index()
    {
        $allSections = PostCategory::whereNotNull('section_component')
            ->parentOnly()
            ->with(['posts' => function ($query) { $query->with('image');
                $query->where("show_in_home", true)->published()->orderBy('order', 'asc');
            }])
            ->orderBy('order', 'asc')
            ->get();

        return response()->json([
            'metaTitle' => config('crm.site_name', 'Home'),
            'sections' => $allSections
        ]);
    }

    public function navigation()
    {
        $categories = PostCategory::where('register_in_header', true)
            ->orderBy('order')
            ->get(['id', 'name', 'slug', 'order']);

        $settings = CrmSetting::pluck('value', 'key');

        return response()->json([
            'categories' => $categories,
            'settings' => $settings,
            'locale' => app()->getLocale(),
            'logo' => asset('/images/logo.svg'),
            'logoDark' => asset('/images/logo-dark.svg'),
        ]);
    }

    public function category($slug)
    {
        $category = PostCategory::where('slug', $slug)->firstOrFail();
        $posts = Post::published()
            ->with(['postCategory', 'image'])
            ->where('post_category_id', $category->id)
            ->orderBy('order')
            ->get();

        return response()->json([
            'category' => $category,
            'posts' => $posts,
        ]);
    }

    public function post($categorySlug, $postSlug)
    {
        $category = PostCategory::where('slug', $categorySlug)->firstOrFail();
        $post = Post::where('slug', $postSlug)
            ->where('post_category_id', $category->id)
            ->with(['postCategory', 'image'])
            ->firstOrFail();

        abort_unless($post->is_published || auth()->check(), 404);

        $relatedPosts = Post::published()
            ->where('post_category_id', $category->id)
            ->where('id', '!=', $post->id)
            ->with('image')
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'post' => $post,
            'category' => $category,
            'relatedPosts' => $relatedPosts,
        ]);
    }

    public function contact(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:250',
            'phone'   => 'required|string|max:30',
            'message' => 'required|string|max:5000',
        ]);

        ContactEntry::create([
            'name'    => $validated['name'],
            'phone'   => $validated['phone'],
            'message' => $validated['message'],
        ]);

        return response()->json(['success' => true]);
    }
}
