<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Day;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{


    public function  days () {
            $days = Day::all(); // استرداد كل الأيام من قاعدة البيانات
            return response()->json($days); // إرجاع الأيام بصيغة JSON
        }

        public function  add_page () {
            return view('dashboard.days.add');

        }


        public function store(Request $request)
        {
            $data = $request->validate([
                'day' => 'required|integer',
                'from' => 'required|array',
                'from.*' => 'required|date_format:H:i',
                'to' => 'required|array',
                'to.*' => 'required|date_format:H:i',
            ]);

            $dayId = $data['day'];
            $fromTimes = $data['from'];
            $toTimes = $data['to'];

            foreach ($fromTimes as $key => $from) {
                $to = $toTimes[$key];

                // التحقق مما إذا كانت البيانات مسجلة مسبقاً
                $exists = Appointment::where('day_id', $dayId)
                    ->where('start_time', $from)
                    ->where('end_time', $to)
                    ->exists();

                if (!$exists) {
                    Appointment::create([
                        'day_id' => $dayId,
                        'start_time' => $from,
                        'end_time' => $to,
                    ]);
                }
            }

            return response()->json(['message' => 'تمت عملية الحفظ بنجاح']);
        }
        public function getAppointmentsByDay(Request $request)
        {
            $dayId = $request->input('day');
            $appointments = Appointment::where('day_id', $dayId)->get();
            return response()->json($appointments);
        }

        public function deleteAppointment(Request $request){
            $appointmentId = $request->input('appointment_id');
            $deleted = Appointment::destroy($appointmentId);
            if ($deleted) {
                return response()->json(['message' => 'تم حذف الموعد بنجاح']);
            } else {
                return response()->json(['message' => 'فشل في حذف الموعد'], 500);
            }
        }
}
