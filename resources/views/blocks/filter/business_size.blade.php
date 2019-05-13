@php
    $needle = $category->filter_cfg && isset($category->filter_cfg['business_size']) ? $category->filter_cfg['business_size'] : ["Medium", "Enterprise", "Small"];
@endphp
<div class="filter__item">
    <div class="filter__item-title">Business size</div>
    @foreach($needle as $need)
    <div class="checkbox-container">
        <input type="checkbox" name="business[]" {{is_array(request()->business) && array_search($need,request()->business)!==false ? 'checked':''}} value="{{$need}}" class="_input" id="{{$loop->iteration+5}}">
        <label for="{{$loop->iteration+5}}" class="_label">{{$need}}</label>
    </div>
    @endforeach
</div>