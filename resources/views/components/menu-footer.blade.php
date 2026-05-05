@props(['name'])

@if ($menu = \App\Models\Menu::where('name', $name)->first())
<section class="py-[80px] mt-[80px] lg:p-[90px] bg-primary relative">
    <div class="container">
        <div class="grid grid-cols-1">
            <div class="col-span">
                <div class="flex flex-wrap items-center justify-between">
                    <div class="w-full lg:w-auto">
                        <h3
                            class="font-lora text-white text-[24px] sm:text-[30px] xl:text-[36px] leading-[1.277] mb-[10px]">
                            هل لديك اي استفسار ؟</h3>
                        <p class="text-secondary leading-[1.5] tracking-[0.03em] mb-10">انضم الى عملاءنا واطلع على كل
                            جديد عبر واتساب</p>
                        <form id="mc-form" action="#" class="relative w-full" novalidate="true" aria-label="اشترك بالواتساب">
                            <input id="mc-phone"
                                class="font-light text-white leading-[1.75] opacity-100 border border-secondary w-full lg:w-[395px] xl:w-[495px] h-[60px] rounded-[10px] py-[15px] pl-[15px] pr-[15px] sm:pr-[135px] focus:border-white focus:outline-none border-opacity-60 placeholder:text-[#E2E2E2] bg-transparent"
                                type="tel" inputmode="tel" pattern="[0-9\s\-()+]+" aria-label="رقم الجوال" placeholder="ادخل رقم الجوال الخاص بك">
                            <button id="mc-submit" type="submit" aria-label="ارسال الرقم"
                                class="text-white font-medium text-[16px] leading-none tracking-[0.02em] bg-secondary py-[17px] px-[20px] mt-5 sm:mt-0 rounded-[10px] hover:bg-white hover:text-primary transition-all sm:absolute sm:right-[4px] sm:top-1/2 sm:-translate-y-1/2">ارسال
                                الرقم</button>
                        </form>
                        <!-- mailchimp-alerts Start -->
                        <div class="mailchimp-alerts text-centre">
                            <div class="mailchimp-submitting"></div><!-- mailchimp-submitting end -->
                            <div class="mailchimp-success text-green-400"></div><!-- mailchimp-success end -->
                            <div class="mailchimp-error text-red-600"></div><!-- mailchimp-error end -->
                        </div>
                        <!-- mailchimp-alerts end -->
                    </div>
                    <div class="w-full hidden lg:block lg:w-auto mt-5 lg:mt-0">
                        <div class="relative mt-10 md:mt-0 lg:absolute lg:left-0 lg:bottom-0">
                            <img class="hero_image lg:max-w-[550px] xl:max-w-[650px] 2xl:max-w-[714px]"
                                src="{{ asset("/assets/images/newsletter/bg-1.png") }}" width="866" height="879"
                                alt="hero image">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<footer class="footer bg-[#EEEEEE] fit-cover pt-[80px] pb-30 md:pb-[80px] font-normal bg-no-repeat"
    style="background-image: url({{ asset('assets/images/footer/pattern.png') }});">

    <div class="container">
        <div class="grid grid-cols-12 gap-x-[20px] mb-[-30px]">
            <div class="col-span-12 lg:col-span-3 mb-[30px]">
                <a href="{{ url("/") }}" class="block mb-[25px]">
                    <span class="text-xl font-semibold">{{ config('app.name') }}</span>
                </a>
                <p class="mb-[5px] xl:mb-[40px] max-w-[270px] text-gray-700">
                    مصادر الشمال العقارية - تسويق، إدارة أملاك، إدارة مرافق، استثمار
                </p>
                <p class="text-sm hidden md:block text-gray-600">&copy; {{ date('Y') }} {{ config('app.name') }} جميع الحقوق محفوظة
                </p>
            </div>

            @php
                $allItems = $menu->items ?? [];
                // Group items by their 'group' field
                $grouped = collect($allItems)->groupBy(function($item) {
                    return $item['group'] ?? 'default';
                });
            @endphp

            @foreach($grouped as $groupName => $items)
            @if($groupName !== 'default' && count($items) > 0)
            <div class="col-span-12 sm:col-span-6 lg:col-span-2 mb-[30px]">
                <h3 class="font-lora font-normal text-[22px] leading-[1.222] text-primary mb-[20px] lg:mb-[30px]">
                    {{ $groupName }}<span class="text-secondary"></span>
                </h3>
                <ul class="text-[16px] leading-none mb-[-20px]">
                    @foreach($items as $item)
                    @php
                        $href = $item['url'] ?? '#';
                        $isExternal = ($item['type'] ?? null) === 'external' || preg_match('#^https?://#', $href);
                        $itemTitle = $item['title'] ?? '';
                    @endphp
                    <li class="mb-[20px]">
                        <a @if(!$isExternal) wire:navigate @endif href="{{ $href }}" @if($isExternal) target="_blank" rel="noopener noreferrer" @endif
                            class="flex flex-row transition-all hover:text-secondary leading-[1.5rem] text-gray-700">
                            @if (!empty($item['icon']))
                            <x-icon name="{{ $item['icon'] }}" width="20" class="self-center ml-3" />
                            @endif
                            {{ $itemTitle }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
            @endforeach

            <p class="text-sm md:hidden mb-7 sm:mb-0 mt-[20px] text-gray-600 col-span-12">&copy; {{ date('Y') }} {{ config('app.name') }} جميع
                الحقوق محفوظة </p>
        </div>
    </div>
</footer>
@endif
