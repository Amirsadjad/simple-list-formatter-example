<?php

use Amirsadjad\SimpleListFormatter\Facades\SimpleList;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
//    User::factory()->count(40)->create();
    $data = User::all();
    $preset = [
        'columns' => [
            'name' => [
                'data_type' => 'string',
                'is_sortable' => true,
                'is_searchable' => true,
                'width' => 70,
                'title' => 'Name',
                'metadata' => []
            ],
            'email' => [
                'data_type' => 'email',
                'is_sortable' => false,
                'is_searchable' => true,
                'width' => 100,
                'title' => 'Email',
                'metadata' => []
            ],
            'city' => [
                'data_type' => 'string',
                'is_sortable' => true,
                'is_searchable' => true,
                'width' => 100,
                'title' => 'City',
                'metadata' => []
            ],
            'age' => [
                'data_type' => 'int',
                'is_sortable' => false,
                'is_searchable' => true,
                'width' => 40,
                'title' => 'Age',
                'metadata' => []
            ],
        ],
        'page_size' => 8
    ];
    $list = SimpleList::Of($data, $preset);

    if (request()->has('query') && request('query')) $list->search(request('query'));
    if (request()->has('sort')) $list->sortBy(request('sort'), request('desc') ?? false);
    if (request()->has('page')) $list->pageNumber(request('page'));

    return view('users.index', $list->generate());
});
