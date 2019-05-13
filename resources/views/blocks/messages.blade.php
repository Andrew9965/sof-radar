@if (count($errors) > 0)
    <div class="popup" id="system-message">
        <div class="popup-inner">4
            <a href="#" class="popup-close js-close-wnd"></a>
            <div class="popup__title">
                <div class="_text">Error</div>
                <div class="border-block">
                    <ul class="mark-list">
                        @foreach ($errors->all() as $error)
                            <li class="_error">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script>Popups.openById('system-message');</script>
@endif
@if (session('status'))
    <div class="popup" id="system-message">
        <div class="popup-inner">
            <div class="popup__title">
                <div class="_text">{{session('status')=='success' ? 'Success' : 'Error'}}</div>
                <div class="border-block">
                    <ul class="mark-list">
                        @if(is_array(session('message')))
                            @foreach (session('message') as $mess)
                                <li {{session('status')=='success' ? '' : 'class="_error"'}}>{{ $mess }}</li>
                            @endforeach
                        @else
                            <li {{session('status')=='success' ? '' : 'class="_error"'}}>{{session('message')}}</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script>Popups.openById('system-message');</script>
@endif