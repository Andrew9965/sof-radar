<script>
    window.user = {!! json_encode(collect($user)->toArray()) !!};
</script>
<div id="admin_stat">
    <click-through-statistics><img src="/spinner.gif" style="margin: 0 auto; display: flex;"/></click-through-statistics>
</div>
<script>
    if(window.interval) clearInterval(window.interval)
    window.interval = setInterval(function () {
        if($('click-through-statistics')[0]) window.app_init()
    }, 1000)
</script>
{!! include_vue_scripts('app2') !!}