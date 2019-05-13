@php
    $needle = $category->filter_cfg && isset($category->filter_cfg['features']) ?
        $category->categories_ff->whereIn('title', $category->filter_cfg['features']) : $category->categories_ff;
@endphp
<div class="filter__item">
    <div class="filter__item-title">Features</div>
    @foreach($category->categories_ff as $ff)
        <div class="checkbox-container">
            <input type="checkbox" class="_input" id="feature_{{$ff->id}}" {{is_array(request()->feature) && array_search($ff->title,request()->feature)!==false ? 'checked':''}} name="feature[]" value="{{$ff->title}}">
            <label for="feature_{{$ff->id}}" class="_label">{{$ff->title}}</label>
        </div>
    @endforeach
</div>