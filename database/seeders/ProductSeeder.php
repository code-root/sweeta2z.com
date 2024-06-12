<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Products;
use App\Models\ImageItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
class ProductSeeder extends Seeder
{

    public function extractImageUrl($imageUrl)
{
    // استخراج عنوان الصورة
    $parsedUrl = parse_url($imageUrl);
    $imagePath = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . $parsedUrl['path'];

    // استخراج الاستعلام من عنوان الصورة
    $queryString = $parsedUrl['query'] ?? ''; // يحتوي على الاستعلام (query string) بعد الرمز الخاص بالاستعلام

    // تحويل الاستعلام إلى مصفوفة من المفاتيح والقيم
    parse_str($queryString, $queryArray);

    // فحص ما إذا كانت هناك مفتاح يسمى "time" في المصفوفة
    if (isset($queryArray['time'])) {
        // حذف مفتاح "time" من المصفوفة
        unset($queryArray['time']);
    }

    // إعادة تجميع عنوان URL بدون الاستعلام
    $newQueryString = http_build_query($queryArray);
    $newImageUrl = $imagePath . ($newQueryString ? '?' . $newQueryString : '');

    return $newImageUrl;
}

    public function downloadAndSaveImage($imageUrl, $table_name, $xf)
    {
        $savePath = 'assets/' . $table_name;
        $extension = pathinfo($imageUrl, PATHINFO_EXTENSION);

      $imageUrlWithoutQuery  = strtok($imageUrl, '?');

        // استخراج اسم الملف من العنوان الجديد
        $imageName = trim($xf . '-' . now()->format('Y-m-d H-i-s')) . '.' . $extension;
        $imageName  = strtok($imageName, '?');

        $imageContents = Http::get($imageUrlWithoutQuery)->body();

        $tempImagePath = storage_path('app/' . $savePath . '/' . $imageName);
        file_put_contents($tempImagePath, $imageContents);

        $finalPath = public_path($savePath . '/' . $imageName);

        // تأكد من وجود المجلد قبل نقل الملف
        if (!file_exists(public_path($savePath))) {
            mkdir(public_path($savePath), 0777, true);
        }

        // نقل الصورة إلى المسار النهائي
        if (file_exists($tempImagePath)) {
            rename($tempImagePath, $finalPath);

            // إضافة سجل الصورة إلى قاعدة البيانات
            $d = ImageItem::create([
                'url' => $savePath . '/' . $imageName,
                'original_name' => $imageName,
                'language' => 'en',
                'table_name' => $table_name,
                'token' => $xf,
                'status' => 'all', // على سبيل المثال
                'image_size' => '1', // حقل لحفظ مساحة الصورة
            ]);
        }
    }



    public function run()
    {
        // استيراد محتوى ملف JSON
        $json = file_get_contents(public_path('data.json'));

        // تحويل المحتوى إلى صيغة JSON
        $data = json_decode($json, true);

        foreach ($data['data'] as $categoryData) {
        // $imageContents = Http::get($imageUrl)->body();
        // Storage::put($savePath . 'image_name.jpg', $imageContents);

            $category = Category::create([
                'name' => $categoryData['category_name'],
                'title' => $categoryData['category_name'],
                'token' => $categoryData['category_hash'],
            ]);
            $this->downloadAndSaveImage($categoryData['image'], ' ', $categoryData['category_hash']);
            foreach ($categoryData['products'] as $productData) {
                Products::create([
                    'category_id' => $category->id,
                    'name' => $productData['product_name'],
                    'price' => $productData['product_price'],
                    'description' => $productData['product_description'],
                    'token' => $productData['product_hash'],
                ]);
            $this->downloadAndSaveImage($productData['product_thumb'], 'products', $productData['product_hash']);
            }
        }
    }
}
