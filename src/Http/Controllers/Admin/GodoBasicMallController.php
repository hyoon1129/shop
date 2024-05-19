<?php

namespace Jiny\Shop\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Jiny\Table\Http\Controllers\ResourceController;
class GodoBasicMallController extends ResourceController
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ##
        $this->actions['table'] = "shop_banners"; // 테이블 정보

        $this->actions['view_list'] = "jiny-shop::godo.conf.basic.mall.list";
        $this->actions['view_form'] = "jiny-shop::godo.conf.basic.mall.form";

    }



}
