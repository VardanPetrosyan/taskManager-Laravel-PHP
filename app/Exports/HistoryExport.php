<?php

namespace App\Exports;

use App\CategoryStructure;
use App\FurnHistory;
use Illuminate\Support\Facades\DB;
use Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;




class HistoryExport implements FromCollection,WithHeadings
{
    public function headings(): array
    {
        return [
            'Անվանում',
            'Տիպ',
            'Նկարագրություն',
            'Պատասխանատու',
            'Բաժին',
            'Պատվիրող բաժին',
            'Քանակ',
            'Օր'
        ];
    }
    
    public function collection()
    {
        $userFilter = Session::get('filter_user');
        $userFilterDate = Session::get('filter_user_date');
    
        if($userFilterDate != null){
            $date = explode("-", $userFilterDate);
        
            $firstDate = date("Y-m-d", strtotime($date[0]));
            $secondDate = date("Y-m-d", strtotime($date[1]));
        }
        
        $furnituresHistory = FurnHistory::query()
            ->join('category_structures', 'category_structures.id','=', 'furn_histories.receiver_categoryStructure_id')
            ->join('users', 'users.id','=', 'furn_histories.user_id')
            ->select("furn_histories.name" ,"furn_histories.type","furn_histories.description","users.name AS userName", "category_structures.category AS categoryStructureResiverName","furn_histories.categoryStructure_id AS categoryStructureName","furn_histories.count", "furn_histories.created_at");
        
        if($userFilter != null){
            $furnituresHistory->where('user_id', '=',$userFilter);
        }
        if($userFilterDate != null){
            if(strtotime($firstDate) != strtotime($secondDate)){
                $furnituresHistory = $furnituresHistory
                    ->where("furn_histories.created_at", ">", $firstDate . " 00:00:00")
                    ->where("furn_histories.created_at", "<", $secondDate . " 00:00:00");
            }
        
        }
    
        $furnituresHistory = $furnituresHistory->get();
        forEach($furnituresHistory as $furnitureHistory){
            $categoryName = DB::table('category_structures')->where("id",$furnitureHistory->categoryStructureName)->first();
     
            $furnitureHistory->categoryStructureName = $categoryName->category;
//            dd($furnitureHistory->categoryStructureName);
        }
        
        foreach ($furnituresHistory as $furnitureHistory) {
            switch ($furnitureHistory->type) {
                case "order":
                    $furnitureHistory->type = "Գրանցվել է պատվեր";
                    break;
                case "cancel_order":
                    $furnitureHistory->type =  "Պատվերը Չեղարկվել է";
                    break;
                case "admin_confirm":
                    $furnitureHistory->type =  "Ադմինը Հաստատել է";
                    break;
                case "admin_disapprove":
                    $furnitureHistory->type =  "Ադմինը Չղարկել է";
                    break;
                case "admin_decline":
                    $furnitureHistory->type = "Ադմինը  Մերժել է";
                    break;
                case "send":
                    $furnitureHistory->type =  "Պատվերը ուղարկվել է";
                    break;
                case "cancel_send":
                    $furnitureHistory->type =  "Պատվերը մերժվել է";
                    break;
                case "receive":
                    $furnitureHistory->type =  "Պատվերը ստացվել է";
                    break;
                case "cancel_receive":
                    $furnitureHistory->type =  "Պատվերը չի ստացվել";
                    break;
                case "add":
                    $furnitureHistory->type = "Գույքի Ավելացում";
                    break;
                case "delete":
                    $furnitureHistory->type =  "Գույքի լուծարում";
                    break;
                case "edit":
                    $furnitureHistory->type = "Գույքի փոփոխություն";
                    break;
            }
            
            
        }

        return $furnituresHistory;
    }
}
