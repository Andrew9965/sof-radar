@php
    $needle = $category->filter_cfg && isset($category->filter_cfg['mobile_version']) ?
        $category->filter_cfg['mobile_version'] :
        ["Android", "IOS", "Windows phone", "Web-browser"];
@endphp
<div class="filter__item">
    <div class="filter__item-title">Mobile version</div>
    @foreach($needle as $need)
    <div class="checkbox-container">
        <input type="checkbox" class="_input" name="mobile_version[]" {{is_array(request()->mobile_version) && array_search($need,request()->mobile_version)!==false ? 'checked':''}} value="{{$need}}" id="{{$loop->iteration+50}}">
        <label for="{{$loop->iteration+50}}" class="_label">{{$need}}</label>
    </div>
    @endforeach
</div>