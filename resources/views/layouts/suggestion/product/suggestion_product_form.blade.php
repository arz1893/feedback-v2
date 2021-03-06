<div class="form-group">
    {{ Form::label('customerId', 'Customer') }}
    <div class="input-group input-group-md">
        {{ Form::select('customerId', $selectCustomers, null, ['class' => 'form-control select2',
                                                               'placeholder' => 'Anonymous',
                                                               'style' => 'width: 100%;']) }}
        <span class="input-group-btn">
          <button type="button" class="btn btn-info btn-flat" id="btn_add_customer" data-toggle="modal" data-target="#modal_add_customer">
              <i class="fa fa-plus-circle"></i>
          </button>
        </span>
    </div>
</div>

<div class="form-group">
    {{ Form::label('customer_suggestion', 'Suggestion') }}
    {{ Form::textarea('customer_suggestion', null, ['class' => 'form-control', 'placeholder' => 'Please enter customer\'s suggestion', 'rows' => 6]) }}
</div>

<div class="form-group">
    {{ Form::label('attachment', 'Attach a File') }}
    {{ Form::file('attachment', ['class' => 'form-control-file', 'accept' => 'image/*', 'v-on:change' => 'previewImage($event)']) }}
    @isset($suggestionProduct->attachment)
        <p class="help-block">Click here to change current attachment</p>
    @endisset
</div>

<div class="form-group" v-if="showAttachment" style="width: 180px;">
    <span class="mailbox-attachment-icon has-img"><img src="" id="preview"></span>

    <div class="mailbox-attachment-info">
        <a @click="clearAttachment($event)" class="btn btn-danger btn-xs pull-right" data-toggle="tooltip" data-placement="bottom" title="delete attachment">
            <i class="fa fa-close"></i>
        </a>
        <a class="mailbox-attachment-name"><i class="fa fa-camera"></i> attachment</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <button type="submit" class="btn btn-warning">
            {{ $submitButtonText }}
        </button>
    </div>
</div>