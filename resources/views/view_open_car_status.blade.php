@component('components.modal', [
    'id' => 'viewStatus'.$car->dept_id,
    'size' => 'modal-lg',
    'title' => $category == 'all'
        ? 'View Open CAR / OFI'
        : ($category == 'car' ? 'View Open CAR' : 'View Open OFI'),
    'is_view' => true
    // 'url' => url('store_car')
])
    <div class="row">
        <div class="col-md-12">
            @if($category == 'all' || $category == 'car')
                @foreach ($car->open_cars as $open_car)
                    <dl class="dl-horizontal">
                        <dt>CAR No. :</dt>
                        <dd>
                            @if (!empty($open_car->car_no))
                                {{ $open_car->car_no }}
                            @else
                                CAR-{{ str_pad($open_car->id, 3, '0', STR_PAD_LEFT) }}
                            @endif
                        </dd>

                        <dt>Status :</dt>
                        <dd>{{ $open_car->status }}</dd>

                        <dt>Corrective Action :</dt>
                        <dd>
                            @foreach ($open_car->correctiveAction as $correctiveAction)
                                {{ $correctiveAction->corrective_action }}
                                - {{ $correctiveAction->status }} <br>
                            @endforeach
                        </dd>
                    </dl>
                    <hr>
                @endforeach
            @endif

            {{-- OFI --}}
            @if($category == 'all' || $category == 'ofi')
                @foreach ($car->open_ofis as $open_ofi)
                    <dl class="dl-horizontal">
                        <dt>OFI No. :</dt>
                        <dd>{{ $open_ofi->ofi_no }}</dd>

                        <dt>Status :</dt>
                        <dd>{{ $open_ofi->status }}</dd>

                        <dt>Implementation Action :</dt>
                        <dd>
                            @foreach ($open_ofi->ofiImmediateAction as $action)
                                @if(!empty($action->implementation_date))
                                    {{ $action->immediate_action }}
                                    - {{ $action->status }} <br>
                                @endif
                            @endforeach
                        </dd>
                    </dl>
                    <hr>
                @endforeach
            @endif
        </div>
    </div>
@endcomponent