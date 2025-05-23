@component('components.modal', [
    'id' => 'viewCloseStatus'.$car->dept_id,
    'size' => 'modal-lg',
    'title' => 'View CAR',
    'is_view' => true
    // 'url' => url('store_car')
])
    <div class="row">
        <div class="col-md-12">
            @foreach ($car->closed_cars as $open_car)
                {{-- @dd($open_car) --}}
                <dl class="dl-horizontal">
                    <dt>CAR No. :</dt>
                    <dd>CAR-{{ str_pad($open_car->id,3,'0',STR_PAD_LEFT) }}</dd>
                    <dt>Status :</dt>
                    <dd>{{ $open_car->status }}</dd>
                    <dt>Corrective Action :</dt>
                    <dd>
                        @foreach ($open_car->correctiveAction as $correctiveAction)
                            {{ $correctiveAction->corrective_action }} - {{ $correctiveAction->status }} <br>
                        @endforeach
                    </dd>
                    <hr>
                </dl>
            @endforeach
        </div>
    </div>
@endcomponent