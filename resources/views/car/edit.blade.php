@component('components.modal', [
    'id' => 'edit'.$car->id,
    'size' => 'modal-xl',
    'title' => 'Edit CAR',
    // 'is_view' => true
    'url' => url('update_car/'.$car->id),
    'has_enctype' => true
])
    <div class="row">
        <div class="col-md-12">
            Correction / Immediate Action :
            <textarea name="immediate_action" class="form-control input-sm" cols="30" rows="10" required>{{ $car->immediate_action }}</textarea>
        </div>
        <div class="col-md-6">
            Action Date :
            <input type="date" name="action_date_immediate_action" class="form-control input-sm" min="{{ date('Y-m-d') }}" value="{{ $car->action_date_immediate_action }}" required>
        </div>
        {{-- <div class="col-md-6">
            Verification :
            <select data-placeholder="Select verification" name="verification_correction" class="form-control input-sm cat">
                <option value=""></option>
                <option value="D" @if($car->verification_correction == 'D') selected @endif>Done</option>
                <option value="ND" @if($car->verification_correction == 'ND') selected @endif>Not Done</option>
                <option value="OG" @if($car->verification_correction == 'OG') selected @endif>On-going</option>
            </select>
        </div> --}}
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            Root Cause Analysis :
            {{-- <textarea name="root_cause_analysis" class="form-control" cols="30" rows="10" required></textarea> --}}
            {{-- <div class="row">
                <div class="col-md-3">1. Man</div>
                <div class="col-md-9">
                    <textarea name="man" id="" class="form-control" cols="30">{{ $car->man }}</textarea>
                </div>
                <div class="col-md-3">2. Method</div>
                <div class="col-md-9">
                    <textarea name="method" id="" class="form-control" cols="30">{{ $car->method }}</textarea>
                </div>
                <div class="col-md-3">3. Machine</div>
                <div class="col-md-9">
                    <textarea name="machine" id="" class="form-control" cols="30">{{ $car->machine }}</textarea>
                </div>
                <div class="col-md-3">4. Material</div>
                <div class="col-md-9">
                    <textarea name="material" id="" class="form-control" cols="30">{{ $car->material }}</textarea>
                </div>
                <div class="col-md-3">5. Mother Nature</div>
                <div class="col-md-9">
                    <textarea name="mother_nature" id="" class="form-control" cols="30">{{ $car->mother_nature }}</textarea>
                </div>
            </div> --}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Man</th>
                                    <th>Method</th>
                                    <th>Machine</th>
                                    <th>Material</th>
                                    <th>Mother Nature</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($car->rootCauseAnalysis->isNotEmpty())
                                    @foreach ($car->rootCauseAnalysis as $key=>$rootCauseAnalysis)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>
                                                <textarea name="man[]" class="form-control" cols="30">{{ $rootCauseAnalysis->man }}</textarea>
                                            </td>
                                            <td>
                                                <textarea name="method[]" class="form-control" cols="30">{{ $rootCauseAnalysis->method }}</textarea>
                                            </td>
                                            <td>
                                                <textarea name="machine[]" class="form-control" cols="30">{{ $rootCauseAnalysis->machine }}</textarea>
                                            </td>
                                            <td>
                                                <textarea name="material[]" class="form-control" cols="30">{{ $rootCauseAnalysis->material }}</textarea>
                                            </td>
                                            <td>
                                                <textarea name="mother_nature[]" class="form-control" cols="30">{{ $rootCauseAnalysis->mother_nature }}</textarea>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>1. </td>
                                        <td>
                                            <textarea name="man[]" class="form-control" cols="30"></textarea>
                                        </td>
                                        <td>
                                            <textarea name="method[]" class="form-control" cols="30"></textarea>
                                        </td>
                                        <td>
                                            <textarea name="machine[]" class="form-control" cols="30"></textarea>
                                        </td>
                                        <td>
                                            <textarea name="material[]" class="form-control" cols="30"></textarea>
                                        </td>
                                        <td>
                                            <textarea name="mother_nature[]" class="form-control" cols="30"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2. </td>
                                        <td>
                                            <textarea name="man[]" class="form-control" cols="30"></textarea>
                                        </td>
                                        <td>
                                            <textarea name="method[]" class="form-control" cols="30"></textarea>
                                        </td>
                                        <td>
                                            <textarea name="machine[]" class="form-control" cols="30"></textarea>
                                        </td>
                                        <td>
                                            <textarea name="material[]" class="form-control" cols="30"></textarea>
                                        </td>
                                        <td>
                                            <textarea name="mother_nature[]" class="form-control" cols="30"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3. </td>
                                        <td>
                                            <textarea name="man[]" class="form-control" cols="30"></textarea>
                                        </td>
                                        <td>
                                            <textarea name="method[]" class="form-control" cols="30"></textarea>
                                        </td>
                                        <td>
                                            <textarea name="machine[]" class="form-control" cols="30"></textarea>
                                        </td>
                                        <td>
                                            <textarea name="material[]" class="form-control" cols="30"></textarea>
                                        </td>
                                        <td>
                                            <textarea name="mother_nature[]" class="form-control" cols="30"></textarea>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-6">
            Action Date :
            <input type="date" name="action_date_root_cause" class="form-control input-sm" required>
        </div> --}}
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            Corrective Action : 
            <button type="button" class="btn btn-xs btn-primary" onclick="addRowBtn({{ $car->id }})"><i class="fa fa-plus"></i></button>
            <button type="button" class="btn btn-xs btn-danger" onclick="removeRowBtn({{ $car->id }})"><i class="fa fa-minus"></i></button>

            @if($car->correctiveAction->isNotEmpty())
                <div id="correctiveActionContainer{{ $car->id }}">
                    @foreach ($car->correctiveAction as $key=>$ca)
                    <div class="row" id="caNum_{{ $key+1 }}">
                        <div class="col-md-1">
                            {{ $key+1 }}
                        </div>
                        <div class="col-md-6">
                            <textarea name="corrective_action[]" class="form-control" cols="30" required>{{ $ca->corrective_action }}</textarea>
                        </div>
                        <div class="col-md-5">
                            <input type="date" name="action_date[]" class="form-control input-sm" min="{{ date('Y-m-d') }}" value="{{ $ca->action_date }}" required>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
            <div id="correctiveActionContainer{{ $car->id }}">
                <div class="row" id="caNum_1">
                    <div class="col-md-1">
                        1
                    </div>
                    <div class="col-md-6">
                        <textarea name="corrective_action[]" class="form-control" cols="30" required></textarea>
                    </div>
                    <div class="col-md-5">
                        <input type="date" name="action_date[]" class="form-control input-sm" min="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
            </div>
            @endif
        </div>
        {{-- <div class="col-md-6">
            Action Date :
            <input type="date" name="action_date_corrective_action" class="form-control input-sm" required>
        </div>
        <div class="col-md-6">
            Verification :
            <select data-placeholder="Select verification" name="verification_corrective_action" class="form-control input-sm cat">
                <option value=""></option>
                <option value="D">Done</option>
                <option value="ND">Not Done</option>
                <option value="OG">On-going</option>
            </select>
        </div>

        <div class="col-md-6">
            Upload Attachment :
            <input type="file" name="attachment[]" class="form-control" multiple required>
        </div> --}}
    </div>
@endcomponent