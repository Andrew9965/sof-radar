@php
    $needle = $category->filter_cfg && isset($category->filter_cfg['desktop_client']) ?
        $category->filter_cfg['desktop_client'] :
        ["Windows", "Linux", "Mac", "Web-browser"];
@endphp
<div class="filter__item">
    <div class="filter__item-title">Desktop client</div>
    @foreach($needle as $need)
    <div class="checkbox-container">
        <input type="checkbox" class="_input" name="desc_client[]" {{is_array(request()->desc_client) && array_search($need,request()->desc_client)!==false ? 'checked':''}} value="{{$need}}" id="{{$loop->iteration+210}}">
        <label for="{{$loop->iteration+210}}" class="_label">{{$need}}</label>
    </div>
    @endforeach
</div>