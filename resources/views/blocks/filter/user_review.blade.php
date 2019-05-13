@php
    $min = $category->filter_cfg && isset($category->filter_cfg['user_review']) ? $category->filter_cfg['user_review']['min'] : 1;
    $max = $category->filter_cfg && isset($category->filter_cfg['user_review']) ? $category->filter_cfg['user_review']['max'] : 4;
    if(!$min) $min=1;
@endphp
@if($max)
<div class="filter__item">
    <div class="filter__item-title">User Review</div>
    @for($iteration=$min; $iteration <= $max; $iteration++)
        <div class="checkbox-container">
            <input type="checkbox" name="rating" {{request()->rating==$iteration ? 'checked':''}} value="{{$iteration}}" class="_input" id="{{$iteration}}" onchange="$(this).parents('.filter__item').find('[type=checkbox][id!={{$iteration}}]').removeAttr('checked');">
            <label for="{{$iteration}}" class="_label">
                <div class="rating-star ">
                    @for($stars=1; $stars <= 5; $stars++)
                        <i @if($stars <= $iteration) class="fill" @endif ></i>
                    @endfor
                </div>
                <span>and more</span></label>
        </div>
    @endfor
</div>
@endif