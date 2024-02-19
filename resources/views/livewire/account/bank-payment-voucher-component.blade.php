<div class="">
    <style>

    </style>



    <!-- Content Header (Page header) -->
    <section class="content-header ">
        <div class="container mx-auto">
            <div class="flex items-center gap-3 py-3 px-4  rounded-tr-lg rounded-tl-lg bg-[#00969B]">
                <img src="/voucher.svg" alt="" class="h-[25px]">

                <h1 class="breadcrumb-item text-sm text-white text-center  font-bold">Bank Payment Voucher</h1>
            </div>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container mx-auto">
            <div>
                @include('livewire.message.success')
                @include('livewire.message.error')
            </div>
            <div class="flex">
                @if ($viewStatus)
                    <div class="w-full bg-white">
                        <div class="card card-custom card-outline">
                            <div
                                class="card-header p-4 py-3 border-b border-gray-200 text-black bg-white font-semibold text-xs ">
                                <h3 class="card-title text-sm font-bold">
                                    Voucher Details
                                </h3>
                            </div>
                            <div class="card-body  table-responsive bg-white">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 p-4">
                                    <div class="col-span-4">
                                        <div class="form-group">
                                            @if ($errors->has('data.voucher_date'))
                                                <label class="col-form-label" for="inputError" class="text-red-500">
                                                    <i class="far fa-times-circle"></i>
                                                    {{ $errors->first('data.voucher_date') }}
                                                </label>
                                            @else
                                                <label for="voucher_date"
                                                    class="block text-xs font-medium text-[#4B465C] mb-1.5">Voucher
                                                    Date</label>
                                            @endif
                                            <input id="voucher_date" wire:model="data.voucher_date" type="date"
                                                class="{{ $errors->has('data.voucher_date') ? 'border-red-500' : '' }} form-input border-[#DBDADE] border rounded w-full p-2 py-2.5  text-[#040404] text-xs"
                                                id="inputError" placeholder="Enter your name">
                                        </div>
                                    </div>
                                    <div class="col-span-4">
                                        <div class="form-group">
                                            <label for="class"
                                                class="block text-xs font-medium text-[#4B465C] mb-1.5">Bank</label>
                                                <select id="class" wire:model="data.cheque_id"
                                                wire:change="getCheckbookSerial"
                                                class="form-select border-[#DBDADE] border rounded w-full p-2 py-2.5 text-[#040404] text-xs ">
                                            <option>Select Account</option>
                                            @foreach ($banks as $item)
                                                @if ($item->active == 1)
                                                    <option class="text-[10px]" value="{{ $item->id }}">
                                                        {{ $item->bank_name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>                                        

                                            @error('data.cheque_id')
                                                <span class="text-red-500">Field is required</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-span-4">
                                        <div class="form-group">
                                            <label for="class"
                                                class="block text-xs font-medium text-[#4B465C] mb-1.5">Cheque
                                                No</label>
                                            <select id="class" wire:model="data.cheque_no"
                                                class="form-select border-[#DBDADE] border rounded w-full p-2 py-2.5 text-[#040404]
                                        text-xs ">
                                                <option>Select Cheque no</option>
                                                @foreach ($checks as $item)
                                                    @if ($item)
                                                        <option class="text-[10px] " value="{{ $item }}">
                                                            {{ $item }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>

                                            @error('data.cheque_no')
                                                <span class="text-red-500">Field is required</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-span-6">
                                        <div class="form-group">
                                            <label for="class"
                                                class="block text-xs font-medium text-[#4B465C] mb-1.5">Credit Account
                                                Head</label>
                                            <div class="custom-select2" wire:ignore>
                                                <select wire:model="data.account_from" onchange="getAccountHeads()"
                                                    id="custom-select2"
                                                    class="js-example-basic-single w-full parttakeAccount">
                                                    <option value="0" selected>Select a Credit Account</option>
                                                    @foreach ($accounts as $item)
                                                        <option value="{{ $item->id }}" data-class="pl-6">

                                                            {{ $item->id }} - {{ $item->account_number }}
                                                            -{{ $item->title }} -
                                                            ({{ $item->subAccountGet() }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('data.account_from')
                                                <span class="text-red-500 mt-2 block">Field is required</span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-span-6">
                                        <div class="form-group">
                                            @if ($errors->has('data.credit_amount'))
                                                <label class="col-form-label" for="inputError" class="text-red-500">
                                                    <i class="far fa-times-circle"></i>
                                                    {{ $errors->first('data.credit_amount') }}
                                                </label>
                                            @else
                                                <label for="credit_amount"
                                                    class="block text-xs font-medium text-[#4B465C] mb-1.5">Credit
                                                    Account
                                                </label>
                                            @endif
                                            <input wire:blur='updateDebitAmount' id="credit_amount"
                                                wire:model.debounce.200ms="data.credit_amount" type="number"
                                                class="{{ $errors->has('data.credit_amount') ? 'border-red-500' : '' }} form-input border-[#DBDADE] border rounded w-full p-2 py-2.5  text-[#040404] text-xs"
                                                id="inputError" placeholder="Enter Amount" disabled>
                                        </div>
                                    </div>

                                </div>

                                <div
                                    class="p-4 py-3 border-b border-gray-200 text-black bg-white  font-semibold text-xs pt-0">
                                    <h2 class=" text-sm font-bold">Transaction Detail</h2>
                                </div>
                                <div class="grid grid-cols-2  gap-2 p-4 pb-2">

                                    <div class="">
                                        <div class="form-group">
                                            <label for="class"
                                                class="block text-xs font-medium text-[#4B465C] mb-1.5">Debit
                                                Account Head</label>
                                            <div class="custom-select" wire:ignore>
                                                <select onchange="getAccountId()" name="account_to" id="custom-select"
                                                    class="js-example-basic-single w-full sub-account resetdebit">
                                                    <option value="0" selected class="text-[#040404] text-xs ">
                                                        Select a Debit Account</option>
                                                </select>
                                            </div>
                                            @error('data.account_to')
                                                <span class="text-red-500 mt-2 block">Field is required</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="form-group">

                                            <label for="debit_amount"
                                                class="block text-xs font-medium text-[#4B465C] mb-1.5">Debit Account
                                            </label>

                                            <input id="debit_amount" wire:model="data.debit_amount" type="number"
                                                class="{{ $errors->has('data.debit_amount') ? 'border-red-500' : '' }} form-input border-[#DBDADE] border rounded w-full p-2 py-2.5 text-[#040404] text-xs "
                                                id="inputError" placeholder="Enter Debit Amount">
                                            @error('data.debit_amount')
                                                <span class="text-red-500">Field is required</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-1 gap-4 p-4 pt-0 ">

                                    <div class="">
                                        <div class="form-group">
                                            <label for="memo"
                                                class="block text-xs font-medium text-[#4B465C] mb-1.5">Narration</label>
                                            <textarea id="memo" wire:model="data.memo" type="text"
                                                class="{{ $errors->has('data.memo') ? 'border-red-500' : '' }} form-input border-[#DBDADE] border rounded w-full p-2 py-2.5 text-[#040404] text-xs  placeholder:text-black"
                                                id="inputError" placeholder="Enter Your Narration..">
                                                </textarea>
                                            @error('data.memo')
                                                <span class="text-red-500">Field is required</span>
                                            @enderror
                                        </div>
                                    </div>



                                </div>



                                @php $sum = 0; @endphp
                                @if ($totalAmount >= 0)
                                    <div class="flex items-end justify-end">
                                        <button wire:click="addDebit" type="submit"
                                            class="p-3 rounded text-xs font-semibold text-white  mt-0 m-4 mb-5 bg-[#00969B] hover:bg-[#005974]">

                                            <i class="fa fa-plus"></i>
                                            Add New Entry
                                        </button>

                                    </div>
                                @endif

                                <div class=" mx-4 overflow-x-auto ">
                                    <table class="table table-hover w-full whitespace-nowrap">
                                        <thead>
                                            <tr class="rounded">

                                                <th
                                                    class="text-start p-3 py-4 text-white  bg-[#00969B] rounded-tl-lg
                                                   font-semibold text-xs border-[#E5E7EB] border border-l-0 border-t-0">
                                                    Bank</th>
                                                <th
                                                    class="text-start p-3 py-4 text-white  bg-[#00969B] font-semibold text-xs border border-[#E5E7EB]">
                                                    Cheque</th>
                                                <th
                                                    class="text-start p-3 py-4 text-white  bg-[#00969B] font-semibold text-xs border border-[#E5E7EB]">
                                                    Account</th>
                                                <th
                                                    class="text-start  p-3 py-4 text-white  bg-[#00969B]  font-semibold text-xs border border-[#E5E7EB]">
                                                    Narration</th>
                                                <th
                                                    class="text-start  p-3 py-4 text-white  bg-[#00969B]  font-semibold text-xs border border-[#E5E7EB]">
                                                    Debit Amount</th>
                                                <th
                                                    class="text-start  p-3 py-4 text-white  bg-[#00969B]  font-semibold text-xs border rounded-tr-lg border-r-0 border-t-0 border-[#E5E7EB]">
                                                    Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($debit_amounts as $key => $debit)
                                                <tr class="{{ $key % 2 == 0 ? 'bg-white' : ' bg-[#f5f5f5]' }}">
                                                    @php
                                                        $chequeNo = App\Models\Checkbook::where('id', $debit['cheque_id'])->first();
                                                        $chart_of_account = App\Models\Account\ChartOfAccount::where('id', $debit['account_to'])->first();
                                                    @endphp
                                                    <td class="text-start p-3  font-semibold text-xs  border">
                                                        {{ $chequeNo->bank_name ?? null }}</td>
                                                    <td class="text-start p-3  font-semibold text-xs  border">
                                                        {{ $debit['cheque_no'] }}</td>
                                                    <td class="text-start p-3  font-semibold text-xs  border">
                                                        {{ $chart_of_account->title ?? '' }}
                                                        25{{ $chart_of_account->account_number ?? '' }}
                                                    </td>
                                                    <td class="border">
                                                        <div
                                                            class="text-start p-4 py-3 font-semibold text-xs flex items-start justify-between gap-1">
                                                            <div class="overflow-hidden"
                                                                style="max-width: 300px; white-space: nowrap; word-wrap: break-all;">
                                                                <span
                                                                    class="text-ellipsis white-nowrap overflow-hidden block max-w-[300px]">
                                                                    {{ $debit['memo'] }}
                                                                </span>
                                                            </div>
                                                            @if (strlen($debit['memo']) > 60)
                                                                <button
                                                                    class="read-more-button text-blue-500 text-xs whitespace-nowrap"
                                                                    onclick="showMore(this)">See
                                                                    More</button>
                                                                <button
                                                                    class="read-less-button text-blue-500 hidden whitespace-nowrap"
                                                                    onclick="showLess(this)">See
                                                                    Less</button>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="text-start p-3  font-semibold text-xs   border">
                                                        {{ $debit['debit_amount'] }}</td>
                                                    @php $sum += $debit['debit_amount'] @endphp
                                                    <td
                                                        class="text-start text-xs flex items-center gap-1 p-3  text-[#dc3545]  border border-l-0 border-b-0">
                                                        <img wire:click="deleteRecord({{ $key }})"
                                                            class="cursor-pointer h-3" src="/trash-03-1.svg"
                                                            alt=""> 
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <thead>
                                            <tr class="border-b">
                                                <th
                                                    class="text-start  p-3 py-4  font-semibold text-sm border border-r-0">
                                                </th>
                                                <th class="text-start  p-3 py-4  font-semibold text-sm ">
                                                </th>
                                                <th class="text-start  p-3 py-4  font-semibold text-sm ">
                                                </th>
                                                <th class=" text-start p-3 py-4 font-bold text-sm   ">
                                                    Total</th>

                                                <th class=" text-start p-3 py-4 font-bold text-sm ">
                                                    {{ $sum ?? 0 }}</th>
                                                <th
                                                    class=" text-start p-3 py-4  font-bold text-sm  border border-l-0 ">
                                                    {{-- Difference:
                                                    @if (isset($data['credit_amount']))
                                                        {{ (float) $data['credit_amount'] - $sum }}
                                                    @endif --}}
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                {{-- <div class="form-check p-4 py-3 border-b flex items-center gap-2">
                                    <input type="checkbox" wire:model="data.active" class="form-check-input rounded "
                                        id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Active</label>
                                </div> --}}
                                <div class="text-right">
                                    <button id="submitBtn" wire:loading.attr='disabled' wire:click="store"
                                        type="submit"
                                        class="p-3 rounded text-xs font-semibold text-white  m-3 my-5 bg-[#00969B] hover:bg-[#005974]">
                                        Create Voucher
                                        <div wire:loading wire:target="store" class="spinner-border spinner-border-sm"
                                            role="status">
                                        </div>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card body -->
                        </div>
                    </div>
                @else
                    <div class="w-full">
                        {{-- <livewire:table.admission-table /> --}}
                    </div>
                @endif
                <!-- /.col -->
            </div>
            <!-- ./row -->
        </div><!-- /.container -->
    </section>
    <!-- /.content -->


    <script>
        document.getElementById("submitBtn").addEventListener("click", function() {
            // Scroll the page to the top
            window.scrollTo(0, 0);
        });

        function getAccountHeads() {
            var inputElement = document.querySelector(".parttakeAccount").value;
            @this.data.account_from = inputElement;
            @this.getAccountHeads()
        }
    </script>
    <script>
        document.addEventListener('livewire:initialized', () => {

            @this.on('post-created', (event) => {
                const selectElements = document.querySelectorAll('.sub-account');
                // Loop through each select element and add options
                selectElements.forEach(selectElement => {
                    // Loop through the data array and create options
                    event.accountheads.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item
                            .id; // Set the value of the option to the item id
                        option.text =
                            `${item.id} - ${item.account_number} - ${item.title} - ${item.mainhead}`; // Set the text of the option
                        selectElement.appendChild(
                            option); // Append the option to the select element
                    });

                    // Initialize Select2 for the current select element
                    $(selectElement).select2();
                });
            });
            
            @this.on('resetData', (event) => {
                
                
                    $('#custom-select').val('0').trigger('change');
            
               
            });

             
            @this.on('resetForm', (event) => {
                
                
                $('#custom-select2').val('0').trigger('change');
        
           
        });

        });
        function getAccountId() {
            var inputElement = document.querySelector(".sub-account").value;
            @this.data.account_to = inputElement;
        }
    </script>
    <script>
        function showMore(button) {
            const div = button.parentNode;
            const hiddenText = div.querySelector('.overflow-hidden');
            const readMoreButton = div.querySelector('.read-more-button');
            const readLessButton = div.querySelector('.read-less-button');
            hiddenText.style.maxWidth = '400px'; // Set the maximum width to 400px
            hiddenText.style.whiteSpace = 'normal'; // Allow line breaks
            hiddenText.style.wordWrap = 'break-word'; // Break long words
            readMoreButton.style.display = 'none';
            readLessButton.style.display = 'inline';
        }

        function showLess(button) {
            const div = button.parentNode;
            const hiddenText = div.querySelector('.overflow-hidden');
            const readMoreButton = div.querySelector('.read-more-button');
            const readLessButton = div.querySelector('.read-less-button');
            hiddenText.style.maxWidth = '300px'; // Set the maximum width back to 300px
            hiddenText.style.whiteSpace = 'nowrap'; // Prevent line breaks
            hiddenText.style.wordWrap = 'break-all'; // Reset word-wrap
            readMoreButton.style.display = 'inline';
            readLessButton.style.display = 'none';
        }
    </script>
</div>
