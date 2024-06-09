@props(['id'])
<div class="modal fade" id="{{$id}}" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{$body}}
            </div>
            @if(!empty($footer))
                <div class="modal-footer">
                    {{$footer}}
                </div>
            @endif
        </div>
    </div>
</div>
