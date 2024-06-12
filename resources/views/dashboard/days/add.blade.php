@extends('dashboard.layouts.footer')

@extends('dashboard.layouts.navbar')
<link rel="stylesheet" type="text/css" href="{{asset('assets')}}/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">

@section('title') {{ 'day' }} @endsection
@section('page-title') day  @endsection
@section('body')

<section class="row">
    <div class="col-xl-6 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Add day</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form id="dayForm">
                        @csrf
                        <label for="day">اختر اليوم:</label>
                        <select id="day" name="day" class="form-select">
                            <!-- خيارات الأيام تعبئ من Ajax -->
                        </select>
                    </form>

                    <div id="slotsForm">
                        <div id="successMessageContainer"></div>

                        <form id="addSlotsForm">
                            @csrf
                            <div id="slots" class="row slot">
                                <div class="col-md-4">
                                    <input type="time" name="from[]" required class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <input type="time" name="to[]" required class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-danger deleteSlotBtn" type="button">حذف</button>
                                </div>
                            </div><br>

                            <button id="addSlotBtn" type="button" class="btn btn-success">إضافة وقت جديد</button>
                            <button type="submit" class="btn btn-primary">حفظ المواعيد</button>
                        </form>
                    </div>

                    <!-- عرض المواعيد المحفوظة -->
                    <div id="savedAppointments">
                        <h5>المواعيد المحفوظة:</h5>
                        <ul id="appointmentsList" class="list-group">
                            <!-- تعبئ من Ajax -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('footer')
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="{{asset('assets')}}/app-assets/vendors/js/extensions/sweetalert.min.js"></script>
<script src="{{asset('assets')}}/dashboard/js/app.js"></script>
<script>

$(document).ready(function () {
    // جلب المواعيد عند تغيير اليوم
    $('#day').change(function () {
        var selectedDay = $('#day').val();
        $.ajax({
            type: 'GET',
            url: "{{ route('days.appointments') }}",
            data: { day: selectedDay },
            success: function (data) {
                var appointmentsList = $('#appointmentsList');
                appointmentsList.empty();

                // عرض المواعيد
                data.forEach(function (appointment) {
                    var listItem = '<li class="list-group-item">' + appointment.start_time + ' - ' + appointment.end_time + '<button class="btn btn-danger deleteAppointmentBtn" data-id="' + appointment.id + '">حذف</button></li>';
                    appointmentsList.append(listItem);
                });
            }
        });
    });

    // حذف موعد
    $('#appointmentsList').on('click', '.deleteAppointmentBtn', function () {
        var appointmentId = $(this).data('id');
        let csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'DELETE',
            url: "{{ route('appointments.delete') }}",
            data: { appointment_id: appointmentId },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function (data) {
                // إعادة جلب المواعيد بعد الحذف
                $('#dayForm').submit();
            }
        });
    });

    // حذف حقل الوقت
    $('#slotsForm').on('click', '.deleteSlotBtn', function (event) {
        event.preventDefault();
        $(this).parent().remove();
    });

    // جلب الأيام وملء القائمة المنسدلة
    $.ajax({
        type: 'GET',
        url: "{{ route('days.index') }}",
        success: function (data) {
            var daySelect = $('#day');
            daySelect.empty();

            // إضافة الأيام
            data.forEach(function (day) {
                daySelect.append('<option value="' + day.id + '">' + day.name_ar + '</option>');
            });
        },
        error: function(xhr, status, error) {
            // إدراج تعامل مع الأخطاء
        }
    });

    // إضافة حقول الوقت
    $('#slotsForm').on('click', '#addSlotBtn', function (event) {
    event.preventDefault();
    var newSlotField = `
        <div class="row slot">
            <div class="col-md-4">
                <input type="time" name="from[]" required class="form-control">
            </div>
            <div class="col-md-4">
                <input type="time" name="to[]" required class="form-control">
            </div>
            <div class="col-md-4">
                <button class="btn btn-danger deleteSlotBtn" type="button">حذف</button>
            </div>
        </div><br>`;
    $('#slots').append(newSlotField);
});


    // حفظ المواعيد
    $('#slotsForm').on('submit', '#addSlotsForm', function (event) {
        event.preventDefault();
        var selectedDay = $('#day').val();
        var formData = $(this).serialize();
        formData += '&day=' + selectedDay;

        $.ajax({
            type: 'POST',
            url: "{{ route('days.store') }}",
            data: formData,
            success: function (data) {
        // إذا تمت العملية بنجاح، قم بإظهار رسالة النجاح
        var successMessage = '<div class="alert alert-success" role="alert">تمت عملية الإضافة بنجاح!</div>';
        // قم بإضافة رسالة النجاح إلى الصفحة
        $('#successMessageContainer').html(successMessage).fadeIn();
        setTimeout(function() {
        $('#successMessageContainer').fadeOut();
        }, 5000); // 5000 ميلي ثانية = 5 ثواني

    },
    error: function (xhr, status, error) {
        // في حال حدوث خطأ، يمكنك إظهار رسالة خطأ أيضًا إذا رغبت
        var errorMessage = '<div class="alert alert-danger" role="alert">حدث خطأ أثناء عملية الإضافة!</div>';
        $('#successMessageContainer').html(errorMessage);
    }
        });
    });
});


</script>

@endsection
@endsection


