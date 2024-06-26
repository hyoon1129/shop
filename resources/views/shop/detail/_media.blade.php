<div class="detail-media">
    <!-- Livewire loading indicator -->
    {{-- <x-loading-star /> --}}

    <div class="mx-auto px-4 mt4" x-data="{ image:'image1'}">
        <div>
            <img src="mac-pro.jpg" alt="" x-show="image == 'image1">

        </div>
        <div class="flex items-center mt-4">
            <a href="" class="border border-transparent hover:border-blue-500" @click.prevent="image='image1">
                <img src="" alt="">
            </a>
        </div>

    </div>

    <!-- Images -->
    <div class="mx-auto px-4 mt4" x-data="{ image:'image'}">
        <div>
            <img src="{{ asset($product['image']) }}"
            x-show="image == 'image'">

            @forEach($media as $i => $item)
            <img src="{{ asset($item->image) }}"
            x-show="image == 'image{{$i}}'">
            @endforeach
        </div>

        <div class="flex items-start mt-4">
            <a href="javascript:void(0)"
            class="border border-transparent hover:border-blue-500"
            :class="{'border-blue-500': image === 'image'}"
            @click.prevent="image='image'">
                <img src="{{ asset($product['image']) }}" class="object-contain w-16">
            </a>

            @forEach($media as $i => $item)
            <a href="javascript:void(0)"
            class="border border-transparent hover:border-blue-500"
            :class="{'border-blue-500': image === 'image{{$i}}'}"
            @click.prevent="image='image{{$i}}'">
                <img src="{{ asset($item->image) }}" class="object-contain w-16">
            </a>
            @endforeach
        </div>


        {{--
        <div class="grid grid-cols-4 gap-2 mt-2">
            @forEach($media as $i => $item)
            <a href="javascript:void(0)" class="transition ease-out opacity-50 hover:opacity-100">
                <img src="{{ asset($item->image) }}" alt="Product Image {{$i}}">
            </a>
            @endforeach
        </div>
        --}}

        @if($admin)

            <button wire:click="edit('{{$product['id']}}')">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
                    <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
                    <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
                </svg>
            </button>

        @endif
    </div>
    <!-- END Images -->





    <!-- 이미지 수정 Popup-->
    @if($admin)
    <x-wire-dialog-modal maxWidth="7xl" wire:model="popup">
        <x-slot name="title">
            {{ $product['id'] }}
            {{ __('제품 이미지 편집') }}
        </x-slot>
        <x-slot name="content">

            <div class="grid grid-cols-4 gap-4">
                <div class="">
                    <img src="{{ asset($product['image']) }}" class="object-contain w-64 h-64"/>
                    <x-btn-danger wire:click="delete(0)">삭제</x-btn-danger>
                </div>

                @forEach($media as $item)
                <div class="">
                    <img src="{{ asset($item->image) }}" class="object-contain w-64 h-64"/>
                    <x-btn-danger wire:click="delete('{{$item->id}}')">삭제</x-btn-danger>
                </div>
                @endforeach

            </div>



            <x-shop-product-image path="{{config('shop.path.products.images')}}" :pid="$product['id']">
                {{ $product['name'] }}의 추가 이미지들 드래그 하여 등록합니다.
            </x-shop-product-image>

            {{--
            <x-form-hor>
                <x-form-label>이미지</x-form-label>
                <x-form-item>
                    <!-- Livewire 이미지 보기-->
                    @if(isset($forms['image']))
                        @if (is_object($forms['image']))
                            <!-- 업로드 미리보기 -->
                            <img src="{{$forms['image']->temporaryUrl()}}" alt="">
                        @else
                            <!-- 저장된 이미지 보기 -->
                            <div>
                                {{$forms['image']}}
                            </div>
                            <div>
                                <img src="/images/shop/products/{{$forms['image']}}" alt="">
                            </div>
                        @endif
                    @endif

                    <!-- 이미지 업로드-->
                    <div
                        x-data="{ isUploading: false, progress: 0 }"
                        x-on:livewire-upload-start="isUploading = true"
                        x-on:livewire-upload-finish="isUploading = false"
                        x-on:livewire-upload-error="isUploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress"
                    >
                        <!-- File Input -->
                        <input type="file" name="filename" wire:model.defer="forms.image" class="form-control"/>

                        <!-- Progress Bar -->
                        <div x-show="isUploading">
                            <progress max="100" x-bind:value="progress"></progress>
                        </div>
                    </div>

                    @error('filename') <span class="text-danger">{{$message}}</span> @enderror

                </x-form-item>
            </x-form-hor>
            --}}


        </x-slot>
        <x-slot name="footer">

            <x-btn-primary wire:click="update">저장</x-btn-primary>
        </x-slot>
    </x-wire-dialog-modal>
    @endif
</div>
