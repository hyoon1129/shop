<?php

namespace Jiny\Shop\Http\Livewire;

use Illuminate\Support\Facades\Blade;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

use Webuni\FrontMatter\FrontMatter;
use Jiny\Pages\Http\Parsedown;

use \Jiny\Html\CTag;
use Jiny\Shop\Entities\ShopProducts;
use Cart;
use Illuminate\Support\Facades\Auth;

class ShopProductDetail extends Component
{
    public $slug;
    public $qty;

    public $option=[];

    public $productOptions=[];

    public function mount()
    {
        $this->qty = 1;
    }

    public function render()
    {
        $slug = $this->slug;
        if (is_numeric($slug)) {
            $product = ShopProducts::where('id',$slug)->first();
        } else {
            $product = ShopProducts::where('slug',$slug)->first();
        }

        // 옵션설정
        if($product->option) {
            $options = $this->options($product->id);
        } else {
            $options = null;
        }

        // 배송정보
        $shipping = DB::table('shop_shipping_method')->where('enable',1)->get();

        return view('jiny-shop::shop.detail.detail', [
            'product'=>$product,
            'shipping'=>$shipping,
            'options'=>$options,
            'optiontree' => $this->optionTree($options,"option")->addClass("option")
        ]);
    }



    private function optionTree($options, $name=null)
    {
        $tree = new CTag('ul',true);
        if(is_array($options)) {
            foreach($options as $i => $option) {
                $title = new CTag('li',true);

                $title->addItem(
                    (new Ctag('span',true))->addItem($option->name)->addClass("font-bold")
                );

                $ul = $this->optionItems($option->id, $name);

                $title->addItem($ul);
                $tree->addItem($title);
            }
        }

        return $tree;
    }

    private function optionItems($option_id, $name=null)
    {
        // 아이템목록
        $ul = new CTag('ul',true);
        $ul->addClass("ml-4");
        $items = $this->getOptionItem($option_id);
        $name .= "[".$option_id."]";
        foreach($items as $i => $item) {
            //$index = $level.$i."-";
            //$index = "";

            $radio = $this->optionRadio($item, $name);

            if($item->nested) {
                $rows = DB::table('shop_options')->where('id',$item->nested)->get();
                $radio->addItem($this->optionTree($rows, $name));
            }

            $ul->addItem($radio);
        }

        return $ul;
    }

    private function optionRadio($item, $name=null)
    {
        $radio = (new Ctag('input',false))->setAttribute('type',"radio");
        //$radio->setAttribute('name', "option[".$item->option_id."]");
        $radio->setAttribute('name', $name);
        $radio->setAttribute('value', $item->id);

        //$radio->setAttribute('wire:model.defer', "option.".$item->id);
        $model = str_replace('[','.',$name);
        $model = str_replace(']','',$model);
        $radio->setAttribute('wire:model.defer', $model.".item");

        //$label = (new Ctag('label',false))->addItem($item->name);
        $label = $item->name;

        $li = new CTag('li',true);
        $li->addItem($label)->addItem($radio);
        return $li;
    }



    private function options($product_id)
    {
        // 복수의 옵션 선택 가능
        $rows = DB::table('shop_products_option')->where('product_id',$product_id)->get();


        $Options = [];
        foreach($rows as $i => $opt) {
            $oid = $opt->option_id;
            $Options[$i] = DB::table('shop_options')->where('id',$oid)->first();

            $items = $this->getOptionItem($oid);
            $Options[$i]->items = $items; //['items'] = [];

        }

        return $Options;
    }

    private $_option_item=[];
    private function getOptionItem($oid)
    {
        if(isset($this->_option_item[$oid])) {
            // 이전 저장된값 반환
        } else {
            $this->_option_item[$oid] = DB::table('shop_options_item')
            ->where('option_id',$oid)
            ->get();
        }
        return $this->_option_item[$oid];
    }



    // 장바구니
    public $cartidx; // 카트번호
    public $popupCart = false;

