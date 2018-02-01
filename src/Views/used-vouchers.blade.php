@extends("Base::layout")
@section("header")
    Prepaid Vouchers
@endsection
@section("content")
    <div class="row">
        <div class="col-xs-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li><a href="{{route('vouchers.unused')}}">Unused Vouchers</a></li>
                    <li class="active"><a href="{{route('vouchers.used')}}">Used Vouchers</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="unused-vouchers">
                        <table class="table table-hover table-stripped">
                            <thead>
                            <tr>
                                <th>
                                    sr no
                                </th>
                                <th>
                                    service plan
                                </th>
                                <th>
                                    pin
                                </th>
                                <th>
                                    validity
                                </th>
                                <th>
                                    generated on
                                </th>
                                <th>
                                    used on
                                </th>
                                <th>
                                    used by
                                </th>
                                <th>
                                    method
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = $vouchers->firstItem(); ?>
                            @forelse($vouchers as $voucher)
                                <tr>
                                    <td>
                                        {{$i++}}
                                    </td>
                                    <td>
                                        {{$voucher->name}}
                                    </td>
                                    <td>
                                        {{$voucher->pin}}
                                    </td>
                                    <td>
                                        {{$voucher->validity}} {{$voucher->validity_unit}}
                                    </td>
                                    <td>
                                        {{$voucher->generated_on->format('d M y H:i')}}
                                    </td>
                                    <td>
                                        @if( $voucher->used_on !== null )
                                            {{$voucher->used_on->format('d M y H:i')}}
                                        @endif
                                    </td>
                                    <td>
                                        @if( ! is_null($voucher->usedby))
                                            <a href="{{route('account.subscriptions.prepaid', [$voucher->usedby->account->username, $voucher->usedby->username])}}">
                                                {{$voucher->usedby->username}}
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        {{$voucher->method}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td></td>
                                    <td colspan="9">
                                        no records found.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <span class="pull-right">
    {{$vouchers->appends([request()->only('used', 'unused')])->links()}}
</span>
                    </div>
                    <!-- tap-pane ends #unused-vouchers -->
                </div>
                <!-- tap-content ends -->
            </div>
            <!-- nav-tabs-custom ends -->
        </div>
    </div>
@endsection