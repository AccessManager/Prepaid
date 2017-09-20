@extends('Base::layout')
@section('header')
    Recharge Vouchers
@endsection

@section('breadcrumb')
    <li>
        <a href="">Dashboard</a>
    </li>
    <li><a href="">Recharge Vouchers</a></li>
    <li class="active">Generate Vouchers</li>
@endsection
@section('box-header')
    Generate Vouchers
@endsection
@section('content')
    {!! Form::open(['route'=>'vouchers.generate.post','class'=>'form-horizontal']) !!}
    <div class="row">
        <div class="col-md-6 col-md-offset-2">
            <div class="fieldset">
                <div class="form-group">
                    <label for="" class="control-label col-md-4">Service Plan</label>
                    <div class="col-md-6">
                        {!! Form::select('plan_id',$plans, NULL, ['class'=>'form-control', 'data-live-search'=>'true', ]) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label col-md-4">Number of vouchers</label>
                    <div class="col-md-6">
                        {!! Form::text('count', NULL, ['class'=>'form-control','placeholder'=>'how many vouchers to generate?']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label col-md-4">Voucher Validity</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            {!! Form::text('validity', NULL, ['class'=>'form-control','placeholder'=>'voucher stands valid for']) !!}
                            <div class="input-group-btn">
                                {!! Form::select('validity_unit', array_combine(\AccessManager\Constants\Time::TIME_DURATION_UNITS, \AccessManager\Constants\Time::TIME_DURATION_UNITS), NULL, ['class'=>'form-control',]) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-md-offset-4">
            {!! Form::submit('Generate', ['class'=>'form-control btn btn-block btn-flat bg-orange']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection