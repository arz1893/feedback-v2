<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="form-group">
            {{ Form::label('name', 'Name') }}
            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Tag Name']) }}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
        <div class="form-group">
            {{ Form::label('defValue', 'Default Search') }}
            {{ Form::select('defValue', [0 => 'No', 1 => 'Yes'], null, ['class' => 'form-control']) }}
        </div>
    </div>
</div>

@if(!isset($tag))
    <div class="row">
        <div class="col-lg-12 error">
            <div class="form-group">
                {{ Form::label('bgColor', 'Select Color') }} <br>
                <div class="btn-group" role="group">
                    <a data-id="777777" class="btn btn-select-color" style="background: #777777;" onclick="selectColor(this)"> &nbsp; &nbsp; &nbsp;
                        <input id="777777" class="invisible" type="radio" name="bgColor" value="#777777">
                    </a>
                    <a data-id="7E8C8D" class="btn btn-select-color" style="background: #7E8C8D;" onclick="selectColor(this)"> &nbsp; &nbsp; &nbsp;
                        <input id="7E8C8D" class="invisible" type="radio" name="bgColor" value="#7E8C8D">
                    </a>
                    <a data-id="C6382E" class="btn btn-select-color" style="background: #C6382E;" onclick="selectColor(this)"> &nbsp; &nbsp; &nbsp;
                        <input id="C6382E" class="invisible" type="radio" name="bgColor" value="#C6382E">
                    </a>
                    <a data-id="D55005" class="btn btn-select-color" style="background: #D55005;" onclick="selectColor(this)"> &nbsp; &nbsp; &nbsp;
                        <input id="D55005" class="invisible" type="radio" name="bgColor" value="#D55005">
                    </a>
                    <a data-id="EF9E0E" class="btn btn-select-color" style="background: #EF9E0E;" onclick="selectColor(this)"> &nbsp; &nbsp; &nbsp;
                        <input id="EF9E0E" class="invisible" type="radio" name="bgColor" value="#EF9E0E">
                    </a>
                    <a data-id="25AF62" class="btn btn-select-color" style="background: #25AF62;" onclick="selectColor(this)"> &nbsp; &nbsp; &nbsp;
                        <input id="25AF62" class="invisible" type="radio" name="bgColor" value="#25AF62">
                    </a>
                    <a data-id="13A388" class="btn btn-select-color" style="background: #13A388;" onclick="selectColor(this)"> &nbsp; &nbsp; &nbsp;
                        <input id="13A388" class="invisible" type="radio" name="bgColor" value="#13A388">
                    </a>
                    <a data-id="2482C0" class="btn btn-select-color" style="background: #2482C0;" onclick="selectColor(this)"> &nbsp; &nbsp; &nbsp;
                        <input id="2482C0" class="invisible" type="radio" name="bgColor" value="#2482C0">
                    </a>
                    <a data-id="8D45AB" class="btn btn-select-color" style="background: #8D45AB;" onclick="selectColor(this)"> &nbsp; &nbsp; &nbsp;
                        <input id="8D45AB" class="invisible" type="radio" name="bgColor" value="#8D45AB">
                    </a>
                    <a data-id="2E3E4E" class="btn btn-select-color" style="background: #2E3E4E;" onclick="selectColor(this)"> &nbsp; &nbsp; &nbsp;
                        <input id="2E3E4E" class="invisible" type="radio" name="bgColor" value="#2E3E4E">
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif

@isset($tag->bgColor)
    <div class="row">
        <div class="col-lg-12 error">
            <div class="form-group">
                {{ Form::label('bgColor', 'Select Color') }} <br>
                <div class="btn-group" role="group">
                    <a data-id="777777" class="btn btn-select-color {!! ($tag->bgColor == '#777777' ? 'is-selected-color':'') !!}" style="background: #777777;" onclick="selectColor(this)"> &nbsp; &nbsp; &nbsp;
                        <input id="777777" class="invisible" type="radio" name="bgColor" value="#777777" {!! ($tag->bgColor == '#777777' ? 'checked':'') !!}>
                    </a>
                    <a data-id="7E8C8D" class="btn btn-select-color {!! ($tag->bgColor == '#7E8C8D' ? 'is-selected-color':'') !!}" style="background: #7E8C8D;" onclick="selectColor(this)"> &nbsp; &nbsp; &nbsp;
                        <input id="7E8C8D" class="invisible" type="radio" name="bgColor" value="#7E8C8D" {!! ($tag->bgColor == '#7E8C8D' ? 'checked':'') !!}>
                    </a>
                    <a data-id="C6382E" class="btn btn-select-color {!! ($tag->bgColor == '#C6382E' ? 'is-selected-color':'') !!}" style="background: #C6382E;" onclick="selectColor(this)"> &nbsp; &nbsp; &nbsp;
                        <input id="C6382E" class="invisible" type="radio" name="bgColor" value="#C6382E" {!! ($tag->bgColor == '#C6382E' ? 'checked':'') !!}>
                    </a>
                    <a data-id="D55005" class="btn btn-select-color {!! ($tag->bgColor == '#D55005' ? 'is-selected-color':'') !!}" style="background: #D55005;" onclick="selectColor(this)"> &nbsp; &nbsp; &nbsp;
                        <input id="D55005" class="invisible" type="radio" name="bgColor" value="#D55005" {!! ($tag->bgColor == '#D55005' ? 'checked':'') !!}>
                    </a>
                    <a data-id="EF9E0E" class="btn btn-select-color {!! ($tag->bgColor == '#EF9E0E' ? 'is-selected-color':'') !!}" style="background: #EF9E0E;" onclick="selectColor(this)"> &nbsp; &nbsp; &nbsp;
                        <input id="EF9E0E" class="invisible" type="radio" name="bgColor" value="#EF9E0E" {!! ($tag->bgColor == '#EF9E0E' ? 'checked':'') !!}>
                    </a>
                    <a data-id="25AF62" class="btn btn-select-color {!! ($tag->bgColor == '#25AF62' ? 'is-selected-color':'') !!}" style="background: #25AF62;" onclick="selectColor(this)"> &nbsp; &nbsp; &nbsp;
                        <input id="25AF62" class="invisible" type="radio" name="bgColor" value="#25AF62" {!! ($tag->bgColor == '#25AF62' ? 'checked':'') !!}>
                    </a>
                    <a data-id="13A388" class="btn btn-select-color {!! ($tag->bgColor == '#13A388' ? 'is-selected-color':'') !!}" style="background: #13A388;" onclick="selectColor(this)"> &nbsp; &nbsp; &nbsp;
                        <input id="13A388" class="invisible" type="radio" name="bgColor" value="#13A388" {!! ($tag->bgColor == '#13A388' ? 'checked':'') !!}>
                    </a>
                    <a data-id="2482C0" class="btn btn-select-color {!! ($tag->bgColor == '#2482C0' ? 'is-selected-color':'') !!}" style="background: #2482C0;" onclick="selectColor(this)"> &nbsp; &nbsp; &nbsp;
                        <input id="2482C0" class="invisible" type="radio" name="bgColor" value="#2482C0" {!! ($tag->bgColor == '#2482C0' ? 'checked':'') !!}>
                    </a>
                    <a data-id="8D45AB" class="btn btn-select-color {!! ($tag->bgColor == '#8D45AB' ? 'is-selected-color':'') !!}" style="background: #8D45AB;" onclick="selectColor(this)"> &nbsp; &nbsp; &nbsp;
                        <input id="8D45AB" class="invisible" type="radio" name="bgColor" value="#8D45AB" {!! ($tag->bgColor == '#8D45AB' ? 'checked':'') !!}>
                    </a>
                    <a data-id="2E3E4E" class="btn btn-select-color {!! ($tag->bgColor == '#2E3E4E' ? 'is-selected-color':'') !!}" style="background: #2E3E4E;" onclick="selectColor(this)"> &nbsp; &nbsp; &nbsp;
                        <input id="2E3E4E" class="invisible" type="radio" name="bgColor" value="#2E3E4E" {!! ($tag->bgColor == '#2E3E4E' ? 'checked':'') !!}>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endisset

<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            <button class="btn btn-primary" type="submit">
                {{ $submitButtonText }}
            </button>
        </div>
    </div>
</div>