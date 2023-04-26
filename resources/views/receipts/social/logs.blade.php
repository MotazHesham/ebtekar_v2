<div id="accordion-collapse" data-accordion="collapse">
    @foreach (\App\Models\AuditLog::where('subject_type', 'App\Models\ReceiptSocial')->where('subject_id', $getRecord()->id)->orderBy('created_at', 'asc')->get()->reverse() as $key => $log)
        @php
            $user = \App\Models\User::find($log->user_id);
        @endphp


        <button type="button"
            class="relative text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2"
            data-toggle="collapse" data-accordion-target="#accordion-collapse-body-{{ $key }}"
            aria-expanded="true" aria-controls="accordion-collapse-body-{{ $key }}"
            style="color:white">
            <span>{{$user ? $user->email : ''}}</span> - <span style="color:rebeccapurple"> {{ $log->created_at }} </span>

        </button>

        <div id="accordion-collapse-body-{{ $key }}" class="hidden" aria-labelledby="accordion-collapse-heading-{{ $key }}">
            <div class="grid gap-4 lg:grid-cols-3 md:grid-cols-2">
                <p>
                    <b>
                        <span class="badge badge-info">{{ __('Note') }}</span>
                    </b>

                    <span   @isset($logs[$key - 1])
                                @if ($logs[$key - 1]->properties['note'] != $logs[$key]->properties['note']) style="color:red" @endif
                            @endisset>
                        <?php echo $log->properties['note'] ?? ''; ?>
                    </span>
                </p>

                <hr>

                <p>
                    <b>
                        {{ __('Delay Reason') }}
                    </b>
                    :
                    @isset($logs[$key]->properties['delay_reason'])
                        <span   @isset($logs[$key - 1])
                                    @isset($logs[$key - 1]->properties['delay_reason'])
                                        @if ($logs[$key - 1]->properties['delay_reason'] != $logs[$key]->properties['delay_reason']) style="color:red" @endif
                                    @else
                                        style="color:red"
                                    @endisset
                                @endisset>
                        (   {{ $log->properties['delay_reason'] ?? ''}}
                        )</span>
                    @endisset
                </p>
                <p>
                    <b>
                        {{ __('Cancel Reason') }}
                    </b>
                    :
                    @isset($logs[$key]->properties['cancel_reason'])
                        <span   @isset($logs[$key - 1])
                                    @isset($logs[$key - 1]->properties['cancel_reason'])
                                        @if ($logs[$key - 1]->properties['cancel_reason'] != $logs[$key]->properties['cancel_reason']) style="color:red" @endif
                                    @else
                                        style="color:red"
                                    @endisset
                                @endisset>
                        (   {{ $log->properties['cancel_reason'] ?? ''}}
                        )</span>
                    @endisset
                </p>
                <p>
                    <b>
                        الطباعة
                    </b>
                    :
                    @isset($logs[$key]->properties['printing_times'])
                        <span   @isset($logs[$key - 1])
                                    @isset($logs[$key - 1]->properties['printing_times'])
                                        @if ($logs[$key - 1]->properties['printing_times'] != $logs[$key]->properties['printing_times']) style="color:red" @endif
                                    @else
                                        style="color:red"
                                    @endisset
                                @endisset>
                        (   {{ $log->properties['printing_times'] ?? ''}}
                        )</span>
                    @endisset
                </p>
                <p>
                    <b>
                        المرتجع
                    </b>
                    :
                    @isset($logs[$key]->properties['returned'])
                        <span   @isset($logs[$key - 1])
                                    @isset($logs[$key - 1]->properties['returned'])
                                        @if ($logs[$key - 1]->properties['returned'] != $logs[$key]->properties['returned']) style="color:red" @endif
                                    @else
                                        style="color:red"
                                    @endisset
                                @endisset>
                        (   {{ $log->properties['returned'] ?? ''}}
                        )</span>
                    @endisset
                </p>
            </div>
            <div class="grid gap-4 lg:grid-cols-3 md:grid-cols-2">
                <p>
                    <b>
                        {{ __('Order Cost') }}
                    </b>
                    :
                    @isset($logs[$key]->properties['total_cost'])
                        <span   @isset($logs[$key - 1])
                                    @isset($logs[$key - 1]->properties['total_cost'])
                                        @if ($logs[$key - 1]->properties['total_cost'] != $logs[$key]->properties['total_cost']) style="color:red" @endif
                                    @else
                                        style="color:red"
                                    @endisset
                                @endisset>
                        (  {{ currency_formatting($log->properties['total_cost']) ?? ''}}
                        )</span>
                    @endisset
                </p>
                <p>
                    <b>
                        {{ __('Discount') }}
                    </b>
                    :
                    @isset($logs[$key]->properties['discount'])
                        <span   @isset($logs[$key - 1])
                                    @isset($logs[$key - 1]->properties['discount'])
                                        @if ($logs[$key - 1]->properties['discount'] != $logs[$key]->properties['discount']) style="color:red" @endif
                                    @else
                                        style="color:red"
                                    @endisset
                                @endisset>
                        (  {{ currency_formatting($log->properties['discount']) ?? ''}}
                        )</span>
                    @endisset
                </p>
                <p>
                    <b>
                        {{ __('Shipping Cost') }}
                    </b>
                    :

                    <span   @isset($logs[$key - 1])
                                @if ($logs[$key - 1]->properties['shipping_country_cost'] != $logs[$key]->properties['shipping_country_cost']) style="color:red" @endif
                            @endisset>
                    (  {{ currency_formatting($log->properties['shipping_country_cost']) ?? ''}}
                    )</span>
                </p>
                <p>
                    <b>
                        {{ __('Deposit') }}
                    </b>
                    :

                    <span   @isset($logs[$key - 1])
                                @if ($logs[$key - 1]->properties['deposit'] != $logs[$key]->properties['deposit']) style="color:red" @endif
                            @endisset>
                    (  {{ currency_formatting($log->properties['deposit']) ?? ''}}
                    )</span>
                </p>
                <p>
                    <b>
                        {{ __('Commission') }}
                    </b>
                    :
                    @isset($logs[$key]->properties['commission'])
                        <span   @isset($logs[$key - 1])
                                    @isset($logs[$key - 1]->properties['commission'])
                                        @if ($logs[$key - 1]->properties['commission'] != $logs[$key]->properties['commission']) style="color:red" @endif
                                    @else
                                        style="color:red"
                                    @endisset
                                @endisset>
                        (  {{ currency_formatting($log->properties['commission']) ?? ''}}
                        )</span>
                    @endisset
                </p>
                <p>
                    <b>
                        {{ __('Extra Commission') }}
                    </b>
                    :
                    @isset($logs[$key]->properties['extra_commission'])
                        <span   @isset($logs[$key - 1])
                                    @isset($logs[$key - 1]->properties['extra_commission'])
                                        @if ($logs[$key - 1]->properties['extra_commission'] != $logs[$key]->properties['extra_commission']) style="color:red" @endif
                                    @else
                                        style="color:red"
                                    @endisset
                                @endisset>
                        (  {{ currency_formatting($log->properties['extra_commission']) ?? ''}}
                        )</span>
                    @endisset
                </p>

                <br>

                <p>
                    <b>
                        {{ __('Delivery Status') }}
                    </b>
                    :
                    @isset($logs[$key]->properties['delivery_status'])
                        <span   @isset($logs[$key - 1])
                                    @isset($logs[$key - 1]->properties['delivery_status'])
                                        @if ($logs[$key - 1]->properties['delivery_status'] != $logs[$key]->properties['delivery_status']) style="color:red" @endif
                                    @else
                                        style="color:red"
                                    @endisset
                                @endisset>
                        (  {{ $log->properties['delivery_status'] }}
                        )</span>
                    @endisset
                </p>
                <p>
                    <b>
                        {{ __('Payment Status') }}
                    </b>
                    :
                    @isset($logs[$key]->properties['payment_status'])
                        <span   @isset($logs[$key - 1])
                                    @isset($logs[$key - 1]->properties['payment_status'])
                                        @if ($logs[$key - 1]->properties['payment_status'] != $logs[$key]->properties['payment_status']) style="color:red" @endif
                                    @else
                                        style="color:red"
                                    @endisset
                                @endisset>
                        (  {{ __(ucfirst($log->properties['payment_status'])) }}
                        )</span>
                    @endisset
                </p>
                <p>
                    <b>
                        حالة التشغيل
                    </b>
                    :
                    @isset($logs[$key]->properties['playlist_status'])
                        <span   @isset($logs[$key - 1])
                                    @isset($logs[$key - 1]->properties['playlist_status'])
                                        @if ($logs[$key - 1]->properties['playlist_status'] != $logs[$key]->properties['playlist_status']) style="color:red" @endif
                                    @else
                                        style="color:red"
                                    @endisset
                                @endisset>
                        (   {{ __('playlist_status_' . $log->properties['playlist_status']) }}
                        )</span>
                    @endisset
                </p>
            </div>
            <div class="grid gap-4 lg:grid-cols-3 md:grid-cols-2">
                <p>
                    <b>
                        {{ __('Date Created') }}
                    </b>
                    :

                    <span   @isset($logs[$key - 1])
                                @if ($logs[$key - 1]->properties['created_at'] != $logs[$key]->properties['created_at']) style="color:red" @endif
                            @endisset>
                    (   {{ $log->properties['created_at'] ?? ''}}
                    )</span>
                </p>
                <p>
                    <b>
                        تاريخ التشغيل
                    </b>
                    :
                    @isset($logs[$key]->properties['send_to_playlist_date'])
                        <span   @isset($logs[$key - 1])
                                    @isset($logs[$key - 1]->properties['send_to_playlist_date'])
                                        @if ($logs[$key - 1]->properties['send_to_playlist_date'] != $logs[$key]->properties['send_to_playlist_date']) style="color:red" @endif
                                    @else
                                        style="color:red"
                                    @endisset
                                @endisset>
                        (   {{ $log->properties['send_to_playlist_date'] ?? ''}}
                        )</span>
                    @endisset
                </p>
                <p>
                    <b>
                        {{ __('Date of Receiving Order') }}
                    </b>
                    :
                    @isset($logs[$key]->properties['date_of_receiving_order'])
                        <span   @isset($logs[$key - 1])
                                    @isset($logs[$key - 1]->properties['date_of_receiving_order'])
                                        @if ($logs[$key - 1]->properties['date_of_receiving_order'] != $logs[$key]->properties['date_of_receiving_order']) style="color:red" @endif
                                    @else
                                        style="color:red"
                                    @endisset
                                @endisset>
                        (   {{ $log->properties['date_of_receiving_order'] ?? ''}}
                        )</span>
                    @endisset
                </p>
                <p>
                    <b>
                        {{ __('Delivery Date') }}
                    </b>
                    :
                    @isset($logs[$key]->properties['deliver_date'])
                        <span   @isset($logs[$key - 1])
                                    @isset($logs[$key - 1]->properties['deliver_date'])
                                        @if ($logs[$key - 1]->properties['deliver_date'] != $logs[$key]->properties['deliver_date']) style="color:red" @endif
                                    @else
                                        style="color:red"
                                    @endisset
                                @endisset>
                        (   {{ $log->properties['deliver_date'] ?? ''}}
                        )</span>
                    @endisset
                </p>

                <br>


                <p>
                    <b>
                        {{ __('Calling') }}
                    </b>
                    :
                    @isset($logs[$key]->properties['calling'])
                        <span   @isset($logs[$key - 1])
                                    @isset($logs[$key - 1]->properties['calling'])
                                        @if ($logs[$key - 1]->properties['calling'] != $logs[$key]->properties['calling']) style="color:red" @endif
                                    @else
                                        style="color:red"
                                    @endisset
                                @endisset>
                        (   {{ $log->properties['calling'] ? 'ON' : 'OFF'}}
                        )</span>
                    @endisset
                </p>
                <p>
                    <b>
                        {{ __('Confirm') }}
                    </b>
                    :
                    @isset($logs[$key]->properties['confirm'])
                        <span   @isset($logs[$key - 1])
                                    @isset($logs[$key - 1]->properties['confirm'])
                                        @if ($logs[$key - 1]->properties['confirm'] != $logs[$key]->properties['confirm']) style="color:red" @endif
                                    @else
                                        style="color:red"
                                    @endisset
                                @endisset>
                        (   {{ $log->properties['confirm'] ? 'ON' : 'OFF'}}
                        )</span>
                    @endisset
                </p>
                <p>
                    <b>
                        {{ __('Quickly') }}
                    </b>
                    :
                    @isset($logs[$key]->properties['quickly'])
                        <span   @isset($logs[$key - 1])
                                    @isset($logs[$key - 1]->properties['quickly'])
                                        @if ($logs[$key - 1]->properties['quickly'] != $logs[$key]->properties['quickly']) style="color:red" @endif
                                    @else
                                        style="color:red"
                                    @endisset
                                @endisset>
                        (   {{ $log->properties['quickly'] ? 'ON' : 'OFF'}}
                        )</span>
                    @endisset
                </p>
                <p>
                    <b>
                        {{ __('Done') }}
                    </b>
                    :
                    @isset($logs[$key]->properties['done'])
                        <span   @isset($logs[$key - 1])
                                    @isset($logs[$key - 1]->properties['done'])
                                        @if ($logs[$key - 1]->properties['done'] != $logs[$key]->properties['done']) style="color:red" @endif
                                    @else
                                        style="color:red"
                                    @endisset
                                @endisset>
                        (   {{ $log->properties['done'] ? 'ON' : 'OFF'}}
                        )</span>
                    @endisset
                </p>
            </div>
            <div class="grid gap-4 lg:grid-cols-3 md:grid-cols-2">
                <p>
                    <b>
                        {{ __('id') }}
                    </b>
                    :

                    <span   @isset($logs[$key - 1])
                                @if ($logs[$key - 1]->properties['id'] != $logs[$key]->properties['id']) style="color:red" @endif
                            @endisset>
                    (   {{ $log->properties['id'] ?? ''}}
                    )</span>
                </p>
                <p>
                    <b>
                        {{ __('Order Num') }}
                    </b>
                    :
                    @isset($logs[$key]->properties['order_num'])
                        <span   @isset($logs[$key - 1])
                                    @isset($logs[$key - 1]->properties['order_num'])
                                        @if ($logs[$key - 1]->properties['order_num'] != $logs[$key]->properties['order_num']) style="color:red" @endif
                                    @else
                                        style="color:red"
                                    @endisset
                                @endisset>
                        (   {{ $log->properties['order_num'] ?? ''}}
                        )</span>
                    @endisset
                </p>
                <p>
                    <b>
                        {{ __('Client') }}
                    </b>
                    :

                    <span   @isset($logs[$key - 1])
                                @if ($logs[$key - 1]->properties['client_name'] != $logs[$key]->properties['client_name']) style="color:red" @endif
                            @endisset>
                    (   {{ $log->properties['client_name'] ?? ''}}
                    )</span>
                </p>
                <p>
                    <b>
                        {{ __('Receipt Type') }}
                    </b>
                    :

                    <span   @isset($logs[$key - 1])
                                @if ($logs[$key - 1]->properties['type'] != $logs[$key]->properties['type']) style="color:red" @endif
                            @endisset>
                    (   {{ $log->properties['type'] ?? ''}}
                    )</span>
                </p>
                <p>
                    <b>
                        {{ __('Phone Number') }}
                    </b>
                    :

                    <span   @isset($logs[$key - 1])
                                @if ($logs[$key - 1]->properties['phone_number'] != $logs[$key]->properties['phone_number']) style="color:red" @endif
                            @endisset>
                    (   {{ $log->properties['phone_number'] ?? ''}}
                    )</span>
                </p>
                <p>
                    <b>
                        {{ __('Phone Number 2') }}
                    </b>
                    :

                    <span   @isset($logs[$key - 1])
                                @if ($logs[$key - 1]->properties['phone_number2'] != $logs[$key]->properties['phone_number2']) style="color:red" @endif
                            @endisset>
                    (   {{ $log->properties['phone_number2'] ?? ''}}
                    )</span>
                </p>
                <p>
                    <b>
                        {{ __('cruds.receipt_social.fields.shipping_country_cost') }}
                    </b>
                    :

                    <span   @isset($logs[$key - 1])
                                @if ($logs[$key - 1]->properties['shipping_country_name'] != $logs[$key]->properties['shipping_country_name']) style="color:red" @endif
                            @endisset>
                    (   {{ $log->properties['shipping_country_name'] ?? ''}}
                    )</span>
                    |
                    <span   @isset($logs[$key - 1])
                                @if ($logs[$key - 1]->properties['shipping_country_cost'] != $logs[$key]->properties['shipping_country_cost']) style="color:red" @endif
                            @endisset>
                    (   {{ $log->properties['shipping_country_cost'] ?? ''}}
                    )</span>
                </p>
                <p>
                    <b>
                        {{ __('cruds.receipt_social.fields.shipping_address') }}
                    </b>
                    :

                    <span   @isset($logs[$key - 1])
                                @if ($logs[$key - 1]->properties['shipping_address'] != $logs[$key]->properties['shipping_address']) style="color:red" @endif
                            @endisset>
                    (   {{ $log->properties['shipping_address'] ?? ''}}
                    )</span>
                </p>
            </div>
        </div>


    @endforeach
</div>
