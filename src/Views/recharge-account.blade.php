@extends("Base::layout")
@section("header")
    Prepaid
@endsection
@section("box-header")
    Recharge Account
@endsection
@section("content")

    {!! Form::open(['route'=>['prepaid.recharge.post',],'class'=>'form-horizontal']) !!}
    <div class="row">
        <div class="col-md-6 col-md-offset-2">
            <fieldset>
                <div class="form-group">
                    <label for="" class="control-label col-md-4">Select Subscription</label>
                    <div class="col-md-6">
                        {!! Form::select('username', $subscriptions, request('username'), ['class'=>'form-control', 'data-live-search'=>'true', ]) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label col-md-4">Select Plan</label>
                    <div class="col-md-6">
                        {!! Form::select('plan_id', $plans, NULL, ['class'=>'form-control', 'data-live-search'=>'true', ]) !!}
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-md-offset-4">
            {!! Form::submit('Recharge', ['class'=>'form-control btn btn-block btn-flat bg-orange']) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection