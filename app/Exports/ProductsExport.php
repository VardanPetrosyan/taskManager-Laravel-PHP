<?php
    
    namespace App\Exports;
    
    use App\Product;
    use Illuminate\Database\Eloquent\Model;
    use Maatwebsite\Excel\Concerns\FromCollection;
    use Maatwebsite\Excel\Concerns\WithHeadings;
    
    
    class ProductsExport implements FromCollection, WithHeadings
    {
        public function headings(): array
        {
            return [
                'Անուն',
                'Կատեգորիա',
                'Արժեք',
                'Կոդ',
                'Քանակ',
                'Կարգավիճակ'
            ];
        }
        
        public function collection()
        {
            
            $products = Product::query()
                ->join('category', 'category.id','=', 'products.category')
                ->select("products.name" ,"category.name AS categoryName", "products.price", "products.code", "products.count", "products.status")
                ->get();
            
            foreach ($products as $product) {
                switch ($product->status) {
                    case "active":
                        $product->status = "ակտիվ";
                        break;
                    case "passive":
                        $product->status = "պասիվ";
                        break;
                    case "reserve":
                        $product->status = "պատվիրված";
                        break;
                    
                }
                if($product->price == ''){
                    $product->price = '0';
                }
                
            }
            
            
            return $products;
        }
    }