    public function store($product_id)
    {
        //dd($this->option);

        if($this->cartidx) {

            // cart목록에 상품이 존재하는지 확인
            $cart = DB::table('shop_cart')
                ->where('cartidx',$this->cartidx)
                ->where('product_id',$product_id)->first();

            if($cart) {
                // 장바구니 존재 : 상품 갯수를 1개 증가
                DB::table('shop_cart')
                ->where('cartidx',$this->cartidx)
                ->where('product_id',$product_id)->increment('quantity');

            } else {
                // 카트 갯수
                session()->increment('cart');

                // 신규상품 등록
                $product = DB::table('shop_products')->where('id',$product_id)->first();
                $data = [
                    'cartidx'=>$this->cartidx,
                    'product_id'=>$product->id,
                    'product'=>$product->name,
                    'image'=>$product->image,
                    'price'=>$product->sale_price
                ];

                // 옵션
                $data['option'] = $this->option;

                if(Auth::check()) {
                    $email = Auth::user()->email;
                    $data['email'] = $email;
                }

                DB::table('shop_cart')->insert($data);
            }
        }

        $this->popupCartOpen();
    }

    public function popupCartOpen()
    {
        $this->popupCart = true;
    }

    public function popupCartClose()
    {
        $this->popupCart = false;
    }

    public function increaseQuantity()
    {
        $this->qty++;
    }

    public function decreaseQuantity()
    {
        if($this->qty>1) {
            $this->qty--;
        }
    }


    /**
     * Popup Admin
     */
    public $admin;
    public $popup = false;
    public $forms = [];
    public $_id;

    public function edit($id)
    {
        $this->_id = $id;
        $this->popup = true;
        $row = DB::table('shop_products')->where('id', $id)->first();
        $this->forms = [];
        foreach($row as $key => $value) {
            $this->forms[$key] = $value;
        }
    }

    public function update()
    {

        DB::table('shop_products')->where('id', $this->_id)->update($this->forms);
        $this->_id = null;
        $this->popup = false;
    }

    /**
     * 관심상품
     */
    public function wish($product_id)
    {
        if(Auth::check()) {
            $email = Auth::user()->email;

            // 카트 갯수
            session()->increment('wish');

            // 신규상품 등록
            $product = DB::table('shop_products')->where('id',$product_id)->first();
            $data = [
                'email'=>$email,
                'product_id'=>$product->id,
                'product'=>$product->name,
                'image'=>$product->image
            ];

            DB::table('shop_wish')->insert($data);

            // wish 컴포넌트 갱신
            $this->emit('refreshComponent');

        }
    }


    /**
     * 옵션설정 관리
     */
    /*
    public $popupOptionSetting=false;

    public $optionList=[];
    public $product_id;
    public function openOptionSetting($id)
    {
        $this->product_id = $id;

        // 상품옵션
        $rows = DB::table('shop_products_option')->where('product_id',$id)->get();
        foreach($rows as $row) {
            $this->productOptions []= $row->option_id;
        }


        // 옵션목록
        $this->optionList = DB::table('shop_options')->get();


        //$this->productOptions = $rows;
        $this->popupOptionSetting=true;
    }

    public function closeOptionSetting()
    {
        $this->popupOptionSetting=false;
    }

    public function addOption($option_id)
    {
        $row = DB::table('shop_products_option')
            ->where('product_id',$this->product_id)
            ->where('option_id',$option_id)
            ->first();

        if($row) {
            // 중복 저장
        } else {
            DB::table('shop_products_option')->insert([
                'product_id'=>$this->product_id,
                'option_id'=>$option_id
            ]);
        }
    }

    public function removeOption($option_id)
    {

    }
    */



    public function orderNow($product_id)
    {
        if (session()->has('orderidx')) {
            // 서버 세션값 이용
            $order_idx = session()->get('orderidx');
            $order_status = "checkout";
        } else {
            // orderidx 생성
            $str = md5(microtime().mt_rand(1000,2000));
            $order_idx = date("Ymd")."_".substr($str,0,21); //30자
            $order_status = "checkout";

            // 세션 생성
            session()->put('orderidx', $order_idx);
        }

        // 신규상품 등록
        $product = DB::table('shop_products')->where('id',$product_id)->first();
        $checkout = [
            'orderidx'=>$order_idx,
            'product_id'=>$product->id,
            'product'=>$product->name,
            'image'=>$product->image,
            'price'=>$product->sale_price
        ];

        // 날짜 정보
        $checkout['created_at'] = date("Y-m-d H:i:s");
        $checkout['updated_at'] = $checkout['created_at'];

        // 옵션
        $checkout['options'] = json_encode($this->option);

        if(Auth::check()) {
            $email = Auth::user()->email;
            $checkout['email'] = $email;
        }

        DB::table('shop_checkout_items')->insert($checkout);

    }
}
