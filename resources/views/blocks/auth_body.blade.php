<a href="#" class="popup-close js-close-wnd"></a>
<div class="popup__form">
    <div class="popup__form-title">
        <div class="_title">Add review</div>
    </div>
    <div class="popup__container--small">
        <p style="width: 100%">
            Do you want to add product review? It's fine!<br>
            Log in with Facebook or Google account, and do it now!
        </p>
        <div class="popup__form-action w245">
            <a href="{{route('social.facebook', ['open_add_review' => 'true'])}}" class="btn btn-purple w100 btn-big facebook_auth">Facebook</a>
        </div>

        <div class="popup__form-action w245">
            <a href="{{route('social.google', ['open_add_review' => 'true'])}}" class="btn btn-purple w100 btn-big google_auth">Google</a>
        </div>

    </div>
</div>