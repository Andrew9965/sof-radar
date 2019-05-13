@php
    $needle = $category->filter_cfg && isset($category->filter_cfg['deployment']) ? $category->filter_cfg['deployment'] : ["SaaS", "InHouse"];
@endphp
<div class="filter__item">
    <div class="filter__item-title">Deployment</div>
    @foreach($needle as $need)
    <div class="checkbox-container">
        <input type="checkbox" class="_input" name="deployment[]" {{is_array(request()->deployment) && array_search($need,request()->deployment)!==false ? 'checked':''}} value="{{$need}}" id="{{$loop->iteration+450}}">
        <label for="{{$loop->iteration+450}}" class="_label">{{$need}} {{$need=='SaaS' ? '(Web-Based)' : '(Installed)'}}</label>
    </div>
    @endforeach
</div>