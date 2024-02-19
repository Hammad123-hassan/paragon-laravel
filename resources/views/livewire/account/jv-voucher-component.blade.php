<div class="">
    <!-- Content Header (Page header) -->
    <section class="content-header ">
        <div class="container mx-auto">
            <div class="flex items-center gap-3 py-3 px-4  rounded-tr-lg rounded-tl-lg bg-[#00969B]">
                <?xml version="1.0" encoding="UTF-8"?>
                <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" fill="#fff" data-name="Layer 1"
                    viewBox="0 0 24 24" width="25" height="25">
                    <path
                        d="M18.5,5h-.559c1.197-1.176,1.427-2.655,.51-3.878-.93-1.24-2.688-1.491-3.928-.561-1.652,1.239-2.327,3.389-2.523,4.439-.195-1.05-.845-3.2-2.497-4.439-1.24-.93-2.998-.678-3.928,.561-.917,1.222-.687,2.702,.51,3.878h-.585C2.467,5,0,7.468,0,10.5v8c0,3.032,2.467,5.5,5.5,5.5h13c3.033,0,5.5-2.468,5.5-5.5V10.5c0-3.032-2.467-5.5-5.5-5.5Zm0,16H5.5c-1.207,0-2.217-.86-2.45-2H20.95c-.232,1.14-1.242,2-2.45,2Zm2.5-5H3v-5.5c0-1.379,1.122-2.5,2.5-2.5h4.828c-.619,1.659-2.716,1.975-3.001,2.01-.82,.095-1.41,.835-1.318,1.656,.085,.767,.737,1.334,1.491,1.334,1.5,0,3.208-.744,4.5-2.102,1.292,1.358,3,2.102,4.5,2.102h.002c.754,0,1.404-.567,1.489-1.334,.092-.823-.502-1.565-1.325-1.657-.11-.012-2.351-.283-2.994-2.009h4.828c1.378,0,2.5,1.121,2.5,2.5v5.5Z" />
                </svg>



                <h1 class="breadcrumb-item text-sm text-white text-center  font-bold">JV Voucher</h1>
            </div>
        </div>
    </section>


    <!-- Main content -->
    <section class="content bg-white">
        <div class="container mx-auto">
            <div>
                @include('livewire.message.success')
                @include('livewire.message.error')
            </div>
            <div class="flex">
                @if ($viewStatus)
                    <div class="w-full">
                        <div class="card card-custom card-outline">
                            <div
                                class="card-header p-4 py-3 border-b border-gray-200 text-black bg-white font-semibold text-xs">
                                <h3 class="card-title  text-sm font-bold">
                                    Add JV Voucher
                                </h3>
                            </div>
                            <div class="card-body  table-responsive">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 p-4">
                                    <div class="col-span-3">
                                        <div class="form-group">
                                            @if ($errors->has('data.voucher_date'))
                                                <label class="col-form-label" for="inputError"><i
                                                        class="far fa-times-circle"></i>
                                                    {{ $errors->first('data.voucher_date') }}
                                                </label>
                                            @else
                                                <label
                                                    class="col-form-label block text-xs font-medium text-[#4B465C] mb-1.5"
                                                    for="voucher_date">Voucher Date</label>
                                            @endif
                                            <input id="voucher_date" wire:model="data.voucher_date" type="date"
                                                class="form-control border-[#DBDADE] border rounded w-full p-2 py-2.5 text-[#040404] text-xs  {{ $errors->has('data.voucher_date') ? 'is-invalid' : '' }}"
                                                id="inputError" placeholder="Enter your name">
                                        </div>
                                    </div>
                                    <div class="col-span-12">
                                        <div class="form-group">
                                            <label
                                                class="col-form-label block text-xs font-medium text-[#4B465C] mb-1.5"
                                                for="master_memo">Narration</label>
                                            <textarea id="master_memo" wire:model="data.master_memo" type="text"
                                                class="form-control border-[#DBDADE] border rounded w-full p-2 py-2.5 text-[#040404] placeholder:text-black text-xs {{ $errors->has('data.master_memo') ? 'is-invalid' : '' }}"
                                                id="inputError" placeholder="Enter Your Narration..">
                                            </textarea>
                                            @error('data.master_memo')
                                                <span class="text-red-500">Field is required</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="p-4 py-3 border-b border-gray-200 text-black bg-white  font-semibold text-xs pt-0">
                                    <h2 class="text-sm font-bold">Transaction Detail</h2>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 p-4">
                                    <div class="col-span-6">
                                        <div class="custom-select" wire:ignore>
                                            <label
                                                class="col-form-label block text-xs font-medium text-[#4B465C] mb-1.5"
                                                for="class">Account Heads</label>
                                            <select id="custom-select"
                                                class="sub-account form-control border-[#DBDADE] border rounded w-full p-2 py-2.5 text-[#040404] text-xs"
                                                wire:model="data.account_id">
                                                <option value="0">Select Account</option>
                                                @foreach ($accountheads as $item)
                                                    <option value="{{ $item->id }}">
                                                        {{ $item->id }}-{{ $item->account_number }}-{{ $item->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('data.account_id')
                                                <span class="text-red-500">Field is required</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-span-3">
                                        <div class="form-group">

                                            <label
                                                class="col-form-label  block text-xs font-medium text-[#4B465C] mb-1.5"
                                                for="debit_amount">Debit Amount</label>

                                            <input @if (isset($data['credit_amount']) > 0 && $data['credit_amount'] > 0) disabled @endif
                                                wire:keyup="resetCreditAmount()" id="debit_amount"
                                                wire:model.live="data.debit_amount" type="number"
                                                class="form-control border-[#DBDADE] border rounded w-full p-2 py-2.5 text-[#040404] text-xs {{ $errors->has('data.debit_amount') ? 'is-invalid' : '' }}"
                                                id="inputError" placeholder="Enter Amount">
                                            @error('data.debit_amount')
                                                <span class="text-red-500">Field is required</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-span-3">
                                        <div class="form-group">
                                            @if ($errors->has('data.credit_amount'))
                                                <label
                                                    class="col-form-label  block text-xs font-medium text-[#4B465C] mb-1.5"
                                                    for="inputError"><i class="far fa-times-circle"></i>
                                                    {{ $errors->first('data.credit_amount') }}
                                                </label>
                                            @else
                                                <label
                                                    class="col-form-label  block text-xs font-medium text-[#4B465C] mb-1.5"
                                                    for="credit_amount">Credit Amount</label>
                                            @endif
                                            <input @if (isset($data['debit_amount']) && $data['debit_amount'] > 0) disabled @endif id="credit_amount"
                                                wire:model.live="data.credit_amount" type="number"
                                                class=" border-[#DBDADE] border rounded w-full p-2 py-2.5 text-[#040404] text-xs
                                        {{ $errors->has('data.credit_amount') ? 'is-invalid' : '' }}"
                                                id="inputError" placeholder="Enter Credit amount">
                                        </div>
                                    </div>

                                </div>
                                <div class="mx-4">
                                    <div class="form-group">
                                        <label class="col-form-label  block text-xs font-medium text-[#4B465C] mb-1.5"
                                            for="memo">Narration</label>
                                        <textarea id="memo" wire:model="data.memo" type="text"
                                            class="form-control border-[#DBDADE] border rounded w-full p-2 py-2.5 text-[#040404] placeholder:text-black text-xs {{ $errors->has('data.memo') ? 'is-invalid' : '' }}"
                                            id="inputError" placeholder="Enter Your Narration..">
                                        </textarea>
                                        @error('data.memo')
                                            <span class="text-red-500">Field is required</span>
                                        @enderror
                                    </div>
                                </div>
                                @php
                                    $debitsum = 0;
                                    $creditsum = 0;
                                @endphp
                                @if ($totalAmount >= 0)
                                    <div class="flex items-end justify-end">
                                        <button wire:click="addDebit" type="submit"
                                            class="p-3 rounded text-xs font-semibold text-white  mt-4 m-4 mb-5 bg-[#00969B] hover:bg-[#005974]">
                                            <i class="fa fa-plus"></i>
                                            Add New Entry
                                        </button>
                                    </div>
                                @endif
                                <div class="mx-4 overflow-x-auto ">
                                    <table class="table table-hover   w-full whitespace-nowrap ">
                                        <thead>
                                            <tr class="">
                                                <th
                                                    class="text-start p-3 py-4 text-white  bg-[#00969B] rounded-tl-lg
                                                    font-semibold text-xs border-[#E5E7EB] border border-l-0 border-t-0">
                                                    Account</th>
                                                <th
                                                    class="text-start p-3 py-4 text-white  bg-[#00969B] font-semibold text-xs border border-[#E5E7EB]">
                                                    Narration</th>
                                                <th
                                                    class="text-start p-3 py-4 text-white  bg-[#00969B] font-semibold text-xs border border-[#E5E7EB]">
                                                    Debit Amount</th>
                                                <th
                                                    class="text-start p-3 py-4 text-white  bg-[#00969B] font-semibold text-xs border border-[#E5E7EB]">
                                                    Credit Amount</th>
                                                <th
                                                    class="text-start  p-3 py-4 text-white  bg-[#00969B]  font-semibold text-xs border rounded-tr-lg border-r-0 border-t-0 border-[#E5E7EB]">
                                                    Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($amounts as $key => $item)
                                                <tr class="{{ $key % 2 == 0 ? 'bg-white' : ' bg-[#f5f5f5]' }}">
                                                    @php $chart_of_account = App\Models\Account\ChartOfAccount::where('id', $item['account_id'])->first(); @endphp
                                                    <td class="text-start p-4 py-3 font-semibold text-xs  border">
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
                                                                    {{ $item['memo'] }}
                                                                </span>
                                                            </div>
                                                            @if (strlen($item['memo']) > 60)
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

                                                    <td class="text-start p-4 py-3 font-semibold text-xs   border">
                                                        {{ $item['debit_amount'] ?? 0 }}</td>
                                                    <td class="text-start p-4 py-3 font-semibold text-xs   border">
                                                        {{ $item['credit_amount'] ?? 0 }}</td>
                                                    @php
                                                        $creditsum += $item['credit_amount'];
                                                        $debitsum += floatval($item['debit_amount']);
                                                    @endphp
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
                                                    class="text-start p-3 py-4 font-bold text-sm border border-l border-r-0">
                                                </th>
                                                <th class="text-start p-3 py-4 font-bold text-sm">
                                                </th>
                                                <th class="text-start p-3 py-4 font-bold text-sm">
                                                    </th>

                                                <th class="text-start p-3 py-4 font-bold text-sm">
                                                   </th>
                                                <th class="text-start p-3 py-4 font-bold text-sm border border-l-0">
                                                    @if (isset($data['debit_amount']))
                                                        <b class=" text-start  font-bold text-sm">Total
                                                            Debit:</b> {{ $debitsum }}
                                                    @endif
                                                    <br>
                                                    <br>
                                                    @if (isset($data['credit_amount']))
                                                        <b class=" text-start  font-bold text-sm">Total
                                                            Credit:</b> {{ $creditsum }}
                                                    @endif
                                                    <br>
                                                    @if (isset($data['debit_amount']) && isset($data['credit_amount']))
                                                    <b class="text-start font-bold text-sm">
                                                        @if ($creditsum >= $debitsum)
                                                            Difference:
                                                        @else
                                                            Difference:
                                                        @endif
                                                    </b>
                                                    {{ abs($creditsum - $debitsum) }}
                                                @endif
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                {{-- <div class="form-check p-4 py-3 border-b flex items-center gap-2">
                                    <input type="checkbox" wire:model="data.active" class="form-check-input rounded"
                                        id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Active</label>
                                </div> --}}
                                <div class=" text-right">
                                    <button wire:loading.attr='disabled' wire:click="store" type="submit"
                                        class="p-3 rounded text-xs font-semibold text-white  mt-5 m-4 mb-5 bg-[#00969B] hover:bg-[#005974]">
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
                    <div class="col-span-12">
                        {{-- <livewire:table.admission-table /> --}}
                    </div>
                @endif
                <!-- /.col -->
            </div>
            <!-- ./row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <script>
        document.addEventListener('livewire:initialized', () => {
            // Initialize Select2 with the 'minimumResultsForSearch' option
            $('.sub-account').select2({
                minimumResultsForSearch: 0, // Set this value to 0 to always show the search input
            });

            // Listen for the 'select2:select' event
            $('.sub-account').on('select2:select', function(e) {
                // Handle the selection here
                console.log('Selection changed:', e.params.data);
                @this.set('data.account_id', e.params.data.id);
            });
            @this.on('resetData', (event) => {
                
                
                $('#custom-select').val('0').trigger('change');
        
           
        });

        });
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
