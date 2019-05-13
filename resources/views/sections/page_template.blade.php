@if(is_file(resource_path('/views/dynamic_pages/'.$page->uri.'.blade.php')))
    @include('dynamic_pages.'.$page->uri, [
        'page' => $page
    ])
@endif