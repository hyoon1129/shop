<?php

namespace Jiny\Shop\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Jiny\Table\Http\Controllers\ResourceController;
class AdminBankController extends ResourceController
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ##
        $this->actions['table'] = "shop_bank"; // 테이블 정보

        $this->actions['view_list'] = "jiny-shop::admin.bank.list";
        $this->actions['view_form'] = "jiny-shop::admin.bank.form";

    }



}
