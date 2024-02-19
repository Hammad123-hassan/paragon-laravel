<div class="">
    <!-- Content Header (Page header) -->
    <!-- Content Header (Page header) -->
    <section class="content-header ">
        <div class="container mx-auto">
            <div class="flex items-center gap-3 py-3 px-4  rounded-tr-lg rounded-tl-lg bg-[#00969B]">
                <img src="/receipt.svg" alt="img" class="h-[25px]">


                <h1 class="breadcrumb-item text-sm text-white text-center  font-bold">Bank Receipt Voucher</h1>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="bg-white">
        <div class="container mx-auto">
            <div>
                @include('livewire.message.success')
                @include('livewire.message.error')
            </div>
            <div class="">
                @if ($viewStatus)
                    <div class="">
                        <div class="card card-custom card-outline">
                            <div
                                class="card-header p-4 py-3 border-b border-gray-200 text-black bg-white font-semibold text-xs">
                                <h3 class="card-title  text-sm font-bold">
                                    Add Bank Receipt Voucher
                                </h3>
                            </div>
                            <div class="">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 p-4">
                                    <div class="col-span-3">
                                        <div class="form-group">

                                            <label class="block text-xs font-medium  text-[#4B465C] mb-1.5"
                                                for="voucher_date">Voucher Date</label>

                                            <input id="voucher_date" wire:model="data.voucher_date" type="date"
                                                class="form-control border-[#DBDADE] border rounded w-full p-2 py-2.5 text-[#040404] text-xs {{ $errors->has('data.voucher_date') ? 'is-invalid' : '' }}"
                                                id="inputError" placeholder="Enter your name">
                                            @error('data.voucher_date')
                                                <span class="text-red-500">Field is required</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-span-6">
                                        <div class="">

                                            <label
                                                class="col-form-label block text-xs text-[#4B465C] font-medium  mb-1.5"
                                                for="class">Debit Account Head</label>
                                            <div class="custom-select" wire:ignore>
                                                <select wire:model="data.account_from" onchange="getAccountHeads()"
                                                    id="custom-select"
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
                                        </div>
                                    </div>
                                    <div class="col-span-3">
                                        <div class="form-group">

                                            <label class="block text-xs font-medium  text-[#4B465C]  mb-1.5"
                                                for="debit_amount">Debit Account</label>

                                            <input  wire:blur='updateCreditAmount' id="debit_amount"
                                                wire:model.debounce.200ms="data.debit_amount" type="number"
                                                class="form-control border-[#DBDADE] border rounded w-full p-2 py-2.5 text-[#040404] text-xs {{ $errors->has('data.debit_amount') ? 'is-invalid' : '' }}"
                                                id="inputError" placeholder="Enter Amount" disabled>
                                            @error('data.debit_amount')
                                                <span class="text-red-500">Field is required</span>
                                            @enderror
                                        </div>
                                    </div>



                                </div>

                                <div
                                    class="p-4 py-3 border-b border-gray-200 text-black bg-white  font-semibold text-xs pt-0">
                                    <h2 class="text-sm font-bold">Transaction Detail</h2>
                                </div>
                                <div class="grid grid-cols-2  gap-2 p-4 pb-2">

                                    <div class="form-group">
                                        <label for="class"
                                            class="block text-xs font-medium text-[#4B465C]  mb-1.5">Credit
                                            Account Head</label>
                                        <div class="custom-select2" wire:ignore>
                                            <select onchange="getAccountId()" name="account_to" id="custom-select2"
                                                class="js-example-basic-single w-full sub-account">
                                                <option value="0" selected>Select a Credit Account</option>
                                            </select>
                                        </div>
                                        @error('data.account_to')
                                            <span class="text-red-500 block mt-3">Field is required</span>
                                        @enderror
                                    </div>


                                    <div class="">
                                        <div class="form-group">

                                            <label
                                                class="col-form-label block text-xs  text-[#4B465C] font-medium  mb-1.5"
                                                for="credit_amount">Credit Account </label>

                                            <input id="credit_amount" wire:model="data.credit_amount" type="number"
                                                class="form-control border-[#DBDADE] border rounded w-full p-2 py-2.5 text-[#040404] text-xs{{ $errors->has('data.credit_amount') ? 'is-invalid' : '' }}"
                                                id="inputError" placeholder="Enter Credit amount">
                                            @error('data.credit_amount')
                                                <span class="text-red-500 ">Field is required</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-1 gap-2 p-4 pt-0">


                                    <div class="">
                                        <div class="form-group">
                                            <label
                                                class="col-form-label block text-xs  text-[#4B465C] font-medium  mb-1.5"
                                                for="memo">Narration</label>
                                            <textarea id="memo" wire:model="data.memo" type="text"
                                                class="form-control border-[#DBDADE] border rounded w-full p-2 py-2.5 text-[#040404] placeholder:text-black text-xs placeholder:text-xs {{ $errors->has('data.memo') ? 'is-invalid' : '' }}"
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
                                <div class="px-4">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover text-nowrap  w-full">
                                                <thead>
                                                    <tr class=" ">
                                                        <th
                                                            class="text-start p-3 text-[#4B465C] font-semibold text-xs border">
                                                            Account</th>
                                                        <th
                                                            class="text-start p-3 text-[#4B465C] font-semibold text-xs border">
                                                            Narration</th>
                                                        <th
                                                            class="text-start p-3 text-[#4B465C] font-semibold text-xs border">
                                                            Credit Amount</th>
                                                        <th
                                                            class="text-start p-3 text-[#4B465C] font-semibold text-xs border">
                                                            Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($credit_amounts as $key => $credit_amount)
                                                        <tr
                                                            class="text-start p-4  py-3 font-semibold text-xs text-[#005974] border">
                                                            @php $chart_of_account = App\Models\Account\ChartOfAccount::where('id', $credit_amount['account_to'])->first(); @endphp
                                                            <td
                                                                class="text-start p-4  py-3 font-semibold text-xs text-[#005974] border">
                                                                {{ $chart_of_account->title ?? '' }}
                                                                25{{ $chart_of_account->account_number ?? '' }}
                                                            </td>
                                                            <td class="">
                                                                <div
                                                                    class="text-start p-4 py-3 font-semibold text-xs text-[#005974] flex items-start justify-between gap-1">
                                                                    <div class="overflow-hidden"
                                                                        style="max-width: 300px">
                                                                        <span
                                                                            class="text-ellipsis white-nowrap overflow-hidden block max-w-[300px]">
                                                                            {{ $credit_amount['memo'] }}
                                                                        </span>
                                                                    </div>
                                                                    {{-- <button
                                                                        class="read-more-button text-blue-500 text-xs whitespace-nowrap "
                                                                        onclick="showMore(this)">See More</button>
                                                                    <button
                                                                        class="read-less-button text-blue-500  hidden"
                                                                        onclick="showLess(this)">See Less</button> --}}
                                                                </div>
                                                            </td>


                                                            <td
                                                                class="text-start p-4  py-3 font-semibold text-xs text-[#005974] border">
                                                                {{ $credit_amount['credit_amount'] }}</td>
                                                            @php $sum += $credit_amount['credit_amount'] @endphp
                                                            <td class="text-start p-4  py-3 text-[#dc3545]">
                                                                <i wire:click="deleteRecord({{ $key }})"
                                                                    style="cursor: pointer;"
                                                                    class="fa fa-trash text-red-500"></i>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            
                                        </tbody>
                                        <thead>
                                            <tr class="border-b">
                                                <th
                                                    class=" text-start p-3 py-4 font-bold text-sm border border-l border-r-0">
                                                </th>
                                                <th class=" text-start p-3 py-4 font-bold text-sm   ">
                                                    Total</th>

                                                <th class=" text-start p-3 py-4 font-bold text-sm   ">
                                                    {{ $sum ?? 0 }}</th>
                                                <th class=" text-start p-3 py-4 font-bold text-sm   border border-l-0">
                                                    {{-- Difference:
                                                    @if (isset($data['debit_amount']))
                                                        {{ $data['debit_amount'] - $sum }}
                                                    @endif --}}
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="text-right">
                                    <button wire:loading.attr='disabled' wire:click="store" type="submit"
                                        class="p-3 rounded text-xs font-semibold text-white  m-3 my-5 bg-[#00969B] hover:bg-[#005974]">
                                        Create Voucher
                                        <div wire:loading wire:target="store" class="spinner-border spinner-border-sm"
                                            role="status">
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card body -->
                    </div>
            </div>
        @else
            <div class="col-span-12">
                {{-- <livewire:table.admission-table /> --}}
            </div>
            @endif
            <!-- /.col -->
        </div>
        <!-- ./row -->
        <!-- /.container-fluid -->
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
                
                
                $('#custom-select2').val('0').trigger('change');
        
           
        });

        @this.on('resetForm', (event) => {
                
                
                $('#custom-select').val('0').trigger('change');
        
           
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
