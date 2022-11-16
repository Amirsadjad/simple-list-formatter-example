<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Users</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body style="margin-top: 3%">

<div class="overflow-x-auto relative shadow-md sm:rounded-lg">
    <div class="pb-4 bg-white dark:bg-gray-900" style="padding-top: 20px; padding-left: 20px">
        <label for="table-search" class="sr-only">Search</label>
        <div class="relative mt-1" x-data>
            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
            </div>
            <form id="search_form">
                @foreach($_REQUEST as $name => $value)
                    @if ($name != 'query')
                        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                    @endif
                @endforeach
                <input @keydown.enter="document.getElementById('search_form').submit()" type="text" id="table-search" name="query" value="{{ $_REQUEST['query'] ?? '' }}" class="block p-2 pl-10 w-80 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search">
            </form>
        </div>
    </div>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" style="padding-left: 10px; padding-right: 10px">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            @foreach($columns as $column)
                <th scope="col" class="py-3 px-6">
                    <div class="@if($loop->first) flex items-center @endif">
                        {{ $preset['columns'][$column]['title'] ?? $column }}
                        @if($preset['columns'][$column]['is_sortable'])
                            <form>
                                @foreach($_REQUEST as $name => $value)
                                    @if (! in_array($name, ['sort', 'desc']))
                                        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                                    @endif
                                @endforeach
                                <input name="sort" type="hidden" value="{{ $column }}">
                                <input name="desc" type="hidden" value="{{ (isset($_REQUEST['sort'], $_REQUEST['desc']) && $_REQUEST['sort'] === $column && ! $_REQUEST['desc']) ? 1 : 0}}">
                                <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" class="ml-1 w-3 h-3" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></button>
                            </form>
                        @endif
                    </div>
                </th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($data as $datum)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                @foreach($columns as $column)
                    @if($loop->first)
                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $datum[$column] }}
                        </th>
                    @else
                        <td class="py-4 px-6">
                            {{ $datum[$column] }}
                        </td>
                    @endif
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
    <nav class="flex justify-between items-center pt-4 dark:bg-gray-900" aria-label="Table navigation" style="padding: 20px 10px;">
        <span class="text-sm font-normal text-gray-500 dark:text-gray-400"></span>
        <ul class="inline-flex items-center -space-x-px">
            @for($i=1; $i<= $page_count; $i++)
                <form>
                    @foreach($_REQUEST as $name => $value)
                        @if ($name != 'page')
                            <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    <input type="hidden" value="{{ $i }}" name="page">
                    @if($i == $page_number)
                        <li>
                            <button type="submit" aria-current="page" class="z-10 py-2 px-3 leading-tight text-blue-600 bg-blue-50 border border-blue-300 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">{{ $i }}</button>
                        </li>
                    @else
                        <li>
                            <button type="submit" class="py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{ $i }}</button>
                        </li>
                    @endif
                </form>
            @endfor
        </ul>
    </nav>
</div>

</body>
</html>
