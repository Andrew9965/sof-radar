<div class="filter__item">
    <div class="filter__item-title">Price</div>
    @if(!$category->filter_cfg || isset($category->filter_cfg['price']) && isset($category->filter_cfg['price']['free_trial']))
    <div class="checkbox-container">
        <input type="checkbox" class="_input" id="120" name="pricing_free_trial_active" value="yes" {{request()->pricing_free_trial_active ? 'checked':''}}>
        <label for="120" class="_label">Free Trial</label>
    </div>
    @endif
    @php
        $needle_pm = isset($category->filter_cfg['price']) && isset($category->filter_cfg['price']['pricing_model']) ? $category->filter_cfg['price']['pricing_model'] :
            ['Freemium','Subscription','One-time license','Open-source'];
    @endphp

    @foreach($needle_pm as $pm)
    <div class="checkbox-container">
        <input type="checkbox" class="_input" id="{{$loop->iteration+60}}" name="pricing_pricing_model[]" value="{{$pm}}" {{is_array(request()->pricing_pricing_model) && array_search($pm,request()->pricing_pricing_model)!==false ? 'checked':''}}>
        <label for="{{$loop->iteration+60}}" class="_label">{{$pm}}</label>
    </div>
    @endforeach
</div>