<?php
namespace Jiny\Shop\Http\Livewire;

use Illuminate\Support\Facades\Blade;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Webuni\FrontMatter\FrontMatter;
use Jiny\Pages\Http\Parsedown;
// use \Jiny\Html\CTag;
// use Jiny\Shop\Entities\ShopSliders;

//use Livewire\WithFileUploads;

class CartzillaLiveCategory extends Component
{
    //use WithFileUploads;
    //use \Jiny\WireTable\Http\Trait\Upload;

    // public function render()
    // {
    //     // 카테고리 데이터를 데이터베이스에서 가져옵니다.
    //     $categories = DB::table('home_category')->get();
    //     $categories = $categories->groupBy('ref'); // 'ref'로 그룹화하여 하위 카테고리 구조를 만듭니다.

    //     return view('jiny-shop::cartzilla.home-electronics-category', [
    //         'categories' => $categories
    //     ]);
    // }



    public function render()
    {
        $objs = DB::table('shop_categories')->get();
        //dd($objs);
        $rows = []; // 빈 배열
        foreach($objs as $item) { // 배열에서 각각의 객체를 하나씩 읽어 온다.

            $temp = []; // 객체를 변환할 빈 배열을 하나 초기화.
            foreach($item as $key => $value) {
                // 객체에서 키(프로퍼티)와 값을 분리해서 읽어 주세요.
                // 객체의 키와 값을 분리할 때는 `=>` 사용한다.
                $temp[$key] = $value;
            }

            // 변환된 하나의 개체의 배열을
            // 상위 rows 배열로 다시 넣어준다.
            $rows []= $temp;
        }
        // dd는 값을 디버그로 화면에 출력하고, 실행을 중단.
        // dump() 는 화면에 출력하고, 코드의 실행은 계속
        //dd($rows);

        return view("jiny-shop::cartzilla.home-electronics-category",[
            'rows' => $rows
        ]);
    }
}
