<div class="flex-wrap flex items-center px-5 py-3 sm:py-3 border-b border-gray-200 dark:border-dark-5">
    <div class="flex-wrap flex items-center dark:border-dark-5 overflow-x-auto overflow-y-hidden">
        <div class="breadcrumb mr-auto sm:flex justify-around">
            <a class="whitespace-nowrap text-left" href="">Money Transfer</a><i data-lucide="chevron-right"></i>
            <a class="whitespace-nowrap text-left" href="" class="">Configuration</a><i
                data-lucide="chevron-right"></i>
            <a class="whitespace-nowrap text-left" href="" class="breadcrumb--active"> @yield('title')</a>
        </div>
    </div>
    <div class="flex justify-end w-auto ml-auto">
        @yield('create-button')
    </div>
</div>
