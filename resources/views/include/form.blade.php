<div class="header row">
    {!! Form::open(['class' => 'main-form col-xs-12 col-sm-6', 'action' => 'ImagesController@store']) !!}
    <div class="form-group">
        {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => __('page.titlePlaceholder')]) !!}
    </div>
    <div class="form-group">
        {!! Form::label('image', __('page.filePlaceholder'), ['class' => 'form-control']) !!}
        {!! Form::file('image', ['class' => 'hidden']) !!}
    </div>
    <div class="form-group">
        {!! Form::submit(__('page.upload'), ['class' => 'btn btn-primary form-control']) !!}
    </div>
    {!! Form::close() !!}
    <div class="col-xs-12 col-sm-6">
        <button class="btn btn-primary form-control random">{{ __('page.random') }}</button>
    </div>
</div>