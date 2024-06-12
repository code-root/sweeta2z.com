@extends('dashboard.layouts.footer')

@extends('dashboard.layouts.navbar')
<link rel="stylesheet" type="text/css" href="{{asset('assets')}}/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">

@section('title') {{ 'orders' }} @endsection
@section('page-title')  @endsection
@section('body')

<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <table id="invoices" class="table table-bordered display">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">الاسم</th>
                                <th scope="col">الرقم</th>
                                <th scope="col">البريد الإلكتروني</th>
                                <th scope="col">السعر</th>
                                <th scope="col">تفاصيل الطلب</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($orders->count() > 0)
                            @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->number }}</td>
                                <td>{{ $order->email }}</td>
                                <td>{{ $order->price }}</td>
                                <td>
                                    <button class="btn btn-primary" type="button" data-toggle="collapse"
                                        data-target="#orderDetails{{ $order->id }}" aria-expanded="false"
                                        aria-controls="orderDetails{{ $order->id }}">
                                        عرض التفاصيل
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <div class="collapse" id="orderDetails{{ $order->id }}">
                                        <div class="card card-body">
                                            <h4>معلومات الطلب</h4>
                                            <!-- بقية التفاصيل -->
                                            <p>
                                                {{ $order->special_request }}
                                            </p>
                                            <hr> <!-- خط فارق -->

                                            <h4>المنتجات</h4>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">اسم المنتج</th>
                                                        <th scope="col">السعر</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($order->cartItems as $item)
                                                    <tr>
                                                        <td>{{ $item->product_id }}</td>
                                                        <td>{{ $item->product->name }}</td>
                                                        <td>{{ $item->price }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            <hr> <!-- خط فارق -->

                                            <h4>المواعيد</h4>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">تاريخ الحجز</th>
                                                        <th scope="col">time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($order->OrderAppointment as $appointment)
                                                    <tr>
                                                        <td>{{ $appointment->appointment_id }}</td>
                                                        <td>{{ $appointment->date }}</td>
                                                        <td>{{ $appointment->appointment->time }}-

                                                        <!-- تفاصيل إضافية -->
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="6">لا توجد طلبات.</td>
                            </tr>
                            @endif
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // JavaScript code for handling orders deletion with AJAX
    $(document).ready(function() {
        $('.delete-orders').click(function() {
            var ordersId = $(this).data('id');
            $('#deleteordersModal').modal('show');

            $('#confirmDelete').click(function() {
                $.ajax({
                    type: 'DELETE',
                    url: '/admin/ourClient/' + ordersId,
                    data: {
                        '_token': '{{ csrf_token() }}',
                    },
                    success: function(data) {
                        // Reload the page or update the table as needed
                        location.reload();
                    }
                });
            });
        });
    });
</script>
@endsection


