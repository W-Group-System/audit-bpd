<div class="modal" id="{{ $id }}">
    <div class="modal-dialog {{ $size }}">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
            </div>
            <form action="{{ isset($url) ? $url : '' }}" method="post" @if(isset($has_enctype)) enctype="multipart/form-data" @endif onsubmit="show()">
                @csrf
                
                <div class="modal-body">
                    {{ $slot }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    @if(!isset($is_view))
                    <button type="submit" class="btn btn-primary" @if(isset($is_disabled)) @if($is_disabled > 0) disabled @endif @endif>Save</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>