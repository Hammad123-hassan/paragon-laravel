<div class="">



    <div class="shadow bg-white rounded-tr-lg rounded-tl-lg">
        <!-- Content Header (Page header) -->
        <section class="content-header ">
            <div class="flex items-center gap-3 py-3 px-4  rounded-tr-lg rounded-tl-lg bg-[#00969B]">
                <img src="/voucher.svg" alt="" class="h-[25px]">

                <h1 class="breadcrumb-item text-sm text-white text-center  font-bold">Trail</h1>
            </div>
        </section>
        <!-- Main content -->
        <section>

            <div>
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 p-4">
                    <div class="col-span-2">
                        <div class="form-group">


                            <label for="voucher_date" class="block text-xs font-medium text-[#4B465C] mb-1.5">
                                Date Start</label>

                            <input type="date" wire:model='date_from'
                                class="form-input border-[#DBDADE] border rounded w-full p-2 py-2.5  text-[#040404] text-xs"
                                placeholder="">
                        </div>
                    </div>
                    <div class="col-span-2">
                        <div class="form-group">


                            <label for="voucher_date" class="block text-xs font-medium text-[#4B465C] mb-1.5">
                                Date End</label>

                            <input wire:model='date_to' type="date"
                                class="form-input border-[#DBDADE] border rounded w-full p-2 py-2.5  text-[#040404] text-xs"
                                placeholder="">
                        </div>
                    </div>
                    <div class="col-span-4">
                        <div class="form-group">
                            <label for="class" class="block text-xs font-medium text-[#4B465C] mb-1.5">Account
                                Head</label>
                            <select id="class" wire:model.live='level'
                                class="form-select border-[#DBDADE] border rounded w-full p-2 py-2.5 text-[#040404] text-xs ">
                                <option>Select Hear</option>
                                <option value="1">Level 1</option>
                                <option value="2">Level 2</option>
                                <option value="3">Level 3</option>

                            </select>


                        </div>
                    </div>
                    {{-- <div class="col-span-4">
                        <div class="form-group">
                            <label for="class" class="block text-xs font-medium text-[#4B465C] mb-1.5">Division</label>
                            <select id="class"
                                class="form-select border-[#DBDADE] border rounded w-full p-2 py-2.5 text-[#040404] text-xs ">
                                <option>Select Account</option>
                            </select>
                        </div>
                    </div> --}}


                </div>
                <div class="flex items-end justify-end">
                    <button wire:click='getChartofAccount' type="submit"
                        class="p-3 rounded text-xs font-semibold text-white  mt-0 m-4 mb-4 bg-[#00969B] hover:bg-[#005974]">
                        Search
                    </button>

                </div>
            </div>
            <div class=" mx-4 overflow-x-auto pb-4">
                <table class="table table-hover w-full whitespace-nowrap">
                    <thead>
                        <tr class="rounded">

                            <th class=" p-3 py-4 text-white text-start  bg-[#00969B] rounded-tl-lg
                               font-bold text-sm border-[#E5E7EB] border border-l-0 border-t-0">
                                Gl Code</th>
                            <th
                                class="text-start p-3 py-4 text-white  bg-[#00969B] font-bold text-sm border border-[#E5E7EB]">
                                Account Title</th>


                            <th
                                class="text-center p-3 py-4 text-white  bg-[#00969B] font-bold text-sm border border-[#E5E7EB]">
                                Opening Balance</th>
                            <th
                                class="text-center p-3 py-4 text-white  bg-[#00969B]  font-bold text-sm border border-[#E5E7EB]">
                                Current Balance</th>
                            <th
                                class="text-center p-3 py-4 text-white  bg-[#00969B]  font-bold text-sm border border-[#E5E7EB]">
                                Closing Balance</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class=" p-3 py-4 font-semibold text-xs border">

                            </td>
                            <td class=" p-3 py-4 font-semibold text-xs border">

                            </td>

                            <td class=" font-semibold text-xs border">
                                <div class="flex">
                                    <div
                                        class="w-1/2 text-center  text-center p-3 py-4 font-bold text-sm border-r border-[#E5E7EB]  ">
                                        Debit</div>
                                    <div class="w-1/2 text-center font-bold   text-center p-3 py-4 text-sm ">Credit
                                    </div>
                                </div>
                            </td>
                            <td class=" font-semibold text-sm border">
                                <div class="flex">
                                    <div
                                        class="w-1/2 text-center  text-center p-3 py-4 font-bold  text-sm border-r border-[#E5E7EB]  ">
                                        Debit</div>
                                    <div class="w-1/2 text-center font-bold   text-center p-3 py-4 text-sm ">Credit
                                    </div>
                                </div>
                            </td>
                            <td class=" font-semibold text-sm border">
                                <div class="flex">
                                    <div
                                        class="w-1/2 text-center  text-center p-3 py-4 font-bold  text-sm border-r border-[#E5E7EB]  ">
                                        Debit</div>
                                    <div class="w-1/2 text-center font-bold   text-center p-3 py-4 text-sm ">Credit
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @php
                            $openingDebit = 0;
                            $openingCredit = 0;
                            $currentDebit = 0;
                            $currentCredit = 0;
                            $closingDebit = 0;
                            $closingCredit = 0;
                        @endphp
                       
                        @foreach ($mainAccounts as $levelOne)
                        <tr>
                            <td class=" p-3 py-4 font-semibold text-xs border">
                                {{ $levelOne->code }}
                            </td>
                            <td class=" p-3 py-4 font-semibold text-xs border">
                                {{ $levelOne->title }}
                            </td>

                            <td class="font-semibold text-xs border">
                                <div class="flex">
                                    <div
                                        class="w-1/2  text-center p-3 py-4  text-center font-semibold text-xs border-r border-[#E5E7EB]">
                                        @php
                                        $mainAccountAmout = $levelOne->mainHeadTrial([
                                        'mainId' => $levelOne->main_chart_of_account_id,
                                        'date_from' => $date_from,
                                        'date_to' => $date_to,
                                        ])
                                        @endphp
                                        {{  number_format($mainAccountAmout['openingDebit'], 2) }}
                                    </div>
                                    <div class="w-1/2 text-center p-3 py-4  text-center font-semibold text-xs ">
                                        {{ number_format($mainAccountAmout['openingCredit'], 2)}}
                                    
                                    </div>
                                </div>
                            </td>
                            <td class="font-semibold text-xs border">
                                <div class="flex">
                                    <div
                                        class="w-1/2  text-center p-3 py-4  text-center font-semibold text-xs border-r border-[#E5E7EB]">
                                     
                                        {{ number_format($mainAccountAmout['currentgDebit'], 2)}}
                                    </div>
                                    <div class="w-1/2 text-center p-3 py-4  text-center font-semibold text-xs ">
                                      
                                        {{ number_format($mainAccountAmout['currentCredit'], 2)}}
                                    </div>
                                </div>
                            </td>
                            <td class="font-semibold text-xs border">
                                <div class="flex">
                                    <div
                                        class="w-1/2  text-center p-3 py-4  text-center font-semibold text-xs border-r border-[#E5E7EB]">
                                       
                                        {{ number_format($mainAccountAmout['closingDebit'], 2)}}
                                    </div>
                                    <div class="w-1/2 text-center p-3 py-4  text-center font-semibold text-xs ">
                                      
                                        {{ number_format($mainAccountAmout['closingCredit'], 2)}}
                                    </div>
                                        @php 
                                            $openingDebit += $mainAccountAmout['openingDebit']; 
                                            $openingCredit += $mainAccountAmout['openingCredit']; 
                                            $currentDebit += $mainAccountAmout['currentgDebit']; 
                                            $currentCredit += $mainAccountAmout['currentCredit'];
                                            $closingDebit += $mainAccountAmout['closingDebit']; 
                                            $closingCredit += $mainAccountAmout['closingCredit']; 
                                        @endphp
                                </div>
                            </td>
                        </tr>
                      
                        @endforeach
                      
                        <!-- Add more rows as needed -->
                    </tbody>
                    <thead>
                        <tr class="border-b">
                            <th class="  p-3 py-4  font-semibold text-sm border border-r-0">
                            </th>

                            <th class="text-start  p-3 py-4 font-bold text-sm border border-r border-l-0 ">
                                Total
                            </th>
                            <td class="font-semibold text-xs ">
                                <div class="flex">
                                    <div
                                        class="w-1/2  text-center p-3  py-4 text-center font-bold text-sm border border-y-0 border-l-0">
                                        {{ number_format($openingDebit, 2)}}
                                    </div>
                                    <div
                                        class="w-1/2 text-center p-3  py-4 text-center font-bold text-sm border border-y-0 border-l-0  border-r-0">
                                        {{ number_format($openingCredit, 2)}}
                                    </div>
                                </div>
                            </td>
                            <td class="font-bold text-sm ">
                                <div class="flex">
                                    <div
                                        class="w-1/2  text-center p-3 py-4 text-center font-bold text-sm border border-y-0 ">
                                        {{ number_format($currentDebit, 2)}}</div>
                                    <div
                                        class="w-1/2 text-center p-3 py-4  text-center font-bold text-sm border border-y-0 border-l-0  border-r-0">
                                        {{ number_format($currentCredit, 2)}}</div>
                                </div>
                            </td>
                            <td class="font-bold text-sm  border border-y-0 border-l-0">
                                <div class="flex">
                                    <div
                                        class="w-1/2  text-center p-3 py-4 text-center font-bold text-sm  border border-y-0 border-r-0">
                                        {{ number_format($closingDebit, 2)}}</div>
                                    <div
                                        class="w-1/2 text-center p-3 py-4 text-center font-bold text-sm border border-y-0  border-r-0 ">
                                        {{ number_format($closingCredit, 2)}}</div>
                                </div>
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
        </section>
    </div>
</div>
