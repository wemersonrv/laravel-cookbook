<?php

use App\Http\Requests\PostFormRequest;
use App\Models\Announcement;
use App\Models\Post;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/charts', function () {
    return view('charts');
});

Route::get('/stats', function () {
    return view('stats');
});

Route::get('/announcement', function () {
    $announcement = Announcement::first();

    abort_if(!$announcement?->is_active, 404);

    return view('announcement', [
      'announcement' => $announcement,
    ]);
});

Route::get('/announcement/edit', function () {
    $announcement = Announcement::first();

    return view('edit-announcement', [
      'announcement' => $announcement,
    ]);
});

Route::patch('/announcement/update', function (Request $request) {
    $fields = $request->validate([
      'is_active' => 'required',
      'banner_text' => 'required',
      'banner_color' => 'required',
      'title_text' => 'required',
      'title_color' => 'required',
      'content' => 'required',
      'button_text' => 'required',
      'button_color' => 'required',
      'button_link' => 'required|url',
      'image_upload' => 'file|image|max:20000',
      'image_upload_filepond' => 'string|nullable',
    ]);

    if($request->image_upload){
        $uploaded = $request->file('image_upload');
        $filename = 'images/' . $uploaded->hashName();
        $path = config('filesystems.disks.public.root') . '/' . $filename;

        Image::make($uploaded)
            ->resize(600,null, function($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->save($path);

        $fields = array_merge($fields, [ 'image_upload' => $filename ]);
    }

    if($request->image_upload_filepond) {
        $filename = 'images/' . Str::after($request->image_upload_filepond, 'temp/');
        Storage::disk('public')->move($request->image_upload_filepond, $filename);
        $fields = array_merge($fields, [ 'image_upload_filepond' => $filename ]);
    }

    $announcement = Announcement::first();
    $announcement->update($fields);

    return back()->with('success_message', 'Announcement was updated!');
});

Route::post('/upload', function (Request $request) {
    if($request->image_upload_filepond) {
        $path = $request->file('image_upload_filepond')->store('temp', 'public');
    }

    return $path;
});

Route::get('/posts', function () {
    return view('posts.index', [
      'posts' => Post::latest()->get(),
    ]);
});

Route::get('/posts/create', function () {
    return view('posts.create', [
      'post' => new Post(),
    ]);
});

Route::post('/posts/create', function (PostFormRequest $request) {
//    Post::create(fields($request));
    $request->updateOrCreate(new Post());

    return redirect('/posts')->with('success_message', 'Post was created!');
});

Route::get('/posts/{post}', function (Post $post) {
    return view('posts.show', [
      'post' => $post,
    ]);
});

Route::get('/posts/{post}/edit', function (Post $post) {
    return view('posts.edit', [
      'post' => $post,
    ]);
});


Route::patch('/posts/{post}', function (Post $post, PostFormRequest $request) {
//    $post->update(fields($request));
    $request->updateOrCreate($post);

    return redirect('/posts/'.$post->id)->with('success_message', 'Post was updated!');
});

Route::get('/drag-drop', function () {
    return view('drag-drop');
});

Route::get('/http-client', function () {
    // $responseGithub = Http::get('https://api.github.com/users/wemersonrv/repos?sort=created&per_page=10',);

    // TODO: Mudar para Aparecida do rio doce e RV
    // $responseWeather = Http::get('https://api.openweathermap.org/data/2.5/weather?q=Toronto&units=metric&appid='.config('services.openWeatherMap.appId'));

    // $responseMovies = Http::withToken(config('services.tmdb.bearerToken'))->get('https://api.themoviedb.org/3/movie/popular');
    // $responseMovies = Http::movies()->get('/movie/popular');

    $responses = Http::pool(function (Pool $pool) {
        return [
          $pool->as('github')->get('https://api.github.com/users/wemersonrv/repos?sort=created&per_page=10'),
          $pool->as('weather')->get('https://api.openweathermap.org/data/2.5/weather?q=Toronto&units=metric&appid='.config('services.openWeatherMap.appId')),
          $pool->as('movies')->withToken(config('services.tmdb.bearerToken'))->get('https://api.themoviedb.org/3/movie/popular'),
        ];
    });

    return view('http-client', [
//      'repos' => $responseGithub->ok() ? $responseGithub->json() : [],
//      'weather' => $responseWeather->ok() ? $responseWeather->json() : [],
//      'movies' => $responseMovies->json(),
        'repos' => $responses['github']->json(),
        'weather' => $responses['weather']->json(),
        'movies' => $responses['movies']->json(),
    ]);
});


function fields(Request $request)
{
    return [
      'user_id' => 1, // auth()->id()
      'title' => $request->title,
      'body' => $request->body,
    ];
}
