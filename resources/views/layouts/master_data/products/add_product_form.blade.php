<div class="col-md-6">
    <div class="col-md-11">
        <div class="form-group">
            {{ Form::label('name', 'Name', ['class' => 'control-label']) }}
            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Your Product Name']) }}
        </div>
        <div class="form-group">
            {{ Form::label('description', 'Description',['class' => 'control-label']) }}
            {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Enter Your Product\'s Description', 'rows' => 6]) }}
        </div>
    </div>
    <div class="col-md-11">
        <div class="form-group">
            {{ Form::label('tags', 'Select tag') }}
            {{ Form::select('tags[]', $selectTags, null, ['class' => 'form-control select2-tag', 'multiple' => true, 'data-placeholder' => 'Select Tag...']) }}
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="col-md-11">
        {{--<div class="form-group">--}}
            {{--{{ Form::label('metric', 'Product\'s metric') }}--}}
            {{--{{ Form::select('metric', [--}}
                    {{--'Porsi' => 'Porsi',--}}
                    {{--'Pcs' => 'Pcs',--}}
                    {{--'Kg' => 'Kg',--}}
                    {{--'Meter' => 'Meter'--}}
            {{--], null, ['class' => 'form-control', 'placeholder' => 'Select metric']) }}--}}
        {{--</div>--}}
        {{--<div class="form-group">--}}
            {{--{{ Form::label('price', 'Product\'s price') }}--}}
            {{--{{ Form::input('number', 'price', null, ['class' => 'form-control', 'placeholder' => 'Enter product\'s price', 'step' => 'any']) }}--}}
        {{--</div>--}}

        <div class="form-group">
            <label for="image_cover">Choose image</label>
            <input type="file" accept="image/*" class="form-control-file" name="image_cover" id="image_cover" aria-describedby="fileHelp" v-on:change='previewImage($event)'>
            <small id="fileHelp" class="form-text text-muted">Choose your product's image</small>
        </div>

        <div class="form-group" v-if="showAttachment" style="width: 180px;">
            <span class="mailbox-attachment-icon has-img"><img src="" id="preview"></span>

            <div class="mailbox-attachment-info">
                <a @click="clearAttachment($event)" class="btn btn-danger btn-xs pull-right" data-toggle="tooltip" data-placement="bottom" title="delete attachment">
                    <i class="fa fa-close"></i>
                </a>
                <a class="mailbox-attachment-name"><i class="fa fa-camera"></i> image</a>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fa fa-plus"></i> Add Product
        </button>
    </div>
</div>