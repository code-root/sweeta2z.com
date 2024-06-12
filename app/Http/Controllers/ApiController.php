<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderAppointment;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ApiController extends Controller
{


    public function getImageHome() {
        $randomProductIds = Products::inRandomOrder()->take(20)->pluck('id');
        $products = Products::with(['category', 'image'])->whereIn('id', $randomProductIds)->get();
        $responseData = $products->map(function ($product) {
            $images = $product->image;
            $transformedImages = $images->map(function ($image) {
                return [
                    'thumbnail' => $image->url,
                    'original' => $image->url,
                ];
            });
            return [
                'images' => $transformedImages,
            ];
        });
        return $responseData;
    }



    public function storeOrder(Request $request) {
        // Validate request data

        $orderData = $request->only([
            'country_id',
            'area_id',
            'name',
            'email',
            'number',
            'price',
            'address',
            'device',
            'special_request',
            'ip_address',
        ]);

        // Check if both country_id and area_id exist
        if (isset($orderData['country_id'])) {
            $products = $request->input('products', []);
            $orderData['area_id'] = Area::where('name' ,'like',$orderData['area_id'])->first()['id']??1;
            $orderData['country_id'] = Country::where('name' ,'like',$orderData['country_id'])->first()['id']??1;

            $order = Order::create($orderData);
            if ($order) {
                foreach ($products as $product) {
                    if (isset($order->id) && isset($product['product_id'])) {
                        CartItem::create([
                            'order_id' => $order->id,
                            // 'titleToAdd' => $product->titleToAdd ?? '',
                            'product_id' => $product['product_id'],
                            'price' => $product['price'],
                            'quantity' => $product['quantity'],
                            'details' => $product['details'],
                        ]);
                    }
                }

                // Check if appointment_id exists before creating an OrderAppointment
                if ($request->has('dates')) {
                    $datesData = $request->input('dates');
                    if (isset($order->id)) {
                        foreach ($datesData as  $item) {
                                $appointmentData = [
                                    'order_id' => $order->id,
                                    'time' => $request->to_time_delivery ?? null,
                                    'date' => $item,
                                ];
                                OrderAppointment::create($appointmentData);
                    }
                }
            }

                return response()->json([
                    'message' => 'Order created successfully' ,
                    'order_id' => $order->id
                    ]
            );
            } else {
                return response()->json(['message' => 'Failed to create order'], 500);
            }
        } else {
            return response()->json(['message' => 'Country ID or Area ID is missing'], 400);
        }
    }



    public function getCategories() {
        $categories = Category::with('image', 'products', 'products.image')->get();
        $categories->each(function ($category) {
            $category->products = $category->products->sortBy('price_before'); // افتراضياً يفترض أن يكون اسم الحقل الذي يحمل السعر هو 'price'
            $category->products->each(function ($product) {
                $wordsArray = explode("\n", $product->word);
                $description = explode("\n", $product->description);
                $product->word = $wordsArray;
                $product->description = $description;
                $product->words_title = $product->words_title;
            });
        });

        return response()->json(['data' => $categories]);
    }


    public function getProducts() {
        $products = Products::with(['category', 'image'])->get();

        if ($products->isEmpty()) {
            return response()->json(['message' => 'Products not found'], 404);
        }

        $responseData = $products->map(function ($product) {
            $images = $product->image;
            $transformedImages = $images->map(function ($image) {
                return [
                    'thumbnail' => $image->url,
                    'original' => $image->url,
                ];
            });

            $wordsArray = explode("\n", $product->word);
            $description = explode("\n", $product->description);
            return [
                'product' => [
                    'id' => $product->id,
                    'category_id' => $product->category_id,
                    'words_title' => $product->words_title,
                    'name' => $product->name,
                    'word' => $wordsArray,
                    'title' => $product->title,
                    'price_before' => $product->price_before,
                    'price' => $product->price,
                    'description' => $description,
                ],
                'category' => [
                    'id' => $product->category->id,
                    'name' => $product->category->name,
                    'title' => $product->category->title,
                ],
                'images' => $transformedImages,
            ];
        });

        return response()->json(['data' => $responseData]);
    }

    public function getProductsId($id) {
        $product = Products::with(['category', 'image'])->where('id', $id)->first();
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $images = $product->image;

        $transformedImages = $images->map(function ($image) {
            return [
                'thumbnail' => $image->url, // ستكون القيمة هنا url بفضل الـ Accessor
                'original' => $image->url, // ستكون القيمة هنا url بفضل الـ Accessor
            ];
        });
        $wordsArray = explode("\n", $product->word);

        $responseData = [
            'relationship' => Products::with(['image'])->where('rel_id' , $product->id)->get(),
            'product' => [
                'id' => $product->id,
                'category_id' => $product->category_id,
                'name' => $product->name,
                'words_title' => $product->words_title,
                'word' => $wordsArray,
                'token' => $product->token,
                'title' => $product->title,
                'price_before' => $product->price_before,
                'price' => $product->price,
                'description' => $product->description,
            ],

            'category' => [
                'id' => $product->category->id,
                'name' => $product->category->name,
                'title' => $product->category->title,
            ],
            'images' => $transformedImages,
        ];

        return response()->json(['data' => $responseData]);
    }

    public function getCountry() {
        $countries = Country::with(['children' => function ($query) {
            $query->select('id', 'country_id', DB::raw('name AS title'), DB::raw('name AS value'));
        }])
        ->select('id', DB::raw('name AS title'), DB::raw('name AS value') , 'name', 'flag' , 'currency')
        ->get(); // اختيار الأعمدة المطلوبة من الجدول الرئيسي

        return response()->json(['data' => $countries]);
    }

        public function  getCountryid ($id) {
        $country = Country::find($id);
        $areas = $country->children;
        return response()->json(['data' => $areas]);
        }

    public function email_send(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);
        $contactMessage = new ContactMessage;
        $contactMessage->name = $data['name'];
        $contactMessage->email = $data['email'];
        $contactMessage->subject = $data['subject'];
        $contactMessage->message = $data['message'];
        $contactMessage->save();
        Mail::send('emails.contact', ['data' => $data], function($message) use ($data) {
            $message->to('zxsofazx@email.com', 'Mostafa')
                    ->subject($data['subject']);
        });
        return response()->json(['message' => 'تم إرسال الرسالة بنجاح.']);
    }





}
