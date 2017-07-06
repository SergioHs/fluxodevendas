@if(Session::has('error'))
    <div class="grid-x grid-padding-x grid-padding-y">
        <div class="medium-12 cell">
            <div class="alert callout">
                {{Session::get('error')}}
            </div>
        </div>
    </div>
@endif
@if(Session::has('success'))
    <div class="grid-x grid-padding-x grid-padding-y">
        <div class="medium-12 cell">
            <div class="success callout">
                {{Session::get('success')}}
            </div>
        </div>
    </div>
@endif